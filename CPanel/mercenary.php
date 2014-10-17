<?php
	session_start();
	include_once 'config2.php';
	include_once 'functions2.php';
	$jobs = $_SESSION[$CONFIG_Name.'jobs'];
	
	opentable("Ranking de Mercenarios - Swordman Guild");
?>
	<table width="550">
		<tr><td colspan="8"><hr></td></tr>
		<tr>
			<td class="head" align="left">#</td>
			<td>&nbsp;</td>
			<td class="head" align="left" colspan="2">Personaje</td>
			<td class="head" align="center">Clase</td>
			<td class="head" align="center">Nivel</td>
			<td class="head" align="center">Loyalty</td>
			<td class="head" align="center">Mapa</td>
		</tr>
<?php
	
	$result = $mysql->query("
		SELECT
			`mercenary_owner`.`sword_faith`, `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`last_map`, `login`.`level`, `login`.`sex`, `guild`.`name` AS `gname`, `char`.`online`, `guild`.`guild_id`
		FROM
			`mercenary_owner` LEFT JOIN `char` ON `char`.`char_id` = `mercenary_owner`.`char_id` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`login`.`level` = '0' AND `login`.`state` = '0' AND `mercenary_owner`.`sword_faith` > '0'
		ORDER BY
			`mercenary_owner`.`sword_faith` DESC
		LIMIT 0, 10
	", $CONFIG['DBMain']);
	
	$pos = 0;

	if( $result )
	{
		while( $data = $mysql->fetcharray($result) )
		{
			$pos++;
			echo '
				<tr>
					<td align="left">' . $pos . '</td>
					<td>&nbsp;</td>
					<td align="center" width=30><img src="' . $data['sex'] . '.gif"></td>
					<td align="left">
						' . htmlformat($data['name']) . '
			';

			if( $data['gname'] != '' )
				echo '<br>
					<span title="Ver Profile de Guild" style="color:#0000FF; cursor:pointer" onMouseOver="this.style.color=#0000FF" onMouseOut="this.style.color=#0000FF" onClick="return LINK_ajax(\'guildprofile.php?guild_id=' . $data['guild_id'] . '\',\'main_div\');">
						<font color="#3dafff"><b>[' . htmlformat($data['gname']) . ']</b></font>
					</span>
				';
			
			echo '
					</td>
					<td align="center"><img src="./imgwm/' . $data['class'] . '.gif"><br>' . $jobs[$data['class']] . '</td>
					<td align="center">' . $data['base_level'] . '/' . $data['job_level'] . '</td>
					<td align="center">' . $data['sword_faith'] .'</td>
					<td align="center">
						' . $data['last_map'] . '<br>
						' . ($data['online']?'<img src="on-oval.png" alt="Online">':'<img src="off-oval.png" alt="Online">') . '
					</td>
				</tr>
			';			
		}
	}
?>
		<tr><td colspan="8"><hr></td></tr>
	</table>
<?php
	closetable();
	opentable("Ranking de Mercenarios - Spearman Guild");
?>
	<table width="550">
		<tr><td colspan="8"><hr></td></tr>
		<tr>
			<td class="head" align="left">#</td>
			<td>&nbsp;</td>
			<td class="head" align="left" colspan="2">Personaje</td>
			<td class="head" align="center">Clase</td>
			<td class="head" align="center">Nivel</td>
			<td class="head" align="center">Loyalty</td>
			<td class="head" align="center">Mapa</td>
		</tr>
<?php
	
	$result = $mysql->query("
		SELECT
			`mercenary_owner`.`spear_faith`, `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`last_map`, `login`.`level`, `login`.`sex`, `guild`.`name` AS `gname`, `char`.`online`, `guild`.`guild_id`
		FROM
			`mercenary_owner` LEFT JOIN `char` ON `char`.`char_id` = `mercenary_owner`.`char_id` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`login`.`level` = '0' AND `login`.`state` = '0' AND `mercenary_owner`.`spear_faith` > '0'
		ORDER BY
			`mercenary_owner`.`spear_faith` DESC
		LIMIT 0, 10
	", $CONFIG['DBMain']);
	
	$pos = 0;

	if( $result )
	{
		while( $data = $mysql->fetcharray($result) )
		{
			$pos++;
			echo '
				<tr>
					<td align="left">' . $pos . '</td>
					<td>&nbsp;</td>
					<td align="center" width=30><img src="' . $data['sex'] . '.gif"></td>
					<td align="left">
						' . htmlformat($data['name']) . '
			';

			if( $data['gname'] != '' )
				echo '<br>
					<span title="Ver Profile de Guild" style="color:#0000FF; cursor:pointer" onMouseOver="this.style.color=#0000FF" onMouseOut="this.style.color=#0000FF" onClick="return LINK_ajax(\'guildprofile.php?guild_id=' . $data['guild_id'] . '\',\'main_div\');">
						<font color="#3dafff"><b>[' . htmlformat($data['gname']) . ']</b></font>
					</span>
				';
			
			echo '
					</td>
					<td align="center"><img src="./imgwm/' . $data['class'] . '.gif"><br>' . $jobs[$data['class']] . '</td>
					<td align="center">' . $data['base_level'] . '/' . $data['job_level'] . '</td>
					<td align="center">' . $data['spear_faith'] .'</td>
					<td align="center">
						' . $data['last_map'] . '<br>
						' . ($data['online']?'<img src="on-oval.png" alt="Online">':'<img src="off-oval.png" alt="Online">') . '
					</td>
				</tr>
			';			
		}
	}
?>
		<tr><td colspan="8"><hr></td></tr>
	</table>
<?php
	closetable();
	opentable("Ranking de Mercenarios - Archer Guild");
?>
	<table width="550">
		<tr><td colspan="8"><hr></td></tr>
		<tr>
			<td class="head" align="left">#</td>
			<td>&nbsp;</td>
			<td class="head" align="left" colspan="2">Personaje</td>
			<td class="head" align="center">Clase</td>
			<td class="head" align="center">Nivel</td>
			<td class="head" align="center">Loyalty</td>
			<td class="head" align="center">Mapa</td>
		</tr>
<?php
	
	$result = $mysql->query("
		SELECT
			`mercenary_owner`.`arch_faith`, `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`last_map`, `login`.`level`, `login`.`sex`, `guild`.`name` AS `gname`, `char`.`online`, `guild`.`guild_id`
		FROM
			`mercenary_owner` LEFT JOIN `char` ON `char`.`char_id` = `mercenary_owner`.`char_id` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`login`.`level` = '0' AND `login`.`state` = '0' AND `mercenary_owner`.`arch_faith` > '0'
		ORDER BY
			`mercenary_owner`.`arch_faith` DESC
		LIMIT 0, 10
	", $CONFIG['DBMain']);
	
	$pos = 0;

	if( $result )
	{
		while( $data = $mysql->fetcharray($result) )
		{
			$pos++;
			echo '
				<tr>
					<td align="left">' . $pos . '</td>
					<td>&nbsp;</td>
					<td align="center" width=30><img src="' . $data['sex'] . '.gif"></td>
					<td align="left">
						' . htmlformat($data['name']) . '
			';

			if( $data['gname'] != '' )
				echo '<br>
					<span title="Ver Profile de Guild" style="color:#0000FF; cursor:pointer" onMouseOver="this.style.color=#0000FF" onMouseOut="this.style.color=#0000FF" onClick="return LINK_ajax(\'guildprofile.php?guild_id=' . $data['guild_id'] . '\',\'main_div\');">
						<font color="#3dafff"><b>[' . htmlformat($data['gname']) . ']</b></font>
					</span>
				';
			
			echo '
					</td>
					<td align="center"><img src="./imgwm/' . $data['class'] . '.gif"><br>' . $jobs[$data['class']] . '</td>
					<td align="center">' . $data['base_level'] . '/' . $data['job_level'] . '</td>
					<td align="center">' . $data['arch_faith'] .'</td>
					<td align="center">
						' . $data['last_map'] . '<br>
						' . ($data['online']?'<img src="on-oval.png" alt="Online">':'<img src="off-oval.png" alt="Online">') . '
					</td>
				</tr>
			';			
		}
	}
?>
		<tr><td colspan="8"><hr></td></tr>
	</table>
<?php
	closetable();