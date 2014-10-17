/*_________________________________________________________________________
 /                                                                         \
 |                  _           _   _   _                                  |
 |                 | |__  _ __ / \ | |_| |__   ___ _ __   __ _             |
 |                 | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |            |
 |                 | |_) | | / ___ \ |_| | | |  __/ | | | (_| |            |
 |                 |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|            |
 |                                                                         |
 |                       brAthena © 2013 - Database                        |
 |                   Convert tables of InnoDB to MyISAM.                   |
 \_________________________________________________________________________/
*/

ALTER TABLE `abra_db` ENGINE = MyISAM;
ALTER TABLE `auction` ENGINE = MyISAM;
ALTER TABLE `cart_inventory` ENGINE = MyISAM;
ALTER TABLE `castle_db` ENGINE = MyISAM;
ALTER TABLE `char` ENGINE = MyISAM;
ALTER TABLE `charlog` ENGINE = MyISAM;
ALTER TABLE `create_arrow_db` ENGINE = MyISAM;
ALTER TABLE `elemental_db` ENGINE = MyISAM;
ALTER TABLE `elemental_skill_db` ENGINE = MyISAM;
ALTER TABLE `friends` ENGINE = MyISAM;
ALTER TABLE `global_reg_value` ENGINE = MyISAM;
ALTER TABLE `guild` ENGINE = MyISAM;
ALTER TABLE `guild_alliance` ENGINE = MyISAM;
ALTER TABLE `guild_castle` ENGINE = MyISAM;
ALTER TABLE `guild_expulsion` ENGINE = MyISAM;
ALTER TABLE `guild_member` ENGINE = MyISAM;
ALTER TABLE `guild_position` ENGINE = MyISAM;
ALTER TABLE `guild_skill` ENGINE = MyISAM;
ALTER TABLE `guild_skill_tree_db` ENGINE = MyISAM;
ALTER TABLE `guild_storage` ENGINE = MyISAM;
ALTER TABLE `exp_guild_db` ENGINE = MyISAM;
ALTER TABLE `exp_homun_db` ENGINE = MyISAM;
ALTER TABLE `homunculus` ENGINE = MyISAM;
ALTER TABLE `homunculus_db` ENGINE = MyISAM;
ALTER TABLE `homun_skill_tree_db` ENGINE = MyISAM;
ALTER TABLE `hotkey` ENGINE = MyISAM;
ALTER TABLE `interlog` ENGINE = MyISAM;
ALTER TABLE `inventory` ENGINE = MyISAM;
ALTER TABLE `ipbanlist` ENGINE = MyISAM;
ALTER TABLE `item_avail_db` ENGINE = MyISAM;
ALTER TABLE `item_bluebox_db` ENGINE = MyISAM;
ALTER TABLE `item_bro` ENGINE = MyISAM;
ALTER TABLE `item_buyingstore_db` ENGINE = MyISAM;
ALTER TABLE `item_cardalbum_db` ENGINE = MyISAM;
ALTER TABLE `item_combo_db` ENGINE = MyISAM;
#ALTER TABLE `item_db` ENGINE = MyISAM;
ALTER TABLE `item_delay_db` ENGINE = MyISAM;
ALTER TABLE `item_findingore_db` ENGINE = MyISAM;
ALTER TABLE `item_giftbox_db` ENGINE = MyISAM;
ALTER TABLE `item_misc_db` ENGINE = MyISAM;
ALTER TABLE `item_noequip_db` ENGINE = MyISAM;
ALTER TABLE `item_stack_db` ENGINE = MyISAM;
ALTER TABLE `item_trade_db` ENGINE = MyISAM;
ALTER TABLE `item_violetbox_db` ENGINE = MyISAM;
ALTER TABLE `level_penalty` ENGINE = MyISAM;
ALTER TABLE `login` ENGINE = MyISAM;
ALTER TABLE `job_db1` ENGINE = MyISAM;
ALTER TABLE `job_db2` ENGINE = MyISAM;
ALTER TABLE `magicmushroom_db` ENGINE = MyISAM;
ALTER TABLE `mail` ENGINE = MyISAM;
ALTER TABLE `mapreg` ENGINE = MyISAM;
ALTER TABLE `memo` ENGINE = MyISAM;
ALTER TABLE `mercenary` ENGINE = MyISAM;
ALTER TABLE `mercenary_db` ENGINE = MyISAM;
ALTER TABLE `mercenary_owner` ENGINE = MyISAM;
ALTER TABLE `mercenary_skill_db` ENGINE = MyISAM;
ALTER TABLE `mob_avail_db` ENGINE = MyISAM;
ALTER TABLE `mob_boss_db` ENGINE = MyISAM;
ALTER TABLE `mob_branch_db` ENGINE = MyISAM;
ALTER TABLE `mob_chat_db` ENGINE = MyISAM;
ALTER TABLE `mob_classchange_db` ENGINE = MyISAM;
#ALTER TABLE `mob_db` ENGINE = MyISAM;
ALTER TABLE `mob_item_ratio_db` ENGINE = MyISAM;
ALTER TABLE `mob_poring_db` ENGINE = MyISAM;
ALTER TABLE `mob_pouch_db` ENGINE = MyISAM;
ALTER TABLE `mob_race2_db` ENGINE = MyISAM;
ALTER TABLE `mob_skill_db` ENGINE = MyISAM;
ALTER TABLE `party` ENGINE = MyISAM;
ALTER TABLE `pet` ENGINE = MyISAM;
ALTER TABLE `pet_db` ENGINE = MyISAM;
ALTER TABLE `produce_db` ENGINE = MyISAM;
ALTER TABLE `quest` ENGINE = MyISAM;
ALTER TABLE `quest_db` ENGINE = MyISAM;
ALTER TABLE `ragsrvinfo` ENGINE = MyISAM;
ALTER TABLE `refine_db` ENGINE = MyISAM;
ALTER TABLE `sc_data` ENGINE = MyISAM;
ALTER TABLE `size_fix_db` ENGINE = MyISAM;
ALTER TABLE `skill` ENGINE = MyISAM;
ALTER TABLE `skill_cast_db` ENGINE = MyISAM;
ALTER TABLE `skill_castnodex_db` ENGINE = MyISAM;
ALTER TABLE `skill_changematerial_db` ENGINE = MyISAM;
ALTER TABLE `skill_db` ENGINE = MyISAM;
ALTER TABLE `skill_homunculus` ENGINE = MyISAM;
ALTER TABLE `skill_improvise_db` ENGINE = MyISAM;
ALTER TABLE `skill_nocast_db` ENGINE = MyISAM;
ALTER TABLE `skill_reproduce_db` ENGINE = MyISAM;
ALTER TABLE `skill_require_db` ENGINE = MyISAM;
ALTER TABLE `skill_tree_db` ENGINE = MyISAM;
ALTER TABLE `skill_unit_db` ENGINE = MyISAM;
ALTER TABLE `spellbook_db` ENGINE = MyISAM;
ALTER TABLE `sstatus` ENGINE = MyISAM;
ALTER TABLE `statpoint_db` ENGINE = MyISAM;
ALTER TABLE `storage` ENGINE = MyISAM;