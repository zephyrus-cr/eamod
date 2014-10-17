<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	if (!empty($_GET['opt']))
	{
		if (inject($_GET['buscar']))
			redir("lognames.php", "main_div", "Caracteres invalidos en el termino de Busqueda.");

		$consulta = "
			SELECT
				`old_name`, `new_name`, `date`
			FROM
				`cp_nameslog`
			WHERE
				`old_name` LIKE '%" . $_GET['buscar'] . "%' OR `new_name` LIKE '%" . $_GET['buscar'] . "%'
			ORDER BY
				`id` DESC
			LIMIT 50
		";
	} else
		$consulta = "
			SELECT
				`old_name`, `new_name`, `date`
			FROM
				`cp_nameslog`
			ORDER BY
				`id` DESC
			LIMIT 50
		";

	$log = $mysql->query($consulta, $CONFIG['DBLogs']);

	opentable("Registro de Cambio de Nombres");

?>
	<table width="550">
		<tr>
			<td align="center" class="head">
				Buscar en el Registro de Cambios
			</td>
		</tr>
		<tr>
			<td align="center">
				<form id="busqueda" onsubmit="return GET_ajax('lognames.php','main_div','busqueda')">
					<input type="text" name="buscar"maxlength="24" size="24" onKeyPress="return force(this.name,this.form.id,event);">
					<input type="hidden" name="opt" value=1>
					&nbsp;
					<input type="submit" value="Buscar">
				</form>
			</td>
		</tr>
	</table>
	<table width="550">
		<tr>
			<td align="left" class="head">Fecha de Cambio</td>
			<td align="center" class="head"> | </td>
			<td align="left" class="head">Nombre Anterior</td>
			<td align="center" class="head"> | </td>
			<td align="left" class="head">Nombre Nuevo</td>
		</tr>
<?php
	if ($log)
	{
		while ($line = $mysql->fetcharray($log))
		{
			echo '
				<tr>
					<td align="left">' . htmlformat($line['date']) . '</td>
					<td align="center" class="head"> | </td>
					<td align="left">' . htmlformat($line['old_name']) . '</td>
					<td align="center" class="head"> | </td>
					<td align="left">' . htmlformat($line['new_name']) . '</td>
				</tr>
			';
		}
	}

	echo "
		</table>
	";

	closetable();
?>