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

#ifndef _BUYINGSTORE_H_
#define _BUYINGSTORE_H_

struct s_search_store_search;

#define MAX_BUYINGSTORE_SLOTS 5

struct s_buyingstore_item
{
	int price;
	unsigned short amount;
	unsigned short nameid;
};

struct s_buyingstore
{
	struct s_buyingstore_item items[MAX_BUYINGSTORE_SLOTS];
	int zenylimit;
	unsigned char slots;
};

bool buyingstore_setup(struct map_session_data* sd, unsigned char slots);
void buyingstore_create(struct map_session_data* sd, int zenylimit, unsigned char result, const char* storename, const uint8* itemlist, unsigned int count);
void buyingstore_close(struct map_session_data* sd);
void buyingstore_open(struct map_session_data* sd, int account_id);
void buyingstore_trade(struct map_session_data* sd, int account_id, unsigned int buyer_id, const uint8* itemlist, unsigned int count);
bool buyingstore_search(struct map_session_data* sd, unsigned short nameid);
bool buyingstore_searchall(struct map_session_data* sd, const struct s_search_store_search* s);

#endif  // _BUYINGSTORE_H_
