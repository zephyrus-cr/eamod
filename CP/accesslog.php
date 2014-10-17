<?php
	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	opentable("Registro de Accesos al Panel de Miembros");
?>
	<table width="550">
		<tr>
			<td align="center" height="30" valign="middle">
				Aca esta el registro de Fechas e IPs que se logearon en este Panel de Control con tu cuenta
			</td>
		</tr>
		<tr>
			<td align="center" height="10" valign="top">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" valign="top">
				<table width="550">
					<tr>
						<td align="left" class="header"><b>Fecha</b></td>
						<td align="center">&nbsp;</td>
						<td align="center" class="header"><b>Direcci&oacute;n IP</b></td>
						<td align="center">&nbsp;</td>
						<td align="right" class="header"><b>Resultado</b></td>
					</tr>
<?php
	// Consulta de Cuentas
	$member_id = $_SESSION[$CONFIG['Name'] . 'member_id'];

	$logs = $mysql->query("
		SELECT
			`ip`, `date`, `ban`
		FROM
			`cp_memberlog`
		WHERE
			`member_id` = '$member_id'
		ORDER BY
			`id` DESC
		LIMIT 30
	", $CONFIG['DBLogs']);

	for ($i = 1; $log = $mysql->fetcharray($logs); $i++)
	{
		if ($log['ban'] == 1)
			$ban = "Correcto";
		else
			$ban = "Fallo de Clave";

		echo '
			<tr>
				<td align="left">' . $log['date'] . '</td>
				<td align="center">&nbsp;</td>
				<td align="center">' . $log['ip'] . '</td>
				<td align="center">&nbsp;</td>
				<td align="right">' . $ban . '</td>
			<tr>
		';
	}
?>
				</table>
			</td>
		</tr>
	</table>
<?php
	closetable();
?>