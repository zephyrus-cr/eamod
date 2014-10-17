-- This will add the agit_status column to your server's info table
-- Alone this won't do anything, but with the install/npc/agit_status.txt npc script loaded
-- You'll be able to display weather or not WoE is on or off in real time.

-- 
-- Table structure for table `ragsrvinfo`
-- 

DROP TABLE IF EXISTS `ragsrvinfo`;
CREATE TABLE IF NOT EXISTS `ragsrvinfo` (
  `index` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `exp` int(11) unsigned NOT NULL default '0',
  `jexp` int(11) unsigned NOT NULL default '0',
  `drop` int(11) unsigned NOT NULL default '0',
  `agit_status` tinyint(1) unsigned NOT NULL default '0',
  `motd` varchar(255) NOT NULL default '',
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
