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

#ifndef _BATTLEGROUND_H_
#define _BATTLEGROUND_H_

#include "../common/mmo.h" // struct party
#include "guild.h"

#define MAX_BG_MEMBERS 50

struct battleground_member_data {
	unsigned short x, y;
	struct map_session_data *sd;
	bool ranked;
};

struct battleground_data {
	unsigned int bg_id;
	time_t creation_tick; // Creation of this Team
	int count;
	struct battleground_member_data members[MAX_BG_MEMBERS];
	// Team Leader and BG Skills features
	int leader_char_id;
	int skill_block_timer[MAX_GUILDSKILL];
	unsigned int color;
	// Party - Faction ID
	int pf_id;
	// Fake Guild Link
	struct guild *g;
	// BG Cementery
	unsigned short mapindex, x, y;
	bool reveal_pos, reveal_flag;
	// Script Events
	char logout_event[EVENT_NAME_LENGTH];
	char die_event[EVENT_NAME_LENGTH];
	// Score Board
	int team_score;
};

struct queue_member {
	int position;
	struct map_session_data *sd;
	struct queue_member *next;
};

struct queue_data {
	unsigned int q_id;
	int min_level, users;
	struct queue_member *first, *last;
	char queue_name[50], join_event[EVENT_NAME_LENGTH];
};

extern struct guild bg_guild[];
extern const unsigned int bg_colors[];

void do_init_battleground(void);
void do_final_battleground(void);

struct battleground_data* bg_team_search(int bg_id);
struct guild* bg_guild_get(int bg_id);
int bg_send_dot_remove(struct map_session_data *sd);
int bg_team_get_id(struct block_list *bl);
struct map_session_data* bg_getavailablesd(struct battleground_data *bg);

int bg_create(unsigned short mapindex, short rx, short ry, int guild_index, const char *ev, const char *dev);
int bg_team_join(int bg_id, struct map_session_data *sd);
int bg_team_clean(int bg_id, bool remove);
int bg_team_leave(struct map_session_data *sd, int flag);
int bg_team_warp(int bg_id, unsigned short mapindex, short x, short y);
int bg_member_respawn(struct map_session_data *sd);
int bg_send_message(struct map_session_data *sd, const char *mes, int len);
int battleground_countlogin(struct map_session_data *sd, bool check_bat_room);
void bg_team_getitem(int bg_id, int nameid, int amount);
void bg_team_get_kafrapoints(int bg_id, int amount);
void bg_team_rewards(int bg_id, int nameid, int amount, int kafrapoints, int quest_id, const char *var, int add_value, int bg_arena, int bg_result);
int bg_checkskill(struct battleground_data *bg, int id);
void bg_block_skill_status(struct battleground_data *bg, int skillnum);
void bg_block_skill_start(struct battleground_data *bg, int skillnum, int time);

struct queue_data* queue_search(int q_id);
int queue_create(const char* queue_name, const char* join_event, int min_level);
int queue_destroy(int q_id);
int queue_leave(struct map_session_data *sd, int q_id);
void queue_leaveall(struct map_session_data *sd);
int queue_join(struct map_session_data *sd, int q_id);

struct queue_member* queue_member_get(struct queue_data *qd, int position);
int queue_member_remove(struct queue_data *qd, int id);

void bg_reload(void);

#endif /* _BATTLEGROUND_H_ */
