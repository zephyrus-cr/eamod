<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	$jobs = $_SESSION[$CONFIG_Name.'jobs'];

	$who = $mysql->query("
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`last_map`, `login`.`level`, `login`.`sex`, `guild`.`name` AS `gname`, `global_reg_value`.`value`, `char`.`online`, `guild`.`guild_id`
		FROM
			`global_reg_value` LEFT JOIN `char` ON `char`.`char_id` = `global_reg_value`.`char_id` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`global_reg_value`.`str` = 'MVPRank' AND `global_reg_value`.`value` > '0' AND `login`.`level` = '0' AND `login`.`state` = '0'
		ORDER BY
			`global_reg_value`.`value` + 0 DESC
		LIMIT 0, 30
	", $CONFIG['DBMain']);

	opentable("Ranking de Eliminacion de MVPs");

?>
	<table width="600">
		<tr>
			<td align="left" class="head">#</td>
			<td>&nbsp;</td>
			<td align="left" class="head" colspan="2">Nombre de Personaje</td>
			<td align="center" class="head">Clase</td>
			<td align="center" class="head">Level</td>
			<td align="center" class="head" width="100">MVP</td>
			<td align="center" class="head">Mapa</td>
		</tr>
<?php
	if ($who)
	{
		$total = 0;
		$mvps = 0;

		while ($char = $mysql->fetcharray($who))
		{
			$total++;
			$mvps += $char['value'];

			echo '
				<tr>
					<td align="left">' . $total . '</td>
					<td>&nbsp;</td>
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
					<td align="center"><img src="./images/item/small/750.png"> x ' . $char['value'] .'</td>
					<td align="center">
						' . $char['last_map'] . '<br>
						' . ($char['online']?'<img src="on-oval.png" alt="Online">':'<img src="off-oval.png" alt="Online">') . '
					</td>
				</tr>
			';
		}
	}

	echo '
			<tr>
				<td align="center" colspan="8">Total en Lista : <b>' . $total . '</b> MVPs Eliminados : <b>' . $mvps . '</b></td>
			</tr>
		</table>
	';

	closetable();
?>