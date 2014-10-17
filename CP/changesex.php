<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	if (!empty($_SESSION[$CONFIG['Name'] . 'account_id']))
	{
		if ($_SESSION[$CONFIG['Name'] . 'account_id'] > 0)
		{
			if (!empty($_GET['opt']))
			{
				if (is_online())
					redir("cuentas.php", "main_div", "No puedes realizar este cambio mientras estes Online en el juego.<br>Click aqui para continuar.");

				// Buscando Bardos o Dancers
				$check = $mysql->fetchrow($mysql->query("
					SELECT
						count(1)
					FROM
						`char`
					WHERE
						(`class` = '19' OR `class` = '20' OR `class` = '4020' OR `class` = '4021') AND
						`account_id` = '" . $_SESSION[$CONFIG['Name'] . 'account_id'] . "'
				", $CONFIG['DBMain']));

				if ($check[0] > 0)
					redir("cuentas.php", "main_div", "No puedes cambiar el sexo de esta cuenta por tener Bardos o Dancers en ella.<br>Click aqui para continuar.");

				if ($_GET['opt'] == 1 && isset($_GET['frm_name']) && !strcmp($_GET['frm_name'], "sex_m"))
					$mysql->query("UPDATE `login` SET `sex` = 'M' WHERE `account_id` = '" . $_SESSION[$CONFIG['Name'] . 'account_id'] . "'", $CONFIG['DBMain']);
				elseif ($_GET['opt'] == 2 && isset($_GET['frm_name']) && !strcmp($_GET['frm_name'], "sex_f"))
					$mysql->query("UPDATE `login` SET `sex` = 'F' WHERE `account_id` = '" . $_SESSION[$CONFIG['Name'] . 'account_id'] . "'", $CONFIG['DBMain']);
			}

			$accsex = $mysql->fetchrow($mysql->query("SELECT `sex` FROM `login` WHERE `account_id` = '" . $_SESSION[$CONFIG['Name'] . 'account_id'] . "'", $CONFIG['DBMain']));
			$sex = $accsex[0];

			opentable("Cambio de Sexo");

			echo "
				<table width=\"550\">
					<tr>
						<td align=\"right\">
							<b>Sexo Actual de Cuenta:</b>
						</td>
			";

			if (!strcmp($sex, "M"))
			{
				echo "
						<td align=\"left\">
							Masculino
						</td>
				";
			}

			if (!strcmp($sex, "F"))
			{
				echo "
						<td align=\"left\">
							Femenino
						</td>
				";
			}

			echo "
					</tr>
					<tr>
						<td align=\"center\">
							<b>Cambiar a...</b>
						</td>
						<td align=\"center\">
							<b>Cambiar a...</b>
						</td>
					</tr>
					<tr>
						<td align=\"center\">
							&nbsp;
						</td>
						<td align=\"center\">
							&nbsp;
						</td>
					</tr>
					<tr>
						<td align=\"center\">
							<img src=\"male.gif\">
						</td>
						<td align=\"center\">
							<img src=\"female.gif\">
						</td>
					</tr>
					<tr>
						<td align=\"center\">
							&nbsp;
						</td>
						<td align=\"center\">
							&nbsp;
						</td>
					</tr>
					<tr>
						<td align=\"center\">
							<form id=\"sex_m\" onsubmit=\"return GET_ajax('changesex.php','main_div','sex_m')\">
								<input type=\"hidden\" name=\"opt\" value=1>
								<input type=\"submit\" value=\"Masculino\">
							</form>
						</td>
						<td align=\"center\">
							<form id=\"sex_f\" onsubmit=\"return GET_ajax('changesex.php','main_div','sex_f')\">
								<input type=\"hidden\" name=\"opt\" value=2>
								<input type=\"submit\" value=\"Femenino\">
							</form>
						</td>
					</tr>
				</table>
			";

			closetable();
		}
		else
		{
			redir("cuentas.php", "main_div", "Debes seleccionar una cuenta primero.<br>Click aqui para seleccionar una ahora.");
		}
	}
?>