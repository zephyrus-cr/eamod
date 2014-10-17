<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	$jobs = $_SESSION[$CONFIG['Name'] . 'jobs'];
	$Rank = array(
		"Civilian",
		"Private",
		"Corporal",
		"Sergeant",
		"Master<br>Sergeant",
		"Sergeant<br>Major",
		"Knight",
		"Knight<br>Lieutenant",
		"Knight<br>Captain",
		"Knight<br>Champion",
		"Lieutenant<br>Commander",
		"Commander",
		"Marshal",
		"Field Marshal",
		"Grand Marshal",
	);
	
	function calc_rank($score)
	{
		$result = intval($score / 1000);
		if( $result > 14 )
			$result = 14;
		
		return $result;
	}

	if (!isset($_GET['opt']))
	{
		echo '
			<div class="ladder_class">
		';

		opentable('Ranking Player Killer');

		echo '
			<table width="600">
				<tr>
					<td align="center">
						<form id="ladder">
							<select name="opt" onChange="javascript:GET_ajax(\'toppk.php\', \'ladder_div\', \'ladder\');">
								<option selected value="0">Todos...</option>
		';

		for ($i = 1; $i < 26; $i++)
		{ // Normal Class
			if ($i != 13 && $i != 21 && $i != 22 && $i != 26)
				echo "<option value=\"$i\">$jobs[$i]</option>";
		}

		for ($i = 4001; $i < 4050; $i++)
		{
			if ($i != 4014 && $i != 4022 && $i != 4036 && $i != 4044 && $i != 4048)
				echo "<option value=\"$i\">$jobs[$i]</option>";
		}

		echo '
							</select>
						</form>
					</td>
				</tr>
			</table>
			<div id="ladder_div" style="color:#000000">
		';

		$begin = 1;
		$_GET['opt'] = 0;

	}

	DEFINE('PK_LADDER_ALL', "
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`, `char`.`account_id`, `char`.`last_map`, `char_pk`.`score`, `char_pk`.`kill_count`, `char_pk`.`death_count`,
			`guild`.`name` AS `gname`, `login`.`sex`, `guild`.`guild_id`
		FROM
			`char_pk` LEFT JOIN `char` ON `char`.`char_id` = `char_pk`.`char_id` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`login`.`level` < '1' AND `login`.`state` = '0' AND `char_pk`.`score` > 0
		ORDER BY
			`char_pk`.`score` DESC,
			`char`.`base_level` DESC,
			`char`.`base_exp` DESC,
			`char`.`job_level` DESC,
			`char`.`job_exp` DESC
		LIMIT 0, 30
	");

	DEFINE('PK_LADDER_JOB', "
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`, `char`.`account_id`, `char`.`last_map`, `char_pk`.`score`, `char_pk`.`kill_count`, `char_pk`.`death_count`,
			`guild`.`name` AS `gname`, `login`.`sex`, `guild`.`guild_id`
		FROM
			`char_pk` LEFT JOIN `char` ON `char`.`char_id` = `char_pk`.`char_id` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`login`.`level` < '1' AND `login`.`state` = '0' AND `char`.`class` = '%d' AND `char_pk`.`score` > 0
		ORDER BY
			`char_pk`.`score` DESC,
			`char`.`base_level` DESC,
			`char`.`base_exp` DESC,
			`char`.`job_level` DESC,
			`char`.`job_exp` DESC
		LIMIT 0, 30
	");

	DEFINE('PK_LADDER_LKPA', "
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`, `char`.`account_id`, `char`.`last_map`, `char_pk`.`score`, `char_pk`.`kill_count`, `char_pk`.`death_count`,
			`guild`.`name` AS `gname`, `login`.`sex`, `guild`.`guild_id`
		FROM
			`char_pk` LEFT JOIN `char` ON `char`.`char_id` = `char_pk`.`char_id` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`login`.`level` < '1' AND `login`.`state` = '0' AND (`char`.`class` = '%d' OR `char`.`class` = '%d') AND `char_pk`.`score` > 0
		ORDER BY
			`char_pk`.`score` DESC,
			`char`.`base_level` DESC,
			`char`.`base_exp` DESC,
			`char`.`job_level` DESC,
			`char`.`job_exp` DESC
		LIMIT 0, 30
	");

	if (notnumber($_GET['opt']))
		alert("Simbolo Incorrecto.");

	$query = sprintf(PK_LADDER_ALL);
	$string = "Todos";

	if ($_GET['opt'] > 0)
	{
		switch ($_GET['opt'])
		{
			case 7:		$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 13); break;
			case 14:	$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 21); break;
			case 4008:	$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4014); break;
			case 4015:	$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4022); break;
			case 4030:	$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4036); break;
			case 4037:	$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4044); break;
			case 4047:	$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4048); break;
			default:	$query = sprintf(PK_LADDER_JOB, $_GET['opt']); break;
		}

		if (isset($jobs[$_GET['opt']]))
			$string = $jobs[$_GET['opt']];
		else
			$string = "Desconocido";
	}

	$result = $mysql->query($query, $CONFIG['DBMain']);

?>
	<table width="600">
		<tr>
			<td align="left" class="head">#</td>
			<td>&nbsp;</td>
			<td align="left" class="head" colspan="2">Nombre de Personaje</td>
			<td align="center" class="head">Profesion<br>Base - Job</td>
			<td align="center" class="head">Rango</td>
			<td align="center" class="head">S</td>
			<td align="center" class="head">K</td>
			<td align="center" class="head">D</td>
			<td align="center" class="head">Mapa<br>Estado</td>
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
				<td align="center" width="30"><img src="' . $char['sex'] . '.gif"></td>
				<td align="left">
					' . htmlformat($char['name']) . '';
		
		if( $char['gname'] != '' )
			echo '<br>
				<span title="Ver Profile de Guild" style="color:#0000FF; cursor:pointer" onMouseOver="this.style.color=#0000FF" onMouseOut="this.style.color=#0000FF" onClick="return LINK_ajax(\'guildprofile.php?guild_id=' . $char['guild_id'] . '\',\'main_div\');">
					<font color="Navy"><b>[' . htmlformat($char['gname']) . ']</b></font>
				</span>
			';
		
		$post = calc_rank($char['score']);

		echo '
				</td>
				<td align="center"><b>' . $char['base_level'] . '</b>&nbsp;<img src="./imgwm/' . $char['class'] . '.gif">&nbsp;<b>' . $char['job_level'] . '</b><br>' . $jobs[$char['class']] . '</td>
				<td align="center">' . ($post > 0 ? '<img src="./images/rank/' . $post . '.png"><br>':'') . $Rank[$post] . '</td>
				<td align="center">' . $char['score'] . '</td>
				<td align="center">' . $char['kill_count'] . '</td>
				<td align="center">' . $char['death_count'] . '</td>
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
	";

	if (isset($begin))
	{
		echo "</div>";
		closetable();
	}
?>