<?php
	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	if (isset($_GET['opt']))
	{
		// Verificacion si el userid corresponde al MemberID
		$member_id = $_SESSION[$CONFIG['Name'] . 'member_id'];

		$result = $mysql->query("
			SELECT
				`userid`, `user_pass`
			FROM
				`login`
			WHERE
				`state` <> '5' AND `member_id` = '$member_id'
		", $CONFIG['DBMain']);

		if ($mysql->countrows($result) > 0)
		{
			$asunto = "Evangelis RO - Solicitud de Claves de Juego";
			$message = "";
			$message.= "Este correo ha sido envidado automaticamente por solicitud, para recuperar todas las claves de Juego de Evangelis Ragnarok.\n\n";

			while ($line = $mysql->fetchrow($result)) {
				$message.= "User ID: $line[0] - Password: $line[1]\n\n";
			}
			$message.= "\n\n\n";
			$message.= "Servidor Evangelis Ragnarok.\n";
			$message.= "High Rates Premium Server.\n";
			$email = $_SESSION[$CONFIG['Name'] . 'email'];
			sendmail($email, $asunto, $message);

			redir("cuentas.php", "main_div", "Un mensaje con todas las claves de sus cuentas ha sido envidado a $email.<br>Haga click aqui para regresar.");
		}
		else
		{
			redir("cuentas.php", "main_div", "Aun no ha registrado cuentas de jugador en esta Membresia.<br>Haga click aqui para regresar.");
		}
	}
	else
	{
		opentable("Recuperacion de Claves de Jugador");
?>
	<table width="550">
		<tr>
			<td align="center" height="30" valign="middle">
				Para recuperar tus claves de cuentas de juegos has click en el siguiente link:<br><br><br>
				<span title="Recuperar claves de jugador" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('accountrecover.php?opt=1','main_div');"></b>Recuperar Contrase&ntilde;as</b></span><br><br><br>
				Un mensaje de Correo ser&aacute; enviado con la informaci&oacute;n de tus cuentas.
			</td>
		</tr>
	</table>
<?php
		closetable();
	}
?>