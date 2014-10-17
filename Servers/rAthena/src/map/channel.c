// (c) 2008 - 2011 eAmod Project; Andres Garbanzo / Zephyrus
//
//  - gaiaro.staff@yahoo.com
//  - MSN andresjgm.cr@hotmail.com
//  - Skype: Zephyrus_cr
//  - Site: http://dev.terra-gaming.com
//
// This file is NOT public - you are not allowed to distribute it.
// Authorized Server List : http://dev.terra-gaming.com/index.php?/topic/72-authorized-eamod-servers/
// eAmod is a non Free, extended version of eAthena Ragnarok Private Server.

#include "../common/malloc.h"
#include "../common/strlib.h"
#include "../common/nullpo.h"
#include "../common/showmsg.h"
#include "../common/utils.h"

#include "channel.h"
#include "atcommand.h"
#include "battle.h"
#include "clif.h"
#include "map.h"
#include "pc.h"

#include <string.h>
#include <stdio.h>
#include <stdlib.h>

struct channel_data *server_channel[CHN_USER];
static unsigned int channel_counter = 0; // Next channel_id
static int vendingbot_timer = 0; // Flood control
static DBMap* channel_db;

const unsigned long channel_color[] = // Forum Colors 0 to 38 = 39 Colors
								   { 0x8B0000, 0xFF0000, 0xFF00FF, 0xFFC0CB,
									 0xA0522D, 0xFF8C00, 0xF4A460, 0xFFA500, 0xF5DEB3,
									 0x556B2F, 0x808000, 0x9ACD32, 0xFFFF00, 0xFFFACD,
									 0x006400, 0x008000, 0x2E8B57, 0x00FF00, 0x98FB98,
									 0x483D8B, 0x008080, 0x48D1CC, 0x00FFFF, 0xAFEEEE,
									 0x000080, 0x0000FF, 0x4169E1, 0x00BFFF, 0xADD8E6,
									 0x4B0082, 0x708090, 0x800080, 0x9932CC, 0xDDA0DD,
									 0x2F4F4F, 0x696969, 0x808080, 0xC0C0C0, 0xFFFFFF };

int channel_slot_free(struct map_session_data *sd)
{
	int i;
	nullpo_retr(-1,sd);
	ARR_FIND(0, MAX_USER_CHANNELS, i, sd->cd[i] == NULL);
	return (i < MAX_USER_CHANNELS) ? i : -1;
}

int channel_slot_get(struct map_session_data *sd, struct channel_data *cd)
{
	int i;
	nullpo_retr(-1,sd);
	nullpo_retr(-1,cd);

	ARR_FIND(0, MAX_USER_CHANNELS, i, sd->cd[i] == cd);
	return (i < MAX_USER_CHANNELS) ? i : -1;
}

void channel_list(struct map_session_data *sd)
{ // Display a list of all channels
	char output[256];
	struct channel_data *cd;
	DBIterator* iter;
	DBKey key;

	iter = channel_db->iterator(channel_db);
	for( cd = (struct channel_data *)iter->first(iter,&key); iter->exists(iter); cd = (struct channel_data *)iter->next(iter,&key) )
	{
		if( cd->users < 1 && cd->type == CHN_USER )
			continue;

		sprintf(output, msg_txt(sd,812), cd->name, cd->users, !cd->pass[0] ? msg_txt(sd,813) : msg_txt(sd,814));
		clif_displaymessage(sd->fd, output);
	}
	iter->destroy(iter);
	return;
}

bool channel_create(struct map_session_data *sd, const char* name, const char* pass, short type, short color, int op)
{
	struct channel_data *cd;
	int i = 0;

	if( !name || strlen(name) < 2 || strlen(name) >= NAME_LENGTH || name[0] != '#' )
	{
		if( sd ) clif_displaymessage(sd->fd, msg_txt(sd,801));
		return false;
	}
	if( type == CHN_USER && !sd )
		return false; // Operator required for user channels
	if( sd && type == CHN_USER && (i = channel_slot_free(sd)) < 0 )
	{
		clif_displaymessage(sd->fd, msg_txt(sd,800));
		return false;
	}
	if( (cd = (struct channel_data *)strdb_get(channel_db, name)) != NULL )
	{
		if( sd ) clif_displaymessage(sd->fd, msg_txt(sd,802));
		return false; // Already exists
	}

	CREATE(cd, struct channel_data, 1);
	cd->channel_id = ++channel_counter;
	safestrncpy(cd->name, name, sizeof(cd->name));
	safestrncpy(cd->pass, pass, sizeof(cd->pass));
	cd->type = type;
	cd->color = channel_color[cap_value(color,0,38)];
	cd->users = 0;
	cd->op = 0;
	cd->users_db = idb_alloc(DB_OPT_BASE);

	if( type == CHN_USER )
	{
		char output[128];
		sprintf(output, msg_txt(sd,803), cd->name, sd->status.name);
		
		sd->cd[i] = cd;
		cd->op = sd->bl.id;
		idb_put(cd->users_db, sd->bl.id, sd);
		cd->users++;
		clif_channel_message(cd, output, -1);
	}
	else if( type < CHN_USER )
	{
		server_channel[type] = cd; // Quick access to main channels
		ShowInfo("Channel System : New channel %s created.\n", cd->name);
	}
	else
		cd->op = op; // Server Channel

	strdb_put(channel_db, cd->name, cd);
	return true;
}

void channel_close(struct channel_data *cd)
{
	int j;
	char output[128];
	struct map_session_data *pl_sd;
	DBIterator* iter;

	if( cd == NULL || cd->type != CHN_USER )
		return;
	
	sprintf(output, msg_txt(NULL,804), cd->name);
	clif_channel_message(cd, output, -1);

	iter = db_iterator(cd->users_db);
	for( pl_sd = (struct map_session_data *)dbi_first(iter); dbi_exists(iter); pl_sd = (struct map_session_data *)dbi_next(iter) )
	{
		idb_remove(cd->users_db, pl_sd->bl.id);
		ARR_FIND(0, MAX_USER_CHANNELS, j, pl_sd->cd[j] == cd);
		if( j == MAX_USER_CHANNELS )
			continue;
		
		pl_sd->cd[j] = NULL;
	}
	dbi_destroy(iter);
	
	db_destroy(cd->users_db);
	strdb_remove(channel_db, cd->name);
}

void channel_join(struct map_session_data *sd, const char* name, const char* pass, bool invite)
{
	char output[256];
	struct channel_data *cd;
	int i = 0;
	
	if( !name || strlen(name) < 2 || strlen(name) >= NAME_LENGTH || name[0] != '#' )
	{
		clif_displaymessage(sd->fd, msg_txt(sd,801));
		return;
	}

	if( (cd = (struct channel_data *)strdb_get(channel_db, name)) == NULL )
	{
		clif_displaymessage(sd->fd, msg_txt(sd,805));
		return;
	}

	if( channel_slot_get(sd, cd) != -1 )
	{
		clif_displaymessage(sd->fd, msg_txt(sd,806));
		return;
	}

	if( (i = channel_slot_free(sd)) < 0 )
	{
		clif_displaymessage(sd->fd, msg_txt(sd,800));
		return;
	}

	if( !invite )
	{
		if( cd->pass[0] && strcmp(cd->pass, pass) != 0 )
		{ // Check password only if not invited
			clif_displaymessage(sd->fd, msg_txt(sd,808));
			return;
		}
		if( cd->type == CHN_GAMEMASTER && pc_has_permission(sd,PC_PERM_CHANNEL_ADMIN) )
		{
			clif_displaymessage(sd->fd, msg_txt(sd,753));
			return;
		}
	}

	if( battle_config.channel_announce_join )
	{
		sprintf(output, msg_txt(sd,803), cd->name, sd->status.name);
		clif_channel_message(cd, output, -1);
	}

	sprintf(output, msg_txt(sd,760), sd->status.name, cd->name);
	clif_wis_message(sd->fd, cd->name, output, strlen(output) + 1);

	// Joining Channel
	sd->cd[i] = cd;
	sd->canjoinchn_tick = gettick() + 10000;
	idb_put(cd->users_db, sd->bl.id, sd);
	cd->users++;

	if( sd->channel_invite_timer != INVALID_TIMER )
	{
		const struct TimerData * td = get_timer(sd->channel_invite_timer);
		char *name = td ? (char *)td->data : NULL;

		if( strcmp(name, cd->name) == 0 )
			channel_invite_clear(sd); // Invitation removed as the user joined the channel
	}

	if( cd->type != CHN_USER )
	{
		switch( cd->type )
		{
			case CHN_MAIN: sd->channels |= 1; break;
			case CHN_VENDING: sd->channels |= 2; break;
			case CHN_BATTLEGROUND: sd->channels |= 4; break;
			case CHN_GAMEMASTER: sd->channels |= 8; break;
		}
		pc_setaccountreg(sd, "#CHANNEL_CONF", sd->channels);
	}
}

void channel_leave(struct map_session_data *sd, const char* name, bool msg)
{
	struct channel_data *cd;
	char output[128];
	int i;

	if( (cd = (struct channel_data *)strdb_get(channel_db, name)) == NULL )
		return;
	if( (i = channel_slot_get(sd, cd)) != -1 )
	{
		sd->cd[i] = NULL;
		clif_displaymessage(sd->fd, msg_txt(sd,809));
		if( cd->type != CHN_USER && msg )
		{
			switch( cd->type )
			{
				case CHN_MAIN: sd->channels &= ~1; break;
				case CHN_VENDING: sd->channels &= ~2; break;
				case CHN_BATTLEGROUND: sd->channels &= ~4; break;
				case CHN_GAMEMASTER: sd->channels &= ~8; break;
			}
			pc_setaccountreg(sd, "#CHANNEL_CONF", sd->channels);
		}
	}

	if( idb_get(cd->users_db, sd->bl.id) != NULL )
	{
		idb_remove(cd->users_db, sd->bl.id);
		cd->users--;
		if( msg )
		{
			sprintf(output, msg_txt(sd,810), cd->name, sd->status.name);
			clif_channel_message(cd, output, -1);
		}
	}

	if( cd->type != CHN_USER )
		return;

	if( cd->users < 1 )
	{ // No more users in the channel
		channel_close(cd);
		return;
	}

	if( sd->bl.id == cd->op )
	{ // Select another Operator
		struct map_session_data *pl_sd;
		DBIterator* iter = db_iterator(cd->users_db);

		cd->op = 0;
		if( (pl_sd = (struct map_session_data *)dbi_first(iter)) != NULL && dbi_exists(iter) )
		{
			cd->op = pl_sd->bl.id;
			sprintf(output, msg_txt(sd,811), cd->name, pl_sd->status.name);
			clif_channel_message(cd, output, -1);
		}
		dbi_destroy(iter);
	}

	if( cd->users <= 0 )
	{
		ShowWarning("Channel '%s' with no users reporting %d users. Destroying it!!.\n", cd->name, cd->users);
		channel_close(cd);
	}
}

int channel_invite_timer(int tid, unsigned int tick, int id, intptr_t data)
{
	struct channel_data *cd;
	struct map_session_data* sd = map_id2sd(id);
	char output[CHAT_SIZE_MAX];
	char *name = (char *)data;

	if( sd && (cd = (struct channel_data *)strdb_get(channel_db, name)) != NULL )
	{
		sprintf(output, msg_txt(sd,751), cd->name, sd->status.name);
		clif_channel_message(cd, output, -1);
	}

	if( sd )
	{
		clif_disp_onlyself(sd, msg_txt(sd,752), strlen(msg_txt(sd,752)));
		sd->channel_invite_timer = INVALID_TIMER;
	}

	if( name ) aFree(name);
	return 1;
}

void channel_invite_clear(struct map_session_data *sd)
{
	if( sd && sd->channel_invite_timer != INVALID_TIMER )
	{
		const struct TimerData * td = get_timer(sd->channel_invite_timer);
		char *name = td ? (char *)td->data : NULL;

		delete_timer(sd->channel_invite_timer, channel_invite_timer);
		sd->channel_invite_timer = INVALID_TIMER;
		if( name ) aFree(name);
	}
}

int channel_invite_accept(struct map_session_data *sd)
{
	struct channel_data *cd;
	const struct TimerData * td;
	char output[CHAT_SIZE_MAX];
	char *name = NULL;

	if( sd == NULL || sd->channel_invite_timer == INVALID_TIMER )
		return 0;

	if( (td = get_timer(sd->channel_invite_timer)) == NULL )
	{
		sd->channel_invite_timer = INVALID_TIMER;
		return 0; // Error
	}

	name = (char *)td->data;

	if( (cd = (struct channel_data *)strdb_get(channel_db, name)) == NULL )
	{
		sprintf(output, msg_txt(sd,899), name);
		clif_displaymessage(sd->fd, output);
		channel_invite_clear(sd);
	}
	else
	{
		channel_invite_clear(sd);
		channel_join(sd, cd->name, cd->pass, true);
	}

	return 1;
}

void channel_message(struct map_session_data *sd, const char* channel, const char* message)
{
	struct channel_data *cd;
	char output[CHAT_SIZE_MAX];
	struct map_session_data *p_sd;

	if( !sd || !message || !*message || strlen(message) < 1 )
		return;

	if( (cd = (struct channel_data *)strdb_get(channel_db, channel)) == NULL )
	{
		clif_displaymessage(sd->fd, msg_txt(sd,805));
		clif_displaymessage(sd->fd, msg_txt(sd,815));
		return;
	}

	if( channel_slot_get(sd,cd) < 0 )
	{
		clif_displaymessage(sd->fd, msg_txt(sd,816));
		return;
	}

	if( message[0] == '|' && strlen(message) >= 4 && message[3] == '.' )
		message += 3;

	if( message[0] == '.' )
	{ // Channel commands
		size_t len = strlen(message);
		char* option_text;

		if( !strncasecmp(message, ".item ", 6) && len > 0 && cd->type == CHN_VENDING && server_channel[CHN_VENDING] && vendingbot_timer < gettick() )
		{
			struct map_session_data *pl_sd, *b_sd[MAX_SEARCH];
			struct s_mapiterator* iter;
			struct item_data *item_array[MAX_SEARCH];
			int total[MAX_SEARCH], amount[MAX_SEARCH];
			unsigned int MinPrice[MAX_SEARCH], MaxPrice[MAX_SEARCH];
			int i, j, count = 1;

			option_text = (char *)message + 6;

			if( (item_array[0] = itemdb_exists(atoi(option_text))) == NULL )
				count = itemdb_searchname_array(item_array, MAX_SEARCH, option_text);

			if( count < 1 )
			{
				clif_displaymessage(sd->fd, msg_txt(sd,19));
				return;
			}

			if( count > MAX_SEARCH ) count = MAX_SEARCH;
			for( i = 0; i < MAX_SEARCH; i++ )
			{
				total[i] = amount[i] = MaxPrice[i] = 0;
				MinPrice[i] = battle_config.vending_max_value + 1;
				b_sd[i] = NULL;
			}

			iter = mapit_getallusers();
			for( pl_sd = (TBL_PC*)mapit_first(iter); mapit_exists(iter); pl_sd = (TBL_PC*)mapit_next(iter) )
			{
				if( !pl_sd->vender_id )
					continue;

				for( i = 0; i < pl_sd->vend_num; i++ )
				{ // Searching in the Vending List
					for( j = 0; j < count; j++ )
					{ // Compares with each search result
						if( pl_sd->status.cart[pl_sd->vending[i].index].nameid != item_array[j]->nameid )
							continue;

						amount[j] += pl_sd->vending[i].amount;
						total[j]++;

						if( pl_sd->vending[i].value < MinPrice[j] )
						{ // Best Price
							MinPrice[j] = pl_sd->vending[i].value;
							b_sd[j] = pl_sd;
						}
						if( pl_sd->vending[i].value > MaxPrice[j] )
							MaxPrice[j] = pl_sd->vending[i].value;
					}
				}
			}
			mapit_free(iter);

			for( i = 0; i < count; i++ )
			{
				if( total[i] > 0 && b_sd[i] != NULL )
				{
					sprintf(output, msg_txt(sd,829), server_channel[CHN_VENDING]->name, item_array[i]->jname, MinPrice[i], b_sd[i]->status.name, map[b_sd[i]->bl.m].name, b_sd[i]->bl.x, b_sd[i]->bl.y, MaxPrice[i], total[i], amount[i]);
					clif_channel_message(cd, output, -1);
				}
			}
			vendingbot_timer = gettick() + 5000; // 5 Seconds Protection from flood
		}
		else if( !strncasecmp(message, ".exit", 5) )
			channel_leave(sd, cd->name, true);
		else if( cd->op != sd->bl.id && pc_has_permission(sd,PC_PERM_CHANNEL_ADMIN) )
			return;
		else if( !strncasecmp(message, ".invite ", 8) && len > 11 )
		{ // Invite a User to the Channel
			option_text = (char *)message + 8;
			if( (p_sd = map_nick2sd(option_text)) == NULL )
				clif_displaymessage(sd->fd, msg_txt(sd,893));
			else if( p_sd == sd )
				clif_displaymessage(sd->fd, msg_txt(sd,894));
			else if( p_sd->state.noask )
				clif_displaymessage(sd->fd, msg_txt(sd,750));
			else if( channel_slot_get(p_sd, cd) >= 0 )
				clif_displaymessage(sd->fd, msg_txt(sd,895));
			else if( p_sd->channel_invite_timer != INVALID_TIMER )
				clif_displaymessage(sd->fd, msg_txt(sd,897));
			else
			{
				sprintf(output, msg_txt(sd,896), cd->name, sd->status.name, p_sd->status.name);
				clif_channel_message(cd, output, -1); // Notify about the invitation to the Channel

				sprintf(output, msg_txt(sd,898), sd->status.name, cd->name);
				clif_disp_onlyself(p_sd, output, strlen(output)); // Notify Player

				p_sd->channel_invite_timer = add_timer(gettick() + 30000, channel_invite_timer, p_sd->bl.id, (intptr_t)aStrdup(cd->name));
			}
		}
		else if( !strncasecmp(message, ".kick ", 6) && len > 9 )
		{ // Kick Users
			option_text = (char *)message + 6;
			if( (p_sd = map_nick2sd(option_text)) == NULL || channel_slot_get(p_sd, cd) < 0 )
				clif_displaymessage(sd->fd, msg_txt(sd,817));
			else if( p_sd == sd )
				clif_displaymessage(sd->fd, msg_txt(sd,818));
			else
			{
				channel_leave(p_sd, cd->name, false);
				sprintf(output, msg_txt(sd,819), cd->name, p_sd->status.name);
				clif_channel_message(cd, output, -1);
				p_sd->canjoinchn_tick = gettick() + 10000;
			}
		}
		else if( !strncasecmp(message, ".color ", 7) && len > 7 )
		{ // Set Chat Room Color
			short color = atoi(message + 7);
			if( color < 1 || color > 39 )
				clif_displaymessage(sd->fd, msg_txt(sd,830));
			else
			{
				cd->color = channel_color[color - 1];
				sprintf(output, msg_txt(sd,831), cd->name);
				clif_channel_message(cd, output, -1);
			}
		}
		else if( !strncasecmp(message, ".op ", 4) && len > 7 )
		{
			option_text = (char *)message + 4;
			if( cd->type != CHN_USER )
				clif_displaymessage(sd->fd, msg_txt(sd,875));
			else if( (p_sd = map_nick2sd(option_text)) == NULL || channel_slot_get(p_sd, cd) < 0 )
				clif_displaymessage(sd->fd, msg_txt(sd,817));
			else if( p_sd == sd )
				clif_displaymessage(sd->fd, msg_txt(sd,832));
			else
			{
				cd->op = p_sd->bl.id;
				sprintf(output, msg_txt(sd,833), cd->name, p_sd->status.name);
				clif_channel_message(cd, output, -1);
			}
		}
		else if( !strncasecmp(message, ".pass ", 6) && len > 6 )
		{
			option_text = trim((char *)message + 6);
			if( cd->type != CHN_USER )
				clif_displaymessage(sd->fd, msg_txt(sd,875));
			else if( !strcmpi(option_text, "off") )
			{
				memset(cd->pass, '\0', sizeof(cd->pass));
				sprintf(output, msg_txt(sd,834), cd->name);
				clif_channel_message(cd, output, -1);
			}
			else if( strlen(option_text) > 1 && strlen(option_text) < NAME_LENGTH )
			{
				safestrncpy(cd->pass, option_text, sizeof(cd->pass));
				sprintf(output, msg_txt(sd,835), cd->name);
				clif_channel_message(cd, output, -1);
			}
			else
				clif_displaymessage(sd->fd, msg_txt(sd,836));
		}
		else if( !strncasecmp(message, ".close", 6) )
		{
			if( cd->type != CHN_USER )
				clif_displaymessage(sd->fd, msg_txt(sd,875));
			else
				channel_close(cd);
		}
		else if( !strncasecmp(message, ".list", 6) )
		{
			DBIterator* iter = db_iterator(cd->users_db);
			clif_displaymessage(sd->fd, msg_txt(sd,837));
			for( p_sd = (struct map_session_data *)dbi_first(iter); dbi_exists(iter); p_sd = (struct map_session_data *)dbi_next(iter) )
				clif_displaymessage(sd->fd, p_sd->status.name);
			dbi_destroy(iter);
			clif_displaymessage(sd->fd, msg_txt(sd,838));
		}
		else if( !strncasecmp(message, ".help", 5) )
		{ // Command List
			clif_displaymessage(sd->fd, msg_txt(sd,839));
			clif_displaymessage(sd->fd, msg_txt(sd,840));
			clif_displaymessage(sd->fd, msg_txt(sd,841));
			clif_displaymessage(sd->fd, msg_txt(sd,842));
			clif_displaymessage(sd->fd, msg_txt(sd,843));
			clif_displaymessage(sd->fd, msg_txt(sd,844));
			clif_displaymessage(sd->fd, msg_txt(sd,845));
			clif_displaymessage(sd->fd, msg_txt(sd,846));
		}
		else
			clif_displaymessage(sd->fd, msg_txt(sd,847));

		return;
	}

	snprintf(output, sizeof(output), "%s : [%s] %s", cd->name, sd->status.name, message);
	clif_channel_message(cd, output, -1);
}

static int channel_db_final(DBKey key, DBData *data, va_list ap)
{
	struct channel_data *cd = (struct channel_data *)db_data2ptr(data);
	ShowInfo("Channel System : Removing Channel %s from memory.\n", cd->name);
	db_destroy(cd->users_db);
	return 0;
}

/*==========================================
 * Reads channels
 *------------------------------------------*/
static bool channel_read_channeldb(char* str[], int columns, int current)
{// <channel name>,<password>,<type>,<color>,<operator id>
	int type, color, op;
	struct channel_data *cd;

	type = atoi(str[2]);
	color = atoi(str[3]);
	op = atoi(str[4]);

	if( type < 0 || type > CHN_SERVER || (type < CHN_USER && server_channel[type]) )
	{
		ShowWarning("channel_read_channeldb: Invalid channel type or type already in use (channel %s type %d).\n", str[0], type);
		return false;
	}

	if( (cd = (struct channel_data *)strdb_get(channel_db, str[0])) != NULL )
	{
		ShowWarning("channel_read_channeldb: Channel %s already exists.\n", str[0]);
		return false;
	}

	if( !channel_create(NULL, str[0], str[1], type, color, op) )
	{
		ShowWarning("channel_read_channeldb: Failed to create Channel %s.\n", str[0]);
		return false;
	}

	return true;
}

void do_init_channel(void)
{
	channel_db = strdb_alloc(DB_OPT_RELEASE_DATA, NAME_LENGTH);
	memset(server_channel, 0, sizeof(server_channel));
	sv_readdb(db_path, "channel_db.txt", ',', 5, 5, -1, &channel_read_channeldb, false);
}

void do_final_channel(void)
{
	channel_db->destroy(channel_db, channel_db_final);
}