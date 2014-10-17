/*_________________________________________________________________________
 /                                                                         \
 |                  _           _   _   _                                  |
 |                 | |__  _ __ / \ | |_| |__   ___ _ __   __ _             |
 |                 | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |            |
 |                 | |_) | | / ___ \ |_| | | |  __/ | | | (_| |            |
 |                 |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|            |
 |                                                                         |
 |                       brAthena © 2013 - Banco de Dados                  |
 |                  Converte as tabelas de MyISAM para InnoDB              |
 \_________________________________________________________________________/
*/

ALTER TABLE `abra_db` ENGINE = InnoDB;
ALTER TABLE `auction` ENGINE = InnoDB;
ALTER TABLE `cart_inventory` ENGINE = InnoDB;
ALTER TABLE `castle_db` ENGINE = InnoDB;
ALTER TABLE `char` ENGINE = InnoDB;
ALTER TABLE `charlog` ENGINE = InnoDB;
ALTER TABLE `create_arrow_db` ENGINE = InnoDB;
ALTER TABLE `elemental_db` ENGINE = InnoDB;
ALTER TABLE `elemental_skill_db` ENGINE = InnoDB;
ALTER TABLE `friends` ENGINE = InnoDB;
ALTER TABLE `global_reg_value` ENGINE = InnoDB;
ALTER TABLE `guild` ENGINE = InnoDB;
ALTER TABLE `guild_alliance` ENGINE = InnoDB;
ALTER TABLE `guild_castle` ENGINE = InnoDB;
ALTER TABLE `guild_expulsion` ENGINE = InnoDB;
ALTER TABLE `guild_member` ENGINE = InnoDB;
ALTER TABLE `guild_position` ENGINE = InnoDB;
ALTER TABLE `guild_skill` ENGINE = InnoDB;
ALTER TABLE `guild_skill_tree_db` ENGINE = InnoDB;
ALTER TABLE `guild_storage` ENGINE = InnoDB;
ALTER TABLE `exp_guild_db` ENGINE = InnoDB;
ALTER TABLE `exp_homun_db` ENGINE = InnoDB;
ALTER TABLE `homunculus` ENGINE = InnoDB;
ALTER TABLE `homunculus_db` ENGINE = InnoDB;
ALTER TABLE `homun_skill_tree_db` ENGINE = InnoDB;
ALTER TABLE `hotkey` ENGINE = InnoDB;
ALTER TABLE `interlog` ENGINE = InnoDB;
ALTER TABLE `inventory` ENGINE = InnoDB;
ALTER TABLE `ipbanlist` ENGINE = InnoDB;
ALTER TABLE `item_avail_db` ENGINE = InnoDB;
ALTER TABLE `item_bluebox_db` ENGINE = InnoDB;
ALTER TABLE `item_bro` ENGINE = InnoDB;
ALTER TABLE `item_buyingstore_db` ENGINE = InnoDB;
ALTER TABLE `item_cardalbum_db` ENGINE = InnoDB;
ALTER TABLE `item_combo_db` ENGINE = InnoDB;
#ALTER TABLE `item_db` ENGINE = InnoDB;
ALTER TABLE `item_delay_db` ENGINE = InnoDB;
ALTER TABLE `item_findingore_db` ENGINE = InnoDB;
ALTER TABLE `item_giftbox_db` ENGINE = InnoDB;
ALTER TABLE `item_misc_db` ENGINE = InnoDB;
ALTER TABLE `item_noequip_db` ENGINE = InnoDB;
ALTER TABLE `item_stack_db` ENGINE = InnoDB;
ALTER TABLE `item_trade_db` ENGINE = InnoDB;
ALTER TABLE `item_violetbox_db` ENGINE = InnoDB;
ALTER TABLE `level_penalty` ENGINE = InnoDB;
ALTER TABLE `login` ENGINE = InnoDB;
ALTER TABLE `job_db1` ENGINE = InnoDB;
ALTER TABLE `job_db2` ENGINE = InnoDB;
ALTER TABLE `magicmushroom_db` ENGINE = InnoDB;
ALTER TABLE `mail` ENGINE = InnoDB;
ALTER TABLE `mapreg` ENGINE = InnoDB;
ALTER TABLE `memo` ENGINE = InnoDB;
ALTER TABLE `mercenary` ENGINE = InnoDB;
ALTER TABLE `mercenary_db` ENGINE = InnoDB;
ALTER TABLE `mercenary_owner` ENGINE = InnoDB;
ALTER TABLE `mercenary_skill_db` ENGINE = InnoDB;
ALTER TABLE `mob_avail_db` ENGINE = InnoDB;
ALTER TABLE `mob_boss_db` ENGINE = InnoDB;
ALTER TABLE `mob_branch_db` ENGINE = InnoDB;
ALTER TABLE `mob_chat_db` ENGINE = InnoDB;
ALTER TABLE `mob_classchange_db` ENGINE = InnoDB;
#ALTER TABLE `mob_db` ENGINE = InnoDB;
ALTER TABLE `mob_item_ratio_db` ENGINE = InnoDB;
ALTER TABLE `mob_poring_db` ENGINE = InnoDB;
ALTER TABLE `mob_pouch_db` ENGINE = InnoDB;
ALTER TABLE `mob_race2_db` ENGINE = InnoDB;
ALTER TABLE `mob_skill_db` ENGINE = InnoDB;
ALTER TABLE `party` ENGINE = InnoDB;
ALTER TABLE `pet` ENGINE = InnoDB;
ALTER TABLE `pet_db` ENGINE = InnoDB;
ALTER TABLE `produce_db` ENGINE = InnoDB;
ALTER TABLE `quest` ENGINE = InnoDB;
ALTER TABLE `quest_db` ENGINE = InnoDB;
ALTER TABLE `ragsrvinfo` ENGINE = InnoDB;
ALTER TABLE `refine_db` ENGINE = InnoDB;
ALTER TABLE `sc_data` ENGINE = InnoDB;
ALTER TABLE `size_fix_db` ENGINE = InnoDB;
ALTER TABLE `skill` ENGINE = InnoDB;
ALTER TABLE `skill_cast_db` ENGINE = InnoDB;
ALTER TABLE `skill_castnodex_db` ENGINE = InnoDB;
ALTER TABLE `skill_changematerial_db` ENGINE = InnoDB;
ALTER TABLE `skill_db` ENGINE = InnoDB;
ALTER TABLE `skill_homunculus` ENGINE = InnoDB;
ALTER TABLE `skill_improvise_db` ENGINE = InnoDB;
ALTER TABLE `skill_nocast_db` ENGINE = InnoDB;
ALTER TABLE `skill_reproduce_db` ENGINE = InnoDB;
ALTER TABLE `skill_require_db` ENGINE = InnoDB;
ALTER TABLE `skill_tree_db` ENGINE = InnoDB;
ALTER TABLE `skill_unit_db` ENGINE = InnoDB;
ALTER TABLE `spellbook_db` ENGINE = InnoDB;
ALTER TABLE `sstatus` ENGINE = InnoDB;
ALTER TABLE `statpoint_db` ENGINE = InnoDB;
ALTER TABLE `storage` ENGINE = InnoDB;