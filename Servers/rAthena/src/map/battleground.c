// Copyright (c) Athena Dev Teams - Licensed under GNU GPL
// For more information, see LICENCE in the main folder

#include "../common/cbasetypes.h"
#include "../common/timer.h"
#include "../common/malloc.h"
#include "../common/nullpo.h"
#include "../common/showmsg.h"
#include "../common/socket.h"
#include "../common/strlib.h"
#include "../common/utils.h"

#include "battleground.h"
#include "battle.h"
#include "clif.h"
#include "map.h"
#include "npc.h"
#include "pc.h"
#include "pet.h"
#include "homunculus.h"
#include "mercenary.h"
#include "elemental.h"
#include "party.h"
#include "log.h"
#include "quest.h"
#include "skill.h"
#include "achievement.h"

#include <string.h>
#include <stdio.h>

static DBMap* bg_team_db; // int bg_id -> struct battleground_data*
static unsigned int bg_team_counter = 0; // Next bg_id
struct guild bg_guild[13]; // Temporal fake guild information
const unsigned int bg_colors[13] = { 0x0000FF, 0xFF0000, 0x00FF00, 0xFFFFFF, 0xFFFFFF, 0xFFFFFF, 0xFFFFFF, 0xFFFFFF, 0xFFFFFF, 0xFFFFFF, 0xFFFFFF, 0xFFFFFF, 0xFFFFFF };

static unsigned int queue_counter = 0; // Next q_id
static DBMap* queue_db;

#define BLUE_SKULL 8965
#define RED_SKULL 8966
#define GREEN_SKULL 8967

int bg_member_removeskulls(struct map_session_data *sd)
{
	int n;
	nullpo_ret(sd);
	if( (n = pc_search_inventory(sd,BLUE_SKULL)) >= 0 )
		pc_delitem(sd,n,sd->status.inventory[n].amount,0,2,LOG_TYPE_CONSUME);
	if( (n = pc_search_inventory(sd,RED_SKULL)) >= 0 )
		pc_delitem(sd,n,sd->status.inventory[n].amount,0,2,LOG_TYPE_CONSUME);
	if( (n = pc_search_inventory(sd,GREEN_SKULL)) >= 0 )
		pc_delitem(sd,n,sd->status.inventory[n].amount,0,2,LOG_TYPE_CONSUME);

	return 1;
}

int battleground_countlogin(struct map_session_data *sd, bool check_bat_room)
{
	int c = 0, m = map_mapname2mapid("bat_room");
	struct map_session_data* pl_sd;
	struct s_mapiterator* iter;
	nullpo_ret(sd);

	iter = mapit_getallusers();
	for( pl_sd = (TBL_PC*)mapit_first(iter); mapit_exists(iter); pl_sd = (TBL_PC*)mapit_next(iter) )
	{
		if( !(pl_sd->qd || map[pl_sd->bl.m].flag.battleground || (check_bat_room && pl_sd->bl.m == m)) )
			continue;
		if( session[sd->fd]->client_addr == session[pl_sd->fd]->client_addr )
			c++;
	}
	mapit_free(iter);
	return c;
}

int bg_checkskill(struct battleground_data *bg, int id)
{
	int idx = id - GD_SKILLBASE;
	if( idx < 0 || idx >= MAX_GUILDSKILL || !bg->g )
		return 0;
	return bg->g->skill[idx].lv;
}

int bg_block_skill_end(int tid, unsigned int tick, int id, intptr_t data)
{
	struct battleground_data *bg;
	char output[128];
	int idx = battle_config.guild_skills_separed_delay ? (int)data - GD_SKILLBASE : 0;

	if( (bg = bg_team_search(id)) == NULL )
		return 1;

	if( idx < 0 || idx >= MAX_GUILDSKILL )
	{
		ShowError("bg_block_skill_end invalid skillnum %d.\n", (int)data);
		return 0;
	}

	if( tid != bg->skill_block_timer[idx] )
	{
		ShowError("bg_block_skill_end %d != %d.\n", bg->skill_block_timer[idx], tid);
		return 0;
	}

	sprintf(output, "%s : Guild Skill %s Ready!!", bg->g->name, skill_get_desc((int)data));
	clif_bg_message(bg, bg->bg_id, bg->g->name, output, strlen(output) + 1);
	bg->skill_block_timer[idx] = INVALID_TIMER;

	return 1;
}

void bg_block_skill_status(struct battleground_data *bg, int skillnum)
{
	const struct TimerData * td;
	char output[128];
	int seconds, idx;

	idx = battle_config.guild_skills_separed_delay ? skillnum - GD_SKILLBASE : 0;
	if( bg == NULL || bg->g == NULL || idx < 0 || idx >= MAX_GUILDSKILL || bg->skill_block_timer[idx] == INVALID_TIMER )
		return;

	if( (td = get_timer(bg->skill_block_timer[idx])) == NULL )
		return;

	seconds = DIFF_TICK(td->tick,gettick())/1000;
	sprintf(output, "%s : Cannot use team skill %s. %d seconds remaining...", bg->g->name, skill_get_desc(skillnum), seconds);
	clif_bg_message(bg, bg->bg_id, bg->g->name, output, strlen(output) + 1);
}

void bg_block_skill_start(struct battleground_data *bg, int skillnum, int time)
{
	int idx = battle_config.guild_skills_separed_delay ? skillnum - GD_SKILLBASE : 0;
	if( bg == NULL || idx < 0 || idx >= MAX_GUILDSKILL )
		return;

	if( bg->skill_block_timer[idx] != INVALID_TIMER )
		delete_timer(bg->skill_block_timer[idx], bg_block_skill_end);

	bg->skill_block_timer[idx] = add_timer(gettick() + time, bg_block_skill_end, bg->bg_id, skillnum);
}

struct battleground_data* bg_team_search(int bg_id)
{ // Search a BG Team using bg_id
	if( !bg_id ) return NULL;
	return (struct battleground_data *)idb_get(bg_team_db, bg_id);
}

struct map_session_data* bg_getavailablesd(struct battleground_data *bg)
{
	int i;
	nullpo_retr(NULL, bg);
	ARR_FIND(0, MAX_BG_MEMBERS, i, bg->members[i].sd != NULL);
	return( i < MAX_BG_MEMBERS ) ? bg->members[i].sd : NULL;
}

int bg_team_clean(int bg_id, bool remove)
{ // Deletes BG Team from db
	int i;
	struct map_session_data *sd;
	struct battleground_data *bg = bg_team_search(bg_id);
	struct guild *g;

	if( bg == NULL ) return 0;
	for( i = 0; i < MAX_BG_MEMBERS; i++ )
	{
		if( (sd = bg->members[i].sd) == NULL )
			continue;

		bg_send_dot_remove(sd);
		sd->bg_id = 0;
		sd->state.bg_afk = 0;
		sd->bmaster_flag = NULL;
		bg_member_removeskulls(sd);

		// Remove Guild Skill Buffs
		status_change_end(&sd->bl,SC_GUILDAURA,INVALID_TIMER);
		status_change_end(&sd->bl,SC_BATTLEORDERS,INVALID_TIMER);
		status_change_end(&sd->bl,SC_REGENERATION,INVALID_TIMER);

		if( !battle_config.bg_eAmod_mode )
			continue; // No need to touch Guild stuff

		if( sd->status.guild_id && (g = guild_search(sd->status.guild_id)) != NULL )
		{
			clif_guild_belonginfo(sd,g);
			clif_guild_basicinfo(sd);
			clif_guild_allianceinfo(sd);
			clif_guild_memberlist(sd);
			clif_guild_skillinfo(sd);
		}
		else
			clif_bg_leave_single(sd, sd->status.name, "Leaving Battleground...");

		clif_charnameupdate(sd);
		clif_guild_emblem_area(&sd->bl);
	}

	for( i = 0; i < MAX_GUILDSKILL; i++ )
	{
		if( bg->skill_block_timer[i] == INVALID_TIMER )
			continue;
		delete_timer(bg->skill_block_timer[i], bg_block_skill_end);
	}

	if( remove )
		idb_remove(bg_team_db, bg_id);
	else
	{
		bg->count = 0;
		bg->leader_char_id = 0;
		bg->team_score = 0;
		bg->creation_tick = 0;
		memset(&bg->members, 0, sizeof(bg->members));
	}

	return 1;
}

int bg_team_warp(int bg_id, unsigned short mapindex, short x, short y)
{ // Warps a Team
	int i;
	struct battleground_data *bg = bg_team_search(bg_id);
	if( bg == NULL ) return 0;
	if( mapindex == 0 )
	{
		mapindex = bg->mapindex;
		x = bg->x;
		y = bg->y;
	}

	for( i = 0; i < MAX_BG_MEMBERS; i++ )
		if( bg->members[i].sd != NULL ) pc_setpos(bg->members[i].sd, mapindex, x, y, CLR_TELEPORT);
	return 1;
}

int bg_reveal_pos(struct block_list *bl, va_list ap)
{
	struct map_session_data *pl_sd, *sd = NULL;
	int flag, color;

	pl_sd = (struct map_session_data *)bl;
	sd = va_arg(ap,struct map_session_data *); // Source
	flag = va_arg(ap,int);
	color = va_arg(ap,int);

	if( pl_sd->bg_id == sd->bg_id )
		return 0; // Same Team

	clif_viewpoint(pl_sd,sd->bl.id,flag,sd->bl.x,sd->bl.y,sd->bl.id,color);
	return 0;
}

int bg_send_dot_remove(struct map_session_data *sd)
{
	struct battleground_data *bg;
	int m;

	if( sd && sd->bg_id && (bg = bg_team_search(sd->bg_id)) != NULL )
	{
		clif_bg_xy_remove(sd);
		if( bg->reveal_pos && (m = map_mapindex2mapid(bg->mapindex)) == sd->bl.m )
			map_foreachinmap(bg_reveal_pos,m,BL_PC,sd,2,0xFFFFFF);
	}
	return 0;
}

int bg_team_join(int bg_id, struct map_session_data *sd)
{ // Player joins team
	int i;
	struct battleground_data *bg = bg_team_search(bg_id);
	struct map_session_data *pl_sd;

	if( bg == NULL || sd == NULL || sd->bg_id ) return 0;

	ARR_FIND(0, MAX_BG_MEMBERS, i, bg->members[i].sd == NULL);
	if( i == MAX_BG_MEMBERS ) return 0; // No free slots

	pc_update_last_action(sd,0,IDLE_WALK); // Start count from here...
	sd->bg_id = bg_id;
	sd->bg_kills = 0;
	sd->state.bg_afk = 0;
	bg->members[i].sd = sd;
	bg->members[i].x = sd->bl.x;
	bg->members[i].y = sd->bl.y;
	bg->count++;

	if( bg->creation_tick == 0 ) bg->creation_tick = last_tick; // Creation Tick = First member joined.

	if( bg->leader_char_id == 0 )
	{ // First Join = Team Leader
		bg->leader_char_id = sd->status.char_id;
		sd->bmaster_flag = bg;
	}

	if( battle_config.bg_ranked_mode && sd->status.bgstats.rank_games < battle_config.bg_ranked_max_games && DIFF_TICK(last_tick,bg->creation_tick) < 60 )
	{
		char output[128];
		bg->members[i].ranked = true;
		sd->status.bgstats.rank_games++;
		sprintf(output,"-- RANKED BATTLEGROUND MATCH %d OF %d --", sd->status.bgstats.rank_games, battle_config.bg_ranked_max_games);
		clif_displaymessage(sd->fd,output);
	}

	guild_send_dot_remove(sd);
	if( battle_config.bg_eAmod_mode )
	{
		clif_bg_belonginfo(sd);
		clif_charnameupdate(sd);
	}

	for( i = 0; i < MAX_BG_MEMBERS; i++ )
	{
		if( (pl_sd = bg->members[i].sd) == NULL )
			continue;

		if( battle_config.bg_eAmod_mode )
		{ // Simulate Guild Information
			clif_guild_basicinfo(pl_sd);
			clif_bg_emblem(pl_sd, bg->g);
			clif_bg_memberlist(pl_sd);
		}

		if( pl_sd != sd )
			clif_bg_hp_single(sd->fd,pl_sd);
	}

	if( battle_config.bg_eAmod_mode ) clif_guild_emblem_area(&sd->bl);
	clif_bg_hp(sd);
	clif_bg_xy(sd);
	return 1;
}

int bg_team_leave(struct map_session_data *sd, int flag)
{ // Single Player leaves team
	int i;
	struct battleground_data *bg;
	struct map_session_data *pl_sd;
	struct guild *g;

	if( sd == NULL || !sd->bg_id )
		return 0;

	bg = bg_team_search(sd->bg_id);

	if( bg && bg->logout_event[0] && flag )
		npc_event(sd, bg->logout_event, 0);

	// Packets
	if( battle_config.bg_eAmod_mode ) clif_bg_leave_single(sd, sd->status.name, "Leaving Battle...");
	bg_send_dot_remove(sd);
	sd->bg_id = 0;
	sd->bg_kills = 0;
	sd->state.bg_afk = 0;
	sd->bmaster_flag = NULL;
	bg_member_removeskulls(sd);

	// Remove Guild Skill Buffs
	status_change_end(&sd->bl,SC_GUILDAURA,INVALID_TIMER);
	status_change_end(&sd->bl,SC_BATTLEORDERS,INVALID_TIMER);
	status_change_end(&sd->bl,SC_REGENERATION,INVALID_TIMER);

	if( battle_config.bg_eAmod_mode )
	{ // Refresh Guild Information
		if( sd->status.guild_id && (g = guild_search(sd->status.guild_id)) != NULL )
		{
			clif_guild_belonginfo(sd, g);
			clif_guild_basicinfo(sd);
			clif_guild_allianceinfo(sd);
			clif_guild_memberlist(sd);
			clif_guild_skillinfo(sd);
			clif_guild_emblem(sd, g);
		}

		clif_charnameupdate(sd);
		clif_guild_emblem_area(&sd->bl);
	}

	if( !bg ) return 0;

	ARR_FIND(0, MAX_BG_MEMBERS, i, bg->members[i].sd == sd);
	if( i < MAX_BG_MEMBERS ) // Removes member from BG
		memset(&bg->members[i], 0, sizeof(bg->members[0]));
	if( bg->leader_char_id == sd->status.char_id )
		bg->leader_char_id = 0;

	bg->count--;
	for( i = 0; i < MAX_BG_MEMBERS; i++ )
	{ // Update other BG members
		if( (pl_sd = bg->members[i].sd) == NULL )
			continue;
		if( !bg->leader_char_id )
		{ // Set new Leader first on the list
			bg->leader_char_id = pl_sd->status.char_id;
			pl_sd->bmaster_flag = bg;
		}

		if( battle_config.bg_eAmod_mode )
		{
			switch( flag )
			{
			case 3: clif_bg_expulsion_single(pl_sd, sd->status.name, "Kicked by AFK Status..."); break;
			case 2: clif_bg_expulsion_single(pl_sd, sd->status.name, "Kicked by AFK Report..."); break;
			case 1: clif_bg_expulsion_single(pl_sd, sd->status.name, "User has quit the game..."); break;
			case 0: clif_bg_leave_single(pl_sd, sd->status.name, "Leaving Battle..."); break;
			}

			clif_guild_basicinfo(pl_sd);
			clif_bg_emblem(pl_sd, bg->g);
			clif_bg_memberlist(pl_sd);
		}
	}

	if( !battle_config.bg_eAmod_mode )
	{
		char output[128];
		switch( flag )
		{
		case 3: sprintf(output, "Server : %s kicked by AFK Status...", sd->status.name); break;
		case 2: sprintf(output, "Server : %s kicked by AFK Report...", sd->status.name); break;
		case 1: sprintf(output, "Server : %s has quit the game...", sd->status.name); break;
		case 0: sprintf(output, "Server : %s is leaving the battlefield...", sd->status.name); break;
		}
		clif_bg_message(bg, 0, "Server", output, strlen(output) + 1);
	}

	return bg->count;
}

int bg_member_respawn(struct map_session_data *sd)
{ // Respawn after killed
	struct battleground_data *bg;
	if( sd == NULL || !pc_isdead(sd) || !sd->bg_id || (bg = bg_team_search(sd->bg_id)) == NULL )
		return 0;
	if( bg->mapindex == 0 )
		return 0; // Respawn not handled by Core
	pc_setpos(sd, bg->mapindex, bg->x, bg->y, CLR_OUTSIGHT);
	status_revive(&sd->bl, 1, 100);

	return 1; // Warped
}

struct guild* bg_guild_get(int bg_id)
{ // Return Fake Guild for BG Members
	struct battleground_data *bg = bg_team_search(bg_id);
	if( bg == NULL ) return NULL;
	return bg->g;
}

int bg_create(unsigned short mapindex, short rx, short ry, int guild_index, const char *ev, const char *dev)
{
	struct battleground_data *bg;
	int i;
	if( ++bg_team_counter <= 0 ) bg_team_counter = 1;

	CREATE(bg, struct battleground_data, 1);
	bg->bg_id = bg_team_counter;
	bg->creation_tick = 0;
	bg->count = 0;
	bg->g = &bg_guild[guild_index];
	bg->mapindex = mapindex;
	bg->x = rx;
	bg->y = ry;
	safestrncpy(bg->logout_event, ev, sizeof(bg->logout_event));
	safestrncpy(bg->die_event, dev, sizeof(bg->die_event));
	for( i = 0; i < MAX_GUILDSKILL; i++ )
		bg->skill_block_timer[i] = INVALID_TIMER;

	memset(&bg->members, 0, sizeof(bg->members));
	bg->color = bg_colors[guild_index];
	bg->pf_id = 0;

	idb_put(bg_team_db, bg_team_counter, bg);

	return bg->bg_id;
}

int bg_team_get_id(struct block_list *bl)
{
	if( bl )
	switch( bl->type )
	{
		case BL_PC:
			return ((TBL_PC*)bl)->bg_id;
		case BL_PET:
			if( ((TBL_PET*)bl)->master )
				return ((TBL_PET*)bl)->master->bg_id;
			break;
		case BL_MOB:
		{
			struct map_session_data *msd;
			struct mob_data *md = (TBL_MOB*)bl;
			if( md->special_state.ai && (msd = map_id2sd(md->master_id)) != NULL )
				return msd->bg_id;
			return md->bg_id;
		}
		case BL_HOM:
			if( ((TBL_HOM*)bl)->master )
				return ((TBL_HOM*)bl)->master->bg_id;
			break;
		case BL_MER:
			if( ((TBL_MER*)bl)->master )
				return ((TBL_MER*)bl)->master->bg_id;
			break;
		case BL_ELEM:
			if( ((TBL_ELEM*)bl)->master )
				return ((TBL_ELEM*)bl)->master->bg_id;
			break;
		case BL_SKILL:
			return ((TBL_SKILL*)bl)->group->bg_id;
		case BL_NPC:
			return ((TBL_NPC*)bl)->u.scr.bg_id;
	}

	return 0;
}

int bg_send_message(struct map_session_data *sd, const char *mes, int len)
{
	struct battleground_data *bg;

	nullpo_ret(sd);
	if( sd->bg_id == 0 || (bg = bg_team_search(sd->bg_id)) == NULL )
		return 0;
	clif_bg_message(bg, sd->bl.id, sd->status.name, mes, len);
	return 0;
}

int bg_send_xy_timer_sub(DBKey key, DBData *data, va_list ap)
{
	struct battleground_data *bg = (struct battleground_data *)db_data2ptr(data);
	struct map_session_data *sd;
	char output[128];
	int i, m;

	nullpo_ret(bg);
	m = map_mapindex2mapid(bg->mapindex);
	bg->reveal_flag = !bg->reveal_flag; // Switch

	for( i = 0; i < MAX_BG_MEMBERS; i++ )
	{
		if( (sd = bg->members[i].sd) == NULL )
			continue;
		if( battle_config.bg_idle_autokick && DIFF_TICK(last_tick, sd->idletime) >= battle_config.bg_idle_autokick && bg->g )
		{
			sprintf(output, "- AFK [%s] Kicked -", sd->status.name);
			clif_broadcast2(&sd->bl, output, (int)strlen(output)+1, bg->color, 0x190, 20, 0, 0, BG);

			bg_team_leave(sd,3);
			clif_displaymessage(sd->fd, "You have been kicked from Battleground because of your AFK status.");
			pc_setpos(sd,sd->status.save_point.map,sd->status.save_point.x,sd->status.save_point.y,CLR_TELEPORT);
			continue;
		}

		if( sd->bl.x != bg->members[i].x || sd->bl.y != bg->members[i].y )
		{ // xy update
			bg->members[i].x = sd->bl.x;
			bg->members[i].y = sd->bl.y;
			clif_bg_xy(sd);
		}
		if( bg->reveal_pos && bg->reveal_flag && sd->bl.m == m ) // Reveal each 4 seconds
			map_foreachinmap(bg_reveal_pos,m,BL_PC,sd,1,bg->color);
		if( battle_config.bg_idle_announce && !sd->state.bg_afk && DIFF_TICK(last_tick, sd->idletime) >= battle_config.bg_idle_announce && bg->g )
		{ // Idle announces
			sd->state.bg_afk = 1;
			sprintf(output, "%s : %s seens to be away. AFK Warning - Can be kicked out with @reportafk", bg->g->name, sd->status.name);
			clif_bg_message(bg, bg->bg_id, bg->g->name, output, strlen(output) + 1);
		}
	}
	return 0;
}

int bg_send_xy_timer(int tid, unsigned int tick, int id, intptr_t data)
{
	bg_team_db->foreach(bg_team_db, bg_send_xy_timer_sub, tick);
	return 0;
}

void bg_guild_build_data(void)
{
	int i, j, k, skill;
	memset(&bg_guild, 0, sizeof(bg_guild));
	for( i = 1; i <= 13; i++ )
	{ // Emblem Data - Guild ID's
		FILE* fp = NULL;
		char path[256];

		j = i - 1;
		bg_guild[j].emblem_id = 1; // Emblem Index
		bg_guild[j].guild_id = SHRT_MAX - j;
		bg_guild[j].guild_lv = 1;
		bg_guild[j].max_member = MAX_BG_MEMBERS;

		// Skills
		if( j < 3 )
		{ // Clan Skills
			for( k = 0; k < MAX_GUILDSKILL; k++ )
			{
				skill = k + GD_SKILLBASE;
				bg_guild[j].skill[k].id = skill;
				switch( skill )
				{
				case GD_GLORYGUILD:
					bg_guild[j].skill[k].lv = 0;
					break;
				case GD_APPROVAL:
				case GD_KAFRACONTRACT:
				case GD_GUARDRESEARCH:
				case GD_BATTLEORDER:
				case GD_RESTORE:
				case GD_EMERGENCYCALL:
				case GD_DEVELOPMENT:
					bg_guild[j].skill[k].lv = 1;
					break;
				case GD_GUARDUP:
				case GD_REGENERATION:
					bg_guild[j].skill[k].lv = 3;
					break;
				case GD_LEADERSHIP:
				case GD_GLORYWOUNDS:
				case GD_SOULCOLD:
				case GD_HAWKEYES:
					bg_guild[j].skill[k].lv = 5;
					break;
				case GD_EXTENSION:
					bg_guild[j].skill[k].lv = 10;
					break;
				}
			}
		}
		else
		{ // Other Data
			snprintf(bg_guild[j].name, NAME_LENGTH, "Team %d", i - 3); // Team 1, Team 2 ... Team 10
			strncpy(bg_guild[j].master, bg_guild[j].name, NAME_LENGTH);
			snprintf(bg_guild[j].position[0].name, NAME_LENGTH, "%s Leader", bg_guild[j].name);
			strncpy(bg_guild[j].position[1].name, bg_guild[j].name, NAME_LENGTH);
		}

		sprintf(path, "%s/emblems/bg_%d.ebm", db_path, i);
		if( (fp = fopen(path, "rb")) != NULL )
		{
			fseek(fp, 0, SEEK_END);
			bg_guild[j].emblem_len = ftell(fp);
			fseek(fp, 0, SEEK_SET);
			fread(&bg_guild[j].emblem_data, 1, bg_guild[j].emblem_len, fp);
			fclose(fp);
			ShowStatus("Done reading '"CL_WHITE"%s"CL_RESET"' emblem data file.\n", path);
		}
	}

	// Guild Data - Guillaume
	strncpy(bg_guild[0].name, "Blue Team", NAME_LENGTH);
	strncpy(bg_guild[0].master, "General Guillaume", NAME_LENGTH);
	strncpy(bg_guild[0].position[0].name, "Blue Team Leader", NAME_LENGTH);
	strncpy(bg_guild[0].position[1].name, "Blue Team", NAME_LENGTH);

	// Guild Data - Croix
	strncpy(bg_guild[1].name, "Red Team", NAME_LENGTH);
	strncpy(bg_guild[1].master, "Prince Croix", NAME_LENGTH);
	strncpy(bg_guild[1].position[0].name, "Red Team Leader", NAME_LENGTH);
	strncpy(bg_guild[1].position[1].name, "Red Team", NAME_LENGTH);

	// Guild Data - Traitors
	strncpy(bg_guild[2].name, "Green Team", NAME_LENGTH);
	strncpy(bg_guild[2].master, "Mercenary", NAME_LENGTH);
	strncpy(bg_guild[2].position[0].name, "Green Team Leader", NAME_LENGTH);
	strncpy(bg_guild[2].position[1].name, "Green Team", NAME_LENGTH);
}

void bg_team_getitem(int bg_id, int nameid, int amount)
{
	struct battleground_data *bg;
	struct map_session_data *sd;
	struct item_data *id;
	struct item it;
	int get_amount, i, j, flag, rank = 0;

	if( amount < 1 || (bg = bg_team_search(bg_id)) == NULL || (id = itemdb_exists(nameid)) == NULL )
		return;
	if( nameid != 7828 && nameid != 7829 && nameid != 7773 )
		return;
	if( battle_config.bg_reward_rates != 100 )
		amount = amount * battle_config.bg_reward_rates / 100;

	memset(&it, 0, sizeof(it));
	it.nameid = nameid;
	it.identify = 1;

	for( j = 0; j < MAX_BG_MEMBERS; j++ )
	{
		if( (sd = bg->members[j].sd) == NULL )
			continue;
		if( battle_config.bg_ranking_bonus )
		{
			rank = 0;
			ARR_FIND(0,MAX_FAME_LIST,i,bgrank_fame_list[i].id == sd->status.char_id);
			if( i < MAX_FAME_LIST )
				rank = 1;
			else
			{
				ARR_FIND(0,MAX_FAME_LIST,i,bg_fame_list[i].id == sd->status.char_id);
				if( i < MAX_FAME_LIST )
					rank = 1;
			}
		}

		get_amount = amount;
		if( rank ) get_amount += battle_config.bg_ranking_bonus * get_amount / 100;

		if( (flag = pc_additem(sd,&it,get_amount,LOG_TYPE_SCRIPT)) )
			clif_additem(sd,0,0,flag);
	}
}

void bg_team_get_kafrapoints(int bg_id, int amount)
{
	struct battleground_data *bg;
	struct map_session_data *sd;
	int i, j, get_amount, rank = 0;

	if( (bg = bg_team_search(bg_id)) == NULL )
		return;

	if( battle_config.bg_reward_rates != 100 )
		amount = amount * battle_config.bg_reward_rates / 100;

	for( i = 0; i < MAX_BG_MEMBERS; i++ )
	{
		if( (sd = bg->members[i].sd) == NULL )
			continue;
		if( battle_config.bg_ranking_bonus )
		{
			rank = 0;
			ARR_FIND(0,MAX_FAME_LIST,j,bgrank_fame_list[j].id == sd->status.char_id);
			if( j < MAX_FAME_LIST )
				rank = 1;
			else
			{
				ARR_FIND(0,MAX_FAME_LIST,j,bg_fame_list[j].id == sd->status.char_id);
				if( j < MAX_FAME_LIST )
					rank = 1;
			}
		}

		get_amount = amount;
		if( rank ) get_amount += battle_config.bg_ranking_bonus * get_amount / 100;
		pc_getcash(sd,0,get_amount,LOG_TYPE_NPC);
	}
}

/* ==============================================================
   bg_arena (0 EoS | 1 Boss | 2 TI | 3 CTF | 4 TD | 5 SC | 6 CON | 7 RUSH | 8 DOM)
   bg_result (0 Won | 1 Tie | 2 Lost)
   ============================================================== */
void bg_team_rewards(int bg_id, int nameid, int amount, int kafrapoints, int quest_id, const char *var, int add_value, int bg_arena, int bg_result)
{
	struct battleground_data *bg;
	struct map_session_data *sd;
	struct item_data *id;
	struct item it;
	int i, j, flag, fame, get_amount, rank = 0, type;

	if( amount < 1 || (bg = bg_team_search(bg_id)) == NULL || (id = itemdb_exists(nameid)) == NULL )
		return;

	if( battle_config.bg_reward_rates != 100 )
	{ // BG Reward Rates
		amount = amount * battle_config.bg_reward_rates / 100;
		kafrapoints = kafrapoints * battle_config.bg_reward_rates / 100;
	}

	bg_result = cap_value(bg_result,0,2);
	memset(&it,0,sizeof(it));
	if( nameid == 7828 || nameid == 7829 || nameid == 7773 )
	{
		it.nameid = nameid;
		it.identify = 1;
	}
	else nameid = 0;

	for( j = 0; j < MAX_BG_MEMBERS; j++ )
	{
		if( (sd = bg->members[j].sd) == NULL )
			continue;

		if( battle_config.bg_ranking_bonus )
		{
			rank = 0;
			ARR_FIND(0,MAX_FAME_LIST,i,bgrank_fame_list[i].id == sd->status.char_id);
			if( i < MAX_FAME_LIST )
				rank = 1;
			else
			{
				ARR_FIND(0,MAX_FAME_LIST,i,bg_fame_list[i].id == sd->status.char_id);
				if( i < MAX_FAME_LIST )
					rank = 1;
			}
		}

		if( quest_id ) quest_add(sd,quest_id);
		pc_setglobalreg(sd,var,pc_readglobalreg(sd,var) + add_value);

		if( kafrapoints > 0 )
		{
			get_amount = kafrapoints;
			if( rank ) get_amount += battle_config.bg_ranking_bonus * get_amount / 100;
			pc_getcash(sd,0,get_amount,LOG_TYPE_NPC);
		}

		if( nameid && amount > 0 )
		{
			get_amount = amount;
			if( rank ) get_amount += battle_config.bg_ranking_bonus * get_amount / 100;

			if( (flag = pc_additem(sd,&it,get_amount,LOG_TYPE_SCRIPT)) )
				clif_additem(sd,0,0,flag);
		}

		type = bg->members[j].ranked ? 2 : 3; // Where to Add Fame

		switch( bg_result )
		{
		case 0: // Won
			add2limit(sd->status.bgstats.win,1,USHRT_MAX);
			achievement_validate_bg(sd,ATB_VICTORY,1);
			fame = 100;
			if( sd->bmaster_flag )
			{
				add2limit(sd->status.bgstats.leader_win,1,USHRT_MAX);
				achievement_validate_bg(sd,ATB_LEADER_VICTORY,1);
				fame += 25;
			}
			pc_addfame(sd,fame,type);
			switch( bg_arena )
			{
			case 0:
				add2limit(sd->status.bgstats.eos_wins,1,USHRT_MAX);
				achievement_validate_bg(sd,ATB_EOS_VICTORY,1);
				break;
			case 1:
				add2limit(sd->status.bgstats.boss_wins,1,USHRT_MAX);
				achievement_validate_bg(sd,ATB_BOSS_VICTORY,1);
				break;
			case 2:
				add2limit(sd->status.bgstats.ti_wins,1,USHRT_MAX);
				achievement_validate_bg(sd,ATB_TI_VICTORY,1);
				break;
			case 3:
				add2limit(sd->status.bgstats.ctf_wins,1,USHRT_MAX);
				achievement_validate_bg(sd,ATB_CTF_VICTORY,1);
				break;
			case 4:
				add2limit(sd->status.bgstats.td_wins,1,USHRT_MAX);
				achievement_validate_bg(sd,ATB_TDM_VICTORY,1);
				break;
			case 5:
				add2limit(sd->status.bgstats.sc_wins,1,USHRT_MAX);
				achievement_validate_bg(sd,ATB_SC_VICTORY,1);
				break;
			case 6:
				add2limit(sd->status.bgstats.cq_wins,1,USHRT_MAX);
				achievement_validate_bg(sd,ATB_CON_VICTORY,1);
				break;
			case 7:
				add2limit(sd->status.bgstats.ru_wins,1,USHRT_MAX);
				achievement_validate_bg(sd,ATB_RU_VICTORY,1);
				break;
			case 8:
				add2limit(sd->status.bgstats.dom_wins,1,USHRT_MAX);
				achievement_validate_bg(sd,ATB_DOM_VICTORY,1);
				break;
			}
			break;
		case 1: // Tie
			add2limit(sd->status.bgstats.tie,1,USHRT_MAX);
			fame = 75;
			if( sd->bmaster_flag )
			{
				add2limit(sd->status.bgstats.leader_tie,1,USHRT_MAX);
				fame += 10;
			}
			pc_addfame(sd,fame,type);
			switch( bg_arena )
			{
			case 0: add2limit(sd->status.bgstats.eos_tie,1,USHRT_MAX); break;
			case 1: add2limit(sd->status.bgstats.boss_tie,1,USHRT_MAX); break;
			case 2: add2limit(sd->status.bgstats.ti_tie,1,USHRT_MAX); break;
			case 3: add2limit(sd->status.bgstats.ctf_tie,1,USHRT_MAX); break;
			case 4: add2limit(sd->status.bgstats.td_tie,1,USHRT_MAX); break;
			case 5: add2limit(sd->status.bgstats.sc_tie,1,USHRT_MAX); break;
			// No Tie for Conquest or Rush
			case 8: add2limit(sd->status.bgstats.dom_tie,1,USHRT_MAX); break;
			}
			break;
		case 2: // Lost
			add2limit(sd->status.bgstats.lost,1,USHRT_MAX);
			achievement_validate_bg(sd,ATB_DEFEAT,1);
			fame = 50;
			if( sd->bmaster_flag )
			{
				add2limit(sd->status.bgstats.leader_lost,1,USHRT_MAX);
				achievement_validate_bg(sd,ATB_LEADER_DEFEAT,1);
			}
			pc_addfame(sd,fame,type);
			switch( bg_arena )
			{
			case 0: add2limit(sd->status.bgstats.eos_lost,1,USHRT_MAX); break;
			case 1: add2limit(sd->status.bgstats.boss_lost,1,USHRT_MAX); break;
			case 2: add2limit(sd->status.bgstats.ti_lost,1,USHRT_MAX); break;
			case 3: add2limit(sd->status.bgstats.ctf_lost,1,USHRT_MAX); break;
			case 4: add2limit(sd->status.bgstats.td_lost,1,USHRT_MAX); break;
			case 5: add2limit(sd->status.bgstats.sc_lost,1,USHRT_MAX); break;
			case 6: add2limit(sd->status.bgstats.cq_lost,1,USHRT_MAX); break;
			case 7: add2limit(sd->status.bgstats.ru_lost,1,USHRT_MAX); break;
			case 8: add2limit(sd->status.bgstats.dom_lost,1,USHRT_MAX); break;
			}
			break;
		}
	}
}

// ====================================================================
// Battleground Queue System
// ====================================================================

struct queue_data* queue_search(int q_id)
{ // Search a Queue using q_id
	if( !q_id ) return NULL;
	return (struct queue_data *)idb_get(queue_db, q_id);
}

int queue_create(const char* queue_name, const char* join_event, int min_level)
{
	struct queue_data *qd;
	if( ++queue_counter <= 0 ) queue_counter = 1;

	CREATE(qd, struct queue_data, 1);
	qd->q_id = queue_counter;
	safestrncpy(qd->queue_name, queue_name, sizeof(qd->queue_name));
	safestrncpy(qd->join_event, join_event, sizeof(qd->join_event));
	qd->first = qd->last = NULL; // First and Last Queue Members
	qd->users = 0;
	qd->min_level = min_level;

	idb_put(queue_db, queue_counter, qd);

	return qd->q_id;
}

void queue_members_clean(struct queue_data *qd)
{
	struct queue_member *head, *next;
	nullpo_retv(qd);

	head = qd->first;
	while( head != NULL )
	{
		if( head->sd ) head->sd->qd = NULL;
		next = head->next;
		aFree(head);
		head = next;
	}

	qd->first = qd->last = NULL;
	qd->users = 0;
}

int queue_member_add(struct queue_data *qd, struct map_session_data *sd)
{
	struct queue_member *qm;
	nullpo_retr(0,qd);
	nullpo_retr(0,sd);

	CREATE(qm, struct queue_member, 1);
	qd->users++;
	qm->sd = sd;
	qm->position = qd->users;
	qm->next = NULL;
	sd->qd = qd; // Attach user to the Queue too

	if( qd->last == NULL )
		qd->first = qd->last = qm; // Attach to first position
	else
	{ // Attach at the end of the queue
		qd->last->next = qm;
		qd->last = qm;
	}

	return qm->position;
}

struct queue_member* queue_member_get(struct queue_data *qd, int position)
{
	struct queue_member *head;
	if( !qd ) return NULL;

	head = qd->first;
	while( head != NULL )
	{
		if( head->sd && head->position == position )
			return head;

		head = head->next;
	}

	return NULL;
}

int queue_member_remove(struct queue_data *qd, int id)
{
	struct queue_member *head, *previous;
	int i;
	nullpo_retr(0,qd);

	head = qd->first;
	previous = NULL;

	while( head != NULL )
	{
		if( head->sd && head->sd->bl.id == id )
		{
			struct queue_member *next;

			next = head->next;
			i = head->position;
			head->sd->qd = NULL;
			qd->users--;

			// De-attach target from the main queue
			if( previous )
				previous->next = head->next;
			else
				qd->first = head->next; // Deleted is on first position

			if( head->next == NULL ) qd->last = previous; // Deleted is on last position

			while( next != NULL )
			{ // Reduces positions of the next of the queue in -1
				next->position--;
				next = next->next;
			}

			aFree(head);
			return i;
		}

		previous = head;
		head = head->next;
	}

	return 0;
}

int queue_member_search(struct queue_data *qd, int id)
{
	struct queue_member *head;
	nullpo_retr(0,qd);

	head = qd->first;
	while( head != NULL )
	{
		if( head->sd && head->sd->bl.id == id )
			return head->position;

		head = head->next;
	}

	return 0; // Not Found
}

int queue_destroy(int q_id)
{
	struct queue_data *qd;

	if( (qd = queue_search(q_id)) == NULL )
		return 0;

	queue_members_clean(qd);
	idb_remove(queue_db, q_id);
	return 1;
}

int queue_join(struct map_session_data *sd, int q_id)
{
	char output[128];
	struct queue_data *qd;
	int i;

	if( battle_config.bg_queue_onlytowns && !map[sd->bl.m].flag.town )
	{
		clif_displaymessage(sd->fd,"You only can join BG queues from Towns or BG Waiting Room.");
		return 0;
	}

	if( sd->bg_id )
	{
		clif_displaymessage(sd->fd,"You cannot join queues when already playing Battlegrounds.");
		return 0;
	}

	if( sd->sc.data[SC_JAILED] )
	{
		clif_displaymessage(sd->fd,"You cannot join queues when jailed.");
		return 0;
	}

	if( (qd = sd->qd) != NULL )
	{ // You cannot join a Queue if you are already on one.
		i = queue_member_search(qd,sd->bl.id);
		sprintf(output,"You are already on %s queue at position %d.", qd->queue_name, i);
		clif_displaymessage(sd->fd,output);
		return 0;
	}

	if( (qd = queue_search(q_id)) == NULL )
		return 0; // Current Queue don't exists

	if( qd->min_level && sd->status.base_level < qd->min_level )
	{
		sprintf(output,"You cannot join %s queue. Required min level is %d.", qd->queue_name, qd->min_level);
		clif_displaymessage(sd->fd,output);
		return 0;
	}

	if( battle_config.bg_logincount_check && battleground_countlogin(sd,false) > 0 )
	{
		sprintf(output,"You cannot join %s queue. Double Login detected.", qd->queue_name);
		clif_displaymessage(sd->fd,output);
		return 0;
	}

	i = queue_member_add(qd,sd);
	sprintf(output,"You have joined %s queue at position %d.", qd->queue_name, i);
	clif_displaymessage(sd->fd,output);

	if( qd->join_event[0] ) npc_event_do(qd->join_event);
	return 1;
}

int queue_leave(struct map_session_data *sd, int q_id)
{
	char output[128];
	struct queue_data *qd;

	if( (qd = queue_search(q_id)) == NULL )
		return 0;

	if( !queue_member_remove(qd,sd->bl.id) )
	{
		sprintf(output,"You are not at %s queue.", qd->queue_name);
		clif_displaymessage(sd->fd,output);
		return 0;
	}

	return 1;
}

void queue_leaveall(struct map_session_data *sd)
{
	struct queue_data *qd;
	if( sd && (qd = sd->qd) != NULL )
	{
		char output[128];
		queue_member_remove(qd,sd->bl.id);
		sprintf(output,"You have been removed from %s BG Queue.",qd->queue_name);
		clif_displaymessage(sd->fd,output);
	}
}

// ====================================================================

void do_init_battleground(void)
{
	bg_team_db = idb_alloc(DB_OPT_RELEASE_DATA);
	queue_db = idb_alloc(DB_OPT_RELEASE_DATA);

	add_timer_func_list(bg_send_xy_timer, "bg_send_xy_timer");
	add_timer_interval(gettick() + battle_config.bg_update_interval, bg_send_xy_timer, 0, 0, battle_config.bg_update_interval);
	bg_guild_build_data();
}

static int bg_team_db_reset(DBKey key, DBData *data, va_list ap)
{
	struct battleground_data *bg = (struct battleground_data *)db_data2ptr(data);
	bg_team_clean(bg->bg_id,false);
	return 0;
}

static int queue_db_final(DBKey key, DBData *data, va_list ap)
{
	struct queue_data *qd = (struct queue_data *)db_data2ptr(data);
	queue_members_clean(qd); // Unlink all queue members
	return 0;
}

void bg_reload(void)
{ // @reloadscript
	bg_team_db->destroy(bg_team_db,bg_team_db_reset);
	queue_db->destroy(queue_db, queue_db_final);

	bg_team_db = idb_alloc(DB_OPT_RELEASE_DATA);
	queue_db = idb_alloc(DB_OPT_RELEASE_DATA);

	bg_team_counter = 0;
	queue_counter = 0;
}

void do_final_battleground(void)
{
	bg_team_db->destroy(bg_team_db, NULL);
	queue_db->destroy(queue_db, queue_db_final);
}
