<?php
	session_start();
	include_once 'config2.php';
	include_once 'functions2.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'account_id']) || $_SESSION[$CONFIG['Name'] . 'account_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	if (isset($_GET['acc']))
	{
		if (!inject($_GET['acc']) && strlen($_GET['acc']) > 0)
		{
			// Verificacion si el userid corresponde al MemberID
			$userid = $_GET['acc'];
			$account_id = $_SESSION[$CONFIG['Name'] . 'account_id'];

			if ($account = $mysql->fetcharray($mysql->query("
				SELECT
					`account_id`, `level`, `userid`, `sex`
				FROM
					`login`
				WHERE
					BINARY `userid` = '$userid' AND `state` <> '5' AND `account_id` = '$account_id'
			", $CONFIG['DBMain'])))
			{
				$_SESSION[$CONFIG['Name'] . 'account_id'] = $account['account_id'];
				$_SESSION[$CONFIG['Name'] . 'userid'] = $userid;
				$_SESSION[$CONFIG['Name'] . 'level'] = $account['level'];
				$_SESSION[$CONFIG['Name'] . 'sex'] = $account['sex'];
				$_SESSION[$CONFIG['Name'] . 'tradelog'] = 0;
				$_SESSION[$CONFIG['Name'] . 'trades'] = array();

				echo '
					<script type="text/javascript">
						LINK_ajax(\'login.php\',\'login_div\');
						load_menu();
					</script>
				';
			}
		}
	}

	opentable("Mis Cuentas de Jugador");
?>
	<table width="550">
		<tr>
			<td align="center" height="30" valign="middle">
				Estas son tus cuentas de jugador en el servidor<br>
				Haz click sobre alguna cuenta para seleccionarla y tener acceso a sus opciones.
			</td>
		</tr>
		<tr>
			<td align="center" height="10" valign="top">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" valign="top">
				<table width="550">
					<tr>
						<td align="left" class="header"><b>#</b></td>
						<td align="center">&nbsp;</td>
						<td align="left" class="header"><b>User ID</b></td>
						<td align="center">&nbsp;</td>
						<td align="center" class="header"><b>Sexo</b></td>
						<td align="center">&nbsp;</td>
						<td align="right" class="header"><b>Accesos</b></td>
						<td align="center">&nbsp;</td>
						<td align="center" class="header"><b>&Uacute;ltimo Acceso</b></td>
						<td align="center">&nbsp;</td>
						<td align="center" class="header"><b>&Uacute;ltima IP</b></td>
						<td align="center">&nbsp;</td>
						<td align="center" class="header"><b>Seguridad IP</b></td>
						<td align="right">&nbsp;</td>
						<td align="right" class="header"><b>Ban</b></td>
					</tr>
					<tr>
						<td align="center" colspan="15"><hr></td>
					</tr>
					<tr>
						<td align="center" colspan="15"><b><font color="Orange">BrawlNetwork Ragnarok - High Rates Premium - Cuentas</font></b></td>
					</tr>
<?php
	// Consulta de Cuentas
	$account_id = $_SESSION[$CONFIG['Name'] . 'account_id'];

	$accounts = $mysql->query("
		SELECT
			`account_id`, `userid`, `lastlogin`, `sex`, `logincount`, `last_ip`, `ipallow`, `unban_time`
		FROM
			`login`
		WHERE
			`account_id` = '$account_id' AND `state` <> '5'
	", $CONFIG['DBMain']);

	for ($i = 1; $account = $mysql->fetcharray($accounts); $i++)
	{
		if ($account['unban_time'] > time())
			$ban = date("F j, Y, g:i a", $account['unban_time']);
		else
			$ban = 'ninguno';

		echo '
			<tr>
				<td align="left"><b>' . $i . '</b></td>
				<td align="center">&nbsp;</td>
				<td align="left">
					<span title="Seleccionar Cuenta" style="color:#000000; cursor:pointer" onMouseOver="this.style.color=#0000FF" onMouseOut="this.style.color=#000000" onClick="return LINK_ajax(\'cuentas.php?acc=' . $account['userid'] . '\',\'main_div\');">
						' . ((isset($_SESSION[$CONFIG['Name'] . 'account_id']) && $_SESSION[$CONFIG['Name'] . 'account_id'] == $account['account_id']) ? '<b>' . htmlformat($account['userid']) . '</b>' : htmlformat($account['userid'])) . '
					</span>
				</td>
				<td align="center">&nbsp;</td>
				<td align="center">' . $account['sex'] . '</td>
				<td align="center">&nbsp;</td>
				<td align="right">' . $account['logincount'] . '</td>
				<td align="center">&nbsp;</td>
				<td align="center">' . $account['lastlogin'] . '</td>
				<td align="center">&nbsp;</td>
				<td align="center">' . $account['last_ip'] . '</td>
				<td align="center">&nbsp;</td>
				<td align="center">' . $account['ipallow'] . '</td>
				<td align="center">&nbsp;</td>
				<td align="right">' . $ban . '</td>
			<tr>
		';
	}
?>
					<tr>
						<td align="center" colspan="15"><hr></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<?php
	closetable();
?>