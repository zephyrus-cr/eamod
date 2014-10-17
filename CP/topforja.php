<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	echo '
		<div class="ladder_class">
	';

	opentable('Ranking Forge WhiteSmith - BlackSmith');

	echo '
			<div id="ladder_div" style="color:#000000">
	';

	$query = "
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`, `char`.`account_id`, `char`.`last_map`, `char`.`fame`,
			`guild`.`name` AS `gname`, `login`.`sex`, `guild`.`guild_id`
		FROM
			`char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`login`.`level` < '1' AND `login`.`state` = '0' AND (`char`.`class` = '10' OR `char`.`class` = '4011') AND `char`.`fame` > 0
		ORDER BY
			`char`.`fame` DESC,
			`char`.`base_level` DESC,
			`char`.`base_exp` DESC,
			`char`.`job_level` DESC,
			`char`.`job_exp` DESC
		LIMIT 0, 30
	";

	$result = $mysql->query($query, $CONFIG['DBMain']);

?>
	<table width="550">
		<tr>
			<td align="left" class="head">#</td>
			<td>&nbsp;</td>
			<td align="right" class="head">Puntaje</td>
			<td>&nbsp;</td>
			<td align="left" class="head" colspan="2">Nombre de Personaje</td>
			<td align="center" class="head">Base / Job Level</td>
			<td align="center" class="head">Ultima Posicion</td>
		</tr>
<?php
	$count = 0;
	while ($char = $mysql->fetcharray($result))
	{
		$count++;

		echo '
			<tr>
				<td align="left">' . $count . '</td>
				<td>&nbsp;</td>
				<td align="right">' . $char['fame'] . '</td>
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
				<td align="center">' . $char['base_level'] . '/' . $char['job_level'] . '</td>
				<td align="center">
					' . $char['last_map'] . '<br>
					' . ($char['online']?'<img src="on-oval.png" alt="Online">':'<img src="off-oval.png" alt="Online">') . '
				</td>
			</tr>
		';
	}

	echo "
				</table>
			</div>
		</div>
	";

	closetable();
?>