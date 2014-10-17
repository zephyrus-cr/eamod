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
int duel_create(struct map_session_data* sd, const unsigned int maxpl);
int duel_invite(const unsigned int did, struct map_session_data* sd, struct map_session_data* target_sd);
int duel_accept(const unsigned int did, struct map_session_data* sd);
int duel_reject(const unsigned int did, struct map_session_data* sd);
int duel_leave(const unsigned int did, struct map_session_data* sd);
int duel_showinfo(const unsigned int did, struct map_session_data* sd);
int duel_checktime(struct map_session_data* sd);

int do_init_duel(void);
void do_final_duel(void);

#endif /* _DUEL_H_ */
