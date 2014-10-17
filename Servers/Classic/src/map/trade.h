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

#ifndef	_TRADE_H_
#define	_TRADE_H_

//#include "map.h"
struct map_session_data;

void trade_traderequest(struct map_session_data *sd, struct map_session_data *target_sd);
void trade_tradeack(struct map_session_data *sd,int type);
void trade_tradeadditem(struct map_session_data *sd,short index,short amount);
void trade_tradeaddzeny(struct map_session_data *sd,int amount);
void trade_tradeok(struct map_session_data *sd);
void trade_tradecancel(struct map_session_data *sd);
void trade_tradecommit(struct map_session_data *sd);

#endif /* _TRADE_H_ */
