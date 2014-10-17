<?php
	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca.");

	if (!isset($_SESSION[$CONFIG['Name'] . 'account_id']) || $_SESSION[$CONFIG['Name'] . 'account_id'] <= 0)
		redir("cuentas.php", "main_div", "Primero selecciona una cuenta de juego para proceder.<br>Click aqui para seleccionar otra cuenta.");

	if (is_online())
		redir("cuentas.php", "main_div", "No puedes usar este servicio con la cuenta Activa en el juego.<br>Deslogeate del juego y vuelve a intentarlo.<br>Click aqui para seleccionar otra cuenta.");

	$member_id = $_SESSION[$CONFIG['Name'] . 'member_id'];
	$services = 0;
	if ($result = $mysql->fetchrow($mysql->query("SELECT `services` FROM `members` WHERE `member_id` = '$member_id'", $CONFIG['DBMain'])))
		$services = $result[0];

	if( isset($_POST['opt']) && $_POST['opt'] == 1 )
	{ // Changing a Name
		if( $services < 1 )
			redir("donate.php", "main_div", "Ya no tienes puntos de servicio.<br>Click aqui para comprar <b>Puntos de Servicio</b>.");

		if( invalid_name($_POST['Nnombre']) )
			redir("changename.php", "main_div", "Hay caracteres invalidos en el nombre.<br>Click aqui para regresar.");
		if( invalid_name($_POST['Onombre']) )
			redir("changename.php", "main_div", "Hay caracteres invalidos en el nombre origen.<br>Click aqui para regresar.");
		if (strlen(trim($_POST['Nnombre'])) < 4 || strlen(trim($_POST['Nnombre'])) > 23)
			redir("changename.php", "main_div", "El largo del nombre es incorrecto, debe ser de 1 a 24 caracteres.<br>Click aqui para regresar.");

		$Oname = $mysql->escapestr(trim($_POST['Onombre']));
		$Ename = $mysql->escapestr(trim($_POST['Nnombre']));
		$char_id = $_POST['charid'];

		if( $mysql->countrows($mysql->query("SELECT `char_id` FROM `char` WHERE `name` = '" . $Ename . "'", $CONFIG['DBMain'])) > 0 )
			redir("changename.php", "main_div", "El nombre indicado ya esta en uso por algun personaje.<br>Click aqui para regresar.");

		if( $mysql->countrows($mysql->query("SELECT `char_id` FROM `char` WHERE `char_id` = '" . $char_id . "' AND (`guild_id` > 0 OR `party_id` > 0)", $CONFIG['DBMain'])) > 0 )
			redir("changename.php", "main_div", "Tu personaje debe estar fuera de Guild y Party para proceder.<br>Click aqui para regresar.");

		$mysql->query("INSERT INTO `cp_nameslog` (`date`, `old_name`, `new_name`) VALUES (NOW(),'$Oname','$Ename')", $CONFIG['DBLogs']);

		$mysql->query("UPDATE `members` SET `services` = `services` - 1 WHERE `member_id` = '$member_id'", $CONFIG['DBMain']);
		$services -= 1;

		// Update Char Name Querys
		$mysql->query("UPDATE `char` SET `name` = '$Ename' WHERE `char_id` = '$char_id'", $CONFIG['DBMain']);
		// Mail System
		$mysql->query("UPDATE `mail` SET `dest_name` = '$Ename' WHERE `dest_name` = '$Oname'", $CONFIG['DBMain']);
		$mysql->query("UPDATE `mail` SET `send_name` = '$Ename' WHERE `send_name` = '$Oname'", $CONFIG['DBMain']);
	}

	$result = $mysql->query("SELECT `char_id`, `name`, `char_num` FROM `char` WHERE `account_id` = '" . $_SESSION[$CONFIG['Name'] . 'account_id'] . "' ORDER BY `char_num`", $CONFIG['DBMain']);

	if( $mysql->countrows($result) < 1 )
		redir("cuentas.php", "main_div", "Esta cuenta no tiene personajes.<br>Click aqui para seleccionar cuenta.");

	opentable("Cambios de Nombre");
	echo '
		<table width="540">
			<tr>
				<td align="center" height="10" valign="top" colspan="3">
					Para cambiar el nombre de un personaje debes:<br>
					- Estar desconectado del juego.<br>
					- Tu personaje debe estar sin guild ni party.<br>
					- Tener 1 punto de servicio minimo, que sera utilizado.<br>
				</td>
			</tr>
			<tr>
				<td align="center" height="10" valign="top" colspan="3">Caracteres Validos</td>
			</tr>
			<tr>
				<td align="center" height="10" valign="top" colspan="3">
					<font size="2" color="blue">
					<b>a b c d e f g h i j k l m n &ntilde; o p q r s t u v w x y z</b><br><br>
					<b>A B C D E F G H I J K L M N &Ntilde; O P Q R S T U V W X Y Z</b><br><br>
					<b>1 2 3 4 5 6 7 8 9 0</b><br><br>
					<b>, . - * [ ] ~ (espacio) @<br><br>
					<b>&#0134;</b> (Alt + 0134) <b>&#0164;</b> (Alt + 0164) <b>&#0167;</b> (Alt + 0167)<br><br>
					<b>&#0171;</b> (Alt + 0171) <b>&#0187;</b> (Alt + 0187)</font>
				</td>
			</tr>
			<tr>
				<td align="center" height="10" valign="top" colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" height="10" valign="top" colspan="3">
					Puntos de Servicio: <b>' . $services . '</b>
				</td>
			</tr>
			<tr>
				<td align="center" height="10" valign="top" colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td align="left" class="head">Slot</td>
				<td align="left" class="head">Nombre de Char</td>
				<td align="center" class="head">Nuevo Nombre</td>
			</tr>
	';

	while( $line = $mysql->fetcharray($result) )
	{
		$char_id = $line['char_id'];
		$name = htmlformat($line['name']);
		$slot = $line['char_num'];

		echo '
			<tr>
				<td align="left">' . $slot . '</td>
				<td align="left">' . $name . '</td>
				<td align="center">
					<form id="ranura' . $slot . '" onsubmit="return POST_ajax(\'changename.php\',\'main_div\',\'ranura' . $slot . '\');">
						<input type="text" name="Nnombre" maxlength="24" size="24" onKeyPress="return force(this.name,this.form.id,event);">
						<input type="submit" value="Cambiar">
						<input type="hidden" name="opt" value="1">
						<input type="hidden" name="charid" value="' . $char_id . '">
						<input type="hidden" name="Onombre" value="' . $name . '">
					</form>
				</td>
			</tr>
		';
	}
	closetable();
?>