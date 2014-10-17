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
		"`char_bg`.`points`",
		"`char_bg`.`rank_points`",
		"`char`.`bg_gold`",
		"`char`.`bg_silver`",
		"`char`.`bg_bronze`",
		"`char_bg`.`score`",

		"`char_bg`.`win`",
		"`char_bg`.`tie`",
		"`char_bg`.`lost`",
		"`char_bg`.`leader_win`",
		"`char_bg`.`leader_tie`",
		"`char_bg`.`leader_lost`",

		"`char_bg`.`kill_count`",
		"`char_bg`.`death_count`",
		"`char_bg`.`deserter`",

		"`char_bg`.`ctf_taken`",
		"`char_bg`.`ctf_captured`",
		"`char_bg`.`ctf_droped`",
		"`char_bg`.`ctf_wins`",
		"`char_bg`.`ctf_tie`",
		"`char_bg`.`ctf_lost`",

		"`char_bg`.`td_kills`",
		"`char_bg`.`td_deaths`",
		"`char_bg`.`td_wins`",
		"`char_bg`.`td_tie`",
		"`char_bg`.`td_lost`",

		"`char_bg`.`sc_stole`",
		"`char_bg`.`sc_captured`",
		"`char_bg`.`sc_droped`",
		"`char_bg`.`sc_wins`",
		"`char_bg`.`sc_tie`",
		"`char_bg`.`sc_lost`",

		"`char_bg`.`eos_flags`",
		"`char_bg`.`eos_bases`",
		"`char_bg`.`eos_wins`",
		"`char_bg`.`eos_tie`",
		"`char_bg`.`eos_lost`",

		"`char_bg`.`boss_damage`",
		"`char_bg`.`boss_killed`",
		"`char_bg`.`boss_flags`",
		"`char_bg`.`boss_wins`",
		"`char_bg`.`boss_tie`",
		"`char_bg`.`boss_lost`",

		"`char_bg`.`skulls`",
		"`char_bg`.`ti_wins`",
		"`char_bg`.`ti_tie`",
		"`char_bg`.`ti_lost`",

		"`char_bg`.`emperium_kill`",
		"`char_bg`.`barricade_kill`",
		"`char_bg`.`gstone_kill`",
		"`char_bg`.`cq_wins`",
		"`char_bg`.`cq_lost`",

		"`char_bg`.`top_damage`",
		"`char_bg`.`damage_done`",
		"`char_bg`.`damage_received`",
		"`char_bg`.`support_skills_used`",
		"`char_bg`.`wrong_support_skills_used`",
		"`char_bg`.`healing_done`",
		"`char_bg`.`wrong_healing_done`",
		"`char_bg`.`hp_heal_potions`",
		"`char_bg`.`sp_heal_potions`",
		"`char_bg`.`yellow_gemstones`",
		"`char_bg`.`red_gemstones`",
		"`char_bg`.`blue_gemstones`",
		"`char_bg`.`zeny_used`",
		"`char_bg`.`ammo_used`",
		"`char_bg`.`acid_demostration`",
		"`char_bg`.`poison_bottles`",
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

		opentable('Week Ranking - Battleground');

		echo '
			<table width="580">
				<tr>
					<td align="center">
						<hr>
					</td>
				</tr>
				<tr>
					<td align="center">
						<form id="ladder" onsubmit="return GET_ajax(\'bgrank.php\',\'ladder_div\',\'ladder\');">
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
								<option selected value="0">Regular Week Points</option>
								<option value="1">Ranked Week Points</option>
								<option value="2">Gold Medals</option>
								<option value="3">Silver Medals</option>
								<option value="4">Bronze Medals</option>
								<option value="5">Offensive</option>
								<option value="6">Game Wins</option>
								<option value="7">Game Tie</option>
								<option value="8">Game Lost</option>
								<option value="9">Leader Game Wins</option>
								<option value="10">Leader Game Tie</option>
								<option value="11">Leader Game Lost</option>
								<option value="12">Kill Counter</option>
								<option value="13">Die Counter</option>
								<option value="14">Deserted Games</option>
								<option value="15">CTF - Flags Taken</option>
								<option value="16">CTF - Flags Captured</option>
								<option value="17">CTF - Flags Droped</option>
								<option value="18">CTF - Game Wins</option>
								<option value="19">CTF - Game Tie</option>
								<option value="20">CTF - Game Lost</option>
								<option value="21">TDM - Kill Counter</option>
								<option value="22">TDM - Die Counter</option>
								<option value="23">TDM - Game Wins</option>
								<option value="24">TDM - Game Tie</option>
								<option value="25">TDM - Game Lost</option>
								<option value="26">SC - Stone Stole</option>
								<option value="27">SC - Stone Captured</option>
								<option value="28">SC - Stone Droped</option>
								<option value="29">SC - Game Wins</option>
								<option value="30">SC - Game Tie</option>
								<option value="31">SC - Game Lost</option>
								<option value="32">EOS - Flags Captured</option>
								<option value="33">EOS - Bases Captured</option>
								<option value="34">EOS - Game Wins</option>
								<option value="35">EOS - Game Tie</option>
								<option value="36">EOS - Game Lost</option>
								<option value="37">BOSS - Guardian Damage</option>
								<option value="38">BOSS - Guardian Killed</option>
								<option value="39">BOSS - Flags Captured</option>
								<option value="40">BOSS - Game Wins</option>
								<option value="41">BOSS - Game Tie</option>
								<option value="42">BOSS - Game Lost</option>
								<option value="43">TI - Skulls Taken</option>
								<option value="44">TI - Game Wins</option>
								<option value="45">TI - Game Tie</option>
								<option value="46">TI - Game Lost</option>
								<option value="47">CON - Emperium Kills</option>
								<option value="48">CON - Barricade Kills</option>
								<option value="49">CON - Guarian Stone Kills</option>
								<option value="50">CON - Game Wins</option>
								<option value="51">CON - Game Lost</option>
								<option value="52">Best Damage</option>
								<option value="53">Total Damage Done</option>
								<option value="54">Total Damage Received</option>
								<option value="55">Good Support Skills</option>
								<option value="56">Wrong Support Skills</option>
								<option value="57">Total Good Healing</option>
								<option value="58">Total Wrong Healing</option>
								<option value="59">HP Potions Used</option>
								<option value="60">SP Potions Used</option>
								<option value="61">Yellow Gems Used</option>
								<option value="62">Red Gems Used</option>
								<option value="63">Blue Gems Used</option>
								<option value="64">Zeny Used</option>
								<option value="65">Arrows Used</option>
								<option value="66">Acid Demonstration Casted</option>
								<option value="67">Enchanted Deadly Poison Casted</option>
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
						<form id="laddersingle" onsubmit="return GET_ajax(\'bgrank.php\',\'ladder_div\',\'laddersingle\');">
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
						<form id="ladderguild" onsubmit="return GET_ajax(\'bgrank.php\',\'ladder_div\',\'ladderguild\');">
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
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`playtime`, `char`.`max_hp`, `char`.`max_sp`, `char`.`str`, `char`.`int`, `char`.`vit`, `char`.`dex`, `char`.`agi`, `char`.`luk`, `char`.`bg_gold`, `char`.`bg_silver`, `char`.`bg_bronze`,
			`login`.`sex`,
			`guild`.`name` AS `gname`, `guild`.`guild_id`, `guild`.`emblem_data`,
			`char_bg`.*
		FROM
			`char` JOIN `char_bg` ON `char_bg`.`char_id` = `char`.`char_id` JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char_bg`.`char_id` > '0' AND `login`.`level` < '1' AND `login`.`state` = '0' AND `guild`.`name` LIKE '%%%s%%'
		ORDER BY
			`char_bg`.`points` DESC
		LIMIT 0, 20
	");

	DEFINE('PK_LADDER_NAME', "
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`playtime`, `char`.`max_hp`, `char`.`max_sp`, `char`.`str`, `char`.`int`, `char`.`vit`, `char`.`dex`, `char`.`agi`, `char`.`luk`, `char`.`bg_gold`, `char`.`bg_silver`, `char`.`bg_bronze`,
			`login`.`sex`,
			`guild`.`name` AS `gname`, `guild`.`guild_id`, `guild`.`emblem_data`,
			`char_bg`.*
		FROM
			`char` JOIN `char_bg` ON `char_bg`.`char_id` = `char`.`char_id` JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char_bg`.`char_id` > '0' AND `login`.`level` < '1' AND `login`.`state` = '0' AND `char`.`name` LIKE '%%%s%%'
		ORDER BY
			`char_bg`.`points` DESC
		LIMIT 0, 20
	");

	DEFINE('PK_LADDER_ALL', "
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`playtime`, `char`.`max_hp`, `char`.`max_sp`, `char`.`str`, `char`.`int`, `char`.`vit`, `char`.`dex`, `char`.`agi`, `char`.`luk`, `char`.`bg_gold`, `char`.`bg_silver`, `char`.`bg_bronze`,
			`login`.`sex`,
			`guild`.`name` AS `gname`, `guild`.`guild_id`, `guild`.`emblem_data`,
			`char_bg`.*
		FROM
			`char` JOIN `char_bg` ON `char_bg`.`char_id` = `char`.`char_id` JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char_bg`.`char_id` > '0' AND `login`.`level` < '1' AND `login`.`state` = '0'
		ORDER BY
			%s %s
		LIMIT 0, 20
	");

	DEFINE('PK_LADDER_JOB', "
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`playtime`, `char`.`max_hp`, `char`.`max_sp`, `char`.`str`, `char`.`int`, `char`.`vit`, `char`.`dex`, `char`.`agi`, `char`.`luk`, `char`.`bg_gold`, `char`.`bg_silver`, `char`.`bg_bronze`,
			`login`.`sex`,
			`guild`.`name` AS `gname`, `guild`.`guild_id`, `guild`.`emblem_data`,
			`char_bg`.*
		FROM
			`char` JOIN `char_bg` ON `char_bg`.`char_id` = `char`.`char_id` JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char_bg`.`char_id` > '0' AND `login`.`level` < '1' AND `login`.`state` = '0' AND `char`.`class` = '%d'
		ORDER BY
			%s %s
		LIMIT 0, 20
	");

	DEFINE('PK_LADDER_LKPA', "
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`playtime`, `char`.`max_hp`, `char`.`max_sp`, `char`.`str`, `char`.`int`, `char`.`vit`, `char`.`dex`, `char`.`agi`, `char`.`luk`, `char`.`bg_gold`, `char`.`bg_silver`, `char`.`bg_bronze`,
			`login`.`sex`,
			`guild`.`name` AS `gname`, `guild`.`guild_id`, `guild`.`emblem_data`,
			`char_bg`.*
		FROM
			`char` JOIN `char_bg` ON `char_bg`.`char_id` = `char`.`char_id` JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char_bg`.`char_id` > '0' AND `login`.`level` < '1' AND `login`.`state` = '0' AND (`char`.`class` = '%d' OR `char`.`class` = '%d')
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
									<font color="#FFC300"><b>' . ( $char['gname'] == '' ? '-- no Guild --' : htmlformat($char['gname']) ) . '</b></font>
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
									<a href="profile.php?cid=' . $char['char_id'] . '" target="_blank"><img src="./images/viewprofile.png" border="0"></a>
								</td>
								<td rowspan="4" align="center" valign="middle">
									<table width="470" border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td>
												<table width="470" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="6" bgcolor="#FFC300" height="15" align="center" valign="middle"><font color="#A92207"><b>Game Results</b></font></td>
														<td colspan="6" bgcolor="#FFC300" height="15" align="center" valign="middle"><font color="#A92207"><b>As Team Leader</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7517.png"></td>
														<td><font color="#4169E1"><b>Won</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/674.png"></td>
														<td><font color="#4169E1"><b>Tie</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/673.png"></td>
														<td><font color="#4169E1"><b>Lost</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7517.png"></td>
														<td><font color="#4169E1"><b>Won</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/674.png"></td>
														<td><font color="#4169E1"><b>Tie</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/673.png"></td>
														<td><font color="#4169E1"><b>Lost</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($char['win'])?$char['win']:'0') . '</td>
														<td>' . (isset($char['tie'])?$char['tie']:'0') . '</td>
														<td>' . (isset($char['lost'])?$char['lost']:'0') . '</td>
														<td>' . (isset($char['leader_win'])?$char['leader_win']:'0') . '</td>
														<td>' . (isset($char['leader_tie'])?$char['leader_tie']:'0') . '</td>
														<td>' . (isset($char['leader_lost'])?$char['leader_lost']:'0') . '</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width="470" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="6" bgcolor="#FFC300" height="15" align="center" valign="middle"><font color="#A92207"><b>General Standings</b></font></td>
														<td colspan="6" bgcolor="#FFC300" height="15" align="center" valign="middle"><font color="#A92207"><b>Damage</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1214.png"></td>
														<td><font color="#4169E1"><b>Kill</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7005.png"></td>
														<td><font color="#4169E1"><b>Death</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/2108.png"></td>
														<td><font color="#4169E1"><b>Quits</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1819.png"></td>
														<td><font color="#4169E1"><b>Top</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1259.png"></td>
														<td><font color="#4169E1"><b>Done</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/2108.png"></td>
														<td><font color="#4169E1"><b>Recv</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($char['kill_count'])?$char['kill_count']:'0') . '</td>
														<td>' . (isset($char['death_count'])?$char['death_count']:'0') . '</td>
														<td>' . (isset($char['deserter'])?$char['deserter']:'0') . '</td>
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
														<td colspan="6" bgcolor="#A92207" height="15" align="center" valign="middle"><font color="#FFC300"><b>Tierra EoS</b></font></td>
														<td colspan="4" bgcolor="#A92207" height="15" align="center" valign="middle"><font color="#FFC300"><b>Tierra TI</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7253.png"></td>
														<td><font color="#4169E1"><b>Flags</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7423.png"></td>
														<td><font color="#4169E1"><b>Bases</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/658.png"></td>
														<td><font color="#4169E1"><b>Results</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7005.png"></td>
														<td><font color="#4169E1"><b>Skulls</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/658.png"></td>
														<td><font color="#4169E1"><b>Results</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($char['eos_flags'])?$char['eos_flags']:'0') . '</td>
														<td>' . (isset($char['eos_bases'])?$char['eos_bases']:'0') . '</td>
														<td><font color="#4169E1"><b>W</b></font> ' . (isset($char['eos_wins'])?$char['eos_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> ' . (isset($char['eos_tie'])?$char['eos_tie']:'0') . ' <font color="#4169E1"><b>L</b></font> ' . (isset($char['eos_lost'])?$char['eos_lost']:'0') . '</td>
														<td>' . (isset($char['skulls'])?$char['skulls']:'0') . '</td>
														<td><font color="#4169E1"><b>W</b></font> ' . (isset($char['ti_wins'])?$char['ti_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> ' . (isset($char['ti_tie'])?$char['ti_tie']:'0') . ' <font color="#4169E1"><b>L</b></font> ' . (isset($char['ti_lost'])?$char['ti_lost']:'0') . '</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width="470" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="8" bgcolor="#A92207" height="15" align="center" valign="middle"><font color="#FFC300"><b>Tierra Bossnia</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/750.png"></td>
														<td><font color="#4169E1"><b>Boss Damage</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/751.png"></td>
														<td><font color="#4169E1"><b>Boss Killed</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7253.png"></td>
														<td><font color="#4169E1"><b>Flags</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/658.png"></td>
														<td><font color="#4169E1"><b>Results</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($char['boss_damage'])?$char['boss_damage']:'0') . '</td>
														<td>' . (isset($char['boss_killed'])?$char['boss_killed']:'0') . '</td>
														<td>' . (isset($char['boss_flags'])?$char['boss_flags']:'0') . '</td>
														<td><font color="#4169E1"><b>W</b></font> ' . (isset($char['boss_wins'])?$char['boss_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> ' . (isset($char['boss_tie'])?$char['boss_tie']:'0') . ' <font color="#4169E1"><b>L</b></font> ' . (isset($char['boss_lost'])?$char['boss_lost']:'0') . '</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width="470" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="6" bgcolor="#4169E1" height="15" align="center" valign="middle"><font color="#9ACD32"><b>Flavius TDM</b></font></td>
														<td colspan="4" bgcolor="#4169E1" height="15" align="center" valign="middle"><font color="#9ACD32"><b>Flavius CTF</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7005.png"></td>
														<td><font color="#4169E1"><b>Kills</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7005.png"></td>
														<td><font color="#4169E1"><b>Deaths</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/658.png"></td>
														<td><font color="#4169E1"><b>Results</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7253.png"></td>
														<td><font color="#4169E1"><b>Flags</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/658.png"></td>
														<td><font color="#4169E1"><b>Results</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($char['td_kills'])?$char['td_kills']:'0') . '</td>
														<td>' . (isset($char['td_deaths'])?$char['td_deaths']:'0') . '</td>
														<td><font color="#4169E1"><b>W</b></font> ' . (isset($char['td_wins'])?$char['td_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> ' . (isset($char['td_tie'])?$char['td_tie']:'0') . ' <font color="#4169E1"><b>L</b></font> ' . (isset($char['td_lost'])?$char['td_lost']:'0') . '</td>
														<td><font color="#4169E1"><b>T</b></font> ' . (isset($char['ctf_taken'])?$char['ctf_taken']:'0') . ' <font color="#4169E1"><b>C</b></font> ' . (isset($char['ctf_captured'])?$char['ctf_captured']:'0') . ' <font color="#4169E1"><b>D</b></font> ' . (isset($char['ctf_droped'])?$char['ctf_droped']:'0') . '</td>
														<td><font color="#4169E1"><b>W</b></font> ' . (isset($char['ctf_wins'])?$char['ctf_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> ' . (isset($char['ctf_tie'])?$char['ctf_tie']:'0') . ' <font color="#4169E1"><b>L</b></font> ' . (isset($char['ctf_lost'])?$char['ctf_lost']:'0') . '</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width="470" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="8" bgcolor="#4169E1" height="15" align="center" valign="middle"><font color="#9ACD32"><b>Flavius Stone Control</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/640.png"></td>
														<td><font color="#4169E1"><b>Stole</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/640.png"></td>
														<td><font color="#4169E1"><b>Capture</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/640.png"></td>
														<td><font color="#4169E1"><b>Droped</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/658.png"></td>
														<td><font color="#4169E1"><b>Results</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($char['sc_stole'])?$char['sc_stole']:'0') . '</td>
														<td>' . (isset($char['sc_captured'])?$char['sc_captured']:'0') . '</td>
														<td>' . (isset($char['sc_droped'])?$char['sc_droped']:'0') . '</td>
														<td><font color="#4169E1"><b>W</b></font> ' . (isset($char['sc_wins'])?$char['sc_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> ' . (isset($char['sc_tie'])?$char['sc_tie']:'0') . ' <font color="#4169E1"><b>L</b></font> ' . (isset($char['sc_lost'])?$char['sc_lost']:'0') . '</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width="470" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="8" bgcolor="#8B0000" height="15" align="center" valign="middle"><font color="#FFFFFF"><b>Castle Conquest</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/714.png"></td>
														<td><font color="#4169E1"><b>Emperium</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1019.png"></td>
														<td><font color="#4169E1"><b>Barricade</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7429.png"></td>
														<td><font color="#4169E1"><b>G.Stone</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/658.png"></td>
														<td><font color="#4169E1"><b>Results</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($char['emperium_kill'])?$char['emperium_kill']:'0') . '</td>
														<td>' . (isset($char['barricade_kill'])?$char['barricade_kill']:'0') . '</td>
														<td>' . (isset($char['gstone_kill'])?$char['gstone_kill']:'0') . '</td>
														<td><font color="#4169E1"><b>W</b></font> ' . (isset($char['cq_wins'])?$char['cq_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> 0 <font color="#4169E1"><b>L</b></font> ' . (isset($char['cq_lost'])?$char['cq_lost']:'0') . '</td>
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
														<td colspan="10" bgcolor="#FFC300" height="15" align="center" valign="middle"><font color="#A92207"><b>Usable Items</b></font></td>
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
								<td height="90" align="center" valign="middle">
									<img src="./images/item/small/2733.png"><br>
									<font size="1" color="#A0522D"><b>Week Points</b></font><br>
									<font size="1" color="#4169E1"><b>Regular : </b></font><font size="1" color="#FFC300"><b>' . (isset($char['points'])?$char['points']:'0') . '</b></font><br>
									<font size="1" color="#4169E1"><b>Ranked : </b></font><font size="1" color="#FFC300"><b>' . (isset($char['rank_points'])?$char['rank_points']:'0') . '</b></font><br>
									<br>
									<font size="1" color="#A0522D"><b>Played </b></font><font size="1" color="#FFC300"><b>' . (isset($char['rank_games'])?$char['rank_games']:'0') . '</b></font><font size="1" color="#A0522D"><b> Rank Games</b></font>
								</td>
							</tr>
							<tr>
								<td height="50" align="center" valign="middle">
									' . ($post > 0 ? '<img src="./images/rank/' . $post . '.png">':'') . '<br>
									<font size="1" color="#FFC300"><b>' . $Rank[$post] . '</b></font><br>
									<font size="1" color="#4169E1"><b>Elo. Rank</b></font><br>
									<font size="1" color="#FFC300"><b>' . (isset($char['score'])?$char['score']:'0') . '</b></font><br>
								</td>
							</tr>
							<tr>
								<td height="50" align="center" valign="middle">
									<font size="1" color="#4169E1"><b>Medals</b></font><br>
									<font size="1" color="#FFC300"><b>' . (isset($char['bg_gold'])?$char['bg_gold']:'0') . '</b></font> | <font size="1" color="#00BFFF"><b>' . (isset($char['bg_silver'])?$char['bg_silver']:'0') . '</b></font> | <font size="1" color="#A0522D"><b>' . (isset($char['bg_bronze'])?$char['bg_bronze']:'0') . '</b></font><br>
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