<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	$jobs = $_SESSION[$CONFIG_Name.'jobs'];

	$who = $mysql->query("
		SELECT
			`F`.`name` AS `padre`, `F`.`class` AS `fclass`, `F`.`base_level` AS `flevel`, `F`.`job_level` AS `fjob`,
			`M`.`name` AS `madre`, `M`.`class` AS `mclass`, `M`.`base_level` AS `mlevel`, `M`.`job_level` AS `mjob`,
			`S`.`name` AS `hijo`,  `S`.`class` AS `sclass`, `S`.`base_level` AS `slevel`, `S`.`job_level` AS `sjob`
		FROM
			`char` `S` JOIN `char` `F` ON `F`.`char_id` = `S`.`father` JOIN `char` `M` ON `M`.`char_id` = `S`.`mother`
	" , $CONFIG['DBMain']);
	
	opentable('Arbol de Familias');
	echo '<table width="550">';

	if ($who)	
	{
		$total = 0;
		
		while ($char = $mysql->fetcharray($who))
		{
			$total++;
			
			echo '
				<tr>
					<td align="center">
						<img src="M.gif">&nbsp;<img src="./imgwm/' . $char['fclass'] . '.gif"><br>
						' . htmlformat($char['padre']) . '<br>
						<b>' . $jobs[$char['fclass']] . '</b></br>
						' . $char['flevel'] . '/' . $char['fjob'] . '</br>
					</td>
					<td align="center">
						<img src="./imgwm/' . $char['sclass'] . '.gif"><br>
						' . htmlformat($char['hijo']) . '<br>
						<b>' . $jobs[$char['sclass']] . '</b></br>
						' . $char['slevel'] . '/' . $char['sjob'] . '</br>
					</td>
					<td align="center">
						<img src="./imgwm/' . $char['mclass'] . '.gif">&nbsp;<img src="F.gif"><br>
						' . htmlformat($char['madre']) . '<br>
						<b>' . $jobs[$char['mclass']] . '</b></br>
						' . $char['mlevel'] . '/' . $char['mjob'] . '</br>
					</td>
				</tr>
				<tr>
					<td align="center" colspan=3><img src="barra.png"></td>
				</tr>
			';
		}
	}
	
	echo '
			<tr>
				<td align="center" colspan=3>Familias Completas : <b>' . $total . '</b></td>
			</tr>
		</table>
	';
	
	closetable();
?>
