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

#include "region.h"
#include "clif.h"
#include "guild.h"
#include "map.h"
#include "pc.h"
#include "script.h"
#include "status.h"
#include "mapreg.h"

#include <string.h>
#include <stdio.h>
#include <stdlib.h>
#include <stdarg.h>

static DBMap* region_db; // int region_id -> struct region_data*
DBMap* region_get_db() { return region_db; }

struct region_data* region_search(int region_id)
{
	return (struct region_data*)idb_get(region_db,region_id);
}

void region_set_guild(int region_id, int guild_id)
{
	struct region_data* rd = region_search(region_id);
	struct map_session_data* sd;
	struct guild* g;
	char output[256];
	int i;

	if( !rd || rd->guild_id == guild_id ) return;

	if( rd->script && (g = guild_search(rd->guild_id)) != NULL )
	{ // Effect from this region removed
		rd->guild_id = 0;
		for( i = 0; i < g->max_member; i++ )
		{
			if( (sd = g->member[i].sd) != NULL )
				status_calc_pc(sd,0);
		}

		snprintf(output,sizeof(output),"Your Guild lost control of [%s]",rd->name);
		clif_guild_message(g,0,output,strlen(output));
	}

	rd->guild_id = guild_id;
	if( rd->script && (g = guild_search(guild_id)) != NULL )
	{ // Effect from this region received
		for( i = 0; i < g->max_member; i++ )
		{
			if( (sd = g->member[i].sd) != NULL )
				status_calc_pc(sd,0);
		}

		snprintf(output,sizeof(output),"Your Guild gained control of [%s]",rd->name);
		clif_guild_message(g,0,output,strlen(output));
	}
}

void region_db_load_maps(void)
{
	char line[1024], path[256], map_name[1024];
	int i = 0, region_id = 0, count = 0;
	struct region_data* rd = NULL;
	FILE* fp;

	sprintf(path, "%s/%s", db_path, "region_map_db.txt");
	if( (fp = fopen(path,"r")) == NULL )
	{
		ShowWarning("region_db_load_maps: File not found \"%s\".\n", path);
		return;
	}

	while( fgets(line,sizeof(line),fp) )
	{
		if( line[0] == '\0' )
			continue; // Empty line
		if( line[0] == '/' && line[1] == '/' )
			continue; // Comments

		switch (sscanf(line, "%1023s\t%d", map_name, &i))
		{
			case 2: // Map with Region ID Given.
				if( (rd = region_search(i)) == NULL )
				{
					ShowError("region_db_load_maps: Invalid region ID %d received.\n",i);
					break; // Invalid Region ID
				}
				region_id = i;
			case 1: // Map without ID given
				if( !rd )
				{
					ShowError("region_db_load_maps: Ignoring map %s, no region data available.\n",map_name);
					break;
				}

				if( (i = map_mapname2mapid(map_name)) >= 0 )
				{
					map[i].region_id = region_id;
					rd->maps++;
					count++;
				}
				break;
			default: continue;
		}
	}

	fclose(fp);
	ShowStatus("Done reading '"CL_WHITE"%d"CL_RESET"' entries in '"CL_WHITE"region_map_db.txt"CL_RESET"'.\n", count);
}

void region_db_load_regions(void)
{
	char line[1024], path[256];
	int lines = 0, count = 0;
	struct region_data* rd;
	FILE* fp;

	sprintf(path, "%s/%s", db_path, "region_db.txt");
	if( (fp = fopen(path,"r")) == NULL )
	{
		ShowWarning("region_db_load_regions: File not found \"%s\".\n", path);
		return;
	}

	while( fgets(line,sizeof(line),fp) )
	{
		char *str[6], *p;
		int i, id;

		lines++;
		if( line[0] == '/' && line[1] == '/' )
			continue;

		memset(str,0,sizeof(str));
		p = line;
		while( ISSPACE(*p) ) ++p; // Ignore white spaces
		if( *p == '\0' ) continue; // Empty Line

		// Read Region_id,Name
		for( i = 0; i < 5; ++i )
		{
			str[i] = p;
			p = strchr(p,';');
			if( p == NULL ) break; // separator not found
			*p = '\0';
			++p;
		}

		id = atoi(str[0]);
		if( id <= 0 || id >= SCRIPT_MAX_ARRAYSIZE )
		{
			ShowError("region_db_load_regions: Region ID must be from 1 to %d ( SCRIPT_MAX_ARRAYSIZE - 1 on script.h ). Line %d of \"%s\" (region with id %d), skipping.\n", SCRIPT_MAX_ARRAYSIZE - 1, lines, path, id);
			continue;		
		}

		if( region_search(id) != NULL )
		{
			ShowError("region_db_load_regions: Region with ID %d already loaded. Line %d of \"%s\", skipping.\n", id, lines, path);
			continue;
		}

		if( p == NULL )
		{
			ShowError("region_db_load_regions: Insufficient columns in line %d of \"%s\" (region with id %d), skipping.\n", lines, path, id);
			continue;
		}

		// Script
		if( *p != '{' )
		{
			ShowError("region_db_load_regions: Invalid format (Script column) in line %d of \"%s\" (region with id %d), skipping.\n", lines, path, id);
			continue;
		}

		str[5] = p;

		CREATE(rd,struct region_data,1);
		rd->region_id = id;
		safestrncpy(rd->name,str[1],sizeof(rd->name));
		rd->script = parse_script(str[5],path,lines,0);
		rd->maps = 0;
		rd->users = 0;
		rd->bonus_bexp = atoi(str[2]);
		rd->bonus_jexp = atoi(str[3]);
		rd->bonus_drop = atoi(str[4]);
		rd->guild_id = 0;

		idb_put(region_db,id,rd);
		count++;
	}

	fclose(fp);
	ShowStatus("Done reading '"CL_WHITE"%d"CL_RESET"' entries in '"CL_WHITE"region_db.txt"CL_RESET"'.\n", count);
}

static int region_db_clear(DBKey key, DBData *data, va_list ap)
{
	struct region_data *rd = (struct region_data *)db_data2ptr(data);
	if( rd->script )
	{
		script_free_code(rd->script);
		rd->script = NULL;
	}
	aFree(rd);
	return 0;
}

static int region_db_guild(DBKey key, DBData *data, va_list ap)
{
	struct region_data *rd = (struct region_data *)db_data2ptr(data);
	int i = 0;

	if( rd && rd->region_id )
	{
		i = mapreg_readreg(add_str("$Region")+(i<<24));
		region_set_guild(rd->region_id,i);
	}

	return 0;
}

void region_db_load(bool clear)
{
	if( clear )
	{
		int i;
		for( i = 0; i < map_num; i++ ) map[i].region_id = 0;
		region_db->clear(region_db,region_db_clear);
	}

	region_db_load_regions();
	region_db_load_maps();
	region_db->foreach(region_db,region_db_guild);
}

void do_init_region(void)
{
	region_db = idb_alloc(DB_OPT_BASE);
	region_db_load(false);
}

void do_final_region(void)
{
	region_db->destroy(region_db,region_db_clear);
}
