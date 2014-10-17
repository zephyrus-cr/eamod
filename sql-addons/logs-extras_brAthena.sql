DROP TABLE IF EXISTS `picklog`;
CREATE TABLE `picklog` (
  `id` int(11) NOT NULL auto_increment,
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `account_id` int(11) NOT NULL default '0',
  `char_id` int(11) NOT NULL default '0',
  `name` varchar(25) NOT NULL,
  `type` enum('M','P','L','T','V','S','N','C','A','R','G','E','B','O','I','X','D','U') NOT NULL default 'P',
  `nameid` int(11) NOT NULL default '0',
  `amount` int(11) NOT NULL default '1',
  `refine` tinyint(3) unsigned NOT NULL default '0',
  `card0` int(11) NOT NULL default '0',
  `card1` int(11) NOT NULL default '0',
  `card2` int(11) NOT NULL default '0',
  `card3` int(11) NOT NULL default '0',
  `unique_id` bigint(20) unsigned NOT NULL default '0',
  `map` varchar(11) NOT NULL default '',
  `serial` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  INDEX (`type`),
  INDEX (`account_id`),
  INDEX (`char_id`),
  INDEX (`nameid`)
) ENGINE=MyISAM;

--
-- Removal of Serial Columns as rAthena implemented their own version. Assembla Rev. 21
--

ALTER TABLE `picklog` DROP COLUMN `serial`;
