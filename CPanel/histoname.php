<?php

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

DEFINE('HISTORNAME', "SELECT `fecha`, `old_name`, `new_name` FROM `log_namechange` ORDER BY `fecha` ASC");

$query = sprintf(HISTORNAME);
$result = execute_query($query, "histoname.php");

opentable("Historial de Cambios de Nombres");
echo "
<hr><table width=\"600\">
<tr>
	<td align=\"right\" class=\"head\">".$lang['POS']."</td>
	<td>&nbsp;</td>
	<td align=\"center\" class=\"head\">Fecha de Cambio</td>
	<td>&nbsp;</td>
	<td align=\"left\" class=\"head\">Antiguo Nombre</td>
	<td>&nbsp;</td>
	<td align=\"left\" class=\"head\">Nuevo Nombre</td>
</tr>
";
$nusers = 0;
if ($result) {
	while ($line = $result->fetch_row()) {
				$nusers++;

				echo '    
				<tr>
					<td align="right">'.$nusers.'</td>
					<td>&nbsp;</td>
					<td align="center">'.$line[0].'</td>
					<td>&nbsp;</td>
					<td align="left">'.$line[1].'</td>
					<td>&nbsp;</td>
					<td align="left">'.$line[2].'</td>	
				</tr>';
	}
}
echo "</table>";
closetable();
fim();
?>