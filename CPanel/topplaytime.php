<?php

	session_start();
	include_once 'config2.php';
	include_once 'functions2.php';

	$jobs = $_SESSION[$CONFIG_Name.'jobs'];

	$who = $mysql->query("
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`last_map`, `login`.`level`, `login`.`sex`, `guild`.`name` AS `gname`, `char`.`zeny`, `guild`.`guild_id`, `char`.`playtime`
		FROM
			`char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`login`.`level` = '0' AND `char`.`playtime` > 0
		ORDER BY
			`char`.`playtime` DESC
		LIMIT 25
	" , $CONFIG['DBMain']);

	opentable('Ranking de Tiempo de Juego');
?>
	<table width="550">
		<tr>
			<td align="left" class="head" colspan="2">Nombre de Personaje</td>
			<td align="center" class="head">Clase</td>
			<td align="center" class="head">Base / Job Level</td>
			<td align="right" class="head">Play Time</td>
		</tr>
<?php

	if ($who)
	{
		while ($char = $mysql->fetcharray($who))
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
						<font color="#3dafff"><b>[' . htmlformat($char['gname']) . ']</b></font>
					</span>
				';

			echo '
					</td>
					<td align="center"><img src="./imgwm/' . $char['class'] . '.gif"><br>' . $jobs[$char['class']] . '</td>
					<td align="center">' . $char['base_level'] . '/' . $char['job_level'] . '</td>
					<td align="right">' . playtime($char['playtime']) . '</td>
				</tr>
			';
		}
	}

	echo '
		</table>
	';

	closetable();
?>
