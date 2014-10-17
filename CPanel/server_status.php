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

DEFINE('INDIBG', "SELECT * FROM `indicator` WHERE `indiname` = 'bg' AND `status` = '1'");
DEFINE('INDIPVP', "SELECT * FROM `indicator` WHERE `indiname` = 'pvp' AND `status` = '1'");
DEFINE('INDIGVG', "SELECT * FROM `indicator` WHERE `indiname` = 'gvg' AND `status` = '1'");
$queryindi1 = sprintf(INDIBG);
$queryindi2 = sprintf(INDIPVP);
$queryindi3 = sprintf(INDIGVG);
$resultindi1 = execute_query($queryindi1, "server_status.php");
$resultindi2 = execute_query($queryindi2, "server_status.php");
$resultindi3 = execute_query($queryindi3, "server_status.php");

DEFINE('INSTENDLESS', "SELECT * FROM `instances` WHERE `instaname` = 'endless' AND `status` = '1'");
DEFINE('INSTSEALED', "SELECT * FROM `instances` WHERE `instaname` = 'sealed' AND `status` = '1'");
DEFINE('INSTORCS', "SELECT * FROM `instances` WHERE `instaname` = 'orcs' AND `status` = '1'");
$queryinst1 = sprintf(INSTENDLESS);
$queryinst2 = sprintf(INSTSEALED);
$queryinst3 = sprintf(INSTORCS);
$resultinst1 = execute_query($queryinst1, "server_status.php");
$resultinst2 = execute_query($queryinst2, "server_status.php");
$resultinst3 = execute_query($queryinst3, "server_status.php");

$servers = server_status();
$quantos = moneyformat(online_count());

//Dynamic Info Check [ABOUT_RATES|RATES_AGIT]
if ($CONFIG_dynamic_info || $CONFIG_agit_check) {
	if ($CONFIG_agit_check)
		$query = sprintf(RATES_AGIT,$CONFIG_dynamic_name);
	else
		$query = sprintf(ABOUT_RATES,$CONFIG_dynamic_name);

	$result = execute_query($query, 'server_status.php');
	$line = $result->fetch_row();
	$rate_base = moneyformat($line[0] / 100);
	$rate_job = moneyformat($line[1] / 100);
	$rate_drop = moneyformat($line[2] / 100);
	if(isset($line[3])) {
		if ($line[3] == 1)
			$agit_status = "<img src=\"./images/onrank.png\">";
		else
			$agit_status = "<img src=\"./images/offrank.png\">";
	}
}

opentable($CONFIG_name."<br><br><font color=\"#848484\">1000</font><font color=\"#000000\">/</font><font color=\"#848484\">1000</font><font color=\"#000000\">/</font><font color=\"#848484\">500</font>");
echo "<BR/>";
echo "<hr><center><b>Server Status</b></center><br><table border=\"0\" bordercolor=\"black\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
if ($servers & 1) 
	echo "<tr><td align=\"left\"><b>".$lang['SERVERSTATUS_LOGIN'].":&nbsp;</b></td><td><img src=\"./images/offrank.png\"></td></td></tr>";
else 
	echo "<tr><td align=\"left\"><b>".$lang['SERVERSTATUS_LOGIN'].":&nbsp;</b></td><td><img src=\"./images/offrank.png\"></td></td></tr>";

if ($servers & 2)
	echo "<tr><td align=\"left\"><b>".$lang['SERVERSTATUS_CHAR'].":&nbsp;</b></td><td><img src=\"./images/offrank.png\"></td></td></tr>";
else
	echo "<tr><td align=\"left\"><b>".$lang['SERVERSTATUS_CHAR'].":&nbsp;</b></td><td><img src=\"./images/offrank.png\"></td></td></tr>";

if ($servers & 4) 
	echo "<tr><td align=\"left\"><b>".$lang['SERVERSTATUS_MAP'].":&nbsp;</b></td><td><img src=\"./images/offrank.png\"></td></td></tr>";
else
	echo "<tr><td align=\"left\"><b>".$lang['SERVERSTATUS_MAP'].":&nbsp;</b></td><td><img src=\"./images/offrank.png\"></td></td></tr>";

if ($CONFIG_show_rates) {
	if ($CONFIG_dynamic_info)
		echo "<tr><td = align=\"center\"><b>".$lang['ABOUT_RATE']."&nbsp;</b></td><td align=\"right\">".$rate_base."/".$rate_job."/".$rate_drop."</td></tr>";
	else
		echo "<tr><td = align=\"center\"><b>".$lang['ABOUT_RATE']."&nbsp;</b></td><td align=\"right\">$CONFIG_rate</td></tr>";
}
echo "</table><BR />";
echo "<hr><center><b>Mapas Battle</b><br>(Se activan si hay gente)</center><br><table border=\"0\" bordercolor=\"black\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
//if ($CONFIG_agit_check)
if (is_woe())
	echo "<tr><td align=\"left\"><b>".$lang['AGIT'].":&nbsp;</b></td><td><img src=\"./images/onrank.png\"></td></tr>";
	else
	echo "<tr><td align=\"left\"><b>".$lang['AGIT'].":&nbsp;</b></td><td><img src=\"./images/offrank.png\"></td></tr>";

if ($resultindi1->fetch_row()) {
	echo "<tr><td align=\"left\"><b>BG: &nbsp;</b></td><td><img src=\"./images/onrank.png\"></td></tr>"; }
	else {
	echo "<tr><td align=\"left\"><b>BG: &nbsp;</b></td><td><img src=\"./images/offrank.png\"></td></tr>"; }

if ($resultindi2->fetch_row()) {
	echo "<tr><td align=\"left\"><b>PVP: &nbsp;</b></td><td><img src=\"./images/onrank.png\"></td></tr>"; }
	else {
	echo "<tr><td align=\"left\"><b>PVP: &nbsp;</b></td><td><img src=\"./images/offrank.png\"></td></tr>"; }

if ($resultindi3->fetch_row()) {
	echo "<tr><td align=\"left\"><b>GVG: &nbsp;</b></td><td><img src=\"./images/onrank.png\"></td></tr>"; }
	else {
	echo "<tr><td align=\"left\"><b>GVG: &nbsp;</b></td><td><img src=\"./images/offrank.png\"></td></tr>"; }
	echo "</table><BR />";

echo "<hr><table border=\"0\" bordercolor=\"black\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
if ($quantos)
	echo "<tr><td align=\"left\"><b><span title=\"See who is online\" style=\"cursor:pointer\" onMouseOver=\"this.style.color='#FF3300'\" onMouseOut=\"this.style.color='#000000'\" onClick=\"LINK_ajax('whoisonline.php','main_div');\">".$lang['SERVERSTATUS_USERSONLINE'].":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></b></td><td align=\"center\"><b><font color=\"blue\" size=2>$quantos</font></b></td></tr>";
else
	echo "<tr><td align=\"left\"><b>".$lang['SERVERSTATUS_USERSONLINE'].":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td align=\"center\"><b><font color=\"red\" size=2>$quantos</font></b></td></tr>";

echo "</table>";
closetable();

fim();
?>
