<?php

	session_start();
	include_once 'config.php'; // loads config variables
	include_once 'functions.php';

	// Contrucción del Menú

	$mainmenu = array(
		array("Evangelis", -2),
		array("Miembro", -1),
		array("Cuenta", 0),
		array("Personajes", 0),
		array("Historicos", 0),
		array("Informacion", -2),
		array("Rankings", -2),
		array("Finanzas", 1)
	);

	$submenu = array(
		// Gaia RO
		array("Noticias", 					"news.php", 				0),
		// Menú Miembro
		array("Membresia",					"myinfo.php",				1),
		array("Cuentas",					"cuentas.php",				1),
		array("Crear Cuenta",				"newaccount.php",			1),
		array("Clave Miembro",				"editmember.php",			1),
		array("Referidos",					"refered.php",				1),
		array("Accesos",					"accesslog.php",			1),
		array("Recuperar Claves",			"accountrecover.php",		1),
		// Menú de Cuenta
		array("Donar",						"donate.php",				2),
		array("Cambiar Clave",				"password.php",				2),
		array("Cambio de Sexo",				"changesex.php",			2),
		array("Clave Storage",				"storagepass.php",			2),
		array("Clave Security",				"securitypass.php",			2),
		array("Tiempo de Juego",			"playtime.php",				2),
		// Menú de Personajes
		array("Storage Chars",				"charstorage.php",			3),
		array("Divorcios",					"marriage.php",				3),
		array("Bautizos",					"changename.php",			3),
		array("Adopciones",					"adoption.php",				3),
		array("Reset Posicion",				"position.php",				3),
		// Históricos
		array("Acceso a Cuenta",			"logaccesos.php",			4),
		array("Log Items (Actual)",			"logtrades.php?db=1",		4),
//		array("Log Items (al 21-05-09)",	"logtrades.php?db=2",		4),
		// Información
		array("God Seals",					"seals.php",				5),
		array("Online",						"whoisonline.php",			5),
		array("Online x Guild",				"onlinexguild.php",			5),
		array("WorldMap",					"worldmap.php?vid=1",		5),
		array("Familias",					"family.php",				5),
		array("Log Nombres",				"lognames.php",				5),
		// Rankings
		array("Class",						"ladder.php",				6),
		array("Guild",						"guild.php",				6),
		array("Castle",						"castles.php",				6),
		array("WoE",						"woerank.php",				6),
		array("Zeny",						"top100zeny.php",			6),
		array("Hom",						"homunculus.php",			6),
		array("Mer",						"mercenary.php",			6),
		array("MVP",						"topmvp.php",				6),
		array("PK",							"toppk.php",				6),
		array("TK",							"toptk.php",				6),
		array("Forja",						"topforja.php",				6),
		array("Potion",						"toppotion.php",			6),
		array("PVP",						"pvprank.php",				6),
		array("BG",							"bgrank.php",				6),
		array("Playtime",					"topplaytime.php",			6),
		array("Hunting",					"hunting.php",				6),
		// Finanzas
		array("Donativos",					"donatives.php",			7),
	);

	$Tmenu = "var mainmenu = new Array(";
	$Lmenu = "var lvlmenu = new Array(";
	$Smenu = "var submenu = new Array(\"\", \"\", -1";

	$head = 0;
	// Creacion del Menú Principal
	for ($i = 0; isset($mainmenu[$i][0]); $i++)
	{
		if( $mainmenu[$i][1] == -2 ||
		   (isset($_SESSION[$CONFIG['Name'] . 'member_id']) && $_SESSION[$CONFIG['Name'] . 'member_id'] > 0 && (
		       ($mainmenu[$i][1] == -1) ||
		       (isset($_SESSION[$CONFIG['Name'] . 'account_id']) && $_SESSION[$CONFIG['Name'] . 'account_id'] > 0 && $mainmenu[$i][1] == 0) ||
		       (isset($_SESSION[$CONFIG['Name'] . 'mlevel']) && $_SESSION[$CONFIG['Name'] . 'mlevel'] > 0 && $mainmenu[$i][1] > 0))) )
		{
			if ($head > 0) { $Tmenu .= ", "; $Lmenu .= ", "; }
			$Tmenu .= "\"" . $mainmenu[$i][0] . "\"";
			$Lmenu .= "\"" . $mainmenu[$i][1] . "\"";

			for( $j = 0; isset($submenu[$j][0]); $j++ )
			{ // Submenu
				if ($submenu[$j][2] == $i)
				{
					$Smenu .= ", \"" . $submenu[$j][0] . "\"" . ", \"" . $submenu[$j][1] . "\", " . $head;
				}
			}

			$head++;
		}
	}

	$Tmenu .= ");\n";
	$Lmenu .= ");\n";
	$Smenu .= ");\n";

	echo $Tmenu;
	echo $Lmenu;
	echo $Smenu;

	// Codigo JavaScript
?>

function main_menu() {
	var the_menu = "";
	var head = "";

	for (i = 0; i < mainmenu.length; i++) {
		if (lvlmenu[i] >= 0)
			the_menu = the_menu + head + "<span style=\"cursor:pointer\" onMouseOver=\"this.style.color='#0000FF'\" onMouseOut=\"this.style.color='#000000'\" onClick=\"return sub_menu(" + i + ");\"><font color=\"#FF0000\">" + mainmenu[i] + "</font></span>";
		else if (lvlmenu[i] == -1)
			the_menu = the_menu + head + "<span style=\"cursor:pointer\" onMouseOver=\"this.style.color='#FF3300'\" onMouseOut=\"this.style.color='#FFFFFF'\" onClick=\"return sub_menu(" + i + ");\"><font color=\"#0000FF\">" + mainmenu[i] + "</font></span>";
		else
			the_menu = the_menu + head + "<span style=\"cursor:pointer\" onMouseOver=\"this.style.color='#FF3300'\" onMouseOut=\"this.style.color='#FFFFFF'\" onClick=\"return sub_menu(" + i + ");\"><font color=\"#000000\">" + mainmenu[i] + "</font></span>";
		head = " | ";
	}

	document.getElementById('main_menu').innerHTML = the_menu;
	document.getElementById('sub_menu').innerHTML = " ";

	return false;
}

function sub_menu(index) {
	var the_menu = "";
	var head = "";

	for (i = 0; i < submenu.length; i = i + 3) {
		if (submenu[i + 2] == index) {
			the_menu = the_menu + head + "<span style=\"cursor:pointer\" onMouseOver=\"this.style.color='#FF3300'\" onMouseOut=\"this.style.color='#FFFFFF'\" onClick=\"return LINK_ajax('" + submenu[i + 1] + "','main_div');\">" + submenu[i] + "</span>";
			head = " | ";
		}
	}

	document.getElementById('sub_menu').innerHTML = the_menu;

	return false;
}

main_menu();
sub_menu(0);
