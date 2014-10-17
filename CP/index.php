<?php
	/* TerraOnline Control Panel - Projecto GaiaRO 4 */
	session_start();
	include_once('config.php');
	include_once('functions.php');

	$_SESSION[$CONFIG['Name'] . 'jobs'] = readjobs();
	$_SESSION[$CONFIG['Name'] . 'castles'] = readcastles();
	$_SESSION[$CONFIG['Name'] . 'itemdb'] = readitems();
	$_SESSION[$CONFIG['Name'] . 'cardpre'] = readcarpref();

	$page = 0;
	if (isset($_GET['page']) && is_numeric($_GET['page']))
		$page = $_GET['page']; // Indica que página mostrar al cargar Index
?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			<title>
				Evangelis Ragnarok - High Rates Premium - Panel de Cuentas
			</title>
			<link rel="stylesheet" type="text/css" href="./gaiaro.css">
			<script type="text/javascript" language="javascript" src="gaiaro.js"></script>
			<script language="javascript" type="text/javascript">
				function show_tip(header,guild,jobinfo,levels,map,jobid)
				{
					var wtip;
					wtip = document.getElementById("tip");

					if( window.opera)
					{
						x = window.event.clientX+15;
						y = window.event.clientY-10;
					}
					else if( navigator.appName == "Netscape")
					{
						document.onmousemove = function(e) { x = e.pageX+15; y = e.pageY-10; return true }
					}
					else
					{
						x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft + 15;
						y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop - 10;
					}

					wtip.innerHTML = '<table width="150" border="0" cellspacing="0" cellpadding="0"\><tr class=\'tip_header\'\><td\>' + header + '</td\></tr\><tr class=\'tip_guild\'\><td\>' + guild + '</td\></tr\><tr class=\'tip_text\'\><td\><img src="imgwm/' + jobid + '.gif"></td\></tr\><tr class=\'tip_text\'\><td\>' + jobinfo + '</td\></tr\><tr class=\'tip_text\'\><td\>' + levels + '</td\></tr\><tr class=\'tip_text\'\><td\>' + map + '</td\></tr\><\/table\>';
					if( screen.width - x < 150 )
						x -= 150;

					wtip.style.left = x + "px";
					wtip.style.top = y + "px";
				}

				function hide_tip()
				{
					var wtip;
					wtip = document.getElementById("tip");

					wtip.innerHTML = "";
					wtip.style.left = "-1000px";
					wtip.style.top = "-1000px";
				}
			</script>
		    <style type="text/css">
				<!--
				.style2 {
					font-size: large;
					font-family: Arial, Helvetica, sans-serif;
				}
				#tip {
					background: #000000;
					border: 0px solid #aaaaaa;
					left: -1000px;
					padding: 0px;
					position: absolute;
					top: -1000px;
					z-index: 110;
				}
				.tip_header {
					background: #BD1E30;
					FONT-WEIGHT: bold;
					color: #FFFFFF;
					font-family: arial, helvetica, sans-serif;
					font-size: 11px;
					font-style: normal;
					text-align: center;
					padding: 0px;
				}
				.tip_guild {
					background: #BD1E30;
					FONT-WEIGHT: bold;
					color: #ffff00;
					font-family: arial, helvetica, sans-serif;
					font-size: 11px;
					font-style: normal;
					text-align: center;
					padding: 3px;
				}
				.tip_text {
					background: #FFFFFF;
					FONT-WEIGHT: normal;
					color: #000000;
					font-family: arial, helvetica, sans-serif;
					font-size: 11px;
					font-style: normal;
					text-align: center;
					padding: 3px;
				}
				-->
            </style>
    </head>
		<BODY style="margin-top:0; margin-bottom:0" background="world.jpg">
			<div id="tip"></div>
			<table border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="height:100%" width="780" align=center>
				<tr>
					<td valign="top" colspan="5" width="100%" style="background:url(images/banner.jpg); height:161px">
					</td>
				</tr>
				<tr>
					<td align="center" bgcolor="#425443">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" bgcolor="#425443">
						<script type="text/javascript"><!--
							google_ad_client = "pub-0434893123029578";
							google_ad_width = 728;
							google_ad_height = 90;
							google_ad_format = "728x90_as";
							google_ad_type = "text_image";
							//2007-05-03: ea.terra-gaming.com
							google_ad_channel = "5536169883";
							//-->
							</script>
							<script type="text/javascript"
							  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
						</script>
					</td>
				</tr>
				<tr>
					<td style="height:25px" colspan="5" bgcolor="#425443" width="100%" align="center">
						<div id="main_menu" style="color:#FFFFFF; font-weight:bold"></div>
						<div id="load_div" style="position:absolute; bottom:10px; right:10px; height:40px width:56px; visibility:hidden; color:#FFFFFF"><img src="loading.gif"></div>
						<div id="menu_load" style="position:absolute; top:0px; left:0px; visibility:hidden; background-color:#004E98; color:#BD1E30"></div>
					</td>
				</tr>
				<tr bgcolor="#BD1E30">
					<td style="height:25px" colspan="5" width="100%" align="center">
						<div id="sub_menu" style="background-color:#BD1E30; color:#FFFFFF; font-weight:bold"></div>
					</td>
				</tr>
				<tr valign=top>
					<td height="100%">
						<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="height:350px">
							<tr style="height:100%">
								<td valign="top" bgcolor="#FFFFFF" colspan="2" width="600" style="height:100%">
									<div id="main_div" style="padding-left: 15; padding-right: 5; padding-top: 10">
									</div>
								</td>
								<td bgcolor="#BD1E30" valign="top" width="156" rowspan="5" style="height:100%">
									<div id="login_div" style="color:#FFFFFF; padding-left: 15; padding-right: 5; padding-top: 10"></div>
									<div id="status_div" style="color:#FFFFFF; padding-left: 15; padding-right: 5; padding-top: 10"></div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="5" bgcolor="#425443" style="height:40px" valign="middle" align="center">
						<p style="font-size: 9px; margin-top: 7">
							<span class="style2"><font color="#BD1E30">Evangelis Ragnarok - Julio 2009</font></span>
						</p>
					</td>
				</tr>
			</table>
<?php
	echo '
			<script type="text/javascript">
				load_menu();
	';

	switch ($page)
	{
		case 0: echo "LINK_ajax('news.php', 'main_div');"; break;
		case 1: echo "LINK_ajax('installguide.php', 'main_div');"; break;
		case 2: echo "LINK_ajax('adminpremium.php', 'main_div');"; break;
		case 3: echo "LINK_ajax('worldmap.php', 'main_div');"; break;
		case 4: echo "LINK_ajax('woerank.php', 'main_div');"; break;
		case 5: echo "LINK_ajax('donate.php', 'main_div');"; break;
	}

	echo "
				LINK_ajax('login.php', 'login_div');
				server_status();
			</script>
	";
?>
		</body>
	</html>