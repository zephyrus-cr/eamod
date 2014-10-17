--
-- Favorite Item Tab. Rev. 378 eAmod A
--

ALTER TABLE `inventory` ADD COLUMN `favorite` tinyint(1) UNSIGNED NOT NULL default '0';
ALTER TABLE `cart_inventory` ADD COLUMN `favorite` tinyint(1) UNSIGNED NOT NULL default '0';
ALTER TABLE `storage` ADD COLUMN `favorite` tinyint(1) UNSIGNED NOT NULL default '0';
ALTER TABLE `rentstorage` ADD COLUMN `favorite` tinyint(1) UNSIGNED NOT NULL default '0';
ALTER TABLE `guild_storage` ADD COLUMN `favorite` tinyint(1) UNSIGNED NOT NULL default '0';