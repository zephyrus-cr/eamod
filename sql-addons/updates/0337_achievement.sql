-- Achievement System Database

DROP TABLE IF EXISTS `achievement`;
CREATE TABLE `achievement` (
  `id` int(11) NOT NULL,
  `char_id` int(11) NOT NULL,
  `completed` tinyint(1) unsigned NOT NULL default '0',
  `count1` int(11) unsigned NOT NULL default '0',
  `count2` int(11) unsigned NOT NULL default '0',
  `count3` int(11) unsigned NOT NULL default '0',
  `count4` int(11) unsigned NOT NULL default '0',
  `count5` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`char_id`,`id`)
) ENGINE=InnoDB;
