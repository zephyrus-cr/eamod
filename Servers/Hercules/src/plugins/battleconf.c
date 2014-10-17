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

#include "../map/battle.h"

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>

#include "../common/HPMDataCheck.h" /* should always be the last file included! (if you don't make it last, it'll intentionally break compile time) */


void parse_bg_reportafk_leaderonly(const char *val) {

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
	strlib = GET_SYMBOL("strlib");

	/* session[] */
	session = GET_SYMBOL("session");}

HPExport void server_preinit(void) {
	addBattleConf("bg_reportafk_leaderonly", parse_bg_reportafk_leaderonly);
}
/* run when server is ready (online) */
HPExport void server_online(void) {

}
/* run when server is shutting down */
HPExport void plugin_final(void) {
}