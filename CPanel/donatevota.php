<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

$remoteip = $_SERVER["REMOTE_ADDR"];
$usersesion = $_SESSION[$CONFIG_name.'account_id'];
DEFINE('CHECKTOP1', "SELECT * FROM `votaciones` WHERE (`account_id` = '".$usersesion."' OR `last_ip` = '".$remoteip."') AND `top_id` = '1' AND `vote_state` = '1'");
DEFINE('CHECKTOP2', "SELECT * FROM `votaciones` WHERE (`account_id` = '".$usersesion."' OR `last_ip` = '".$remoteip."') AND `top_id` = '2' AND `vote_state` = '1'");
DEFINE('INSERTVOTOS1', "INSERT INTO `votaciones` (`account_id`, `last_ip`, `top_id`, `vote_state`) VALUES ('".$usersesion."', '".$remoteip."', '1', '1')");
DEFINE('INSERTVOTOS2', "INSERT INTO `votaciones` (`account_id`, `last_ip`, `top_id`, `vote_state`) VALUES ('".$usersesion."', '".$remoteip."', '2', '1')");
DEFINE('VOTOPUNTOS', "UPDATE `login` SET `votepuntos` = `votepuntos` + '20' WHERE `account_id` = '".$usersesion."'");
DEFINE('VOTORANK', "UPDATE `login` SET `voterank` = `voterank` + '1' WHERE `account_id` = '".$usersesion."'");
DEFINE('COINCANJEADA', "UPDATE `login` SET `votepuntos` = `votepuntos` - '1000' WHERE `account_id` = '".$usersesion."'");
DEFINE('CHECKPUNTOS', "SELECT `votepuntos` FROM `login` WHERE `account_id` = '".$usersesion."'");
DEFINE('ITEMBRAWL', "INSERT INTO `storage` (`account_id`, `nameid`, `amount`, `identify`) VALUES ('".$usersesion."', '21002', '1', '1')");

if (!empty($_SESSION[$CONFIG_name.'account_id'])) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {

if (isset($_POST['votecoin']) && $_POST['votecoin'] == 5) {
	if (is_online()) {
	//redir("donatevota.php", "main_div", "Para Canjear la Deviling Coin tu cuenta debe estar DESLOGUEADA primero.");
	alert("Para Canjear la Deviling Silver Coin tu cuenta debe estar DESLOGUEADA primero."); }
	$querych4 = sprintf(CHECKPUNTOS);
	$resultch4 = execute_query($querych4, "donatevota.php");
	$checkpuntos = $resultch4->fetch_row();
	if ($checkpuntos[0] >= 1000) {
	$querycoin = sprintf(ITEMBRAWL);
	$resultcoin = execute_query($querycoin, "donatevota.php");
	$querych5 = sprintf(COINCANJEADA);
	$resultch5 = execute_query($querych5, "donatevota.php");
	redir("donatevota.php", "main_div", "Deviling Coin canjeada con exito en tu STORAGE.");
	} else { alert("No posees Puntos suficientes para canjear 1 Deviling Coin."); }
}

if (isset($_POST['votetop1']) && $_POST['votetop1'] == 1) {

	$queryc1 = sprintf(CHECKTOP1);
	$resultc1 = execute_query($queryc1, "donatevota.php");
	if ($resultc1->fetch_row()) alert("Ya has votado en este TOP, no puedes volver a adquirir puntos sino dentro de 24 horas.");

	$queryr1 = sprintf(INSERTVOTOS1);
	$resultr1 = execute_query($queryr1, "donatevota.php");
	$queryp1 = sprintf(VOTOPUNTOS);
	$resultp1 = execute_query($queryp1, "donatevota.php");
	$queryrk1 = sprintf(VOTORANK);
	$resultrk1 = execute_query($queryrk1, "donatevota.php");
	redir("donatevota.php", "main_div", "Has votado en este TOP con exito y recibiste tus 20 puntos de recompensa.");
}

if (isset($_POST['votetop2']) && $_POST['votetop2'] == 2) {

	$queryc2 = sprintf(CHECKTOP2);
	$resultc2 = execute_query($queryc2, "donatevota.php");
	if ($resultc2->fetch_row()) alert("Ya has votado en este TOP, no puedes volver a adquirir puntos sino dentro de 24 horas.");

	$queryr2 = sprintf(INSERTVOTOS2);
	$resultr2 = execute_query($queryr2, "donatevota.php");
	$queryp2 = sprintf(VOTOPUNTOS);
	$resultp2 = execute_query($queryp2, "donatevota.php");
	$queryrk2 = sprintf(VOTORANK);
	$resultrk2 = execute_query($queryrk2, "donatevota.php");
	redir("donatevota.php", "main_div", "Has votado en este TOP con exito y recibiste tus 20 puntos de recompensa.");
}

	$queryc1 = sprintf(CHECKTOP1);
	$resultc1 = execute_query($queryc1, "donatevota.php");
	$queryc2 = sprintf(CHECKTOP2);
	$resultc2 = execute_query($queryc2, "donatevota.php");
	$querych4 = sprintf(CHECKPUNTOS);
	$resultch4 = execute_query($querych4, "donatevota.php");
	$checkpuntos = $resultch4->fetch_row();

	opentable("Panel de Votaciones");

?>
<br/><center><b><font color="Black">Este sistema de votaciones funciona unicamente cada 24 horas por TOP a votar, asi cambien de cuenta o de IP no van a poder adquirir sus puntos de recompensas mas de 1 vez al dia.</font></b></center><br /><br />

<center>
<form id="donatevota1" onSubmit="return POST_ajax('donatevota.php','main_div','donatevota1');">
<input type="image" src="http://brawlnetwork.net/cp/images/VotaYaporBrawlRO.png" name="vote1" value="1" onclick="window.location='http://top.ragnarokonline.es/index.php?a=in&u=Salvador'" target="main">
<br />
<?php
if ($resultc1->fetch_row()) { echo "<b><font color=\"red\" size=3>VOTADO</font></b>"; } else { echo "<b><font color=\"green\" size=3>SIN VOTAR</font></b>"; }
?>
<input type="hidden" name="votetop1" value="1">
</form><br />
<form id="donatevota2" onSubmit="return POST_ajax('donatevota.php','main_div','donatevota2');">
<input type="image" src="http://www.top.valkyrie-online.net/images/banner.jpg" name="vote2" value="2" onclick="window.location='http://top.valkyrie-online.net/index.php?a=in&u=Salvador'" target="main">
<br />
<?php
if ($resultc2->fetch_row()) { echo "<b><font color=\"red\" size=3>VOTADO</font></b>"; } else { echo "<b><font color=\"green\" size=3>SIN VOTAR</font></b>"; }
?>
<input type="hidden" name="votetop2" value="2">
</form><br />
<br /></center>
<center><b><font color="Black" size="3">Puntos acumulados en la cuenta: <font color="Red">
<?php
if ($checkpuntos){ echo $checkpuntos[0]; }
?>
</font></font></b></center>
<br /><br />
<form id="donatecanjeo" onSubmit="return POST_ajax('donatevota.php','main_div','donatecanjeo');">
<center><input type="submit" value="Canjear Deviling Coin"><input type="hidden" name="votecoin" value="5"></center>
</form>
<br /><br /><center><b><font color="Black" size="3">Recompensa: 20 puntos por TOP.<br />1000 puntos = 1 Deviling Coin.<br /><br />Las Coins se almacenan directamente en tu Storage, tu cuenta debe estar DESLOGUEADA antes de canjear.</font></b></center><br /><br />
<?php
	closetable();
	}
	fim();
}
?>