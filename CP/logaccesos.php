<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	if (!isset($_SESSION[$CONFIG['Name'] . 'account_id']) || $_SESSION[$CONFIG['Name'] . 'account_id'] <= 0)
		redir("cuentas.php", "main_div", "Debes seleccionar una cuenta de juego para accesar aca.");

	if (!empty($_GET['opt']) && $_GET['opt'] == 1 && !inject($_GET['thisip']))
	{ // Buscando Quien es por IP
		opentable("Quien es <b>" . $_GET['thisip'] . "</b> ?");

		echo ('
			<center>
			<hr>
			| <span title="regresar..." style="cursor:pointer" onMouseOver="this.style.color=#FF3300" onMouseOut="this.style.color=#000000" onClick="return LINK_ajax(\'logaccesos.php\',\'main_div\');">Regresar al Registro</span> |
			<hr>
			</center>
			<table width="550">
				<tr>
					<td align="center" colspan="5" class="head"><b>Por Registros de Ultimo Acceso:</b><br><br></td>
				</tr>
				<tr>
					<td align="left" class="head">Personaje</td>
					<td>&nbsp;</td>
					<td align="left" class="head">Clase</td>
					<td>&nbsp;</td>
					<td align="left" class="head">Acceso Final</td>
				</tr>
		');

		$jobs = $_SESSION[$CONFIG['Name'] . 'jobs'];

		$result = $mysql->query("
			SELECT
				`login`.`account_id` ,`char`.`name`, `char`.`class`, `login`.`lastlogin`
			FROM
				`char` LEFT JOIN `login` ON `char`.`account_id` = `login`.`account_id`
			WHERE
				`login`.`last_ip` = '" . $_GET['thisip'] . "'
			ORDER BY
				`login`.`lastlogin` DESC,
				`login`.`account_id`
		", $CONFIG['DBMain']);

		$account = 0;
		while ($line = $mysql->fetchrow($result))
		{
			if (strcmp($line[0],$account) != 0)
			{
				$account = $line[0];
				$fecha = htmlformat($line[3]);

				echo ('
					<tr>
						<td align="center" colspan="5">
							<hr>
						</td>
					</tr>
				');
			}
			else
			{
				$fecha = '...';
			}

			$nombre = htmlformat($line[1]);
			if (isset($jobs[$line[2]]))
				$job = $jobs[$line[2]];
			else
				$job = "Desconocido";

			echo "
				<tr>
					<td align=\"left\">$nombre</td>
					<td>&nbsp;</td>
					<td align=\"left\">$job</td>
					<td>&nbsp;</td>
					<td align=\"left\">$fecha</td>
				</tr>
			";
		}
	}
	else
	{ // Modo Normal
		if (isset($_GET['start']))
			$start = $_GET['start'];
		else
			$start = 0;

		$show = 30;

		$total = $mysql->fetchrow($mysql->query("
			SELECT
				COUNT(1) AS Accesos
			FROM
				`loginlog` LEFT JOIN `login` ON BINARY `login`.`userid` = `loginlog`.`user`
			WHERE
				`login`.`account_id` = '" . $_SESSION[$CONFIG['Name'] . 'account_id'] . "' AND `loginlog`.`time` > DATE_SUB(NOW(), INTERVAL 1 MONTH)
		", $CONFIG['DBLogs']));
		$count = $total[0];

		if ($count <= 0)
			redir("cuentas.php", "main_div", "No hay registros de accesos a su cuenta.<br>Click aqui para regresar");

		if ($start < 0 || $start > $count) $start = 0;
		$next = $start + $show;
		$prev = $start - $show;

		opentable("Registro de Accesos a Cuenta");

		echo ('
			<center>
			| <span title="Pagina Anterior" style="cursor:pointer" onMouseOver="this.style.color=#FF3300" onMouseOut="this.style.color=#000000" onClick="return LINK_ajax(\'logaccesos.php?start=' . $prev . '\',\'main_div\');">' . $show . ' Anteriores</span>
			 |
			<span title="Siguiente Pagina" style="cursor:pointer" onMouseOver="this.style.color=#FF3300" onMouseOut="this.style.color=#000000" onClick="return LINK_ajax(\'logaccesos.php?start=' . $next . '\',\'main_div\');">Siguientes ' . $show . '</span> |
			<br>
			<hr>
		');

		// Menu de Páginas
		for ($i = 0; $i < $count; $i += 30)
		{
			echo('
				<span title="del #' . ($i + 1) . ' en adelante" style="cursor:pointer" onMouseOver="this.style.color=#FF3300" onMouseOut="this.style.color=#000000" onClick="return LINK_ajax(\'logaccesos.php?start=' . $i . '\',\'main_div\');">
			');

			if ($i == $start)
				echo('<b>X</b></span>');
			else
				echo('O</span>');
		}

		// Obtencion del total de accesos registrados
		$result = $mysql->query("
			SELECT
				`loginlog`.`time`, `loginlog`.`ip`, `loginlog`.`rcode`, `loginlog`.`log`
			FROM
				`loginlog` LEFT JOIN `login` ON BINARY `login`.`userid` = `loginlog`.`user`
			WHERE
				`login`.`account_id` = '" . $_SESSION[$CONFIG['Name'] . 'account_id'] . "'
			ORDER BY
				`loginlog`.`time` DESC
			LIMIT $start, 30
		", $CONFIG['DBLogs']);

		// Resultados de Búsqueda
		echo('
			</center>
			<table width="550">
				<tr>
					<td align="left" class="head">Fecha</td>
					<td>&nbsp;</td>
					<td align="left" class="head">IP</td>
					<td>&nbsp;</td>
					<td align="left" class="head" colspan="3">Respuesta del Server...</td>
					<td>&nbsp;</td>
					<td align="center" class="head">' . htmlformat("¿Quien?") . '</td>
				</tr>
		');
		$i = 0;
		while ($line = $mysql->fetchrow($result))
		{
			$i += 1;
			$fecha = htmlformat($line[0]);
			$log =	 htmlformat($line[3]);
			$ip = $line[1];
			$cod = $line[2];

			echo "
				<tr>
					<td align=\"left\">$fecha</td>
					<td>&nbsp;</td>
					<td align=\"left\">$ip</td>
					<td>&nbsp;</td>
					<td align=\"right\">$cod</td>
					<td>&nbsp;</td>
					<td align=\"left\">$log</td>
					<td>&nbsp;</td>
					<td align=\"center\">
						<form id=\"log$i\" onsubmit=\"return GET_ajax('logaccesos.php','main_div','log$i')\">
							<input type=\"hidden\" name=\"opt\" value=\"1\">
							<input type=\"hidden\" name=\"thisip\" value=\"$ip\">
							<input type=\"submit\" value=\"Info\">
						</form>
					</td>
				</tr>
			";
		}

	}

	echo ('
		</table>
		<br>
		<hr>
		<table width="550">
			Si encuentras muchos accesos erroneos y consecutivos a tu cuenta, posiblemente esten tratando de hackear tu clave. Si sospechas de esto
			reporta cualquier problema a los GMs Principales: Perseus o Sgt.Slaughter <br>
			<br>
		</table>
	');

	closetable();
?>