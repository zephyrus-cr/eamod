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
include_once 'adminquery.php';
include_once 'functions.php';

if (!isset($_SESSION[$CONFIG_name.'level']) || $_SESSION[$CONFIG_name.'level'] < $CONFIG['cp_admin'])
	die ("Not Authorized");

$items = readitems();

echo "
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
<html>
	<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
		<title>
			Ceres Control Panel - Charactere Details
		</title>
		<link rel=\"stylesheet\" type=\"text/css\" href=\"./ceres.css\">
	</head>

<BODY>
";

opentable("Char Detail");

if (isset($GET_id) && !notnumber($GET_id)) {
	$jobs = $_SESSION[$CONFIG_name.'jobs'];

	$query = sprintf(CHARINFO_CHAR, trim($GET_id));
	$answere = execute_query($query, 'admincharinfo.php');
	echo "
		<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" width=\"400\">
	";
	if ($result = $answere->fetch_row()) {
		$acc_id = $result[1];
		$class = $result[4];
		echo "
			<tr>
				<td align=\"right\" class=\"head\">Name:&nbsp;</td><td align=\"left\">$result[3]</td>
				<td align=\"right\" class=\"head\">Job:&nbsp;</td><td align=\"left\">
			";
		if (isset($jobs[$result[4]]))
			echo $jobs[$result[4]];
		else
			echo "unknown";
		echo "
			</tr>
			<tr>
				<td align=\"right\" class=\"head\">Level:&nbsp;</td><td align=\"left\">$result[5]/$result[6]</td>
				<td align=\"right\" class=\"head\">Zeny:&nbsp;</td><td align=\"left\">$result[9]</td>
			<tr>
				<td align=\"right\" class=\"head\">STR:&nbsp;</td><td align=\"left\">$result[10]</td>
				<td align=\"right\" class=\"head\">AGI:&nbsp;</td><td align=\"left\">$result[11]</td>
				<td align=\"right\" class=\"head\">VIT:&nbsp;</td><td align=\"left\">$result[12]</td>
			</tr>
			<tr>
				<td align=\"right\" class=\"head\">INT:&nbsp;</td><td align=\"left\">$result[13]</td>
				<td align=\"right\" class=\"head\">DEX:&nbsp;</td><td align=\"left\">$result[14]</td>
				<td align=\"right\" class=\"head\">LUK:&nbsp;</td><td align=\"left\">$result[15]</td>
			</tr>
			</table>
		";
	}
	$query = sprintf(CHARINFO_INVENTORY, trim($GET_id));
	$answere = execute_query($query, 'admincharinfo.php');
	echo "
		<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" width=\"700\">
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class=\"head\">INVENTORY</td>
		</tr>
		<tr>
			<td align=\"center\" class=\"head\">Item</td>
			<td align=\"center\" class=\"head\">Amount</td>
			<td align=\"center\" class=\"head\">Refine</td>
			<td align=\"center\" class=\"head\">Card0</td>
			<td align=\"center\" class=\"head\">Card1</td>
			<td align=\"center\" class=\"head\">Card2</td>
			<td align=\"center\" class=\"head\">Card3</td>
		</tr>
	";
	while ($result = $answere->fetch_row()) {
		echo "
			<tr>
				<td align=\"center\">
		";
		if (isset($items[$result[0]]))
			echo $items[$result[0]];
		else
			echo $result[0];
		echo "
				</td>
				<td align=\"center\">$result[1]</td>
				<td align=\"center\">$result[6]</td>
				<td align=\"center\">
		";

		if ($result[2] == 255) {
			echo "
				forger</td>
				<td align=\"center\">
			";
			echo forger($result[4], $result[5]);
			echo "
				</td>
				<td align=\"center\">
				</td>
				<td align=\"center\">
				</td>
			</tr>
			";
			continue;
		}

		if (isset($items[$result[2]]))
			echo $items[$result[2]];
		else
			echo $result[2];
		echo "
				</td>
				<td align=\"center\">
		";
		if (isset($items[$result[3]]))
			echo $items[$result[3]];
		else
			echo $result[3];
		echo "
				</td>
				<td align=\"center\">
		";
		if (isset($items[$result[4]]))
			echo $items[$result[4]];
		else
			echo $result[4];
		echo "
				</td>
				<td align=\"center\">
		";
		if (isset($items[$result[5]]))
			echo $items[$result[5]];
		else
			echo $result[5];
		echo "
				</td>
			</tr>
		";
	}

	$query = sprintf(CHARINFO_STORAGE, trim($acc_id));
	$answere = execute_query($query, 'admincharinfo.php');
	echo "
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class=\"head\">STORAGE</td>
		</tr>
		<tr>
			<td align=\"center\" class=\"head\">Item</td>
			<td align=\"center\" class=\"head\">Amount</td>
			<td align=\"center\" class=\"head\">Refine</td>
			<td align=\"center\" class=\"head\">Card0</td>
			<td align=\"center\" class=\"head\">Card1</td>
			<td align=\"center\" class=\"head\">Card2</td>
			<td align=\"center\" class=\"head\">Card3</td>
		</tr>
	";
	while ($result = $answere->fetch_row()) {
		echo "
			<tr>
				<td align=\"center\">
		";
		if (isset($items[$result[0]]))
			echo $items[$result[0]];
		else
			echo $result[0];
		echo "
				</td>
				<td align=\"center\">$result[1]</td>
				<td align=\"center\">$result[6]</td>
				<td align=\"center\">
		";

		if ($result[2] == 255) {
			echo "
				forger</td>
				<td align=\"center\">
			";
			echo forger($result[4], $result[5]);
			echo "
				</td>
				<td align=\"center\">
				</td>
				<td align=\"center\">
				</td>
			</tr>
			";
			continue;
		}

		if (isset($items[$result[2]]))
			echo $items[$result[2]];
		else
			echo $result[2];
		echo "
				</td>
				<td align=\"center\">
		";
		if (isset($items[$result[3]]))
			echo $items[$result[3]];
		else
			echo $result[3];
		echo "
				</td>
				<td align=\"center\">
		";
		if (isset($items[$result[4]]))
			echo $items[$result[4]];
		else
			echo $result[4];
		echo "
				</td>
				<td align=\"center\">
		";
		if (isset($items[$result[5]]))
			echo $items[$result[5]];
		else
			echo $result[5];
		echo "
				</td>
			</tr>
		";
	}

	switch ($class) {
		case 5:
		case 10:
		case 18:
		case 4006:
		case 4011:
		case 4019:
		case 4028:
		case 4033:
		case 4041:
			$query = sprintf(CHARINFO_CART, trim($GET_id));
			$answere = execute_query($query, 'admincharinfo.php');
			echo "
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class=\"head\">CART</td>
		</tr>
		<tr>
			<td align=\"center\" class=\"head\">Item</td>
			<td align=\"center\" class=\"head\">Amount</td>
			<td align=\"center\" class=\"head\">Refine</td>
			<td align=\"center\" class=\"head\">Card0</td>
			<td align=\"center\" class=\"head\">Card1</td>
			<td align=\"center\" class=\"head\">Card2</td>
			<td align=\"center\" class=\"head\">Card3</td>
		</tr>
			";
			while ($result = $answere->fetch_row()) {
				echo "
			<tr>
				<td align=\"center\">
				";
				if (isset($items[$result[0]]))
					echo $items[$result[0]];
				else
					echo $result[0];
				echo "
				</td>
				<td align=\"center\">$result[1]</td>
				<td align=\"center\">$result[6]</td>
				<td align=\"center\">
				";

				if ($result[2] == 255) {
					echo "
				forger</td>
				<td align=\"center\">
					";
					echo forger($result[4], $result[5]);
					echo "
				</td>
				<td align=\"center\">
				</td>
				<td align=\"center\">
				</td>
			</tr>
					";
					continue;
				}

				if (isset($items[$result[2]]))
					echo $items[$result[2]];
				else
					echo $result[2];
				echo "
				</td>
				<td align=\"center\">
				";
				if (isset($items[$result[3]]))
					echo $items[$result[3]];
				else
					echo $result[3];
				echo "
				</td>
				<td align=\"center\">
				";
				if (isset($items[$result[4]]))
					echo $items[$result[4]];
				else
					echo $result[4];
				echo "
				</td>
				<td align=\"center\">
				";
				if (isset($items[$result[5]]))
					echo $items[$result[5]];
				else
					echo $result[5];
				echo "
				</td>
			</tr>
				";
			}
		default:
			break;
	}

	echo "</table>";

} else echo "Not Found";

echo "<table width=\"500\"><tr><td align=\"center\"><span title=\"Close this window\" style=\"cursor:pointer\" onMouseOver=\"this.style.color='#FF3300'\" onMouseOut=\"this.style.color='#000000'\" onClick=\"window.close();\"><b>CLOSE</b></span></td></tr></table>";

closetable();
echo "</body></html>";
fim();
?>
