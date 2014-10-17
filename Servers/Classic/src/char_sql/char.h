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

#ifndef _CHAR_SQL_H_
#define _CHAR_SQL_H_

#include "../common/core.h" // CORE_ST_LAST

#ifndef TXT_SQL_CONVERT
enum E_CHARSERVER_ST
{
	CHARSERVER_ST_RUNNING = CORE_ST_LAST,
	CHARSERVER_ST_SHUTDOWN,
	CHARSERVER_ST_LAST
};
#endif

struct mmo_charstatus;

#define MAX_MAP_SERVERS 30

#define DEFAULT_AUTOSAVE_INTERVAL 300*1000

enum {
	TABLE_INVENTORY,
	TABLE_CART,
	TABLE_STORAGE,
	TABLE_GUILD_STORAGE,
	TABLE_EXT_STORAGE,
};

int memitemdata_to_sql(const struct item items[], int max, int id, int tableswitch);

int mapif_sendall(unsigned char *buf,unsigned int len);
int mapif_sendallwos(int fd,unsigned char *buf,unsigned int len);
int mapif_send(int fd,unsigned char *buf,unsigned int len);

int char_married(int pl1,int pl2);
int char_child(int parent_id, int child_id);
int char_family(int pl1,int pl2,int pl3);

int request_accreg2(int account_id, int char_id);
int save_accreg2(unsigned char* buf, int len);

extern int char_name_option;
extern char char_name_letters[];
extern bool char_gm_read;
extern int autosave_interval;
extern int save_log;
extern char db_path[];
extern char char_db[256];
extern char scdata_db[256];
extern char cart_db[256];
extern char inventory_db[256];
extern char charlog_db[256];
extern char storage_db[256];
extern char rentstorage_db[256]; // [ZephStorage]
extern char interlog_db[256];
extern char reg_db[256];
extern char skill_db[256];
extern char memo_db[256];
extern char guild_db[256];
extern char guild_alliance_db[256];
extern char guild_castle_db[256];
extern char guild_expulsion_db[256];
extern char guild_member_db[256];
extern char guild_position_db[256];
extern char guild_skill_db[256];
extern char guild_storage_db[256];
extern char party_db[256];
extern char pet_db[256];
extern char mail_db[256];
extern char auction_db[256];
extern char quest_db[256];
extern char achievement_db[256];

extern int db_use_sqldbs; // added for sql item_db read for char server [Valaris]

extern int guild_exp_rate;
extern int log_inter;
extern int guild_base_members;
extern int guild_add_members;

//Exported for use in the TXT-SQL converter.
int mmo_char_tosql(int char_id, struct mmo_charstatus *p);
void sql_config_read(const char *cfgName);

#endif /* _CHAR_SQL_H_ */
