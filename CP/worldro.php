<?php
	// **********************************
	// * Ragnarok World Map             *
	// * By Zephyrus                    *
	// * www.terra-gaming.com           *
	// **********************************

	// Main Settings - Edit this lines

	$options = array (
		'DBHost'		=> '127.0.0.1',
		'DBUser'		=> 'root',
		'DBPass'		=> 'password',
		'DBName'		=> 'database',
		'ServerName'	=> 'EvangelisRO',
		'ServerURL'		=> 'http://www.evangelis-ro.cl'
	);

	// Main Source - No edit required, do it just if you know

	class sql {
		// Constructor
		function sql() {
			global $options;

			$this->connection = @mysql_connect($options['DBHost'],$options['DBUser'],$options['DBPass'])
				OR die('MySQL Connection Error...');
			mysql_select_db($options['DBName'])
				OR die('Database selection Error...');
		}

		function query($query) {
			if ($result = @mysql_query($query,$this->connection))
				return $result;
			die('MySQL Query Error...');
		}

		function fetchrow($result) {
			return mysql_fetch_row($result);
		}

		function fetcharray($result, $type = MYSQL_ASSOC) {
			return mysql_fetch_array($result,$type);
		}

		function numrows($result) {
			return mysql_num_rows($result);
		}

	}

	// To format char name output
	function htmlformat($string)
	{
		$resp = "";

		for ($i = 0; isset($string[$i]) && ord($string[$i]) > 0; $i++)
			$resp .= "&#".ord($string[$i]).";";

		return $resp;
	}

	// Ragnarok Classes
	$jobs = array (
		// First Class
		0 => "Novice","Swordman","Magician","Archer","Acolyte","Merchant","Thief",
		// 2.1
		7 => "Knight","Priest","Wizard","Blacksmith","Hunter","Assassin","Knight",
		// 2.2
		14 => "Crusader","Monk","Sage","Rogue","Alchemist","Bard","Dancer","Crusader",
		// Expanded and Extra
		22 => "Wedding","Super Novice","Gunslinger","Ninja","Santa",
		// High First Class
		4001 => "Novice High","Swordsman High","Mage High","Archer High","Acolyte High","Merchant High","Thief High",
		// Advanced 2.1
		4008 => "Lord Knight","High Priest","High Wizard","Whitesmith","Sniper","Assassin Cross","Lord Knight",
		// Advanced 2.2
		4015 => "Paladin","Champion","Professor","Stalker","Creator","Clown","Gypsy","Paladin",
		// Baby First Class
		4023 => "Baby Novice","Baby Swordman","Baby Magician","Baby Archer","Baby Acolyte","Baby Merchant","Baby Thief",
		// Baby 2.1
		4030 => "Baby Knight","Baby Priest","Baby Wizard","Baby Blacksmith","Baby Hunter","Baby Assassin","Baby Knight",
		// Baby 2.2
		4037 => "Baby Crusader","Baby Monk","Baby Sage","Baby Rogue","Baby Alchemist","Baby Bard","Baby Dancer","Baby Crusader",
		// Expanded and Extra
		4045 => "Baby Super Novice","Taekwon","Star Gladiator","Star Gladiator","Soul Linker"
	);

	// WorldMap X-Y
	$maps = array(
		'nameless_i'	=> array('x1' => 93,	'y1' => 697,	'x2' => 157,	'y2' => 760),
		've_fild07'		=> array('x1' => 160,	'y1' => 585,	'x2' => 218,	'y2' => 643),
		'veins'			=> array('x1' => 161,	'y1' => 528,	'x2' => 218,	'y2' => 584),
		've_fild06'		=> array('x1' => 164,	'y1' => 485,	'x2' => 223,	'y2' => 527),
		've_fild05'		=> array('x1' => 106,	'y1' => 469,	'x2' => 163,	'y2' => 527),
		've_fild04'		=> array('x1' => 164,	'y1' => 410,	'x2' => 223,	'y2' => 468),
		've_fild03'		=> array('x1' => 106,	'y1' => 410,	'x2' => 163,	'y2' => 468),
		've_fild02'		=> array('x1' => 224,	'y1' => 352,	'x2' => 282,	'y2' => 409),
		've_fild01'		=> array('x1' => 163,	'y1' => 352,	'x2' => 223,	'y2' => 409),
		'rachel'		=> array('x1' => 224,	'y1' => 292,	'x2' => 282,	'y2' => 351),
		'ra_temple'		=> array('x1' => 235,	'y1' => 260,	'x2' => 271,	'y2' => 291),
		'ra_fild13'		=> array('x1' => 283,	'y1' => 352,	'x2' => 341,	'y2' => 409),
		'ra_fild12'		=> array('x1' => 283,	'y1' => 292,	'x2' => 341,	'y2' => 351),
		'ra_fild11'		=> array('x1' => 163,	'y1' => 292,	'x2' => 223,	'y2' => 351),
		'ra_fild10'		=> array('x1' => 106,	'y1' => 291,	'x2' => 162,	'y2' => 351),
		'ra_fild09'		=> array('x1' => 342,	'y1' => 235,	'x2' => 400,	'y2' => 291),
		'ra_fild08'		=> array('x1' => 283,	'y1' => 235,	'x2' => 341,	'y2' => 291),
		'ra_fild07'		=> array('x1' => 163,	'y1' => 235,	'x2' => 223,	'y2' => 291),
		'ra_fild06'		=> array('x1' => 401,	'y1' => 173,	'x2' => 459,	'y2' => 234),
		'ra_fild05'		=> array('x1' => 342,	'y1' => 174,	'x2' => 400,	'y2' => 234),
		'ra_fild04'		=> array('x1' => 283,	'y1' => 174,	'x2' => 341,	'y2' => 234),
		'ra_fild03'		=> array('x1' => 224,	'y1' => 173,	'x2' => 282,	'y2' => 234),
		'ra_fild02'		=> array('x1' => 163,	'y1' => 173,	'x2' => 223,	'y2' => 234),
		'ra_fild01'		=> array('x1' => 282,	'y1' => 116,	'x2' => 341,	'y2' => 173),
		'lighthalzen'	=> array('x1' => 401,	'y1' => 292,	'x2' => 459,	'y2' => 346),
		'lhz_01'		=> array('x1' => 401,	'y1' => 235,	'x2' => 459,	'y2' => 291),
		'lhz_02'		=> array('x1' => 460,	'y1' => 235,	'x2' => 517,	'y2' => 291),
		'lhz_03'		=> array('x1' => 460,	'y1' => 292,	'x2' => 517,	'y2' => 351),
		'ein_fild10'	=> array('x1' => 636,	'y1' => 292,	'x2' => 694,	'y2' => 351),
		'einbroch'		=> array('x1' => 518,	'y1' => 235,	'x2' => 575,	'y2' => 291),
		'einbrech'		=> array('x1' => 576,	'y1' => 244,	'x2' => 635,	'y2' => 291),
		'ein_fild09'	=> array('x1' => 576,	'y1' => 292,	'x2' => 635,	'y2' => 351),
		'ein_fild08'	=> array('x1' => 518,	'y1' => 292,	'x2' => 575,	'y2' => 351),
		'ein_fild07'	=> array('x1' => 636,	'y1' => 235,	'x2' => 694,	'y2' => 291),
		'ein_fild06'	=> array('x1' => 636,	'y1' => 174,	'x2' => 694,	'y2' => 234),
		'ein_fild05'	=> array('x1' => 576,	'y1' => 174,	'x2' => 635,	'y2' => 234),
		'ein_fild04'	=> array('x1' => 518,	'y1' => 174,	'x2' => 575,	'y2' => 234),
		'ein_fild03'	=> array('x1' => 460,	'y1' => 174,	'x2' => 517,	'y2' => 234),
		'ein_fild02'	=> array('x1' => 575,	'y1' => 117,	'x2' => 635,	'y2' => 173),
		'ein_fild01'	=> array('x1' => 575,	'y1' => 57,		'x2' => 635,	'y2' => 116),
		'yuno'			=> array('x1' => 643,	'y1' => 79,		'x2' => 706,	'y2' => 136),
		'yuno_fild12'	=> array('x1' => 753,	'y1' => 235,	'x2' => 811,	'y2' => 291),
		'yuno_fild11'	=> array('x1' => 695,	'y1' => 235,	'x2' => 752,	'y2' => 291),
		'yuno_fild10'	=> array('x1' => 871,	'y1' => 173,	'x2' => 927,	'y2' => 234),
		'yuno_fild09'	=> array('x1' => 812,	'y1' => 174,	'x2' => 870,	'y2' => 234),
		'yuno_fild08'	=> array('x1' => 753,	'y1' => 174,	'x2' => 811,	'y2' => 234),
		'yuno_fild07'	=> array('x1' => 695,	'y1' => 174,	'x2' => 752,	'y2' => 234),
		'yuno_fild06'	=> array('x1' => 695,	'y1' => 58,		'x2' => 752,	'y2' => 116),
		'yuno_fild05'	=> array('x1' => 636,	'y1' => 57,		'x2' => 694,	'y2' => 116),
		'yuno_fild04'	=> array('x1' => 636,	'y1' => 117,	'x2' => 694,	'y2' => 173),
		'yuno_fild03'	=> array('x1' => 695,	'y1' => 117,	'x2' => 752,	'y2' => 173),
		'yuno_fild02'	=> array('x1' => 753,	'y1' => 117,	'x2' => 811,	'y2' => 173),
		'yuno_fild01'	=> array('x1' => 812,	'y1' => 235,	'x2' => 870,	'y2' => 291),
		'hugel'			=> array('x1' => 871,	'y1' => 0,		'x2' => 927,	'y2' => 57),
		'hu_fild07'		=> array('x1' => 812,	'y1' => 117,	'x2' => 870,	'y2' => 173),
		'hu_fild06'		=> array('x1' => 871,	'y1' => 58,		'x2' => 927,	'y2' => 116),
		'hu_fild05'		=> array('x1' => 812,	'y1' => 58,		'x2' => 870,	'y2' => 116),
		'hu_fild04'		=> array('x1' => 753,	'y1' => 58,		'x2' => 811,	'y2' => 116),
		'hu_fild03'		=> array('x1' => 812,	'y1' => 0,		'x2' => 870,	'y2' => 57),
		'hu_fild02'		=> array('x1' => 753,	'y1' => 0,		'x2' => 811,	'y2' => 57),
		'hu_fild01'		=> array('x1' => 694,	'y1' => 0,		'x2' => 752,	'y2' => 57),
		'odin_tem01'	=> array('x1' => 987,	'y1' => 173,	'x2' => 1043,	'y2' => 234),
		'odin_tem02'	=> array('x1' => 1044,	'y1' => 173,	'x2' => 1102,	'y2' => 234),
		'odin_tem03'	=> array('x1' => 1046,	'y1' => 116,	'x2' => 1102,	'y2' => 172),
		'alde_gld'		=> array('x1' => 753,	'y1' => 292,	'x2' => 811,	'y2' => 351),
		'aldebaran'		=> array('x1' => 812,	'y1' => 292,	'x2' => 870,	'y2' => 351),
		'mjolnir_12'	=> array('x1' => 812,	'y1' => 352,	'x2' => 870,	'y2' => 410),
		'mjolnir_11'	=> array('x1' => 871,	'y1' => 468,	'x2' => 927,	'y2' => 527),
		'mjolnir_10'	=> array('x1' => 812,	'y1' => 469,	'x2' => 870,	'y2' => 527),
		'mjolnir_09'	=> array('x1' => 753,	'y1' => 528,	'x2' => 811,	'y2' => 586),
		'mjolnir_08'	=> array('x1' => 753,	'y1' => 469,	'x2' => 811,	'y2' => 527),
		'mjolnir_07'	=> array('x1' => 695,	'y1' => 469,	'x2' => 752,	'y2' => 527),
		'mjolnir_06'	=> array('x1' => 636,	'y1' => 469,	'x2' => 694,	'y2' => 527),
		'mjolnir_05'	=> array('x1' => 812,	'y1' => 411,	'x2' => 870,	'y2' => 468),
		'mjolnir_04'	=> array('x1' => 753,	'y1' => 410,	'x2' => 811,	'y2' => 468),
		'mjolnir_03'	=> array('x1' => 695,	'y1' => 410,	'x2' => 752,	'y2' => 468),
		'mjolnir_02'	=> array('x1' => 636,	'y1' => 410,	'x2' => 694,	'y2' => 468),
		'mjolnir_01'	=> array('x1' => 575,	'y1' => 410,	'x2' => 635,	'y2' => 468),
		'geffen'		=> array('x1' => 576,	'y1' => 528,	'x2' => 635,	'y2' => 586),
		'gef_fild14'	=> array('x1' => 518,	'y1' => 644,	'x2' => 575,	'y2' => 701),
		'gef_fild13'	=> array('x1' => 518,	'y1' => 587,	'x2' => 575,	'y2' => 643),
		'gef_fild12'	=> array('x1' => 459,	'y1' => 587,	'x2' => 517,	'y2' => 643),
		'gef_fild11'	=> array('x1' => 576,	'y1' => 702,	'x2' => 635,	'y2' => 760),
		'gef_fild10'	=> array('x1' => 576,	'y1' => 644,	'x2' => 635,	'y2' => 701),
		'gef_fild09'	=> array('x1' => 576,	'y1' => 587,	'x2' => 635,	'y2' => 643),
		'gef_fild08'	=> array('x1' => 460,	'y1' => 528,	'x2' => 517,	'y2' => 586),
		'gef_fild07'	=> array('x1' => 518,	'y1' => 528,	'x2' => 575,	'y2' => 586),
		'gef_fild06'	=> array('x1' => 460,	'y1' => 468,	'x2' => 517,	'y2' => 527),
		'gef_fild05'	=> array('x1' => 518,	'y1' => 468,	'x2' => 575,	'y2' => 527),
		'gef_fild04'	=> array('x1' => 576,	'y1' => 469,	'x2' => 635,	'y2' => 527),
		'gef_fild03'	=> array('x1' => 636,	'y1' => 644,	'x2' => 694,	'y2' => 701),
		'gef_fild02'	=> array('x1' => 695,	'y1' => 643,	'x2' => 753,	'y2' => 701),
		'gef_fild01'	=> array('x1' => 636,	'y1' => 587,	'x2' => 870,	'y2' => 643),
		'gef_fild00'	=> array('x1' => 636,	'y1' => 528,	'x2' => 870,	'y2' => 586),
		'prontera'		=> array('x1' => 812,	'y1' => 587,	'x2' => 870,	'y2' => 643),
		'prt_fild11'	=> array('x1' => 636,	'y1' => 702,	'x2' => 694,	'y2' => 760),
		'prt_fild10'	=> array('x1' => 695,	'y1' => 702,	'x2' => 752,	'y2' => 760),
		'prt_fild09'	=> array('x1' => 753,	'y1' => 702,	'x2' => 811,	'y2' => 760),
		'prt_fild08'	=> array('x1' => 812,	'y1' => 644,	'x2' => 870,	'y2' => 701),
		'prt_fild07'	=> array('x1' => 753,	'y1' => 644,	'x2' => 811,	'y2' => 701),
		'prt_fild06'	=> array('x1' => 871,	'y1' => 587,	'x2' => 927,	'y2' => 643),
		'prt_fild05'	=> array('x1' => 753,	'y1' => 587,	'x2' => 811,	'y2' => 643),
		'prt_fild04'	=> array('x1' => 695,	'y1' => 587,	'x2' => 752,	'y2' => 643),
		'prt_fild03'	=> array('x1' => 928,	'y1' => 528,	'x2' => 986,	'y2' => 570),
		'prt_fild02'	=> array('x1' => 871,	'y1' => 528,	'x2' => 927,	'y2' => 586),
		'prt_fild01'	=> array('x1' => 812,	'y1' => 528,	'x2' => 870,	'y2' => 586),
		'prt_fild00'	=> array('x1' => 695,	'y1' => 528,	'x2' => 752,	'y2' => 586),
		'izlude'		=> array('x1' => 871,	'y1' => 644,	'x2' => 902,	'y2' => 676),
		'izlu2dun'		=> array('x1' => 928,	'y1' => 644,	'x2' => 948,	'y2' => 665),
		'payon'			=> array('x1' => 966,	'y1' => 745,	'x2' => 1013,	'y2' => 803),
		'pay_arche'		=> array('x1' => 984,	'y1' => 693,	'x2' => 1030,	'y2' => 744),
		'pay_fild11'	=> array('x1' => 907,	'y1' => 867,	'x2' => 959,	'y2' => 931),
		'pay_fild10'	=> array('x1' => 1054,	'y1' => 804,	'x2' => 1113,	'y2' => 861),
		'pay_fild09'	=> array('x1' => 1054,	'y1' => 745,	'x2' => 1113,	'y2' => 803),
		'pay_fild08'	=> array('x1' => 1014,	'y1' => 746,	'x2' => 1053,	'y2' => 803),
		'pay_fild07'	=> array('x1' => 995,	'y1' => 804,	'x2' => 1053,	'y2' => 861),
		'pay_fild06'	=> array('x1' => 1004,	'y1' => 932,	'x2' => 1058,	'y2' => 989),
		'pay_fild05'	=> array('x1' => 960,	'y1' => 932,	'x2' => 1003,	'y2' => 989),
		'pay_fild04'	=> array('x1' => 871,	'y1' => 702,	'x2' => 927,	'y2' => 760),
		'pay_fild03'	=> array('x1' => 1004,	'y1' => 884,	'x2' => 1058,	'y2' => 931),
		'pay_fild02'	=> array('x1' => 960,	'y1' => 868,	'x2' => 1003,	'y2' => 931),
		'pay_fild01'	=> array('x1' => 936,	'y1' => 804,	'x2' => 994,	'y2' => 861),
		'alberta'		=> array('x1' => 1059,	'y1' => 912,	'x2' => 1113,	'y2' => 964),
		'alb2trea'		=> array('x1' => 1114,	'y1' => 919,	'x2' => 1134,	'y2' => 944),
		'tur_dun01'		=> array('x1' => 1163,	'y1' => 974,	'x2' => 1191,	'y2' => 1004),
		'glast_01'		=> array('x1' => 407,	'y1' => 468,	'x2' => 459,	'y2' => 527),
		'prt_monk'		=> array('x1' => 987,	'y1' => 527,	'x2' => 1042,	'y2' => 570),
		'umbala'		=> array('x1' => 307,	'y1' => 659,	'x2' => 356,	'y2' => 716),
		'um_fild01'		=> array('x1' => 238,	'y1' => 775,	'x2' => 296,	'y2' => 834),
		'um_fild02'		=> array('x1' => 297,	'y1' => 776,	'x2' => 356,	'y2' => 834),
		'um_fild03'		=> array('x1' => 357,	'y1' => 775,	'x2' => 416,	'y2' => 834),
		'um_fild04'		=> array('x1' => 296,	'y1' => 717,	'x2' => 356,	'y2' => 774),
		'comodo'		=> array('x1' => 297,	'y1' => 835,	'x2' => 356,	'y2' => 893),
		'cmd_fild09'	=> array('x1' => 544,	'y1' => 951,	'x2' => 602,	'y2' => 1009),
		'cmd_fild08'	=> array('x1' => 544,	'y1' => 893,	'x2' => 602,	'y2' => 950),
		'cmd_fild07'	=> array('x1' => 484,	'y1' => 951,	'x2' => 543,	'y2' => 1009),
		'cmd_fild06'	=> array('x1' => 484,	'y1' => 893,	'x2' => 543,	'y2' => 950),
		'cmd_fild05'	=> array('x1' => 484,	'y1' => 834,	'x2' => 543,	'y2' => 893),
		'cmd_fild04'	=> array('x1' => 426,	'y1' => 893,	'x2' => 483,	'y2' => 950),
		'cmd_fild03'	=> array('x1' => 426,	'y1' => 834,	'x2' => 483,	'y2' => 893),
		'cmd_fild02'	=> array('x1' => 366,	'y1' => 893,	'x2' => 425,	'y2' => 950),
		'cmd_fild01'	=> array('x1' => 366,	'y1' => 835,	'x2' => 425,	'y2' => 893),
		'morroc'		=> array('x1' => 605,	'y1' => 844,	'x2' => 655,	'y2' => 893),
		'moc_ruins'		=> array('x1' => 566,	'y1' => 816,	'x2' => 602,	'y2' => 848),
		'moc_fild19'	=> array('x1' => 566,	'y1' => 849,	'x2' => 602,	'y2' => 881),
		'moc_fild18'	=> array('x1' => 603,	'y1' => 951,	'x2' => 659,	'y2' => 1009),
		'moc_fild17'	=> array('x1' => 660,	'y1' => 951,	'x2' => 717,	'y2' => 1008),
		'moc_fild16'	=> array('x1' => 718,	'y1' => 939,	'x2' => 776,	'y2' => 996),
		'moc_fild15'	=> array('x1' => 718,	'y1' => 879,	'x2' => 776,	'y2' => 938),
		'moc_fild14'	=> array('x1' => 777,	'y1' => 879,	'x2' => 835,	'y2' => 938),
		'moc_fild13'	=> array('x1' => 836,	'y1' => 810,	'x2' => 882,	'y2' => 868),
		'moc_fild12'	=> array('x1' => 603,	'y1' => 894,	'x2' => 659,	'y2' => 950),
		'moc_fild11'	=> array('x1' => 660,	'y1' => 894,	'x2' => 717,	'y2' => 950),
		'moc_fild10'	=> array('x1' => 656,	'y1' => 845,	'x2' => 717,	'y2' => 893),
		'moc_fild09'	=> array('x1' => 718,	'y1' => 820,	'x2' => 776,	'y2' => 878),
		'moc_fild08'	=> array('x1' => 777,	'y1' => 820,	'x2' => 835,	'y2' => 878),
		'moc_fild07'	=> array('x1' => 603,	'y1' => 785,	'x2' => 659,	'y2' => 844),
		'moc_fild06'	=> array('x1' => 660,	'y1' => 785,	'x2' => 717,	'y2' => 844),
		'moc_fild05'	=> array('x1' => 718,	'y1' => 761,	'x2' => 776,	'y2' => 819),
		'moc_fild04'	=> array('x1' => 777,	'y1' => 761,	'x2' => 835,	'y2' => 819),
		'moc_fild03'	=> array('x1' => 883,	'y1' => 810,	'x2' => 935,	'y2' => 868),
		'moc_fild02'	=> array('x1' => 857,	'y1' => 761,	'x2' => 906,	'y2' => 809),
		'moc_fild01'	=> array('x1' => 812,	'y1' => 702,	'x2' => 870,	'y2' => 760),
	);
?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			<title>
<?php
	echo $options['ServerName'];
?>
			</title>
			<script language="javascript" type="text/javascript">
				function show_tip(header,guild,jobinfo,levels,map,jobid)
				{
					var wtip;
					wtip = document.getElementById("tip");

					if( window.opera)
					{
						x = window.event.clientX+15;
						y = window.event.clientY-10;
					}
					else if( navigator.appName == "Netscape")
					{
						document.onmousemove = function(e) { x = e.pageX+15; y = e.pageY-10; return true }
					}
					else
					{
						x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft + 15;
						y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop - 10;
					}

					wtip.innerHTML = '<table width="150" border="0" cellspacing="0" cellpadding="0"\><tr class=\'tip_header\'\><td\>' + header + '</td\></tr\><tr class=\'tip_guild\'\><td\>' + guild + '</td\></tr\><tr class=\'tip_text\'\><td\><img src="imgwm/' + jobid + '.gif"></td\></tr\><tr class=\'tip_text\'\><td\>' + jobinfo + '</td\></tr\><tr class=\'tip_text\'\><td\>' + levels + '</td\></tr\><tr class=\'tip_text\'\><td\>' + map + '</td\></tr\><\/table\>';
					if( screen.width - x < 150 )
						x -= 150;

					wtip.style.left = x + "px";
					wtip.style.top = y + "px";
				}

				function hide_tip()
				{
					var wtip;
					wtip = document.getElementById("tip");

					wtip.innerHTML = "";
					wtip.style.left = "-1000px";
					wtip.style.top = "-1000px";
				}
			</script>
		    <style type="text/css">
				<!--
				.style2 {
					font-size: large;
					font-family: Arial, Helvetica, sans-serif;
				}
				#tip {
					background: #000000;
					border: 0px solid #aaaaaa;
					left: -1000px;
					padding: 0px;
					position: absolute;
					top: -1000px;
					z-index: 110;
				}
				.tip_header {
					background: #0099FF;
					FONT-WEIGHT: bold;
					color: #FFFFFF;
					font-family: arial, helvetica, sans-serif;
					font-size: 11px;
					font-style: normal;
					text-align: center;
					padding: 0px;
				}
				.tip_guild {
					background: #0099FF;
					FONT-WEIGHT: bold;
					color: #ffff00;
					font-family: arial, helvetica, sans-serif;
					font-size: 11px;
					font-style: normal;
					text-align: center;
					padding: 3px;
				}
				.tip_text {
					background: #FFFFFF;
					FONT-WEIGHT: normal;
					color: #000000;
					font-family: arial, helvetica, sans-serif;
					font-size: 11px;
					font-style: normal;
					text-align: center;
					padding: 3px;
				}
				-->
            </style>
    	</head>
		<BODY style="margin-top:0; margin-bottom:0" bgcolor="Black">
			<div id="tip"></div>
			<div class="world_class">
<?php
	$sql = new sql();

	$result = $sql->query("
		SELECT
			`char`.`char_id`, `char`.`name`, `char`.`last_x`, `char`.`last_y`, `char`.`last_map`, `char`.`base_level`, `char`.`job_level`, `char`.`class`,
			`guild`.`name` AS `gname`,
			`login`.`sex`
		FROM
			`char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char`.`online` = '1' AND `login`.`level` < '1'
	");

	$count = 0;
	while( $char = $sql->fetcharray($result) )
	{
		$map = $char['last_map'];
		if( isset($maps[$map]) )
		{
			echo '<img src="ro' . $char['sex'] . '.gif" style="position:absolute; border:0px; left:' . (rand($maps[$map]['x1'], $maps[$map]['x2']) - 7) .'px; top: ' . (rand($maps[$map]['y1'], $maps[$map]['y2']) - 7) .'px;" onMouseMove="show_tip(\'' . htmlformat($char['name']) . '\',\'' . htmlformat($char['gname']) . '\',\'' . $jobs[$char['class']] . '\',\'(' . $char['base_level'] . '/' . $char['job_level'] . ')\',\'' . htmlformat($char['last_map']) . '\',\'' . $char['class'] . '\');" onMouseOut="hide_tip();">';
		}

		$count++;
	}
?>
				<img src="worldmap.jpg">
			</div>
			<center><b><font color="White">
<?php
	echo $options['ServerName'] . '<br><a href="' . $options['ServerURL'] . '">' . $options['ServerURL'] . '</a><br>' . $count . ' Users Online<br>';
?>
				Created by Zephyrus<br>
				WorldMap Image by Gravity<br><br><br>
			</font></b></center>
		</body>
	</html>