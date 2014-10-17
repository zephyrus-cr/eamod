<?php

	session_start();
	include_once 'config2.php';
	include_once 'functions2.php';

	$castles = $_SESSION[$CONFIG['Name'] . 'castles'];

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

	$SortType = array(
		"defensive_score",
		"offensive_score",
		"posesion_time",
		"capture",
		"emperium",
		"treasure",
		"top_eco",
		"top_def",
		"invest_eco",
		"invest_def",
		"zeny_eco",
		"zeny_def",
		"skill_battleorder",
		"skill_regeneration",
		"skill_restore",
		"skill_emergencycall",
		"off_kill",
		"off_death",
		"def_kill",
		"def_death",
		"ext_kill",
		"ext_death",
		"ali_kill",
		"ali_death",
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

	function calc_posesion_time($time)
	{
		$days = intval($time / 86400);
		$time -= $days * 86400;

		$hour = intval($time / 3600);
		$time -= $hour * 3600;

		$minute = intval($time / 60);
		$time -= $minute * 60;

		$second = $time;

		$days = $days > 0 ? $days : 0;
		$hour = $hour > 0 ? $hour : 0;
		$minute = $minute > 0 ? $minute : 0;
		$second = $second > 0 ? $second : 0;

		return sprintf("%02d:%02d:%02d", $hour, $minute, $second);
	}

	if( !isset($_GET['opt']) )
	{
		echo '
			<div class="ladder_class">
		';

		opentable('War of Emperium - Castle Ranking');

		echo '
			<table width="580">
				<tr>
					<td align="center">
						<form id="ladder" onsubmit="return GET_ajax(\'castles.php\',\'ladder_div\',\'ladder\');">
							<select name="opt">
								<option selected value="0">All Castles</option>
		';

		$i = 0;
		$j = 1;
		while( isset($castles[$i]) )
		{
			echo "<option value=\"$j\">$castles[$i]</option>";
			$i++;
			$j++;
		}

		echo '
							</select>
							&nbsp;
							<select name="ser">
								<option selected value="0">Defensive</option>
								<option value="1">Ofensive</option>
								<option value="2">Possesion Time</option>
								<option value="3">Final Castle Capture</option>
								<option value="4">Captured Emperiums</option>
								<option value="5">Open Treasures</option>
								<option value="6">Best Economy</option>
								<option value="7">Best Defense</option>
								<option value="8">Total Economy Investment</option>
								<option value="9">Total Defense Investment</option>
								<option value="10">Zeny on Economy</option>
								<option value="11">Zeny on Defense</option>
								<option value="12">Skill BattleOrder</option>
								<option value="13">Skill Regeneration</option>
								<option value="14">Skill Restore</option>
								<option value="15">Skill Emergency Call</option>
								<option value="16">Offensive Kills</option>
								<option value="17">Offensive Deaths</option>
								<option value="18">Defensive Kills</option>
								<option value="19">Defensive Deaths</option>
								<option value="20">Extra Kills</option>
								<option value="21">Extra Deaths</option>
								<option value="22">Alliance Kills</option>
								<option value="23">Alliance Deaths</option>
							</select>
							&nbsp;
							<input type="submit" value="Buscar">
						</form>
					</td>
				</tr>
				<tr>
				<td align="center">Muestra el Rank de todos los Castillos que Mejor han sido defendidos </td></tr>
			</table>
			<div id="ladder_div" style="color:#000000">
		';

		$begin = 1;
		$_GET['opt'] = 0;
		$_GET['ser'] = 0;
	}

	if( $_GET['opt'] == 0 )
	{ // All Castles
		$query = "
			SELECT
				`g`.`name`, `g`.`master`, `g`.`emblem_data`, `gr`.*
			FROM
				`guild` `g`, `guild_rank` `gr`, (
					SELECT
						`castle_id`, MAX(`" . $SortType[$_GET['ser']] . "`) AS `t" . $SortType[$_GET['ser']] . "`
					FROM
						`guild_rank`
					WHERE
						" . ( ( $_GET['ser'] != 1 ) ? "`" . $SortType[$_GET['ser']] . "` > 0" : "`off_kill` + `def_kill` + `ext_kill` + `ali_kill` > 100" ) . "
					GROUP BY
						`castle_id`
				) `tgr`
			WHERE
				`g`.`guild_id` = `gr`.`guild_id` AND `gr`.`castle_id` = `tgr`.`castle_id` AND `gr`.`" . $SortType[$_GET['ser']] . "` = `tgr`.`t" . $SortType[$_GET['ser']] . "`
			ORDER BY
				`gr`.`castle_id` DESC
		";
	}
	else
	{ // Per Castle - Top 25
		$castle_id = $_GET['opt'] - 1;
		$query = "
			SELECT
				`guild`.`name`, `guild`.`master`, `guild`.`emblem_data`, `guild_rank`.*
			FROM
				`guild` LEFT JOIN `guild_rank` ON `guild_rank`.`guild_id` = `guild`.`guild_id`
			WHERE
				`guild_rank`.`castle_id` = '$castle_id' AND 
				" . ( ( $_GET['ser'] != 1 ) ? "`guild_rank`.`" . $SortType[$_GET['ser']] . "` > 0" : "`guild_rank`.`off_kill` + `guild_rank`.`def_kill` + `guild_rank`.`ext_kill` + `guild_rank`.`ali_kill` > 100 " ) . "
			ORDER BY
				`guild_rank`.`" . $SortType[$_GET['ser']] . "` DESC
			LIMIT 25
		";
	}

	$mydata = $mysql->query($query, $CONFIG['DBMain']);
	$castle_id = -1;
	/* Build Data */
	while( $data = $mysql->fetcharray($mydata) )
	{
		$emblems[$data['guild_id']] = $data['emblem_data'];
		$post = calc_rank($data['offensive_score']);
		
		if( $castle_id != $data['castle_id'] )
		{ // Post Image
			echo '<center><img src="./images/castle_icon.jpg"><br>
			<font size="2" color="#47bcff"><b>~ ' . $castles[$data['castle_id']] . ' ~<b></font><br><br></center>';
			$castle_id = $data['castle_id'];
		}

		echo '
			<table witdh="580" border="1" cellpadding="0" cellspacing="0" bordercolor="#c4c4c4">
				<tr>
					<td>
						<table width="580" border="0" cellpadding="0" cellspacing="0" bgcolor="#919191">
							<tr>
								<td width="36" height="36" rowspan="2" align="center" valign="middle">
									<img src="emblema.php?data=' . $data['guild_id'] . '" alt=".">
								</td>
								<td>
									<font color="#FFFFFF" size="3"><b>' . htmlformat($data['name']) . '<b></font>
								</td>
								<td width="300" align="right" valign="middle">
									<font size="2" color="#FFFFFF"><b>' . $castles[$data['castle_id']] . '<b></font>&nbsp;
								</td>
							</tr>
							<tr>
								<td>
									<font color="#47bcff"><b>' . htmlformat($data['master']) . '</b></font>
								</td>
								<td align="right">
									<font color="#47bcff"><b>' . calc_posesion_time($data['posesion_time']) . '</b>&nbsp;</font>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">
						<table width="580" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center" valign="middle">
									<table width="580" border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td>
												<table width="580" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="10" bgcolor="#7c7c7c" height="15" align="center" valign="middle"><font color="#FFFFFF"><b>Global Guild Standings</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/13411.png"></td>
														<td><font color="#D0D0D0"><b>Offensive Score</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/2122.png"></td>
														<td><font color="#D0D0D0"><b>Defensive Score</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/2733.png"></td>
														<td><font color="#D0D0D0"><b>Final Captures</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/714.png"></td>
														<td><font color="#D0D0D0"><b>Emperiums</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7444.png"></td>
														<td><font color="#D0D0D0"><b>Treasures</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($data['offensive_score'])?$data['offensive_score']:'0') . '</td>
														<td>' . (isset($data['defensive_score'])?$data['defensive_score']:'0') . '</td>
														<td>' . (isset($data['capture'])?$data['capture']:'0') . '</td>
														<td>' . (isset($data['emperium'])?$data['emperium']:'0') . '</td>
														<td>' . (isset($data['treasure'])?$data['treasure']:'0') . '</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width="580" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="4" bgcolor="#7c7c7c" height="15" align="center" valign="middle"><font color="#FFFFFF"><b>Economy Stats</b></font></td>
														<td colspan="4" bgcolor="#7c7c7c" height="15" align="center" valign="middle"><font color="#FFFFFF"><b>Defense Stats</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/670.png"></td>
														<td><font color="#D0D0D0"><b>Top Eco</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/674.png"></td>
														<td><font color="#D0D0D0"><b>Invest Eco</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/2125.png"></td>
														<td><font color="#D0D0D0"><b>Top Def</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/2107.png"></td>
														<td><font color="#D0D0D0"><b>Invest Def</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($data['top_eco'])?$data['top_eco']:'0') . '</td>
														<td>' . (isset($data['invest_eco'])?$data['invest_eco']:'0') . '</td>
														<td>' . (isset($data['top_def'])?$data['top_def']:'0') . '</td>
														<td>' . (isset($data['invest_def'])?$data['invest_def']:'0') . '</td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7338.png"></td>
														<td colspan="3"><font color="#D0D0D0"><b>Total Zeny Eco</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7338.png"></td>
														<td colspan="3"><font color="#D0D0D0"><b>Total Zeny Def</b></font></td>
													</tr>
													<tr>
														<td colspan="3">' . (isset($data['zeny_eco'])?$data['zeny_eco']:'0') . '</td>
														<td colspan="3">' . (isset($data['zeny_def'])?$data['zeny_def']:'0') . '</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width="580" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="8" bgcolor="#7c7c7c" height="15" align="center" valign="middle"><font color="#FFFFFF"><b>Guild Skill Usage</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/686.png"></td>
														<td><font color="#D0D0D0"><b>Battle Order</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/688.png"></td>
														<td><font color="#D0D0D0"><b>Regeneration</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/690.png"></td>
														<td><font color="#D0D0D0"><b>Restore</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/692.png"></td>
														<td><font color="#D0D0D0"><b>Emergency Call</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($data['skill_battleorder'])?$data['skill_battleorder']:'0') . '</td>
														<td>' . (isset($data['skill_regeneration'])?$data['skill_regeneration']:'0') . '</td>
														<td>' . (isset($data['skill_restore'])?$data['skill_restore']:'0') . '</td>
														<td>' . (isset($data['skill_emergencycall'])?$data['skill_emergencycall']:'0') . '</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width="580" border="0" cellpadding="0" cellspacing="1">
													<tr>
														<td colspan="4" bgcolor="#7c7c7c" height="15" align="center" valign="middle"><font color="#FFFFFF"><b>Kill Counter</b></font></td>
														<td colspan="4" bgcolor="#7c7c7c" height="15" align="center" valign="middle"><font color="#FFFFFF"><b>Death Counter</b></font></td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1213.png"></td>
														<td><font color="#D0D0D0"><b>Offensive</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1213.png"></td>
														<td><font color="#D0D0D0"><b>Defensive</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7005.png"></td>
														<td><font color="#D0D0D0"><b>Offensive</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7005.png"></td>
														<td><font color="#D0D0D0"><b>Defensive</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($data['off_kill'])?$data['off_kill']:'0') . '</td>
														<td>' . (isset($data['def_kill'])?$data['def_kill']:'0') . '</td>
														<td>' . (isset($data['off_death'])?$data['off_death']:'0') . '</td>
														<td>' . (isset($data['def_death'])?$data['def_death']:'0') . '</td>
													</tr>
													<tr>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1213.png"></td>
														<td><font color="#D0D0D0"><b>Alliance</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/1213.png"></td>
														<td><font color="#D0D0D0"><b>Extra</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7005.png"></td>
														<td><font color="#D0D0D0"><b>Alliance</b></font></td>
														<td width="28" rowspan="2" align="center" valign="middle"><img src="./images/item/small/7005.png"></td>
														<td><font color="#D0D0D0"><b>Extra</b></font></td>
													</tr>
													<tr>
														<td>' . (isset($data['ali_kill'])?$data['ali_kill']:'0') . '</td>
														<td>' . (isset($data['ext_kill'])?$data['ext_kill']:'0') . '</td>
														<td>' . (isset($data['ali_death'])?$data['ali_death']:'0') . '</td>
														<td>' . (isset($data['ext_death'])?$data['ext_death']:'0') . '</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<br><br>
		';
	}

	/* Build Data */
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