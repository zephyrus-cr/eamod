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

#ifndef _CHAT_H_
#define _CHAT_H_

#include "map.h" // struct block_list, CHATROOM_TITLE_SIZE
struct map_session_data;
struct chat_data;


struct chat_data {
	struct block_list bl;            // data for this map object
	char title[CHATROOM_TITLE_SIZE]; // room title 
	char pass[CHATROOM_PASS_SIZE];   // password
	bool pub;                        // private/public flag
	uint8 users;                     // current user count
	uint8 limit;                     // join limit
	uint8 trigger;                   // number of users needed to trigger event
	uint32 zeny;						 // required zeny to join
	uint32 minLvl;					 // minimum base level to join
	uint32 maxLvl;					 // maximum base level allowed to join
	struct map_session_data* usersd[20];
	struct block_list* owner;
	char npc_event[EVENT_NAME_LENGTH];
};


int chat_createpcchat(struct map_session_data* sd, const char* title, const char* pass, int limit, bool pub);
int chat_joinchat(struct map_session_data* sd, int chatid, const char* pass);
int chat_leavechat(struct map_session_data* sd, bool kicked);
int chat_changechatowner(struct map_session_data* sd, const char* nextownername);
int chat_changechatstatus(struct map_session_data* sd, const char* title, const char* pass, int limit, bool pub);
int chat_kickchat(struct map_session_data* sd, const char* kickusername);

int chat_createnpcchat(struct npc_data* nd, const char* title, int limit, bool pub, int trigger, const char* ev, int zeny, int minLvl, int maxLvl);
int chat_deletenpcchat(struct npc_data* nd);
int chat_enableevent(struct chat_data* cd);
int chat_disableevent(struct chat_data* cd);
int chat_npckickall(struct chat_data* cd);

#endif /* _CHAT_H_ */
