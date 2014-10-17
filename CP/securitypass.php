<?php
	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	if (!isset($_SESSION[$CONFIG['Name'] . 'account_id']) || $_SESSION[$CONFIG['Name'] . 'account_id'] <= 0)
		redir("cuentas.php", "main_div", "Primero selecciona una cuenta de juego para proceder");

	if( isset($_GET['opt']) && $_GET['opt'] == 1 )
	{ // Recover Account Storage Password
		$asunto = "[Evangelis Ragnarok] Solicitud de Clave de Seguridad";
		$mensaje = "";
		$mensaje.= "Esta es la clave de seguridad para la cuenta: " . $_GET['userid'] . ".\n";
		$mensaje.= "Clave: " . $_GET['pass'] . "\n";

		sendmail($_SESSION[$CONFIG['Name'] . 'email'], $asunto, $mensaje);

		redir("cuentas.php", "main_div", "El mensaje con la clave de Seguridad ha sido enviado a tu email.");
	}

	$account_id = $_SESSION[$CONFIG['Name'] . 'account_id'];
	// Normal Page
	$result = $mysql->query("
		SELECT
			`global_reg_value`.`value` - 0 AS clave, `login`.`userid`
		FROM
			`global_reg_value` LEFT JOIN `login` ON `login`.`account_id` = `global_reg_value`.`account_id`
		WHERE
			`login`.`account_id` = '$account_id' AND `global_reg_value`.`str` = '#SECURITYCODE' AND `global_reg_value`.`value` <> '0'
	", $CONFIG['DBMain']);

	if( $line = $mysql->fetcharray($result) )
	{
		opentable('Clave de Seguridad');
		echo('
			<table width="550">
				<tr>
					<td align="center">
						Otro agregado al sistema de seguridad de personajes e items, es el<br>
						modulo de @security (comando).<br>
						Con este comando podras configurar tu clave de 4 digitos para permitir<br>
						la entrada o salida de items de tu personaje. Si eres lo suficiente<br>
						terco para entender que no es seguro prestar cuentas, aun puedes usar este<br>
						sistema para ponerle clave a tu personaje y prohibir toda salida de items<br>
						del mismo.<br>
					</td>
				</tr>
			</table>
			<hr>
			<table width="550">
				<tr>
					<td aligh="center">
						<form id="stpass" onsubmit="return GET_ajax(\'securitypass.php\',\'main_div\',\'stpass\')">
							<input type="hidden" name="opt" value=1>
							<input type="hidden" name="pass" value=' . $line['clave'] . '>
							<input type="hidden" name="userid" value="' . $line['userid'] . '">
							<input type="submit" value="Enviarme Secu-Code">
						</form>
					</td>
				</tr>
			</table>
		');
		closetable();
	}
	else
	{
		redir("cuentas.php", "main_div", "Esta cuenta de juego no tiene clave de Security.");
	}
?>