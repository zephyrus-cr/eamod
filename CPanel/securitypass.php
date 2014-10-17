<?php
	session_start();
	include_once 'config.php';
	include_once 'functions.php';

if (!empty($_SESSION[$CONFIG_name.'account_id'])) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {

	$account_id = $_SESSION[$CONFIG_name.'account_id'];

	DEFINE('SECUPASSMAIL',"SELECT `email` FROM `login` WHERE `account_id` = '".$account_id."'");
	$querysp = sprintf(SECUPASSMAIL);
	$resultsp = execute_query($querysp, "securitypass.php");
	$email = $resultsp->fetch_row();
	$emailp = $email[0];

	if( isset($POST_opt) && $POST_opt == 1 )
	{ // Recover Account Storage Password
		$asunto = "[Brawl Network RO] Clave de Seguridad";
		$mensaje = "Esta es la clave de seguridad para la cuenta: ".$POST_userid.".";
		$mensaje.= "\n\nClave: ".$POST_pass;

		mail($emailp, $asunto, $mensaje, "From: BrawlNetwork");
		redir("securitypass.php", "main_div", "El mensaje con la clave de Seguridad ha sido enviado a tu email.");
	}

	// Normal Page

	DEFINE('SECURITYPASS', "SELECT `global_reg_value`.`value` - 0 AS clave, `login`.`userid` FROM
			`global_reg_value` LEFT JOIN `login` ON `login`.`account_id` = `global_reg_value`.`account_id` WHERE
			`login`.`account_id` = '$account_id' AND `global_reg_value`.`str` = '#SECURITYCODE' AND `global_reg_value`.`value` <> '0'");

	$query = sprintf(SECURITYPASS);
	$result = execute_query($query, "securitypass.php");

	if( $line = $result->fetch_row() )
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
						<center><form id="stpass" onsubmit="return POST_ajax(\'securitypass.php\',\'main_div\',\'stpass\')">
							<input type="hidden" name="opt" value=1>
							<input type="hidden" name="pass" value=' . $line[0] . '>
							<input type="hidden" name="userid" value="' . $line[1] . '">
							<input type="submit" value="Enviarme Security Code">
						</center></form>
					</td>
				</tr>
			</table>
		');
		closetable();
	}
	else
	{
		redir("securitypass.php", "main_div", "Esta cuenta de juego no tiene clave de Security.");
	}
	}
	}
?>