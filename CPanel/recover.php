<?php

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';
include_once 'mail.php';

$random = rand(11111111111111111,99999999999999999);

	if (isset($_POST['opt']) && $_POST['opt'] == 1)
	{

$session = $_SESSION[$CONFIG_name.'sessioncode'];
DEFINE('RECOVER1',"SELECT * FROM `login`");
DEFINE('RECOVER2',"SELECT * FROM `login` WHERE BINARY `userid` = '".$POST_userid."'");
DEFINE('RECOVER3',"SELECT * FROM `login` WHERE BINARY `email` = '".$POST_mail."'");
DEFINE('RECOVER4',"SELECT * FROM `login` WHERE `userid` = '".$POST_userid."' AND `email` = '".$POST_mail."'");
DEFINE('RECOVERUP',"UPDATE `login` SET `user_pass` = '". $random . "' WHERE `userid` = '".$POST_userid."' AND `email` = '".$POST_mail."'");

		if ($POST_userid == "" || $POST_mail == "")
			alert("No puedes dejar ningún campo vacío.");

$query2 = sprintf(RECOVER2);
$result2 = execute_query($query2, "recover.php");

if(!($char = $result2->fetch_row()))
	alert("El User ID que ingresaste no existe en la Base de datos.");

$query3 = sprintf(RECOVER3);
$result3 = execute_query($query3, "recover.php");

if(!($char = $result3->fetch_row()))
	alert("El Correo que ingresaste no existe en la Base de datos.");

$query4 = sprintf(RECOVER4);
$result4 = execute_query($query4, "recover.php");

if(!($char = $result4->fetch_row()))
	alert("El ID User no concuerda con el Correo de la cuenta solicitada.");

		if ($CONFIG_auth_image && function_exists("gd_info")
			&& strtoupper($POST_code) != substr(strtoupper(md5("Mytext".$session['account'])), 0,6))
			alert($lang['INCORRECT_CODE']);

$query5 = sprintf(RECOVERUP);
$result5 = execute_query($query5, "recover.php");
		$myip = $_SERVER['REMOTE_ADDR'];
		$email = $POST_mail.',';
		$email .= 's.uzumaki03@gmail.com';
		$asunto = "Brawl RO - Solicitud de Clave de Cuenta";
		$message = "";
		$message.= "Se realizó una solicitud de Recuperación de Cuenta.";
		$message.= "\n\nEste mensaje ha sido enviado automáticamente ya que usted (o alguien más) colocó este correo como solicitante, recuerda tener precausión al utilizar este sistema, para mayor seguridad NO COMPARTAS TUS DATOS CON NADIE.";
		$message.= "\n\n     Su User-ID es: ".$POST_userid;
		$message.= "\n     Su e-mail de la cuenta es: ".$POST_mail;
		$message.= "\n     Su dirección IP actual para esta solicitud es: ".$myip;
		$message.= "\n     Fecha de recuperación de cuenta: ".date('l jS \of F Y h:i:s A');
		$message.= "\n\nLa clave ha sido transformada a esta nueva: [ $random ], esta contraseña le sirve para cambiarla en el Control Panel por otra que a usted le convenga.";
		$message.= "\n\nPara mayor seguridad estos cambios y solicitudes que usted realice con su cuenta, automáticamente son supervisadas por el Staff en general, no intente abusar de este sistema para evitar penalizaciones.";
		$message.= "\n\nAtentamente: Staff de Brawl RO.";
		mail($email, $asunto, $message, "From: BrawlNetwork");
		alert("Tu solicitud de Password ha sido enviada con exito a tu e-mail.");
	}
	else
	{
if (isset($_SESSION[$CONFIG_name.'sessioncode']))
	$session = $_SESSION[$CONFIG_name.'sessioncode'];
$session['account'] = rand(12345, 99999);
$_SESSION[$CONFIG_name.'sessioncode'] = $session;
$var = rand(10, 9999999);
	opentable("Recuperar Clave de Juego");
?>

	<form id="recuperar" onsubmit="return POST_ajax('recover.php','main_div','recuperar');">
		<table width="550">
			<tr>
				<td align="center" height="30" valign="middle">
					Para recuperar clave de la cuenta, por favor ingresa la informacion que se te solicita a continuacion:
				</td>
			</tr>
			<tr>
				<td align="center" height="20" valign="middle"><b>User ID:</b></td>
			</tr>
			<tr>
				<td align="center" height="30" valign="top">
					<input type="password" name="userid" maxlength="100" size="23" onkeypress="return force(this.name, this.form.id, event);">
				</td>
			</tr>
			<tr>
				<td align="center" height="20" valign="middle"><b>Correo:</b></td>
			</tr>
			<tr>
				<td align="center" height="30" valign="top">
					<input type="password" name="mail" maxlength="100" size="23" onkeypress="return force(this.name, this.form.id, event);">
					<script type="password/javascript" >email.add( Validate.Presence );
					email.add( Validate.Email );</script>
				</td>
			</tr>
<?php
	if ($CONFIG_auth_image && function_exists("gd_info")) { 
		echo "<tr><td align=center><br><img src=\"img.php?img=account&var=$var\" alt=\"".$lang['SECURITY_CODE']."\">
		</td></tr><tr><td align=center>".$lang['CODE'].":
		<input type=\"text\" name=\"code\" maxlength=\"6\" size=\"6\" onKeyPress=\"return force(this.name,this.form.id,event);\">
		&nbsp;</td></tr>";
}
?>
			<tr>
				<td align="center" height="50" valign="middle">
					<input type="submit" value="Realizar Solicitud">
				</td>
			</tr>
		</table>
		<input type="hidden" name="opt" value="1">
	</form>
<?php
	}
	closetable();
?>