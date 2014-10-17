<?php

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

DEFINE('SEXZENY', "SELECT `char_id`, `char_num`, `name`, `zeny`, `base_level`, `job_level`, 
`last_map` FROM `char` WHERE `account_id` = '%d' and `online`=0 and `char_id` not in (select 
`char_id` FROM `sc_data` where type=249 and `account_id` = '%d') ORDER BY 
`char_num`");

DEFINE('SEXCH', "SELECT `sex` FROM `login` WHERE `account_id` = '".$_SESSION[$CONFIG_name.'account_id']."'");

$querysex = sprintf(SEXCH);
$resultsex = execute_query($querysex, "changesex.php");
$accsex = $resultsex->fetch_row();
$sexo = $accsex[0];

if (!empty($_SESSION[$CONFIG_name.'account_id'])) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {
		
	if (isset($POST_opt)) {

	DEFINE('UPZENSEX', "UPDATE `char` SET `zeny` = `zeny` - '2000000' WHERE `char_id` = '".$POST_charid."'");

				if (is_online())
					alert("Necesitas estar desconectado del juego primero.");
				if ($POST_zenycheck < 2000000)
					alert("No posees zenys suficientes para cambiar tu sexo.");

				if (!strcmp($sexo, "M")) {
				DEFINE('SEXCAMBIO1', "UPDATE `login` SET `sex` = 'F' WHERE `account_id` = '".$_SESSION[$CONFIG_name.'account_id']."'");
				$querychsx1 = sprintf(SEXCAMBIO1);
				$resultchsx1 = execute_query($querychsx1, "changesex.php"); }
				elseif (!strcmp($sexo, "F")) {
				DEFINE('SEXCAMBIO2', "UPDATE `login` SET `sex` = 'M' WHERE `account_id` = '".$_SESSION[$CONFIG_name.'account_id']."'");
				$querychsx2 = sprintf(SEXCAMBIO2);
				$resultchsx2 = execute_query($querychsx2, "changesex.php"); }
				$queryupzn = sprintf(UPZENSEX);
				$resultUPZN = execute_query($queryupzn, "changesex.php");
				redir("changesex.php", "main_div", "Sexo de la cuenta cambiado con exito. Click para regresar.");
	}

		$query = sprintf(SEXZENY, $_SESSION[$CONFIG_name.'account_id'], $_SESSION[$CONFIG_name.'account_id']);
		$result = execute_query($query, "changesex.php");

		if ($result->count() < 1)
			redir("motd.php", "main_div", $lang['ONE_CHAR']);

		opentable("Cambiar Sexo");
		echo "
		<table align=\"center\" width=\"400\"><tr><td align=\"left\"><b><h3>Sexo Actual de Cuenta:</h3></b></td>";
		if (!strcmp($sexo, "M"))
			{	echo "<td align=\"left\"><h3>Masculino <img src=\"M.gif\"></h3></td>";	}
		if (!strcmp($sexo, "F"))
			{	echo "<td align=\"left\"><h3>Femenino <img src=\"F.gif\"></h3></td>";	}
		echo "</tr></table><BR />
		<table align=\"center\" width=\"600\">
		<tr>
			<td align=\"right\" class=\"head\">".$lang['SLOT']."</td>
			<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
			<td align=\"left\" class=\"head\">Zeny</td>
			<td align=\"center\" class=\"head\">".$lang['POSITION_LEVEL']."</td>
			<td align=\"left\" class=\"head\">".$lang['MAP']."</td>
			<td align=\"center\" class=\"head\">Seleccionar</td>
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
				<form id=\"namewrite$slot\" onsubmit=\"return POST_ajax('changesex.php','main_div','namewrite$slot')\">
					<input type=\"submit\" name=\"opt\" value=\"Cambiar Sexo\">
					<input type=\"hidden\" name=\"charid\" value=\"$GID\">
					<input type=\"hidden\" name=\"zenycheck\" value=\"$czeny\">
				</form></td>
			</tr>
			";
		}
		echo "</table><BR />";
		echo "<h3><center>Para cambiar el Sexo de la Cuenta necesitas tener minimo 2000000 Zenys en un Char y luego seleccionarlo.</center></h3>";
		closetable();
	}
	fim();
}

alert($lang['NEED_TO_LOGIN']);
?>
