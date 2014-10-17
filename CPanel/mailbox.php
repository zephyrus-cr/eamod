<?php
	session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';
	if (isset($POST_optdel))
	{
		$query1 = sprintf(DELMAILBOX);
		$result1 = execute_query($query1, "mailbox.php");
		alert("Los mensajes respondidos han sido borrados con éxito.");
		$POST_nummsg == "";
		$POST_destid == "";
		$POST_destname == "";
		$POST_messages == "";
		$queryload2 = sprintf(MAILBOX);
		$resultload2 = execute_query($queryload2, "mailbox.php");
	}
	else if (isset($POST_opt))
	{
		if ($POST_nummsg == "" || $POST_destid == "" || $POST_destname == "" || $POST_messages == ""){
			alert("No puedes dejar ningún campo vacío.");}

		$query2 = sprintf(NEWMAILBOX);
		$result2 = execute_query($query2, "mailbox.php");
		$query3 = sprintf(UPDMAILBOX);
		$result3 = execute_query($query3, "mailbox.php");
		alert("Tu mensaje ha sido enviado a su Mailbox con éxito.");
		$POST_nummsg == "";
		$POST_destid == "";
		$POST_destname == "";
		$POST_messages == "";
		$queryload1 = sprintf(MAILBOX);
		$resultload1 = execute_query($queryload1, "mailbox.php");
	}
	else
	{
		$query = sprintf(MAILBOX);
		$result = execute_query($query, "mailbox.php");
		?><b><center><h3>Mensajes Support Lady NPC Prontera (Quejas/Sugerencias)</h3></center></b>
			<form id="mailbox" onsubmit="return POST_ajax('mailbox.php','main_div','mailbox');"><table align="center" width=550 border=1><tr>
					<td align="center" colspan=7>
					Este sistema permite enviar un mensaje directo al Mailbox de un usuario con tan solo escribir los datos que esten en <font color="#0000FF"><b>AZUL</b></font> y el <font color="#0000FF"><b>Mensaje</b></font>, no puedes dejar ningun campo vacio.<br>
					</td>
			</tr><tr>
					<td align="center" class="head"><b><center>Numero Msg</center></b></td>
					<td align="center" class="head"><b><center>ID del personaje:</center></b></td>
					<td align="center" class="head"><b><center>Nombre del Personaje:</center></b></td>
					<td align="center" class="head"><b><center>Escribe el Mensaje:</center></b></td>
					<td align="center" class="head"><b><center>Enviar Mensaje:</center></b></td>
			</tr><tr>
					<td align="center" class="head"><input type="string" name="nummsg" size="5" onkeypress="return force(this.name, this.form.id, event);"></td>
					<td align="center" class="head"><input type="string" name="destid" size="23" onkeypress="return force(this.name, this.form.id, event);"></td>
					<td align="center" class="head"><input type="string" name="destname" size="23" onkeypress="return force(this.name, this.form.id, event);"></td>
					<td align="center" class="head"><textarea rows="1" name="messages" cols="20"></textarea></td>
					<td align="center" class="head"><input type="submit" value="Enviar" name="opt"></td>
			</tr></table></form>
		<br><center><form id="mailboxdelete" onsubmit="return POST_ajax('mailbox.php','main_div','mailboxdelete');"><input type="submit" size="100" value="Borrar todos los mensajes respondidos" name="optdel"></form></center><hr>
		<?php
		$i = 0;
		echo '<form id="mail'.$i.'" onsubmit="return POST_ajax(\'mailbox.php\',\'main_div\',\'mail'.$i.'\')">
			<table align="center" width=600 border=1>				
				<tr>
					<td align="center" width=30 class="head"><b><center>Numero<br>Msg</center></b></td>
					<td align="center" width=40 class="head"><b><center>Fecha<br>Msg</center></b></td>
					<td align="center" width=60 class="head"><b><center>ID<br>Personaje</center></b></td>
					<td align="center" width=80 class="head"><b><center>Nombre Personaje</center></b></td>
					<td align="center" width=300 class="head"><b><center>Mensaje</center></b></td>
					<td align="center" width=50 class="head"><b><center>Estado</center></b></td>
				</tr>';
if ($result) {
		while ($line = $result->fetch_row())
		{
		if ($line[6] == 'Pendiente'){
		echo '
					<tr><td align="center" width=30><b><font color="#0000FF">' . $line[2] . '</font></b></td>
					<td align="center" width=40>' . $line[3] . '</td>		
					<td align="center" width=60><b><font color="#0000FF">' . $line[0] . '</font></b></td>
					<td align="center" width=80><b><font color="#0000FF">' . $line[4] . '</font></b></td>
					<td align="center" width=300>' . $line[5] . '</td>
					<td align="center" width=50><b><font color="#FF0000">' . $line[6] . '</font></b></td></tr>			
		'; 
		$i++;	
		}
		if ($line[6] == 'Respondido'){
		echo '
					<tr><td align="center" width=30><b><font color="#0000FF">' . $line[2] . '</font></b></td>
					<td align="center" width=40>' . $line[3] . '</td>		
					<td align="center" width=60><b><font color="#0000FF">' . $line[0] . '</font></b></td>
					<td align="center" width=80><b><font color="#0000FF">' . $line[4] . '</font></b></td>
					<td align="center" width=300>' . $line[5] . '</td>
					<td align="center" width=50><b><font color="#00FF00">' . $line[6] . '</font></b></td></tr>			
		'; 
		$i++;	
		}	
		}
		echo '</table></form>';
	}
}
?>