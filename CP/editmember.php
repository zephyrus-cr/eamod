<?php
	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	if (isset($_POST['opt']) && $_POST['opt'] == 1)
	{ // Cambiando contraseña
		if( strlen($_POST['cpass']) < 6 || strlen($_POST['cpass']) > 40 || inject($_POST['cpass']) )
			redir("editmember.php","main_div","Valor invalido en el campo de clave actual.<br>Intenta nuevamente.");

		if( !($result = $mysql->fetcharray($mysql->query("SELECT `mpass` FROM `members` WHERE `member_id` = '" . $_SESSION[$CONFIG['Name'] . 'member_id'] . "'", $CONFIG['DBMain']))) )
			redir("editmember.php","main_div","Problema en la Base de Datos, intente de nuevo.<br>Intenta nuevamente.");

		if( strcmp($result['mpass'], $_POST['cpass']) )
			redir("editmember.php","main_div","La clave actual no coincide con la de tu cuenta!!.<br>Intenta nuevamente.");

		if( strlen($_POST['npass']) < 6 || strlen($_POST['npass']) > 40 || inject($_POST['npass']) )
			redir("editmember.php","main_div","Valor invalido en el campo de clave nueva.<br>Intenta nuevamente.");

		if( strcmp($_POST['npass'], $_POST['rpass']) )
			redir("editmember.php","main_div","La clave nueva no coincide con la verificacion!!.<br>Intenta nuevamente.");

		$mysql->query("UPDATE `members` SET `mpass` = '" . $_POST['npass'] . "' WHERE `member_id` = '" . $_SESSION[$CONFIG['Name'] . 'member_id'] . "'", $CONFIG['DBMain']);

		// E-Mail to Member
		$asunto = 'Evangelis Ragnarok - Cambio de Clave Membresia';
		$message = "";
		$message.= "Este mensaje es para notificarle que su cuenta ha cambiado de Clave.\n\n";
		$message.= "La nueva clave es : " . $_POST['npass'] . ".\n\n\n";
		$message.= "Servidor Evangelis Ragnarok.\n";
		$message.= "High Rates Premium.\n";
		sendmail($_SESSION[$CONFIG['Name'] . 'email'], $asunto, $message);

		redir("cuentas.php","main_div","La Clave de Membresia ha sido cambiada con exito!!.<br>Clic aqui para seleccionar una Cuenta.");
	}
	else
	{
		opentable("Clave de Membresia");
?>
	<form id="changepass" onsubmit="return POST_ajax('editmember.php','main_div','changepass');">
	<table width="550">
		<tr>
			<td align="center" height="30" valign="middle">
				Para realizar un cambio de clave de membresia, por favor indica tu clave actual, y 2 veces tu nueva clave.<br>
				Un correo ser&aacute; enviado para confirmar que hiciste el cambio.<br><br>
				El correo debe medir entre 6 y 40 caracteres, y solo debes usar letras o n&uacute;meros.
			</td>
		</tr>
		<tr>
			<td align="center" height="20" valign="middle"><b>Clave Actual de Cuenta:</b></td>
		</tr>
		<tr>
			<td align="center" height="30" valign="top">
				<input type="password" name="cpass" maxlength="40" size="40" onkeypress="return force(this.name, this.form.id, event);">
			</td>
		</tr>
		<tr>
			<td align="center" height="20" valign="middle"><b>Nueva Clave:</b></td>
		</tr>
		<tr>
			<td align="center" height="30" valign="top">
				<input type="password" name="npass" maxlength="40" size="40" onkeypress="return force(this.name, this.form.id, event);">
			</td>
		</tr>
		<tr>
			<td align="center" height="20" valign="middle"><b>Confirma la Nueva Clave:</b></td>
		</tr>
		<tr>
			<td align="center" height="30" valign="top">
				<input type="password" name="rpass" maxlength="40" size="40" onkeypress="return force(this.name, this.form.id, event);">
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