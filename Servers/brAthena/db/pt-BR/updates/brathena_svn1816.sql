-- Este script redefine todas as quests que foram feitas por seus usuários antes desta revisão
DELETE FROM `quest` WHERE `quest_id` > 5034 AND `quest_id` < 5055;
DELETE FROM `quest` WHERE `quest_id` > 9154 AND `quest_id` < 9166;
DELETE FROM `global_reg_value` WHERE `str` = 'dewata_gatti';
DELETE FROM `global_reg_value` WHERE `str` = 'dewata_legend';
DELETE FROM `global_reg_value` WHERE `str` = 'dewata_oldman';
