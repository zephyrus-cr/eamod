ALTER TABLE `char` ADD COLUMN `playtime` bigint(20) unsigned NOT NULL default '0';
ALTER TABLE `login` ADD COLUMN `ipallow` varchar(20) NOT NULL default '*.*.*.*';
ALTER TABLE `login` ADD COLUMN `member_id` int(11) unsigned NOT NULL default '0';

DROP TABLE IF EXISTS `char_pk`;
CREATE TABLE `char_pk` (
  `char_id` int(11) NOT NULL,
  `kill_count` int(11) NOT NULL default '0',
  `death_count` int(11) NOT NULL default '0',
  `score` int(11) NOT NULL default '0',
  PRIMARY KEY  (`char_id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `char_pvp`;
CREATE TABLE `char_pvp` (
  `char_id` int(11) NOT NULL,
  `kill_count` int(11) NOT NULL default '0',
  `death_count` int(11) NOT NULL default '0',
  `score` int(11) NOT NULL default '0',
  PRIMARY KEY  (`char_id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `guild_rank`;
CREATE TABLE `guild_rank` (
  `guild_id` int(11) NOT NULL,
  `castle_id` int(11) NOT NULL,
  `capture` int(11) unsigned NOT NULL default '0',
  `emperium` int(11) unsigned NOT NULL default '0',
  `treasure` int(11) unsigned NOT NULL default '0',
  `top_eco` int(11) unsigned NOT NULL default '0',
  `top_def` int(11) unsigned NOT NULL default '0',
  `invest_eco` int(11) unsigned NOT NULL default '0',
  `invest_def` int(11) unsigned NOT NULL default '0',
  `offensive_score` int(11) unsigned NOT NULL default '0',
  `defensive_score` int(11) unsigned NOT NULL default '0',
  `posesion_time` int(11) unsigned NOT NULL default '0',
  `zeny_eco` int(11) unsigned NOT NULL default '0',
  `zeny_def` int(11) unsigned NOT NULL default '0',
  
  `skill_battleorder` int(11) unsigned NOT NULL default '0',
  `skill_regeneration` int(11) unsigned NOT NULL default '0',
  `skill_restore` int(11) unsigned NOT NULL default '0',
  `skill_emergencycall` int(11) unsigned NOT NULL default '0',

  `off_kill` int(11) unsigned NOT NULL default '0',
  `off_death` int(11) unsigned NOT NULL default '0',
  `def_kill` int(11) unsigned NOT NULL default '0',
  `def_death` int(11) unsigned NOT NULL default '0',
  `ext_kill` int(11) unsigned NOT NULL default '0',
  `ext_death` int(11) unsigned NOT NULL default '0',
  `ali_kill` int(11) unsigned NOT NULL default '0',
  `ali_death` int(11) unsigned NOT NULL default '0',
  
  PRIMARY KEY  (`guild_id`,`castle_id`),
  KEY `castle_id` (`castle_id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `ippremium`;
CREATE TABLE `ippremium` (
  `ip` varchar(30) NOT NULL,
  `level` tinyint(2) default '0',
  PRIMARY KEY  (`ip`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `member_id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL default '',
  `email` varchar(39) NOT NULL default '',
  `sexo` enum('M','F') NOT NULL default 'M',
  `pais` varchar(20) NOT NULL default '',
  `msn` varchar(39) NOT NULL default '',
  `icq` varchar(15) NOT NULL default '',
  `mpass` varchar(40) NOT NULL default '',
  `last_ip` varchar(20) NOT NULL default '0.0.0.0',
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `acc_balance` int(10) unsigned NOT NULL default '0',
  `services` smallint(5) unsigned NOT NULL default '0',
  `banned` tinyint(1) unsigned NOT NULL default '0',
  `ref_option` tinyint(3) unsigned NOT NULL default '0',
  `ref_email` varchar(39) NOT NULL default 'none',
  `ref_points` smallint(5) unsigned NOT NULL default '0',
  `mlevel` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`member_id`)
) ENGINE=InnoDB;

--
-- Table structure for table `picklog` 
--

DROP TABLE IF EXISTS `rentstorage`;
CREATE TABLE `rentstorage` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `account_id` int(11) unsigned NOT NULL default '0',
  `nameid` int(11) unsigned NOT NULL default '0',
  `amount` smallint(11) unsigned NOT NULL default '0',
  `equip` mediumint(8) unsigned NOT NULL default '0',
  `identify` smallint(6) unsigned NOT NULL default '0',
  `refine` tinyint(3) unsigned NOT NULL default '0',
  `attribute` tinyint(4) unsigned NOT NULL default '0',
  `card0` smallint(11) NOT NULL default '0',
  `card1` smallint(11) NOT NULL default '0',
  `card2` smallint(11) NOT NULL default '0',
  `card3` smallint(11) NOT NULL default '0',
  `expire_time` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `serial` int(11) unsigned NOT NULL default '0',
  `bound` tinyint(1) UNSIGNED NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB;

--
-- Table structure for table `skillcooldown`
--

CREATE TABLE IF NOT EXISTS `skillcooldown` (
  `account_id` int(11) unsigned NOT NULL,
  `char_id` int(11) unsigned NOT NULL,
  `skill` smallint(11) unsigned NOT NULL default '0',
  `tick` int(11) NOT NULL,
  KEY (`account_id`),
  KEY (`char_id`)
) ENGINE=InnoDB;

--
-- Account Bound System. Rev. 172 eAmod A
--

ALTER TABLE `inventory` ADD COLUMN `bound` tinyint(1) UNSIGNED NOT NULL default '0';
ALTER TABLE `cart_inventory` ADD COLUMN `bound` tinyint(1) UNSIGNED NOT NULL default '0';
ALTER TABLE `storage` ADD COLUMN `bound` tinyint(1) UNSIGNED NOT NULL default '0';
ALTER TABLE `guild_storage` ADD COLUMN `bound` tinyint(1) UNSIGNED NOT NULL default '0';

--
-- Item Serialization Update. Rev. 177 eAmod A
--

DROP TABLE IF EXISTS `item_serials`;
CREATE TABLE `item_serials` (
  `nameid` smallint(5) unsigned NOT NULL,
  `serial` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`nameid`)
) ENGINE=InnoDB;

-- New Serial format - size reduced
ALTER TABLE `auction` ADD COLUMN `serial` int(11) unsigned NOT NULL default '0';
ALTER TABLE `cart_inventory` ADD COLUMN `serial`  int(11) unsigned NOT NULL default '0';
ALTER TABLE `guild_storage` ADD COLUMN `serial`  int(11) unsigned NOT NULL default '0';
ALTER TABLE `inventory` ADD COLUMN `serial`  int(11) unsigned NOT NULL default '0';
ALTER TABLE `mail` ADD COLUMN `serial`  int(11) unsigned NOT NULL default '0';
ALTER TABLE `storage` ADD COLUMN `serial`  int(11) unsigned NOT NULL default '0';

--
-- Added Elemental DB from 3CeAM
--

DROP TABLE IF EXISTS `elemental`;
CREATE TABLE `elemental` (
  `ele_id` int(11) unsigned NOT NULL auto_increment,
  `char_id` int(11) NOT NULL,
  `class` mediumint(9) unsigned NOT NULL default '0',
  `mode` int(11) unsigned NOT NULL default '1',
  `hp` int(12) NOT NULL default '1',
  `sp` int(12) NOT NULL default '1',
  `life_time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ele_id`)
) ENGINE=InnoDB;

ALTER TABLE `char` ADD COLUMN `elemental_id` INTEGER UNSIGNED NOT NULL DEFAULT '0' AFTER `homun_id`;

DROP TABLE IF EXISTS `char_bg`;
CREATE TABLE `char_bg` (
  `char_id` int(11) NOT NULL,
  `top_damage` int(11) NOT NULL default '0',
  `damage_done` int(11) NOT NULL default '0',
  `damage_received` int(11) NOT NULL default '0',
  `skulls` int(11) NOT NULL default '0',
  `ti_wins` int(11) NOT NULL default '0',
  `ti_lost` int(11) NOT NULL default '0',
  `ti_tie` int(11) NOT NULL default '0',
  `eos_flags` int(11) NOT NULL default '0',
  `eos_bases` int(11) NOT NULL default '0',
  `eos_wins` int(11) NOT NULL default '0',
  `eos_lost` int(11) NOT NULL default '0',
  `eos_tie` int(11) NOT NULL default '0',
  `boss_killed` int(11) NOT NULL default '0',
  `boss_damage` int(11) NOT NULL default '0',
  `boss_flags` int(11) NOT NULL default '0',
  `boss_wins` int(11) NOT NULL default '0',
  `boss_lost` int(11) NOT NULL default '0',
  `boss_tie` int(11) NOT NULL default '0',
  `td_kills` int(11) NOT NULL default '0',
  `td_deaths` int(11) NOT NULL default '0',
  `td_wins` int(11) NOT NULL default '0',
  `td_lost` int(11) NOT NULL default '0',
  `td_tie` int(11) NOT NULL default '0',
  `sc_stole` int(11) NOT NULL default '0',
  `sc_captured` int(11) NOT NULL default '0',
  `sc_droped` int(11) NOT NULL default '0',
  `sc_wins` int(11) NOT NULL default '0',
  `sc_lost` int(11) NOT NULL default '0',
  `sc_tie` int(11) NOT NULL default '0',
  `ctf_taken` int(11) NOT NULL default '0',
  `ctf_captured` int(11) NOT NULL default '0',
  `ctf_droped` int(11) NOT NULL default '0',
  `ctf_wins` int(11) NOT NULL default '0',
  `ctf_lost` int(11) NOT NULL default '0',
  `ctf_tie` int(11) NOT NULL default '0',
  `emperium_kill` int(11) NOT NULL default '0',
  `barricade_kill` int(11) NOT NULL default '0',
  `gstone_kill` int(11) NOT NULL default '0',
  `cq_wins` int(11) NOT NULL default '0',
  `cq_lost` int(11) NOT NULL default '0',
  `kill_count` int(11) NOT NULL default '0',
  `death_count` int(11) NOT NULL default '0',
  `win` int(11) NOT NULL default '0',
  `lost` int(11) NOT NULL default '0',
  `tie` int(11) NOT NULL default '0',
  `leader_win` int(11) NOT NULL default '0',
  `leader_lost` int(11) NOT NULL default '0',
  `leader_tie` int(11) NOT NULL default '0',
  `deserter` int(11) NOT NULL default '0',
  `score` int(11) NOT NULL default '0',
  `points` int(11) NOT NULL default '0',
  `sp_heal_potions` int(11) NOT NULL default '0',
  `hp_heal_potions` int(11) NOT NULL default '0',
  `yellow_gemstones` int(11) NOT NULL default '0',
  `red_gemstones` int(11) NOT NULL default '0',
  `blue_gemstones` int(11) NOT NULL default '0',
  `poison_bottles` int(11) NOT NULL default '0',
  `acid_demostration` int(11) NOT NULL default '0',
  `acid_demostration_fail` int(11) NOT NULL default '0',
  `support_skills_used` int(11) NOT NULL default '0',
  `healing_done` int(11) NOT NULL default '0',
  `wrong_support_skills_used` int(11) NOT NULL default '0',
  `wrong_healing_done` int(11) NOT NULL default '0',
  `sp_used` int(11) NOT NULL default '0',
  `zeny_used` int(11) NOT NULL default '0',
  `spiritb_used` int(11) NOT NULL default '0',
  `ammo_used` int(11) NOT NULL default '0',
  `rank_points` int(11) NOT NULL default '0',
  `rank_games` int(11) NOT NULL default '0',
  `ru_captures` int(11) NOT NULL default '0',
  `ru_wins` int(11) NOT NULL default '0',
  `ru_lost` int(11) NOT NULL default '0',
PRIMARY KEY  (`char_id`)
) ENGINE=InnoDB;

ALTER TABLE `char` ADD COLUMN `bg_gold` int(11) NOT NULL default '0';
ALTER TABLE `char` ADD COLUMN `bg_silver` int(11) NOT NULL default '0';
ALTER TABLE `char` ADD COLUMN `bg_bronze` int(11) NOT NULL default '0';

--
-- New Kill Log Update. Rev. 183 eAmod A
--

DROP TABLE IF EXISTS `char_bg_log`;
CREATE TABLE `char_bg_log` (
  `id` int(11) NOT NULL auto_increment,
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `killer` varchar(25) NOT NULL,
  `killer_id` int(11) NOT NULL,
  `killed` varchar(25) NOT NULL,
  `killed_id` int(11) NOT NULL,
  `map` varchar(11) NOT NULL default '',
  `skill` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `killer_id` (`killer_id`),
  KEY `killed_id` (`killed_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `char_woe_log`;
CREATE TABLE `char_woe_log` (
  `id` int(11) NOT NULL auto_increment,
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `killer` varchar(25) NOT NULL,
  `killer_id` int(11) NOT NULL,
  `killed` varchar(25) NOT NULL,
  `killed_id` int(11) NOT NULL,
  `map` varchar(11) NOT NULL default '',
  `skill` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `killer_id` (`killer_id`),
  KEY `killed_id` (`killed_id`)
) ENGINE=MyISAM;

--
-- New Kill Log Update. Rev. 186 eAmod A
--

DROP TABLE IF EXISTS `char_woe`;
DROP TABLE IF EXISTS `char_wstats`;
CREATE TABLE `char_wstats` (
  `char_id` int(11) NOT NULL,
  `kill_count` int(11) NOT NULL default '0',
  `death_count` int(11) NOT NULL default '0',
  `score` int(11) NOT NULL default '0',
  `top_damage` int(11) NOT NULL default '0',
  `damage_done` int(11) NOT NULL default '0',
  `damage_received` int(11) NOT NULL default '0',
  `emperium_damage` int(11) NOT NULL default '0',
  `guardian_damage` int(11) NOT NULL default '0',
  `barricade_damage` int(11) NOT NULL default '0',
  `gstone_damage` int(11) NOT NULL default '0',
  `emperium_kill` int(11) NOT NULL default '0',
  `guardian_kill` int(11) NOT NULL default '0',
  `barricade_kill` int(11) NOT NULL default '0',
  `gstone_kill` int(11) NOT NULL default '0',
  `sp_heal_potions` int(11) NOT NULL default '0',
  `hp_heal_potions` int(11) NOT NULL default '0',
  `yellow_gemstones` int(11) NOT NULL default '0',
  `red_gemstones` int(11) NOT NULL default '0',
  `blue_gemstones` int(11) NOT NULL default '0',
  `poison_bottles` int(11) NOT NULL default '0',
  `acid_demostration` int(11) NOT NULL default '0',
  `acid_demostration_fail` int(11) NOT NULL default '0',
  `support_skills_used` int(11) NOT NULL default '0',
  `healing_done` int(11) NOT NULL default '0',
  `wrong_support_skills_used` int(11) NOT NULL default '0',
  `wrong_healing_done` int(11) NOT NULL default '0',
  `sp_used` int(11) NOT NULL default '0',
  `zeny_used` int(11) NOT NULL default '0',
  `spiritb_used` int(11) NOT NULL default '0',
  `ammo_used` int(11) NOT NULL default '0',
  PRIMARY KEY  (`char_id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `skill_count`;
CREATE TABLE `skill_count` (
  `char_id` int(11) unsigned NOT NULL default '0',
  `id` smallint(11) unsigned NOT NULL default '0',
  `count` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`char_id`,`id`),
  KEY `char_id` (`char_id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `bg_skill_count`;
CREATE TABLE `bg_skill_count` (
  `char_id` int(11) unsigned NOT NULL default '0',
  `id` smallint(11) unsigned NOT NULL default '0',
  `count` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`char_id`,`id`),
  KEY `char_id` (`char_id`)
) ENGINE=InnoDB;


--
-- Elemental Table updates from 3CeAM. Rev 218 eAmod A
--

ALTER TABLE `elemental` ADD `max_hp` MEDIUMINT( 8 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `sp` ,
ADD `max_sp` MEDIUMINT( 6 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `max_hp` ,
ADD `str` SMALLINT( 4 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `max_sp` ,
ADD `agi` SMALLINT( 4 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `str` ,
ADD `vit` SMALLINT( 4 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `agi` ,
ADD `int` SMALLINT( 4 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `vit` ,
ADD `dex` SMALLINT( 4 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `int` ,
ADD `luk` SMALLINT( 4 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `dex` ;
