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

#ifndef _ATCOMMAND_H_
#define _ATCOMMAND_H_

//#include "map.h"
struct map_session_data;

//This is the distance at which @autoloot works,
//if the item drops farther from the player than this,
//it will not be autolooted. [Skotlex]
//Note: The range is unlimited unless this define is set.
//#define AUTOLOOT_DISTANCE AREA_SIZE

extern char atcommand_symbol;
extern char charcommand_symbol;
typedef int (*AtCommandFunc)(const int fd, struct map_session_data* sd, const char* command, const char* message);

bool is_atcommand(const int fd, struct map_session_data* sd, const char* message, int type);
int get_atcommand_level(const AtCommandFunc func);

void do_init_atcommand(void);
void do_final_atcommand(void);
int atcommand_config_read(const char *cfgName);
void atcommand_expinfo_sub(int time, int* day, int* hour, int* minute, int* second); // Exp Gain Rates

int atcommand_mail(const int fd, struct map_session_data* sd,const char* command, const char* message);
int atcommand_item(const int fd, struct map_session_data* sd,const char* command, const char* message);
int atcommand_mapmove(const int fd, struct map_session_data* sd,const char* command, const char* message);
int atcommand_monster(const int fd, struct map_session_data* sd, const char* command, const char* message);
int atcommand_jumpto(const int fd, struct map_session_data* sd, const char* command, const char* message);
int atcommand_recall(const int fd, struct map_session_data* sd, const char* command, const char* message);
int atcommand_hide(const int fd, struct map_session_data* sd, const char* command, const char* message);
int atcommand_mute(const int fd, struct map_session_data* sd, const char* command, const char* message);
int atcommand_kick(const int fd, struct map_session_data* sd, const char* command, const char* message);
int atcommand_broadcast(const int fd, struct map_session_data* sd,const char* command, const char* message);
int atcommand_localbroadcast(const int fd, struct map_session_data* sd,const char* command, const char* message);
int atcommand_reset(const int fd, struct map_session_data* sd,const char* command, const char* message);
int atcommand_unloadnpc(const int fd, struct map_session_data* sd, const char* command, const char* message);
int atcommand_killmonster(const int fd, struct map_session_data* sd, const char* command, const char* message);

#define MAX_MSG 1000
extern char* msg_table[MAX_MSG];
const char* msg_txt(int msg_number);
int msg_config_read(const char* cfgName);
void do_final_msg(void);

#define MAX_ATCMD_BINDINGS 100

typedef struct Atcmd_Binding {
	char command[50];
	char npc_event[50];
	int level;
	int level2;
} Atcmd_Binding;

//At command events
struct Atcmd_Binding atcmd_binding[MAX_ATCMD_BINDINGS];
struct Atcmd_Binding* get_atcommandbind_byname(const char* name);

#endif /* _ATCOMMAND_H_ */
