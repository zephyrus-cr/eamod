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
#include "../common/malloc.h"
#include "../common/nullpo.h"
#include "../common/strlib.h"
#include "../common/showmsg.h"
#include "../common/timer.h"
#include "../common/utils.h"

#include "faction.h"
#include "homunculus.h"
#include "map.h"
#include "mercenary.h"
#include "elemental.h"
#include "mob.h"
#include "npc.h"
#include "pc.h"
#include "pet.h"
#include "script.h"
#include "skill.h"

#include <string.h>
#include <stdio.h>
#include <stdlib.h>
#include <stdarg.h>

static DBMap* faction_db; // int faction_id -> struct faction_data*

//////////////////////////////////////////////////////////////
// CRC Tools - Maybe not needed...
//////////////////////////////////////////////////////////////
static unsigned int crc_table[256];

void make_crc_table(void)
{
	unsigned int crc, poly;
	int i, c;

	poly = 0xEDB88320;
	for( i = 0; i < 256; i++ )
	{
		crc = i;
		for( c = 0; c < 8; c++ )
			crc = (crc&1) ? poly ^ (crc >> 1) : crc >> 1;
		crc_table[i] = crc;
	}
}

unsigned int crc_32(char* dat, int len)
{
	register unsigned int crc;
	int i;
	crc = 0xFFFFFFFF;
	for( i = 0; i < len; i++ )
		crc = ((crc >> 8) & 0x00FFFFFF) ^ crc_table[(crc ^ *dat++)&0xFF];
	return (crc ^ 0xFFFFFFFF);
}

//////////////////////////////////////////////////////////////
// Language System
//////////////////////////////////////////////////////////////
static DBMap* lang_db; // int lang_id -> struct lang_data*
const int lang_pow[LANG_MAX] = { 0x1, 0x2, 0x4, 0x8, 0x10, 0x20, 0x40, 0x80, 0x100, 0x200, 0x400, 0x800, 0x1000, 0x2000, 0x4000, 0x8000 };

struct lang_data* lang_search(int lang_id)
{
	return (struct lang_data*)idb_get(lang_db,lang_id);
}

char* lang_convert(char* dst, const char* message, size_t size, int lang_id)
{
	struct lang_data* ld;

	if( size > 0 && lang_id && (ld = lang_search(lang_id)) != NULL && ld->max_len )
	{
		char word[LANG_MAX_CHARS+1];
		const char* p;
		int oi = 0, i = 0, j;

		p = message;
		while( p[i] && p[i] != '\0' && oi < size )
		{
			int len;

			// Build Words
			for( j = 0; j < ld->max_len && p[i] && p[i] != '\0' && !ISPUNCT(p[i]) && !ISSPACE(p[i]); j++, i++ )
				word[j] = p[i];
			for( ; j <= LANG_MAX_CHARS; j++ )
				word[j] = '\0'; // Clean the rest of the separated word
			if( (len = strlen(word)) > 0 )
			{
				int li = len - 1; // Convert to Index
				if( li >= ld->max_len ) li = ld->max_len - 1; // Should not happen, just in case...
				if( ld->count_words[li] > 0 )
				{
					char tmp[LANG_MAX_CHARS+1], *w;
					for( j = 0; j < len; j++ ) tmp[j] = TOLOWER(word[j]);
					for( ; j <= LANG_MAX_CHARS; j++ ) tmp[j] = '\0';
					// Calculate CRC32 to the Lowercase string, to avoid different Lang results from the same string...
					w = ld->words[li][(crc_32(tmp,len) % ld->count_words[li])];
					for( j = 0; j < len && oi < size; j++, oi++ )
					{
						if( ISUPPER(word[j]) )
							dst[oi] = TOUPPER(w[j]);
						else
							dst[oi] = TOLOWER(w[j]);
					}
				}
				else
				{
					ShowWarning("lang_convert: Not words found of length %d into the Lang Type %s(%d).\n",len,ld->name,ld->lang_id);
					for( j = 0; j < len && oi < size; j++, oi++ )
						dst[oi] = word[j]; // Just keep the original Word
				}
			}

			while( p[i] && p[i] != '\0' && (ISPUNCT(p[i]) || ISSPACE(p[i])) && oi < size )
				dst[oi++] = p[i++];
		}
		for( ; oi < size; oi++ ) dst[oi] = '\0';
	}
	else if( size > 0 )
		safestrncpy(dst,message,size); // Keep the Original Text

	return dst;
}

static bool faction_parse_row_lang(char* split[], int columns, int current)
{
	int i, id = atoi(split[0]);
	struct lang_data* ld;
	bool usable = true;

	if( id > LANG_MAX )
	{
		ShowWarning("faction_parse_row_lang: Lang id %d invalid. Use a value from 1 to %d.\n", id, LANG_MAX);
		return false;
	}
	if( lang_search(id) != NULL )
	{
		ShowWarning("faction_parse_row_lang: Lang id %d already exists.\n", id);
		return false;
	}

	CREATE(ld,struct lang_data,1);
	ld->lang_id = id;
	ld->max_len = 0;
	safestrncpy(ld->name,split[1],sizeof(ld->name));
	memset(ld->words,0,sizeof(ld->words));
	memset(ld->count_words,0,sizeof(ld->count_words));

	for( i = 2; i < columns; i++ )
	{
		int len = strlen(split[i]);
		if( len > LANG_MAX_CHARS )
		{
			ShowWarning("faction_parse_row_lang: Cannot add the word '%s'(len %d) to the Lang Table %d. Max length %d exceed.\n",split[i],len,id,LANG_MAX_CHARS);
			continue;
		}
		if( ld->count_words[len-1] >= LANG_MAX_WORDS )
		{
			ShowWarning("faction_parse_row_lang: Cannot add the word '%s'(len %d) to the Lang Table %d. Max words per word length is %d.\n",split[i],len,id,LANG_MAX_WORDS);
			continue;
		}

		ld->max_len = max(ld->max_len,len);
		ld->words[len-1][ld->count_words[len-1]] = aStrdup(split[i]);
		ld->count_words[len-1]++;
	}

	// Verification
	for( i = 0; i < ld->max_len; i++ )
	{
		if( ld->count_words[i] <= 0 )
		{
			ShowWarning("faction_parse_row_lang: Lang %s(%d) don't contains word of length %d. This language cannot be used until you add a mininum of 1.\n",ld->name,ld->lang_id,i+1);
			usable = false;
		}
	}

	if( !usable )
		ld->max_len = 0; // Block Language
	else if( !ld->max_len )
		ShowWarning("faction_parse_row_lang: Lang %s(%d) cannot be used. Include Words of different length to enable it.\n",ld->name,ld->lang_id);

	idb_put(lang_db,id,ld);
	return true;
}

static int lang_db_clear(DBKey key, DBData *data, va_list ap)
{
	int i, j;
	struct lang_data *ld = (struct lang_data *)db_data2ptr(data);

	for( i = 0; i < LANG_MAX_CHARS; i++ )
	{
		for( j = 0; j < LANG_MAX_WORDS; j++ )
		{
			if( ld->words[i][j] != NULL ) aFree(ld->words[i][j]);
		}
	}

	aFree(ld);
	return 0;
}
//////////////////////////////////////////////////////////////

struct faction_data* faction_search(int faction_id)
{
	return (struct faction_data*)idb_get(faction_db,faction_id);
}

int faction_get_alliance(struct block_list* bl)
{
	int id;
	struct faction_data* fd;

	if( bl && (id = status_get_faction_id(bl)) > 0 && (fd = faction_search(id)) != NULL )
		return fd->alliance_flag;

	return 0;
}

static int faction_db_clear(DBKey key, DBData *data, va_list ap)
{
	struct faction_data *fd = (struct faction_data *)db_data2ptr(data);
	if( fd->script )
	{
		script_free_code(fd->script);
		fd->script = NULL;
	}
	aFree(fd);
	return 0;
}

void faction_db_load(bool clear)
{
	char line[1024], path[256];
	int lines = 0, count = 0;
	struct faction_data* fd;
	FILE* fp;

	if( clear ) faction_db->clear(faction_db,faction_db_clear);

	sprintf(path, "%s/%s", db_path, "faction_db.txt");
	if( (fp = fopen(path,"r")) == NULL )
	{
		ShowWarning("faction_db_load: File not found \"%s\".\n", path);
		return;
	}

	while( fgets(line,sizeof(line),fp) )
	{
		char *str[10], *p;
		int i, id;

		lines++;
		if( line[0] == '/' && line[1] == '/' )
			continue;

		memset(str,0,sizeof(str));
		p = line;
		while( ISSPACE(*p) ) ++p; // Ignore white spaces
		if( *p == '\0' ) continue; // Empty Line

		// Read faction_id,Name,def_ele,ele_lv,size,race,fontcolor
		for( i = 0; i < 9; ++i )
		{
			str[i] = p;
			p = strchr(p,';');
			if( p == NULL ) break; // separator not found
			*p = '\0';
			++p;
		}

		id = atoi(str[0]);
		if( id <= 0 || id > FACTION_MAX )
		{
			ShowError("faction_db_load: Invalid Faction ID. Line %d of \"%s\" (faction with id %d), skipping.\n", lines, path, id);
			continue;
		}

		if( faction_search(id) != NULL )
		{
			ShowError("faction_db_load: Faction with ID %d already loaded. Line %d of \"%s\", skipping.\n", id, lines, path);
			continue;
		}

		if( p == NULL )
		{
			ShowError("faction_db_load: Insufficient columns in line %d of \"%s\" (faction with id %d), skipping.\n", lines, path, id);
			continue;
		}

		// Script
		if( *p != '{' )
		{
			ShowError("faction_db_load: Invalid format (Script column) in line %d of \"%s\" (faction with id %d), skipping.\n", lines, path, id);
			continue;
		}

		str[9] = p;

		CREATE(fd,struct faction_data,1);
		fd->faction_id = id;
		safestrncpy(fd->name,str[1],sizeof(fd->name));
		fd->race = atoi(str[2]);
		if( fd->race < RC_FORMLESS || fd->race > RC_DRAGON )
			fd->race = RC_DEMIHUMAN;

		fd->size = atoi(str[3]);
		if( fd->size < 0 || fd->size > 2 )
			fd->size = 1;

		fd->def_ele = atoi(str[4]);
		if( fd->def_ele < ELE_NEUTRAL || fd->def_ele > ELE_UNDEAD )
			fd->def_ele = ELE_NEUTRAL;

		fd->ele_lv = atoi(str[5]);
		if( fd->ele_lv < 1 || fd->ele_lv > 4 )
			fd->ele_lv = 1;

		fd->font_color = strtoul(str[6],NULL,0);
		fd->font_color = (fd->font_color & 0x0000FF) << 16 | (fd->font_color & 0x00FF00) | (fd->font_color & 0xFF0000) >> 16; // RGB to BGR
		fd->lang_id = atoi(str[7]);
		if( lang_search(fd->lang_id) == NULL ) fd->lang_id = 0;
		fd->alliance_flag = atoi(str[8]);

		fd->script = parse_script(str[9],path,lines,0);
		idb_put(faction_db,id,fd);
		count++;
	}

	fclose(fp);
	ShowStatus("Done reading '"CL_WHITE"%d"CL_RESET"' entries in '"CL_WHITE"%s"CL_RESET"'.\n",count,path);
}

void do_init_faction(void)
{
	make_crc_table();
	lang_db = idb_alloc(DB_OPT_BASE);
	sv_readdb(db_path, "lang_db.txt", ',', 3, 2 + (LANG_MAX_WORDS * LANG_MAX_CHARS), LANG_MAX, faction_parse_row_lang);
	faction_db = idb_alloc(DB_OPT_BASE);
	faction_db_load(false);
}

void do_final_faction(void)
{
	faction_db->destroy(faction_db,faction_db_clear);
	lang_db->destroy(lang_db,lang_db_clear);
}
