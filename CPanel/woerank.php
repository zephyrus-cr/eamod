<?php

	session_start();
	include_once 'config2.php';
	include_once 'functions2.php';

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
		"Field<br>Marshal",
		"Grand<br>Marshal",
	);

	$SortOrder = array(
		"DESC",
		"ASC",
	);

	$SortType = array(
		"`char_wstats`.`score`",
		"`char_wstats`.`kill_count`",
		"`char_wstats`.`death_count`",
		"`char_wstats`.`top_damage`",
		"`char_wstats`.`damage_done`",
		"`char_wstats`.`damage_received`",
		"`char_wstats`.`emperium_damage`",
		"`char_wstats`.`barricade_damage`",
		"`char_wstats`.`gstone_damage`",
		"`char_wstats`.`guardian_damage`",
		"`char_wstats`.`emperium_kill`",
		"`char_wstats`.`barricade_kill`",
		"`char_wstats`.`gstone_kill`",
		"`char_wstats`.`guardian_kill`",
		"`char_wstats`.`support_skills_used`",
		"`char_wstats`.`wrong_support_skills_used`",
		"`char_wstats`.`healing_done`",
		"`char_wstats`.`wrong_healing_done`",
		"`char_wstats`.`hp_heal_potions`",
		"`char_wstats`.`sp_heal_potions`",
		"`char_wstats`.`yellow_gemstones`",
		"`char_wstats`.`red_gemstones`",
		"`char_wstats`.`blue_gemstones`",
		"`char_wstats`.`zeny_used`",
		"`char_wstats`.`ammo_used`",
		"`char_wstats`.`acid_demostration`",
		"`char_wstats`.`poison_bottles`",
	);

	function calc_rank($score)
	{
		$result = intval($score / 270);
		if( $result > 14 )
			$result = 14;
		else if( $result < 0 )
			$result = 0;
		return $result;
	}

	if (!isset($_GET['opt']))
	{
		echo '
			<div class="ladder_class">
		';

		opentable('Ranking Acumulativo War of Emperium');

		echo '
			<table width="580">
				<tr>
					<td align="center">
						<hr>
					</td>
				</tr>
				<tr>
					<td align="center">
						<form id="ladder" onsubmit="return GET_ajax(\'woerank.php\',\'ladder_div\',\'ladder\');">
							<select name="opt">
								<option selected value="0">Todos...</option>
		';

		for( $i = 1; $i <= 26; $i++ )
		{ // First and Second Class - Expanded
			switch( $i )
			{
			// Ignored Classes
			case 13:
			case 21:
			case 22:
			case 26:
				continue;
			default:
				echo "<option value=\"$i\">$jobs[$i]</option>";
			}
		}

		for( $i = 4001; $i <= 4022; $i++ )
		{ // Advanced Class
			switch( $i )
			{
			// Ignored Classes
			case 4014:
			case 4022:
				continue;
			default:
				echo "<option value=\"$i\">$jobs[$i]</option>";
			}
		}

		for( $i = 4023; $i <= 4049; $i++ )
		{ // Baby Class - Expanded
			switch( $i )
			{
			// Ignored Classes
			case 4036:
			case 4044:
			case 4048:
				continue;
			default:
				echo "<option value=\"$i\">$jobs[$i]</option>";
			}
		}

		for( $i = 4054; $i <= 4079; $i++ )
		{ // 3rd Class
			echo "<option value=\"$i\">$jobs[$i]</option>";
		}

		for( $i = 4096; $i <= 4112; $i++ )
		{ // 3rd Class
			echo "<option value=\"$i\">$jobs[$i]</option>";
		}

		echo '
							</select>
							&nbsp;
							<select name="ser">
								<option selected value="0">Ofensiva</option>
								<option value="1">Kills</option>
								<option value="2">Deaths</option>
								<option value="3">Best Damage</option>
								<option value="4">Total Damage Done</option>
								<option value="5">Total Damage Received</option>
								<option value="6">Emperium Damage</option>
								<option value="7">Barricade Damage</option>
								<option value="8">Guardian Stone Damage</option>
								<option value="9">Guardian Damage</option>
								<option value="10">Emperium Kills</option>
								<option value="11">Barricade Kills</option>
								<option value="12">Guardian Stone Kills</option>
								<option value="13">Guardian Kills</option>
								<option value="14">Good Support Skills</option>
								<option value="15">Wrong Support Skills</option>
								<option value="16">Total Good Healing</option>
								<option value="17">Total Wrong Healing</option>
								<option value="18">HP Potions Used</option>
								<option value="19">SP Potions Used</option>
								<option value="20">Yellow Gems Used</option>
								<option value="21">Red Gems Used</option>
								<option value="22">Blue Gems Used</option>
								<option value="23">Zeny Used</option>
								<option value="24">Arrows Used</option>
								<option value="25">Acid Demonstration Casted</option>
								<option value="26">Enchanted Deadly Poison Casted</option>
							</select>
							&nbsp;
							<select name="ord">
								<option selected value="0">Descending</option>
								<option value="1">Ascending</option>
							</select>
							&nbsp;
							<input type="submit" value="Search">
						</form>
					</td>
				</tr>
				<tr>
					<td align="center">
						<hr>
					</td>
				</tr>
				<tr>
					<td align="center">
						<form id="laddersingle" onsubmit="return GET_ajax(\'woerank.php\',\'ladder_div\',\'laddersingle\');">
							Search by Character Name
							&nbsp;
							<input type="text" name="buscar" maxlength="24" size="24" onKeyPress="return force(this.name,this.form.id,event);">
							<input type="hidden" name="opt" value="100">
							&nbsp;
							<input type="submit" value="Search">
						</form>
					</td>
				</tr>
				<tr>
					<td align="center">
						<hr>
					</td>
				</tr>
				<tr>
					<td align="center">
						<form id="ladderguild" onsubmit="return GET_ajax(\'woerank.php\',\'ladder_div\',\'ladderguild\');">
							Search by Guild Name
							&nbsp;
							<input type="text" name="buscar" maxlength="24" size="24" onKeyPress="return force(this.name,this.form.id,event);">
							<input type="hidden" name="opt" value="101">
							&nbsp;
							<input type="submit" value="Search">
						</form>
					</td>
				</tr>
				<tr>
					<td align="center">
						<hr>
					</td>
				</tr>
			</table>
			<div id="ladder_div" style="color:#000000">
		';

		$begin = 1;
		$_GET['opt'] = 0;
		$_GET['ser'] = 0;
		$_GET['ord'] = 0;
	}

	DEFINE('PK_LADDER_GUILD', "
		SELECT
			`char`.`char_id`,
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`playtime`, `char`.`max_hp`, `char`.`max_sp`, `char`.`str`, `char`.`int`, `char`.`vit`, `char`.`dex`, `char`.`agi`, `char`.`luk`,
			`login`.`sex`,
			`guild`.`name` AS `gname`, `guild`.`guild_id`, `guild`.`emblem_data`,
			`char_wstats`.`score`, `char_wstats`.`kill_count`, `char_wstats`.`death_count`,
			`char_wstats`.`top_damage`, `char_wstats`.`damage_done`, `char_wstats`.`damage_received`,
			`char_wstats`.`emperium_damage`, `char_wstats`.`guardian_damage`, `char_wstats`.`barricade_damage`, `char_wstats`.`gstone_damage`,
			`char_wstats`.`emperium_kill`, `char_wstats`.`guardian_kill`, `char_wstats`.`barricade_kill`, `char_wstats`.`gstone_kill`,
			`char_wstats`.`sp_heal_potions`, `char_wstats`.`hp_heal_potions`, `char_wstats`.`yellow_gemstones`, `char_wstats`.`red_gemstones`, `char_wstats`.`blue_gemstones`,
			`char_wstats`.`poison_bottles`, `char_wstats`.`acid_demostration`, `char_wstats`.`acid_demostration_fail`, `char_wstats`.`support_skills_used`, `char_wstats`.`healing_done`, `char_wstats`.`ammo_used`,
			`char_wstats`.`wrong_support_skills_used`, `char_wstats`.`wrong_healing_done`, `char_wstats`.`sp_used`, `char_wstats`.`zeny_used`, `char_wstats`.`spiritb_used`
		FROM
			`char` JOIN `char_wstats` ON `char_wstats`.`char_id` = `char`.`char_id` JOIN `login` ON `login`.`account_id` = `char`.`account_id` JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char_wstats`.`char_id` > '0' AND `login`.`level` < '1' AND `login`.`state` = '0' AND `guild`.`name` LIKE '%%%s%%'
		ORDER BY
			`char_wstats`.`score` DESC
		LIMIT 0, 20
	");

	DEFINE('PK_LADDER_NAME', "
		SELECT
			`char`.`char_id`,
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`playtime`, `char`.`max_hp`, `char`.`max_sp`, `char`.`str`, `char`.`int`, `char`.`vit`, `char`.`dex`, `char`.`agi`, `char`.`luk`,
			`login`.`sex`,
			`guild`.`name` AS `gname`, `guild`.`guild_id`, `guild`.`emblem_data`,
			`char_wstats`.`score`, `char_wstats`.`kill_count`, `char_wstats`.`death_count`,
			`char_wstats`.`top_damage`, `char_wstats`.`damage_done`, `char_wstats`.`damage_received`,
			`char_wstats`.`emperium_damage`, `char_wstats`.`guardian_damage`, `char_wstats`.`barricade_damage`, `char_wstats`.`gstone_damage`,
			`char_wstats`.`emperium_kill`, `char_wstats`.`guardian_kill`, `char_wstats`.`barricade_kill`, `char_wstats`.`gstone_kill`,
			`char_wstats`.`sp_heal_potions`, `char_wstats`.`hp_heal_potions`, `char_wstats`.`yellow_gemstones`, `char_wstats`.`red_gemstones`, `char_wstats`.`blue_gemstones`,
			`char_wstats`.`poison_bottles`, `char_wstats`.`acid_demostration`, `char_wstats`.`acid_demostration_fail`, `char_wstats`.`support_skills_used`, `char_wstats`.`healing_done`, `char_wstats`.`ammo_used`,
			`char_wstats`.`wrong_support_skills_used`, `char_wstats`.`wrong_healing_done`, `char_wstats`.`sp_used`, `char_wstats`.`zeny_used`, `char_wstats`.`spiritb_used`
		FROM
			`char` JOIN `char_wstats` ON `char_wstats`.`char_id` = `char`.`char_id` JOIN `login` ON `login`.`account_id` = `char`.`account_id` JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char_wstats`.`char_id` > '0' AND `login`.`level` < '1' AND `login`.`state` = '0' AND `char`.`name` LIKE '%%%s%%'
		ORDER BY
			`char_wstats`.`score` DESC
		LIMIT 0, 20
	");

	DEFINE('PK_LADDER_ALL', "
		SELECT
			`char`.`char_id`,
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`playtime`, `char`.`max_hp`, `char`.`max_sp`, `char`.`str`, `char`.`int`, `char`.`vit`, `char`.`dex`, `char`.`agi`, `char`.`luk`,
			`login`.`sex`,
			`guild`.`name` AS `gname`, `guild`.`guild_id`, `guild`.`emblem_data`,
			`char_wstats`.`score`, `char_wstats`.`kill_count`, `char_wstats`.`death_count`,
			`char_wstats`.`top_damage`, `char_wstats`.`damage_done`, `char_wstats`.`damage_received`,
			`char_wstats`.`emperium_damage`, `char_wstats`.`guardian_damage`, `char_wstats`.`barricade_damage`, `char_wstats`.`gstone_damage`,
			`char_wstats`.`emperium_kill`, `char_wstats`.`guardian_kill`, `char_wstats`.`barricade_kill`, `char_wstats`.`gstone_kill`,
			`char_wstats`.`sp_heal_potions`, `char_wstats`.`hp_heal_potions`, `char_wstats`.`yellow_gemstones`, `char_wstats`.`red_gemstones`, `char_wstats`.`blue_gemstones`,
			`char_wstats`.`poison_bottles`, `char_wstats`.`acid_demostration`, `char_wstats`.`acid_demostration_fail`, `char_wstats`.`support_skills_used`, `char_wstats`.`healing_done`, `char_wstats`.`ammo_used`,
			`char_wstats`.`wrong_support_skills_used`, `char_wstats`.`wrong_healing_done`, `char_wstats`.`sp_used`, `char_wstats`.`zeny_used`, `char_wstats`.`spiritb_used`
		FROM
			`char` JOIN `char_wstats` ON `char_wstats`.`char_id` = `char`.`char_id` JOIN `login` ON `login`.`account_id` = `char`.`account_id` JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char_wstats`.`char_id` > '0' AND `login`.`level` < '1' AND `login`.`state` = '0'
		ORDER BY
			%s %s
		LIMIT 0, 20
	");

	DEFINE('PK_LADDER_JOB', "
		SELECT
			`char`.`char_id`,
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`playtime`, `char`.`max_hp`, `char`.`max_sp`, `char`.`str`, `char`.`int`, `char`.`vit`, `char`.`dex`, `char`.`agi`, `char`.`luk`,
			`login`.`sex`,
			`guild`.`name` AS `gname`, `guild`.`guild_id`, `guild`.`emblem_data`,
			`char_wstats`.`score`, `char_wstats`.`kill_count`, `char_wstats`.`death_count`,
			`char_wstats`.`top_damage`, `char_wstats`.`damage_done`, `char_wstats`.`damage_received`,
			`char_wstats`.`emperium_damage`, `char_wstats`.`guardian_damage`, `char_wstats`.`barricade_damage`, `char_wstats`.`gstone_damage`,
			`char_wstats`.`emperium_kill`, `char_wstats`.`guardian_kill`, `char_wstats`.`barricade_kill`, `char_wstats`.`gstone_kill`,
			`char_wstats`.`sp_heal_potions`, `char_wstats`.`hp_heal_potions`, `char_wstats`.`yellow_gemstones`, `char_wstats`.`red_gemstones`, `char_wstats`.`blue_gemstones`,
			`char_wstats`.`poison_bottles`, `char_wstats`.`acid_demostration`, `char_wstats`.`acid_demostration_fail`, `char_wstats`.`support_skills_used`, `char_wstats`.`healing_done`, `char_wstats`.`ammo_used`,
			`char_wstats`.`wrong_support_skills_used`, `char_wstats`.`wrong_healing_done`, `char_wstats`.`sp_used`, `char_wstats`.`zeny_used`, `char_wstats`.`spiritb_used`
		FROM
			`char` JOIN `char_wstats` ON `char_wstats`.`char_id` = `char`.`char_id` JOIN `login` ON `login`.`account_id` = `char`.`account_id` JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char_wstats`.`char_id` > '0' AND `login`.`level` < '1' AND `login`.`state` = '0' AND `char`.`class` = '%d'
		ORDER BY
			%s %s
		LIMIT 0, 20
	");

	DEFINE('PK_LADDER_LKPA', "
		SELECT
			`char`.`char_id`,
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`playtime`, `char`.`max_hp`, `char`.`max_sp`, `char`.`str`, `char`.`int`, `char`.`vit`, `char`.`dex`, `char`.`agi`, `char`.`luk`,
			`login`.`sex`,
			`guild`.`name` AS `gname`, `guild`.`guild_id`, `guild`.`emblem_data`,
			`char_wstats`.`score`, `char_wstats`.`kill_count`, `char_wstats`.`death_count`,
			`char_wstats`.`top_damage`, `char_wstats`.`damage_done`, `char_wstats`.`damage_received`,
			`char_wstats`.`emperium_damage`, `char_wstats`.`guardian_damage`, `char_wstats`.`barricade_damage`, `char_wstats`.`gstone_damage`,
			`char_wstats`.`emperium_kill`, `char_wstats`.`guardian_kill`, `char_wstats`.`barricade_kill`, `char_wstats`.`gstone_kill`,
			`char_wstats`.`sp_heal_potions`, `char_wstats`.`hp_heal_potions`, `char_wstats`.`yellow_gemstones`, `char_wstats`.`red_gemstones`, `char_wstats`.`blue_gemstones`,
			`char_wstats`.`poison_bottles`, `char_wstats`.`acid_demostration`, `char_wstats`.`acid_demostration_fail`, `char_wstats`.`support_skills_used`, `char_wstats`.`healing_done`, `char_wstats`.`ammo_used`,
			`char_wstats`.`wrong_support_skills_used`, `char_wstats`.`wrong_healing_done`, `char_wstats`.`sp_used`, `char_wstats`.`zeny_used`, `char_wstats`.`spiritb_used`
		FROM
			`char` JOIN `char_wstats` ON `char_wstats`.`char_id` = `char`.`char_id` JOIN `login` ON `login`.`account_id` = `char`.`account_id` JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char_wstats`.`char_id` > '0' AND `login`.`level` < '1' AND `login`.`state` = '0' AND (`char`.`class` = '%d' OR `char`.`class` = '%d')
		ORDER BY
			%s %s
		LIMIT 0, 20
	");

	if( notnumber($_GET['opt']) )
		alert("Wrong simbol.");


	if( $_GET['opt'] == 0 )
	{
		$query = sprintf(PK_LADDER_ALL, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
		$string = "All";
	}
	elseif( $_GET['opt'] == 100 )
	{
		$name = $mysql->escapestr($_GET['buscar']);
		$query = sprintf(PK_LADDER_NAME, $name);
		$string = "All";
	}
	elseif( $_GET['opt'] == 101 )
	{
		$name = $mysql->escapestr($_GET['buscar']);
		$query = sprintf(PK_LADDER_GUILD, $name);
		$string = "All";
	}
	elseif( $_GET['opt'] > 0 )
	{
		switch( $_GET['opt'] )
		{
		case 7: // Knight
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 13, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 14: // Crusader
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 21, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4008: // Lord Knight
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4014, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4015: // Paladin
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4022, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4030: // Baby Knight
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4036, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4037: // Baby Crusader
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4044, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4047: // Star Gladiator
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4048, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4054: // Rune Knight
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4080, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4060: // Rune Knight T
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4081, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4066: // Royal Guard
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4082, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4073: // Royal Guard T
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4083, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4056: // Ranger
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4084, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4062: // Ranger T
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4085, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4058: // Mechanic
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4086, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4064: // Mechanic T
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4087, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4096: // Baby Rune Knight
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4109, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4102: // Baby Royal Guard
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4110, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4098: // Baby Ranger
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4111, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		case 4100: // Baby Mechanic
			$query = sprintf(PK_LADDER_LKPA, $_GET['opt'], 4112, $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		default:
			$query = sprintf(PK_LADDER_JOB, $_GET['opt'], $SortType[$_GET['ser']], $SortOrder[$_GET['ord']]);
			break;
		}

		if( isset($jobs[$_GET['opt']]) )
			$string = $jobs[$_GET['opt']];
		else
			$string = "Unknown";
	}

	$result = $mysql->query($query, $CONFIG['DBMain']);
	$count = 0;
	while( $char = $mysql->fetcharray($result) )
	{
		$count++;
		$emblems[$char['guild_id']] = $char['emblem_data'];
		$post = calc_rank($char['score']);

		echo '
			<table witdh="580" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFC300">
				<tr>
					<td>
						<table width="580" border="0" cellpadding="0" cellspacing="0" bgcolor="#A92207">
							<tr>
								<td width="36" height="36" rowspan="2" align="center" valign="middle">
									<img src="emblema.php?data=' . $char['guild_id'] . '" alt=".">
								</td>
								<td>
									<font color="#FFFFFF" size="3"><b>' . htmlformat($char['name']) . '<b></font>
								</td>
								<td width="150" align="right" valign="middle">
									<font size="3" color="#FFFFFF"><b>' . $count . '<b></font>&nbsp;
								</td>
							</tr>
							<tr>
								<td>
									<font color="#FFC300"><b>' . htmlformat($char['gname']) . '</b></font>
								</td>
								<td align="right">
									<font color="#FFC300"><b>' . playtime($char['playtime']) . '</b>&nbsp;</font>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">
						<table width="580" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="110" height="130" align="center" valign="middle">
									<img src="./images/class/' . $char['sex'] . '/' . $char['class'] . '.gif"><br>
									<font size="2" color="#4169E1"><b>' . $jobs[$char['class']] . '</b></font><br>
									<font color="#FF0000">' . $char['max_hp'] . '</font> / <font color="#0000FF">' . $char['max_sp'] . '</font><br>
									<a href="wprofile.php?cid=' . $char['char_id'] . '" target="_blank"><img src="./images/viewprofile.png" border="0"></a>
								</td>
								<td rowspan="2" align="center" valign="middle">
									<table width="470" border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td>
												<table width="470" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="6" bgcolor="#FFC300" height="15" align="center" valign="middle"><font color="#A92207"><b>Estadisticas Generales</b></font></td>
														<td colspan="6" bgcolor="#FFC300" height="15" align="center" valign="middle"><font color="#A92207"><b>Da&ntilde;o vs Jugador</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/2733.png"></td>
														<td><font color="#4169E1"><b>Score</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1214.png"></td>
														<td><font color="#4169E1"><b>Kill</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7005.png"></td>
														<td><font color="#4169E1"><b>Death</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1819.png"></td>
														<td><font color="#4169E1"><b>Best</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1259.png"></td>
														<td><font color="#4169E1"><b>Done</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/2108.png"></td>
														<td><font color="#4169E1"><b>Recv</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($char['score'])?$char['score']:'0') . '</td>
														<td>' . (isset($char['kill_count'])?$char['kill_count']:'0') . '</td>
														<td>' . (isset($char['death_count'])?$char['death_count']:'0') . '</td>
														<td>' . (isset($char['top_damage'])?$char['top_damage']:'0') . '</td>
														<td>' . (isset($char['damage_done'])?$char['damage_done']:'0') . '</td>
														<td>' . (isset($char['damage_received'])?$char['damage_received']:'0') . '</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width="470" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="4" bgcolor="#FFC300" height="15" align="center" valign="middle"><font color="#A92207"><b>Da&ntilde;o vs Estructuras</b></font></td>
														<td colspan="4" bgcolor="#FFC300" height="15" align="center" valign="middle"><font color="#A92207"><b>Estructuras Eliminadas</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/714.png"></td>
														<td><font color="#4169E1"><b>Emperium</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1019.png"></td>
														<td><font color="#4169E1"><b>Barricada</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/714.png"></td>
														<td><font color="#4169E1"><b>Emperium</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1019.png"></td>
														<td><font color="#4169E1"><b>Barricada</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($char['emperium_damage'])?$char['emperium_damage']:'0') . '</td>
														<td>' . (isset($char['barricade_damage'])?$char['barricade_damage']:'0') . '</td>
														<td>' . (isset($char['emperium_kill'])?$char['emperium_kill']:'0') . '</td>
														<td>' . (isset($char['barricade_kill'])?$char['barricade_kill']:'0') . '</td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7429.png"></td>
														<td><font color="#4169E1"><b>G.Stone</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1160.png"></td>
														<td><font color="#4169E1"><b>Guardian</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7429.png"></td>
														<td><font color="#4169E1"><b>G.Stone</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1160.png"></td>
														<td><font color="#4169E1"><b>Guardian</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($char['gstone_damage'])?$char['gstone_damage']:'0') . '</td>
														<td>' . (isset($char['guardian_damage'])?$char['guardian_damage']:'0') . '</td>
														<td>' . (isset($char['gstone_kill'])?$char['gstone_kill']:'0') . '</td>
														<td>' . (isset($char['guardian_kill'])?$char['guardian_kill']:'0') . '</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width="470" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="4" bgcolor="#FFC300" height="15" align="center" valign="middle"><font color="#A92207"><b>Skills Soporte</b></font></td>
														<td colspan="4" bgcolor="#FFC300" height="15" align="center" valign="middle"><font color="#A92207"><b>Total Healing</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/2277.png"></td>
														<td><font color="#4169E1"><b>Correcto</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/5203.png"></td>
														<td><font color="#4169E1"><b>Erroneo</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/2277.png"></td>
														<td><font color="#4169E1"><b>Correcto</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/5203.png"></td>
														<td><font color="#4169E1"><b>Erroneo</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($char['support_skills_used'])?$char['support_skills_used']:'0') . '</td>
														<td>' . (isset($char['wrong_support_skills_used'])?$char['wrong_support_skills_used']:'0') . '</td>
														<td>' . (isset($char['healing_done'])?$char['healing_done']:'0') . '</td>
														<td>' . (isset($char['wrong_healing_done'])?$char['wrong_healing_done']:'0') . '</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width="470" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="10" bgcolor="#FFC300" height="15" align="center" valign="middle"><font color="#A92207"><b>Consumo de Items</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/504.png"></td>
														<td><font color="#4169E1"><b>HP</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/505.png"></td>
														<td><font color="#4169E1"><b>SP</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/715.png"></td>
														<td><font color="#4169E1"><b>Gems</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/716.png"></td>
														<td><font color="#4169E1"><b>Gems</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/717.png"></td>
														<td><font color="#4169E1"><b>Gems</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($char['hp_heal_potions'])?$char['hp_heal_potions']:'0') . '</td>
														<td>' . (isset($char['sp_heal_potions'])?$char['sp_heal_potions']:'0') . '</td>
														<td>' . (isset($char['yellow_gemstones'])?$char['yellow_gemstones']:'0') . '</td>
														<td>' . (isset($char['red_gemstones'])?$char['red_gemstones']:'0') . '</td>
														<td>' . (isset($char['blue_gemstones'])?$char['blue_gemstones']:'0') . '</td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/676.png"></td>
														<td colspan="3"><font color="#4169E1"><b>Total Zeny</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1752.png"></td>
														<td><font color="#4169E1"><b>Arrow</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7136.png"></td>
														<td><font color="#4169E1"><b>Bottle</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/678.png"></td>
														<td><font color="#4169E1"><b>Bottle</b></font></td>
													</tr>
													<tr>
														<td colspan="3">' . (isset($char['zeny_used'])?$char['zeny_used']:'0') . '</td>
														<td>' . (isset($char['ammo_used'])?$char['ammo_used']:'0') . '</td>
														<td>' . (isset($char['acid_demostration'])?$char['acid_demostration']:'0') . '</td>
														<td>' . (isset($char['poison_bottles'])?$char['poison_bottles']:'0') . '</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="50" align="center" valign="middle">
									' . ($post > 0 ? '<img src="./images/rank/' . $post . '.png">':'') . '<br>
									<font size="1" color="#FFC300"><b>' . $Rank[$post] . '</b></font><br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
		';

		echo  '
			</table>
			<br><br>
		';
	}

	echo "
		</div>
	";

	if( isset($emblems) )
		$_SESSION[$CONFIG['Name'] . 'emblems'] = $emblems;

	if (isset($begin))
	{
		echo "</div>";
		closetable();
	}
?>