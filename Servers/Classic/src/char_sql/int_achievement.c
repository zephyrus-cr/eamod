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

#include "../common/db.h"
#include "../common/mmo.h"
#include "../common/socket.h"
#include "../common/sql.h"

#include "char.h"
#include "inter.h"
#include "int_achievement.h"

#include <stdio.h>
#include <string.h>
#include <stdlib.h>

//Load achievements for a character
int mapif_achievement_fromsql(int char_id, struct s_achievement ad[])
{
	int i;
	struct s_achievement tmp_ad;
	SqlStmt * stmt;

	stmt = SqlStmt_Malloc(sql_handle);
	if( stmt == NULL )
	{
		SqlStmt_ShowDebug(stmt);
		return 0;
	}

	memset(&tmp_ad,0,sizeof(tmp_ad));

	if( SQL_ERROR == SqlStmt_Prepare(stmt, "SELECT `id`, `completed`, `count1`, `count2`, `count3`, `count4`, `count5` FROM `%s` WHERE `char_id` = ? LIMIT %d", achievement_db, ACHIEVEMENT_MAX)
	||	SQL_ERROR == SqlStmt_BindParam(stmt, 0, SQLDT_INT, &char_id, 0)
	||	SQL_ERROR == SqlStmt_Execute(stmt)
	||	SQL_ERROR == SqlStmt_BindColumn(stmt, 0, SQLDT_INT,  &tmp_ad.id, 0, NULL, NULL)
	||	SQL_ERROR == SqlStmt_BindColumn(stmt, 1, SQLDT_CHAR, &tmp_ad.completed, 0, NULL, NULL)
	||	SQL_ERROR == SqlStmt_BindColumn(stmt, 2, SQLDT_INT,  &tmp_ad.count[0], 0, NULL, NULL)
	||	SQL_ERROR == SqlStmt_BindColumn(stmt, 3, SQLDT_INT,  &tmp_ad.count[1], 0, NULL, NULL)
	||	SQL_ERROR == SqlStmt_BindColumn(stmt, 4, SQLDT_INT,  &tmp_ad.count[2], 0, NULL, NULL)
	||	SQL_ERROR == SqlStmt_BindColumn(stmt, 5, SQLDT_INT,  &tmp_ad.count[3], 0, NULL, NULL)
	||	SQL_ERROR == SqlStmt_BindColumn(stmt, 6, SQLDT_INT,  &tmp_ad.count[4], 0, NULL, NULL) )
		SqlStmt_ShowDebug(stmt);

	for( i = 0; i < ACHIEVEMENT_MAX && SQL_SUCCESS == SqlStmt_NextRow(stmt); ++i )
		memcpy(&ad[i], &tmp_ad, sizeof(tmp_ad));

	SqlStmt_Free(stmt);
	return i;
}

//Delete Achievement
bool mapif_achievement_delete(int char_id, int id)
{
	if ( SQL_ERROR == Sql_Query(sql_handle, "DELETE FROM `%s` WHERE `id` = '%d' AND `char_id` = '%d'", achievement_db, id, char_id) )
	{
		Sql_ShowDebug(sql_handle);
		return false;
	}

	return true;
}

//Add Achievement
bool mapif_achievement_add(int char_id, struct s_achievement ad)
{
	if ( SQL_ERROR == Sql_Query(sql_handle, "INSERT INTO `%s` (`id`, `char_id`, `completed`, `count1`, `count2`, `count3`, `count4`, `count5`) VALUES ('%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d')", achievement_db, ad.id, char_id, ad.completed, ad.count[0], ad.count[1], ad.count[2], ad.count[3], ad.count[4]) )
	{
		Sql_ShowDebug(sql_handle);
		return false;
	}

	return true;
}

//Update Achievement
bool mapif_achievement_update(int char_id, struct s_achievement ad)
{
	if ( SQL_ERROR == Sql_Query(sql_handle, "UPDATE `%s` SET `completed`='%d', `count1`='%d', `count2`='%d', `count3`='%d', `count4`='%d', `count5`='%d' WHERE `id` = '%d' AND `char_id` = '%d'", achievement_db, ad.completed, ad.count[0], ad.count[1], ad.count[2], ad.count[3], ad.count[4], ad.id, char_id) )
	{
		Sql_ShowDebug(sql_handle);
		return false;
	}

	return true;
}

//Send Achievements to map server
int mapif_parse_achievement_load(int fd)
{
	int i, count, len, char_id = RFIFOL(fd,2);
	struct s_achievement tmp_ad[ACHIEVEMENT_MAX];

	memset(tmp_ad,0,sizeof(tmp_ad));
	count = mapif_achievement_fromsql(char_id,tmp_ad);
	len = count * sizeof(struct s_achievement) + 8;

	WFIFOHEAD(fd,len);
	WFIFOW(fd,0) = 0x385a;
	WFIFOW(fd,2) = len;
	WFIFOL(fd,4) = char_id;

	for( i = 0; i < count; i++ )
	{
		memcpy(WFIFOP(fd,(i*sizeof(struct s_achievement))+8),&tmp_ad[i], sizeof(struct s_achievement));
	}

	WFIFOSET(fd,len);
	return 0;
}

int mapif_parse_achievement_save(int fd)
{
	int char_id = RFIFOL(fd,4);
	struct s_achievement rec[ACHIEVEMENT_MAX], cur[ACHIEVEMENT_MAX];
	int i, j, rec_count, cur_count;
	bool success = true;

	// Load received Achievements
	memset(rec,0,sizeof(rec));
	if( (rec_count = (RFIFOW(fd,2) - 8) / sizeof(struct s_achievement)) > 0 )
		memcpy(&rec,RFIFOP(fd,8),RFIFOW(fd,2) - 8);

	// Load stored Achievements
	memset(cur,0,sizeof(cur));
	cur_count = mapif_achievement_fromsql(char_id,cur);

	for( i = 0; i < rec_count; i++ )
	{
		ARR_FIND(0,cur_count,j,rec[i].id == cur[j].id);
		if( j < cur_count )
		{ // Existing Achievement
			if( memcmp(&rec[i],&cur[j],sizeof(struct s_achievement)) )
				success &= mapif_achievement_update(char_id,rec[i]);

			if( j < (--cur_count) )
			{
				memmove(&cur[j],&cur[j+1],sizeof(struct s_achievement)*(cur_count-j));
				memset(&cur[cur_count],0,sizeof(struct s_achievement));
			}
		}
		else // New Achievement
			success &= mapif_achievement_add(char_id,rec[i]);
	}

	for( i = 0; i < cur_count; i++ ) // Delete Achievements not found in the received data
		success &= mapif_achievement_delete(char_id,cur[i].id);

	WFIFOHEAD(fd,7);
	WFIFOW(fd,0) = 0x385b;
	WFIFOL(fd,2) = char_id;
	WFIFOB(fd,6) = success?1:0;
	WFIFOSET(fd,7);

	return 0;
}

/*==========================================
 * Packets From Map Server
 *------------------------------------------*/
int inter_achievement_parse_frommap(int fd)
{
	switch(RFIFOW(fd,0))
	{
		case 0x305a: mapif_parse_achievement_load(fd); break;
		case 0x305b: mapif_parse_achievement_save(fd); break;
		default:
			return 0;
	}
	return 1;
}

int inter_achievement_sql_init(void)
{
	return 1;
}

void inter_achievement_sql_final(void)
{
	return;
}
