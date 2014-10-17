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

if (!empty($_SESSION[$CONFIG_name.'account_id']) && $CONFIG_money_transfer) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {

		if (is_online())
			redir("motd.php", "main_div", $lang['NEED_TO_LOGOUT_F']);

		if (!empty($GET_opt)) {
			if ($GET_opt == 3) {
				if (notnumber($GET_GID1) || notnumber($GET_GID2) || notnumber($GET_zeny))
					alert($lang['MONEY_INCORRECT_NUMBER']);

				if ($GET_GID1 == $GET_GID2 || $GET_zeny < 0)
					redir("motd.php", "main_div", $lang['MONEY_CHEAT_DETECTED']);

				$query = sprintf(CHECK_ZENY, $GET_GID1, $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, "money.php");
				$line = $result->fetch_row();
				$zeny1 = $line[0];

				$query = sprintf(CHECK_ZENY, $GET_GID2, $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, "money.php");
				$line = $result->fetch_row();
				$zeny2 = $line[0];

				$cost = (int)($GET_zeny * $CONFIG_money_cost / 10000);
				$less = $zeny1 - ($GET_zeny + $cost);
				$more = $zeny2 + $GET_zeny;
				if ($less < 0)
					alert("Not enough zeny.");
				if ($less > 999999999)
					redir("motd.php", "main_div", $lang['MONEY_OPER_IMPOSSIBLE']);
				if ($more > 999999999)
					redir("motd.php", "main_div", $lang['MONEY_OPER_IMPOSSIBLE']);

				$query = sprintf(SET_ZENY, $less, $GET_GID1, $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, "money.php");
				$query = sprintf(SET_ZENY, $more, $GET_GID2, $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, "money.php");

				$ban_until = time() + (2 * 60); // 2 minutos pra fazer efeito //testando vicous pucca
				$query = sprintf(PARTNER_BAN, $ban_until, $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, "money.php");

				
				if (is_online()) {
					$query = sprintf(SET_ZENY, $zeny1, $GET_GID1, $_SESSION[$CONFIG_name.'account_id']);
					$result = execute_query($query, "money.php");
					$query = sprintf(SET_ZENY, $zeny2, $GET_GID2, $_SESSION[$CONFIG_name.'account_id']);
					$result = execute_query($query, "money.php");
					redir("motd.php", "main_div", $lang['NEED_TO_LOGOUT_F']);
				}
				redir("money.php", "main_div", $lang['MONEY_OK']);
			}
			if ($GET_opt == 2) {
				opentable($lang['MONEY_AMMOUNT']);
				echo "
				<form id=\"money\" onsubmit=\"return GET_ajax('money.php','main_div','money')\"><table>
				<tr><td align=\"right\">".$lang['MONEY_AVAILABLE'].":</td><td align=\"left\">$GET_zeny1</td></tr>
				<tr><td align=\"right\">".$lang['MONEY_TRANSFER'].":</td><td align=\"left\">
					<input type=text name=zeny maxlength=23 size=23></td></tr>
				<input type=\"hidden\" name=\"GID1\" value=\"$GET_GID1\">
				<input type=\"hidden\" name=\"GID2\" value=\"$GET_GID2\">
				<input type=\"hidden\" name=\"opt\" value=\"3\">
				<tr><td>&nbsp;</td><td><input type=\"submit\" value=\"".$lang['MONEY_CHANGE']."\"></td></tr>
				</table></form>
				";
				if ($CONFIG_money_cost) {
					$cost = $CONFIG_money_cost / 100;
					$lang['MONEY_PS1'] = sprintf($lang['MONEY_PS1'], $cost);
					echo "
						<table>
							<tr><td align=\"left\">".$lang['MONEY_PS1']."</td></tr>
						</table>
					";
				}
				closetable();
				fim();
			}
			if ($GET_opt == 1) {
				$query = sprintf(GET_ZENY, $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, "money.php");

				if ($result->count() < 2)
					redir("motd.php", "main_div", $lang['MONEY_TWO_CHAR']);

				opentable($lang['MONEY_TRANSFER_TO']);
				echo "
				<table width=\"400\">
				<tr>
					<td align=\"left\" class=\"head\">".$lang['SLOT']."</td>
					<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
					<td align=\"right\" class=\"head\">".$lang['ZENY']."</td>
				</tr>
				";
				while ($line = $result->fetch_row()) {
					$GID = $line[0];
					$slot = $line[1];
					$charname = htmlformat($line[2]);
					$zeny = $line[3];
					$clevel = $line[4];
					if ($GID != $GET_GID1) {
						echo "    
						<tr>
						<td align=\"left\">$slot</td>
						<td align=\"left\">$charname</td>
						<td align=\"right\">$zeny</td>
						<td>
						";
						if ($clevel >= 20) {
							echo "
							<form id=\"money$slot\" onsubmit=\"return GET_ajax('money.php','main_div','money$slot')\">
									<input type=\"submit\" value=\"select\">
									<input type=\"hidden\" name=\"opt\" value=\"2\">
									<input type=\"hidden\" name=\"zeny1\" value=\"$GET_zeny1\">
									<input type=\"hidden\" name=\"GID2\" value=\"$GID\">
									<input type=\"hidden\" name=\"GID1\" value=\"$GET_GID1\">
							</form>
							";
						}
						echo "
							</td>
							</tr>
						";
					}
				}
				echo "</table>";
				if ($CONFIG_money_cost) {
					$cost = $CONFIG_money_cost / 100;
					$lang['MONEY_PS1'] = sprintf($lang['MONEY_PS1'], $cost);
					echo "
						<table>
							<tr><td align=\"left\">".$lang['MONEY_PS1']."</td></tr>
						</table>
					";
				}
				closetable();
				fim();
			}
		}
		$query = sprintf(GET_ZENY, $_SESSION[$CONFIG_name.'account_id']);
		$result = execute_query($query, "money.php");

		if ($result->count() < 2)
			redir("motd.php", "main_div", $lang['MONEY_TWO_CHAR']);

		opentable($lang['MONEY_TRANSFER_FROM']);
		echo "
		<table width=\"400\">
		<tr>
			<td align=\"left\" class=\"head\">".$lang['SLOT']."</td>
			<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
			<td align=\"right\" class=\"head\">".$lang['ZENY']."</td>
		</tr>
		";
		while ($line = $result->fetch_row()) {
			$GID = $line[0];
			$slot = $line[1];
			$charname = htmlformat($line[2]);
			$zeny = moneyformat($line[3]);
			$clevel = $line[4];
			echo "    
			<tr>
				<td align=\"left\">$slot</td>
				<td align=\"left\">$charname</td>
				<td align=\"right\">$zeny</td>
				<td>
			";
			if ($clevel >= 20) {
				echo "
					<form id=\"money$slot\" onsubmit=\"return GET_ajax('money.php','main_div','money$slot')\">
						<input type=\"submit\" value=\"select\">
						<input type=\"hidden\" name=\"opt\" value=\"1\">
						<input type=\"hidden\" name=\"zeny1\" value=\"$zeny\">
						<input type=\"hidden\" name=\"GID1\" value=\"$GID\">
					</form>
				";
			}
			echo "
					</td>
				</tr>
			";
		}
		echo "</table>";
		if ($CONFIG_money_cost) {
			$cost = $CONFIG_money_cost / 100;
			$lang['MONEY_PS1'] = sprintf($lang['MONEY_PS1'], $cost);
			echo "
				<table>
					<tr><td align=\"left\">".$lang['MONEY_PS1']."</td></tr>
				</table>
			";
		}
		closetable();
	}
	fim();
}

redir("motd.php", "main_div", $lang['NEED_TO_LOGIN']);
?>
