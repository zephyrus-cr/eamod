<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	opentable("Recuper Clave de Miembro");
?>
<table width="550" height="300">
	<tr>
		<td align="center" valign="middle" height="30">
<?php
	if (isset($_SESSION[$CONFIG['Name'] . 'member_id']) && $_SESSION[$CONFIG['Name'] . 'member_id'] > 0)
	{ // Ya esta logeado
?>
			<b><font color="Red" size="2">Ya has iniciado sesi&oacute;n en este equipo!!</font></b><br>
			Debes salirte para poder realizar el tr&aacute;mite de recuperaci&oacute;n de Clave de Membres&iacute;a.
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle" height="30">
			<span title="Terminar con tu sesion de administracion" style="cursor:pointer" onMouseOver="this.style.color='#FF3300'" onMouseOut="this.style.color='#FFFFFF'" onClick="LINK_ajax('login.php?opt=1','login_div');">
				<img src="logout.gif">
			</span>
<?php
	}
	elseif (!isset($_POST['email']))
	{ // Solicitud de Clave
		$_SESSION[$CONFIG['Name'] . 'securitycode'] = rand(12345,99999);
		$fakecode = rand(11111,99999);
?>
			Para recuperar tu <b>Clave de Membres&iacute;a</b> indica los datos que se piden a continuaci&oacute;n. Si el correo es correcto, se te enviar&aacute;
			un mail con la informaci&oacute;n de tu Clave.
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle" height="270">
			<form id="recover1" onsubmit="return POST_ajax('recover.php','main_div','recover1');">
				<table width="550" height="270">
					<tr>
						<td align="center" height="20" valign="middle">
							<b>Correo Electr&oacute;nico</b>
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="top">
							<input type="text" name="email" maxlength="39" size="39" onkeypress="return force(this.name, this.form.id, event);">
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="middle">
							<b>C&oacute;digo de Seguridad</b>
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="top">
							<img src="img.php?cod= <?php echo $fakecode; ?>" alt="Codigo de Seguridad">
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="middle">
							Reescribe el c&oacute;digo en el siguiente cuadro
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="top">
							<input type="text" name="code" maxlength="6" size="6" onkeypress="return force(this.name, this.form.id, event);">
						</td>
					</tr>
					<tr>
						<td align="center" height="30" valign="middle">
							<input type="submit" value="Solicitar Clave">
						</td>
					</tr>
				</table>
			</form>
<?php
	}
	else
	{
		$email = trim($_POST['email']);
		$code = $_POST['code'];

		if (inject($email) || strlen($email) < 7 || !strstr($_POST['email'], '@'))
		{ // Email invalido
			?>
							<b><font color="Red" size="2">Direcci&oacute;n de Correo con Caracteres no V&aacute;lidos!!</font></b>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" height="60">
							La direcci&oacute;n de correo que ingresaste, o bien no es v&aacute;lida o tiene caracteres inapropiados para la seguridad del servidor.<br>
							Regresa e intentalo de nuevo en <span title="Recuperar clave de Miembro" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('recover.php','main_div');"></b>Recuperar Clave</b></span>.
			<?php
		}
		elseif (strtoupper($code) != substr(strtoupper(md5("Gaiaro" . $_SESSION[$CONFIG['Name'] . 'securitycode'])), 0, 6))
		{ // Codigo de Seguridad Diferente
			?>
							<b><font color="Red" size="2">C&oacute;digo de Seguridad no concuerda!!</font></b>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" height="60">
							No concuerda el c&oacute;digo de seguridad con el que escribiste.<br>
							Intenta de nuevo haciendo click en <span title="Recuperar clave de Miembro" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('recover.php','main_div');"></b>Recuperar Clave</b></span>.
			<?php
		}
		elseif (!($member = $mysql->fetcharray($mysql->query("
				SELECT
					*
				FROM
					`members`
				WHERE
					BINARY `email` = '$email'
			", $CONFIG['DBMain']))))
		{ // Correo no Registrado
			?>
							<b><font color="Red" size="2">Cuenta de Correo no Encontrada!!</font></b>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" height="60">
							La direcci&oacute;n de correo que ingresaste no fue encontrada en la Base de Datos.<br>
							Regresa e intentalo de nuevo en <span title="Recuperar clave de Miembro" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('recover.php','main_div');"></b>Recuperar Clave</b></span>.
			<?php
		}
		else
		{ // Encontrada... enviando mail con Clave
			$mpass = $member['mpass'];
			$asunto = "Evangelis - Solicitud de Clave de Miembro";
			$message = "";
			$message.= "Se realizo una solicitud de Recuperacion de Clave de Membresia de esta cuenta de correo en el Servidor Evangelis.\n\n";
			$message.= "Este mensaje ha sido enviado automaticamente ya que usted (o alguien mas) coloco este correo como solicitante.\n\n\n";
			$message.= "Su clave de Miembro es: $mpass\n\n\n\n";
			$message.= "Servidor Evangelis Ragnarok.\n";
			$message.= "High Rates Premium.\n";
			sendmail($email, $asunto, $message);

			?>
							<b><font color="Red" size="2">Mensaje con Clave ha sido enviado!!</font></b>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" height="60">
							Revisa la cuenta de correo <b><? echo $email; ?></b>. Dentro de poco tiempo llear&aacute; un mensaje con la Clave de tu cuenta de Miembro Evangelis.
							Si no logras recuperar tu clave, ponte en contacto con algun administrador del juego.<br><br>
							Cuando ya tengas tu clave utiliza el bot&oacute;n de <span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('member.php','main_div');"></b>Iniciar Sesi&oacute;n</b></span>.
			<?php
		}
	}

	echo '
				</td>
			</tr>
		</table>
	';

	closetable();
?>