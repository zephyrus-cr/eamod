<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if( !isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0 )
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	$email = $_SESSION[$CONFIG['Name'] . 'email'];
	$member_id = $_SESSION[$CONFIG['Name'] . 'member_id'];

	// Cobro de Jugador
	if( isset($_POST['opt']) && $_POST['opt'] == 1 && isset($_POST['member_id']) && is_numeric($_POST['member_id']) && $_POST['member_id'] > 0 )
	{
		$ref_id = $_POST['member_id'];

		$result = $mysql->query("
			SELECT
				SUM(`char`.`playtime`) AS `Time`
			FROM
				`members` LEFT JOIN `login` ON `login`.`member_id` = `members`.`member_id` LEFT JOIN `char` ON `char`.`account_id` = `login`.`account_id`
			WHERE
				`members`.`member_id` = '$ref_id' AND `members`.`ref_email` = '$email' AND `login`.`level` = 0 AND `login`.`state` = 0 AND `members`.`member_id` <> '$member_id'
			GROUP BY
				`members`.`member_id`
			ORDER BY
				`Time` DESC
		", $CONFIG['DBMain']);

		if( ($data = $mysql->fetcharray($result)) && $data['Time'] >= 1728000 )
		{
			$mysql->query("UPDATE `members` SET `ref_email` = '' WHERE `member_id` = '$ref_id'", $CONFIG['DBMain']);
			$mysql->query("UPDATE `members` SET `acc_balance` = `acc_balance` + '10000' WHERE `member_id` = '$member_id'", $CONFIG['DBMain']);
		}
	}
	elseif( isset($_POST['opt']) && $_POST['opt'] == 2 && isset($_POST['account_id']) && is_numeric($_POST['account_id']) && $_POST['account_id'] > 0 )
	{
		$cashpoints = 0;
		$account_id = $_POST['account_id'];

		if( $data = $mysql->fetcharray($mysql->query("SELECT `acc_balance` FROM `members` WHERE `member_id` = '$member_id'", $CONFIG['DBMain'])) )
		{
			$cashpoints = $data['acc_balance'];
		}
		if( $cashpoints > 0 )
		{
			$mysql->query("
				INSERT INTO `cp_donatives`
					(`reference`, `amount`, `coin`, `place`, `status`, `account_id`, `date`, `nombre`, `email`)
				VALUES
					('Rerefed System', '" . intval($cashpoints / 1500) . "', '0', 'Server', '1', '$account_id', NOW(), '" . $_SESSION[$CONFIG['Name'] . 'nombre'] . "', '$email')"
			, $CONFIG['DBLogs']);

			$mysql->query("UPDATE `members` SET `acc_balance` = '0' WHERE `member_id` = '$member_id'", $CONFIG['DBMain']);
			$mysql->query("UPDATE `login` SET `cash_points` = `cash_points` + '10000' WHERE `account_id` = '$account_id'", $CONFIG['DBMain']);
		}
	}

	$cashpoints = 0;
	if( $data = $mysql->fetcharray($mysql->query("SELECT `acc_balance` FROM `members` WHERE `member_id` = '$member_id'", $CONFIG['DBMain'])) )
	{
		$cashpoints = $data['acc_balance'];
	}

	opentable("Mis Referencias");
?>
	<table width="550">
		<tr>
			<td align="center" height="30" valign="middle">
				Estos son los jugadores que te han referido a ti como <b>quien los invit&oacute; a jugar</b> en el servidor.<br>
				Cuando un nuevo miembro se registra en el servidor para jugar puede ingresar tu email como quien lo refiri&oacute;.<br>
				En el momento en que estos jugadores acumulen 480 horas de Juego (20 d&iacute;as),<br>
				tu podr&aacute;s cobrar <b>10.000 Puntos Sagrados</b>.<br>
				<br>
				Aprovecha el Sistema, invita a tus amigos a jugar y hagamos crecer el servidor todos juntos!!.
			</td>
		</tr>
		<tr>
			<td align="center" height="10" valign="top">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" height="30" valign="middle">
				Total <b>Puntos Sagrados</b> Ganados por Referencias : <b><?php echo $cashpoints; ?></b><br><br>
<?php
	$accounts = $mysql->query("SELECT `account_id`, `userid` FROM `login` WHERE `member_id` = '$member_id' AND `state` <> '5'", $CONFIG['DBMain']);
	$c = 0;
	if( $data = $mysql->fetcharray($accounts) )
	{
		echo '
			<form id="transfercash" onsubmit="return POST_ajax(\'refered.php\',\'main_div\',\'transfercash\');">
				Transferir Puntos a la Cuenta
				&nbsp;
				<select name="account_id" onKeyPress="return force(this.name,this.form.id,event);">
		';
		do
		{
			$c++;
			echo '<option value="' . $data['account_id'] . '" ' . (($c == 1)? 'selected':'') . '>' . htmlformat($data['userid']) . '</option>';
		} while( $data = $mysql->fetcharray($accounts) );
		echo '
				</select>
				&nbsp;
				<input type="submit" value="Cobrar">
				<input type="hidden" name="opt" value="2">
			</form>
		';
	}
	else
	{
		echo 'Para transferir tus <b>Puntos Sagrados</b> al juego necesitas al menos una <b>cuenta de juego</b>';
	}
?>
			</td>
		</tr>
		<tr>
			<td align="center" height="10" valign="top">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" valign="top">
				<table width="550">
					<tr>
						<td align="left" class="header"><b>ID</b></td>
						<td align="center">&nbsp;</td>
						<td align="left" class="header"><b>Nombre</b></td>
						<td align="center">&nbsp;</td>
						<td align="left" class="header"><b>Correo<br>Electr&oacute;nico</b></td>
						<td align="center">&nbsp;</td>
						<td align="right" class="header"><b>Tiempo<br>Acumulado</b></td>
						<td align="center">&nbsp;</td>
						<td align="center" class="header"><b>P.S</b></td>
					</tr>
					<tr>
						<td align="center" colspan="9"><hr></td>
					</tr>
					<tr>
						<td align="center" colspan="9">&nbsp;</td>
					</tr>
<?php
	// Consulta de Membresias

	$result = $mysql->query("
		SELECT
			`members`.`member_id`, `members`.`nombre`, `members`.`email`, SUM(`char`.`playtime`) AS `Time`
		FROM
			`members` LEFT JOIN `login` ON `login`.`member_id` = `members`.`member_id` LEFT JOIN `char` ON `char`.`account_id` = `login`.`account_id`
		WHERE
			`members`.`ref_email` = '$email' AND `login`.`level` = 0 AND `login`.`state` = 0 AND `members`.`member_id` <> '$member_id'
		GROUP BY
			`members`.`member_id`
		ORDER BY
			`Time` DESC
	", $CONFIG['DBMain']);

	while( $data = $mysql->fetcharray($result) )
	{
		echo '
			<tr>
				<td align="left"><b>' . $data['member_id'] . '</b></td>
				<td align="center">&nbsp;</td>
				<td align="left">' . htmlformat($data['nombre']) . '</td>
				<td align="center">&nbsp;</td>
				<td align="left">' . htmlformat($data['email']) . '</td>
				<td align="center">&nbsp;</td>
				<td align="right"><b>' . playtime($data['Time']) . '</b></td>
				<td align="center">&nbsp;</td>
				<td align="center">
		';

		if( $data['Time'] >= 1728000 )
			echo '
					<form id="id' . $data['member_id'] . '" onsubmit="return POST_ajax(\'refered.php\',\'main_div\',\'id' . $data['member_id'] . '\');">
						<input type="hidden" name="member_id" value="' . $data['member_id'] . '">
						<input type="hidden" name="opt" value="1">
						<input type="submit" value="Cobrar">
					</form>
			';
		else
			echo '...';

		echo '
				</td>
			</tr>
		';
	}
?>
					<tr>
						<td align="center" colspan="9"><hr></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<?php
	closetable();
?>