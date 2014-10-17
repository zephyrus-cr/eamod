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

#ifndef _MAIL_H_
#define _MAIL_H_

#include "../common/mmo.h"

void mail_clear(struct map_session_data *sd);
int mail_removeitem(struct map_session_data *sd, short flag);
int mail_removezeny(struct map_session_data *sd, short flag);
unsigned char mail_setitem(struct map_session_data *sd, int idx, int amount);
bool mail_setattachment(struct map_session_data *sd, struct mail_message *msg);
void mail_getattachment(struct map_session_data* sd, int zeny, struct item* item);
int mail_openmail(struct map_session_data *sd);
void mail_deliveryfail(struct map_session_data *sd, struct mail_message *msg);
bool mail_invalid_operation(struct map_session_data *sd);

#endif /* _MAIL_H_ */
