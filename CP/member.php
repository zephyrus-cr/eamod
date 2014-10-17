<?php

	session_start();
	include_once 'config.php';
	include_once 'functions.php';

	function isipbanned()
	{
		global $mysql, $CONFIG_DBMain;

		$n = sscanf($_SERVER['REMOTE_ADDR'], "%d.%d.%d.%d", $p3, $p2, $p1, $p0);

		$result = $mysql->fetchrow($mysql->query("
			SELECT
				count(*)
			FROM
				`ipbanlist`
			WHERE
				`list` = '$p3.*.*.*' OR `list` = '$p3.$p2.*.*' OR `list` = '$p3.$p2.$p1.*' OR `list` = '$p3.$p2.$p1.$p0'
		", $CONFIG_DBMain));

		if ($result[0] == 0)
			return FALSE;
		else
			return TRUE;
	}

	opentable("Evangelis Ragnarok - Membresia");

	if (isset($_SESSION[$CONFIG['Name'] . 'member_id']) && $_SESSION[$CONFIG['Name'] . 'member_id'] > 0)
	{ // Ya esta logeado
?>
<table width="550" height="300">
	<tr>
		<td align="center" valign="middle" height="30">
			<b><font color="Red" size="2">Ya has iniciado sesi&oacute;n en este equipo!!</font></b><br>
			Debes salirte para poder iniciar con otra cuenta o crear una cuenta nueva.
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle" height="30">
			<span title="Terminar con tu sesion de administracion" style="cursor:pointer" onMouseOver="this.style.color='#FF3300'" onMouseOut="this.style.color='#FFFFFF'" onClick="LINK_ajax('login.php?opt=1','login_div');">
				</b>Terminar Sesion</b>
			</span>
		</td>
	</tr>
</table>
<?php
	}
	elseif (!isset($_POST['opt']))
	{
		$_SESSION[$CONFIG['Name'] . 'securitycode'] = rand(12345,99999);
		$fakecode = rand(11111,99999);
?>
<table width="550" height="500">
	<tr>
		<td width="49%" align="center" valign="top">
			<form id="memberlog" onsubmit="return POST_ajax('member.php','main_div','memberlog');">
				<table width="100%">
					<tr>
						<td align="center" height="30" valign="middle"><b><font color="Red" size="2">Ya soy Miembro</font></b></td>
					</tr>
					<tr>
						<td align="center" height="50" valign="middle">
							<img src="po1.gif">
						</td>
					</tr>
					<tr>
						<td align="center" height="30" valign="middle">
							Ingresa los datos que se solicitan a continuacion. Los mismos que usaste al crear tu membresia en Evangelis Ragnarok.
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="middle">
							<b>Correo Electr&oacute;nico</b>
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="top">
							<input type="text" name="email" maxlength="39" size="39" onkeypress="return force(this.name, this.form.id, event);">
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="middle">
							<b>Contrase&ntilde;a</b>
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="top">
							<input type="password" name="mpass" maxlength="40" size="39" onkeypress="return force(this.name, this.form.id, event);">
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="middle">
							<b>C&oacute;digo de Seguridad</b>
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="top">
							<img src="img.php?cod= <?php echo $fakecode; ?>" alt="Codigo de Seguridad">
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="middle">
							Reescribe el c&oacute;digo en el siguiente cuadro
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="top">
							<input type="text" name="code" maxlength="6" size="6" onkeypress="return force(this.name, this.form.id, event);">
						</td>
					</tr>
					<tr>
						<td align="center" height="30" valign="middle">
							<input type="submit" value="Accesar">
						</td>
					</tr>
				</table>
				<input type="hidden" name="opt" value="1">
			</form>
		</td>
		<td width="2%" align="center" bgcolor="#A92207">&nbsp;</td>
		<td width="49%" align="center" valign="top">
			<form id="memberreg" onsubmit="return POST_ajax('member.php','main_div','memberreg');">
				<table width="100%">
					<tr>
						<td align="center" height="30" valign="middle"><b><font color="Red" size="2">Registrarme en Evangelis</font></b></td>
					</tr>
					<tr>
						<td align="center" height="50" valign="middle">
							<img src="po2.gif">
						</td>
					</tr>
					<tr>
						<td align="center" height="30" valign="middle">
							Si no eres miembro aun de la comunidad, primero debes crearte una CUENTA DE MEMBRES&Iacute;A.
						</td>
					</tr>
					<tr>
						<td align="center" height="30" valign="bottom">
							<b>Correo Electr&oacute;nico</b>
						</td>
					</tr>
					<tr>
						<td align="center" height="20" valign="top">
							<input type="text" name="email" maxlength="39" size="39" onkeypress="return force(this.name, this.form.id, event);">
						</td>
					</tr>
					<tr>
						<td align="center" height="110" valign="middle">
							<b>LEER ANTES DE CONTINUAR!!</b><br>
							<br>
							Solamente es necesario hacerte una sola cuenta de Miembro, ya que dentro de esta podras hacer Cuentas de Juego. Asi que cuando termines tu registro y te logees con tu Membres&iacute;a
							aparecer&aacute; un men&uacute; llamado <b>Menu de Miembro</b> y dentro de este podras Crear Cuenta o Ver todas tus cuentas de jugador.<br><br>
							Presiona el bot&oacute;n de enviar para solicitar a tu correo un C&oacute;digo de Registro. En pocos momentos deber&aacute; llegarte con el dato.<br>
							(Recuerda revisar correo no deseado tambien, si no llega usa otro mail)
						</td>
					</tr>
					<tr>
						<td align="center" height="30" valign="middle">
							<input type="submit" value="Enviar">
						</td>
					</tr>
				</table>
				<input type="hidden" name="opt" value="2">
			</form>
		</td>
	</tr>
</table>
<?php
	}
	elseif ($_POST['opt'] == 1)
	{ // Intento de Login a la Cuenta
		$email = trim($_POST['email']);
		$mpass = $_POST['mpass'];
		$code = $_POST['code'];
		$last_ip = $_SERVER['REMOTE_ADDR'];

		echo '
			<table width="550" height="300">
				<tr>
					<td align="center" valign="middle" height="30">
		';
		if (isipbanned())
		{ // Baneo por IP
			?>
							<b><font color="Red" size="2">Tu direcci&oacute;n IP esta baneada!!</font></b>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" height="60">
							La direcci&oacute;n IP de donde te encuentras se encuentra baneada. Si fallaste tu clave de juego 3 veces es posible que debas esperar 1 hora.<br>
							Si no es lo anterior, informate en el foro de Reglamento, Seccion de Historial de Baneos si existe alguna razon adicional.<br>
							De no ser asi, ponte en contacto con el Staff de Evangelis.<br>
							Intenta de nuevo haciendo click en <span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('member.php','main_div');"></b>Iniciar Sesion</b></span>.
			<?php
		}
		elseif (inject($email) || strlen($email) < 7 || !strstr($_POST['email'], '@'))
		{ // Correo Invalido
			?>
							<b><font color="Red" size="2">Direcci&oacute;n de Correo con Caracteres no V&aacute;lidos!!</font></b>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" height="60">
							La direcci&oacute;n de correo que ingresaste, o bien no es v&aacute;lida o tiene caracteres inapropiados para la seguridad del servidor.<br>
							Intenta de nuevo haciendo click en <span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('member.php','main_div');"></b>Iniciar Sesion</b></span>.
			<?php
		}
		elseif (inject($mpass) || strlen($mpass) < 6)
		{ // Password Invalido
			?>
							<b><font color="Red" size="2">Contrase&ntilde;a inv&aacute;lida!!</font></b>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" height="60">
							La clave que ingresaste no cumple el largo minimo requerido o contiene caracteres inv&aacute;lidos.
							Intenta de nuevo haciendo click en <span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('member.php','main_div');"></b>Iniciar Sesion</b></span>.
			<?php
		}
		elseif (strtoupper($code) != substr(strtoupper(md5("Gaiaro" . $_SESSION[$CONFIG['Name'] . 'securitycode'])), 0, 6))
		{ // Codigo Incorrecto
			?>
							<b><font color="Red" size="2">C&oacute;digo de Seguridad no concuerda!!</font></b>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" height="60">
							No concuerda el c&oacute;digo de seguridad con el que escribiste.<br>
							Intenta de nuevo haciendo click en <span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('member.php','main_div');"></b>Iniciar Sesion</b></span>.
			<?php
		}
		else
		{ // Revision de Cuenta
			if (!($member = $mysql->fetcharray($mysql->query("
				SELECT
					*
				FROM
					`members`
				WHERE
					`email` LIKE '$email'
			", $CONFIG['DBMain']))))
			{ // Cuenta no Existe
				?>
								<b><font color="Red" size="2">El correo no est&aacute; registrado!!</font></b>
							</td>
						</tr>
						<tr>
							<td align="center" valign="middle" height="60">
								El email que ingresaste no existe en la base de datos.<br>
								Create una nueva cuenta haciendo click en <span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('member.php','main_div');"></b>Iniciar Sesion</b></span>.
				<?php
			}
			else
			{
				$member_id = $member['member_id'];

				if (strcmp($member['mpass'], $mpass))
				{ // Clave diferente
					$result = 0;
					?>
									<b><font color="Red" size="2">Error de contrase&ntilde;a!!</font></b>
								</td>
							</tr>
							<tr>
								<td align="center" valign="middle" height="60">
									La clave de cuenta de Miembro es incorrecta.<br>
									La Direcci&oacute;n IP <b><? echo $last_ip; ?></b> ha sido registrada para seguridad del Propietario de la Cuenta.<br>
									Intenta accesar de nuevo en <span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('member.php','main_div');"></b>Iniciar Sesion</b></span>.
					<?php
				}
				elseif ($member['banned'] == 1)
				{ // Baneado del Servidor
					$result = 2;
					?>
									<b><font color="Red" size="2">Membres&iacute;a Baneada de Evangelis Ragnarok</font></b>
								</td>
							</tr>
							<tr>
								<td align="center" valign="middle" height="60">
									Esta membres&iacute;a ha sido baneada de Evangelis Ragnarok.<br>
									Si desconoces la razon, busca en el foro de la comunidad, en la seccion Reglamento, sub-seccion Historial de Baneos la raz&oacute;n.
									Intenta una nueva membres&iacute;a en <span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('member.php','main_div');"></b>Iniciar Sesion</b></span>.
					<?php
				}
				else
				{ // Login correcto, procediendo
					$result = 1;
					// Estableciendo Session
					$_SESSION[$CONFIG['Name'] . 'member_id'] = $member_id;
					$_SESSION[$CONFIG['Name'] . 'email'] = $member['email'];
					$_SESSION[$CONFIG['Name'] . 'pais'] = $member['pais'];
					$_SESSION[$CONFIG['Name'] . 'nombre'] = $member['nombre'];
					$_SESSION[$CONFIG['Name'] . 'mlevel'] = $member['mlevel'];
					// Cuenta Activa, ninguna
					$_SESSION[$CONFIG['Name'] . 'account_id'] = 0;
					$_SESSION[$CONFIG['Name'] . 'userid'] = '';
					$_SESSION[$CONFIG['Name'] . 'level'] = -1;
					// Algunos Timers
					$_SESSION[$CONFIG['Name'] . 'tradelog'] = 0;

					// Log de Ultimo login e IP
					$mysql->query("
						UPDATE
							`members`
						SET
							`last_ip` = '$last_ip', `last_login` = NOW()
						WHERE
							member_id = '$member_id'
					", $CONFIG['DBMain']);

					?>
									<b><font color="Red" size="2">Bievenido <? echo htmlformat($member['nombre']); ?></font></b>
								</td>
							</tr>
							<tr>
								<td align="center" valign="middle" height="60">
									Ya tienes acceso a las opciones de tu cuenta en el men&uacute;, solamente recuerda Cerrar la Sesi&oacute;n cuanto termines tus tramites.<br>
									<script type="text/javascript">
										LINK_ajax('login.php','login_div');
										load_menu();
									</script>
									<br><br>
									Para Administrar tus cuentas de Juego haz click en:<br><br>
									<span title="Click aqui para seleccionar otra cuenta de juego" style="cursor:pointer" onMouseOver="this.style.color='#FF3300'" onMouseOut="this.style.color='#FFFFFF'" onClick="LINK_ajax('cuentas.php','main_div');"><img src="accselect.png"></span>
									<br><br>Tambien puedes crear una nueva cuenta aca:<br><br>
									<span title="Click aqui para crear una cuenta de juego" style="cursor:pointer" onMouseOver="this.style.color='#FF3300'" onMouseOut="this.style.color='#FFFFFF'" onClick="LINK_ajax('newaccount.php','main_div');"><img src="newgameacc.png"></span>
					<?php
				}

				// Log de Accesos
				if ($result < 2)
					$mysql->query("INSERT INTO `cp_memberlog` (`member_id`, `ip`, `date`, `ban`) VALUE ('$member_id', '$last_ip', NOW(), '$result')", $CONFIG['DBLogs']);
			}
		}

		echo '
					</td>
				</tr>
			</table>
		';
	}
	elseif ($_POST['opt'] == 2)
	{ // Solicitud de Registro al Servidor
		if (isipbanned())
		{ // Baneo por IP
			?>
				<table width="550" height="300">
					<tr>
						<td align="center" valign="middle" height="30">
							<b><font color="Red" size="2">Tu direcci&oacute;n IP esta baneada!!</font></b>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" height="60">
							La direcci&oacute;n IP de donde te encuentras se encuentra baneada. Si fallaste tu clave de juego 3 veces es posible que debas esperar 1 hora.<br>
							Si no es lo anterior, informate en el foro de Reglamento, Seccion de Historial de Baneos si existe alguna razon adicional.<br>
							De no ser asi, ponte en contacto con el Staff de Evangelis.<br>
							Intenta de nuevo haciendo click en <span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('member.php','main_div');"></b>Iniciar Sesion</b></span>.
						</td>
					</tr>
				</table>
			<?php
			closetable();
			exit(0);
		}
		if (inject($_POST['email']))
		{ // Seguridad en direccion de Correo
			?>
				<table width="550" height="300">
					<tr>
						<td align="center" valign="middle" height="30">
							<b><font color="Red" size="2">Direcci&oacute;n de Correo con Caracteres no V&aacute;lidos</font></b>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" height="60">
							Lamentablemente la cuenta de correo que ingresaste no es permitida en el servidor ya que tiene caracteres que pueden arriesgar la seguiridad del mismo.
							Intenta con otra cuenta de Correo haciendo click en <span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('member.php','main_div');"></b>Iniciar Sesion</b></span>.
						</td>
					</tr>
				</table>
			<?php
			closetable();
			exit(0);
		}
		if (strlen($_POST['email']) < 7 || !strstr($_POST['email'], '@'))
		{ // No es correo o es un valor vacio
			?>
				<table width="550" height="300">
					<tr>
						<td align="center" valign="middle" height="30">
							<b><font color="Red" size="2">Direcci&oacute;n de Correo Inv&aacute;lida</font></b>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" height="60">
							El correo que ingresaste no parece v&aacute;lido, por favor intenta con otra direcci&oacute;n. <span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('member.php','main_div');"></b>Intentar de nuevo</b></span>.
						</td>
					</tr>
				</table>
			<?php
			closetable();
			exit(0);
		}

		$email = $_POST['email'];
		if ($mysql->fetchrow($mysql->query("SELECT `member_id` FROM `members` WHERE `email` LIKE '$email'", $CONFIG['DBMain'])))
		{ // Correo ya existe
			?>
				<table width="550" height="300">
					<tr>
						<td align="center" valign="middle" height="30">
							<b><font color="Red" size="2">Cuenta actualmente ya registrada</font></b>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" height="60">
							Este correo actualmente ya est&aacute; en uso. Si tu problema es que perdiste la contrase&ntilde;a de acceso, entonces puedes solicitarla en
							<span title="Recuperar clave de miembro" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('recover.php','main_div');"></b>recuperar clave de miembro</b></span>.<br><br>
							Si deseas intentar con otra cuenta de correo, entonces
							<span title="Accesar o crear cuenta de miembro" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('member.php','main_div');"></b>haz click aqu&iacute;</b></span>.<br><br>
						</td>
					</tr>
				</table>
			<?php
			closetable();
			exit(0);
		}

		$regcode = generateCode(15);
		$asunto = "Evangelis Ragnarok - Solicitud de Membresia";
		$message = "";
		$message.= "Gracias por tu interes en unirte a la comunidad Evangelis, si lees este mensaje, este correo ha sido verificado y se puede usar para el registro.\n\n";
		$message.= "Este mensaje ha sido enviado automaticamente ya que usted (o alguien mas) coloco el correo $email como solicitante.\n\n\n";
		$message.= "Para terminar su registro ingrese este código en el Sistema de Membresias: $regcode\n\n";
		$message.= "Si por error cerro la ventana de Registro de Miembros, debera volver a iniciar el proceso de creacion de cuenta.\n\n\n";
		$message.= "Servidor Evangelis Ragnarok.\n";
		$message.= "High Rates Premium.\n";
		sendmail($_POST['email'], $asunto, $message);
		$_SESSION[$CONFIG['Name'] . 'regcode'] = $regcode;
?>
<form id="memberchk" onsubmit="return POST_ajax('member.php','main_div','memberchk');">
	<table width="550" height="300">
		<tr>
			<td align="center" valign="middle" height="30">
				<b><font color="Red" size="2">Confirmaci&oacute;n de Correo</font></b>
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle" height="60">
				Un correo electr&oacute;nico ha sido enviado a la direccion <b><? echo $_POST['email']; ?></b> con el C&oacute;digo de registro de Membres&iacute;a.<br><br>
				No cierres esta ventana hasta que lo tengas, para escribirlo en el siguiente cuadro. Si el correo no llega en unos 5 minutos, posiblemente haya quedado en
				la carpeta de correo no deseado, o simplemente ese correo no se pueda utilizar para registrarte en el servidor.
			</td>
		</tr>
		<tr>
			<td align="center" height="70" valign="middle">
				<img src="mail.gif">
			</td>
		</tr>
		<tr>
			<td align="center" height="30" valign="bottom">
				<b>C&oacute;digo de Registro</b>
			</td>
		</tr>
		<tr>
			<td align="center" height="20" valign="top">
				<input type="text" name="code" maxlength="20" size="20" onkeypress="return force(this.name, this.form.id, event);">
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle" height="60">
				Mientras el correo llega, te recordamos que es MUY IMPORTANTE no compartas tus cuentas, ya que cuando se han presentado problemas de robo de cosas, principalmente
				es porque amigos o familiares se han aprovechado y sacado cosas de una cuenta, e inclusive ellos mismos la han dado a terceros.<br><br>
				Si quieres jugar con tranquilidad y seguridad, no facilites la cuenta a nadie. Evangelis Ragnarok te da seguridad a diferencia de cualquier otro servidor por el sistema
				de membresia, en donde la cuenta es tuya totalmente ya que se asocia al correo electronico, pero de todas formas se pueden presentar extravio de items o robo de los mismos.
			</td>
		</tr>
		<tr>
			<td align="center" height="30" valign="middle">
				<input type="submit" value="Confirmar Codigo">
			</td>
		</tr>
	</table>
	<input type="hidden" name="opt" value="3">
	<input type="hidden" name="email" value="<? echo $_POST['email']; ?>">
</form>
<?php
	}
	elseif ($_POST['opt'] == 3)
	{ // Verificacion del Codigo
		echo '
			<table width="550" height="300">
				<tr>
					<td align="center" valign="middle" height="30">
		';

		if (strcmp($_POST['code'], $_SESSION[$CONFIG['Name'] . 'regcode']))
		{ // Wrong Code
			echo '
						<b><font color="Red" size="2">Error en el C&oacute;digo de Registro</font></b>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" height="60">
						Lamentablemente no podemos permitir usar un correo si no se ha confirmado al maximo que permita recibir mensajes del mismo servidor Evangelis Ragnarok.
						Te recomendamos crearte cuentas en hotmail o yahoo, pero es muy importante que sean correo real, al que visites a menudo ya que en muchos casos
						personas se crean correos solo para registrarse y ya, y luego los olvidan.<br><br>
						Intentalo de nuevo dando click en <span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color=\'#0000FF\'" onMouseOut="this.style.color=\'#0000FF\'" onClick="LINK_ajax(\'member.php\',\'main_div\');"></b>Iniciar Sesion</b></span> otra vez. Buena Suerte!!.
			';
		}
		else
		{ // Right Code
			$email = $_POST['email'];
			if ($mysql->fetchrow($mysql->query("SELECT `member_id` FROM `members` WHERE `email` LIKE '$email'", $CONFIG['DBMain'])))
			{ // But allready existing e-mail
				?>
								<b><font color="Red" size="2">Cuenta actualmente ya registrada</font></b>
							</td>
						</tr>
						<tr>
							<td align="center" valign="middle" height="60">
								Este correo actualmente ya est&aacute; en uso. Si tu problema es que perdiste la contrase&ntilde;a de acceso, entonces puedes solicitarla en
								<span title="Recuperar clave de miembro" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('recover.php','main_div');"></b>recuperar clave de miembro</b></span>.<br><br>
								Si deseas intentar con otra cuenta de correo, entonces
								<span title="Accesar o crear cuenta de miembro" style="cursor:pointer" onMouseOver="this.style.color='#0000FF'" onMouseOut="this.style.color='#0000FF'" onClick="LINK_ajax('member.php','main_div');"></b>haz click aqu&iacute;</b></span>.<br><br>
				<?php
			}
			else
			{ // Correo Ok, creando formulario
				?>
								<b><font color="Red" size="2">Formulario de Membres&iacute;a</font></b>
							</td>
						</tr>
						<tr>
							<td align="center" valign="middle" height="40">
								El correo <b><? echo $email; ?></b> ha sido comprobado, ahora procede a llenar el formulario que se presenta a continuaci&oacute;n.
								Por normas de seguridad, solamente se permiten <b>letras</b> (may&uacute;sculas y min&uacute;sculas), <b>n&uacute;meros</b> estos caracteres: <b>@ . , - _</b>
							</td>
						</tr>
						<tr>
							<td align="center" valign="middle" height="240">
								<form id="memberfor" onsubmit="return POST_ajax('member.php','main_div','memberfor');">
									<table width="550" height="240">
										<tr><td align="center" valign="middle" height="30">Clave de Miembro<br>(Min 6 max 40 caracteres)</td></tr>
										<tr><td align="center" valign="top" height="20">
												<input type="password" name="mpass" maxlength="40" size="40" onKeyPress="return force(this.name,this.form.id,event);">
										</td></tr>
										<tr><td align="center" valign="middle" height="20">Confirme su Clave</td></tr>
										<tr><td align="center" valign="top" height="20">
												<input type="password" name="cpass" maxlength="40" size="40" onKeyPress="return force(this.name,this.form.id,event);">
										</td></tr>
										<tr><td align="center" valign="middle" height="20">Tu Nombre</td></tr>
										<tr><td align="center" valign="top" height="20">
												<input type="text" name="nombre" maxlength="50" size="50" onkeypress="return force(this.name, this.form.id, event);">
										</td></tr>
										<tr><td align="center" valign="middle" height="30">G&eacute;nero<br>(Independiente del juego)</td></tr>
										<tr><td align="center" valign="top" height="20">
												<select name="sexo" onKeyPress="return force(this.name,this.form.id,event);">
													<option value="M">Masculino</option>
													<option value="F">Femenino</option>
												</select>
										</td></tr>
										<tr><td align="center" valign="middle" height="20">Pais donde te encuentras</td></tr>
										<tr><td align="center" valign="top" height="20">
												<select name="pais" onKeyPress="return force(this.name,this.form.id,event);">
													<option value="AF">Afganist&aacute;n</option>
													<option value="AL">Albania</option>
													<option value="DE">Alemania</option>
													<option value="AD">Andorra</option>
													<option value="AO">Angola</option>
													<option value="AI">Anguila</option>
													<option value="AQ">Ant&aacute;rtida</option>
													<option value="AG">Antigua y Barbuda</option>
													<option value="AN">Antillas Neerlandesas</option>
													<option value="SA">Arabia Saud&iacute;</option>
													<option value="DZ">Argelia</option>
													<option value="AR">Argentina</option>
													<option value="AM">Armenia</option>
													<option value="AW">Aruba</option>
													<option value="AU">Australia</option>
													<option value="AT">Austria</option>
													<option value="AZ">Azerbaiy&aacute;n</option>
													<option value="BS">Bahamas</option>
													<option value="BH">Bahr&aacute;in</option>
													<option value="BD">Bangladesh</option>
													<option value="BB">Barbados</option>
													<option value="BE">B&eacute;lgica</option>
													<option value="BZ">Belice</option>
													<option value="BJ">Ben&iacute;n</option>
													<option value="BM">Bermudas</option>
													<option value="BY">Bielorrusia</option>
													<option value="BO">Bolivia</option>
													<option value="BA">Bosnia y Hercegovina</option>
													<option value="BW">Botsuana</option>
													<option value="BR">Brasil</option>
													<option value="BN">Brun&eacute;i</option>
													<option value="BG">Bulgaria</option>
													<option value="BF">Burkina Faso</option>
													<option value="BI">Burundi</option>
													<option value="BT">But&aacute;n</option>
													<option value="CV">Cabo Verde</option>
													<option value="KH">Camboya</option>
													<option value="CM">Camer&uacute;n</option>
													<option value="CA">Canad&aacute;</option>
													<option value="TD">Chad</option>
													<option value="CL">Chile</option>
													<option value="CN">China</option>
													<option value="CY">Chipre</option>
													<option value="VA">Ciudad del Vaticano</option>
													<option value="CO">Colombia</option>
													<option value="KM">Comoras</option>
													<option value="CG">Congo</option>
													<option value="CD">Congo, Rep&uacute;blica Democr&aacute;tica del</option>
													<option value="KP">Corea del Norte</option>
													<option value="KR">Corea del Sur</option>
													<option value="CI">Costa de Marfil</option>
													<option value="CR" selected>Costa Rica</option>
													<option value="HR">Croacia</option>
													<option value="CU">Cuba</option>
													<option value="DK">Dinamarca</option>
													<option value="DM">Dominica</option>
													<option value="EC">Ecuador</option>
													<option value="EG">Egipto</option>
													<option value="SV">El Salvador</option>
													<option value="AE">Emiratos &Aacute;rabes Unidos</option>
													<option value="ER">Eritrea</option>
													<option value="SK">Eslovaquia</option>
													<option value="SI">Eslovenia</option>
													<option value="ES">Espa&ntilde;a</option>
													<option value="US">Estados Unidos</option>
													<option value="EE">Estonia</option>
													<option value="ET">Etiop&iacute;a</option>
													<option value="PH">Filipinas</option>
													<option value="FI">Finlandia</option>
													<option value="FJ">Fiyi</option>
													<option value="FR">Francia</option>
													<option value="GA">Gab&oacute;n</option>
													<option value="GM">Gambia</option>
													<option value="GE">Georgia</option>
													<option value="GH">Ghana</option>
													<option value="GI">Gibraltar</option>
													<option value="GD">Granada</option>
													<option value="GR">Grecia</option>
													<option value="GL">Groenlandia</option>
													<option value="GP">Guadalupe</option>
													<option value="GU">Guam</option>
													<option value="GT">Guatemala</option>
													<option value="GF">Guayana Francesa</option>
													<option value="GG">Guernsey</option>
													<option value="GN">Guinea</option>
													<option value="GW">Guinea-Bissau</option>
													<option value="GQ">Guinea Ecuatorial</option>
													<option value="GY">Guyana</option>
													<option value="HT">Hait&iacute;</option>
													<option value="HN">Honduras</option>
													<option value="HK">Hong Kong</option>
													<option value="HU">Hungr&iacute;a</option>
													<option value="IN">India</option>
													<option value="ID">Indonesia</option>
													<option value="IR">Ir&aacute;n</option>
													<option value="IQ">Iraq</option>
													<option value="IE">Irlanda</option>
													<option value="BV">Isla Bouvet</option>
													<option value="CX">Isla Christmas</option>
													<option value="IM">Isla de Man</option>
													<option value="IS">Islandia</option>
													<option value="NF">Isla Norfolk</option>
													<option value="AX">Islas Aland</option>
													<option value="KY">Islas Caim&aacute;n</option>
													<option value="CC">Islas Cocos</option>
													<option value="CK">Islas Cook</option>
													<option value="FO">Islas Feroe</option>
													<option value="GS">Islas Georgia del Sur y Sandwich del Sur</option>
													<option value="HM">Islas Heard y McDonald</option>
													<option value="FK">Islas Malvinas</option>
													<option value="MP">Islas Mariana del Norte</option>
													<option value="MH">Islas Marshall</option>
													<option value="UM">Islas menores alejadas de los Estados Unidos</option>
													<option value="PN">Islas Pitcairn</option>
													<option value="SB">Islas Salom&oacute;n</option>
													<option value="SJ">Islas Svalbard y Jan Mayen</option>
													<option value="TC">Islas Turcas y Caicos</option>
													<option value="VI">Islas V&iacute;rgenes, EE.UU.</option>
													<option value="VG">Islas V&iacute;rgenes Brit&aacute;nicas</option>
													<option value="IL">Israel</option>
													<option value="IT">Italia</option>
													<option value="JM">Jamaica</option>
													<option value="JP">Jap&oacute;n</option>
													<option value="JE">Jersey</option>
													<option value="JO">Jordania</option>
													<option value="KZ">Kazajist&aacute;n</option>
													<option value="KE">Kenia</option>
													<option value="KG">Kirguizist&aacute;n</option>
													<option value="KI">Kiribati</option>
													<option value="KW">Kuwait</option>
													<option value="LA">Laos</option>
													<option value="LS">Lesoto</option>
													<option value="LV">Letonia</option>
													<option value="LB">L&iacute;bano</option>
													<option value="LR">Liberia</option>
													<option value="LY">Libia</option>
													<option value="LI">Liechtenstein</option>
													<option value="LT">Lituania</option>
													<option value="LU">Luxemburgo</option>
													<option value="MO">Macao</option>
													<option value="MK">Macedonia</option>
													<option value="MG">Madagascar</option>
													<option value="MY">Malasia</option>
													<option value="MW">Malaui</option>
													<option value="MV">Maldivas</option>
													<option value="ML">Mali</option>
													<option value="MT">Malta</option>
													<option value="MA">Marruecos</option>
													<option value="MQ">Martinica</option>
													<option value="MU">Mauricio</option>
													<option value="MR">Mauritania</option>
													<option value="YT">Mayotte</option>
													<option value="MX">M&eacute;xico</option>
													<option value="FM">Micronesia</option>
													<option value="MD">Moldavia</option>
													<option value="MC">M&oacute;naco</option>
													<option value="MN">Mongolia</option>
													<option value="ME">Montenegro</option>
													<option value="MS">Montserrat</option>
													<option value="MZ">Mozambique</option>
													<option value="MM">Myanmar</option>
													<option value="NA">Namibia</option>
													<option value="NR">Nauru</option>
													<option value="NP">Nepal</option>
													<option value="NI">Nicaragua</option>
													<option value="NE">N&iacute;ger</option>
													<option value="NG">Nigeria</option>
													<option value="NU">Niue</option>
													<option value="NO">Noruega</option>
													<option value="NC">Nueva Caledonia</option>
													<option value="NZ">Nueva Zelanda</option>
													<option value="OM">Om&aacute;n</option>
													<option value="NL">Pa&iacute;ses Bajos</option>
													<option value="PK">Pakist&aacute;n</option>
													<option value="PW">Palaos</option>
													<option value="PA">Panam&aacute;</option>
													<option value="PG">Pap&uacute;a-Nueva Guinea</option>
													<option value="PY">Paraguay</option>
													<option value="PE">Per&uacute;</option>
													<option value="PF">Polinesia Francesa</option>
													<option value="PL">Polonia</option>
													<option value="PT">Portugal</option>
													<option value="PR">Puerto Rico</option>
													<option value="QA">Qatar</option>
													<option value="GB">Reino Unido</option>
													<option value="CF">Rep&uacute;blica Centroafricana</option>
													<option value="CZ">Rep&uacute;blica Checa</option>
													<option value="DO">Rep&uacute;blica Dominicana</option>
													<option value="RE">Reuni&oacute;n</option>
													<option value="RW">Ruanda</option>
													<option value="RO">Rumania</option>
													<option value="RU">Rusia</option>
													<option value="EH">S&aacute;hara Occidental</option>
													<option value="WS">Samoa</option>
													<option value="AS">Samoa americana</option>
													<option value="KN">San Crist&oacute;bal y Nieves</option>
													<option value="SM">San Marino</option>
													<option value="PM">San Pedro y Miquel&oacute;n</option>
													<option value="SH">Santa Elena</option>
													<option value="LC">Santa Luc&iacute;a</option>
													<option value="ST">Santo Tom&eacute; y Pr&iacute;ncipe</option>
													<option value="VC">San Vicente y las Granadinas</option>
													<option value="SN">Senegal</option>
													<option value="RS">Serbia</option>
													<option value="CS">Serbia y Montenegro</option>
													<option value="SC">Seychelles</option>
													<option value="SL">Sierra Leona</option>
													<option value="SG">Singapur</option>
													<option value="SY">Siria</option>
													<option value="SO">Somalia</option>
													<option value="LK">Sri Lanka</option>
													<option value="SZ">Suazilandia</option>
													<option value="ZA">Sud&aacute;frica</option>
													<option value="SD">Sud&aacute;n</option>
													<option value="SE">Suecia</option>
													<option value="CH">Suiza</option>
													<option value="SR">Surinam</option>
													<option value="TH">Tailandia</option>
													<option value="TW">Taiw&aacute;n</option>
													<option value="TZ">Tanzania</option>
													<option value="TJ">Tayikist&aacute;n</option>
													<option value="IO">Territorio Brit&aacute;nico del Oc&eacute;ano &Iacute;ndico</option>
													<option value="PS">Territorio Palestino</option>
													<option value="TF">Territorios Australes Franceses</option>
													<option value="TL">Timor Oriental</option>
													<option value="TG">Togo</option>
													<option value="TK">Tokelau</option>
													<option value="TO">Tonga</option>
													<option value="TT">Trinidad y Tobago</option>
													<option value="TN">T&uacute;nez</option>
													<option value="TM">Turkmenist&aacute;n</option>
													<option value="TR">Turqu&iacute;a</option>
													<option value="TV">Tuvalu</option>
													<option value="UA">Ucrania</option>
													<option value="UG">Uganda</option>
													<option value="UY">Uruguay</option>
													<option value="UZ">Uzbekist&aacute;n</option>
													<option value="VU">Vanuatu</option>
													<option value="VE">Venezuela</option>
													<option value="VN">Vietnam</option>
													<option value="WF">Wallis y Futuna</option>
													<option value="YE">Yemen</option>
													<option value="DJ">Yibuti</option>
													<option value="ZM">Zambia</option>
													<option value="ZW">Zimbabue</option>
												</select>
										</td></tr>
										<tr><td align="center" valign="middle" height="20">&nbsp;</td></tr>
										<tr><td align="center" valign="middle" height="20">
											<b>Sistema de Referencias</b><br>Indica por favor como fue que conociste Evangelis.
										</td></tr>
										<tr><td align="center" valign="top" height="20">
												<select name="ref_option" onKeyPress="return force(this.name,this.form.id,event);">
													<option value="0" selected>(Selecciona una Respuesta)
													<option value="1">Recomendado por un Amigo
													<option value="2">Buscando en Internet
													<option value="3">Web del tipo Top100
													<option value="4">Publicidad en mi centro de estudio
													<option value="5">Publicidad en Internet Cafe
													<option value="6">Correo de Invitacion
												</select>
										</td></tr>
										<tr><td align="center" valign="middle" height="20">&nbsp;</td></tr>
										<tr><td align="center" valign="middle" height="40">
											Si tu opcion fue <b>Recomendado por un Amigo</b>, por favor indicanos su <b>email</b>.<br>
											Escribelo bien, para que tu amigo tenga beneficios que luego tu tambien podras recibir.
										</td></tr>
										<tr><td align="center" valign="top" height="20">
												<input type="text" name="ref_email" maxlength="39" size="39" onkeypress="return force(this.name, this.form.id, event);">
										</td></tr>
										<tr><td align="center" valign="middle" height="20">&nbsp;</td></tr>
										<tr><td align="center" valign="middle" height="20">
											Cuando termines con el registro ya podr&aacute;s Iniciar Sesi&oacute;n en el bot&oacute;n de la derecha.
										</td></tr>
										<tr><td align="center" valign="middle" height="20">&nbsp;</td></tr>
										<tr><td align="center" valign="top" height="20">
												<input type="submit" value="Registrarme ahora">
										</td></tr>
									</table>
									<input type="hidden" name="email" value="<? echo $email; ?>">
									<input type="hidden" name="code" value="<? echo $_POST['code']; ?>">
									<input type="hidden" name="opt" value="4">
								</form>
				<?php
			}
		}

		echo '
					</td>
				</tr>
			</table>
		';
	}
	elseif ($_POST['opt'] == 4)
	{ // Registrandose
		$email = $_POST['email'];
		$ref_email = trim($_POST['ref_email']);
		echo '
			<table width="550" height="300">
				<tr>
					<td align="center" valign="middle" height="30">
		';

		if( strlen($_POST['mpass']) < 6 || strlen($_POST['mpass']) > 40 || inject($_POST['mpass']) )
		{
			echo '
						<b><font color="Red" size="2">Clave insegura!!</font></b><br>
						O bien la clave no es de la medida necesaria o esta utilizando caracteres invalidos<br>
						Haga click en regresar para intentar otra vez.
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" height="40">
						<form id="memberfor" onsubmit="return POST_ajax(\'member.php\',\'main_div\',\'memberfor\');">
							<input type="hidden" name="email" value="' . $email . '">
							<input type="hidden" name="code" value="' . $_POST['code'] . '">
							<input type="hidden" name="opt" value="3">
							<input type="submit" value="Regresar...">
						</form>
			';
		}
		elseif( strcmp($_POST['mpass'], $_POST['cpass']) )
		{
			echo '
						<b><font color="Red" size="2">Claves no coinciden!!</font></b><br>
						La clave que introdujo no es la misma que la de verificacion<br>
						Haga click en regresar para intentar otra vez.
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" height="40">
						<form id="memberfor" onsubmit="return POST_ajax(\'member.php\',\'main_div\',\'memberfor\');">
							<input type="hidden" name="email" value="' . $email . '">
							<input type="hidden" name="code" value="' . $_POST['code'] . '">
							<input type="hidden" name="opt" value="3">
							<input type="submit" value="Regresar...">
						</form>
			';
		}
		elseif( strlen($ref_email) > 0 && !preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $ref_email) )
		{
			echo '
						<b><font color="Red" size="2">Correo de referencia invalido!!</font></b><br>
						El correo que introdujo de referencia no parece tener un formato valido<br>
						Haga click en regresar para intentar otra vez.
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" height="40">
						<form id="memberfor" onsubmit="return POST_ajax(\'member.php\',\'main_div\',\'memberfor\');">
							<input type="hidden" name="email" value="' . $email . '">
							<input type="hidden" name="code" value="' . $_POST['code'] . '">
							<input type="hidden" name="opt" value="3">
							<input type="submit" value="Regresar...">
						</form>
			';
		}
		elseif( strlen($ref_email) > 0 && !$mysql->fetchrow($mysql->query("SELECT `member_id` FROM `members` WHERE `email` LIKE '$ref_email'", $CONFIG['DBMain'])) )
		{
			echo '
						<b><font color="Red" size="2">Correo de Referencia no Existe!!</font></b><br>
						El correo que introdujo de referencia no parece estar registrado<br>
						Si deseas beneficiar a un amigo, intenta de nuevo haciendo click en Regresar...<br>
						Si no deseas beneficiar a nadie Regresa y deja el espacio de correo de referencia vacio.
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" height="40">
						<form id="memberfor" onsubmit="return POST_ajax(\'member.php\',\'main_div\',\'memberfor\');">
							<input type="hidden" name="email" value="' . $email . '">
							<input type="hidden" name="code" value="' . $_POST['code'] . '">
							<input type="hidden" name="opt" value="3">
							<input type="submit" value="Regresar...">
						</form>
			';
		}
		elseif( strlen($_POST['nombre']) < 2 || inject($_POST['nombre']) )
		{
			echo '
						<b><font color="Red" size="2">Nombre incorrecto!!</font></b><br>
						O bien el largo del nombre no es suficiente o tiene caracteres incorrectos<br>
						Haga click en regresar para intentar otra vez.
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" height="40">
						<form id="memberfor" onsubmit="return POST_ajax(\'member.php\',\'main_div\',\'memberfor\');">
							<input type="hidden" name="email" value="' . $email . '">
							<input type="hidden" name="code" value="' . $_POST['code'] . '">
							<input type="hidden" name="opt" value="3">
							<input type="submit" value="Regresar...">
						</form>
			';
		}
		elseif( $mysql->fetchrow($mysql->query("SELECT `member_id` FROM `members` WHERE `email` LIKE '$email'", $CONFIG['DBMain'])) )
		{
			echo '
						<b><font color="Red" size="2">Email ya Registrado!!</font></b><br>
						Durante el proceso de registro es probable que alguien mas haya registrado este correo, o tu mismo si hubo algun fallo.<br>
						Haga click en regresar para intentar otra vez.
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" height="30">
						<span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color=\'#0000FF\'" onMouseOut="this.style.color=\'#0000FF\'" onClick="LINK_ajax(\'member.php\',\'main_div\');"></b>Regresar al Inicio</b></span>
			';
		}
		else
		{ // Todo Terminado, Creando Miembro
			$nombre = $_POST['nombre'];
			$sexo = $_POST['sexo'];
			$pais = $_POST['pais'];
			$mpass = $_POST['mpass'];
			$ref_option = $_POST['ref_option'];
			if( strlen($ref_email) > 0 )
				$mysql->query("UPDATE `members` SET `ref_points` = `ref_points` + 1 WHERE `email` = '$ref_email'", $CONFIG['DBMain']);

			$mysql->query("
				INSERT INTO `members`
					(`nombre`, `email`, `sexo`, `pais`, `msn`, `icq`, `mpass`, `services`, `ref_option`, `ref_email`)
				VALUES
					('$nombre', '$email', '$sexo', '$pais', '', '', '$mpass', '2', '$ref_option', '$ref_email')
			", $CONFIG['DBMain']);

			echo '
						<b><font color="Red" size="2">Felicitaciones, ya eres Miembro de Evangelis Ragnarok!!</font></b><br>
						<b>RECUERDA!!!:</b> Basta con que te hagas una cuenta de Membresia, y dentro de esta es que crearas las cuentas de juego que quieras.<br><br>
						Cuando logees con tu correo y clave, aparecera una opcion MENU DE MIEMBRO, donde podras tener acceso a crearte cuentas de jugador.<br><br>
						Ya puedes accesar para administrar y crear cuentas de juego en el panel.<br>
						Recuerda que es muy importante proteger tu cuenta y no darla a nadie, tu cuenta de miembro es la que protege a tus cuentas de juego
						y las identifica como tuyas, asi que de igual manera si un jugador te regala una cuenta ten cuidado, pues en cualquier momento la
						podra recuperar nuevamente.<br>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" height="30">
						<span title="Accesa o create tu cuenta ahora" style="cursor:pointer" onMouseOver="this.style.color=\'#0000FF\'" onMouseOut="this.style.color=\'#0000FF\'" onClick="LINK_ajax(\'member.php\',\'main_div\');">
							<img src="login.gif">
						</span>
			';
		}

		echo '
					</td>
				</tr>
			</table>
		';

	}

	closetable();
?>