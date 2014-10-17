<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!isset($_SESSION[$CONFIG['Name'] . 'member_id']) || $_SESSION[$CONFIG['Name'] . 'member_id'] <= 0)
		redir("news.php", "main_div", "Debes estar logeado con tu cuenta de Miembro para accesar aca");

	if (!isset($_SESSION[$CONFIG['Name'] . 'mlevel']) || $_SESSION[$CONFIG['Name'] . 'mlevel'] < 1)
		redir("news.php", "main_div", "No estas autorizado para entrar a esta seccion.<br>Click para regresar.");

	if (!isset($_GET['char_id']) || !is_numeric($_GET['char_id']))
	{ // Ingreso del ID del Personaje
		opentable("Administrativo de Items - Movimientos");
?>
	<form id="buscar" onsubmit="return GET_ajax('admintrade.php','main_div','buscar')">
		<table width="580">
			<tr>
				<td align="center" colspan="3">
					Para realizar busquedas precisas de movimientos de items, ingrese el ID del Personaje que sea buscar.
				</td>
			</tr>
			<tr>
				<td align="right" width="46%">ID del Personaje:</td>
				<td width="8%">&nbsp;</td>
				<td align="left" width="46%"><input type="text" name="char_id" maxlength="10" size="10" onKeyPress="return force(this.name,this.form.id,event);"></td>
			</tr>
			<tr>
				<td align="center" colspan="3">
					<input type="submit" value="Buscar">
				</td>
			</tr>
		</table>
	</form>
<?php
		closetable();
		exit(0);
	}

	$tradetype = array (
		'T' => 'Trades de Jugador',
		'V' => 'Ventas de Merchant',
		'P' => 'Dropeo de Suelo',
		'L' => 'Dropeo de Mob',
		'S' => 'Comercio con NPC',
		'N' => 'Quest NPC/Refine',
		'M' => 'Robado de Mob/MVP',
		'C' => 'Consumido',
		'A' => 'Creado por Comando',
		'R' => 'Storage Kafra',
		'G' => 'Storage Guild',
		'E' => 'MailBox',
	);

	$items = $_SESSION[$CONFIG['Name'] . 'itemdb'];
	$prefixdb = $_SESSION[$CONFIG['Name'] . 'cardpre'];

	$char_id = $_GET['char_id'];
	$result = $mysql->query("SELECT `name` FROM `char` WHERE `char_id` = '$char_id'", $CONFIG['DBMain']);

	if( !($char = $mysql->fetcharray($result)) )
		$chars[$char_id] = '--Eliminado--';
	else
		$chars[$char_id] = $char['name'];

	if( $_SESSION[$CONFIG_Name . 'tradelog'] < time() )
	{ // Updating Trade List
		$result = $mysql->query("
				SELECT
					`id`, `time`, `type`, `nameid`, `amount`, `refine`, `card0`, `card1`, `card2`, `card3`, `map`, `char_id`
				FROM
					`picklog`
				WHERE
					`picklog`.`time` > DATE_SUB(NOW(), INTERVAL 20 DAY) AND `char_id` = '$char_id'
		", $CONFIG['DBLogs']);

		$count = $mysql->countrows($result);
		$data = array();

		for( $i = $count - 1; ($line = $mysql->fetcharray($result)); $i-- )
		{
			$data[$i] = array(
				'id' => $line['id'],
				'time' => $line['time'],
				'type' => $line['type'],
				'nameid' => $line['nameid'],
				'amount' => $line['amount'],
				'refine' => $line['refine'],
				'card0' => $line['card0'],
				'card1' => $line['card1'],
				'card2' => $line['card2'],
				'card3' => $line['card3'],
				'map' => $line['map'],
				'char_id' => $line['char_id'],
			);
		}

		$_SESSION[$CONFIG_Name . 'tradelog'] = time() + 1800;
		$_SESSION[$CONFIG_Name . 'trades'] = $data;
	}

	$dblog = $_SESSION[$CONFIG['Name'] . 'trades'];

	// Default Values
	if( !isset($_GET['nameid']) ) $_GET['nameid'] = '';
	if( !isset($_GET['refine']) || !is_numeric($_GET['refine']) ) $_GET['refine'] = -1;
	if( !isset($_GET['card']) || !is_numeric($_GET['card']) ) $_GET['card'] = 0;
	if( !isset($_GET['type']) ) $_GET['type'] = 'X';

	opentable("Registro de Movimientos de Items");
?>
	<form id="buscar" onsubmit="return GET_ajax('admintrade.php','main_div','buscar')">
		<table width="580">
			<tr>
				<td align="center" colspan="3">
					La informacion mostrada aca no es prueba legal suficiente para demostrar un robo o extravio de items, puedes usar estos reportes como consultas a tus movimientos de items y ver quien tiene o donde esta un articulo.
					Si sospecha de robo, notificalo al staff con fecha y hora del movimiento. <b>Los logs son borrados cuando superan el mes de antiguedad</b>.<br>
					Se paciente, las consultas de este tipo pueden tardar hasta 1 minuto en obtener los resultados.<br>El Log de Trades se actualiza cada 30 minutos.<br><br>
				</td>
			</tr>
			<tr>
				<td align="right" width="46%">Nombre del Item:</td>
				<td width="8%">&nbsp;</td>
				<td align="left" width="46%"><input type="text" name="nameid" maxlength="24" size="24" onKeyPress="return force(this.name,this.form.id,event);" value="<?php echo $_GET['nameid']; ?>"></td>
			</tr>
			<tr>
				<td align="right">Refinado:</td>
				<td>&nbsp;</td>
				<td align="left">
					<select name="refine">
						<option value="-1" selected>-
						<option value="0">0
						<option value="1">1
						<option value="2">2
						<option value="3">3
						<option value="4">4
						<option value="5">5
						<option value="6">6
						<option value="7">7
						<option value="8">8
						<option value="9">9
						<option value="10">10
					</select>
				</td>
			</tr>
			<tr>
				<td align="right">ID de Carta:</td>
				<td>&nbsp;</td>
				<td align="left"><input type="text" name="card" maxlength="4" size="4" onKeyPress="return force(this.name,this.form.id,event);" value="<?php echo ($_GET['card'] == 0)?'':$_GET['card']; ?>"></td>
			</tr>
			<tr>
				<td align="right">Tipo de Trade:</td>
				<td>&nbsp;</td>
				<td align="left">
					<select name="type">
						<option value="X" selected>Todos
						<option value="T">Trades de Jugador
						<option value="V">Ventas de Merchant
						<option value="P">Dropeo al Suelo
						<option value="L">Dropeo de Mobs
						<option value="S">Comercio con NPC
						<option value="N">Quest NPC/Refine
						<option value="M">Robado de Mob/MVP
						<option value="C">Consumido
						<option value="A">Creado por Comando
						<option value="R">Storage Kafra
						<option value="G">Storage Guild
						<option value="E">Buzon de Correo
					</select>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="3">
					<input type="submit" value="Buscar">
				</td>
			</tr>
			<tr><td align="center" colspan="3"><hr></td></tr>
			<tr><td align="center" colspan="3"><div id="tradeinfo"><center>Aca se muestra la informacion de un Trade al dar click en <b>Info</b></center></div></td></tr>
			<tr><td align="center" colspan="3"><hr></td></tr>
		</table>
	</form>
	<table width="580">
		<tr>
			<td align="left" class="head">Hora</td>
			<td>&nbsp;</td>
			<td align="left" class="head" colspan="3">Cantidad e Item</td>
			<td>&nbsp;</td>
			<td align="left" class="head">Personaje</td>
			<td>&nbsp;</td>
			<td align="left" class="head">Tipo Movimiento</td>
			<td>&nbsp;</td>
			<td align="left" class="head">Mapa</td>
			<td>&nbsp;</td>
			<td align="left" class="head">Info</td>
		</tr>
<?php
	// Trade Log Request
	$count = 0;
	$j = 0;

	$fecha = '';

	while( $count < 100 && isset($dblog[$j]) )
	{
		$data = $dblog[$j];

		if( ($_GET['nameid'] == '' || stristr($items[$data['nameid']], $_GET['nameid'])) &&
			($_GET['refine'] == -1 || $data['refine'] == $_GET['refine']) &&
			($_GET['card'] == 0 || $data['card0'] == $_GET['card'] || $data['card1'] == $_GET['card'] || $data['card2'] == $_GET['card'] || $data['card3'] == $_GET['card']) &&
			($_GET['type'] == 'X' || $data['type'] == $_GET['type']) )
		{
			if( strcmp($fecha, htmlformat(substr($data['time'], 0, 10))) != 0 )
			{
				$fecha = htmlformat(substr($data['time'], 0, 10));
				echo('
					<tr>
						<td align="left" colspan="13">
							<hr>
							<b>' . $fecha . '</b>
						</td>
					</tr>
				');
			}

			$id = $data['id'];
			$hora = htmlformat(substr($data['time'], 10));
			$card0 = $data['card0'];
			$card1 = $data['card1'];
			$card2 = $data['card2'];
			$card3 = $data['card3'];

			// Construccion del Nombre del Item
			$item = '';
			$postfix = '';
			if( $data['refine'] ) $item = '+'.$data['refine'].' ';

			// Detalle de Cartas
			if( $data['card0'] > 4000 )
			{ // Card0
				$i = 1;
				if( $data['card0'] == $data['card1'] ) { $i += 1; $data['card1'] = 0; }
				if( $data['card0'] == $data['card2'] ) { $i += 1; $data['card2'] = 0; }
				if( $data['card0'] == $data['card3'] ) { $i += 1; $data['card3'] = 0; }

				$item .= cardcounter($i);

				if( substr($prefixdb[$data['card0']], 0, 2) == 'of' ) $postfix .= ' ' . htmlformat($prefixdb[$data['card0']]);
				else $item .= htmlformat($prefixdb[$data['card0']]) . ' ';

				if( $data['card1'] > 0 )
				{ // Card1
					$i = 1;
					if( $data['card1'] == $data['card2'] ) { $i += 1; $data['card2'] = 0; }
					if( $data['card1'] == $data['card3'] ) { $i += 1; $data['card3'] = 0; }
					$item .= cardcounter($i);
					if( substr($prefixdb[$data['card1']], 0, 2) == 'of' ) $postfix .= ' ' . htmlformat($prefixdb[$data['card1']]);
					else $item .= htmlformat($prefixdb[$data['card1']]) . ' ';
				}

				if( $data['card2'] > 0 )
				{ // Card2
					$i = 1;
					if( $data['card2'] == $data['card3'] ) { $i += 1; $data['card3'] = 0; }
					$item .= cardcounter($i);
					if( substr($prefixdb[$data['card2']], 0, 2) == 'of' ) $postfix .= ' ' . htmlformat($prefixdb[$data['card2']]);
					else $item .= htmlformat($prefixdb[$data['card2']]) . ' ';
				}

				if( $data['card3'] > 0 )
				{ // Card3
					if( substr($prefixdb[$data['card3']], 0, 2) == 'of' ) $postfix .= ' ' . htmlformat($prefixdb[$data['card3']]);
					else $item .= htmlformat($prefixdb[$data['card3']]) . ' ';
				}
			}
			elseif( $data['card0'] > 0 )
			{ // Produccion
				$item .= "(".$data['card2']."|".$data['card3'].")'s ";
			}

			if( isset($items[$data['nameid']]) )
				$item .= $items[$data['nameid']] . $postfix;
			else
				$item .= 'Custom Evangelis' . $postfix . '(' . $data['nameid'] . ')';

			// Output
			echo '
				<tr>
					<td align="left">' . $hora . '</td>
					<td>&nbsp;</td>
					<td align="right" width="20px"><b>' . $data['amount'] . '</b></td>
					<td>&nbsp;</td>
					<td align="left">' . $item . '</td>
					<td>&nbsp;</td>
					<td align="left">' . htmlformat($chars[$data['char_id']]) . '</td>
					<td>&nbsp;</td>
					<td align="left">' . $tradetype[$data['type']] . '</td>
					<td>&nbsp;</td>
					<td align="left">' . htmlformat($data['map']) . '</td>
					<td>&nbsp;</td>
					<td align="left">
			';

			if( (!strcmp($data['type'],'T') || !strcmp($data['type'],'P') || !strcmp($data['type'],'V') || !strcmp($data['type'],'E')) && $data['amount'] < 0 )
			{ // Busqueda del Destinatario/Origen del Trade
				echo '
					<form id="buscar' . $j . '" onsubmit="return GET_ajax(\'tradeinfo.php\',\'tradeinfo\',\'buscar' . $j . '\')">
						<input type="hidden" name="opt" value="2">
						<input type="hidden" name="id" value="' . $id . '">
						<input type="hidden" name="fecha" value="' . $data['time']  . '">
						<input type="hidden" name="type" value="' . $data['type']  . '">
						<input type="hidden" name="nameid" value="' . $data['nameid']  . '">
						<input type="hidden" name="amount" value="' . $data['amount']  . '">
						<input type="hidden" name="refine" value="' . $data['refine']  . '">
						<input type="hidden" name="card0" value="' . $card0 . '">
						<input type="hidden" name="card1" value="' . $card1 . '">
						<input type="hidden" name="card2" value="' . $card2 . '">
						<input type="hidden" name="card3" value="' . $card3 . '">
						<input type="hidden" name="map" value="' . $data['map'] . '">
						<input type="hidden" name="origen" value="' . $chars[$data['char_id']] . '">
						<input type="hidden" name="char_id" value="' . $char_id . '">
						<input type="submit" value="Info">
					</form>
				';
			}
			else
			{
				echo('...');
			}

			echo '
					</td>
				</tr>
			';

			$count++;
		}

		$j++;
	}

	echo '
			<tr>
				<td align="left" colspan="13"><hr></td>
			</tr>
		</table>
	';
	closetable();
?>