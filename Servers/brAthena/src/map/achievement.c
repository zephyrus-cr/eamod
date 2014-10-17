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

#include "achievement.h"
#include "atcommand.h"
#include "clif.h"
#include "itemdb.h"
#include "map.h"
#include "mob.h"
#include "npc.h"
#include "party.h"
#include "pc.h"
#include "pet.h"
#include "log.h"

#include <string.h>
#include <stdio.h>
#include <stdlib.h>
#include <stdarg.h>

static DBMap* achievement_db; // int id -> struct achievement_data*

struct achievement_data* achievement_search(int id)
{
	return (struct achievement_data*)idb_get(achievement_db,id);
}

int achievement_empty_slot(struct map_session_data* sd)
{
	int i;
	ARR_FIND(sd->achievement_count,ACHIEVEMENT_MAX,i,sd->achievement[i].id <= 0);
	if( i < ACHIEVEMENT_MAX ) return i;
	return -1;
}

int achievement_index(struct map_session_data* sd, int id)
{
	int i;
	ARR_FIND(0,sd->achievement_count,i,sd->achievement[i].id == id);
	if( i < sd->achievement_count ) return i;
	return achievement_empty_slot(sd);
}

static int achievement_delete_cutin_timer(int tid, unsigned int tick, int id, intptr_t data)
{
	struct map_session_data *sd;
	if( (sd = map_id2sd(id)) == NULL )
		return 1;

	if( sd->achievement_cutin_timer != tid )
	{
		ShowError("achievement_delete_cutin_timer: %d != %d.\n", sd->achievement_cutin_timer, tid);
		return 0;
	}

	sd->achievement_cutin_timer = INVALID_TIMER;
	clif_cutin(sd,"",255);
	return 0;
}

/*==========================================
 * Complete Achievement
 *------------------------------------------*/
void achievement_complete(struct map_session_data* sd, struct achievement_data* ad)
{
	int i, index;
	struct s_achievement* sad;
	char output[128];

	if( !sd || !ad ) return;
	index = achievement_index(sd,ad->id);
	if( index < 0 || sd->achievement[index].completed ) return;
	
	sad = &sd->achievement[index];
	sad->completed = true;
	sd->save_achievement = true;

	// Sync with Achievement DB
	for( i = 0; i < ad->objectives; i++ ) sad->count[i] = ad->ao[i].count;
	if( sad->id != ad->id )
	{ // New in the List
		sad->id = ad->id;
		sd->achievement_count++;
	}

	// Announcement
	sprintf(output,msg_txt(709),ad->name);
	clif_broadcast2(&sd->bl,output,strlen(output)+1,0x00CCFF,0x190,12,0,0,SELF);
	clif_specialeffect(&sd->bl,488,AREA);

	if( ad->cutin != NULL && *ad->cutin != '\0' )
	{
		clif_cutin(sd,ad->cutin,1);
		if( sd->achievement_cutin_timer != INVALID_TIMER )
			delete_timer(sd->achievement_cutin_timer,achievement_delete_cutin_timer);
		sd->achievement_cutin_timer = add_timer(gettick() + 5000,achievement_delete_cutin_timer,sd->bl.id,0);
	}

	// Rewards
	if( ad->bexp || ad->jexp ) pc_gainexp(sd,NULL,ad->bexp,ad->jexp,true);
	if( ad->nameid && ad->amount > 0 )
	{
		int flag;
		struct item it;
		int get_count;

		memset(&it, 0, sizeof(it));
		it.nameid = ad->nameid;
		it.identify = 1;
		get_count = ( itemdb_isstackable(ad->nameid) ? ad->amount : 1 );

		for( i = 0; i < ad->amount; i += get_count )
		{
			if( !pet_create_egg(sd,it.nameid) )
			{
				if( (flag = pc_additem(sd,&it,get_count,LOG_TYPE_SCRIPT)) )
				{
					clif_additem(sd,0,0,flag);
					if( pc_candrop(sd,&it) )
						map_addflooritem(&it,get_count,sd->bl.m,sd->bl.x,sd->bl.y,0,0,0,0,0);
				}
			}
		}
	}

	// Script Side
	if( ad->achieve_event[0] )
		npc_event(sd, ad->achieve_event, 0);

	// Check if this achievement is part of another Achievement set.
	achievement_validate_achievement(sd,ad->id);
}

/*==========================================
 * Main Achievement Check
 *------------------------------------------*/
static int achievement_validate(DBKey key, DBData *data, va_list ap)
{
	struct achievement_data* ad; // Link to Database
	struct s_achievement* sad;   // Link to Character Achievement
	struct map_session_data* sd;
	enum AchievementType type;
	int i, index;
	bool changed = false;

	if( (ad = (struct achievement_data *)db_data2ptr(data)) == NULL || (sd = va_arg(ap,struct map_session_data*)) == NULL )
		return 0;
	
	if( (type = (enum AchievementType)va_arg(ap,int)) < AT_SCRIPT || type >= AT_MAX )
		return 0;

	if( type == AT_MOB_KILL_CLASS && ad->type >= AT_MOB_KILL_CLASS && ad->type <= AT_MOB_CASTLE )
		; // Compatible with mob kill event
	else if( type != ad->type )
		return 0;

	index = achievement_index(sd,ad->id);
	if( index < 0 || sd->achievement[index].completed )
		return 0;

	sad = &sd->achievement[index];

	switch( ad->type )
	{
	case AT_EXPLORE:
		{
			int mapid = va_arg(ap,int);
			ARR_FIND(0,ad->objectives,i,mapid == ad->ao[i].value && ad->ao[i].count && sad->count[i] < ad->ao[i].count);
			if( i < ad->objectives ) { sad->count[i]++; changed = true; }
		}
		break;
	case AT_MOB_CASTLE:
		if( !map[sd->bl.m].flag.gvg_castle )
			break;
	case AT_MOB_KILL_CLASS:
	case AT_MOB_KILL_RACE:
	case AT_MOB_KILL_ELEM:
	case AT_MOB_KILL_SIZE:
		{
			int mob_id = va_arg(ap,int),
				killer_id = va_arg(ap,int);
			struct mob_db* mob;

			if( ad->type == AT_MOB_CASTLE && sd->bl.id != killer_id )
				break; // Achievement of Mob Castles don't work for party

			if( !mobdb_checkid(mob_id) ) return 0;
			mob = mob_db(mob_id);

			ARR_FIND(0,ad->objectives,i,ad->ao[i].count && sad->count[i] < ad->ao[i].count && (
				((ad->type == AT_MOB_KILL_CLASS || ad->type == AT_MOB_CASTLE) && ad->ao[i].value == mob->vd.class_) ||
				(ad->type == AT_MOB_KILL_RACE && ad->ao[i].value == mob->status.race) ||
				(ad->type == AT_MOB_KILL_ELEM && ad->ao[i].value == mob->status.def_ele) ||
				(ad->type == AT_MOB_KILL_SIZE && ad->ao[i].value == mob->status.size)));
			if( i < ad->objectives ) { sad->count[i]++; changed = true; }
		}
		break;
	case AT_PC_KILL:
	case AT_PC_DAMAGE_DONE:
		{
			ARR_FIND(0,ad->objectives,i,ad->ao[i].count && sad->count[i] < ad->ao[i].count && (
				(ad->ao[i].value == 0 && map[sd->bl.m].flag.pvp) ||
				(ad->ao[i].value == 1 && map_allowed_woe(sd->bl.m)) ||
				(ad->ao[i].value == 2 && map[sd->bl.m].flag.battleground) ||
				(ad->ao[i].value == 3 && sd->state.pvpmode) || ad->ao[i].value == 4));
			if( i < ad->objectives )
			{
				changed = true;
				if( ad->type == AT_PC_DAMAGE_DONE )
				{
					int damage = va_arg(ap,int);
					add2limit(sad->count[i],damage,ad->ao[i].count);
				}
				else sad->count[i]++;
			}
		}
		break;
	case AT_QUEST:
	case AT_ACHIEVEMENT:
		{
			int id = va_arg(ap,int);
			ARR_FIND(0,ad->objectives,i,ad->ao[i].count && sad->count[i] < ad->ao[i].count && ad->ao[i].value == id);
			if( i < ad->objectives ) { sad->count[i]++; changed = true; }
		}
		break;
	case AT_ZENY:
		{
			int sub_type = va_arg(ap,int),
				amount = va_arg(ap,int);
			ARR_FIND(0,ad->objectives,i,ad->ao[i].count && sad->count[i] < ad->ao[i].count && ad->ao[i].value == sub_type);
			if( i < ad->objectives )
			{
				if( sub_type == (int)ATZ_HAVE )
				{
					if( amount < ad->ao[i].count )
						break;
					sad->count[i] = ad->ao[i].count; // Direct achieve
				}
				else
					add2limit(sad->count[i],amount,ad->ao[i].count); // Acumulatives

				changed = true;
			}
		}
		break;
	case AT_ITEM_FIND:
	case AT_ITEM_HAVE:
	case AT_ITEM_EQUIP:
	case AT_ITEM_USE:
	case AT_ITEM_CONSUME:
		{
			struct item_data *it = va_arg(ap,struct item_data*);
			int amount = va_arg(ap,int);

			if( !it ) break;
			ARR_FIND(0,ad->objectives,i,ad->ao[i].count && sad->count[i] < ad->ao[i].count && (
				(ad->ao[i].value > 500 && ad->ao[i].value == it->nameid ) ||
				(ad->ao[i].value < IT_MAX && ad->ao[i].value == it->type)));
			if( i < ad->objectives )
			{
				if( ad->type == AT_ITEM_HAVE )
				{
					if( amount < ad->ao[i].count )
						break;
					sad->count[i] = ad->ao[i].count; // Direct achieve
				}
				else
					add2limit(sad->count[i],amount,ad->ao[i].count); // Acumulatives

				changed = true;
			}
		}
		break;
	case AT_BATTLEGROUND:
		{
			int sub_type = va_arg(ap,int),
				amount = va_arg(ap,int);

			ARR_FIND(0,ad->objectives,i,ad->ao[i].count && sad->count[i] < ad->ao[i].count && ad->ao[i].value == sub_type);
			if( i < ad->objectives )
			{
				add2limit(sad->count[i],amount,ad->ao[i].count);
				changed = true;
			}
		}
		break;
	}

	if( changed )
	{
		sd->save_achievement = true;
		if( !sad->id )
		{ // New Achievement!!
			sad->id = ad->id;
			sd->achievement_count++;
		}

		// Check if Achievement is completed
		ARR_FIND(0,ad->objectives,i,sad->count[i] < ad->ao[i].count);
		if( i >= ad->objectives ) achievement_complete(sd,ad);
	}

	return 1;
}

/*==========================================
 * Achievement Check Process by Type
 *------------------------------------------*/
void achievement_validate_explore(struct map_session_data* sd, int mapid)
{
	if( sd && mapid >= 0 ) achievement_db->foreach(achievement_db,achievement_validate,sd,(int)AT_EXPLORE,mapid);
}

int achievement_validate_mob_sub(struct block_list* bl, va_list ap)
{
	struct map_session_data *sd;
	int party_id, mob_id, killer_id;

	nullpo_ret(bl);
	nullpo_ret(sd = (struct map_session_data*)bl);
	party_id = va_arg(ap,int);
	mob_id = va_arg(ap,int);
	killer_id = va_arg(ap,int);

	if( sd->status.party_id != party_id )
		return 0;

	achievement_db->foreach(achievement_db,achievement_validate,sd,(int)AT_MOB_KILL_CLASS,mob_id,killer_id);
	return 1;
}

void achievement_validate_mob(struct map_session_data* sd, int mob_id)
{
	struct party_data* pd;

	if( !sd || mob_id <= 0 ) return;
	if( sd->status.party_id && (pd = party_search(sd->status.party_id)) != NULL )
		map_foreachinrange(achievement_validate_mob_sub,&sd->bl,AREA_SIZE,BL_PC,sd->status.party_id,mob_id,sd->bl.id);
	else
		achievement_db->foreach(achievement_db,achievement_validate,sd,(int)AT_MOB_KILL_CLASS,mob_id,sd->bl.id);
}

void achievement_validate_killer(struct map_session_data* sd)
{
	if( sd ) achievement_db->foreach(achievement_db,achievement_validate,sd,(int)AT_PC_KILL);
}

void achievement_validate_damage(struct map_session_data* sd, int damage)
{
	if( sd && damage > 0 ) achievement_db->foreach(achievement_db,achievement_validate,sd,(int)AT_PC_DAMAGE_DONE,damage);
}

void achievement_validate_quest(struct map_session_data* sd, int quest_id)
{
	if( sd && quest_id > 0 ) achievement_db->foreach(achievement_db,achievement_validate,sd,(int)AT_QUEST,quest_id);
}

void achievement_validate_achievement(struct map_session_data* sd, int achievement_id)
{
	if( sd && achievement_id > 0 ) achievement_db->foreach(achievement_db,achievement_validate,sd,(int)AT_ACHIEVEMENT,achievement_id);
}

void achievement_validate_zeny(struct map_session_data* sd, enum AchievementType_Zeny sub_type, int amount)
{
	if( sd && amount > 0 ) achievement_db->foreach(achievement_db,achievement_validate,sd,(int)AT_ZENY,(int)sub_type,amount);
}

void achievement_validate_item(struct map_session_data* sd, enum AchievementType type, int nameid, int amount)
{
	struct item_data* it;
	
	if( !sd || amount <= 0 || !(type >= AT_ITEM_FIND && type <= AT_ITEM_CONSUME) )
		return;
	if( (it = itemdb_exists(nameid)) == NULL )
		return;

	achievement_db->foreach(achievement_db,achievement_validate,sd,(int)type,it,amount);
}

void achievement_validate_bg(struct map_session_data* sd, enum AchievementType_BG sub_type, int amount)
{
	if( sd ) achievement_db->foreach(achievement_db,achievement_validate,sd,(int)AT_BATTLEGROUND,(int)sub_type,amount);
}

/*==========================================
 * Read Database
 * ID,Type,Name,Cutin,BExp,JExp,NameID,Amount,Event,<Parameter1>,<Count1>,...
 *------------------------------------------*/
static bool achievement_read_achievementdb(char* str[], int columns, int current)
{
	struct achievement_data ad, *newad;
	int i, c, value;

	ad.id = atoi(str[0]);
	if( idb_get(achievement_db,ad.id) != NULL )
	{
		ShowWarning("achievement_read_achievementdb: Already registered achievement ID %d.\n", ad.id);
		return false;
	}

	if( (ad.type = (enum AchievementType)atoi(str[1])) < AT_SCRIPT || ad.type >= AT_MAX )
	{
		ShowWarning("achievement_read_achievementdb: Invalid achievement type %d.\n", (int)ad.type);
		return false;
	}

	safestrncpy(ad.name, str[2], sizeof(ad.name));
	safestrncpy(ad.cutin, str[3], sizeof(ad.cutin));

	ad.bexp = atoi(str[4]);
	ad.jexp = atoi(str[5]);
	ad.nameid = atoi(str[6]);
	ad.amount = atoi(str[7]);

	safestrncpy(ad.achieve_event, str[8], sizeof(ad.achieve_event));

	memset(&ad.ao,0,sizeof(ad.ao));

	for( i = 9, c = 0; i < columns && str[i]; i += 2 )
	{
		switch( ad.type )
		{
		case AT_EXPLORE:
			value = map_mapname2mapid(str[i]);
			break;
		default:
			value = atoi(str[i]);
			break;
		}

		ad.ao[c].value = value;
		if( i + 1 < columns && str[i+1] ) ad.ao[c].count = atoi(str[i+1]);
		if( ad.ao[c].count <= 0 || ad.type == AT_ACHIEVEMENT || ad.type == AT_QUEST )
			ad.ao[c].count = 1;
		c++;
	}

	ad.objectives = c;
	CREATE(newad,struct achievement_data,1);
	memcpy(newad,&ad,sizeof(ad));
	idb_put(achievement_db,ad.id,newad);
	return true;
}

void achievement_db_load(bool clear)
{
	if( clear ) achievement_db->clear(achievement_db,NULL);
	sv_readdb(db_path, "achievement_db.txt", ',', 9, 9 + (ACHIEVEMENT_OBJETIVE_MAX * 2), -1, &achievement_read_achievementdb);
}

void do_init_achievement(void)
{
	achievement_db = idb_alloc(DB_OPT_RELEASE_DATA);
	add_timer_func_list(achievement_delete_cutin_timer, "achievement_delete_cutin_timer");
	achievement_db_load(false);
}

void do_final_achievement(void)
{
	achievement_db->destroy(achievement_db,NULL);
}
