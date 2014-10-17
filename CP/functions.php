<?php
	include_once('classes.php');
	include("class.phpmailer.php");
	include("class.smtp.php");

	// Session Checking ...
	if (isset($_SESSION[$CONFIG['Name'] . 'SERVER']))
	{
		if (strcmp($_SESSION[$CONFIG['Name'] . 'SERVER'], $CONFIG['Name']))
		{
			session_destroy();
			die();
		}
	}
	else
	{
		$_SESSION[$CONFIG['Name'] . 'SERVER'] = $CONFIG['Name'];
	}

	$mysql = new sql($CONFIG['DBHost'], $CONFIG['DBUser'], $CONFIG['DBPass']);

	if (!isset($_SESSION[$CONFIG['Name'] . 'jobs']))
		$_SESSION[$CONFIG['Name'] . 'jobs'] = readjobs();

	if (!isset($_SESSION[$CONFIG['Name'] . 'castles']))
		$_SESSION[$CONFIG['Name'] . 'castles'] = readcastles();

	if (!isset($_SESSION[$CONFIG['Name'] . 'itemdb']))
		$_SESSION[$CONFIG['Name'] . 'itemdb'] = readitems();

	if (!isset($_SESSION[$CONFIG['Name'] . 'cardpre']))
		$_SESSION[$CONFIG['Name'] . 'cardpre'] = readcarpref();

	// Play Time Functions ************************************************************************

	function playtime($time)
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

		return sprintf("%d days, %02d:%02d:%02d", $days, $hour, $minute, $second);
	}

	// Mail Config ********************************************************************************

	function sendmail($to, $subject, $body)
	{
		$phpmailer = new PHPMailer();
		$phpmailer->IsSMTP();
		$phpmailer->SMTPAuth   = true;
		$phpmailer->SMTPSecure = "ssl";
		$phpmailer->Host       = "plus.smtp.mail.yahoo.com";
		$phpmailer->Port       = 465;

		$phpmailer->Username   = "yahoo user";
		$phpmailer->Password   = "yahoo password";

		$phpmailer->From       = "correo origen";
		$phpmailer->FromName   = "Staff Mi Servidor";

		$phpmailer->Subject = $subject;
		$phpmailer->Body = $body;

		$phpmailer->AddAddress($to,"Mi Servidor Ragnarok Member");
		$phpmailer->AddReplyTo("emailtoreply@change.me","Staff Mi Servidor");

		return $phpmailer->Send();
	}

	// Bases de Datos *****************************************************************************

	function readjobs()
	{
		$resp[] = "Desconocido";
		if (!($handle = fopen("./db/jobs.txt", "rt")))
			die('JOB DB Error...');

		while ($line = fgets($handle, 1024))
		{
			if (($line[0] == '/' && $line[1] == '/') || $line[0] == '\0' || $line[0] == '\n' || $line[0] == '\r')
				continue;

			$job = sscanf($line, "%s %d");

			if (isset($job[0]) && isset($job[1]))
			{
				for($i = 1; isset($job[0][$i]); $i++)
					if ($job[0][$i] == '_') $job[0][$i] = ' ';

				$resp[$job[1]] = $job[0];
			}
		}

		fclose($handle);
		return $resp;
	}

	function readskills()
	{
		$resp[] = "Desconocido";
		if (!($handle = fopen("./db/skills.txt", "rt")))
			die('SKILL DB Error...');

		while ($line = fgets($handle, 1024))
		{
			if (($line[0] == '/' && $line[1] == '/') || $line[0] == '\0' || $line[0] == '\n' || $line[0] == '\r')
				continue;

			$skill = sscanf($line, "%d %s");

			if (isset($skill[0]) && isset($skill[1]))
			{
				for($i = 1; isset($skill[1][$i]); $i++)
					if ($skill[1][$i] == '_') $skill[1][$i] = ' ';

				$resp[$skill[0]] = $skill[1];
			}
		}

		fclose($handle);
		return $resp;
	}

	function readcastles()
	{
		if (!($handle = fopen("./db/castles.txt", "rt")))
			die('CASTLE DB Error...');

		while ($line = fgets($handle, 1024))
		{
			if (($line[0] == '/' && $line[1] == '/') || $line[0] == '\0' || $line[0] == '\n' || $line[0] == '\r')
				continue;

			$job = sscanf($line, "%d %s");

			if (isset($job[0]) && isset($job[1]))
			{
				for($i = 1; isset($job[1][$i]); $i++)
					if ($job[1][$i] == '_') $job[1][$i] = ' ';

				$resp[$job[0]] = $job[1];
			}
		}

		fclose($handle);
		return $resp;
	}

	function readitems()
	{
		global $mysql, $CONFIG_DBMain;

		$result = $mysql->query("
			SELECT
				`id`, `name_japanese`
			FROM
				`item_db`
		", $CONFIG_DBMain);

		while ($line = $mysql->fetchrow($result))
		{
			$items[$line[0]] = $line[1]; // Nombre Japones
		}

		return $items;
	}

	function readslots()
	{
		global $mysql, $CONFIG_DBMain;

		$result = $mysql->query("
			SELECT
				`id`, `slots`
			FROM
				`item_db`
		", $CONFIG_DBMain);

		while ($line = $mysql->fetchrow($result))
		{
			$slots[$line[0]] = $line[1]; // Slots
		}

		return $slots;
	}

	function readcarpref()
	{
		$resp[] = "Desconocido";

		if (!($handle = fopen("./db/cardpref.txt", "rt")))
			die('CARD PREFIX DB Error...');

		while ($line = fgets($handle, 1024))
		{
			if (($line[0] == '/' && $line[1] == '/') || $line[0] == '\0' || $line[0] == '\n' || $line[0] == '\r')
				continue;

			$prefix = sscanf($line, "%d %s");

			if (isset($prefix[0]) && isset($prefix[1]))
			{
				for($i = 1; isset($prefix[1][$i]); $i++)
					if ($prefix[1][$i] == '_') $prefix[1][$i] = ' ';

				$resp[$prefix[0]] = $prefix[1];
			}
		}

		fclose($handle);
		return $resp;
	}

	// Server Functions ***************************************************************************

	function DectoIP($a)
	{

		$b = array(0,0,0,0);
		$c = 16777216.0;
		$a += 0.0;

		for ($i = 0; $i < 4; $i++)
		{
			$k = (int) ($a / $c);
			$a -= $c * $k;
			$b[$i]= $k;
			$c /= 256.0;
		}

		$d = join('.', $b);

		return $d;
	}

	function server_status()
	{
		global $CONFIG_DBLogs, $CONFIG_LoginIP, $CONFIG_LoginPort, $CONFIG_CharIP, $CONFIG_CharPort, $CONFIG_MapIP, $CONFIG_MapPort, $mysql;

		if (!($estado = $mysql->fetcharray($mysql->query("
			SELECT
				*
			FROM
				`cp_sstatuslog`
		", $CONFIG_DBLogs))))
		{
			$mysql->query("
				INSERT INTO
					`cp_sstatuslog`
				VALUES
					(NOW(), '0')
			", $CONFIG_DBLogs);
			$estado['last_checked'] = 0;
			$estado['status'] = 0;
		}

		$diff = time() - strtotime($estado['last_checked']);
		$server = 0;

		if($diff > 300 || $estado['last_checked'] < 7)
		{
			// Low Rates
			if (@fsockopen($CONFIG_LoginIP, $CONFIG_LoginPort, $errno, $errstr, 1) > 0) { $server += 1; }
			if (@fsockopen($CONFIG_CharIP, $CONFIG_CharPort, $errno, $errstr, 1) > 0) { $server += 2; }
			if (@fsockopen($CONFIG_MapIP, $CONFIG_MapPort, $errno, $errstr, 1) > 0) { $server += 4; }

			$mysql->query("
				UPDATE
					`cp_sstatuslog`
				SET
					last_checked = NOW(), status = '$server'
			", $CONFIG_DBLogs);
		}
		else
		{
			$server = $estado['status'];
		}

		return $server;
	}

	function online_count()
	{
		global $mysql, $mysql, $CONFIG_DBMain;

		$estado = $mysql->fetcharray($mysql->query("
			SELECT
				COUNT(1) AS `Total`
			FROM
				`char`
			WHERE
				`online` != '0'
		", $CONFIG_DBMain));

		return $estado['Total'];
	}

	// Security Functions *************************************************************************

	function generateCode($length = 12)
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
		$code = "";
		$clen = strlen($chars) - 1;
		while (strlen($code) < $length)
		{
			$code .= $chars[mt_rand(0,$clen)];
	 	}
	 	return $code;
	}

	function alert($alertmsg)
	{
		$trans_tbl = get_html_translation_table (HTML_ENTITIES);
		$trans_tbl = array_flip ($trans_tbl);
		$alertmsg = strtr ($alertmsg, $trans_tbl);

		echo "ALERT|".utf8_encode($alertmsg)."|ENDALERT";
		exit(0);
	}

	function redir($page, $div, $msg)
	{
		opentable("- Informacion -");
		echo "
			<tr>
				<td align=\"center\">
					<span style=\"cursor:pointer\" onMouseOver=\"this.style.color='#FF3300'\" onMouseOut=\"this.style.color='#000000'\" onClick=\"return LINK_ajax('$page','$div')\"><b>".$msg."</span>
				</tr>
			</td>
		";
		closetable();
		exit(0);
	}

	function inject($string)
	{
		$permitido = " abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@_.,Ò—-·ÈÌÛ˙¡…Õ”⁄";
		for ($i=0; $i<strlen($string); $i++)
		{
			if (strpos($permitido, substr($string, $i, 1)) === FALSE)
				return TRUE;
		}
		return FALSE;
	}

	function invalid_desc($string)
	{
		$permitido = " abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@_.,Ò—-·ÈÌÛ˙¡…Õ”⁄[]%+>=";
		for ($i=0; $i<strlen($string); $i++)
		{
			if (strpos($permitido, substr($string, $i, 1)) === FALSE)
				return TRUE;
		}
		return FALSE;
	}

	function invalid_name(&$string)
	{
		$string = preg_replace('/%u2020/', 'Ü', $string);
		$permitido = "abcdefghijklmnÒopqrstuvwxyz ABCDEFGHIJKLMN—OPQRSTUVWXYZ1234567890,.-*Ü§ß~[]´ª@";
		for ($i=0; $i<strlen($string); $i++)
		{
			if (strpos($permitido, substr($string, $i, 1)) === FALSE)
				return TRUE;
		}
		return FALSE;
	}

	function notnumber($string)
	{
		$permitido = "1234567890";
		for ($i=0; $i<strlen($string); $i++)
		{
			if (strpos($permitido, substr($string, $i, 1)) === FALSE)
				return TRUE;
		}

		return FALSE;
	}

	function is_online($msg = 0)
	{
		global $mysql, $CONFIG_DBMain, $CONFIG_Name;

		if (empty($_SESSION[$CONFIG_Name . 'account_id']) && $msg)
			redir("cuentas.php", "main_div", "Para utilizar esta herramienta debes tener una cuenta seleccionada.<br>Click aqui para Continuar.");

		$log_account = $_SESSION[$CONFIG_Name . 'account_id'];

		$result = $mysql->fetchrow($mysql->query("SELECT COUNT(1) FROM `char` WHERE `online` != '0' AND `account_id` = '$log_account'", $CONFIG_DBMain));

		return $result[0];
	}

	function is_online2($log_account)
	{
		global $mysql, $CONFIG_DBMain;
		$result = $mysql->fetchrow($mysql->query("SELECT COUNT(1) FROM `char` WHERE `online` != '0' AND `account_id` = '$log_account'", $CONFIG_DBMain));

		return $result[0];
	}

	// Visual Functions ***************************************************************************

	function cardcounter($n)
	{
		$rest = '';
		switch ($n)
		{
			case 2: $rest = 'Doble '; break;
			case 2: $rest = 'Triple '; break;
			case 2: $rest = 'Cuadruple '; break;
		}

		return $rest;
	}

	function moneyformat($string)
	{
		$string = trim($string);
		$return = "";
		$len = strlen($string) - 1;

		for ($i = 0; $i < strlen($string); $i++)
		{
			if ($i > 0 && $i % 3 == 0)
				$return = ",".$return;
			$return = $string[$len - $i].$return;
		}

		return $return;
	}

	function htmlformat($string)
	{
		$resp = "";

		for ($i = 0; isset($string[$i]) && ord($string[$i]) > 0; $i++)
			$resp .= "&#".ord($string[$i]).";";

		return $resp;
	}

	function opentable($titulo)
	{
		echo "
			<center>
				<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
					<tbody>
						<tr>
							<th height=\"28\" class=\"title\">".$titulo."</th>
						</tr>
						<tr>
							<td>
		";
	}

	function closetable()
	{
		echo "
							</td>
						</tr>
					</tbody>
				</table>
			</center>
		";
	}
?>