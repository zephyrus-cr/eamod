/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/map/pc_groups.h                                                  *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena, Athena, eAthena                                          *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/

#ifndef _PC_GROUPS_H_
#define _PC_GROUPS_H_

#include "atcommand.h" // AtCommandType

extern int pc_group_max;

bool pc_group_exists(int group_id);
bool pc_group_can_use_command(int group_id, const char *command, AtCommandType type);
bool pc_group_has_permission(int group_id, int permission);
bool pc_group_should_log_commands(int group_id);
const char* pc_group_id2name(int group_id);
int pc_group_id2level(int group_id);
void pc_group_pc_load(struct map_session_data *);

void do_init_pc_groups(void);
void do_final_pc_groups(void);
void pc_groups_reload(void);

enum e_pc_permission {
	PC_PERM_NONE                = 0,
	PC_PERM_TRADE               = 0x000001,
	PC_PERM_PARTY               = 0x000002,
	PC_PERM_ALL_SKILL           = 0x000004,
	PC_PERM_USE_ALL_EQUIPMENT   = 0x000008,
	PC_PERM_SKILL_UNCONDITIONAL = 0x000010,
	PC_PERM_JOIN_ALL_CHAT       = 0x000020,
	PC_PERM_NO_CHAT_KICK        = 0x000040,
	PC_PERM_HIDE_SESSION        = 0x000080,
	PC_PERM_WHO_DISPLAY_AID     = 0x000100,
	PC_PERM_RECEIVE_HACK_INFO   = 0x000200,
	PC_PERM_WARP_ANYWHERE       = 0x000400,
	PC_PERM_VIEW_HPMETER        = 0x000800,
	PC_PERM_VIEW_EQUIPMENT      = 0x001000,
	PC_PERM_USE_CHECK           = 0x002000,
	PC_PERM_USE_CHANGEMAPTYPE   = 0x004000,
	PC_PERM_USE_ALL_COMMANDS    = 0x008000,
	PC_PERM_RECEIVE_REQUESTS    = 0x010000,
	PC_PERM_SHOW_BOSS			= 0x020000,
	PC_PERM_DISABLE_PVM			= 0x040000,
	PC_PERM_DISABLE_PVP			= 0x080000,
	PC_PERM_DISABLE_CMD_DEAD    = 0x100000,
	PC_PERM_NO_TAKE_ITEM    		= 0x200000,    // [Holy]
	PC_PERM_CAN_SHOP    		= 0x400000,    // [Megasantos]
	PC_PERM_CAN_DROPS    		= 0x800000,    // [Megasantos]
	PC_PERM_DISABLE_EXP    		= 0x1000000,   // [Megasantos]
	PC_PERM_NOT_ATTACK    		= 0x2000000,   // [Holy]
	PC_PERM_NO_CREATE_GUILD     = 0x4000000,   // [Holy]
	PC_PERM_NOT_USE_SKILL       = 0x8000000,   // [Holy]
	// eAmod Permissions
	PC_PERM_CHANNEL_OPERATOR	= 0x100000,
};

static const struct {
	const char *name;
	unsigned int permission;
} pc_g_permission_name[] = {
	{ "can_trade", PC_PERM_TRADE },
	{ "can_party", PC_PERM_PARTY },
	{ "all_skill", PC_PERM_ALL_SKILL },
	{ "all_equipment", PC_PERM_USE_ALL_EQUIPMENT },
	{ "skill_unconditional", PC_PERM_SKILL_UNCONDITIONAL },
	{ "join_chat", PC_PERM_JOIN_ALL_CHAT },
	{ "kick_chat", PC_PERM_NO_CHAT_KICK },
	{ "hide_session", PC_PERM_HIDE_SESSION },
	{ "who_display_aid", PC_PERM_WHO_DISPLAY_AID },
	{ "hack_info", PC_PERM_RECEIVE_HACK_INFO },
	{ "any_warp", PC_PERM_WARP_ANYWHERE },
	{ "view_hpmeter", PC_PERM_VIEW_HPMETER },
	{ "view_equipment", PC_PERM_VIEW_EQUIPMENT },
	{ "use_check", PC_PERM_USE_CHECK },
	{ "use_changemaptype", PC_PERM_USE_CHANGEMAPTYPE },
	{ "all_commands", PC_PERM_USE_ALL_COMMANDS },
	{ "receive_requests", PC_PERM_RECEIVE_REQUESTS },
	{ "show_bossmobs", PC_PERM_SHOW_BOSS },
	{ "disable_pvm", PC_PERM_DISABLE_PVM },
	{ "disable_pvp", PC_PERM_DISABLE_PVP },
	{ "disable_commands_when_dead", PC_PERM_DISABLE_CMD_DEAD },
	{ "no_take_item", PC_PERM_NO_TAKE_ITEM },     // [Holy]
	{ "can_shop", PC_PERM_CAN_SHOP },       // [Megasantos]
	{ "can_drops", PC_PERM_CAN_DROPS },     // [Megasantos]
	{ "disable_exp", PC_PERM_DISABLE_EXP }, // [Megasantos]
	{ "not_attack", PC_PERM_NOT_ATTACK },   // [Holy]
	{ "no_create_guild", PC_PERM_NO_CREATE_GUILD },// [Holy]
	{ "not_use_skill", PC_PERM_NOT_USE_SKILL },   // [Holy]
};

#endif // _PC_GROUPS_H_
