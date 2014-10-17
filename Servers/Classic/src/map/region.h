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

#ifndef _REGION_H_
#define _REGION_H_

#include "../common/mmo.h"

#define REGION_NAME_LENGTH 48

struct region_data {
	int region_id;
	char name[REGION_NAME_LENGTH];
	int maps, users;
	int guild_id;

	int bonus_bexp, bonus_jexp, bonus_drop;
	struct script_code *script;
};

struct DBMap* region_get_db(void);
struct region_data* region_search(int region_id);
void region_set_guild(int region_id, int guild_id);

void do_init_region(void);
void do_final_region(void);

#endif /* _REGION_H_ */
