<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca.");

	if (!isset($_SESSION[$CONFIG['Name'] . 'account_id']) || $_SESSION[$CONFIG['Name'] . 'account_id'] <= 0)
		redir("cuentas.php", "main_div", "Primero selecciona una cuenta de juego para proceder.<br>Click aqui para seleccionar otra cuenta.");

	if (is_online())
		redir("cuentas.php", "main_div", "No puedes resetear posicion a una cuenta Activa en el Juego.<br>Click aqui para seleccionar otra cuenta.");

	if (isset($_POST['opt']) && $_POST['opt'] == 1 && isset($_POST['char_id']) && is_numeric($_POST['char_id']) && $_POST['char_id'] > 0)
	{ // Reset a un Personaje
		$result = $mysql->query("
			SELECT
				`char`.`last_map`, `login`.`unban_time`
			FROM
				`char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id`
			WHERE
				`char`.`char_id` = '" . $_POST['char_id'] . "' AND `char`.`account_id` = '" . $_SESSION[$CONFIG['Name'] . 'account_id'] . "'
		", $CONFIG['DBMain']);

		if (!($char = $mysql->fetcharray($result)))
			redir("position.php", "main_div", "El personaje no se encontro asociado a la Cuenta.<br>Click aqui para intentar otra vez.");

		if (!strcmp($char['last_map'], 'sec_pri'))
			redir("position.php", "main_div", "No puedes resetear la posicion de un personaje en Jail.<br>Click aqui para intentar otra vez.");

		if ($char['unban_time'] >= time())
			redir("position.php", "main_div", "Tu personaje está baneado por tiempo. Debes esperar a que este tiempo pase.");

		$mysql->query("
			UPDATE
				`char`
			SET
				`last_map` = `save_map`, `last_x` = `save_x`, `last_y` = `save_y`
			WHERE
				`char_id` = '" . $_POST['char_id'] . "'
		", $CONFIG['DBMain']);

		$unban_time = time() + (2 * 60); // 2 minutos de seguridad de Baneo de Cuenta
		$mysql->query("
			UPDATE
				`login`
			SET
				`unban_time` = '$unban_time'
			WHERE
				`account_id` = '" . $_SESSION[$CONFIG['Name'] . 'account_id'] . "'
		", $CONFIG['DBMain']);

		redir("position.php", "main_div", "La posicion del personaje ha sido reseteada.<br>Por seguridad, tu cuenta ha sido bloqueada 2 minutos.<br>Click aqui para regresar.");
	}
	else
	{ // Lista de Personajes
		opentable("Reset de Posicion para Personajes");
		$result = $mysql->query("
			SELECT
				`char_id`, `name`, `last_map`, `last_x`, `last_y`, `save_map`, `save_x`, `save_y`
			FROM
				`char`
			WHERE
				`account_id` = '" . $_SESSION[$CONFIG['Name'] . 'account_id'] . "'
		", $CONFIG['DBMain']);

		echo '
			<table width="550">
				<tr>
					<td align="center" colspan="7">
						El reset de posicion es una herramienta que permite enviar a un personaje de tu cuenta a la ultima posicion donde guardo con Kafra.<br>
						Este servicio es gratuito, por favor evite abusos.<br>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="7">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" class="head"><b>Personaje</b></td>
					<td align="center">&nbsp;</td>
					<td align="center" class="head">Posicion Actual</td>
					<td align="center">&nbsp;</td>
					<td align="center" class="head">Posicion Kafra</td>
					<td align="center">&nbsp;</td>
					<td align="right" class="head">Resetear</td>
				</tr>
		';

		$i = 0;
		while ($line = $mysql->fetcharray($result))
		{
			echo '
				<tr>
					<td align="left">' . $line['name'] . '</td>
					<td align="center">&nbsp;</td>
					<td align="center"><b>' . $line['last_map'] . '</b><br>(' . $line['last_x'] . ', ' . $line['last_y'] . ')</td>
					<td align="center">&nbsp;</td>
					<td align="center"><b>' . $line['save_map'] . '</b><br>(' . $line['save_x'] . ', ' . $line['save_y'] . ')</td>
					<td align="center">&nbsp;</td>
					<td align="right">
						<form id="position' . $i . '" onsubmit="return POST_ajax(\'position.php\',\'main_div\',\'position' . $i . '\')">
							<input type="submit" value="Resetear Pos">
							<input type="hidden" name="char_id" value="' . $line['char_id'] . '">
							<input type="hidden" name="opt" value="1">
						</form>
					</td>
				</tr>
			';

			$i++;
		}

		echo '</table>';
		closetable();
	}
?>