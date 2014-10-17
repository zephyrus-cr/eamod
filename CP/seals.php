<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	$result = $mysql->query("
		SELECT
			`varname`, `value`
		FROM
			`mapreg`
		WHERE
			`varname` LIKE '\$god%'
	" , $CONFIG['DBMain']);

	$seals = array(
		'$god1' => 0,
		'$god2' => 0,
		'$god3' => 0,
		'$god4' => 0,
	);

	while( $data = $mysql->fetcharray($result) )
		$seals[strtolower($data['varname'])] = $data['value'];

	opentable('God Seals Quest Status');
?>
	<table width="550">
		<tr>
			<td align="center" colspan="4">
				Informaci&oacute;n del progreso de la Quest de los Sellos y pr&oacute;xima apertura de los mismos en el Servidor.
				La Gu&iacute;a para la Quest la pueden encontrar haciendo click sobre el dibujo de cada parte de los items de los Sellos.<br><br>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" class="head"><a href="http://foro.terra-gaming.com/index.php?/topic/444-quest-godly-artifacts-quest-quest-para-romper-el-sello-de-sleipnir-adicional-quest-the-mad-scientific/"><img src="./images/item/large/2410.png" border="0"></a></td>
			<td align="center" class="head"><a href="http://foro.terra-gaming.com/index.php?/topic/450-quest-godly-artifacts-quest-quest-para-romper-el-sello-de-megingjard/"><img src="./images/item/large/2629.png" border="0"></a></td>
			<td align="center" class="head"><a href="http://foro.terra-gaming.com/index.php?/topic/451-quest-godly-artifacts-quest-quest-para-romper-el-sello-de-brisingamen/"><img src="./images/item/large/2630.png" border="0"></a></td>
			<td align="center" class="head"><a href="http://foro.terra-gaming.com/index.php?/topic/452-quest-godly-artifacts-quest-quest-para-romper-el-sello-de-mjolnir/"><img src="./images/item/large/1530.png" border="0"></a></td>
		</tr>
		<tr>
			<td align="center" class="head">Seal of<br>Sleipnir</td>
			<td align="center" class="head">Seal of<br>Megingjard</td>
			<td align="center" class="head">Seal of<br>Brisingamen</td>
			<td align="center" class="head">Seal of<br>Mjolnir</td>
		</tr>
<?php

	$status = array(
		'$god1' => (($seals['$god1'] == 100) ? 'The 1st seal<br>has been released':($seals['$god1'] >= 50) ? 'The 1st seal<br>has appeared':''),
		'$god2' => (($seals['$god2'] == 100) ? 'The 2nd seal<br>has been released':($seals['$god2'] >= 50) ? 'The 2nd seal<br>has appeared':''),
		'$god3' => (($seals['$god3'] == 100) ? 'The 3rd seal<br>has been released':($seals['$god3'] >= 50) ? 'The 3rd seal<br>has appeared':''),
		'$god4' => (($seals['$god4'] == 100) ? 'The 4th seal<br>has been released':($seals['$god4'] >= 50) ? 'The 4th seal<br>has appeared':''),
	);

	echo '
		<tr>
			<td align="center">' . $seals['$god1'] . '</td>
			<td align="center">' . $seals['$god2'] . '</td>
			<td align="center">' . $seals['$god3'] . '</td>
			<td align="center">' . $seals['$god4'] . '</td>
		</tr>
		<tr>
			<td align="center"><b><i>' . $status['$god1'] . '</b></i></td>
			<td align="center"><b><i>' . $status['$god2'] . '</b></i></td>
			<td align="center"><b><i>' . $status['$god3'] . '</b></i></td>
			<td align="center"><b><i>' . $status['$god4'] . '</b></i></td>
		</tr>
	</table>
	';

	closetable();
?>
