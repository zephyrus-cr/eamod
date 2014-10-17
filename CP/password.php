<?php
	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	if (!isset($_SESSION[$CONFIG['Name'] . 'account_id']) || $_SESSION[$CONFIG['Name'] . 'account_id'] <= 0)
		redir("cuentas.php", "main_div", "Primero selecciona una cuenta de juego para proceder");

	if (isset($_POST['opt']) && $_POST['opt'] == 1)
	{
		if (strlen($_POST['cpass']) < 6 || strlen($_POST['cpass']) > 23 || inject($_POST['cpass']))
			redir ("password.php", "main_div", "La Clave Actual no es del largo correcto o contiene caracteres no permitidos.<br>Click aqui para volver a intentarlo.");

		$result = $mysql->query("
			SELECT
				`user_pass`
			FROM
				`login`
			WHERE
				`account_id` = '" . $_SESSION[$CONFIG['Name'] . 'account_id'] . "' AND
				`member_id` = '" . $_SESSION[$CONFIG['Name'] . 'member_id'] . "'
		", $CONFIG['DBMain']);

		if (!($acc = $mysql->fetchrow($result)))
			redir ("cuentas.php", "main_div", "La Cuenta no corresponde a tu Membresia o hay problemas para obtener la informacion actual.<br>Click aqui para seleccionar la cuenta de nuevo.");

		if (strcmp($acc[0], $_POST['cpass']))
			redir ("password.php", "main_div", "La Clave que ingresate como Actual, no corresponde a la de la Cuenta.<br>Click aqui para volver a intentarlo.");

		if (strlen($_POST['npass']) < 6 || strlen($_POST['npass']) > 23 || inject($_POST['npass']))
			redir ("password.php", "main_div", "La Clave Nueva no es del largo correcto o contiene caracteres no permitidos.<br>Click aqui para volver a intentarlo.");

		if (strlen($_POST['rpass']) < 6 || strlen($_POST['rpass']) > 23 || inject($_POST['rpass']))
			redir ("password.php", "main_div", "La Confirmacion de Clave no es del largo correcto o contiene caracteres no permitidos.<br>Click aqui para volver a intentarlo.");

		if (strcmp($_POST['npass'], $_POST['rpass']))
			redir ("password.php", "main_div", "La Clave Nueva y la Confirmacion no son iguales. <br>Click aqui para volver a intentarlo.");

		// Todo comprobado, Realizando el Cambio

		$mysql->query("
			UPDATE
				`login`
			SET
				`user_pass` = '". $_POST['npass'] . "'
			WHERE
				`account_id` = '" . $_SESSION[$CONFIG['Name'] . 'account_id'] . "'
		", $CONFIG['DBMain']);

		redir ("cuentas.php", "main_div", "Tu clave ha sido cambiada con Exito.<br>Click aqui para volver al menu de Cuentas.");
	}
	else
	{
		opentable("Cambio de Clave de Juego");
?>
	<form id="changepass" onsubmit="return POST_ajax('password.php','main_div','changepass');">
		<table width="550">
			<tr>
				<td align="center" height="30" valign="middle">
					Para cambiar de la cuenta <b><?php echo $_SESSION[$CONFIG['Name'] . 'userid']; ?></b> por favor
					ingresa la informaci&oacute;n que se te solicita a continuaci&oacute;n.
				</td>
			</tr>
			<tr>
				<td align="center" height="20" valign="middle"><b>Clave Actual de Juego:</b></td>
			</tr>
			<tr>
				<td align="center" height="30" valign="top">
					<input type="password" name="cpass" maxlength="23" size="23" onkeypress="return force(this.name, this.form.id, event);">
				</td>
			</tr>
			<tr>
				<td align="center" height="20" valign="middle"><b>Nueva Clave:</b></td>
			</tr>
			<tr>
				<td align="center" height="30" valign="top">
					<input type="password" name="npass" maxlength="23" size="23" onkeypress="return force(this.name, this.form.id, event);">
				</td>
			</tr>
			<tr>
				<td align="center" height="20" valign="middle"><b>Confirma la Nueva Clave:</b></td>
			</tr>
			<tr>
				<td align="center" height="30" valign="top">
					<input type="password" name="rpass" maxlength="23" size="23" onkeypress="return force(this.name, this.form.id, event);">
				</td>
			</tr>
			<tr>
				<td align="center" height="50" valign="middle">
					<input type="submit" value="Realizar Cambio">
				</td>
			</tr>
		</table>
		<input type="hidden" name="opt" value="1">
	</form>
<?php
	}
	closetable();
?>