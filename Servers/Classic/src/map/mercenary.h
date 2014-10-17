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

#ifndef _MERCENARY_H_
#define _MERCENARY_H_

#include "status.h" // struct status_data, struct status_change
#include "unit.h" // struct unit_data

enum {
	ARCH_MERC_GUILD,
	SPEAR_MERC_GUILD,
	SWORD_MERC_GUILD,
};

struct s_mercenary_db {
	int class_;
	char sprite[NAME_LENGTH], name[NAME_LENGTH];
	unsigned short lv;
	short range2, range3;
	struct status_data status;
	struct view_data vd;
	struct {
		unsigned short id, lv;
	} skill[MAX_MERCSKILL];
};

extern struct s_mercenary_db mercenary_db[MAX_MERCENARY_CLASS];

struct mercenary_data {
	struct block_list bl;
	struct unit_data ud;
	struct view_data *vd;
	struct status_data base_status, battle_status;
	struct status_change sc;
	struct regen_data regen;

	struct s_mercenary_db *db;
	struct s_mercenary mercenary;
	char blockskill[MAX_SKILL];

	struct map_session_data *master;
	int contract_timer;
	
	unsigned devotion_flag : 1;
};

bool merc_class(int class_);
struct view_data * merc_get_viewdata(int class_);

int merc_create(struct map_session_data *sd, int class_, unsigned int lifetime);
int merc_data_received(struct s_mercenary *merc, bool flag);
int mercenary_save(struct mercenary_data *md);

void mercenary_damage(struct mercenary_data *md, struct block_list *src, int hp, int sp);
void mercenary_heal(struct mercenary_data *md, int hp, int sp);
int mercenary_dead(struct mercenary_data *md, struct block_list *src);

int merc_delete(struct mercenary_data *md, int reply);
void merc_contract_stop(struct mercenary_data *md);

int mercenary_get_lifetime(struct mercenary_data *md);
int mercenary_get_guild(struct mercenary_data *md);
int mercenary_get_faith(struct mercenary_data *md);
int mercenary_set_faith(struct mercenary_data *md, int value);
int mercenary_get_calls(struct mercenary_data *md);
int mercenary_set_calls(struct mercenary_data *md, int value);
int mercenary_kills(struct mercenary_data *md);

int mercenary_checkskill(struct mercenary_data *md, int skill_id);

int do_init_mercenary(void);

#endif /* _MERCENARY_H_ */
