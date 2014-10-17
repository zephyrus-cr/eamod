<?php
	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca.");

	if (!isset($_SESSION[$CONFIG['Name'] . 'account_id']) || $_SESSION[$CONFIG['Name'] . 'account_id'] <= 0)
		redir("cuentas.php", "main_div", "Primero selecciona una cuenta de juego para proceder.<br>Click aqui para seleccionar otra cuenta.");

	opentable("Tiempo de Juego");

	$account_id = $_SESSION[$CONFIG['Name'] . 'account_id'];
	$result = $mysql->query("
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`last_map`, `login`.`level`, `login`.`sex`, `guild`.`name` AS `gname`, `char`.`playtime`, `guild`.`guild_id`
		FROM
			`char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char`.`account_id` = '$account_id'
		ORDER BY
			`char`.`char_num`
	", $CONFIG['DBMain']);
?>
	<table width="550">
		<tr>
			<td align="left" class="head" colspan="2">Nombre de Personaje</td>
			<td align="center" class="head">Clase</td>
			<td align="center" class="head">Base / Job Level</td>
			<td align="right" class="head">Play Time</td>
		</tr>
<?php
	$total = 0;

	while ($char = $mysql->fetcharray($result))
	{
		echo '
			<tr>
				<td align="center" width=30><img src="' . $char['sex'] . '.gif"></td>
				<td align="left">
					' . htmlformat($char['name']) . '
		';

		if( $char['gname'] != '' )
			echo '<br>
				<span title="Ver Profile de Guild" style="color:#0000FF; cursor:pointer" onMouseOver="this.style.color=#0000FF" onMouseOut="this.style.color=#0000FF" onClick="return LINK_ajax(\'guildprofile.php?guild_id=' . $char['guild_id'] . '\',\'main_div\');">
					<font color="Navy"><b>[' . htmlformat($char['gname']) . ']</b></font>
				</span>
			';

		echo '
				</td>
				<td align="center"><img src="./imgwm/' . $char['class'] . '.gif"><br>' . $jobs[$char['class']] . '</td>
				<td align="center">' . $char['base_level'] . '/' . $char['job_level'] . '</td>
				<td align="right">' . playtime($char['playtime']) . '</td>
			</tr>
		';

		$total += $char['playtime'];
	}

	echo '
			<tr>
				<td align="center" class="head" colspan="5">Tiempo total de Juego : <b>' . playtime($total) . '</b></td>
			</tr>
		</table>
	';

	closetable();
?>