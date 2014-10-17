/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/map/quest.c                                                      *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena, Athena, eAthena                                          *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/

#include "../common/cbasetypes.h"
#include "../common/socket.h"
#include "../common/timer.h"
#include "../common/malloc.h"
#include "../common/nullpo.h"
#include "../common/showmsg.h"
#include "../common/strlib.h"
#include "../common/utils.h"

#include "map.h"
#include "pc.h"
#include "npc.h"
#include "itemdb.h"
#include "script.h"
#include "intif.h"
#include "battle.h"
#include "mob.h"
#include "party.h"
#include "unit.h"
#include "log.h"
#include "clif.h"
#include "quest.h"
#include "intif.h"
#include "chrif.h"
#include "achievement.h"

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdarg.h>
#include <time.h>


struct s_quest_db quest_db[MAX_QUEST_DB];


int quest_search_db(int quest_id)
{
	int i;

	ARR_FIND(0, MAX_QUEST_DB,i,quest_id == quest_db[i].id);
	if(i == MAX_QUEST_DB)
		return -1;

	return i;
}

//Send quest info on login
int quest_pc_login(TBL_PC *sd)
{
	if(sd->avail_quests == 0)
		return 1;

	clif_quest_send_list(sd);
	clif_quest_send_mission(sd);

	return 0;
}

int quest_add(TBL_PC *sd, int quest_id)
{

	int i, j;

	if(sd->num_quests >= MAX_QUEST_DB) {
		ShowError("quest_add: Character %d has got all the quests.(max quests: %d)\n", sd->status.char_id, MAX_QUEST_DB);
		return 1;
	}

	if(quest_check(sd, quest_id, HAVEQUEST) >= 0) {
		ShowError("quest_add: Character %d already has quest %d.\n", sd->status.char_id, quest_id);
		return -1;
	}

	if((j = quest_search_db(quest_id)) < 0) {
		ShowError("quest_add: quest %d not found in DB.\n", quest_id);
		return -1;
	}

	i = sd->avail_quests;
	memmove(&sd->quest_log[i+1], &sd->quest_log[i], sizeof(struct quest)*(sd->num_quests-sd->avail_quests));
	memmove(sd->quest_index+i+1, sd->quest_index+i, sizeof(int)*(sd->num_quests-sd->avail_quests));

	memset(&sd->quest_log[i], 0, sizeof(struct quest));
	sd->quest_log[i].quest_id = quest_db[j].id;
	if(quest_db[j].time)
		sd->quest_log[i].time = (unsigned int)(time(NULL) + quest_db[j].time);
	sd->quest_log[i].state = Q_ACTIVE;

	sd->quest_index[i] = j;
	sd->num_quests++;
	sd->avail_quests++;
	sd->save_quest = true;

	clif_quest_add(sd, &sd->quest_log[i], sd->quest_index[i]);

	if(save_settings&64)
		chrif_save(sd,0);

	return 0;
}

int quest_change(TBL_PC *sd, int qid1, int qid2)
{

	int i, j;

	if(quest_check(sd, qid2, HAVEQUEST) >= 0) {
		ShowError("quest_change: Character %d already has quest %d.\n", sd->status.char_id, qid2);
		return -1;
	}

	if(quest_check(sd, qid1, HAVEQUEST) < 0) {
		ShowError("quest_change: Character %d doesn't have quest %d.\n", sd->status.char_id, qid1);
		return -1;
	}

	if((j = quest_search_db(qid2)) < 0) {
		ShowError("quest_change: quest %d not found in DB.\n",qid2);
		return -1;
	}

	ARR_FIND(0, sd->avail_quests, i, sd->quest_log[i].quest_id == qid1);
	if(i == sd->avail_quests) {
		ShowError("quest_change: Character %d has completed quests %d.\n", sd->status.char_id, qid1);
		return -1;
	}

	memset(&sd->quest_log[i], 0, sizeof(struct quest));
	sd->quest_log[i].quest_id = quest_db[j].id;
	if(quest_db[j].time)
		sd->quest_log[i].time = (unsigned int)(time(NULL) + quest_db[j].time);
	sd->quest_log[i].state = Q_ACTIVE;

	sd->quest_index[i] = j;
	sd->save_quest = true;

	clif_quest_delete(sd, qid1);
	clif_quest_add(sd, &sd->quest_log[i], sd->quest_index[i]);

	if(save_settings&64)
		chrif_save(sd,0);

	return 0;
}

int quest_delete(TBL_PC *sd, int quest_id)
{
	int i;

	//Search for quest
	ARR_FIND(0, sd->num_quests, i, sd->quest_log[i].quest_id == quest_id);
	if(i == sd->num_quests) {
		ShowError("quest_delete: Character %d doesn't have quest %d.\n", sd->status.char_id, quest_id);
		return -1;
	}

	if(sd->quest_log[i].state != Q_COMPLETE)
		sd->avail_quests--;
	if(sd->num_quests-- < MAX_QUEST_DB && sd->quest_log[i+1].quest_id) {
		memmove(&sd->quest_log[i], &sd->quest_log[i+1], sizeof(struct quest)*(sd->num_quests-i));
		memmove(sd->quest_index+i, sd->quest_index+i+1, sizeof(int)*(sd->num_quests-i));
	}
	memset(&sd->quest_log[sd->num_quests], 0, sizeof(struct quest));
	sd->quest_index[sd->num_quests] = 0;
	sd->save_quest = true;

	clif_quest_delete(sd, quest_id);

	if(save_settings&64)
		chrif_save(sd,0);

	return 0;
}

int quest_update_objective_sub(struct block_list *bl, va_list ap)
{
	struct map_session_data *sd;
	int mob, party;

	nullpo_ret(bl);
	nullpo_ret(sd = (struct map_session_data *)bl);

	party = va_arg(ap,int);
	mob = va_arg(ap,int);

	if(!sd->avail_quests)
		return 0;
	if(sd->status.party_id != party)
		return 0;

	quest_update_objective(sd, mob);

	return 1;
}


void quest_update_objective(TBL_PC *sd, int mob)
{
	int i,j;

	for(i = 0; i < sd->avail_quests; i++) {
		if(sd->quest_log[i].state != Q_ACTIVE)
			continue;

		for(j = 0; j < MAX_QUEST_OBJECTIVES; j++)
			if(quest_db[sd->quest_index[i]].mob[j] == mob && sd->quest_log[i].count[j] < quest_db[sd->quest_index[i]].count[j])  {
				sd->quest_log[i].count[j]++;
				sd->save_quest = true;
				clif_quest_update_objective(sd,&sd->quest_log[i],sd->quest_index[i]);
			}
	}
}

int quest_update_status(TBL_PC *sd, int quest_id, quest_state status)
{
	int i;

	//Only status of active and inactive quests can be updated. Completed quests can't (for now). [Inkfish]
	ARR_FIND(0, sd->avail_quests, i, sd->quest_log[i].quest_id == quest_id);
	if(i == sd->avail_quests) {
		ShowError("quest_update_status: Character %d doesn't have quest %d.\n", sd->status.char_id, quest_id);
		return -1;
	}

	sd->quest_log[i].state = status;
	sd->save_quest = true;

	if(status < Q_COMPLETE) {
		clif_quest_update_status(sd, quest_id, (bool)status);
		return 0;
	}

	achievement_validate_quest(sd,quest_id);	
	
	if( i != (--sd->avail_quests) ) {
		struct quest tmp_quest;
		memcpy(&tmp_quest, &sd->quest_log[i],sizeof(struct quest));
		memcpy(&sd->quest_log[i], &sd->quest_log[sd->avail_quests],sizeof(struct quest));
		memcpy(&sd->quest_log[sd->avail_quests], &tmp_quest,sizeof(struct quest));
	}

	clif_quest_delete(sd, quest_id);

	if(save_settings&64)
		chrif_save(sd,0);

	return 0;
}

int quest_check(TBL_PC *sd, int quest_id, quest_check_type type)
{
	int i;

	ARR_FIND(0, sd->num_quests, i, sd->quest_log[i].quest_id == quest_id);
	if(i == sd->num_quests)
		return -1;

	switch(type) {
		case HAVEQUEST:
			return sd->quest_log[i].state;
		case PLAYTIME:
			return (sd->quest_log[i].time < (unsigned int)time(NULL) ? 2 : sd->quest_log[i].state == Q_COMPLETE ? 1 : 0);
		case HUNTING: {
				if(sd->quest_log[i].state == 0 || sd->quest_log[i].state == 1) {
					int j;
					ARR_FIND(0, MAX_QUEST_OBJECTIVES, j, sd->quest_log[i].count[j] < quest_db[sd->quest_index[i]].count[j]);
					if(j == MAX_QUEST_OBJECTIVES)
						return 2;
					if(sd->quest_log[i].time < (unsigned int)time(NULL))
						return 1;
					return 0;
				} else
					return 0;
			}
		default:
			ShowError("quest_check_quest: Unknown parameter %d",type);
			break;
	}

	return -1;
}

int quest_read_db(void)
{
	int QuestLoop, QueryLoop, MaxQuestLoop = 0;

	if(SQL_ERROR == Sql_Query(dbmysql_handle, "SELECT * FROM `%s`", get_database_name(50))) {
		Sql_ShowDebug(dbmysql_handle);
		return -1;
	}

	while(SQL_SUCCESS == Sql_NextRow(dbmysql_handle) && MaxQuestLoop < MAX_QUEST_DB) {
		char *row[9];

		for(QueryLoop = 0; QueryLoop < 9; ++QueryLoop)
			Sql_GetData(dbmysql_handle, QueryLoop, &row[QueryLoop], NULL);

		memset(&quest_db[MaxQuestLoop], 0, sizeof(quest_db[0]));

		quest_db[MaxQuestLoop].id = atoi(row[0]);
		quest_db[MaxQuestLoop].time = atoi(row[1]);

		for(QuestLoop = 0; QuestLoop < MAX_QUEST_OBJECTIVES; QuestLoop++) {
			quest_db[MaxQuestLoop].mob[QuestLoop] = atoi(row[2*QuestLoop+2]);
			quest_db[MaxQuestLoop].count[QuestLoop] = atoi(row[2*QuestLoop+3]);

			if(!quest_db[MaxQuestLoop].mob[QuestLoop] || !quest_db[MaxQuestLoop].count[QuestLoop])
				break;
		}

		quest_db[MaxQuestLoop].num_objectives = QuestLoop;
		MaxQuestLoop++;
	}

	ShowSQL("Leitura de '"CL_WHITE"%lu"CL_RESET"' entradas na tabela '"CL_WHITE"%s"CL_RESET"'.\n", MaxQuestLoop, get_database_name(50));
	Sql_FreeResult(dbmysql_handle);
	return 0;
}

void do_init_quest(void)
{
	quest_read_db();
}

void do_reload_quest(void)
{
	memset(&quest_db, 0, sizeof(quest_db));
	quest_read_db();
}
