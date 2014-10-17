<?php
	/* Character Profile */
	session_start();
	include_once('config2.php');
	include_once('functions2.php');

	if( !isset($_GET['cid']) || !is_numeric($_GET['cid']) )
	{
		header( "HTTP/1.1 301 Moved Permanently" );
		header( "Status: 301 Moved Permanently" );
		header( "Location: http://brawlnetwork.net" );
		exit(0);
	}

	$char_id = $_GET['cid'];
	$tar_id = 0;
	if( isset($_GET['tid']) && is_numeric($_GET['tid']) )
		$tar_id = $_GET['tid'];
	$sid = 0;
	if( isset($_GET['sid']) && is_numeric($_GET['sid']) )
		$sid = $_GET['sid'];

	$query = sprintf("
		SELECT
			`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`playtime`, `char`.`max_hp`, `char`.`max_sp`, `char`.`str`, `char`.`int`, `char`.`vit`, `char`.`dex`, `char`.`agi`, `char`.`luk`, `char`.`bg_gold`, `char`.`bg_silver`, `char`.`bg_bronze`,
			`login`.`sex`,
			`guild`.`name` AS `gname`, `guild`.`guild_id`, `guild`.`emblem_data`,
			`char_bg`.*
		FROM
			`char` JOIN `char_bg` ON `char_bg`.`char_id` = `char`.`char_id` JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
		WHERE
			`char_bg`.`char_id` > '0' AND `login`.`level` < '1' AND `login`.`state` = '0' AND `char`.`char_id` = '%d'
	",$char_id);

	$result = $mysql->query($query, $CONFIG['DBMain']);
	if( !($data = $mysql->fetcharray($result)) )
	{ // Profile not found
		header( "HTTP/1.1 301 Moved Permanently" );
		header( "Status: 301 Moved Permanently" );
		header( "Location: http://members.chronos-ro.com" );
		exit(0);
	}

	$jobs = readjobs();
	$skills = readskills();

	$Rank = array(
		"Civilian",
		"Private",
		"Corporal",
		"Sergeant",
		"Master Sergeant",
		"Sergeant Major",
		"Knight",
		"Knight Lieutenant",
		"Knight Captain",
		"Knight Champion",
		"Lieutenant Commander",
		"Commander",
		"Marshal",
		"Field Marshal",
		"Grand Marshal",
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

	$post = calc_rank($data['score']);
	$emblems[$data['guild_id']] = $data['emblem_data'];
	$_SESSION[$CONFIG['Name'] . 'emblems'] = $emblems;

	$bgs = array(
		'bat_a01' => 'Tierra George',
		'bat_a02' => '<font color="#4169E1">Tierra EoS</font>',
		'bat_a03' => '<font color="#483D8B">Tierra Bossnia</font>',
		'region_8' => '<font color="#696969">Tierra TI</font>',
		'bat_b01' => 'Flavius',
		'bat_b02' => '<font color="#A0522D">Flavius CTF</font>',
		'bat_b03' => '<font color="#808000">Flavius TDM</font>',
		'bat_b04' => '<font color="#9ACD32">Flavius SC</font>',
		'bat_c01' => 'KvM 5vs5',
		'bat_c02' => 'KvM 5vs5',
		'bat_c03' => 'KvM 12vs12',
		'bat_c04' => 'Duel Arena',
		'schg_cas06' => '<font color="#FFA500">Castle Conquest</font>',
		'schg_cas07' => '<font color="#FFA500">Castle Conquest</font>',
		'schg_cas08' => '<font color="#FFA500">Castle Conquest</font>',
		'arug_cas06' => '<font color="#FFA500">Castle Conquest</font>',
		'arug_cas07' => '<font color="#FFA500">Castle Conquest</font>',
		'arug_cas08' => '<font color="#FFA500">Castle Conquest</font>',
		'rush_cas01' => '<font color="#DDA0DD">Castle Rush</font>',
		'rush_cas02' => '<font color="#DDA0DD">Castle Rush</font>',
		'rush_cas03' => '<font color="#DDA0DD">Castle Rush</font>',
		'rush_cas04' => '<font color="#DDA0DD">Castle Rush</font>',
	);
?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			<title>
				Brawl Network - Character Battleground Profile
			</title>
			<link rel="stylesheet" type="text/css" href="./gaiaro.css">
			<script type="text/javascript" language="javascript" src="gaiaro.js"></script>
	    </head>
		<BODY style="margin-top:0; margin-bottom:0" background="world.jpg">
			<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="height:100%" width="780" align=center>
				<tr>
					<td colspan="3" valign="top" style="background:url(images/header.jpg); height:161px"></td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFC300">&nbsp;</td></tr>
				<tr>
					<td colspan="3" align="center" bgcolor="#FFC300">
<?php
						echo '<img src="./images/class/' . $data['sex'] . '/' . $data['class'] . '.gif">';
?>
					</td>
				</tr>
				<tr>
					<td rowspan="3" align="center" valign="middle" width="30%" bgcolor="#FFC300">
<?php
						echo '
							' . ($post > 0 ? '<img src="./images/rank/' . $post . '.png">':'') . '<br>
							<font color="#4169E1"><b>' . $Rank[$post] . '</b></font><br>
							<font size="1" color="#4169E1"><b>Elo. Rank : </b></font><font color="#A92207"><b>' . (isset($data['score'])?$data['score']:'0') . '</b></font>
						';
?>
					</td>
					<td align="center" bgcolor="#FFC300">
<?php
						echo '<font color="#A92207" size="2"><b>' . htmlformat($data['name']) . '<b></font>';
?>
					</td>
					<td rowspan="3" align="center" valign="middle" width="30%" bgcolor="#FFC300">
<?php
						echo '
							<img src="emblema.php?data=' . $data['guild_id'] . '" alt="."><br>
							<font color="#4169E1"><b>Member of</b></font><br>
							<font color="#A92207"><b>' . ( $data['gname'] == '' ? '-- no Guild --' : htmlformat($data['gname']) ) . '</b></font>
						';
?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" bgcolor="#FFC300">
<?php
						echo '<img src="./imgwm/' . $data['class'] . '.gif"><br>';
						echo '<font size="2" color="#4169E1"><b>' . $jobs[$data['class']] . '</b></font><br>';
						echo '<font color="#FF0000">' . $data['max_hp'] . '</font> / <font color="#0000FF">' . $data['max_sp'] . '</font>';
?>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFC300">&nbsp;</td></tr>
				<tr>
					<td style="height:25px" colspan="3" align="center" valign="middle" bgcolor="#A92207">
						<font color="#FFFFFF"><b>Week Medals</b></font>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td colspan="3" align="center" bgcolor="#FFFFFF">
<?php
					echo '
						1st Place <font size="2" color="#FFC300"><b>' . (isset($data['bg_gold'])?$data['bg_gold']:'0') . '</b></font> Gold - <img src="./images/rank/14.png"> - 2nd Place <font size="2" color="#00BFFF"><b>' . (isset($data['bg_silver'])?$data['bg_silver']:'0') . '</b></font> Silver - <img src="./images/rank/14.png"> - 3rd Place <font size="2" color="#A0522D"><b>' . (isset($data['bg_bronze'])?$data['bg_bronze']:'0') . '</b></font> Bronze<br>
					';
?>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td style="height:25px" colspan="3" align="center" valign="middle" bgcolor="#A92207">
						<font color="#FFFFFF"><b>Battleground Profile</b></font>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td colspan="3" align="center" bgcolor="#FFFFFF">
<?php
					echo '
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
								<td>' . (isset($data['win'])?$data['win']:'0') . '</td>
								<td>' . (isset($data['tie'])?$data['tie']:'0') . '</td>
								<td>' . (isset($data['lost'])?$data['lost']:'0') . '</td>
								<td>' . (isset($data['leader_win'])?$data['leader_win']:'0') . '</td>
								<td>' . (isset($data['leader_tie'])?$data['leader_tie']:'0') . '</td>
								<td>' . (isset($data['leader_lost'])?$data['leader_lost']:'0') . '</td>
							</tr>
						</table>
					';
?>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center" bgcolor="#FFFFFF">
<?php
					echo '
						<table width="540" border="0" cellpadding="0" cellspacing="1">
							<tr>
								<td colspan="6" bgcolor="#FFC300" width="50%" height="15" align="center" valign="middle"><font color="#A92207"><b>General Standings</b></font></td>
								<td colspan="6" bgcolor="#FFC300" width="50%" height="15" align="center" valign="middle"><font color="#A92207"><b>Damage</b></font></td>
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
								<td>' . (isset($data['kill_count'])?$data['kill_count']:'0') . '</td>
								<td>' . (isset($data['death_count'])?$data['death_count']:'0') . '</td>
								<td>' . (isset($data['deserter'])?$data['deserter']:'0') . '</td>
								<td>' . (isset($data['top_damage'])?$data['top_damage']:'0') . '</td>
								<td>' . (isset($data['damage_done'])?$data['damage_done']:'0') . '</td>
								<td>' . (isset($data['damage_received'])?$data['damage_received']:'0') . '</td>
							</tr>
						</table>
					';
?>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center" bgcolor="#FFFFFF">
<?php
					echo '
						<table width="400" border="0" cellpadding="0" cellspacing="1">
							<tr>
								<td colspan="4" bgcolor="#FFC300" width="50%" height="15" align="center" valign="middle"><font color="#A92207"><b>Skills Soporte</b></font></td>
								<td colspan="4" bgcolor="#FFC300" width="50%" height="15" align="center" valign="middle"><font color="#A92207"><b>Total Healing</b></font></td>
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
								<td>' . (isset($data['support_skills_used'])?$data['support_skills_used']:'0') . '</td>
								<td>' . (isset($data['wrong_support_skills_used'])?$data['wrong_support_skills_used']:'0') . '</td>
								<td>' . (isset($data['healing_done'])?$data['healing_done']:'0') . '</td>
								<td>' . (isset($data['wrong_healing_done'])?$data['wrong_healing_done']:'0') . '</td>
							</tr>
						</table>
					';
?>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center" bgcolor="#FFFFFF">
<?php
					echo '
						<table width="660" border="0" cellpadding="0" cellspacing="1">
							<tr>
								<td colspan="20" bgcolor="#FFC300" height="15" align="center" valign="middle"><font color="#A92207"><b>Usable Items</b></font></td>
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
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1752.png"></td>
								<td><font color="#4169E1"><b>Arrow</b></font></td>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7136.png"></td>
								<td><font color="#4169E1"><b>Bottle</b></font></td>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/678.png"></td>
								<td><font color="#4169E1"><b>Bottle</b></font></td>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7371.png"></td>
								<td><font color="#4169E1"><b>Spirit</b></font></td>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/676.png"></td>
								<td><font color="#4169E1"><b>Zeny</b></font></td>
							</tr>
							<tr>
								<td>' . (isset($data['hp_heal_potions'])?$data['hp_heal_potions']:'0') . '</td>
								<td>' . (isset($data['sp_heal_potions'])?$data['sp_heal_potions']:'0') . '</td>
								<td>' . (isset($data['yellow_gemstones'])?$data['yellow_gemstones']:'0') . '</td>
								<td>' . (isset($data['red_gemstones'])?$data['red_gemstones']:'0') . '</td>
								<td>' . (isset($data['blue_gemstones'])?$data['blue_gemstones']:'0') . '</td>
								<td>' . (isset($data['ammo_used'])?$data['ammo_used']:'0') . '</td>
								<td>' . (isset($data['acid_demostration'])?$data['acid_demostration']:'0') . '</td>
								<td>' . (isset($data['poison_bottles'])?$data['poison_bottles']:'0') . '</td>
								<td>' . (isset($data['spiritb_used'])?$data['spiritb_used']:'0') . '</td>
								<td>' . (isset($data['zeny_used'])?$data['zeny_used']:'0') . '</td>
							</tr>
						</table>
					';
?>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td style="height:25px" colspan="3" align="center" valign="middle" bgcolor="#A92207">
						<font color="#FFFFFF"><b>Battleground Arenas</b></font>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td colspan="3" align="center" bgcolor="#FFFFFF">
<?php
					echo '
						<table width="420" border="0" cellpadding="0" cellspacing="1">
							<tr>
								<td colspan="8" bgcolor="#4169E1" height="15" align="center" valign="middle"><font color="#FFC300"><b>Castle Conquest</b></font></td>
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
								<td>' . (isset($data['emperium_kill'])?$data['emperium_kill']:'0') . '</td>
								<td>' . (isset($data['barricade_kill'])?$data['barricade_kill']:'0') . '</td>
								<td>' . (isset($data['gstone_kill'])?$data['gstone_kill']:'0') . '</td>
								<td><font color="#4169E1"><b>W</b></font> ' . (isset($data['cq_wins'])?$data['cq_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> 0 <font color="#4169E1"><b>L</b></font> ' . (isset($data['cq_lost'])?$data['cq_lost']:'0') . '</td>
							</tr>
						</table>
					';
?>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td colspan="3" align="center" bgcolor="#FFFFFF">
<?php
					echo '
						<table width="760" border="0" cellpadding="0" cellspacing="1">
							<tr>
								<td colspan="6" bgcolor="#4169E1" width="35%" height="15" align="center" valign="middle"><font color="#FFC300"><b>Tierra EoS</b></font></td>
								<td colspan="8" bgcolor="#4169E1" width="40%" height="15" align="center" valign="middle"><font color="#FFC300"><b>Tierra Bossnia</b></font></td>
								<td colspan="4" bgcolor="#4169E1" width="25%" height="15" align="center" valign="middle"><font color="#FFC300"><b>Tierra TI</b></font></td>
							</tr>
							<tr>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7253.png"></td>
								<td><font color="#4169E1"><b>Flag</b></font></td>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7423.png"></td>
								<td><font color="#4169E1"><b>Base</b></font></td>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/658.png"></td>
								<td><font color="#4169E1"><b>Results</b></font></td>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/750.png"></td>
								<td><font color="#4169E1"><b>Damage</b></font></td>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/751.png"></td>
								<td><font color="#4169E1"><b>Kill</b></font></td>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7253.png"></td>
								<td><font color="#4169E1"><b>Flag</b></font></td>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/658.png"></td>
								<td><font color="#4169E1"><b>Results</b></font></td>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7005.png"></td>
								<td><font color="#4169E1"><b>Skulls</b></font></td>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/658.png"></td>
								<td><font color="#4169E1"><b>Results</b></font></td>
							</tr>
							<tr>
								<td>' . (isset($data['eos_flags'])?$data['eos_flags']:'0') . '</td>
								<td>' . (isset($data['eos_bases'])?$data['eos_bases']:'0') . '</td>
								<td><font color="#4169E1"><b>W</b></font> ' . (isset($data['eos_wins'])?$data['eos_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> ' . (isset($data['eos_tie'])?$data['eos_tie']:'0') . ' <font color="#4169E1"><b>L</b></font> ' . (isset($data['eos_lost'])?$data['eos_lost']:'0') . '</td>
								<td>' . (isset($data['boss_damage'])?$data['boss_damage']:'0') . '</td>
								<td>' . (isset($data['boss_killed'])?$data['boss_killed']:'0') . '</td>
								<td>' . (isset($data['boss_flags'])?$data['boss_flags']:'0') . '</td>
								<td><font color="#4169E1"><b>W</b></font> ' . (isset($data['boss_wins'])?$data['boss_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> ' . (isset($data['boss_tie'])?$data['boss_tie']:'0') . ' <font color="#4169E1"><b>L</b></font> ' . (isset($data['boss_lost'])?$data['boss_lost']:'0') . '</td>
								<td>' . (isset($data['skulls'])?$data['skulls']:'0') . '</td>
								<td><font color="#4169E1"><b>W</b></font> ' . (isset($data['ti_wins'])?$data['ti_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> ' . (isset($data['ti_tie'])?$data['ti_tie']:'0') . ' <font color="#4169E1"><b>L</b></font> ' . (isset($data['ti_lost'])?$data['ti_lost']:'0') . '</td>
							</tr>
						</table>
					';
?>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td colspan="3" align="center" bgcolor="#FFFFFF">
<?php
					echo '
						<table width="760" border="0" cellpadding="0" cellspacing="1">
							<tr>
								<td colspan="6" bgcolor="#4169E1" width="33%" height="15" align="center" valign="middle"><font color="#FFC300"><b>Flavius TDM</b></font></td>
								<td colspan="4" bgcolor="#4169E1" width="33%" height="15" align="center" valign="middle"><font color="#FFC300"><b>Flavius CTF</b></font></td>
								<td colspan="4" bgcolor="#4169E1" width="33%" height="15" align="center" valign="middle"><font color="#FFC300"><b>Flavius SC</b></font></td>
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
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/640.png"></td>
								<td><font color="#4169E1"><b>Stones</b></font></td>
								<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/658.png"></td>
								<td><font color="#4169E1"><b>Results</b></font></td>
							</tr>
							<tr>
								<td>' . (isset($data['td_kills'])?$data['td_kills']:'0') . '</td>
								<td>' . (isset($data['td_deaths'])?$data['td_deaths']:'0') . '</td>
								<td><font color="#4169E1"><b>W</b></font> ' . (isset($data['td_wins'])?$data['td_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> ' . (isset($data['td_tie'])?$data['td_tie']:'0') . ' <font color="#4169E1"><b>L</b></font> ' . (isset($data['td_lost'])?$data['td_lost']:'0') . '</td>
								<td><font color="#4169E1"><b>T</b></font> ' . (isset($data['ctf_taken'])?$data['ctf_taken']:'0') . ' <font color="#4169E1"><b>C</b></font> ' . (isset($data['ctf_captured'])?$data['ctf_captured']:'0') . ' <font color="#4169E1"><b>D</b></font> ' . (isset($data['ctf_droped'])?$data['ctf_droped']:'0') . '</td>
								<td><font color="#4169E1"><b>W</b></font> ' . (isset($data['ctf_wins'])?$data['ctf_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> ' . (isset($data['ctf_tie'])?$data['ctf_tie']:'0') . ' <font color="#4169E1"><b>L</b></font> ' . (isset($data['ctf_lost'])?$data['ctf_lost']:'0') . '</td>
								<td><font color="#4169E1"><b>S</b></font> ' . (isset($data['sc_stole'])?$data['sc_stole']:'0') . ' <font color="#4169E1"><b>C</b></font> ' . (isset($data['sc_captured'])?$data['sc_captured']:'0') . ' <font color="#4169E1"><b>D</b></font> ' . (isset($data['sc_droped'])?$data['sc_droped']:'0') . '</td>
								<td><font color="#4169E1"><b>W</b></font> ' . (isset($data['sc_wins'])?$data['sc_wins']:'0') . ' <font color="#4169E1"><b>T</b></font> ' . (isset($data['sc_tie'])?$data['sc_tie']:'0') . ' <font color="#4169E1"><b>L</b></font> ' . (isset($data['sc_lost'])?$data['sc_lost']:'0') . '</td>
							</tr>
						</table>
					';
?>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td style="height:25px" colspan="3" align="center" valign="middle" bgcolor="#A92207">
						<font color="#FFFFFF"><b>
<?php
	if( $sid > 0 )
		echo 'Top 20 ' . $skills[$sid] . ' Casters';
	else
		echo 'Top 10 Casted Skills';
?>
						</b></font>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td colspan="3" align="center" bgcolor="#FFFFFF">
<?php
	if( $sid == 0 )
	{
?>
						<table width="760" border="0" cellpadding="0" cellspacing="1">
							<tr>
								<td colspan="2" width="230" bgcolor="#8B0000" align="center" valign="middle"><font color="#FFFFFF"><b>Skill Name</b></font></td>
								<td bgcolor="#8B0000" width="20" align="center" valign="middle"><font color="#FFFFFF"><b>T</b></font></td>
								<td bgcolor="#8B0000" width="130" align="center" valign="middle"><font color="#FFFFFF"><b>Count</b></font></td>
								<td colspan="2" width="230" bgcolor="#8B0000" align="center" valign="middle"><font color="#FFFFFF"><b>Skill Name</b></font></td>
								<td bgcolor="#8B0000" width="20" align="center" valign="middle"><font color="#FFFFFF"><b>T</b></font></td>
								<td bgcolor="#8B0000" width="130" align="center" valign="middle"><font color="#FFFFFF"><b>Count</b></font></td>
							</tr>
<?php
		$result = $mysql->query("SELECT * FROM bg_skill_count WHERE char_id = '$char_id' ORDER BY `count` DESC LIMIT 10", $CONFIG['DBMain']);
		for( $i = 0; $i < 5; $i++ )
		{
			if( $skill = $mysql->fetcharray($result) )
			{
				echo '
							<tr>
								<td width="24"><img src="./images/skill/' . $skill['id'] . '.bmp"></td>
								<td>&nbsp;' . $skills[$skill['id']] . '</td>
								<td><a href="profile.php?cid=' . $data['char_id'] . '&sid=' . $skill['id'] . '"><img src="./images/casters.png" border="0"></a></td>
								<td align="center">' . $skill['count'] . '</td>
				';
			}
			else break;

			if( $skill = $mysql->fetcharray($result) )
			{
				echo '
								<td width="24"><img src="./images/skill/' . $skill['id'] . '.bmp"></td>
								<td>&nbsp;' . $skills[$skill['id']] . '</td>
								<td><a href="profile.php?cid=' . $data['char_id'] . '&sid=' . $skill['id'] . '"><img src="./images/casters.png" border="0"></a></td>
								<td align="center">' . $skill['count'] . '</td>
							</tr>
				';
			}
			else
			{
				echo '
								<td width="24">&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
				';
				break;
			}
		}
?>
						</table>
<?php
	}
	else
	{
?>
						<table width="690" border="0" cellpadding="0" cellspacing="1">
							<tr>
								<td bgcolor="#8B0000" width="30" align="center" valign="middle"><font color="#FFFFFF"><b>Pos</b></font></td>
								<td bgcolor="#8B0000" width="20" align="center" valign="middle"><font color="#FFFFFF"><b>P</b></font></td>
								<td bgcolor="#8B0000" width="250" align="center" valign="middle"><font color="#FFFFFF"><b>Caster</b></font></td>
								<td bgcolor="#8B0000" width="130" align="center" valign="middle"><font color="#FFFFFF"><b>Count</b></font></td>

								<td bgcolor="#8B0000" width="40" align="center" valign="middle"><font color="#FFFFFF"><b>Wins</b></font></td>
								<td bgcolor="#8B0000" width="40" align="center" valign="middle"><font color="#FFFFFF"><b>Tie</b></font></td>
								<td bgcolor="#8B0000" width="40" align="center" valign="middle"><font color="#FFFFFF"><b>Lost</b></font></td>
								<td bgcolor="#8B0000" width="50" align="center" valign="middle"><font color="#FFFFFF"><b>Total</b></font></td>
								<td bgcolor="#8B0000" width="50" align="center" valign="middle"><font color="#FFFFFF"><b>Rate</b></font></td>
								<td bgcolor="#8B0000" width="40" align="center" valign="middle"><font color="#FFFFFF"><b>Quit</b></font></td>
							</tr>
<?php
		$result = $mysql->query("
			SELECT
				`char`.`char_id`, `char`.`name`, `bg_skill_count`.`count`, `char_bg`.`win`, `char_bg`.`lost`, `char_bg`.`tie`, `char_bg`.`deserter`
			FROM
				`bg_skill_count` JOIN `char` ON `char`.`char_id` = `bg_skill_count`.`char_id` JOIN `char_bg` ON `char_bg`.`char_id` = `char`.`char_id`
			WHERE
				`bg_skill_count`.`id` = '$sid'
			ORDER BY
				`bg_skill_count`.`count` DESC
			LIMIT 20", $CONFIG['DBMain']);

		$count = 0;
		while( $skill = $mysql->fetcharray($result) )
		{
				$count++;
				$total = $skill['win'] + $skill['tie'] + $skill['lost'];


				echo '
							<tr>
								<td>' . ($char_id == $skill['char_id'] ? '<b>' . $count . '</b>' : $count) . '</td>
								<td><a href="profile.php?cid=' . $skill['char_id'] . '"><img src="./images/viewprofile.png" border="0"></a></td>
								<td>' . ($char_id == $skill['char_id'] ? '<b>' . htmlformat($skill['name']) . '</b>' : htmlformat($skill['name'])) . '</td>
								<td align="center">' . $skill['count'] . '</td>
								<td align="center">' . $skill['win'] . '</td>
								<td align="center">' . $skill['tie'] . '</td>
								<td align="center">' . $skill['lost'] . '</td>
								<td align="center"><font color="#A92207"><b>' . $total . '</b></font></td>
								<td align="center"><font color="#8B0000"><b>' . ($total > 0 ? intval($skill['count'] / $total) : "--") . '</b></font></td>
								<td align="center">' . $skill['deserter'] . '</td>
							</tr>
				';
		}
?>
						</table>
<?php
	}
?>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td style="height:25px" colspan="3" align="center" valign="middle" bgcolor="#A92207">
<?php
	if( $tar_id )
		echo '<font color="#FFFFFF"><b>Kill Log - Comparative</b></font>';
	else
		echo '<font color="#FFFFFF"><b>Kill Log - Last 40 Kills</b></font>';
?>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td colspan="3" align="center" bgcolor="#FFFFFF">
						<table width="760" border="0" cellpadding="0" cellspacing="1">
							<tr>
								<td bgcolor="#8B0000" width="150" align="center" valign="middle"><font color="#FFFFFF"><b>Date/Time</b></font></td>
								<td bgcolor="#8B0000" width="20" align="center" valign="middle"><font color="#FFFFFF"><b>P</b></font></td>
								<td bgcolor="#8B0000" width="20" align="center" valign="middle"><font color="#FFFFFF"><b>C</b></font></td>
								<td bgcolor="#8B0000" width="250" align="center" valign="middle"><font color="#FFFFFF"><b>Victim</b></font></td>
								<td bgcolor="#8B0000" width="150" align="center" valign="middle"><font color="#FFFFFF"><b>Map</b></font></td>
								<td colspan="2" bgcolor="#8B0000" align="center" valign="middle"><font color="#FFFFFF"><b>Attack</b></font></td>
							</tr>
<?php

	if( $tar_id )
		$result = $mysql->query("SELECT * FROM char_bg_log WHERE killer_id = '$char_id' AND killed_id = '$tar_id' ORDER BY `id` DESC LIMIT 100", $CONFIG['DBMain']);
	else
		$result = $mysql->query("SELECT * FROM char_bg_log WHERE killer_id = '$char_id' ORDER BY `id` DESC LIMIT 40", $CONFIG['DBMain']);

	while( $klog = $mysql->fetcharray($result) )
	{
		echo '
			<tr>
				<td>' . $klog['time'] . '</td>
				<td><a href="profile.php?cid=' . $klog['killed_id'] . '"><img src="./images/viewprofile.png" border="0"></a></td>
				<td><a href="profile.php?cid=' . $char_id . '&tid=' . $klog['killed_id'] . '"><img src="./images/compare.png" border="0"></a></td>
				<td>&nbsp;' . htmlformat($klog['killed']) . '</td>
				<td>' . $bgs[$klog['map']] . '</td>
		';
		if( $klog['skill'] > 0 )
		{
			echo '
				<td width="24"><img src="./images/skill/' . $klog['skill'] . '.bmp"</td>
				<td>&nbsp;' . $skills[$klog['skill']] . '</td>
			';
		}
		else
		{
			echo '
				<td width="24"><img src="./images/skill/107.bmp"</td>
				<td>&nbsp;Melee/Reflect/Effect</td>
			';
		}

		echo '
			</tr>
		';
	}
?>
						</table>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td style="height:25px" colspan="3" align="center" valign="middle" bgcolor="#A92207">
<?php
	if( $tar_id )
		echo '<font color="#FFFFFF"><b>Death Log - Comparative</b></font>';
	else
		echo '<font color="#FFFFFF"><b>Death Log - Last 40 Deaths</b></font>';
?>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td colspan="3" align="center" bgcolor="#FFFFFF">
						<table width="760" border="0" cellpadding="0" cellspacing="1">
							<tr>
								<td bgcolor="#8B0000" width="150" align="center" valign="middle"><font color="#FFFFFF"><b>Date/Time</b></font></td>
								<td bgcolor="#8B0000" width="20" align="center" valign="middle"><font color="#FFFFFF"><b>P</b></font></td>
								<td bgcolor="#8B0000" width="20" align="center" valign="middle"><font color="#FFFFFF"><b>C</b></font></td>
								<td bgcolor="#8B0000" width="250" align="center" valign="middle"><font color="#FFFFFF"><b>Assassin</b></font></td>
								<td bgcolor="#8B0000" width="150" align="center" valign="middle"><font color="#FFFFFF"><b>Map</b></font></td>
								<td colspan="2" bgcolor="#8B0000" align="center" valign="middle"><font color="#FFFFFF"><b>Attack</b></font></td>
							</tr>
<?php

	if( $tar_id )
		$result = $mysql->query("SELECT * FROM char_bg_log WHERE killed_id = '$char_id' AND killer_id = '$tar_id' ORDER BY `id` DESC LIMIT 100", $CONFIG['DBMain']);
	else
		$result = $mysql->query("SELECT * FROM char_bg_log WHERE killed_id = '$char_id' ORDER BY `id` DESC LIMIT 40", $CONFIG['DBMain']);

	while( $klog = $mysql->fetcharray($result) )
	{
		echo '
			<tr>
				<td>' . $klog['time'] . '</td>
				<td><a href="profile.php?cid=' . $klog['killer_id'] . '"><img src="./images/viewprofile.png" border="0"></a></td>
				<td><a href="profile.php?cid=' . $char_id . '&tid=' . $klog['killer_id'] . '"><img src="./images/compare.png" border="0"></a></td>
				<td>&nbsp;' . htmlformat($klog['killer']) . '</td>
				<td>' . $bgs[$klog['map']] . '</td>
		';
		if( $klog['skill'] > 0 )
		{
			echo '
				<td width="24"><img src="./images/skill/' . $klog['skill'] . '.bmp"</td>
				<td>&nbsp;' . $skills[$klog['skill']] . '</td>
			';
		}
		else
		{
			echo '
				<td width="24"><img src="./images/skill/107.bmp"</td>
				<td>&nbsp;Melee/Reflect/Effect</td>
			';
		}

		echo '
			</tr>
		';
	}
?>
						</table>
					</td>
				</tr>
				<tr><td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
				<tr>
					<td style="height:25px" colspan="3" align="center" valign="middle" bgcolor="#A92207">
						<font color="#FFFFFF"><b>Brawl Network - <a href="http://foro.brawlnetwork.net">http://foro.brawlnetwork.net</a> - Visit Us and Join the Real Battle </b></font>
					</td>
				</tr>
			</table>
		</body>
		<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
			var pageTracker = _gat._getTracker("UA-5821494-2");
			pageTracker._trackPageview();
		</script>
	</html>
