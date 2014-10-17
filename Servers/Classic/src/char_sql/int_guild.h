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

#ifndef _INT_GUILD_SQL_H_
#define _INT_GUILD_SQL_H_

#define GS_BASIC 0x0001
#define GS_MEMBER 0x0002
#define GS_POSITION 0x0004
#define GS_ALLIANCE 0x0008
#define GS_EXPULSION 0x0010
#define GS_SKILL 0x0020
#define GS_EMBLEM 0x0040
#define GS_CONNECT 0x0080
#define GS_LEVEL 0x0100
#define GS_MES 0x0200
#define GS_RANKING 0x0400
#define GS_MASK 0x07FF
#define GS_BASIC_MASK (GS_BASIC | GS_EMBLEM | GS_CONNECT | GS_LEVEL | GS_MES)
#define GS_REMOVE 0x8000

struct guild;
struct guild_castle;

int inter_guild_parse_frommap(int fd);
int inter_guild_sql_init(void);
void inter_guild_sql_final(void);
int inter_guild_mapif_init(int fd);
int inter_guild_leave(int guild_id,int account_id,int char_id);
int mapif_parse_BreakGuild(int fd,int guild_id);
int inter_guild_broken(int guild_id);
int inter_guild_sex_changed(int guild_id,int account_id,int char_id, short gender);
int inter_guild_charname_changed(int guild_id,int account_id, int char_id, char *name);
int inter_guild_CharOnline(int char_id, int guild_id);
int inter_guild_CharOffline(int char_id, int guild_id);

//For the TXT->SQL converter.
int inter_guild_tosql(struct guild *g,int flag);
int inter_guildcastle_tosql(struct guild_castle *gc);

#endif /* _INT_GUILD_SQL_H_ */
