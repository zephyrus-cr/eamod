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


//if (!empty($_SESSION[$CONFIG_name.'account_id'])) {
//	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {
//


			$query = sprintf(GUILD_CASTLE);
			$result = execute_query($query, "guild.php");
			opentable($lang['GUILD_GCASTLES']);
			$castles = $_SESSION[$CONFIG_name.'castles'];
			echo "
			<table>
			<tr>
				<td align=\"center\" class=\"head\">".$lang['GUILD_EMBLEM']."</td> 
				<td>&nbsp;</td>
				<td align=\"left\" class=\"head\">".$lang['GUILD_GNAME']."</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align=\"left\" class=\"head\">".$lang['GUILD_GCASTLE']."</td>
				</tr>
			";
			for ($i = $i; $line = $result->fetch_row(); $i++) {
				$gname = htmlformat($line[0]);
				if (isset($castles[$line[2]]))
					$cname = $castles[$line[2]];
				else 
					continue;
				$emblems[$line[3]] = $line[1];
				echo "
				<tr>
					<td align=\"center\"><img src=\"emblema.php?data=$line[3]\" alt=\"$gname\"></td>
					<td>&nbsp;</td>
					<td align=\"left\">$gname</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"left\">$cname</td>
				</tr>";
			}
			echo "</table>";
			
			
				if( isset($emblems) )
		$_SESSION[$CONFIG['Name'] . 'emblems'] = $emblems;
			
			closetable();
	

//	}
	fim();
//}


//redir("index.php", "main_div", "You need to be logged to use this page.");
?>
