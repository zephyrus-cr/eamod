<?php

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

$jobs = $_SESSION[$CONFIG_name.'jobs'];

$query = sprintf(EMPBREAK);
$result = execute_query($query, "empbreak.php");

opentable('Top 20 Emp Breakers');
echo "
<table width=\"400\">
<tr>
	<td align=\"right\" class=\"head\">".$lang['POS']."</td>
	<td>&nbsp;</td>
	<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
	<td align=\"left\" class=\"head\">".$lang['CLASS']."</td>
	<td align=\"left\" class=\"head\">".$lang['GUILD_GNAME']."</td>
	<td align=\"right\" class=\"head\">".'Breaks'."</td>
</tr>
";
$nusers = 0;
if ($result) {
	while ($line = $result->fetch_row()) {
				$nusers++;
				if ($nusers > 20)
					break;

				$charname = htmlformat($line[0]);
				$gname = htmlformat($line[6]);

				echo "    
				<tr>
					<td align=\"right\">$nusers</td>
					<td>&nbsp;</td>
					<td align=\"left\">$charname</td>
					<td align=\"left\">
				";
				if (isset($jobs[$line[1]]))
					echo $jobs[$line[1]];
				else
					echo $lang['UNKNOWN'];
				echo "
					</td>

					<td align=\"left\">$gname</td>
					<td align=\"right\">$line[4]</td>
				</tr>
				";
	}
}
echo "</table>";
closetable();
fim();
?>
