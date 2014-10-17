<?php
	session_start();

	include_once 'config.php';
	include_once 'functions.php';

	$result = $mysql->query("
		SELECT
			`char`.`name` AS CName, `homunculus`.`name`, `homunculus`.`level`, `homunculus`.`class`
		FROM
			`homunculus` LEFT JOIN `char` ON `char`.`char_id` = `homunculus`.`char_id`
		ORDER BY
			`homunculus`.`level` DESC, `homunculus`.`exp` DESC
		LIMIT 20
	", $CONFIG['DBMain']);

	opentable("Ranking Homunculus");
	
	echo ('
		<table width=\"550\">
			<tr>
				<td align=\"left\" class=\"head\">Puesto</td>
				<td>&nbsp;</td>
				<td align=\"left\" class=\"head\">' . htmlformat("Dueño") . '</td>
				<td align=\"left\" class=\"head\">Nombre</td>
				<td align=\"center\" class=\"head\">Clase</td>
				<td align=\"right\" class=\"head\">Level</td>
			</tr>
	');
	
	$nhomun = 0;
	
	if ($result)
	{
		while ($line = $mysql->fetchrow($result))
		{
			$nhomun++;
			
			if ($nhomun > 100)
				break;

			$cnombre = htmlformat($line[0]);
			$hnombre = '<b>' . htmlformat($line[1]) . '</b>';
			
			echo ('    
				<tr>
					<td align="left">' . $nhomun . '</td>
					<td>&nbsp;</td>
					<td align="left">' . $cnombre . '</td>
					<td align=\"left\">' . $hnombre . '</td>
					<td align=\"left\">
			');
			
			if (file_exists('./images/mob/' . $line[3] . '.gif')) {
				echo ('
					<img src="./images/mob/' . $line[3] . '.gif" alt="ID: ' . $line[3] . '">
				');
			} else {
				echo ('
					Imagen Pediente
				');
			}
			
			echo ('
					</td>
						<td align="right">' . $line[2] . '</td>
					</tr>
			');
		}
	}
	
	echo ('</table>');
	closetable();
?>
