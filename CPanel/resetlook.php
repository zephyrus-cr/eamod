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

if (!empty($_SESSION[$CONFIG_name.'account_id']) && $CONFIG_reset_enable) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {

		if (!empty($GET_opt)) {
			if ($GET_opt == 1) {
				if (is_online()) 
					alert($lang['NEED_TO_LOGOUT_F']);

				if (inject($GET_GID1)) 
					alert($lang['RESETLOOK_RESET_LOOK']);
				
				if (isset($GET_equip) && $GET_equip > 0) {
					$query = sprintf(LOOK_EQUIP, $GET_GID1, $_SESSION[$CONFIG_name.'account_id']);
					$result = execute_query($query, "resetlook.php");
		
					$query = sprintf(LOOK_INVENTORY, $GET_GID1);
					$result = execute_query($query, "resetlook.php");
					alert($lang['RESETLOOK_EQUIP_OK']);
				}

				if (isset($GET_hair_color) && $GET_hair_color > 0) {
					$query = sprintf(LOOK_HAIR_COLOR, $GET_GID1, $_SESSION[$CONFIG_name.'account_id']);
					$result = execute_query($query, "resetlook.php");
					alert($lang['RESETLOOK_HAIRC_OK']);
				}

				if (isset($GET_hair_style) && $GET_hair_style > 0) {
					$query = sprintf(LOOK_HAIR_STYLE, $GET_GID1, $_SESSION[$CONFIG_name.'account_id']);
					$result = execute_query($query, "resetlook.php");
					alert($lang['RESETLOOK_HAIRS_OK']);
				}

				if (isset($GET_clothes_color) && $GET_clothes_color > 0) {
					$query = sprintf(LOOK_CLOTHES_COLOR, $GET_GID1, $_SESSION[$CONFIG_name.'account_id']);
					$result = execute_query($query, "resetlook.php");
					alert($lang['RESETLOOK_CLOTHESC_OK']);
				}

				alert($lang['RESETLOOK_SELECT']);
			}
		}

		$query = sprintf(LOOK_GET_CHARS, $_SESSION[$CONFIG_name.'account_id']);
		$result = execute_query($query, "resetlook.php");

		if ($result->count() < 1)
			redir("motd.php", "main_div", $lang['ONE_CHAR']);

		opentable($lang['RESETLOOK_RESETLOOK']);
		echo "
		<table width=\"595\">
		<tr>
			<td align=\"right\" class=\"head\">".$lang['SLOT']."</td>
			<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
		</tr>
		";
		while ($line = $result->fetch_row()) {
			$GID = $line[0];
			$slot = $line[1];
			$charname = htmlformat($line[2]);
			echo "    
			<tr>
				<td align=\"right\">$slot</td>
				<td align=\"left\">$charname</td>
				<td align=\"center\">
					<form id=\"equip$slot\" onsubmit=\"return GET_ajax('resetlook.php','main_div','equip$slot')\">
						<input type=\"hidden\" name=\"equip\" value = 1>
						<input type=\"hidden\" name=\"charnum\" value=\"$slot\">
						<input type=\"hidden\" name=\"opt\" value=\"1\">
						<input type=\"hidden\" name=\"GID1\" value=\"$GID\">
						<input type=\"submit\" value=\"equip\">
					</form>
				</td><td align=\"center\">
					<form id=\"hair_style$slot\" onsubmit=\"return GET_ajax('resetlook.php','main_div','hair_style$slot')\">
						<input type=\"hidden\" name=\"hair_style\" value = 1>
						<input type=\"hidden\" name=\"charnum\" value=\"$slot\">
						<input type=\"hidden\" name=\"opt\" value=\"1\">
						<input type=\"hidden\" name=\"GID1\" value=\"$GID\">
						<input type=\"submit\" value=\"Hair Style\">
					</form>
				</td><td align=\"center\">
					<form id=\"clothes_color$slot\" onsubmit=\"return GET_ajax('resetlook.php','main_div','clothes_color$slot')\">
						<input type=\"hidden\" name=\"clothes_color\" value = 1>
						<input type=\"hidden\" name=\"charnum\" value=\"$slot\">
						<input type=\"hidden\" name=\"opt\" value=\"1\">
						<input type=\"hidden\" name=\"GID1\" value=\"$GID\">
						<input type=\"submit\" value=\"Clothes Color\">
					</form>
				</td><td align=\"center\">
					<form id=\"hair_color$slot\" onsubmit=\"return GET_ajax('resetlook.php','main_div','hair_color$slot')\">
						<input type=\"hidden\" name=\"hair_color\" value = 1>
						<input type=\"hidden\" name=\"charnum\" value=\"$slot\">
						<input type=\"hidden\" name=\"opt\" value=\"1\">
						<input type=\"hidden\" name=\"GID1\" value=\"$GID\">
						<input type=\"submit\" value=\"Hair Color\">
					</form>
				</td>
			</tr>
			";
		}
		echo "</table>";
		closetable();
	}
	fim();
}

redir("motd.php", "main_div", $lang['NEED_TO_LOGIN']);
?>
