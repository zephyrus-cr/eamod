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

	if (isset($_POST['opt']) && $_POST['opt'] == 1)
	{ // Intento de De-Adopcion
		if (!isset($_POST['char_id']) || !isset($_POST['child']) || !isset($_POST['account_id']))
			redir("adoption.php", "main_div", "Valores incorrectos en adopcion!!.<br>Click aqui para intentar otra vez.");

		if (!is_numeric($_POST['char_id']) || !is_numeric($_POST['child']) || !is_numeric($_POST['account_id']))
			redir("adoption.php", "main_div", "Valores no numericos en el tramite!!.<br>Click aqui para intentar otra vez.");

		if ($account_id != $_POST['account_id'])
			redir("adoption.php", "main_div", "No puedes des-adoptar un personaje que no este en tu cuenta activa!!.<br>Click aqui para intentar otra vez.");

		if (is_online())
			redir("adoption.php", "main_div", "Tu cuenta de juego debe estar offline del juego para proceder.<br>Click aqui para intentar otra vez.");

		$result = $mysql->query("SELECT `father`, `mother` FROM `char` WHERE `char_id` = '" . $_POST['child'] . "'", $CONFIG['DBMain']);
		if ($line = $mysql->fetcharray($result))
			redir("adoption.php", "main_div", "El Baby aun existe, no podras des-adoptarlo hasta que se elimine del juego.<br>Click aqui para intentar otra vez.");

		$result = $mysql->query("SELECT `char_id`, `online` FROM `char` WHERE `child` = '" . $_POST['child'] . "'", $CONFIG['DBMain']);

		$count = 0;
		while ($line = $mysql->fetcharray($result)) {
			if( $line['online'] > 0 )
				redir("adoption.php", "main_div", "Alguno de los padres esta conectado en el juego. No se puede proceder.<br>Click aqui para intentar otra vez.");

			$parent[$count] = $line['char_id'];
			$count++;
		}

		if( $parent[0] != $_POST['char_id'] && $parent[1] != $_POST['char_id'] )
			redir("adoption.php", "main_div", "Padres y Baby no corresponden a la informacion otorgada.<br>Click aqui para intentar otra vez.");

		for( $i = 0; $i < $count; $i++ )
		{
			// Remover Skills de Padres
			$mysql->query("DELETE FROM `skill` WHERE `char_id` = '" . $parent[$i] . "' AND `id` = '410'", $CONFIG['DBMain']);
		}

		// Remover marca del Baby
		$mysql->query("UPDATE `char` SET `child` = '0' WHERE `child` = '" . $_POST['child'] . "'", $CONFIG['DBMain']);
	}

	opentable("Estado de Adopciones");
?>
	<table width="600">
		<tr>
			<td align="center" colspan="5">
				Utiliza esta secci&oacute;n del Panel de Cuentas para quitar las marcas de adopci&oacute;n que quedan en los pap&aacute;s cuando se elimina el Baby.<br><br>
				<b>Requisitos para tramitar:</b><br>
				- Ambos Padres deben estar fuera del juego.<br>
				- El Baby no debe existir, el personaje debe ser eliminado.<br>
				<b>Nota: A partir del Lunes 17 de Marzo del 2008, basta con borrar al baby para que los padres puedan volver a adoptar.</b><br>
			</td>
		</tr>
		<tr>
			<td align="center" height="10" valign="top" colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td align="right"><b>Tu Personaje</b></td>
			<td align="center">&nbsp;</td>
			<td align="left"><b>Baby</b></td>
			<td align="center">&nbsp;</td>
			<td align="left"><b>Des-adoptar?</b></td>
		</tr>
<?php
	$result = $mysql->query("
		SELECT
			c1.`name` AS `name1`, c1.`char_id` AS `char_id1`, c1.`account_id` AS `account_id1`, c1.`child`, c2.`name` AS `name2`, c2.`char_id` AS `char_id2`
		FROM
			`char` c1 LEFT JOIN `char` c2 ON c1.`child` = c2.`char_id`
		WHERE
			c1.`account_id` = '$account_id' AND c1.`child` > 0
	", $CONFIG['DBMain']);

	while ($line = $mysql->fetcharray($result))
	{
		if ($line['char_id2'] <= 0)
			$line['name2'] = "--- Eliminado ---";

		echo '
			<tr>
				<td align="right">' . htmlformat($line['name1']) . '</td>
				<td align="center"> <img src="images/item/small/994.png"> </td>
				<td align="left">' . htmlformat($line['name2']) . '</td>
				<td align="right">&nbsp;</td>
		';

		if( $line['char_id2'] == 0 )
			echo '
					<td align="left">
						<form id="deadopt' . $line['char_id1'] . '" onsubmit="return POST_ajax(\'adoption.php\',\'main_div\',\'deadopt' . $line['char_id1'] . '\')">
							<input type="hidden" name="char_id" value="' . $line['char_id1'] . '">
							<input type="hidden" name="child" value="' . $line['child'] . '">
							<input type="hidden" name="account_id" value="' . $line['account_id1'] . '">
							<input type="hidden" name="opt" value="1">
							<input type="submit" value="Confirmar">
						</form>
					</td>
				</tr>
			';
		else
			echo '<td align="left"><b>Imposible</b></td></tr>';
	}
?>
		<tr>
			<td align="center" height="10" valign="top" colspan="5">&nbsp;</td>
		</tr>
	</table>
<?php
	closetable();
?>