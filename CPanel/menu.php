<?php
/*
Ceres Control Panel

This is a control pannel program for Athena and Freya
Copyright (C) 2005 by Beowulf and Nightroad

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

To contact any of the authors about special permissions send
an e-mail to cerescp@gmail.com
*/

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

$mainmenu[0][0] = $lang['MENU_HOME'];
$mainmenu[0][1] = -1;

$mainmenu[1][0] = $lang['MENU_MYACCOUNT'];
$mainmenu[1][1] = 0;

$mainmenu[2][0] = $lang['MENU_MYCHARS'];
$mainmenu[2][1] = 0;

$mainmenu[3][0] = $lang['MENU_RANKING'];
$mainmenu[3][1] = -1;

$mainmenu[4][0] = $lang['MENU_INFORMATION'];
$mainmenu[4][1] = -1;

$mainmenu[5][0] = "Votanos";
$mainmenu[5][1] = 0;

$mainmenu[6][0] = $lang['MENU_PROBLEMS'];
$mainmenu[6][1] = 0;

$mainmenu[7][0] = "Administration";
$mainmenu[7][1] = $CONFIG['cp_admin'];

$submenu[0][0] = $lang['MENU_MESSAGE'];
$submenu[0][1] = "motd.php";
$submenu[0][2] = 0;

$submenu[1][0] = $lang['MENU_CHANGEPASS'];
$submenu[1][1] = "password.php";
$submenu[1][2] = 1;

$submenu[2][0] = $lang['MENU_CHANGEMAIL'];
$submenu[2][1] = "changemail.php";
$submenu[2][2] = 1;

$submenu[3][0] = "Familias";
$submenu[3][1] = "family.php";
$submenu[3][2] = 4;

$submenu[4][0] = "Online x Guild";
$submenu[4][1] = "onlinexguild.php";
$submenu[4][2] = 4;

$submenu[5][0] = $lang['MENU_MARRIAGE'];
$submenu[5][1] = "marriage.php";
$submenu[5][2] = 2;

$submenu[6][0] = "Exp";
$submenu[6][1] = "ladder.php";
$submenu[6][2] = 3;

$submenu[7][0] = $lang['MENU_GUILDLADDER'];
$submenu[7][1] = "guild.php";
$submenu[7][2] = 3;

$submenu[8][0] = $lang['MENU_ZENYLADDER'];
$submenu[8][1] = "top100zeny.php";
$submenu[8][2] = 3;

$submenu[9][0] = $lang['MENU_WHOSONLINE'];
$submenu[9][1] = "whoisonline.php";
$submenu[9][2] = 4;

$submenu[10][0] = $lang['MENU_ABOUT'];
$submenu[10][1] = "about.php";
$submenu[10][2] = 4;

$submenu[11][0] = $lang['MENU_RESETPOS'];
$submenu[11][1] = "position.php";
if ($CONFIG_reset_enable)
	$submenu[11][2] = 6;
else
	$submenu[11][2] = -1;

$submenu[12][0] = $lang['MENU_RESETLOOK'];
$submenu[12][1] = "resetlook.php";
if ($CONFIG_reset_look)
	$submenu[12][2] = 6;
else
	$submenu[12][2] = -1;

$submenu[13][0] = $lang['MENU_OTHER'];
$submenu[13][1] = "sendmail.php";
$submenu[13][2] = 6;

$submenu[14][0] = "Castillos Actuales de WoE";
$submenu[14][1] = "links.php";
$submenu[14][2] = 4;

$submenu[15][0] = "Accounts";
$submenu[15][1] = "adminaccounts.php";
$submenu[15][2] = 7;

$submenu[16][0] = "Chars";
$submenu[16][1] = "adminchars.php";
$submenu[16][2] = 7;

$submenu[17][0] = "TK";
$submenu[17][1] = "toptk.php";
$submenu[17][2] = 3;

$submenu[18][0] = "Potion";
$submenu[18][1] = "toppotion.php";
$submenu[18][2] = 3;

$submenu[19][0] = "Forja";
$submenu[19][1] = "topforja.php";
$submenu[19][2] = 3;

$submenu[20][0] = "MVP";
$submenu[20][1] = "topmvp.php";
$submenu[20][2] = 3;

$submenu[21][0] = "PK";
$submenu[21][1] = "toppk.php";
$submenu[21][2] = 3;

$submenu[22][0] = "Char Storage";
$submenu[22][1] = "charstorage.php";
$submenu[22][2] = 2;

$submenu[23][0] = "Mute";
$submenu[23][1] = "offline_muter.php";
$submenu[23][2] = 7;

$submenu[24][0] = "Sancion Log";
$submenu[24][1] = "sancion.php";
$submenu[24][2] = 7;

$submenu[25][0] = "Play";
$submenu[25][1] = "topplaytime.php";
$submenu[25][2] = 3;

$submenu[26][0] = "WoE";
$submenu[26][1] = "woerank.php";
$submenu[26][2] = 3;

$submenu[27][0] = "Castle";
$submenu[27][1] = "castles.php";
$submenu[27][2] = 3;

$submenu[28][0] = "Homu";
$submenu[28][1] = "homunculus.php";
$submenu[28][2] = 3;

$submenu[29][0] = "Merce";
$submenu[29][1] = "mercenary.php";
$submenu[29][2] = 3;

$submenu[30][0] = "Hunting";
$submenu[30][1] = "hunting.php";
$submenu[30][2] = 3;

$submenu[31][0] = "PVP";
$submenu[31][1] = "pvprank.php";
$submenu[31][2] = 3;

$submenu[32][0] = "BG";
$submenu[32][1] = "bgrank.php";
$submenu[32][2] = 3;

$submenu[33][0] = "Slot";
$submenu[33][1] = "slot.php";
if ($CONFIG_set_slot)
	$submenu[33][2] = 2;
else
	$submenu[33][2] = -1;

$submenu[34][0] = "Cambiar Nombre";
$submenu[34][1] = "changename.php";
$submenu[34][2] = 2;

$submenu[35][0] = "World Map";
$submenu[35][1] = "iframemap.php";
$submenu[35][2] = 4;

$submenu[36][0] = "Cards MVP";
$submenu[36][1] = "topmvpcard.php";
$submenu[36][2] = 4;

$submenu[37][0] = "Historial Cambios de Nombre";
$submenu[37][1] = "histoname.php";
$submenu[37][2] = 4;

$submenu[38][0] = "Cambiar Sexo";
$submenu[38][1] = "changesex.php";
$submenu[38][2] = 1;

$submenu[39][0] = "Recuperar Security Pass";
$submenu[39][1] = "securitypass.php";
$submenu[39][2] = 1;

$submenu[40][0] = "Votar por puntos";
$submenu[40][1] = "donatevota.php";
$submenu[40][2] = 5;

$submenu[41][0] = "Mineria";
$submenu[41][1] = "topmineria.php";
$submenu[41][2] = 3;

$submenu[42][0] = "CP/KP";
$submenu[42][1] = "topcpkp.php";
$submenu[42][2] = 3;

$submenu[43][0] = "Votos";
$submenu[43][1] = "topvota.php";
$submenu[43][2] = 3;

$submenu[44][0] = "Quejas/Sugerencias";
$submenu[44][1] = "mailbox.php";
$submenu[44][2] = 7;

$pos = 0;
$menu = "var mainmenu = new Array(";
$sub  = "var submenu = new Array(\"\", \"\", -1";

for ($i = 0; isset($mainmenu[$i][0]); $i++) {
	if ($mainmenu[$i][1] < 0 || (isset($_SESSION[$CONFIG_name.'level']) && $_SESSION[$CONFIG_name.'level'] >= $mainmenu[$i][1])) {
		if ($pos > 0)
			$menu = $menu.", ";
		$menu = $menu."\"".$mainmenu[$i][0]."\"";
		for ($j = 0; isset($submenu[$j][0]); $j++) {
			if ($submenu[$j][2] == $i) {
				$sub = $sub.", \"".$submenu[$j][0]."\"".", \"".$submenu[$j][1]."\", ".$pos;
			}
		}
		$pos++;
	}
}

$menu = $menu.");";
$sub  = $sub.");";

echo $menu."\n";
echo $sub."\n";

?>
function main_menu() {
	var the_menu = " | ";

	for (i = 0; i < mainmenu.length; i++)
		the_menu = the_menu + "<span style=\"cursor:pointer\" onMouseOver=\"this.style.color='#000000'\" onMouseOut=\"this.style.color='#000000'\" onClick=\"return sub_menu(" + i + ");\">" + mainmenu[i] + "</span> | ";

	document.getElementById('main_menu').innerHTML = the_menu;
	document.getElementById('sub_menu').innerHTML = " ";

	return false;
}

function sub_menu(index) {
	var the_menu = " | ";
	
	for (i = 0; i < submenu.length; i = i + 3) {
		if (submenu[i + 2] == index)
		the_menu = the_menu + "<span style=\"cursor:pointer\" onMouseOver=\"this.style.color='#000000'\" onMouseOut=\"this.style.color='#000000'\" onClick=\"return LINK_ajax('" + submenu[i + 1] + "','main_div');\">" + submenu[i] + "</span> | ";
	}

	document.getElementById('sub_menu').innerHTML = the_menu;

	return false;
}

main_menu();
<?php
//fim();
?>