<?php
	/* TerraOnline Control Panel - Projecto GaiaRO 4 */
	$CONFIG = array(
		// Server information
		'Name' => 		'Evangelis RO',

		// Main Database Settings
		'DBHost' =>		'127.0.0.1',
		'DBUser' =>		'dbuser',
		'DBPass' =>		'dbpassword',
		'DBMain' =>		'main',
		'DBLogs' =>		'logs',

		// Server Coneccion Settings
		'MapIP' =>		'127.0.0.1',
		'MapPort' =>	'5121',
		'CharIP' =>		'127.0.0.1',
		'CharPort' =>	'6121',
		'LoginIP' =>	'127.0.0.1',
		'LoginPort' =>	'6900',

		// Mail Settings
		'smtpServer' =>	'127.0.0.1',
		'smtpPort' =>	'25',
		'smtpMail' => 	'soporte@terra-gaming.com',
		'smtpUser' =>	'',
		'smtpPass' =>	'',

		// CP Settings
		'GMLevel' =>	7,

		// Char Settings
		'MaxChars' =>	9,

		// Downloads
		'Client' =>		'http://www.megaupload.com/?d=IFIYXHCZ',
		'Client2' =>	'ftp://ftp.terra-gaming.com/GSETUP_090126.exe',
		'FClient' =>	'http://www.megaupload.com/?d=8WEBUJFF',
		'FClient2' =>	'ftp://ftp.terra-gaming.com/GFULL_081113.exe',
	);

	extract($CONFIG, EXTR_PREFIX_ALL, "CONFIG");
?>