/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/map/trade.h                                                      *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena, Athena, eAthena                                          *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/

#ifndef _TRADE_H_
#define _TRADE_H_

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
