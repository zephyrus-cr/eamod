/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/map/atcommand.h                                                  *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena, Athena, eAthena                                          *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/ 

#ifndef _ATCOMMAND_H_
#define _ATCOMMAND_H_

struct map_session_data;

//This is the distance at which @autoloot works,
//if the item drops farther from the player than this,
//it will not be autolooted. [Skotlex]
//Note: The range is unlimited unless this define is set.
//#define AUTOLOOT_DISTANCE AREA_SIZE

extern char atcommand_symbol;
extern char charcommand_symbol;

typedef enum {
    COMMAND_ATCOMMAND = 1,
    COMMAND_CHARCOMMAND = 2,
} AtCommandType;

typedef int (*AtCommandFunc)(const int fd, struct map_session_data *sd, const char *command, const char *message);

bool is_atcommand(const int fd, struct map_session_data *sd, const char *message, int type);

void do_init_atcommand(void);
void do_final_atcommand(void);
void atcommand_db_load_groups(int* group_ids);
void atcommand_expinfo_sub(int time, int* day, int* hour, int* minute, int* second); // Exp Gain Rates

bool atcommand_exists(const char* name);

const char *msg_txt(int msg_number);
int msg_config_read(const char *cfgName);
void do_final_msg(void);

extern int atcmd_binding_count;

// @commands (script based)
struct atcmd_binding_data {
	char command[50];
	char npc_event[50];
	int level;
	int level2;
};

struct atcmd_binding_data **atcmd_binding;

struct atcmd_binding_data *get_atcommandbind_byname(const char *name);

#endif /* _ATCOMMAND_H_ */
