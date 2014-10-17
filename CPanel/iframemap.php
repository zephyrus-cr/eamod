<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';
if (is_woe())
	alert("No puedes ver esta función durante una WOE/Baby WOE activa.");
	//redir("motd.php", "main_div", $lang['WOE_TIME']);
echo '
<iframe src="http://cp.brawlnetwork.net/AjaxMapper.php" frameborder=0 scrolling="auto" border="0" width="650" height="820">
<p>Tu navegador no soporta Iframes</p>
</iframe>';
?>
