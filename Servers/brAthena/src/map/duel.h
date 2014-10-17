/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/map/duel.h                                                       *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena, Athena, eAthena                                          *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/

#ifndef _DUEL_H_
#define _DUEL_H_

struct duel {
	int members_count;
	int invites_count;
	int max_players_limit;
};

#define MAX_DUEL 1024
extern struct duel duel_list[MAX_DUEL];
extern int duel_count;

//Duel functions // [LuzZza]
int duel_create(struct map_session_data *sd, const unsigned int maxpl);
void duel_invite(const unsigned int did, struct map_session_data *sd, struct map_session_data *target_sd);
void duel_accept(const unsigned int did, struct map_session_data *sd);
void duel_reject(const unsigned int did, struct map_session_data *sd);
void duel_leave(const unsigned int did, struct map_session_data *sd);
void duel_showinfo(const unsigned int did, struct map_session_data *sd);
int duel_checktime(struct map_session_data *sd);

void do_init_duel(void);
void do_final_duel(void);

#endif /* _DUEL_H_ */
