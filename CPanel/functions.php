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



include_once './language/language.php';

include_once 'classes.php';



if (isset($_SESSION[$CONFIG_name.'SERVER'])) {

	if (strcmp($_SESSION[$CONFIG_name.'SERVER'], $CONFIG_name)) {

		session_destroy();

		die();

	}

} else {

	$_SESSION[$CONFIG_name.'SERVER'] = $CONFIG_name;

}



$mysql = new QueryClass($CONFIG_db_serv, $CONFIG_db_user, $CONFIG_db_pass, $CONFIG_rag_db, $CONFIG_cp_db);



if (!isset($_SESSION[$CONFIG_name.'ipban']) || (isset($_SESSION[$CONFIG_name.'iptime']) && (time() - $_SESSION[$CONFIG_name.'iptime']) > 300)) {

	include_once 'ipban.php';

	$_SESSION[$CONFIG_name.'ipban'] = ipban();

	$_SESSION[$CONFIG_name.'iptime'] = time();

}



if ($_SESSION[$CONFIG_name.'ipban'])

	die("Denied");



if (!isset($_SESSION[$CONFIG_name.'jobs']))

	$_SESSION[$CONFIG_name.'jobs'] = readjobs();



if (!isset($_SESSION[$CONFIG_name.'castles']))

	$_SESSION[$CONFIG_name.'castles'] = readcastles();



if ($CONFIG['cp_admin'] < 10)

	$CONFIG['cp_admin'] = 100;



function readcastles() {

	global $lang;

	$handle = fopen("./db/castles.txt", "rt")

		or die(htmlformat($lang['TXT_ERROR']));

	while ($line = fgets($handle, 1024)) {

		if (($line[0] == '/' && $line[1] == '/') || $line[0] == '\0' || $line[0] == '\n' || $line[0] == '\r')

			continue;

		$job = sscanf($line, "%d %s");

		if (isset($job[0]) && isset($job[1])) {

			for($i = 1; isset($job[1][$i]); $i++)

				if ($job[1][$i] == '_') $job[1][$i] = ' ';

			$resp[$job[0]] = $job[1];

		}

	}	

	fclose($handle);

	return $resp;

}



function is_woe() {

	global $CONFIG_woe_time;

	$wdaynow = date('w');

	$wtimenow = date('Hi');

	$week_day = array (

		0  => 'sun',

		1  => 'mon',

		2  => 'tue',

		3  => 'wed',

		4  => 'thu',

		5  => 'fri',

		6  => 'sat'

	);



	$woe_times = explode(";", $CONFIG_woe_time);

	for ($i = 0; isset($woe_times[$i]); $i++) {

		$woe_times[$i] = str_replace("(", ",", $woe_times[$i]);

		$woe_times[$i] = str_replace(")", "", $woe_times[$i]);

		$woe_times[$i] = str_replace(" ", "", $woe_times[$i]);

		$woe_times[$i] = explode(",", $woe_times[$i]);

		if (!isset($woe_times[$i][2]))

			continue;



		if (strcasecmp($woe_times[$i][0], $week_day[$wdaynow]) == 0) {

			if (($wtimenow > $woe_times[$i][1]) && ($wtimenow < $woe_times[$i][2]))

				return TRUE;

		}

	}



	return FALSE;

}



function ret_woe_times() {

	global $CONFIG_woe_time, $lang;



	$week_day = array (

		'sun' => $lang['SUNDAY'],

		'mon' => $lang['MONDAY'],

		'tue' => $lang['TUESDAY'],

		'wed' => $lang['WEDNSDAY'],

		'thu' => $lang['THURSDAY'],

		'fri' => $lang['FRIDAY'],

		'sat' => $lang['SATURDAY']

	);



	$woe_times = explode(";", $CONFIG_woe_time);

	for ($i = 0; isset($woe_times[$i]); $i++) {

		$woe_times[$i] = str_replace("(", ",", $woe_times[$i]);

		$woe_times[$i] = str_replace(")", "", $woe_times[$i]);

		$woe_times[$i] = str_replace(" ", "", $woe_times[$i]);

		$woe_times[$i] = explode(",", $woe_times[$i]);

		if (!isset($woe_times[$i][2]))

			continue;



		$day = $week_day[$woe_times[$i][0]];

		$start = $woe_times[$i][1];

		$end = $woe_times[$i][2];

		echo "<tr><td align=\"right\">$day</td><td>&nbsp;</td><td align=\"left\">$start - $end</td></tr>";

	}

}



function readitems() {

	$resp[] = "unknown";

	if (!($handle = fopen("./db/item_db.txt", "rt")))

		return $resp;

	while ($line = fgets($handle, 1024)) {

		if (($line[0] == '/' && $line[1] == '/') || $line[0] == '\0' || $line[0] == '\n' || $line[0] == '\r')

			continue;

		$item = explode(',', $line, 4);

		if (isset($item[0]) && isset($item[1])) {

			$resp[$item[0]] = $item[2];

		}

	}	

	$resp[0] = " ";

	fclose($handle);

	return $resp;

}



function readjobs() {

	global $lang;



	$resp[] = "unknown";

	$handle = fopen("./db/jobs.txt", "rt")

		or die(htmlformat($lang['TXT_ERROR']));

	while ($line = fgets($handle, 1024)) {

		if (($line[0] == '/' && $line[1] == '/') || $line[0] == '\0' || $line[0] == '\n' || $line[0] == '\r')

			continue;

		$job = sscanf($line, "%s %d");

		if (isset($job[0]) && isset($job[1])) {

			for($i = 1; isset($job[0][$i]); $i++)

				if ($job[0][$i] == '_') $job[0][$i] = ' ';

			$resp[$job[1]] = $job[0];

		}

	}	

	fclose($handle);

	return $resp;

}



function htmlformat($string) {

	$resp = "";

	for ($i = 0; isset($string[$i]) && ord($string[$i]) > 0; $i++)

		$resp .= "&#".ord($string[$i]).";";

	return $resp;

}



function moneyformat($string) {

	$string = trim($string);

	$return = "";

	$len = strlen($string) - 1;



	for ($i = 0; $i < strlen($string); $i++) {

		if ($i > 0 && $i % 3 == 0)

			$return = ",".$return;

		$return = $string[$len - $i].$return;

	}



	return $return;

}



function inject($string) {

	$permitido = "abcdefghijklmnopqrstuvxzwyABCDEFGHIJKLMNOPQRSTUVXZWY1234567890._@-&$/§*°ºª"; //dicionario de palavras permitidas

	for ($i=0; $i<strlen($string); $i++) {

		if (strpos($permitido, substr($string, $i, 1)) === FALSE) return TRUE;

	}

	return FALSE;

}



function notnumber($string) {

	$permitido = "1234567890"; //numeros

	for ($i=0; $i<strlen($string); $i++) {

		if (strpos($permitido, substr($string, $i, 1)) === FALSE) return TRUE;

	}

	return FALSE;

}



function thepass($string) {

	global $lang;



	$string = trim($string);



	$numero = 0;

	for ($i = 0; isset($string[$i]); $i++) {

		if (!notnumber($string[$i]))

			$numero++;

	}



	if ($numero < 2)

		return TRUE;

	if ($numero == strlen($string))

		return TRUE;

	if ((strlen($string) - $numero) < 2)

		return TRUE;



	$handle = fopen("./db/passdict.txt", "rt")

		or die(htmlformat($lang['TXT_ERROR']));

	while ($line = fgets($handle, 1024)) {

		if (($line[0] == '/' && $line[1] == '/') || $line[0] == '\0' || $line[0] == '\n' || $line[0] == '\r')

			continue;

		if (strcmp(trim($string), trim($line)) === 0) {

			fclose($handle);

			return TRUE;

		}

	}	

	fclose($handle);



	return FALSE;

}



function truedate($day, $month, $year) {

	$diames = array (

		1  => 31,

		2  => 28,

		3  => 31,

		4  => 30,

		5  => 31,

		6  => 30,

		7  => 31,

		8  => 31,

		9  => 30,

		10 => 31,

		11 => 30,

		12 => 31,

	);

	if (($year % 4) === 0)

		$diames[2] = 29;



	if ($day > $diames[$month])

		return 0;



	return mktime(0, 0, 0, $month, $day, $year);

}



function is_online() {

	global $CONFIG_name, $lang;



	if (empty($_SESSION[$CONFIG_name.'account_id'])) 

		redir("motd.php", "main_div", htmlformat($lang['NEED_TO_LOGIN_F']));



	$log_account = $_SESSION[$CONFIG_name.'account_id'];



	$query = sprintf(IS_ONLINE, $log_account);

	$result = execute_query($query, 'is_online');



	$result->fetch_row();



	return $result->row[0];

}



function online_count() {

	$query = sprintf(GET_ONLINE);

	$result = execute_query($query, 'online_count', 0, 0);



	$result->fetch_row();



	return $result->row[0];

}



function check_ban() {

	$query = sprintf(CHECK_BAN, $_SERVER['REMOTE_ADDR']);

	$result = execute_query($query, 'check_ban', 0, 0);



	if ($result->count()) {

		while ($line = $result->fetch_row()) {

			if (($line[2] == 5 || $line[1] > 0) && (time() - $line[0]) < (86400 * 2)) //2 dias

				return 1;

		}

	}



	return 0;

}



function forger($hint, $lint) {

	$result = 0;

	$result = $lint * 65536;

	if ($hint > 0)

		return ($result + $lint);

	return ($result + 65536 + $hint);

}



function execute_query($query, $source = 'none.php', $database = 0, $save_report = 1) {

	global $mysql;



	$query = str_replace("\r\n", " ", $query);

	if ($save_report)

		add_query_entry($source, $query);



	if ($result = $mysql->Query($query, $database)) {

		if (strpos($query,"SELECT") === 0)

			return $result;

		return TRUE;

	}

	return FALSE;

}



function add_query_entry($source, $log_query) {

	global $CONFIG_name, $CONFIG_cp_db, $CONFIG_db_serv, $CONFIG_db_user, $CONFIG_db_pass;

	if (!empty($_SESSION[$CONFIG_name.'account_id'])) 

		$log_account = $_SESSION[$CONFIG_name.'account_id'];

	else

		$log_account = 0;

	$log_ip = $_SERVER['REMOTE_ADDR'];

	$log_query = addslashes($log_query);

	$query = sprintf(ADD_QUERY_ENTRY, $log_account, $log_ip, $source, $log_query);



	execute_query($query, 'none.php', 1, 0);

}



// o retorno eh em compara?o binaria
// ($var & 1) - se TRUE login online
// ($var & 2) - se TRUE char  online
// ($var & 4) - se TRUE map   online
function server_status() {
	global $CONFIG_accip,$CONFIG_accport,$CONFIG_charip,$CONFIG_charport,$CONFIG_mapip,$CONFIG_mapport;

	$query = sprintf(CHECK_STATUS);
	$result = execute_query($query, 'server_status', 1, 0);
	if (!($line = $result->fetch_row())) {
		$query = sprintf(INSERT_STATUS);
		$result = execute_query($query, 'server_status', 1, 0);
		$line[0] = 0;
	}
	$retorno = 0;
	if ($line[2] > 300 || $line[1] < 7) {
		$acc = @fsockopen ($CONFIG_accip, $CONFIG_accport, $errno, $errstr, 1);
		$char = @fsockopen ($CONFIG_charip, $CONFIG_charport, $errno, $errstr, 1);
		$map = @fsockopen ($CONFIG_mapip, $CONFIG_mapport, $errno, $errstr, 1);
		if ($acc > 1) $retorno += 1;
		if ($char > 1) $retorno += 2;
		if ($map > 1) $retorno += 4;
		$query = sprintf(UPDATE_STATUS, $retorno);
		$result = execute_query($query, 'server_status', 1, 0);
	}
	else {
		$retorno = $line[1];
	}
	return $retorno;
}


function redir($page, $div, $msg) {

	opentable("Status");

	echo "<tr><td><span style=\"cursor:pointer\" onMouseOver=\"this.style.color='#FF3300'\" onMouseOut=\"this.style.color='#000000'\"

	onClick=\"return LINK_ajax('$page','$div')\"><b>".$msg."</span></tr></td>";

	closetable();

	fim();

}



function alert($alertmsg) {

	$trans_tbl = get_html_translation_table (HTML_ENTITIES);

	$trans_tbl = array_flip ($trans_tbl);

	$alertmsg = strtr ($alertmsg, $trans_tbl);



	echo "ALERT|".utf8_encode($alertmsg)."|ENDALERT";

	fim();

}



function fim() {

	global $mysql;

	$mysql->finish();

	exit(0);

}



function opentable($titulo) {

	echo "

<center><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">

	<tbody>

		<tr>

			<th height=\"28\" class=\"title\">".$titulo."</th>

		</tr>

		<tr>

			<td>

	";

}



function closetable() {

	echo "

			</td>

		</tr>

	</tbody>

</table></center>

	";

}



function read_maildef($file) {

	global $lang;

	$handle = fopen("./language/mail/".$file.".txt", "rt")

		or die(htmlformat($lang['TXT_ERROR']));

	$maildef="";

	while ($line = fgets($handle, 1024)) {

		if ($line[0] == '/' && $line[1] == '/')

			continue;

		$maildef .= $line;

	}

	fclose($handle);

	return $maildef;

}



function erro_de_login($i = 0) {

	session_destroy();

	setcookie("login_pass", "", time() - 3600);

	setcookie("userid", "", time() - 3600);

	session_start();

	echo "<script type=\"text/javascript\">";

	echo "LINK_ajax('login.php', 'login_div');";

	if (!$i)

		echo "LINK_ajax('motd.php','main_div');";

	echo "</script>";

}



/* =================================================================================================================================================================*/



?>



