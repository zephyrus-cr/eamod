<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	if (!isset($_SESSION[$CONFIG['Name'] . 'account_id']) || $_SESSION[$CONFIG['Name'] . 'account_id'] <= 0)
		redir("cuentas.php", "main_div", "Debes seleccionar una cuenta de juego para accesar aca.");

	$member_id = $_SESSION[$CONFIG['Name'] . 'member_id'];
	$account_id = $_SESSION[$CONFIG['Name'] . 'account_id'];
	$services = 0;

	if ($result = $mysql->fetchrow($mysql->query("SELECT `services` FROM `members` WHERE `member_id` = '$member_id'", $CONFIG['DBMain'])))
		$services = $result[0];

	if (isset($_POST['opt']) && $_POST['opt'] == 1)
	{ // Intento de Divorcio
		if (!isset($_POST['char_id1']) || !isset($_POST['char_id2']) || !isset($_POST['account_id1']) || !isset($_POST['account_id2']))
			redir("marriage.php", "main_div", "Valores incorrectos en divorcio!!.<br>Click aqui para intentar otra vez.");

		if (!is_numeric($_POST['char_id1']) || !is_numeric($_POST['char_id2']) || !is_numeric($_POST['account_id1']) || !is_numeric($_POST['account_id2']))
			redir("marriage.php", "main_div", "Valores no numericos en el tramite!!.<br>Click aqui para intentar otra vez.");

		if ($account_id != $_POST['account_id1'])
			redir("marriage.php", "main_div", "No puedes divorciar un personaje que no este en tu cuenta activa!!.<br>Click aqui para intentar otra vez.");

		if (is_online())
			redir("marriage.php", "main_div", "Tu cuenta de juego debe estar offline del juego para proceder.<br>Click aqui para intentar otra vez.");

		if (is_online2($_POST['account_id2']))
			redir("marriage.php", "main_div", "Tu pareja debe estar offline del juego para proceder.<br>Click aqui para intentar otra vez.");

		if( $services < 1 )
			redir("marriage.php", "main_div", "No tienes puntos de Servicios para este tramite!!.<br>Invierte tus donativos en Puntos para esta funcion.<br>Click aqui para intentar otra vez.");

		$services--;
		$mysql->query("UPDATE `members` SET `services` = `services` - 1 WHERE `member_id` = '$member_id'", $CONFIG['DBMain']);

		$unban_time = time() + (2 * 60); // 2 minutos de seguridad de Baneo de Cuenta(s)
		$mysql->query("UPDATE `login` SET `unban_time` = '$unban_time' WHERE `account_id` = '$account_id'", $CONFIG['DBMain']);
		$mysql->query("UPDATE `login` SET `unban_time` = '$unban_time' WHERE `account_id` = '" . $_POST['account_id2'] . "' AND `unban_time` = '0'", $CONFIG['DBMain']);

		$mysql->query("UPDATE `char` SET `partner_id` = '0' WHERE `char_id` = '" . $_POST['char_id1'] . "' OR `char_id` = '" . $_POST['char_id2'] . "'", $CONFIG['DBMain']);
		$mysql->query("DELETE FROM `inventory` WHERE (`nameid` = '2634' OR `nameid` = '2635') AND (`char_id` = '" . $_POST['char_id1'] . "' OR `char_id` = '" . $_POST['char_id2'] . "')", $CONFIG['DBMain']);
	}

	opentable("Divorcios de Personajes");
?>
	<table width="600">
		<tr>
			<td align="center" colspan="5">
				Utiliza esta secci&oacute;n del Panel de Cuentas para tramitar divorcios de personajes.<br><br>
				<b>Requisitos para tramitar:</b><br>
				- Ambos miembros de la pareja deben estar fuera del juego.<br>
				- Se requiere <b>1 Punto de Servicio</b> para el tramite.<br>
				- Por seguridad, las cuentas ser&aacute;n baneadas por 2 minutos luego de tramitar el divorcio.<br>
			</td>
		</tr>
		<tr>
			<td align="center" height="10" valign="top" colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td align="right"><b>Tu Personaje</b></td>
			<td align="right">&nbsp;</td>
			<td align="left"><b>Pareja</b></td>
			<td align="right">&nbsp;</td>
			<td align="left"><b>Divorciar?</b></td>
		</tr>
<?php
	$result = $mysql->query("
		SELECT
			c1.`name` AS `name1`, c1.`char_id` AS `char_id1`, c1.`account_id` AS `account_id1`,
			c2.`name` AS `name2`, c2.`char_id` AS `char_id2`, c2.`account_id` AS `account_id2`
		FROM
			`char` c1 LEFT JOIN `char` c2 ON c1.`partner_id` = c2.`char_id`
		WHERE
			c1.`account_id` = '$account_id'
	", $CONFIG['DBMain']);

	while ($line = $mysql->fetcharray($result))
	{
		if ($line['char_id2'] <= 0)
			continue;

		echo '
			<tr>
				<td align="right">' . htmlformat($line['name1']) . '</td>
				<td align="center"> <img src="images/item/small/994.png"> </td>
				<td align="left">' . htmlformat($line['name2']) . '</td>
				<td align="right">&nbsp;</td>
				<td align="left">
					<form id="divorce' . $line['char_id1'] . '" onsubmit="return POST_ajax(\'marriage.php\',\'main_div\',\'divorce' . $line['char_id1'] . '\')">
						<input type="hidden" name="char_id1" value="' . $line['char_id1'] . '">
						<input type="hidden" name="char_id2" value="' . $line['char_id2'] . '">
						<input type="hidden" name="account_id1" value="' . $line['account_id1'] . '">
						<input type="hidden" name="account_id2" value="' . $line['account_id2'] . '">
						<input type="hidden" name="opt" value="1">
						<input type="submit" value="Confirmar">
					</form>
				</td>
			</tr>
		';
	}
?>
		<tr>
			<td align="center" height="10" valign="top" colspan="5">&nbsp;</td>
		</tr>
	</table>
<?php
	closetable();
?>