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

if (!empty($_SESSION[$CONFIG_name.'account_id']) && $CONFIG_set_slot) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {

		if (is_online())
			redir("index.php", "main_div", $lang['NEED_TO_LOGOUT_F']);

		if (!empty($GET_opt)) {
			if ($GET_opt == 1) {
				if (!isset($GET_newslot) || $GET_newslot == $GET_slot)
					alert($lang['SLOT_NOT_SELECTED']);

				if (notnumber($GET_char_id) || notnumber($GET_newslot) || notnumber($GET_slot))
					alert($lang['SLOT_CHANGE_FAILED']);

				if ($GET_newslot < 0 || $GET_newslot > 11 || $GET_slot < 0 ||  $GET_slot > 11)
					alert($lang['SLOT_WRONG_NUMBER']);
				
				$query = sprintf(CHECK_SLOT, $GET_newslot, $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, "slot.php");

				if ($line = $result->fetch_row()) {
					$query = sprintf(CHANGE_SLOT, $GET_slot, $line[0], $_SESSION[$CONFIG_name.'account_id']);
					$result = execute_query($query, "slot.php");
				}

				$query = sprintf(CHANGE_SLOT, $GET_newslot, $GET_char_id, $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, "slot.php");
			}
		}
		$query = sprintf(GET_SLOT, $_SESSION[$CONFIG_name.'account_id']);
		$result = execute_query($query, "slot.php");

		if ($result->count() < 1)
			redir("slot.php", "main_div", $lang['ONE_CHAR']);

		opentable($lang['SLOT_CHANGE_SLOT']);
		echo "
		<table width=\"400\">
		<tr>
			<td align=\"right\" class=\"head\">".$lang['SLOT']."</td>
			<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
			<td align=\"center\" class=\"head\">".$lang['SLOT_NEW_SLOT']."</td>
		</tr>
		";
		for ($j = 0; $line = $result->fetch_row(); $j++) {
			$GID = $line[0];
			$slot = $line[1];
			$charname = htmlformat($line[2]);
			echo "
			<tr>
				<td align=\"right\">$slot</td>
				<td align=\"left\">$charname</td>
				<td align=\"center\">
				<form id=\"slot$j\" onsubmit=\"return GET_ajax('slot.php','main_div','slot$j')\">
					<select name=\"newslot\">";
			for ($i = 0; $i < 12; $i++) {
				if ($slot == $i)
					echo "<option value=\"$i\" selected>$i";
				else
					echo "<option value=\"$i\">$i";
			}
			echo "</select>
						<input type=\"submit\" value=\"".$lang['CHANGE']."\">
						<input type=\"hidden\" name=\"opt\" value=\"1\">
						<input type=\"hidden\" name=\"slot\" value=\"$slot\">
						<input type=\"hidden\" name=\"char_id\" value=\"$GID\">
				</form>
				</td>
			</tr>
			";
		}
		echo "</table>
			<table>
				<tr><td align=\"left\">".$lang['SLOT_PS1']."</td></tr>
				<tr><td align=\"left\">".$lang['SLOT_PS2']."</td></tr>
			</table>";
		closetable();
	}
	fim();
}

redir("motd.php", "main_div", $lang['NEED_TO_LOGIN']);
?>