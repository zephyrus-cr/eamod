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
		$asunto = "[Evangelis Ragnarok] Solicitud de Clave de Storage";
		$mensaje = "";
		$mensaje.= "Esta es la clave de storage para la cuenta: " . $_GET['userid'] . ".\n";
		$mensaje.= "Clave: " . $_GET['pass'] . "\n";

		sendmail($_SESSION[$CONFIG['Name'] . 'email'], $asunto, $mensaje);

		redir("cuentas.php", "main_div", "El mensaje con la clave de Storage ha sido enviado a tu email.");
	}

	$account_id = $_SESSION[$CONFIG['Name'] . 'account_id'];
	// Normal Page
	$result = $mysql->query("
		SELECT
			`global_reg_value`.`value` - `login`.`account_id` - 1337 AS clave, `login`.`userid`
		FROM
			`global_reg_value` LEFT JOIN `login` ON `login`.`account_id` = `global_reg_value`.`account_id`
		WHERE
			`login`.`account_id` = '$account_id' AND `global_reg_value`.`str` = '#kafra_code' AND `global_reg_value`.`value` <> '0'
	", $CONFIG['DBMain']);

	if( $line = $mysql->fetcharray($result) )
	{
		opentable('Clave de Storage');
		echo('
			<table width="550">
				<tr>
					<td align="center">
						Para aumentar la seguridad en las cuentas, se ofrece el servicio <br>
						de clave de Storage en Kafra. Con esto, si alguien tiene acceso a <br>
						tu cuenta (que no es recomendado dar), puedes proteger tus items. <br>
						Para colocar clave en tu storage, puedes hacerlo en cualquier Kafra <br>
						en la opcion <b>Revisar Otra Informacion</b> y luego en <b>Servicio de <br>
						contrasena de almacenaje</b>.<br>
						Si perdiste el dato de tu clave, puedes solicitar que se te envie al <br>
						mail de tu cuenta desde esta seccion. <br>
					</td>
				</tr>
			</table>
			<hr>
			<table width="550">
				<tr>
					<td aligh="center">
						<form id="stpass" onsubmit="return GET_ajax(\'storagepass.php\',\'main_div\',\'stpass\')">
							<input type="hidden" name="opt" value=1>
							<input type="hidden" name="pass" value=' . $line['clave'] . '>
							<input type="hidden" name="userid" value="' . $line['userid'] . '">
							<input type="submit" value="Enviarme Kafra-Pass">
						</form>
					</td>
				</tr>
			</table>
		');
		closetable();
	}
	else
	{
		redir("cuentas.php", "main_div", "Esta cuenta de juego no tiene clave de Storage.");
	}
?>