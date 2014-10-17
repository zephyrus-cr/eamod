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

$query = sprintf(TOTALACCOUNTS);
$result = execute_query($query, 'about.php');
$result->fetch_row();
$accounts = moneyformat($result->row(0));

$query = sprintf(TOTALZENY);
$result = execute_query($query, 'about.php');
$result->fetch_row();
$zeny = moneyformat($result->row(0));

if ($CONFIG_dynamic_info || $CONFIG_agit_check) {
	if ($CONFIG_agit_check)
		$query = sprintf(RATES_AGIT, $CONFIG_dynamic_name);
	else
		$query = sprintf(ABOUT_RATES, $CONFIG_dynamic_name);
	$result = execute_query($query, 'about.php');
	$line = $result->fetch_row();
	$rate_base = $line[0] / 100;
	$rate_job = $line[1] / 100;
	$rate_drop = $line[2] / 100;
	if (isset($line[3]))
		$agit_status = $line[3];

}
$query = sprintf(TOTALCHARS);
$result = execute_query($query, 'about.php');

for ($chars = 0; $line = $result->fetch_row(); $chars++) {
	if (isset($class[$line[0]]))
		$class[$line[0]]++;
	else
		$class[$line[0]] = 1;
}

$chars = moneyformat($chars);
if ($CONFIG_classlist_show) {
	for ($i = 0; $i < 27; $i++) {
		if (!isset($class[$i]))
			$class[$i] = 0;
	}
	for ($i = 4001; $i < 4050; $i++) {
		if (!isset($class[$i]))
			$class[$i] = 0;
	}

	$class[7] = $class[7] + $class[13];
	$class[14] = $class[14] + $class[21];
	$class[4008] = $class[4008] + $class[4014];
	$class[4015] = $class[4015] + $class[4022];
	$class[4030] = $class[4030] + $class[4036];
	$class[4037] = $class[4037] + $class[4044];
	$class[4047] = $class[4047] + $class[4048];
}
opentable($lang['ABOUT_ABOUT']);

echo "
<table align=\"center\" width = \"300\">
	<tr>
	<td>&nbsp;</td>
	</tr>
	<tr>
		<td align=\"right\">".$lang['ABOUT_SERVER_NAME']."</td><td>&nbsp;</td><td align=\"left\">$CONFIG_name</td>
	</tr>";

	if ($CONFIG_dynamic_info)
		echo "<td align=\"right\">".$lang['ABOUT_RATE']."</td><td>&nbsp;</td><td align=\"left\">".$rate_base."/".$rate_job."/".$rate_drop."</td>";
	else
		echo "<td align=\"right\">".$lang['ABOUT_RATE']."</td><td>&nbsp;</td><td align=\"left\">$CONFIG_rate</td>";
echo "
	</tr>
	<tr>
	<td>&nbsp;</td>
	</tr>
	<tr>
		<td align=\"right\">".$lang['ABOUT_WOE_TIMES']."</td>
	</tr>
	";
	ret_woe_times();
	
echo "
	<tr>
	<td>&nbsp;</td>
	</tr>
	<tr>
		<td align=\"right\">".$lang['ABOUT_TOTAL_ACCOUNTS']."</td><td>&nbsp;</td><td align=right>$accounts</td>
	</tr>
	<tr>
		<td align=\"right\">".$lang['ABOUT_TOTAL_CHAR']."</td><td>&nbsp;</td><td align=right>$chars</td>
	</tr>
	<tr>
		<td align=\"right\">".$lang['ABOUT_TOTAL_ZENY']."</td><td>&nbsp;</td><td align=right>$zeny</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	</tr>";
	if ($CONFIG_classlist_show) {
	echo "<tr><td align=\"right\">".$lang['ABOUT_TOTAL_CLASS']."</td></tr>";
	
			for ($i = 0; $i < 26; $i++) {
			$class[$i] = moneyformat($class[$i]);
			if ($i != 13 && $i != 21 && $i != 22 && $i != 26 && !empty($class[$i]) && !empty($jobs[$i]))
				echo "<tr><td align=\"right\">$jobs[$i]</td><td>&nbsp;</td><td align=right>$class[$i]</td></tr>";
		}
		for ($i = 4001; $i < 4050; $i++) {
			$class[$i] = moneyformat($class[$i]);
			if ($i != 4014 && $i != 4022 && $i != 4036 && $i != 4044 && $i != 4048 && !empty($class[$i]) && !empty($jobs[$i]))
				echo "<tr><td align=\"right\">$jobs[$i]</td><td>&nbsp;</td><td align=right>$class[$i]</td></tr>";
		}
	}
echo "</table>";
closetable();
fim();
?>
