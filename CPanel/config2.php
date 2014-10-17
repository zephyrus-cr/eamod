<?php
	/* TerraOnline Control Panel - Projecto GaiaRO 4 */
	$CONFIG = array(
		// Server information
		'Name' => 		'Brawl Network',

		// Main Database Settings
		'DBHost' =>		'216.180.250.123',
		'DBUser' =>		'cerescp',
		'DBPass' =>		'f?IBn],~CuPB',
		'DBMain' =>		'ragnarok',
		'DBLogs' =>		'ragnarok',

		// Server Coneccion Settings
		'MapIP' =>	'216.180.250.123',
		'MapPort' =>	'5121',
		'CharIP' =>	'216.180.250.123',
		'CharPort' =>	'6121',
		'LoginIP' =>	'216.180.250.123',
		'LoginPort' =>	'6900',

		// Mail Settings
		'smtpServer' =>	'server405.webhostingpad.com',
		'smtpPort' =>	'2626',
		'smtpMail' =>	'cuentas@brawlnetwork.net',
		'smtpUser' =>	'cuentas@brawlnetwork.net',
		'smtpPass' =>	'PayRcwTfTt-y',

		// CP Settings
		'GMLevel' =>	99,

		// Char Settings
		'MaxChars' =>	12,

		// Downloads
		'Client' =>	'http://www.megaupload.com/?d=IFIYXHCZ',
		'Client2' =>	'ftp://ftp.terra-gaming.com/GSETUP_090126.exe',
		'FClient' =>	'http://www.megaupload.com/?d=8WEBUJFF',
		'FClient2' =>	'ftp://ftp.terra-gaming.com/GFULL_081113.exe',
	);

	extract($CONFIG, EXTR_PREFIX_ALL, "CONFIG");
?>