<?php

	session_start();
	include_once 'config2.php';
	include_once 'functions2.php';

	$jobs = $_SESSION[$CONFIG_Name.'jobs'];

	$who = $mysql->query("
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`last_map`, `login`.`level`, `login`.`sex`, LOWER(`members`.`pais`) AS `lpais`, `guild`.`name` AS `gname`, `char`.`zeny`, `guild`.`guild_id`
		FROM
			`char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `members` ON `members`.`member_id` = `login`.`member_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char`.`online` <> '0' AND `login`.`level` = '0'
		ORDER BY
			`char`.`last_map`
	" , $CONFIG['DBMain']);

	opentable('Jugadores Actualmente en el Servidor');
?>
	<table width="550">
		<tr>
			<td align="center" class="head">Pais</td>
			<td align="left" class="head" colspan="2">Nombre</td>
			<td align="center" class="head">Clase</td>
			<td align="center" class="head">Base / Job Level</td>
			<td align="right" class="head">Mapa Actual</td>
		</tr>
<?php

	if ($who)
	{
		$autot = 0;
		$total = 0;

		while ($char = $mysql->fetcharray($who))
		{
			echo '
				<tr>
					<td align="center">
						' . (file_exists("./images/flags/" . $char['lpais'] . ".png") ? '<img src="./images/flags/' . $char['lpais'] . '.png">':'') . '
					</td>
			';
			
			if( in_array($char['class'], array( 5,10,18,23,4006,4011,4019,4028,4033,4041 )) && $char['last_map'] == 'gmhouse_in' )
			{
				$autot++;
				$char['name'] = '[AT] ' . $char['name'];
				echo '
					<td align="center" width=30><img src="' . $char['sex'] . '.gif"></td>
					<td align="left">
						<font color="Blue"><b>' . htmlformat($char['name']) . '</b></font>
				';
			}
			else
			{
				$total++;
				echo '
					<td align="center" width=30><img src="' . $char['sex'] . '.gif"></td>
					<td align="left">
						' . htmlformat($char['name']) . '
				';
			}

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
					<td align="right">' . $char['last_map'] . '</td>
				</tr>
			';
		}
	}

	echo '
			<tr>
		
			</tr>
			<tr>
				<td align="center" class="head" colspan="6">Jugadores Activos : <b>' . $total . '</b></td>
			</tr>
		</table>
	';

	closetable();
?>
