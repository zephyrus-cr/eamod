<?php
	session_start();
	include_once('config.php');
	include_once('functions.php');

	if (isset($_GET['opt']) && $_GET['opt'] == 1)
	{
		session_destroy();
		session_start();
		echo "
			<script type=\"text/javascript\">
				LINK_ajax('news.php','main_div');
				load_menu();
			</script>
		";
	}

	opentable('');
	echo '
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center">
					<img src="orcbaby.gif">
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="center">
	';

	if (isset($_SESSION[$CONFIG['Name'] . 'member_id']) && $_SESSION[$CONFIG['Name'] . 'member_id'] > 0)
	{ // Sesion Activa
		$nombre = htmlformat($_SESSION[$CONFIG['Name'] . 'nombre']);
		echo "		<b>Bienvenido, $nombre</b>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		";

		if (isset($_SESSION[$CONFIG['Name'] . 'account_id']) && $_SESSION[$CONFIG['Name'] . 'account_id'] > 0)
		{
			echo "
				<tr>
					<td align=\"center\">
						Cuenta Seleccionada<br><br>
						<img src=\"" . $_SESSION[$CONFIG['Name'] . 'sex'] . ".gif\"><br>
						<b>" . $_SESSION[$CONFIG['Name'] . 'userid'] . "</b>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align=\"center\">
						<span title=\"Click aqui para seleccionar otra cuenta de juego\" style=\"cursor:pointer\" onMouseOver=\"this.style.color='#FF3300'\" onMouseOut=\"this.style.color='#FFFFFF'\" onClick=\"LINK_ajax('cuentas.php','main_div');\">
							<img src=\"accswitch.png\">
						</span>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align=\"center\">
						<span title=\"Click aqui para reportar donaciones o informate del sistema\" style=\"cursor:pointer\" onMouseOver=\"this.style.color='#FF3300'\" onMouseOut=\"this.style.color='#FFFFFF'\" onClick=\"LINK_ajax('donate.php','main_div');\">
							<img src=\"donar.png\">
						</span>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			";
		}
		else
		{
			echo "
				<tr>
					<td align=\"center\">
						<span title=\"Click aqui para seleccionar una cuenta de juego\" style=\"cursor:pointer\" onMouseOver=\"this.style.color='#FF3300'\" onMouseOut=\"this.style.color='#FFFFFF'\" onClick=\"LINK_ajax('cuentas.php','main_div');\">
							<img src=\"accselect.png\">
						</span>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			";
		}

		echo "
			<tr>
				<td align=\"center\">
					<span title=\"Terminar con tu sesion de administracion\" style=\"cursor:pointer\" onMouseOver=\"this.style.color='#FF3300'\" onMouseOut=\"this.style.color='#FFFFFF'\" onClick=\"LINK_ajax('login.php?opt=1','login_div');\">
						<img src=\"logout.gif\">
					</span>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		";
	}
	else
	{ // Sin sesion
		echo "		<b>Bienvenido, Invitado</b>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align=\"center\">
					<span title=\"Accesa o create tu cuenta ahora\" style=\"cursor:pointer\" onMouseOver=\"this.style.color='#FF3300'\" onMouseOut=\"this.style.color='#FFFFFF'\" onClick=\"LINK_ajax('member.php','main_div');\">
						<img src=\"login.gif\">
					</span>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align=\"center\">
					<span title=\"Click para ayudarte a recuperar tu clave de miembro\" style=\"cursor:pointer\" onMouseOver=\"this.style.color='#FF3300'\" onMouseOut=\"this.style.color='#FFFFFF'\" onClick=\"LINK_ajax('recover.php','main_div');\">
						<img src=\"pass.gif\">
					</span>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		";
	}

	echo "
			<tr>
				<td align=\"center\">
					<a href=\"http://foro.evangelis-ro.cl/viewforum.php?f=20\"><img src=\"itemspremium.png\" border=\"0\"></a>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
	";
	closetable();
?>