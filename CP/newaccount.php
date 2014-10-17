<?php
	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	if (isset($_POST['opt']))
	{
		if ($_POST['opt'] == 1 && isset($_POST['frm_name']) && !strcmp($_POST['frm_name'], 'account'))
		{ // Revisando Datos para creacion de Cuenta
			$userid = trim($_POST['userid']);
			$pass = trim($_POST['apass']);
			$sex = $_POST['sex'];

			if(strlen($userid) < 6 || strlen($userid) > 23 || inject($userid))
				redir("newaccount.php", "main_div", "El nombre de usuario es Invalido o tiene caracteres inapropiados.<br>Click aqui para continuar");

			if(strlen($pass) < 6 || strlen($pass) > 23 || inject($pass))
				redir("newaccount.php", "main_div", "La Clave es Invalido o tiene caracteres inapropiados.<br>Click aqui para continuar");

			if(strcmp($pass, trim($_POST['cpass'])))
				redir("newaccount.php", "main_div", "Las Claves de Cuenta y Confirmacion no son iguales.<br>Click aqui para continuar");

			if(!strcmp($pass, $userid))
				redir("newaccount.php", "main_div", "La Clave no puede ser igual al Login.<br>Click aqui para continuar");

			$email = $_SESSION[$CONFIG['Name'] . 'email'];
			$member_id = $_SESSION[$CONFIG['Name'] . 'member_id'];
			$last_ip = $_SERVER['REMOTE_ADDR'];

			if($mysql->countrows($mysql->query("SELECT `account_id` FROM `login` WHERE `userid` = '$userid'", $CONFIG['DBMain'])) > 0)
				redir("newaccount.php", "main_div", "El Login ya esta en uso en la Base de Datos, utiliza otro.<br>Click aqui para continuar");

			$mysql->query("
				INSERT INTO `login`
					(`userid`, `user_pass`, `sex`, `email`, `last_ip`, `member_id`)
				VALUES
					('$userid', '$pass', '$sex', '$email', '$last_ip', '$member_id')
			", $CONFIG['DBMain']);

			if($mysql->countrows($mysql->query("SELECT `account_id` FROM `login` WHERE `userid` = '$userid'", $CONFIG['DBMain'])) > 0)
				redir("cuentas.php", "main_div", "La Cuenta ha sido creada en Evangelis. Haga click aqui para regresar.");
			else
				redir("newaccount.php", "main_div", "Hubo un problema al crear la cuenta, intenta de nuevo. <br>Click aqui para continuar");
		}
	}

	opentable("Creando Cuenta de Juego");
?>
	<form id="account" onSubmit="return POST_ajax('newaccount.php','main_div','account');">
		<table width="550">
			<tr>
				<td align="center" height="30" valign="middle">
					Ingresa los datos que se solicitan a continuacion para crear tu cuenta de juego.
				</td>
			</tr>
			<tr>
				<td align="center" height="30" valign="middle">
					<b>ID de Cuenta, Login o Nombre de Usuario</b><br>
					Este sera el que pongas en la ventana del juego cuando quieres entrar.<br>
					<font color="Gray">(6 a 23 letras o n&uacute;meros, May&uacute;sculas o Min&uacute;sculas)</font>
				</td>
			</tr>
			<tr>
				<td align="center" height="20" valign="top">
					<input type="text" name="userid" maxlength="23" size="23" onkeypress="return force(this.name, this.form.id, event);">
				</td>
			</tr>
			<tr>
				<td align="center" height="30" valign="middle">
					<b>Contrase&ntilde;a de Cuenta</b><br>
					No es necesario que sea la misma de la cuenta de miembro y no se recomienda.<br>
					<font color="Gray">(6 a 23 letras o n&uacute;meros, May&uacute;sculas o Min&uacute;sculas)</font>
				</td>
			</tr>
			<tr>
				<td align="center" height="20" valign="top">
					<input type="password" name="apass" maxlength="23" size="23" onkeypress="return force(this.name, this.form.id, event);">
				</td>
			</tr>
			<tr>
				<td align="center" height="20" valign="middle">
					<b>Conformar Contrase&ntilde;a</b><br>
					Repite la clave que ingresaste arriba, por seguridad.
				</td>
			</tr>
			<tr>
				<td align="center" height="20" valign="top">
					<input type="password" name="cpass" maxlength="23" size="23" onkeypress="return force(this.name, this.form.id, event);">
				</td>
			</tr>
			<tr>
				<td align="center" height="20" valign="middle">
					<b>G&eacute;nero de Cuenta - Sexo</b><br>
					Este ser&aacute; el g&eacute;nero de todos los personajes bajo esa cuenta.
				</td>
			</tr>
			<tr>
				<td align="center" height="20" valign="top">
					<select name="sex" onKeyPress="return force(this.name,this.form.id,event);">
						<option value="M">Masculino</option>
						<option value="F">Femenino</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="center" height="120" valign="middle">
					<img src="account.gif">
				</td>
			</tr>
			<tr>
				<td align="center" height="30" valign="middle">
					<input type="submit" value="Crear la Cuenta">
				</td>
			</tr>
		</table>
		<input type="hidden" name="opt" value="1">
	</form>
<?php
	closetable();
?>