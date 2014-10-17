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

#ifndef _CHANNEL_H_
#define _CHANNEL_H_

#include "../common/mmo.h"
#include "../common/db.h"

#define MAX_USER_CHANNELS 4

enum {
	CHN_MAIN,
	CHN_VENDING,
	CHN_BATTLEGROUND,
	CHN_GAMEMASTER,
	CHN_USER,
	CHN_SERVER,
};

struct channel_data {
	unsigned int channel_id;
	char name[NAME_LENGTH];
	char pass[NAME_LENGTH];
	// Channel Settings
	short type; // Main, Vending, Battleground, Other
	unsigned long color;
	int op, users;
	// User Database
	DBMap* users_db;
};

extern struct channel_data *server_channel[];
extern const unsigned long channel_color[];

void channel_list(struct map_session_data *sd);
bool channel_create(struct map_session_data *sd, const char* name, const char* pass, short type, short color, int op);
void channel_join(struct map_session_data *sd, const char* name, const char* pass, bool invite);
void channel_leave(struct map_session_data *sd, const char* name, bool msg);
void channel_message(struct map_session_data *sd, const char* channel, const char* message);
int channel_invite_accept(struct map_session_data *sd);
void channel_invite_clear(struct map_session_data *sd);

void do_init_channel(void);
void do_final_channel(void);

#endif /* _CHANNEL_H_ */
