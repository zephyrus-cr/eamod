<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

DEFINE('GMBLOCK11', "UPDATE `login` SET `state` = '5' WHERE `account_id` = '2000000'");
DEFINE('GMBLOCK12', "UPDATE `login` SET `state` = '0' WHERE `account_id` = '2000000'");
DEFINE('GMBLOCK21', "UPDATE `login` SET `state` = '5' WHERE `account_id` = '2000001'");
DEFINE('GMBLOCK22', "UPDATE `login` SET `state` = '0' WHERE `account_id` = '2000001'");
DEFINE('GMBLOCK31', "UPDATE `login` SET `state` = '5' WHERE `account_id` = '2000002'");
DEFINE('GMBLOCK32', "UPDATE `login` SET `state` = '0' WHERE `account_id` = '2000002'");
DEFINE('GMBLOCK41', "UPDATE `login` SET `state` = '5' WHERE `account_id` = '2000003'");
DEFINE('GMBLOCK42', "UPDATE `login` SET `state` = '0' WHERE `account_id` = '2000003'");
DEFINE('GMBLOCK51', "UPDATE `login` SET `state` = '5' WHERE `account_id` = '2000004'");
DEFINE('GMBLOCK52', "UPDATE `login` SET `state` = '0' WHERE `account_id` = '2000004'");
DEFINE('GMBLOCK61', "UPDATE `login` SET `state` = '5' WHERE `account_id` = '2000005'");
DEFINE('GMBLOCK62', "UPDATE `login` SET `state` = '0' WHERE `account_id` = '2000005'");
DEFINE('GMBLOCK71', "UPDATE `login` SET `state` = '5' WHERE `account_id` = '2000006'");
DEFINE('GMBLOCK72', "UPDATE `login` SET `state` = '0' WHERE `account_id` = '2000006'");
DEFINE('GMBLOCK81', "UPDATE `login` SET `state` = '5' WHERE `account_id` = '2000007'");
DEFINE('GMBLOCK82', "UPDATE `login` SET `state` = '0' WHERE `account_id` = '2000007'");
DEFINE('GMBLOCK91', "UPDATE `login` SET `state` = '5' WHERE `account_id` = '2009476'");
DEFINE('GMBLOCK92', "UPDATE `login` SET `state` = '0' WHERE `account_id` = '2009476'");
DEFINE('GMBLOCK101', "UPDATE `login` SET `state` = '5' WHERE `account_id` = '2007985'");
DEFINE('GMBLOCK102', "UPDATE `login` SET `state` = '0' WHERE `account_id` = '2007985'");
DEFINE('GMCHECK1', "SELECT * FROM `login` WHERE `account_id` = '2000000' AND `state` = '5'");
DEFINE('GMCHECK2', "SELECT * FROM `login` WHERE `account_id` = '2000001' AND `state` = '5'");
DEFINE('GMCHECK3', "SELECT * FROM `login` WHERE `account_id` = '2000002' AND `state` = '5'");
DEFINE('GMCHECK4', "SELECT * FROM `login` WHERE `account_id` = '2000003' AND `state` = '5'");
DEFINE('GMCHECK5', "SELECT * FROM `login` WHERE `account_id` = '2000004' AND `state` = '5'");
DEFINE('GMCHECK6', "SELECT * FROM `login` WHERE `account_id` = '2000005' AND `state` = '5'");
DEFINE('GMCHECK7', "SELECT * FROM `login` WHERE `account_id` = '2000006' AND `state` = '5'");
DEFINE('GMCHECK8', "SELECT * FROM `login` WHERE `account_id` = '2000007' AND `state` = '5'");
DEFINE('GMCHECK9', "SELECT * FROM `login` WHERE `account_id` = '2009476' AND `state` = '5'");
DEFINE('GMCHECK10', "SELECT * FROM `login` WHERE `account_id` = '2007985' AND `state` = '5'");
DEFINE('GMRCHECK1', "SELECT * FROM `login` WHERE `account_id` = '2000000' AND `state` = '0'");
DEFINE('GMRCHECK2', "SELECT * FROM `login` WHERE `account_id` = '2000001' AND `state` = '0'");
DEFINE('GMRCHECK3', "SELECT * FROM `login` WHERE `account_id` = '2000002' AND `state` = '0'");
DEFINE('GMRCHECK4', "SELECT * FROM `login` WHERE `account_id` = '2000003' AND `state` = '0'");
DEFINE('GMRCHECK5', "SELECT * FROM `login` WHERE `account_id` = '2000004' AND `state` = '0'");
DEFINE('GMRCHECK6', "SELECT * FROM `login` WHERE `account_id` = '2000005' AND `state` = '0'");
DEFINE('GMRCHECK7', "SELECT * FROM `login` WHERE `account_id` = '2000006' AND `state` = '0'");
DEFINE('GMRCHECK8', "SELECT * FROM `login` WHERE `account_id` = '2000007' AND `state` = '0'");
DEFINE('GMRCHECK9', "SELECT * FROM `login` WHERE `account_id` = '2009476' AND `state` = '0'");
DEFINE('GMRCHECK10', "SELECT * FROM `login` WHERE `account_id` = '2007985' AND `state` = '0'");

if (isset($_POST['blockacc11']) && $_POST['blockacc11'] == 1) {

$validpass1 = $POST_pass1;
DEFINE('GMPASS1', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass1."' AND `account_id` = '2000000'");

	$queryc1 = sprintf(GMCHECK1);
	$resultc1 = execute_query($queryc1, "xblockgmsacc.php");
	$queryps1 = sprintf(GMPASS1);
	$resultps1 = execute_query($queryps1, "xblockgmsacc.php");
	if(!($resultps1->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Seph.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultc1->fetch_row()) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Seph ya estaba bloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr11 = sprintf(GMBLOCK11);
	$resultr11 = execute_query($queryr11, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Seph se bloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}
if (isset($_POST['blockacc12']) && $_POST['blockacc12'] == 2) {

$validpass1 = $POST_pass1;
DEFINE('GMPASS1', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass1."' AND `account_id` = '2000000'");

	$queryrc1 = sprintf(GMRCHECK1);
	$resultrc1 = execute_query($queryrc1, "xblockgmsacc.php");
	$queryps1 = sprintf(GMPASS1);
	$resultps1 = execute_query($queryps1, "xblockgmsacc.php");
	if(!($resultps1->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Seph.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultrc1->fetch_row()) {
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Seph ya estaba desbloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr12 = sprintf(GMBLOCK12);
	$resultr12 = execute_query($queryr12, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Seph se desbloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}

if (isset($_POST['blockacc21']) && $_POST['blockacc21'] == 1) {

$validpass2 = $POST_pass2;
DEFINE('GMPASS2', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass2."' AND `account_id` = '2000001'");

	$queryc2 = sprintf(GMCHECK2);
	$resultc2 = execute_query($queryc2, "xblockgmsacc.php");
	$queryps2 = sprintf(GMPASS2);
	$resultps2 = execute_query($queryps2, "xblockgmsacc.php");
	if(!($resultps2->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Strife.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultc2->fetch_row()) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Strife ya estaba bloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr21 = sprintf(GMBLOCK21);
	$resultr21 = execute_query($queryr21, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Strife se bloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}
if (isset($_POST['blockacc22']) && $_POST['blockacc22'] == 2) {

$validpass2 = $POST_pass2;
DEFINE('GMPASS2', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass2."' AND `account_id` = '2000001'");

	$queryrc2 = sprintf(GMRCHECK2);
	$resultrc2 = execute_query($queryrc2, "xblockgmsacc.php");
	$queryps2 = sprintf(GMPASS2);
	$resultps2 = execute_query($queryps2, "xblockgmsacc.php");
	if(!($resultps2->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Strife.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultrc2->fetch_row()) {
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Strife ya estaba desbloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr22 = sprintf(GMBLOCK22);
	$resultr22 = execute_query($queryr22, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Strife se desbloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}

if (isset($_POST['blockacc31']) && $_POST['blockacc31'] == 1) {

$validpass3 = $POST_pass3;
DEFINE('GMPASS3', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass3."' AND `account_id` = '2000002'");

	$queryc3 = sprintf(GMCHECK3);
	$resultc3 = execute_query($queryc3, "xblockgmsacc.php");
	$queryps3 = sprintf(GMPASS3);
	$resultps3 = execute_query($queryps3, "xblockgmsacc.php");
	if(!($resultps3->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Esthar.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultc3->fetch_row()) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Esthar ya estaba bloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr31 = sprintf(GMBLOCK31);
	$resultr31 = execute_query($queryr31, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Esthar se bloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}
if (isset($_POST['blockacc32']) && $_POST['blockacc32'] == 2) {

$validpass3 = $POST_pass3;
DEFINE('GMPASS3', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass3."' AND `account_id` = '2000002'");

	$queryrc3 = sprintf(GMRCHECK3);
	$resultrc3 = execute_query($queryrc3, "xblockgmsacc.php");
	$queryps3 = sprintf(GMPASS3);
	$resultps3 = execute_query($queryps3, "xblockgmsacc.php");
	if(!($resultps3->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Esthar.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultrc3->fetch_row()) {
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Esthar ya estaba desbloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr32 = sprintf(GMBLOCK32);
	$resultr32 = execute_query($queryr32, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Esthar se desbloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}

if (isset($_POST['blockacc41']) && $_POST['blockacc41'] == 1) {

$validpass4 = $POST_pass4;
DEFINE('GMPASS4', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass4."' AND `account_id` = '2000003'");

	$queryc4 = sprintf(GMCHECK4);
	$resultc4 = execute_query($queryc4, "xblockgmsacc.php");
	$queryps4 = sprintf(GMPASS4);
	$resultps4 = execute_query($queryps4, "xblockgmsacc.php");
	if(!($resultps4->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Gm Conrad.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultc4->fetch_row()) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Gm Conrad ya estaba bloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr41 = sprintf(GMBLOCK41);
	$resultr41 = execute_query($queryr41, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Gm Conrad se bloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}
if (isset($_POST['blockacc42']) && $_POST['blockacc42'] == 2) {

$validpass4 = $POST_pass4;
DEFINE('GMPASS4', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass4."' AND `account_id` = '2000003'");

	$queryrc4 = sprintf(GMRCHECK4);
	$resultrc4 = execute_query($queryrc4, "xblockgmsacc.php");
	$queryps4 = sprintf(GMPASS4);
	$resultps4 = execute_query($queryps4, "xblockgmsacc.php");
	if(!($resultps4->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Gm Conrad.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultrc4->fetch_row()) {
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Gm Conrad ya estaba desbloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr42 = sprintf(GMBLOCK42);
	$resultr42 = execute_query($queryr42, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Gm Conrad se desbloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}

if (isset($_POST['blockacc51']) && $_POST['blockacc51'] == 1) {

$validpass5 = $POST_pass5;
DEFINE('GMPASS5', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass5."' AND `account_id` = '2000004'");

	$queryc5 = sprintf(GMCHECK5);
	$resultc5 = execute_query($queryc5, "xblockgmsacc.php");
	$queryps5 = sprintf(GMPASS5);
	$resultps5 = execute_query($queryps5, "xblockgmsacc.php");
	if(!($resultps5->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Juliette.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultc5->fetch_row()) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Juliette ya estaba bloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr51 = sprintf(GMBLOCK51);
	$resultr51 = execute_query($queryr51, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Juliette se bloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}
if (isset($_POST['blockacc52']) && $_POST['blockacc52'] == 2) {

$validpass5 = $POST_pass5;
DEFINE('GMPASS5', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass5."' AND `account_id` = '2000004'");

	$queryrc5 = sprintf(GMRCHECK5);
	$resultrc5 = execute_query($queryrc5, "xblockgmsacc.php");
	$queryps5 = sprintf(GMPASS5);
	$resultps5 = execute_query($queryps5, "xblockgmsacc.php");
	if(!($resultps5->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Juliette.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultrc5->fetch_row()) {
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Juliette ya estaba desbloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr52 = sprintf(GMBLOCK52);
	$resultr52 = execute_query($queryr52, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Juliette se desbloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}

if (isset($_POST['blockacc61']) && $_POST['blockacc61'] == 1) {

$validpass6 = $POST_pass6;
DEFINE('GMPASS6', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass6."' AND `account_id` = '2000005'");

	$queryc6 = sprintf(GMCHECK6);
	$resultc6 = execute_query($queryc6, "xblockgmsacc.php");
	$queryps6 = sprintf(GMPASS6);
	$resultps6 = execute_query($queryps6, "xblockgmsacc.php");
	if(!($resultps6->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Canela.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultc6->fetch_row()) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Canela ya estaba bloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr61 = sprintf(GMBLOCK61);
	$resultr61 = execute_query($queryr61, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Canela se bloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}
if (isset($_POST['blockacc62']) && $_POST['blockacc62'] == 2) {

$validpass6 = $POST_pass6;
DEFINE('GMPASS6', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass6."' AND `account_id` = '2000005'");

	$queryrc6 = sprintf(GMRCHECK6);
	$resultrc6 = execute_query($queryrc6, "xblockgmsacc.php");
	$queryps6 = sprintf(GMPASS6);
	$resultps6 = execute_query($queryps6, "xblockgmsacc.php");
	if(!($resultps6->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Canela.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultrc6->fetch_row()) {
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Canela ya estaba desbloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr62 = sprintf(GMBLOCK62);
	$resultr62 = execute_query($queryr62, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Canela se desbloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}

if (isset($_POST['blockacc71']) && $_POST['blockacc71'] == 1) {

$validpass7 = $POST_pass7;
DEFINE('GMPASS7', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass7."' AND `account_id` = '2000006'");

	$queryc7 = sprintf(GMCHECK7);
	$resultc7 = execute_query($queryc7, "xblockgmsacc.php");
	$queryps7 = sprintf(GMPASS7);
	$resultps7 = execute_query($queryps7, "xblockgmsacc.php");
	if(!($resultps7->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de HazeN.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultc7->fetch_row()) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de HazeN ya estaba bloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr71 = sprintf(GMBLOCK71);
	$resultr71 = execute_query($queryr71, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de HazeN se bloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}
if (isset($_POST['blockacc72']) && $_POST['blockacc72'] == 2) {

$validpass7 = $POST_pass7;
DEFINE('GMPASS7', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass7."' AND `account_id` = '2000006'");

	$queryrc7 = sprintf(GMRCHECK7);
	$resultrc7 = execute_query($queryrc7, "xblockgmsacc.php");
	$queryps7 = sprintf(GMPASS7);
	$resultps7 = execute_query($queryps7, "xblockgmsacc.php");
	if(!($resultps7->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de HazeN.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultrc7->fetch_row()) {
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de HazeN ya estaba desbloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr72 = sprintf(GMBLOCK72);
	$resultr72 = execute_query($queryr72, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de HazeN se desbloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}

if (isset($_POST['blockacc81']) && $_POST['blockacc81'] == 1) {

$validpass8 = $POST_pass8;
DEFINE('GMPASS8', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass8."' AND `account_id` = '2000007'");

	$queryc8 = sprintf(GMCHECK8);
	$resultc8 = execute_query($queryc8, "xblockgmsacc.php");
	$queryps8 = sprintf(GMPASS8);
	$resultps8 = execute_query($queryps8, "xblockgmsacc.php");
	if(!($resultps8->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Lixi.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultc8->fetch_row()) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Lixi ya estaba bloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr81 = sprintf(GMBLOCK81);
	$resultr81 = execute_query($queryr81, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Lixi se bloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}
if (isset($_POST['blockacc82']) && $_POST['blockacc82'] == 2) {

$validpass8 = $POST_pass8;
DEFINE('GMPASS8', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass8."' AND `account_id` = '2000007'");

	$queryrc8 = sprintf(GMRCHECK8);
	$resultrc8 = execute_query($queryrc8, "xblockgmsacc.php");
	$queryps8 = sprintf(GMPASS8);
	$resultps8 = execute_query($queryps8, "xblockgmsacc.php");
	if(!($resultps8->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Lixi.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultrc8->fetch_row()) {
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Lixi ya estaba desbloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr82 = sprintf(GMBLOCK82);
	$resultr82 = execute_query($queryr82, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Lixi se desbloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}

if (isset($_POST['blockacc91']) && $_POST['blockacc91'] == 1) {

$validpass9 = $POST_pass9;
DEFINE('GMPASS9', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass9."' AND `account_id` = '2009476'");

	$queryc9 = sprintf(GMCHECK9);
	$resultc9 = execute_query($queryc9, "xblockgmsacc.php");
	$queryps9 = sprintf(GMPASS9);
	$resultps9 = execute_query($queryps9, "xblockgmsacc.php");
	if(!($resultps9->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Manwe.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultc9->fetch_row()) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Manwe ya estaba bloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr91 = sprintf(GMBLOCK91);
	$resultr91 = execute_query($queryr91, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Manwe se bloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}
if (isset($_POST['blockacc92']) && $_POST['blockacc92'] == 2) {

$validpass9 = $POST_pass9;
DEFINE('GMPASS9', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass9."' AND `account_id` = '2009476'");

	$queryrc9 = sprintf(GMRCHECK9);
	$resultrc9 = execute_query($queryrc9, "xblockgmsacc.php");
	$queryps9 = sprintf(GMPASS9);
	$resultps9 = execute_query($queryps9, "xblockgmsacc.php");
	if(!($resultps9->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Manwe.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultrc9->fetch_row()) {
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Manwe ya estaba desbloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr92 = sprintf(GMBLOCK92);
	$resultr92 = execute_query($queryr92, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Manwe se desbloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}

if (isset($_POST['blockacc101']) && $_POST['blockacc101'] == 1) {

$validpass10 = $POST_pass10;
DEFINE('GMPASS10', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass10."' AND `account_id` = '2007985'");

	$queryc10 = sprintf(GMCHECK10);
	$resultc10 = execute_query($queryc10, "xblockgmsacc.php");
	$queryps10 = sprintf(GMPASS10);
	$resultps10 = execute_query($queryps10, "xblockgmsacc.php");
	if(!($resultps10->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Chronus.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultc10->fetch_row()) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Chronus ya estaba bloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr101 = sprintf(GMBLOCK101);
	$resultr101 = execute_query($queryr101, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Chronus se bloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}
if (isset($_POST['blockacc102']) && $_POST['blockacc102'] == 2) {

$validpass10 = $POST_pass10;
DEFINE('GMPASS10', "SELECT * FROM `login` WHERE BINARY `user_pass` = '".$validpass10."' AND `account_id` = '2007985'");

	$queryrc10 = sprintf(GMRCHECK10);
	$resultrc10 = execute_query($queryrc10, "xblockgmsacc.php");
	$queryps10 = sprintf(GMPASS10);
	$resultps10 = execute_query($queryps10, "xblockgmsacc.php");
	if(!($resultps10->fetch_row())) { 
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La Clave actual que ingresaste no concuerda con la cuenta de Chronus.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	if ($resultrc10->fetch_row()) {
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Chronus ya estaba desbloqueada anteriormente.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
	}
	$queryr102 = sprintf(GMBLOCK102);
	$resultr102 = execute_query($queryr102, "xblockgmsacc.php");
		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		echo "alert('La cuenta de Chronus se desbloqueó con éxito.');\n";
		echo "window.location = ('http://cp.brawlnetwork.net/xblockgmsacc.php');\n";
		echo "</script>\n";
		exit();
}

	$queryc1 = sprintf(GMCHECK1);
	$resultc1 = execute_query($queryc1, "xblockgmsacc.php");
	$queryc2 = sprintf(GMCHECK2);
	$resultc2 = execute_query($queryc2, "xblockgmsacc.php");
	$queryc3 = sprintf(GMCHECK3);
	$resultc3 = execute_query($queryc3, "xblockgmsacc.php");
	$queryc4 = sprintf(GMCHECK4);
	$resultc4 = execute_query($queryc4, "xblockgmsacc.php");
	$queryc5 = sprintf(GMCHECK5);
	$resultc5 = execute_query($queryc5, "xblockgmsacc.php");
	$queryc6 = sprintf(GMCHECK6);
	$resultc6 = execute_query($queryc6, "xblockgmsacc.php");
	$queryc7 = sprintf(GMCHECK7);
	$resultc7 = execute_query($queryc7, "xblockgmsacc.php");
	$queryc8 = sprintf(GMCHECK8);
	$resultc8 = execute_query($queryc8, "xblockgmsacc.php");
	$queryc9 = sprintf(GMCHECK9);
	$resultc9 = execute_query($queryc9, "xblockgmsacc.php");
	$queryc10 = sprintf(GMCHECK10);
	$resultc10 = execute_query($queryc10, "xblockgmsacc.php");

	opentable("Panel de Administradores");

?>
<br/><center><b><font color="Black">Este sistema se encarga unicamente de bloquear/desbloquear las cuentas de cada GM para mayor seguridad. SOLO ESTO ES CONFIDENCIAL PARA EL STAFF DE BRAWL, NO COMPARTAN ESTA PAGINA CON NADIE.</font></b></center><br /><br />

<table align="center" border="1" width="800" heigh="600"><tr>
<td>
<center><b><font size=3>Seph</font></b><hr>
<form id="blockgm11" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass1" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm11" value="Bloquear" target="main">
<input type="hidden" name="blockacc11" value="1">
</form>
<form id="blockgm12" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass1" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm12" value="Desbloquear" target="main">
<input type="hidden" name="blockacc12" value="2">
</form>
<?php
if ($resultc1->fetch_row()) { echo "<b><font color=\"red\" size=3>BLOQUEADO</font></b>"; } else { echo "<b><font color=\"green\" size=3>DESBLOQUEADO</font></b>"; }
?></center>
</td><td>
<center><b><font size=3>Strife</font></b><hr>
<form id="blockgm21" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass2" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm21" value="Bloquear" target="main">
<input type="hidden" name="blockacc21" value="1">
</form>
<form id="blockgm22" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass2" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm22" value="Desbloquear" target="main">
<input type="hidden" name="blockacc22" value="2">
</form>
<?php
if ($resultc2->fetch_row()) { echo "<b><font color=\"red\" size=3>BLOQUEADO</font></b>"; } else { echo "<b><font color=\"green\" size=3>DESBLOQUEADO</font></b>"; }
?></center>
</td><td>
<center><b><font size=3>Esthar</font></b><hr>
<form id="blockgm31" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass3" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm31" value="Bloquear" target="main">
<input type="hidden" name="blockacc31" value="1">
</form>
<form id="blockgm32" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass3" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm32" value="Desbloquear" target="main">
<input type="hidden" name="blockacc32" value="2">
</form>
<?php
if ($resultc3->fetch_row()) { echo "<b><font color=\"red\" size=3>BLOQUEADO</font></b>"; } else { echo "<b><font color=\"green\" size=3>DESBLOQUEADO</font></b>"; }
?></center>
</td><td>
<center><b><font size=3>Gm Conrad</font></b><hr>
<form id="blockgm41" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass4" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm41" value="Bloquear" target="main">
<input type="hidden" name="blockacc41" value="1">
</form>
<form id="blockgm42" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass4" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm42" value="Desbloquear" target="main">
<input type="hidden" name="blockacc42" value="2">
</form>
<?php
if ($resultc4->fetch_row()) { echo "<b><font color=\"red\" size=3>BLOQUEADO</font></b>"; } else { echo "<b><font color=\"green\" size=3>DESBLOQUEADO</font></b>"; }
?></center>
</td><td>
<center><b><font size=3>Juliette</font></b><hr>
<form id="blockgm51" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass5" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm51" value="Bloquear" target="main">
<input type="hidden" name="blockacc51" value="1">
</form>
<form id="blockgm52" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass5" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm52" value="Desbloquear" target="main">
<input type="hidden" name="blockacc52" value="2">
</form>
<?php
if ($resultc5->fetch_row()) { echo "<b><font color=\"red\" size=3>BLOQUEADO</font></b>"; } else { echo "<b><font color=\"green\" size=3>DESBLOQUEADO</font></b>"; }
?></center>
</td></tr>
<tr><td>
<center><b><font size=3>Canela</font></b><hr>
<form id="blockgm61" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass6" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm61" value="Bloquear" target="main">
<input type="hidden" name="blockacc61" value="1">
</form>
<form id="blockgm62" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass6" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm62" value="Desbloquear" target="main">
<input type="hidden" name="blockacc62" value="2">
</form>
<?php
if ($resultc6->fetch_row()) { echo "<b><font color=\"red\" size=3>BLOQUEADO</font></b>"; } else { echo "<b><font color=\"green\" size=3>DESBLOQUEADO</font></b>"; }
?></center>
</td><td>
<center><b><font size=3>HazeN</font></b><hr>
<form id="blockgm71" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass7" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm71" value="Bloquear" target="main">
<input type="hidden" name="blockacc71" value="1">
</form>
<form id="blockgm72" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass7" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm72" value="Desbloquear" target="main">
<input type="hidden" name="blockacc72" value="2">
</form>
<?php
if ($resultc7->fetch_row()) { echo "<b><font color=\"red\" size=3>BLOQUEADO</font></b>"; } else { echo "<b><font color=\"green\" size=3>DESBLOQUEADO</font></b>"; }
?></center>
</td><td>
<center><b><font size=3>Lixi</font></b><hr>
<form id="blockgm81" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass8" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm81" value="Bloquear" target="main">
<input type="hidden" name="blockacc81" value="1">
</form>
<form id="blockgm82" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass8" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm82" value="Desbloquear" target="main">
<input type="hidden" name="blockacc82" value="2">
</form>
<?php
if ($resultc8->fetch_row()) { echo "<b><font color=\"red\" size=3>BLOQUEADO</font></b>"; } else { echo "<b><font color=\"green\" size=3>DESBLOQUEADO</font></b>"; }
?></center>
</td><td>
<center><b><font size=3>Manwe</font></b><hr>
<form id="blockgm91" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass9" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm91" value="Bloquear" target="main">
<input type="hidden" name="blockacc91" value="1">
</form>
<form id="blockgm92" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass9" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm92" value="Desbloquear" target="main">
<input type="hidden" name="blockacc92" value="2">
</form>
<?php
if ($resultc9->fetch_row()) { echo "<b><font color=\"red\" size=3>BLOQUEADO</font></b>"; } else { echo "<b><font color=\"green\" size=3>DESBLOQUEADO</font></b>"; }
?></center>
</td><td>
<center><b><font size=3>Chronus</font></b><hr>
<form id="blockgm101" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass10" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm101" value="Bloquear" target="main">
<input type="hidden" name="blockacc101" value="1">
</form>
<form id="blockgm102" method="post">
Pass de tu cuenta para validar
<br><input type="password" name="pass10" maxlength="100" size="23"><br>
<input type="submit" size="100" name="blockgm102" value="Desbloquear" target="main">
<input type="hidden" name="blockacc102" value="2">
</form>
<?php
if ($resultc10->fetch_row()) { echo "<b><font color=\"red\" size=3>BLOQUEADO</font></b>"; } else { echo "<b><font color=\"green\" size=3>DESBLOQUEADO</font></b>"; }
?></center>
</td>

</tr></table>
<?php
	closetable();
?>