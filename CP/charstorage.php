<?php
	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca.");

	if (!isset($_SESSION[$CONFIG['Name'] . 'account_id']) || $_SESSION[$CONFIG['Name'] . 'account_id'] <= 0)
		redir("cuentas.php", "main_div", "Primero selecciona una cuenta de juego para proceder.<br>Click aqui para seleccionar otra cuenta.");

	if ($_SESSION[$CONFIG['Name'] . 'leve'] > 0 && $_SESSION[$CONFIG['Name'] . 'leve'] <= 60)
		redir("cuentas.php", "main_div", "Esta seccion no es para tu nivel de GM.<br>Click aqui para seleccionar otra cuenta.");

	if (is_online())
		redir("cuentas.php", "main_div", "No puedes usar este servicio con la cuenta Activa en el juego.<br>Deslogeate del juego y vuelve a intentarlo.<br>Click aqui para seleccionar otra cuenta.");

	$member_id = $_SESSION[$CONFIG['Name'] . 'member_id'];
	$account_id = $_SESSION[$CONFIG['Name'] . 'account_id'];
	$services = 0;

	if ($result = $mysql->fetchrow($mysql->query("SELECT `services` FROM `members` WHERE `member_id` = '$member_id'", $CONFIG['DBMain'])))
		$services = $result[0];

	if( isset($_POST['opt']) && isset($_POST['char_id']) && is_numeric($_POST['char_id']) )
	{
		$charid = $_POST['char_id'];

		$result = $mysql->query("
			SELECT
				`char`.`char_num`, `char`.`guild_id`, `char`.`party_id`, `login`.`member_id`, `login`.`sex`, `login`.`state`, `login`.`unban_time`, `char`.`class`, `char`.`account_id`, `char`.`last_map`
			FROM
				`char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id`
			WHERE
				`char`.`char_id` = '$charid'
		", $CONFIG['DBMain']);

		if( !($char = $mysql->fetcharray($result)) )
			redir("charstorage.php", "main_div", "El personaje que trata de mover no existe!!.<br>Click aqui para intentar otra vez.");

		if( $char['member_id'] != $member_id )
			redir("charstorage.php", "main_div", "El personaje que trata de mover no es de tu membresia!!.<br>Click aqui para intentar otra vez.");

		if( $char['state'] != 0 )
			redir("charstorage.php", "main_div", "La cuenta del personaje que trata de mover se encuentra Bloqueado!!.<br>Click aqui para intentar otra vez.");

		if( $char['unban_time'] > time() )
			redir("charstorage.php", "main_div", "La cuenta del personaje que trata de mover se encuentra Baneado!!.<br>Click aqui para intentar otra vez.");

		if( !strcmp($char['last_map'], 'sec_pri') )
			redir("charstorage.php", "main_div", "El personaje se encuentra en Jail. No se puede realizar ningun movimiento!!.<br>Click aqui para intentar otra vez.");

		$unban_time = time() + (1 * 60); // 2 minutos de seguridad de Baneo de Cuenta(s)
		$orig_account_id = $char['account_id'];

		if( $_POST['opt'] == 1 )
		{ // Guardar personaje
			if( $char['char_num'] == $CONFIG['MaxChars'] )
				redir("charstorage.php", "main_div", "El personaje que trata de guardar ya se encuentra en tu Storage de Chars!!.<br>Click aqui para intentar otra vez.");

			if( $char['guild_id'] > 0 || $char['party_id'] > 0 )
				redir("charstorage.php", "main_div", "No se pueden tramitar personajes en Party o Guild!!.<br>Click aqui para intentar otra vez.");

			if( $orig_account_id != $account_id )
				redir("charstorage.php", "main_div", "El personaje que trata de mover no es de tu cuenta!!.<br>Click aqui para intentar otra vez.");

			if( $services < 1 )
				redir("charstorage.php", "main_div", "No tienes puntos de Servicios para este tramite!!.<br>Invierte tus donativos en Puntos para esta funcion.<br>Click aqui para intentar otra vez.");

			$mysql->query("UPDATE `login` SET `unban_time` = '$unban_time' WHERE `account_id` = '$account_id'", $CONFIG['DBMain']);

			$services--;
			$mysql->query("UPDATE `char` SET `char_num` = '" . $CONFIG['MaxChars'] . "' WHERE `char_id` = '$charid'", $CONFIG['DBMain']);
			$mysql->query("UPDATE `members` SET `services` = `services` - 1 WHERE `member_id` = '$member_id'", $CONFIG['DBMain']);
		}
		elseif( $_POST['opt'] == 2 && isset($_POST['slot']) && is_numeric($_POST['slot']) )
		{ // Regresar Personaje
			$slot = $_POST['slot'];

			if( $char['char_num'] != $CONFIG['MaxChars'] )
				redir("charstorage.php", "main_div", "El personaje que trata de regresar no esta en tu Storage de Chars!!.<br>Click aqui para intentar otra vez.");

			if( $char['sex'] != $_SESSION[$CONFIG['Name'] . 'sex'] && ($char['class'] == 19 || $char['class'] == 20 || $char['class'] == 4020 || $char['class'] == 4021) )
				redir("charstorage.php", "main_div", "El personaje que trata de mover puede ser cambiado de Sexo!!.<br>Bardo, Dancer y Advanced de este tipo no pueden ser puestos en una cuenta de diferente sexo a la origen.<br>Click aqui para intentar otra vez.");

			if( $result = $mysql->fetchrow($mysql->query("SELECT `char_id` FROM `char` WHERE `char_num` = '$slot' AND `account_id` = '$account_id'", $CONFIG['DBMain'])))
				redir("charstorage.php", "main_div", "El slot al que tratar de mover el personaje ya se encuentra en uso.<br>Click aqui para intentar otra vez.");

			if( is_online2($orig_account_id) )
				redir("charstorage.php", "main_div", "La cuenta origen del Personaje esta activa en el juego, no se puede continuar!!.<br>Click aqui para intentar otra vez.");

			$mysql->query("UPDATE `login` SET `unban_time` = '$unban_time' WHERE `account_id` = '$account_id' || `account_id` = '$orig_account_id'", $CONFIG['DBMain']);
			$mysql->query("UPDATE `char` SET `account_id` = '$account_id', `char_num` = '$slot' WHERE `char_id` = '$charid'", $CONFIG['DBMain']);
			$mysql->query("DELETE FROM `sc_data` WHERE `account_id` = '$orig_account_id' AND `char_id` = '$charid'", $CONFIG['DBMain']);
			$mysql->query("UPDATE `friends` SET `friend_account` = '$account_id' WHERE `friend_account` = '$orig_account_id' AND `friend_id` = '$charid'", $CONFIG['DBMain']);
			$mysql->query("UPDATE `pet` SET `account_id` = '$account_id' WHERE `account_id` = '$orig_account_id' AND `char_id` = '$charid'", $CONFIG['DBMain']);
		}
	}

	opentable("Storage y Traslado de Personajes");
?>
	<table width="600">
		<tr>
			<td align="center">
				Utiliza esta secci&oacute;n del Panel de Cuentas para trasladar personajes entre cuentas de tu misma Membres&iacute;a.<br><br>
				<b>Requisitos para tramitar:</b><br>
				- Personaje debe estar sin Guild, ni party.<br>
				- La cuenta debe estar fuera del juego.<br>
				- Se requiere <b>1 Punto de Servicio</b> para almacenar un Personaje en tu Storage de Chars.<br>
				- Por seguridad, cada movimiento que realices banea la cuenta (o cuentas) por 1 minuto.<br>
			</td>
		</tr>
		<tr>
			<td align="center" height="10" valign="top">&nbsp;</td>
		</tr>
<?php
	echo '
			<tr>
				<td align="center" valign="top">
					Tu cuenta Activa : <b>' . $_SESSION[$CONFIG['Name'] . 'userid'] . '</b><br><br>
					Tus puntos de Servicio : <b>' . $services . '</b>
				</td>
			</tr>
			<tr><td align="center" height="10" valign="top">&nbsp;</td></tr>
			<tr>
				<td align="center" height="10" valign="top"><b>Personajes en Cuenta</b></td>
			</tr>
			<tr><td align="center" height="10" valign="top">&nbsp;</td></tr>
			<tr>
				<td align="center">
					<table width="600">
						<tr bgcolor="#FF6600">
							<td align="left"><font color="White"><b>Slot</b></font></td>
							<td align="left"><font color="White"><b>Nombre</b></font></td>
							<td align="center"><font color="White"><b>Clase</b></font></td>
							<td align="center"><font color="White"><b>Level</b></font></td>
							<td align="right"><font color="White"><b>Operacion</b></font></td>
						</tr>
	';

	$jobs = $_SESSION[$CONFIG['Name'] . 'jobs'];
	// Account Char List
	$result = $mysql->query("SELECT `char_id`, `char_num`, `name`, `base_level`, `job_level`, `class` FROM `char` WHERE `char_num` < '" . $CONFIG['MaxChars'] . "' AND `account_id` = '$account_id'", $CONFIG['DBMain']);

	while( $char = $mysql->fetcharray($result) )
	{
		echo '
			<tr>
				<td align="left">' . $char['char_num'] . '</td>
				<td align="left">' . htmlformat($char['name']) . '</td>
				<td align="center"><img src="./imgwm/' . $char['class'] . '.gif"><br>' . $jobs[$char['class']] . '</td>
				<td align="center">(' . $char['base_level'] . '/' . $char['job_level'] . ')</td>
				<td align="right">
					<form id="store' . $char['char_num'] . '" onsubmit="return POST_ajax(\'charstorage.php\',\'main_div\',\'store' . $char['char_num'] . '\')">
						<input type="hidden" name="opt" value="1">
						<input type="hidden" name="char_id" value="' . $char['char_id'] . '">
						<input type="submit" value="Almacenar">
					</form>
				</td>
			</tr>
		';
	}

	echo '
					</table>
				</td>
			</tr>
			<tr><td align="center" height="10" valign="top">&nbsp;</td></tr>
			<tr>
				<td align="center" height="10" valign="top"><b>Personajes en Storage</b></td>
			</tr>
			<tr><td align="center" height="10" valign="top">&nbsp;</td></tr>
			<tr>
				<td align="center">
					<table width="600">
						<tr bgcolor="#FF6600">
							<td align="left"><font color="White"><b>Nombre</b></font></td>
							<td align="center"><font color="White"><b>Clase</b></font></td>
							<td align="center"><font color="White"><b>Level</b></font></td>
							<td align="right"><font color="White"><b>Operacion</b></font></td>
						</tr>
	';

	// Storage Char List

	$result = $mysql->query("
		SELECT
			`char`.`char_id`, `char`.`char_num`, `char`.`name`, `char`.`base_level`, `char`.`job_level`, `char`.`class`
		FROM
			`char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id`
		WHERE
			`char`.`char_num` = '" . $CONFIG['MaxChars'] . "' AND `login`.`member_id` = '$member_id'
	", $CONFIG['DBMain']);

	while( $char = $mysql->fetcharray($result) )
	{
		echo '
			<tr>
				<td align="left">' . htmlformat($char['name']) . '</td>
				<td align="center"><img src="./imgwm/' . $char['class'] . '.gif"><br>' . $jobs[$char['class']] . '</td>
				<td align="center">(' . $char['base_level'] . '/' . $char['job_level'] . ')</td>
				<td align="right">
					<form id="return' . $char['char_id'] . '" onsubmit="return POST_ajax(\'charstorage.php\',\'main_div\',\'return' . $char['char_id'] . '\')">
						<input type="hidden" name="opt" value="2">
						<input type="hidden" name="char_id" value="' . $char['char_id'] . '">
						<b>Slot:</b>&nbsp;
						<select name="slot">
		';

		for( $i = 0; $i < 9; $i++ )
		{
			if( $i == 0 )
				echo "<option value=\"$i\" selected>$i";
			else
				echo "<option value=\"$i\">$i";
		}

		echo '
						</select>&nbsp;
						<input type="submit" value="Regresar">
					</form>
				</td>
			</tr>
		';
	}

	echo '
					</table>
				</td>
			</tr>
			<tr><td align="center" height="10" valign="top">&nbsp;</td></tr>
		</table>
	';
	closetable();
?>
