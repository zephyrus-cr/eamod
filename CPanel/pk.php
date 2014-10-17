<?php
/*
Based on ladder.php file
Modified by Érid =)!
*/
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

$jobs = $_SESSION[$CONFIG_name.'jobs'];
if (!isset($GET_opt)) {
	opentable("TOP 50 PK");
	echo "
	<table width=\"70%\">
	<tr>
		<td align=center>
		<form id=\"ladder\">
			<select name = \"opt\" onChange=\"javascript:GET_ajax('pk.php', 'ladder_div', 'ladder');\">
				<option selected value=\"0\">All</option>
	";
	for ($i = 1; $i < 26; $i++) {
		if ($i != 13 && $i != 21 && $i != 22 && $i != 26)
			echo "<option value=\"$i\">$jobs[$i]</option>";
	}
	for ($i = 4001; $i < 4050; $i++) {
		if ($i != 4014 && $i != 4022 && $i != 4036 && $i != 4044 && $i != 4048)
			echo "<option value=\"$i\">$jobs[$i]</option>";
	}
	echo "
			</select>
		</form>
		</td>
	</tr>
	</table>

	<div id=\"ladder_div\" style=\"color:#000000\">
	";
	$begin = 1;
	$GET_opt = 0;
}

if (notnumber($GET_opt))
	alert($lang['INCORRECT_CHARACTER']);

$query = sprintf(LADDER_PK_ALL);
$string = "All";

if ($GET_opt > 0) {
	switch ($GET_opt) {
		case 7:
			$query = sprintf(LADDER_LKPPK, $GET_opt, 13);
			break;
		case 14:
			$query = sprintf(LADDER_LKPPK, $GET_opt, 21);
			break;
		case 4008:
			$query = sprintf(LADDER_LKPPK, $GET_opt, 4014);
			break;
		case 4015:
			$query = sprintf(LADDER_LKPPK, $GET_opt, 4022);
			break;
		case 4030:
			$query = sprintf(LADDER_LKPPK, $GET_opt, 4036);
			break;
		case 4037:
			$query = sprintf(LADDER_LKPPK, $GET_opt, 4044);
			break;
		case 4047:
			$query = sprintf(LADDER_LKPPK, $GET_opt, 4048);
			break;
		default:
			$query = sprintf(LADDER_JOB, $GET_opt);
			break;
	}
	$string = "unknown";
	if (isset($jobs[$GET_opt]))
		$string = $jobs[$GET_opt];
}

$result = execute_query($query, "ladder.php");
echo "
<table width=\"500\">
<tr>
	<td align=\"right\" class=\"head\">".$lang['POS']."</td>
	<td>&nbsp;</td>
	<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"left\" class=\"head\">".$lang['CLASS']."</td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\" class=\"head\">".$lang['BLVLJLVL']."</td>
	<td align=\"center\" class=\"head\">Kills/Deaths</td>
	<td align=\"center\" class=\"head\">".$lang['LADDER_STATUS']."</td>
</tr>
";
for ($i = 1; $i < 101; $i++) {
	if (!($line = $result->fetch_row()))
		break;

	$charname = htmlformat($line[0]);
	if($line[6] == "")
		$line[6] = $line[7] = 0;
	$job = "unknown";
	if (isset($jobs[$line[1]]))
		$job = $jobs[$line[1]];
	echo "
	<tr>";
	if (isset($_SESSION[$CONFIG_name.'account_id']) && $line[5] == $_SESSION[$CONFIG_name.'account_id']) {
		echo "
		<td align=\"right\"><b>$i</b></td>
		<td>&nbsp;</td>
		<td align=\"left\"><b>$charname</b></td>
		<td>&nbsp;</td>
		<td align=\"left\"><b>$job</b></td>
		<td>&nbsp;</td>
		<td align=\"center\"><b>$line[2]/$line[3]</b></td>
		<td align=\"center\"><b>$line[6]/$line[7]</b></td>";
	} else {
	echo "
		<td align=\"right\">$i</td>
		<td>&nbsp;</td>
		<td align=\"left\">$charname</td>
		<td>&nbsp;</td>
		<td align=\"left\">$job</td>
		<td>&nbsp;</td>
		<td align=\"center\">$line[2]/$line[3]</td>
		<td align=\"center\">$line[6]/$line[7]</td>";
	}

	if ($line[4])
		echo "<td align=\"center\"><font color=\"green\">".$lang['LADDER_STATUS_ON']."</font></td>";
	else 
		echo "<td align=\"center\"><font color=\"red\">".$lang['LADDER_STATUS_OFF']."</font></td>";
	echo "
	</tr>";
}
echo "</table>";
if (isset($begin)) {
	echo "</div>";
	closetable();
}
fim();
?>