CREATE TABLE IF NOT EXISTS `level_penalty` (
  `Type` int(11) unsigned NOT NULL DEFAULT '0',
  `Race` smallint(4) unsigned NOT NULL DEFAULT '0',
  `Level difference` text NOT NULL,
  `Rate` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Exp and Drop Rate
-- Type,Race,Level difference,Rate
-- TYPE:
--  1=Exp, 2= Item drop
-- RACE:
--   0=Formless, 1=Undead, 2=Brute, 3=Plant, 4=Insect,
--   5=Fish, 6=Demon, 7=Demi-Human, 8=Angel, 9=Dragon, 
--   10=Boss monsters, 11=Normal monsters
-- Note: RENEWAL_DROP or RENEWAL_EXP need be enabled.

-- EXP Modifiers.
REPLACE INTO `level_penalty` VALUES (1, 11 ,'16',40);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'15',115);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'14',120);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'13',125);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'12',130);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'11',135);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'10',140);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'9',135);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'8',130);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'7',125);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'6',120);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'5',115);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'4',110);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'3',105);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'0',100);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'11',100);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'-6',95);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'-11',90);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'-16',85);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'-21',60);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'-26',35);
REPLACE INTO `level_penalty` VALUES (1, 11 ,'-31',10);
-- Type of Boss
REPLACE INTO `level_penalty` VALUES (1, 10 ,'0',100);
REPLACE INTO `level_penalty` VALUES (2, 11 ,'16',50);
REPLACE INTO `level_penalty` VALUES (2, 11 ,'13',60);
REPLACE INTO `level_penalty` VALUES (2, 11 ,'10',70);
REPLACE INTO `level_penalty` VALUES (2, 11 ,'7',80);
REPLACE INTO `level_penalty` VALUES (2, 11 ,'4',90);
REPLACE INTO `level_penalty` VALUES (2, 11 ,'0',100);
REPLACE INTO `level_penalty` VALUES (2, 11 ,'-4',90);
REPLACE INTO `level_penalty` VALUES (2, 11 ,'-7',80);
REPLACE INTO `level_penalty` VALUES (2, 11 ,'-10',70);
REPLACE INTO `level_penalty` VALUES (2, 11 ,'-13',60);
REPLACE INTO `level_penalty` VALUES (2, 11 ,'-16',50);
-- Type of Boss
REPLACE INTO `level_penalty` VALUES (2, 10 ,'0',100);
