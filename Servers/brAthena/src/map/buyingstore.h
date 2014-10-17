/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/map/buyingstore.h                                                *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena, Athena, eAthena                                          *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/

#ifndef _BUYINGSTORE_H_
#define _BUYINGSTORE_H_

struct s_search_store_search;

#define MAX_BUYINGSTORE_SLOTS 5

struct s_buyingstore_item {
	int price;
	unsigned short amount;
	unsigned short nameid;
};

struct s_buyingstore {
	struct s_buyingstore_item items[MAX_BUYINGSTORE_SLOTS];
	int zenylimit;
	unsigned char slots;
};

bool buyingstore_setup(struct map_session_data *sd, unsigned char slots);
void buyingstore_create(struct map_session_data *sd, int zenylimit, unsigned char result, const char *storename, const uint8 *itemlist, unsigned int count);
void buyingstore_close(struct map_session_data *sd);
void buyingstore_open(struct map_session_data *sd, int account_id);
void buyingstore_trade(struct map_session_data *sd, int account_id, unsigned int buyer_id, const uint8 *itemlist, unsigned int count);
bool buyingstore_search(struct map_session_data *sd, unsigned short nameid);
bool buyingstore_searchall(struct map_session_data *sd, const struct s_search_store_search *s);

#endif  // _BUYINGSTORE_H_
