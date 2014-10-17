-- Tierra Domination Ranking. Rev 352 eAmod A

ALTER TABLE `char_bg` ADD COLUMN `dom_bases` int(11) NOT NULL default '0' AFTER `boss_tie`,
ADD COLUMN `dom_off_kills` int(11) NOT NULL default '0' AFTER `dom_bases`,
ADD COLUMN `dom_def_kills` int(11) NOT NULL default '0' AFTER `dom_off_kills`,
ADD COLUMN `dom_wins` int(11) NOT NULL default '0' AFTER `dom_def_kills`,
ADD COLUMN `dom_lost` int(11) NOT NULL default '0' AFTER `dom_wins`,
ADD COLUMN `dom_tie` int(11) NOT NULL default '0' AFTER `dom_lost`;
