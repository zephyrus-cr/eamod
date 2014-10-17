<?php

	session_start();
	include_once 'config2.php';
	include_once 'functions2.php';

	$jobs = $_SESSION[$CONFIG['Name'] . 'jobs'];

	$result = $mysql->query("
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`last_map`, `login`.`level`, `login`.`sex`, `guild`.`name` AS `gname`, `char`.`zeny`, `guild`.`guild_id`
		FROM
			`char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`login`.`level` < '1' AND `login`.`state` = '0' AND `char`.`zeny` > 100000
		ORDER BY
			`zeny` DESC
		LIMIT 0, 25
	", $CONFIG['DBMain']);

	opentable('Ranking de Zeny');

	echo '
		<table width="550">
		<tr>
			<td align="left" class="head">#</td>
			<td>&nbsp;</td>
			<td align="left" class="head" colspan="2">Nombre de Personaje</td>
			<td align="center" class="head">Clase</td>
			<td align="center" class="head">Base / Job Level</td>
			<td align="right" class="head">Zeny</td>
		</tr>
	';

	$nusers = 0;

	if ($result)
	{
		while ($char = $mysql->fetcharray($result))
		{
			$nusers++;
			echo '
				<tr>
					<td align="left">' . $nusers . '</td>
					<td>&nbsp;</td>
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
					<td align="right">' . moneyformat($char['zeny']) . '</td>
				</tr>
			';
		}
	}

	echo "</table>";
	closetable();
?>
