<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca.");

	if (!isset($_SESSION[$CONFIG['Name'] . 'mlevel']) || $_SESSION[$CONFIG['Name'] . 'mlevel'] < 1)
		redir("news.php", "main_div", "No estas autorizado para entrar a esta seccion.<br>Click para regresar.");

	// Aprobacion o Cancelacion de Donativos
	if (isset($_POST['opt']) && $_POST['opt'] > 0 && isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id'] > 0)
	{
		if (!$result = $mysql->fetcharray($mysql->query("
			SELECT
				`account_id`, `amount`, `coin`
			FROM
				`cp_donatives`
			WHERE
				`id` = '" . $_POST['id'] . "' AND `status` = '0'
		", $CONFIG['DBLogs'])))
		{
			redir("donatives.php", "main_div", "El Donativo no puede ser tramitado, posiblemente ya fue Aprobado o Cancelado.<br>Click para regresar.");
		}

		$id = $_POST['id'];
		$email = $_POST['email'];
		$account_id = $result['account_id'];
		$amount = $result['amount'];
		$coin = $result['coin'];

		// Conversion
		switch( $coin )
		{
			case 0: // Peso Chileno
				$total = intval($amount * 1500 / 500);
				break;
		}

		if ($_POST['opt'] == 1)
		{ // Aprobacion
			$mysql->query("UPDATE `login` SET `cash_points` = `cash_points` + '$total' WHERE `account_id` = '$account_id'", $CONFIG['DBMain']); // Actualizacion del Saldo
			$status = 1;
		}
		else
		{ // Cancelacion
			$status = 2;
		}

		$mysql->query("UPDATE `cp_donatives` SET `status` = '$status' WHERE `id` = '$id'", $CONFIG['DBLogs']);

		// E-Mail to Member
		$asunto = 'Evangelis Ragnarok - Reporte de Donativos';
		$message = "";
		$message.= "Este mensaje es para notificarle el resultado de su reporte de donativos a Evangelis Ragnarok.\n\n";
		$message.= "Su donativo ha sido : " . (($status == 1)?'Aprobado':'Cancelado') . ".\n\n\n";
		if( $status == 1 )
			$message.= "Muchas gracias por su cooperacion a la comunidad. El monto de su cuenta ha sido actualizado.\n\n";
		else
			$message.= "El motivo de la cancelacion lo puedes solicitar con cualquier miembro del Staff.\n\n";

		$message.= "Servidor Evangelis Ragnarok.\n";
		$message.= "High Rates Premium.\n";
		sendmail($email, $asunto, $message);
	}

	opentable("Estadistica y Aprobacion de Donativos");
?>
	<table width="600">
		<tr>
			<td align="center" colspan="11">
				Este es el Panel de Control de Donativos que los jugadores reportan en sus respectivas cuentas.<br>
				El GM encargado de esta seccion debe verificar que los reportes sean ver&iacute;dicos.<br>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="11"><hr></td>
		</tr>
		<tr>
			<td align="left"><b>Cuenta</b></td>
			<td align="left">|</td>
			<td align="left"><b>Nombre<br>Email</b></td>
			<td align="left">|</td>
			<td align="left" width="60"><b>Fecha<br>Hora</b></td>
			<td align="left">|</td>
			<td align="left"><b>Referencia<br>Lugar</b></td>
			<td align="left">|</td>
			<td align="right"><b>Monto</b></td>
			<td align="left">|</td>
			<td align="center" width="40"><b>OK?</b></td>
		</tr>
		<tr>
			<td align="center" colspan="11"><hr></td>
		</tr>
<?php

	$count = 0;
	$result = $mysql->query("
		SELECT
			`account_id`, `nombre`, `email`, `id`, `date`, `reference`, `place`, `amount`, `coin`, `status`
		FROM
			`cp_donatives`
		WHERE
			`status` = '0'
		ORDER BY
			`date` DESC
	", $CONFIG['DBLogs']);

	$simbolo = array("CL Peso");

	while ($line = $mysql->fetcharray($result))
	{
		$count++;
		switch( $line['coin'] )
		{
			case 0: // dolars
				$total = intval($line['amount'] * 1500 / 500);
				break;
		}

		echo '
			<tr>
				<td align="left">' . $line['account_id'] . '</td>
				<td align="left">&nbsp;</td>
				<td align="left">' . $line['nombre'] . '<br>' . $line['email'] . '</td>
				<td align="left">&nbsp;</td>
				<td align="left" width="60">' . $line['date'] . '</td>
				<td align="left">&nbsp;</td>
				<td align="left">' . $line['reference'] . '<br>' . $line['place'] . '</td>
				<td align="left">&nbsp;</td>
				<td align="right">' . $simbolo[$line['coin']] . '<br>' . moneyformat($line['amount']) . '<br>' . moneyformat($total) . ' PS</td>
				<td align="left">&nbsp;</td>
				<td align="center" width="50">
					<form id="yes' . $count . '" onsubmit="return POST_ajax(\'donatives.php\',\'main_div\',\'yes' . $count . '\');">
						<input type="submit" value="Si">
						<input type="hidden" name="opt" value="1">
						<input type="hidden" name="id" value="' . $line['id'] . '">
						<input type="hidden" name="email" value="' . $line['email'] . '">
					</form>
					<form id="no' . $count . '" onsubmit="return POST_ajax(\'donatives.php\',\'main_div\',\'no' . $count . '\');">
						<input type="submit" value="No">
						<input type="hidden" name="opt" value="2">
						<input type="hidden" name="id" value="' . $line['id'] . '">
					</form>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="11"><hr></td>
			</tr>
		';
	}
?>
		<tr>
			<td align="center" colspan="11"><hr></td>
		</tr>
		<tr>
			<td align="center" colspan="11"><b>Hist&oacute;rico de Reportes</b></td>
		</tr>
		<tr>
			<td align="left"><b>Cuenta</b></td>
			<td align="left">|</td>
			<td align="left"><b>Nombre<br>Email</b></td>
			<td align="left">|</td>
			<td align="left" width="60"><b>Fecha<br>Hora</b></td>
			<td align="left">|</td>
			<td align="left"><b>Referencia<br>Lugar</b></td>
			<td align="left">|</td>
			<td align="right"><b>Monto</b></td>
			<td align="left">|</td>
			<td align="center" width="40"><b>Estado</b></td>
		</tr>
		<tr>
			<td align="center" colspan="13"><hr></td>
		</tr>
<?php
	$count = 0;
	$result = $mysql->query("
		SELECT
			`account_id`, `nombre`, `email`, `id`, `date`, `reference`, `place`, `amount`, `coin`, `status`
		FROM
			`cp_donatives`
		WHERE
			`status` != '0'
		ORDER BY
			`date` DESC
		LIMIT 30
	", $CONFIG['DBLogs']);

	while ($line = $mysql->fetcharray($result))
	{
		$count++;

		echo '
			<tr>
				<td align="left">' . $line['account_id'] . '</td>
				<td align="left">&nbsp;</td>
				<td align="left">' . $line['nombre'] . '<br>' . $line['email'] . '</td>
				<td align="left">&nbsp;</td>
				<td align="left" width="60">' . $line['date'] . '</td>
				<td align="left">&nbsp;</td>
				<td align="left">' . $line['reference'] . '<br>' . $line['place'] . '</td>
				<td align="left">&nbsp;</td>
				<td align="right">' . $simbolo[$line['coin']] . ' ' . moneyformat($line['amount']) . '</td>
				<td align="left">&nbsp;</td>
				<td align="center" width="50">
					<b>' . ( $line['status'] == 1 ? '<font color="Green">OK</font>' : '<font color="Red">NO</font>' ) . '</b>
				</td>
			</tr>
		';
	}

	echo '</table>';
	closetable();
?>