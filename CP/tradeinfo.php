<?php
	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	if (!isset($_SESSION[$CONFIG['Name'] . 'account_id']) || $_SESSION[$CONFIG['Name'] . 'account_id'] <= 0)
		redir("cuentas.php", "main_div", "Debes seleccionar una cuenta de juego para accesar aca.");

	if (!isset($_SESSION[$CONFIG_Name . 'tradedb']))
		redir("cuentas.php", "main_div", "Modo de consulta invalido.");

	switch( $_SESSION[$CONFIG_Name . 'tradedb'] )
	{
		case 1: $picklog = "picklog"; break;
		case 2: $picklog = "picklog_20090521"; break;
		default:
			redir("cuentas.php", "main_div", "Modo de consulta invalido.");
	}

	if( isset($_GET['opt']) && $_GET['opt'] == 2 )
	{
		$operacion = '>';
		$orden = 'ASC';

		if( $_GET['amount'] > 0 ) { $operacion = '<'; $orden = 'DESC'; }

		$result = $mysql->query("
			SELECT
				`char_id`, `name`, `time`, `id`
			FROM
				`$picklog`
			WHERE
				`id` $operacion '" . $_GET['id'] . "' AND `type` = '" . $_GET['type'] . "' AND
				`nameid` = '" . $_GET['nameid'] . "' AND `amount` = '" . ($_GET['amount'] * -1.0) . "' AND `refine` = '" . $_GET['refine'] . "' AND
				`card0` = '" . $_GET['card0'] . "' AND `card1` = '" . $_GET['card1'] . "' AND `card2` = '" . $_GET['card2'] . "' AND `card3` = '" . $_GET['card3'] . "'" . ($_GET['type'] != 'E' ? " AND `map` = '" . $_GET['map'] . "'" : "") . " AND `serial` = '" . $_GET['serial'] . "'
			ORDER BY
				`id` $orden
			LIMIT 1
		", $CONFIG['DBLogs']);

		if( $line = $mysql->fetcharray($result) )
		{
			$items = $_SESSION[$CONFIG['Name'] . 'itemdb'];

			echo '
				<table background="./images/light3.jpg">
					<tr>
						<td align="center" colspan="2">
							El resultado mas posible de origen|destino de este trade es <b> ' . htmlformat($line['name']) . '</b><br>
						</td>
					</tr>
					<tr>
						<td align="center" colspan="2">
							<b>Parametros de Busqueda Utilizados</b>
						</td>
					</tr>
					<tr>
						<td align="center">
							<b>Jugador ' . ($_GET['amount'] > 0 ? "que Recibe" : "que Entrega") . '</b>
						</td>
						<td align="center">
							<b>Jugador ' . ($_GET['amount'] > 0 ? "que Entrega" : "que Recibe") . '</b>
						</td>
					</tr>
					<tr>
						<td align="center">
							' . htmlformat($_GET['origen']) . '
						</td>
						<td align="center">
							' . htmlformat($line['name']) . '
						</td>
					</tr>
					<tr>
						<td align="center" colspan="2">
							Estas son las fechas de distancia entre el log de tu trade (Consulta) y el log de recibido del jugador origen|destino del trade (Respuesta). Para que sea el mismo trade la diferencia debe ser de milisegundos.<br>
						</td>
					</tr>
					<tr>
						<td align="center">
							<b>Fecha Consulta</b>
						</td>
						<td align="center">
							<b>Fecha Respuesta</b>
						</td>
					</tr>
					<tr>
						<td align="center">
							' . htmlformat($_GET['fecha']) . '
						</td>
						<td align="center">
							' . htmlformat($line['time']) . '
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>ID de Item:</b>
						</td>
						<td align="left">
							' . $_GET['nameid'] . '(' . $items[$_GET['nameid']] . ')
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>Cantidad:</b>
						</td>
						<td align="left">
							' . abs($_GET['amount']) . '
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>Refinado:</b>
						</td>
						<td align="left">
							' . $_GET['refine'] . '
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>Carta 1:</b>
						</td>
						<td align="left">
							' . $_GET['card0'] . '
							' . ($_GET['card0'] > 4000 ? " (" . $items[$_GET['card0']] . ")" : "" ) . '
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>Carta 2:</b>
						</td>
						<td align="left">
							' . $_GET['card1'] . '
							' . ($_GET['card1'] > 4000 ? " (" . $items[$_GET['card1']] . ")" : "" ) . '
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>Carta 3:</b>
						</td>
						<td align="left">
							' . $_GET['card2'] . '
							' . ($_GET['card2'] > 4000 ? " (" . $items[$_GET['card2']] . ")" : "" ) . '
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>Carta 4:</b>
						</td>
						<td align="left">
							' . $_GET['card3'] . '
							' . ($_GET['card3'] > 4000 ? " (" . $items[$_GET['card3']] . ")" : "" ) . '
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>Serial:</b>
						</td>
						<td align="left">
							' . ($_GET['serial'] != 0 ? $_GET['serial'] : '(no serializado)') . '
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>Mapa del Trade:</b>
						</td>
						<td align="left">
							' . $_GET['map'] . '
						</td>
					</tr>
					<tr>
						<td align="center" colspan="2">
							<b>IDs de los registros (uso Administrativo)</b>
						</td>
					</tr>
					<tr>
						<td align="center" colspan="2">
							' . $_GET['id'] . ' | ' . $line['id'] . '
						</td>
					</tr>
			';

			// Zeny on this trade...
			if( !strcmp($_GET['type'],'T') || !strcmp($_GET['type'],'V') )
			{
				$j = 0;
				echo '
					<tr>
						<td align="center" colspan="2">
							<b>Zeny Asociado a este Movimiento</b>
						</td>
					</tr>
				';

				$result = $mysql->query("
					SELECT
						`char_id`, `src_id`, `time`, `amount`, `id`
					FROM
						`zenylog`
					WHERE
						((`char_id` = '" . $_GET['char_id'] . "' AND `src_id` = '" . $line['char_id'] . "') OR (`char_id` = '" . $line['char_id'] . "' AND `src_id` = '" . $_GET['char_id'] . "')) AND
						`type` = '" . $_GET['type'] . "' AND `map` = '" . $_GET['map'] . "' AND
						ABS(TIMESTAMPDIFF(SECOND,`time`,'". $line['time'] . "')) <= 1
				", $CONFIG['DBLogs']);

				while( $zdata = $mysql->fetcharray($result) )
				{
					$j++;
					echo '
						<tr>
							<td align="center" colspan="2">
					';

					if( $zdata['char_id'] == $_GET['char_id'] )
						echo '' . $_GET['origen'] . ' recibe ' . $zdata['amount'] . ' (id ' . $zdata['id'] . ').';
					else if( $zdata['char_id'] == $line['char_id'] )
						echo '' . $line['name'] . ' recibe ' . $zdata['amount'] . ' (id ' . $zdata['id'] . ').';

					echo '
							</td>
						</tr>
					';
				}

				if( $j == 0 )
					echo '
						<tr>
							<td align="center" colspan="2">
								Sin relaciones con Zeny.
							</td>
						</tr>
					';
			}

			echo '
				</table>
			';
		}
		else
		{
			echo '<center>No se encontro un origen|destino del trade de este item. Consulte al staff si tiene problemas.</center>';
		}
	}
	else if( isset($_GET['opt']) && $_GET['opt'] == 3 && isset($_GET['serial']) && is_numeric($_GET['serial']) &&  $_GET['serial'] > 0 )
	{ // Rastreo de Serie Electrónica
		$tradetype = array (
			'T' => 'Trades',
			'V' => 'Ventas',
			'P' => 'Dropeo',
			'L' => 'Loteo',
			'S' => 'Ventas NPC',
			'N' => 'Quest/Refine',
			'M' => 'Robado Mob/MVP',
			'C' => 'Consumido',
			'A' => 'Comando',
			'R' => 'Storage',
			'G' => 'Guild Storage',
			'E' => 'Correo',
		);

		$account_id = $_SESSION[$CONFIG['Name'] . 'account_id'];
		$items = $_SESSION[$CONFIG['Name'] . 'itemdb'];

		$result = $mysql->query("
			SELECT
				`name`, `time`, `id`, `type`, `amount`, `account_id`
			FROM
				`$picklog`
			WHERE
				`nameid` = '" . $_GET['nameid'] . "' AND `serial` = '" . $_GET['serial'] . "'
			ORDER BY
				`id`
		", $CONFIG['DBLogs']);

		echo '
			<table width="400" cellpadding="2" cellspacing="0" border="0" background="./images/light3.jpg">
				<tr bgcolor="white">
					<td align="center" colspan="7">
						<b>Rastreo de Item</b><br>
						<b>Item</b> : ' . $items[$_GET['nameid']] . ' <b>Serial</b> : ' . $_GET['serial'] . '<br>
						<hr>
					</td>
				</tr>
				<tr>
					<td align="left" class="head">Fecha y Hora</td>
					<td>&nbsp;</td>
					<td align="left" class="head">Personaje</td>
					<td>&nbsp;</td>
					<td align="center" class="head">Direccion</td>
					<td>&nbsp;</td>
					<td align="center" class="head">Tipo Movimiento</td>
				<tr>
		';

		while( $data = $mysql->fetcharray($result) )
		{
			if( $data['account_id'] == $account_id )
				echo '<tr bgcolor="lightgreen">';
			else
				echo '<tr>';

			echo '
					<td align="left">
						' . htmlformat(substr($data['time'], 0, 10)) . '<br>' . htmlformat(substr($data['time'], 10)) . '
					</td>
					<td>&nbsp;</td>
					<td align="left"><b>' . htmlformat($data['name']) . '</b></td>
					<td>&nbsp;</td>
					<td align="center"><b><font color="' . ($data['amount'] > 0 ? 'blue">Entra' : 'red">Sale')  . '</font></b></td>
					<td>&nbsp;</td>
					<td align="center" class="head">' . $tradetype[$data['type']] . '</td>
				<tr>
			';
		}

		echo '
			</table>
		';
	}
	else
	{
		echo '<center>Problema en la consulta</center>';
	}
?>