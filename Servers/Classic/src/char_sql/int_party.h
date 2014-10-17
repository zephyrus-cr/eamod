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

#ifndef _INT_PARTY_SQL_H_
#define _INT_PARTY_SQL_H_

//Party Flags on what to save/delete.
//Create a new party entry (index holds leader's info) 
#define PS_CREATE 0x01
//Update basic party info.
#define PS_BASIC 0x02
//Update party's leader
#define PS_LEADER 0x04
//Specify new party member (index specifies which party member)
#define PS_ADDMEMBER 0x08
//Specify member that left (index specifies which party member)
#define PS_DELMEMBER 0x10
//Specify that this party must be deleted.
#define PS_BREAK 0x20

struct party;

int inter_party_parse_frommap(int fd);
int inter_party_sql_init(void);
void inter_party_sql_final(void);
int inter_party_leave(int party_id,int account_id, int char_id);
int inter_party_CharOnline(int char_id, int party_id);
int inter_party_CharOffline(int char_id, int party_id);
//Required for the TXT->SQL converter
int inter_party_tosql(struct party *p, int flag, int index);

#endif /* _INT_PARTY_SQL_H_ */
