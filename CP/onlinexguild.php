<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if( isset($_SESSION[$CONFIG['Name'] . 'emblems']) )
		$emblems = $_SESSION[$CONFIG['Name'] . 'emblems'];

	$jobs = $_SESSION[$CONFIG_Name.'jobs'];

	$who = $mysql->query("
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`last_map`, `login`.`level`, `login`.`sex`, LOWER(`members`.`pais`) AS `lpais`, `guild`.`name` AS `gname`, `char`.`zeny`, `guild`.`guild_id`, `guild`.`emblem_data`, `guild`.`connect_member`, `guild`.`max_member`
		FROM
			`char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `members` ON `members`.`member_id` = `login`.`member_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char`.`online` <> '0' AND `login`.`level` = '0'
		ORDER BY
			`guild`.`guild_id` DESC
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
		$lastguild = 0;

		while ($char = $mysql->fetcharray($who) )
		{
			if( $lastguild != $char['guild_id'])
			{
				$lastguild = $char['guild_id'];
				$emblems[$lastguild] = $char['emblem_data'];

				echo '
					<tr bgcolor="#0A4D79">
						<td align="center" height="28">
							&nbsp;' . ($lastguild > 0 ? '<img src="emblema.php?data=' . $lastguild . '" alt="X">' : '' ) . '&nbsp;
						</td>
						<td align="left" colspan="4" height="28">
							&nbsp;<font color="#8BC53F" size="2"><b>' . ($lastguild > 0 ? htmlformat($char['gname']) : '--- Sin Guild ---' ) . '</b></font>&nbsp;
						</td>
						<td align="center" height="28">
							&nbsp;<font color="#8BC53F" size="2"><b>[ ' . $char['connect_member'] . ' | ' . $char['max_member'] . ' ]</b></font>&nbsp;
						</td>
					</tr>
				';
				
			}
			
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
						<font color="#FFA500"><b>' . htmlformat($char['name']) . '</b></font>
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
				<td align="center" class="head" colspan="6">Jugadores en Autotrade (Estimado) : <b>' . $autot . '</b></td>
			</tr>
			<tr>
				<td align="center" class="head" colspan="6">Jugadores Activos : <b>' . $total . '</b></td>
			</tr>
		</table>
	';

	if( isset($emblems) )
		$_SESSION[$CONFIG['Name'] . 'emblems'] = $emblems;

	closetable();
?>
