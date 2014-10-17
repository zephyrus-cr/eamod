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

$jobs = $_SESSION[$CONFIG_name.'jobs'];

$query = sprintf(RANKVOTA);
$result = execute_query($query, "topvota.php");

opentable("Ranking de TOP Votaciones");
echo "
<hr><table width=\"600\">
<tr>
	<td align=\"right\" class=\"head\">".$lang['POS']."</td>
	<td>&nbsp;</td>
	<td align=\"center\" class=\"head\">Sexo</td>
	<td>&nbsp;</td>
	<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
	<td>&nbsp;</td>
	<td align=\"center\" class=\"head\">".$lang['CLASS']."</td>
	<td align=\"center\" class=\"head\">Veces que voto</td>
	<td align=\"center\" class=\"head\">".$lang['LADDER_STATUS']."</td>
</tr>
";
$nusers = 0;
if ($result) {
	while ($line = $result->fetch_row()) {
				$nusers++;
				if ($nusers > 100)
					break;

				$charname = htmlformat($line[0]);
				$job = $jobs[$line[1]];

				echo '    
				<tr>
					<td align="right">'.$nusers.'</td>
					<td>&nbsp;</td>
					<td align="center"><b><img src="./images/'.$line[6].'.gif"></b></td>
					<td>&nbsp;</td>
					<td align="left">'.$charname.'</td>
					<td>&nbsp;</td>
					<td align="left">
				';
					echo '<center><img src="./images/jobs/' . $line[1] . '.gif"><br>'.$job;
				echo '
					</center></td>
					<td align="center"><img src="./images/votanos.png"><br>'.$line[8].'</td>';
			if ($line[7])
				echo "<td align=\"center\"><img src=\"./images/onrank.png\"></td>";
			else 
				echo "<td align=\"center\"><img src=\"./images/offrank.png\"></td>";
				echo '</tr>';
	}
}
echo "</table>";
closetable();
fim();
?>