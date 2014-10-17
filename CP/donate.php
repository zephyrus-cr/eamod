<?php
	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	if (!isset($_SESSION[$CONFIG['Name'] . 'account_id']) || $_SESSION[$CONFIG['Name'] . 'account_id'] <= 0)
		redir("cuentas.php", "main_div", "Primero selecciona una cuenta de juego para proceder.<br>Click aqui para seleccionar otra cuenta.");

	$account_id = $_SESSION[$CONFIG['Name'] . 'account_id'];
	$cash_points = 0;

	if( $result = $mysql->fetchrow($mysql->query("SELECT `cash_points` FROM `login` WHERE `account_id` = '$account_id'", $CONFIG['DBMain'])) )
		$cash_points = $result[0];

	if( isset($_POST['opt']) && $_POST['opt'] == 1 )
	{
		if(strlen($_POST['reference']) < 1 || strlen($_POST['reference']) > 40 || inject($_POST['reference']))
			redir("donate.php", "main_div", "Error en el Numero de Referencia (caracteres invalidos o largo incorrecto)<br>Click aqui para volver a intentar.");

		if(strlen($_POST['place']) < 1 || strlen($_POST['place']) > 40 || inject($_POST['place']))
			redir("donate.php", "main_div", "Error en el Lugar de Deposito (caracteres invalidos o largo incorrecto)<br>Click aqui para volver a intentar.");

		if(!isset($_POST['amount']) || notnumber($_POST['amount']) || $_POST['amount'] <= 0)
			redir("donate.php", "main_div", "Valor incorrecto de Monto<br>Click aqui para volver a intentar.");

		if(!isset($_POST['moneda']) || notnumber($_POST['moneda']) || $_POST['moneda'] < 0 || $_POST['moneda'] > 2 )
			redir("donate.php", "main_div", "Valor incorrecto de Moneda<br>Click aqui para volver a intentar.");

		// Reportando
		$mysql->query("
			INSERT INTO `cp_donatives`
				(`reference`, `amount`, `coin`, `place`, `status`, `account_id`, `date`, `nombre`, `email`)
			VALUES
				('" . $_POST['reference'] . "', '" . $_POST['amount'] . "', '" . $_POST['moneda'] . "', '" . $_POST['place'] . "', '0', '$account_id', NOW(), '" . $_SESSION[$CONFIG['Name'] . 'nombre'] . "', '" . $_SESSION[$CONFIG['Name'] . 'email'] . "')
		", $CONFIG['DBLogs']);

		redir("donate.php", "main_div", "Tu donativo ha sido reportado, cuando el Staff lo confirme, sera trasladado a tu Fondo de Cuenta.<br>Click aqui para ver los donativos.");
	}

	opentable("Reporte de Donativos de Miembro");
?>
	<table width="550">
		<tr>
			<td align="left">
				Bienvenido a la Secci&oacute;n de Reporte de Donaciones al servidor Evangelis Ragnarok. Aqu&iacute; podr&aacute;s controlar el estado de donaciones, as&iacute; como reportar nuevas.<br>
				Las donaciones tienen el fin principal de cubrir los gastos del servidor e invertir en infraestructura para mejorar nuestros servicios. Pero para motivar a los usuarios a cooperar
				con este servicio gratuito, se les d&aacute; la opcio&oacute;n de conseguir <b>Puntos Sagrados</b> en el juego que podr&aacute;n usar para comprar art&iacute;culos en cualquiera de los
				<b>Premium Dealer</b> que encontrar&aacute;s en el juego, en todas las ciudades.<br>
				<br>
				<center><img src="images/item/large/670.png">&nbsp;&nbsp;&nbsp;<img src="images/item/large/672.png">&nbsp;&nbsp;&nbsp;<img src="images/item/large/676.png"><br></center>
				<br>
				<b>Reportando Donaciones:</b><br>
				Para reportar una donaci&oacute;n que hayas realizado, necesitar&aacute; saber el N&uacute;mero de Comprobante o Recibo (normalmente viene al lado de la fecha en el papel que te entregan
				en el banco, en el cajero o en paypal). Tambi&eacute;n como detalle necesitamos saber el lugar en donde realizaste el aporte y la moneda. Nosotros realizaremos la conversi&oacute;n
				en <b>Puntos Sagrados</b> cuando aprobemos tu donaci&oacute;n, lo cual puede tardar de 1 a 24 horas.<br>
				<br>
				<b>Moneda a Cash Points:</b><br>
				500 Pesos Chilenos = 1500 <b>Puntos Sagrados</b><br>
				<br>
			</td>
		</tr>
		<tr>
			<td align="center" height="10" valign="top">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" height="10" valign="top"><img src="images/item/small/674.png">&nbsp;&nbsp;<img src="images/item/small/674.png"><br>Puntos Sagrados Actuales : <b><?php echo moneyformat($cash_points); ?></b><br><img src="images/item/small/674.png">&nbsp;&nbsp;<img src="images/item/small/674.png"></td>
		</tr>
		<tr>
			<td align="center" height="10" valign="top">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" height="10" valign="middle">
				<hr>
				Reporta tu donativo llenado el formulario a continuaci&oacute;n<br><br>
				<form id="donate" onsubmit="return POST_ajax('donate.php','main_div','donate');">
					<table width="500">
						<tr>
							<td align="center"><b>Comprobante<br>(N&uacute;mero de Referencia)</b></td>
							<td align="center"><b>Monto Aportado<br>(Solo N&uacute;meros Enteros)</b></td>
							<td align="center"><b>Moneda</b></td>
							<td align="center"><b>Lugar de<br>Dep&oacute;sito</b></td>
						</tr>
						<tr>
							<td align="center"><input type="text" name="reference" maxlength="20" size="20" onkeypress="return force(this.name, this.form.id, event);"></td>
							<td align="center"><input type="text" name="amount" maxlength="10" size="10" onkeypress="return force(this.name, this.form.id, event);"></td>
							<td align="center">
								<select name="moneda" onKeyPress="return force(this.name,this.form.id,event);">
									<option value="0" selected>Peso(Chile)
								</select>
							</td>
							<td align="center"><input type="text" name="place" maxlength="20" size="20" onkeypress="return force(this.name, this.form.id, event);"></td>
						</tr>
						<tr>
							<td align="center" colspan="4" valign="middle" headers="20">
								<input type="submit" value="Reportar este Donativo">
								<input type="hidden" name="opt" value="1">
							</td>
						</tr>
					</table>
				</form>
				<br>
				** <b>Por razones de pol&iacute;ticas de servicio<br>
				<font color="Red">Reportes Falsos de Donaciones</font> ser&aacute;n sancionados en el juego con baneo de la cuenta.</b><br><br>
				Para acelerar tu tramite de aprobaci&oacute;n, env&iacute;a una copia escaneada o fotograf&iacute;a del comprobante al correo evangelis-ro@hotmail.com
				<hr>
			</td>
		</tr>
		<tr>
			<td align="center" height="10" valign="top">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" valign="top">
				<table width="550">
					<tr>
						<td align="center" class="header" colspan="9"><font color="Navy" size="2"><b>Reporte de Movimientos</b></font></td>
					</tr>
					<tr>
						<td align="center" class="header" colspan="9"><hr></td>
					</tr>
					<tr>
						<td align="left" class="header">Fecha de Reporte</td>
						<td align="center">&nbsp;</td>
						<td align="center" class="header"><b>N&uacute;mero de Comprobante</b></td>
						<td align="center">&nbsp;</td>
						<td align="right" class="header">Monto Depositado</td>
						<td align="center">&nbsp;</td>
						<td align="center" class="header">Lugar de Dep&oacute;sito</td>
						<td align="center">&nbsp;</td>
						<td align="right" class="header">Comprobaci&oacute;n</td>
					</tr>
<?php
	$result = $mysql->query("
		SELECT
			`id`, `reference`, `amount`, `coin`, `place`, `status`, `date`
		FROM
			`cp_donatives`
		WHERE
			`account_id` = '$account_id'
		ORDER BY
			`date` DESC
	", $CONFIG['DBLogs']);

	$simbolo = array("USA Dolar","CL Peso","CR Colon");

	while ($line = $mysql->fetcharray($result))
	{
		echo '
			<tr>
				<td align="left">' . $line['date'] . '</td>
				<td align="center">&nbsp;</td>
				<td align="center">' . $line['reference'] . '</td>
				<td align="center">&nbsp;</td>
				<td align="right">' . $simbolo[$line['coin']] . ' ' . moneyformat($line['amount']) . '.00</td>
				<td align="center">&nbsp;</td>
				<td align="center">' . $line['place'] . '</td>
				<td align="center">&nbsp;</td>
				<td align="right">
		';

		switch ($line['status'])
		{
			case 0: echo '<font color="Gray">Sin aprobar</font>'; break;
			case 1: echo '<font color="Green">Aprobado</font>'; break;
			case 2: echo '<font color="Red">No Aprobado</font>'; break;
		}

		echo '
				</td>
			</tr>
		';
	}

?>
				</table>
			</td>
		</tr>
	</table>
<?php
	closetable();
?>