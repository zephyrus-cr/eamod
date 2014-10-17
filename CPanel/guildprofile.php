<?php

	session_start();
	include_once 'config2.php';
	include_once 'functions2.php';

	if( !isset($_GET['guild_id']))
		redir("guild.php","main_div","Seleccione una guild para ver el Profile.<br>Click aqui para seleccionar una de la lista.");

	$guild_id = $_GET['guild_id'];

	if( !is_numeric($guild_id))
		redir("guild.php","main_div","Valor inadecuado de Guild.<br>Click aqui para seleccionar una de la lista.");

	if( isset($_SESSION[$CONFIG['Name'] . 'emblems']) )
		$emblems = $_SESSION[$CONFIG['Name'] . 'emblems'];

	if( !($guild = $mysql->fetcharray($mysql->query("
		SELECT
			`guild`.`name`, `guild`.`master`, `guild`.`guild_lv`, `guild`.`max_member`, `guild`.`average_lv`, `guild`.`exp`, `guild`.`next_exp`, `guild`.`emblem_data`,
			`char`.`class`, `char`.`base_level`, `char`.`job_level`
		FROM
			`guild` JOIN `char` ON `guild`.`char_id` = `char`.`char_id`
		WHERE
			`guild`.`guild_id` = '$guild_id'
	",$CONFIG['DBMain']))) )
		redir("guild.php","main_div","La Guild que trata de consultar no existe.<br>Click aqui para seleccionar una de la lista.");

	// Members Information
	$all_members = $mysql->query("
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`, `login`.`sex`, DATEDIFF(NOW(),`login`.`lastlogin`) AS `last_online`, LOWER(`members`.`pais`) AS `lpais`
		FROM
			`char` JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `members` ON `members`.`member_id` = `login`.`member_id`
		WHERE
			`char`.`guild_id` = '$guild_id'
		ORDER BY
			`char`.`class`
	", $CONFIG['DBMain']);
?>
			<center>
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tbody>
						<tr>
							<th height="28" class="title"><font color="blue" size="3"><b><?php echo htmlformat($guild['name']); ?></b></font></th>
						</tr>
						<tr>
							<td align="center">
<?php
	$emblems[$guild_id] = $guild['emblem_data'];
	$jobs = $_SESSION[$CONFIG_Name.'jobs'];

	echo '
		<table width="550">
			<tr><td align="center"><img src="emblema.php?data=' . $guild_id . '" alt="' . $guild['name'] . '"></td></tr>
			<tr><td align="center"><b>' . htmlformat($guild['master']) . '</b> <font color="red"><b>' . $jobs[$guild['class']] . '</b></font> ' . $guild['base_level'] . '/' . $guild['job_level'] . '</td></tr>
		</table>
		<table width="550">
			<tr><td align="center" colspan="5" bgcolor="919191" height="30"><font size="2"><b>Estadisticas Generales</b></font></td></tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td align="left"><b>Nivel de Guild :</b> ' . $guild['guild_lv'] . '</td>
				<td align="center">&nbsp;</td>
				<td align="right"><b>Miembros Actuales :</b> ' . $mysql->countrows($all_members) . '</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td align="left"><b>Experiencia :</b> ' . moneyformat($guild['exp']) . '</td>
				<td align="center">&nbsp;</td>
				<td align="right"><b>Cupos Totales :</b> ' . $guild['max_member'] . '</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td align="left"><b>Siguiente Lvl :</b> ' . moneyformat($guild['next_exp']) . '</td>
				<td align="center">&nbsp;</td>
				<td align="right"><b>Nivel Promedio :</b> ' . $guild['average_lv'] . '</td>
				<td align="center">&nbsp;</td>
			</tr>
		</table>
	';


	// Diplomacia
	$diplomacy = $mysql->query("
		SELECT
			`guild`.`guild_id`, `guild`.`name`, `guild`.`emblem_data`, `guild_alliance`.`opposition`
		FROM
			`guild_alliance` JOIN `guild` ON `guild`.`guild_id` = `guild_alliance`.`alliance_id`
		WHERE
			`guild_alliance`.`guild_id` = '$guild_id'
		ORDER BY
			`guild_alliance`.`opposition`
	", $CONFIG['DBMain']);

	$count = $mysql->countrows($diplomacy);

	if( $count )
	{
		echo '
			<table width="550">
				<tr><td align="center" colspan="2" bgcolor="#919191" height="30"><font size="2"><b>Diplomacia</b></font></td></tr>
				<tr>
					<td align="center" width="50%"><font color="blue"><b>Alianzas</b></font></td>
					<td align="center" width="50%"><font color="red"><b>Enemigos</b></font></td>
				</tr>
				<tr><td align="center" colspan="2">&nbsp;</td></tr>
		';

		$ally = '';
		$enemy = '';

		while( ($data = $mysql->fetcharray($diplomacy)) )
		{
			$emblems[$data['guild_id']] = $data['emblem_data'];

			if( $data['opposition'] == 0 )
			{
				$ally .= '<img src="emblema.php?data=' . $data['guild_id'] . '"><br><span title="Ver Profile de Guild" style="color:#000000; cursor:pointer" onMouseOver="this.style.color=#0000FF" onMouseOut="this.style.color=#000000" onClick="return LINK_ajax(\'guildprofile.php?guild_id=' . $data['guild_id'] . '\',\'main_div\');">' . htmlformat($data['name']) . '</span><br><br>';
			}
			else
			{
				$enemy .= '<img src="emblema.php?data=' . $data['guild_id'] . '"><br><span title="Ver Profile de Guild" style="color:#000000; cursor:pointer" onMouseOver="this.style.color=#0000FF" onMouseOut="this.style.color=#000000" onClick="return LINK_ajax(\'guildprofile.php?guild_id=' . $data['guild_id'] . '\',\'main_div\');">' . htmlformat($data['name']) . '</span><br><br>';
			}
		}

		echo '
				<tr>
					<td align="center">' . $ally . '</td>
					<td align="center">' . $enemy . '</td>
				</tr>
			</table>
		';
	}

	// Territorios
	$territory = $mysql->query("
		SELECT
			`castle_id`, `economy`, `defense`
		FROM
			`guild_castle`
		WHERE
			`guild_id` = '$guild_id'
	", $CONFIG['DBMain']);

	$count = $mysql->countrows($territory);

	if( $count )
	{
		$castles = $_SESSION[$CONFIG['Name'] . 'castles'];

		echo '
			<table width="550">
				<tr><td align="center" colspan="' . $count . '" bgcolor="#919191" height="30"><font size="2"><b>Territorios</b></font></td></tr>
				<tr>
		';

		while( ($data = $mysql->fetcharray($territory)) )
			echo '<td align="center">' . $castles[$data['castle_id']] . '<br><b>Defense</b> ' . $data['defense'] . '<br><b>Economy</b> ' . $data['economy'] . '</td>';

		echo '
				</tr>
			</table>
		';
	}

	// Miembros
	echo '
		<table width="550">
			<tr><td align="center" bgcolor="#919191" height="30" colspan="5"><font size="2"><b>Miembros</b></font></td></tr>
			<tr>
				<td align="left" class="head" colspan="2">Nombres</td>
				<td align="center" class="head">Pais</td>
				<td align="center" class="head">Base / Job Level</td>
				<td align="right" class="head">Estado</td>
			</tr>
	';

	$count = 0;
	$online = 0;

	while( $char = $mysql->fetcharray($all_members) )
	{
		$count++;

		echo '
			<tr>
				<td align="center" width=30><img src="' . $char['sex'] . '.gif"></td>
				<td align="left">' . htmlformat($char['name']) . '<br><font color="3dafff"><b>[' . $jobs[$char['class']] . ']</b></font></td>
				<td align="center">
					' . (file_exists("./images/flags/" . $char['lpais'] . ".png") ? '<img src="./images/flags/' . $char['lpais'] . '.png">':'') . '
				</td>
				<td align="center">' . $char['base_level'] . '/' . $char['job_level'] . '</td>
				<td align="right">
					' . ($char['online']?'<b><font color="orange">Online</font></b>':$char['last_online'] . ' dias inactivo') . '
				</td>
			</tr>
		';

		if( $char['online'] )
			$online++;
	}

	$asistencia = '' . round(($online / $count) * 100,2) . ' %';

	echo '
			<tr>
				<td align="center" colspan="5">
					Total de Miembros : <b>' . $count . '</b> | Miembros Activos : <b>' . $online . '</b><br><br>
					Porcentaje de Asistencia : <b>' . $asistencia . '</b><br>
				</td>
			</tr>
		</table>
	';

	if( isset($emblems) )
		$_SESSION[$CONFIG['Name'] . 'emblems'] = $emblems;

	closetable();
?>