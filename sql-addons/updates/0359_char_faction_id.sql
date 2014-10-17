-- Faction System. Rev 359 eAmod A

ALTER TABLE `char` ADD COLUMN `faction_id` int(11) NOT NULL default '0' AFTER `elemental_id`;
