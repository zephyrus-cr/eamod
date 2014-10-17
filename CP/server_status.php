<?php
	session_start();
	include_once 'config.php'; // loads config variables
	include_once 'functions.php';

	$servers = server_status();
	$users = online_count();

	opentable('<font color="yellow">Evangelis RO</font><br><font size="1" color="gray">- 500x500x100x -<br>High Rates Premium</font>');

	echo '
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center"><b>Login</b></td>
				<td align="center"><b>Char</b></td>
				<td align="center"><b>Map</b></td>
			</tr>
			<tr>
	';
	if ($servers & 1)
		echo '
			 <td><img src="online.png"></td>
		';
	else
		echo '
			<td><img src="offline.png"></td>
		';


	if ($servers & 2)
		echo '
			 <td><img src="online.png"></td>
		';
	else
		echo '
			<td><img src="offline.png"></td>
		';

	if ($servers & 4)
		echo '
			 <td><img src="online.png"></td>
		';
	else
		echo '
			<td><img src="offline.png"></td>
		';

	echo '
			</tr>
			<tr>
				<td align="center" colspan="3">
					<b>Jugadores Online</b>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="3">
					<font size="3" color="yellow"><b>' . moneyformat($users) . '</b></font>
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
		</table>
	';
	closetable();
?>