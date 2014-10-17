DROP TABLE IF EXISTS `broadcast`;
CREATE TABLE IF NOT EXISTS `broadcast` (
  `ID__MSJ` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `last__broadcast` varchar(100) NOT NULL DEFAULT 'no se encontro mensaje',
  PRIMARY KEY (`ID__MSJ`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;

ALTER TABLE `login` ADD COLUMN `BG_DLALLOW` varchar(10) NOT NULL Default '0'
ALTER TABLE `login` ADD COLUMN `BLOCK_PJ` varchar(10) NOT NULL Default '0'

-- --------------------------------------------------------

DROP TABLE IF EXISTS `controlgm`;
CREATE TABLE IF NOT EXISTS `controlgm` (
  `id_gm` int(11) NOT NULL AUTO_INCREMENT,
  `gm_name` varchar(30) NOT NULL DEFAULT '0',
  `ip` varchar(60) NOT NULL DEFAULT '*.*.*',
  `mac` varchar(50) NOT NULL DEFAULT '*.*.*',
  PRIMARY KEY (`id_gm`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `item_transfer`;
CREATE TABLE IF NOT EXISTS `item_transfer` (
  `id_transfer` int(100) NOT NULL AUTO_INCREMENT,
  `char_name` varchar(50) NOT NULL,
  `char_id` int(100) NOT NULL,
  `item_id` int(100) NOT NULL,
  `guild` varchar(75) DEFAULT 'no encontrada',
  PRIMARY KEY (`id_transfer`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;