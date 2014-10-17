/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/map/searchstore.h                                                *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena, Athena, eAthena                                          *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/

#ifndef _SEARCHSTORE_H_
#define _SEARCHSTORE_H_

#define SEARCHSTORE_RESULTS_PER_PAGE 10

/// information about the search being performed
struct s_search_store_search {
	struct map_session_data *search_sd;  // sd of the searching player
	const unsigned short *itemlist;
	const unsigned short *cardlist;
	unsigned int item_count;
	unsigned int card_count;
	unsigned int min_price;
	unsigned int max_price;
};

struct s_search_store_info_item {
	int store_id;
	int account_id;
	char store_name[MESSAGE_SIZE];
	unsigned short nameid;
	unsigned short amount;
	unsigned int price;
	short card[MAX_SLOTS];
	unsigned char refine;
};

struct s_search_store_info {
	unsigned int count;
	struct s_search_store_info_item *items;
	unsigned int pages;  // amount of pages already sent to client
	unsigned int uses;
	int remote_id;
	time_t nextquerytime;
	unsigned short effect;  // 0 = Normal (display coords), 1 = Cash (remote open store)
	unsigned char type;  // 0 = Vending, 1 = Buying Store
	bool open;
};

bool searchstore_open(struct map_session_data *sd, unsigned int uses, unsigned short effect);
void searchstore_query(struct map_session_data *sd, unsigned char type, unsigned int min_price, unsigned int max_price, const unsigned short *itemlist, unsigned int item_count, const unsigned short *cardlist, unsigned int card_count);
bool searchstore_querynext(struct map_session_data *sd);
void searchstore_next(struct map_session_data *sd);
void searchstore_clear(struct map_session_data *sd);
void searchstore_close(struct map_session_data *sd);
void searchstore_click(struct map_session_data *sd, int account_id, int store_id, unsigned short nameid);
bool searchstore_queryremote(struct map_session_data *sd, int account_id);
void searchstore_clearremote(struct map_session_data *sd);
bool searchstore_result(struct map_session_data *sd, int store_id, int account_id, const char *store_name, unsigned short nameid, unsigned short amount, unsigned int price, const short *card, unsigned char refine);

#endif  // _SEARCHSTORE_H_
