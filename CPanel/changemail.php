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

if (!empty($_SESSION[$CONFIG_name.'account_id'])) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {

		if (!empty($POST_opt)) {
			if ($POST_opt == 1 && isset($POST_frm_name) && !strcmp($POST_frm_name, "changemail")) {
				if (strlen($POST_email) < 7 || !strstr($POST_email, '@') || !strstr($POST_email, '.'))
					alert($lang['CHANGEMAIL_MAIL_INVALID']);

				if (inject($POST_email) || inject($POST_login_pass)) 
					alert($lang['INCORRECT_CHARACTER']);

				if (strlen($POST_login_pass) < 4 || strlen($POST_login_pass) > 23)
					alert($lang['PASSWORD_LENGTH_OLD']);

				if ($CONFIG_md5_pass)
					$POST_login_pass = md5($POST_login_pass);

				$query = sprintf(CHANGE_EMAIL, $POST_email, $POST_login_pass, $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, 'changemail.php');
			}
		}


	$query = sprintf(CHECK_EMAIL, $_SESSION[$CONFIG_name.'account_id']);
	$result = execute_query($query, 'changemail.php');

	$cemail = $result->fetch_row();
	$cemail[0] = htmlformat($cemail[0]);

	opentable($lang['CHANGEMAIL_CHANGEMAIL']);
		echo "
		<form id=\"changemail\" onsubmit=\"return POST_ajax('changemail.php','main_div','changemail')\"><table>
		<tr><td align=\"right\">".$lang['CHANGEMAIL_CURRENT_MAIL'].":</td><td align=\"left\">$cemail[0]</td></tr>
		<tr><td align=\"right\">".$lang['CHANGEMAIL_NEW_MAIL'].":</td><td align=\"left\">
		<input type=\"text\" name=\"email\" maxlength=\"40\" size=\"40\" onKeyPress=\"return force(this.name,this.form.id,event);\">
			</td></tr>
		<tr><td align=right>".$lang['PASSWORD'].":</td><td align=\"left\">
		<input type=\"password\" name=\"login_pass\" maxlength=\"23\" size=\"23\" onKeyPress=\"return force(this.name,this.form.id,event);\">
		</td></tr>
		<input type=\"hidden\" name=\"opt\" value=\"1\">
		<tr><td>&nbsp;</td><td><input type=\"submit\" value=\"".$lang['CHANGEMAIL_CHANGE']."\"></td></tr>
		</table></form>
		";
	closetable();
	fim();
	}
}
redir("motd.php", "main_div", $lang['NEED_TO_LOGIN']);
?>
