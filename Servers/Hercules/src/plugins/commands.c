// Will add all the standard copyright crap later
//
// eAmod Commands - Order
//
//


#include "../common/cbasetypes.h"
#include "../common/mmo.h"
#include "../common/timer.h"
#include "../common/nullpo.h"
#include "../common/core.h"
#include "../common/showmsg.h"
#include "../common/malloc.h"
#include "../common/random.h"
#include "../common/socket.h"
#include "../common/strlib.h"
#include "../common/utils.h"
#include "../common/conf.h"
#include "../common/sysinfo.h"
#include "../common/HPMi.h"

#include "../map/atcommand.h"
#include "../map/battle.h"
#include "../map/battleground.h"
#include "../map/chat.h"
#include "../map/clif.h"
#include "../map/chrif.h"
#include "../map/duel.h"
#include "../map/intif.h"
#include "../map/itemdb.h"
#include "../map/log.h"
#include "../map/map.h"
#include "../map/pc.h"
#include "../map/pc_groups.h" // groupid2name
#include "../map/status.h"
#include "../map/skill.h"
#include "../map/mob.h"
#include "../map/npc.h"
#include "../map/pet.h"
#include "../map/homunculus.h"
#include "../map/mail.h"
#include "../map/mercenary.h"
#include "../map/elemental.h"
#include "../map/party.h"
#include "../map/guild.h"
#include "../map/script.h"
#include "../map/storage.h"
#include "../map/trade.h"
#include "../map/unit.h"
#include "../map/mapreg.h"
#include "../map/quest.h"
#include "../map/searchstore.h"
#include "../map/HPMmap.h"

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>

#include "../common/HPMDataCheck.h" /* should always be the last file included! (if you don't make it last, it'll intentionally break compile time) */


// Declarations

static char atcmd_output[CHAT_SIZE_MAX];
static char atcmd_player_name[NAME_LENGTH];

HPExport struct hplugin_info pinfo = {
	"eAmod Commands",		// Plugin name
	SERVER_TYPE_MAP,// Which server types this plugin works with?
	"1.0",			// Plugin version
	HPM_VERSION,	// HPM Version (don't change, macro is automatically updated)
};

ACMD(order)
{
	nullpo_retr(-1,sd);
	if( !message || !*message )
	{
		clif->message(fd, "Please, enter a message (usage: @order <message>).");
		return -1;
	}
	if( map->list[sd->bl.m].flag.battleground )
	{
		if( !sd->bgdata.bmaster_flag )
		{
			clif->message(fd, "This command is reserved for Team Leaders Only.");
			return -1;
		}
		clif->broadcast2(&sd->bl, message, (int)strlen(message)+1, sd->bgdata.bmaster_flag->color, 0x190, 20, 0, 0, BG);
	}
	else
	{
		if( !sd->state.gmaster_flag )
		{
			clif->message(fd, "This command is reserved for Guild Leaders Only.");
			return -1;
		}
		clif->broadcast2(&sd->bl, message, (int)strlen(message)+1, 0xFF0000, 0x190, 20, 0, 0, GUILD);
	}

	return 0;
}

ACMD(leader)
{
	struct map_session_data *pl_sd;
	nullpo_retr(-1, sd);


	if (!sd->bgdata.bmaster_flag)
		clif->message(fd, "This command is reserved for Team Leaders Only.");
	else if (sd->ud.skilltimer != INVALID_TIMER)
		clif->message(fd, "Command not allow while casting a skill.");
	else if (!message || !*message)
		clif->message(fd, "Please, enter the new Leader name (usage: @leader <name>).");
	else if ((pl_sd = map->nick2sd((char *)message)) == NULL)
		clif->message(fd, msg_txt(3)); // Character not found.
	else if (sd->bg_id != pl_sd->bg_id)
		clif->message(fd, "Destination Player is not in your Team.");
	else if (sd == pl_sd)
		clif->message(fd, "You are already the Team Leader.");
	else
	{ // Everytest OK!
		ShowMessage(atcmd_output, "Team Leader transfered to [%s]", pl_sd->status.name);
		clif->broadcast2(&sd->bl, atcmd_output, (int)strlen(atcmd_output) + 1, sd->bgdata.bmaster_flag->color, 0x190, 20, 0, 0, BG);

		sd->bgdata.bmaster_flag->leader_char_id = pl_sd->status.char_id;
		pl_sd->bgdata.bmaster_flag = sd->bgdata.bmaster_flag;
		sd->bgdata.bmaster_flag = NULL;

		clif->charnameupdate(sd);
		clif->charnameupdate(pl_sd);
		return 0;
	}
	return -1;
}

ACMD(reportafk)
{
	struct map_session_data *pl_sd;
	nullpo_retr(-1, sd);
	if (!sd->bg_id)
		clif->message(fd, "This command is reserved for Battleground Only.");
	else if (!sd->bgdata.bmaster_flag && battle_config.bg_reportafk_leaderonly)
		clif->message(fd, "This command is reserved for Team Leaders Only.");
	else if (!message || !*message)
		clif->message(fd, "Please, enter the character name (usage: @reportafk <name>).");
	else if ((pl_sd = map->nick2sd((char *)message)) == NULL)
		clif->message(fd, msg_txt(3)); // Character not found.
	else if (sd->bg_id != pl_sd->bg_id)
		clif->message(fd, "Destination Player is not in your Team.");
	else if (sd == pl_sd)
		clif->message(fd, "You cannot kick yourself.");
	else if (pl_sd->state.bg_afk == 0)
		clif->message(fd, "The player is not AFK on this Battleground.");
	else
	{ // Everytest OK!
		struct battleground_data *bg_d;
		if ((bg_d = bg->team_search(sd->bg_id)) == NULL)
			return -1;

		bg->team_leave(pl_sd, 2);
		clif->message(pl_sd->fd, "You have been kicked from Battleground because of your AFK status.");
		pc->setpos(pl_sd, pl_sd->status.save_point.map, pl_sd->status.save_point.x, pl_sd->status.save_point.y, 3);

		ShowMessage(atcmd_output, "- AFK [%s] Kicked -", pl_sd->status.name);
		clif->broadcast2(&sd->bl, atcmd_output, (int)strlen(atcmd_output) + 1, bg_d->color, 0x190, 20, 0, 0, BG);
		return 0;
	}
	return -1;
}

HPExport void plugin_init(void) {
	char *server_type;
	char *server_name;

	/* core vars */
	server_type = GET_SYMBOL("SERVER_TYPE");
	server_name = GET_SYMBOL("SERVER_NAME");

	/* core interfaces */
	iMalloc = GET_SYMBOL("iMalloc");

	/* map-server interfaces */
	script = GET_SYMBOL("script");
	clif = GET_SYMBOL("clif");
	pc = GET_SYMBOL("pc");
	strlib = GET_SYMBOL("strlib");

	/* session[] */
	session = GET_SYMBOL("session");

	addAtcommand("order", order);
	addAtcommand("leader", leader);
	addAtcommand("reportafk", reportafk);
}

HPExport void server_preinit(void) {
}
/* run when server is ready (online) */
HPExport void server_online(void) {

}
/* run when server is shutting down */
HPExport void plugin_final(void) {
}