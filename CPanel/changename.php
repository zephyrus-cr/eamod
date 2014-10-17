<?php

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

DEFINE('CHAR_GET_NAMESN', "SELECT `char_id`, `char_num`, `name`, `zeny`, `base_level`, `job_level`, 
`last_map` FROM `char` WHERE `account_id` = '%d' and `online`=0 and `char_id` not in (select 
`char_id` FROM `sc_data` where type=249 and `account_id` = '%d') ORDER BY 
`char_num`");

if (!empty($_SESSION[$CONFIG_name.'account_id'])) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {
		
	if (isset($POST_opt)) {

	DEFINE('UPZENAME', "UPDATE `char` SET `name` = '".$POST_newname."', `zeny` = `zeny` - '2000000' WHERE `char_id` = '".$POST_charid."'");
	DEFINE('LOGNAMECHANGE', "INSERT INTO `log_namechange` (`fecha`, `old_name`, `new_name`) VALUES (NOW(), '".$POST_oldname."', '".$POST_newname."')");
	DEFINE('CHECKGUILDGL', "SELECT `master` FROM `guild` WHERE `master` = '".$POST_oldname."'");
	DEFINE('CHANGEGUILDGL', "UPDATE `guild` SET `master` = '".$POST_newname."' WHERE `master` = '".$POST_oldname."'");
	DEFINE('CHANGEGUILDGLM', "UPDATE `guild_member` SET `name` = '".$POST_newname."' WHERE `name` = '".$POST_oldname."'");
	DEFINE('CHECK_NEWNAMECOUNT', "SELECT `name` FROM `char` WHERE `name` LIKE '%%".$POST_newname."%%'");

				if ($POST_newname == "")
					alert("No puedes escribir nombres vacios.");
				if (is_online())
					alert("Necesitas estar desconectado del juego primero.");
				if ($POST_zenycheck < 2000000)
					alert("No posees zenys suficientes para cambiar tu nombre.");
				$querync = sprintf(CHECK_NEWNAMECOUNT, trim($POST_newname));
				$resultnc = execute_query($querync, 'changename.php');
				if ($resultnc->count())
					alert("El nuevo nombre colocado ya está en uso, favor intente con otro.");

				$querychkgl = sprintf(CHECKGUILDGL);
				$resultchkgl = execute_query($querychkgl, "changename.php");

				if (!($checarnamegl = $resultchkgl->fetch_row())){
				$queryupzn = sprintf(UPZENAME);
				$resultUPZN = execute_query($queryupzn, "changename.php");
				$querylogzn = sprintf(LOGNAMECHANGE);
				$resultlogzn = execute_query($querylogzn, "changename.php");
				redir("changename.php", "main_div", "Nombre cambiado con exito.<br/>Click para regresar.");
				} else {
				$querycnggl = sprintf(CHANGEGUILDGL);
				$resultcnggl = execute_query($querycnggl, "changename.php");
				$querycngglm = sprintf(CHANGEGUILDGLM);
				$resultcngglm = execute_query($querycngglm, "changename.php");
				$queryupzn = sprintf(UPZENAME);
				$resultUPZN = execute_query($queryupzn, "changename.php");
				$querylogzn = sprintf(LOGNAMECHANGE);
				$resultlogzn = execute_query($querylogzn, "changename.php");
				redir("changename.php", "main_div", "Nombre cambiado con exito.<br/>Click para regresar.");
				}
	}

		$query = sprintf(CHAR_GET_NAMESN, $_SESSION[$CONFIG_name.'account_id'], $_SESSION[$CONFIG_name.'account_id']);
		$result = execute_query($query, "changename.php");

		if ($result->count() < 1)
			redir("motd.php", "main_div", $lang['ONE_CHAR']);

		opentable("Cambiar Nombre");
		echo "
		<table width=\"600\">
		<tr>
			<td align=\"right\" class=\"head\">".$lang['SLOT']."</td>
			<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
			<td align=\"left\" class=\"head\">Zeny</td>
			<td align=\"center\" class=\"head\">".$lang['POSITION_LEVEL']."</td>
			<td align=\"left\" class=\"head\">".$lang['MAP']."</td>
			<td align=\"center\" class=\"head\">Escribe tu nuevo nombre</td>
		</tr>
		";
		while ($line = $result->fetch_row()) {
			$GID = $line[0];
			$slot = $line[1];
			$charname = htmlformat($line[2]);
			$czeny = $line[3];
			$clevel = $line[4];
			$joblevel = $line[5];
			$lastmap = $line[6];
			echo "    
			<tr>
				<td align=\"right\">$slot</td>
				<td align=\"left\">$charname</td>
				<td align=\"left\">$czeny</td>
				<td align=\"center\">$clevel/$joblevel</td>
				<td align=\"left\">$lastmap</td>
				<td align=\"center\">
				<form id=\"namewrite$slot\" onsubmit=\"return POST_ajax('changename.php','main_div','namewrite$slot')\">
					<input type=\"text\" name=\"newname\" maxlength=\"17\" onkeypress=\"return val(event)\">
					<input type=\"submit\" name=\"opt\" value=\"Cambiar Nombre\">
					<input type=\"hidden\" name=\"charid\" value=\"$GID\">
					<input type=\"hidden\" name=\"zenycheck\" value=\"$czeny\">
					<input type=\"hidden\" name=\"oldname\" value=\"$charname\">
				</form></td>
			</tr>
			";
		}
		echo "</table><BR />";
		echo "<h3><center>Para cambiar el nombre del Char necesitas tener minimo 2000000 Zenys en el.</center></h3>";
		closetable();
	}
	fim();
}

alert($lang['NEED_TO_LOGIN']);
?>