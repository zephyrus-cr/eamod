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
include_once 'functions.php';

$langdir = opendir ("language/");
while ($file = readdir($langdir)) {
	if (strcmp(substr($file, strlen($file) - 4, 4), ".php") == 0) {
		$file = substr($file, 0, strlen($file) - 4);
		if (strcmp($file, "index") != 0 && strcmp($file, "language") != 0)
			$idiom[] = $file;
	}
}
closedir($langdir);

if (isset($_COOKIE['language']))
	$selected = $_COOKIE['language'];
else
	$selected = $CONFIG_language;

if (isset($GET_language)) {
	setcookie("language", $GET_language, time() + 3600 * 24 * 30);
	echo "
	<script type=\"text/javascript\">
		load_menu();
		login_hide(2);
		server_status();
		LINK_ajax('motd.php', 'main_div');
		LINK_ajax('login.php', 'login_div');
	</script>
	";
	$selected = $GET_language;
}

opentable("");
echo "
<form id=\"selectlang\">
	<select name = \"language\" onChange=\"javascript:GET_ajax('selectlang.php', 'selectlang_div', 'selectlang');\">
	";

for ($i = 0; isset($idiom[$i]); $i++) {
	if (strcmp($selected, $idiom[$i]) === 0)
		echo "<option selected value=\"$idiom[$i]\">$idiom[$i]</option>"; 
	else
		echo "<option value=\"$idiom[$i]\">$idiom[$i]</option>";
}

echo "
	</select>
</form>
";
closetable();
fim();
?>
