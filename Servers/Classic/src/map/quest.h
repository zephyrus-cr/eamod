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

#ifndef _QUEST_H_
#define _QUEST_H_

struct s_quest_db {
	int id;
	unsigned int time;
	int mob[MAX_QUEST_OBJECTIVES];
	int count[MAX_QUEST_OBJECTIVES];
	int num_objectives;
	//char name[NAME_LENGTH];
};
extern struct s_quest_db quest_db[MAX_QUEST_DB];

typedef enum quest_check_type { HAVEQUEST, PLAYTIME, HUNTING } quest_check_type;

int quest_pc_login(TBL_PC * sd);

int quest_add(TBL_PC * sd, int quest_id);
int quest_delete(TBL_PC * sd, int quest_id);
int quest_change(TBL_PC * sd, int qid1, int qid2);
int quest_update_objective_sub(struct block_list *bl, va_list ap);
void quest_update_objective(TBL_PC * sd, int mob);
int quest_update_status(TBL_PC * sd, int quest_id, quest_state status);
int quest_check(TBL_PC * sd, int quest_id, quest_check_type type);

int quest_search_db(int quest_id);

void do_init_quest();

#endif
