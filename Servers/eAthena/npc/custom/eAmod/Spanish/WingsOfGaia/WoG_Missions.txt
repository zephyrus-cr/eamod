// Wings of Gaia Missions

airwog	mapflag	monster_noteleport

function	script	get_WoGID	{
	// Regresa si el Personaje es de la Guild dueña de la Nave
	if (getcharid(2) && getcharid(2) == $WoG_guild_id)
		return 1;
	else
		return 0;
}

function	script	get_WoGMission	{
	// Valor del Progreso de la Quest
	if (getcharid(2))
		return getd("$WoG_M_" + getcharid(2));
	else
		return 0;
}

airwog,74,185,7	script	Vigilante::WoGMission2		868,{
	mes "^0000FF[Vigilante]^000000";
	mes "Esta habitación es exclusiva para transportar Artículos o Bestias, de los encargos de ^0000FF'Wings of Gaia Missions'.^000000";
	next;
	mes "^0000FF[Vigilante]^000000";
	// No pertenece a la guild
	if (!callfunc("get_WoGID")) {
		mes "Tu no deberías estar aquí. No eres miembro de la Guild propietaria de la Nave.";
		mes "Retiraré o llamaré a seguridad.";
		close;
	}
	// No registrado en Misiones
	set @M, callfunc("get_WoGMission");
	if (@M <= 0) {
		mes "Señor!!, la nave no está bajo ningun contrato aún.";
		mes "Conozco a un señor que viaja mucho a Izlude, cerca del acceso al Airplane, talvez él quiera contratarnos.";
		close;
	}
	// Superadas todas las Misiones
	if (@M > getarraysize($@WoG_M_Type)) {
		mes "No hay más misiones por el momento Señor!!.";
		mes "Le avisaré si hay algo nuevo por realizar";
		close;
	}

	mes "Reporte Mision Nº:^0000FF" + @M + "^000000.";

	switch ($@WoG_M_Type[@M]) {
		case 1:
			// Transporte de Criaturas
			mes "^FF0000Casería de Criaturas^000000";
			mes "Objetivo: ^0000FF" + strmobinfo(2,$@WoG_M_id[@M]) + "^000000.";
			mes "Total: ^0000FF" + $@WoG_M_Total[@M] + "^000000.";
			mes "Capturados: ^0000FF" + $WoG_MP + "^000000.";
			mes "Capturar en: ^0000FF" + $@WoG_nam$[$@WoG_M_Orig[@M]] + "^000000.";
			mes "Entregar en: ^0000FF" + $@WoG_nam$[$@WoG_M_Dest[@M]] + "^000000.";
			next;
			mes "^0000FF[Vigilante]^000000";
			mes "Recuerda que solo se podrán capturar criaturas si W.o.G se encuentra en tierra, en el mapa indicado.";
			next;
			mes "^0000FF[Vigilante]^000000";
			mes "Cuando completen la captura se les avisará, y deberán ir al mapa de entrega y esperar 5 minutos a que se complete.";
			close;
		break;

		case 2:
			// Transporte de Artículos
			mes "^FF0000Búsqueda de Artículos^000000";
			mes "Recolectando: ^0000FF" + getitemname($@WoG_M_id[@M]) + "^000000.";
			mes "Total: ^0000FF" + $@WoG_M_Total[@M] + "^000000.";
			mes "Recolectados: ^0000FF" + $WoG_MP + "^000000.";
			mes "Entregar en: ^0000FF" + $@WoG_nam$[$@WoG_M_Dest[@M]] + "^000000.";
			next;
			mes "^0000FF[Vigilante]^000000";
			mes "Tus colectas de items deberás traermelas a mi, y yo las iré almacenando en esta habitación.";
			next;
			mes "^0000FF[Vigilante]^000000";
			mes "Cuando completen la captura se les avisará, y deberán ir al mapa de entrega y esperar 5 minutos a que se complete.";
			
			if ($@WoG_access) {
				mes "Mientras estemos en modo aventura, no podemos agregar más embarques";
				close;
			}
			
			mes "¿Deseas cooperar con tus Artículos ahora?";
			next;
			menu "Agregar 100 " + getitemname($@WoG_M_id[@M]),-,"No por ahora",L_No;
			
			set @Agregar, 100;
			set @Total, countitem($@WoG_M_id[@M]);
			set @Faltante, $@WoG_M_Total[@M] - $WoG_MP;
			
			if (@Agregar > @Faltante)
				set @Agregar, @Faltante;
			
			if (@Faltante <= 0) {
				mes "^0000FF[Vigilante]^000000";
				mes "Ya no se requieren más artículos para esta misión. Ahora se deben de entregar en el mapa indicado.";
				mes "Entregar en: ^0000FF" + $@WoG_nam$[$@WoG_M_Dest[@M]] + "^000000.";
				close;
			}
			
			if (@Agregar > @Total) {
				mes "^0000FF[Vigilante]^000000";
				mes "No posees la cantidad que indicas en tu inventario... lo lamento.";
				close;
			}
			
			delitem $@WoG_M_id[@M],@Agregar;
			set $WoG_MP, $WoG_MP + @Agregar;
			
			// Creación de Cajas
			mobevent "airwog",rand(71,85),rand(172,175),"Embarque de Items",1326,0,1,0,0,0,1,1,1,0,0,0,0,0,"WoGMission2::OnMobs";
			// Revision de Estado
			if ($WoG_MP == $@WoG_M_Total[@M]) {
				announce "[Wings of Gaia Mission | Pedido Completo]",4,0xCC9900;
				announce "[Lugar de Entrega: " + $@WoG_nam$[$@WoG_M_Dest[@M]] + "]",4,0xCC9900;
			}
			
			mes "^0000FF[Vigilante]^000000";
			mes "Gracias por cooperar en la misión, todo el equipo de tu guild estará agradecido.";
			close;
		break;
	}

L_No:
	mes "^0000FF[Vigilante]^000000";
	mes "No quieres agregar nada... No hay problema, nos vemos luego.";
	close;

OnWoGLanded:
	// Revision del Aterrizaje
	if (!$WoG_guild_id) end; // No tiene Guild
	if ($@WoG_access) end; // Modo Aventura
	
	set .@Temp, getd("$WoG_M_" + $WoG_guild_id);
	
	if (.@Temp <= 0) end; // No esta inscrito en misiones
	if (.@Temp > getarraysize($@WoG_M_Type)) end; // Misiones Terminadas
	
	if ($@WoG_M_Orig[.@Temp] == $WoG_Cmap && $@WoG_M_Type[.@Temp] == 1) {
		mapannounce "airwog","[Misiones W.o.G | Hemos llegado a la Ciudad de Captura]",1,0xFFFF00;
		end;
	}
	
	if ($@WoG_M_Dest[.@Temp] != $WoG_Cmap) end; // No es el mapa de Entraga para la misión
	
	if ($WoG_MP < $@WoG_M_Total[.@Temp]) {
		mapannounce "airwog","[Misiones W.o.G | El pedido para esta Ciudad no está listo]",1,0xFFFF00;
		end;
	}
	
	set $@WoG_Entregando, 1;
	initnpctimer;
	mapannounce "airwog","[Misiones W.o.G | Descargando Pedido | Tiempo: 5 minutos]",1,0xFFFF00;
	mapannounce "airwog","[Protejan la Nave de Piratas durante la Entrega]",1,0xFFFF00;
	mapannounce $@WoG_map$[$WoG_Cmap],"[Wings of Gaia ha traido nuevo Embarque]",1,0xFFFF00;
	end;

OnTimer60000:
	mapannounce "airwog","[WoG Mission: 4 Minutos para terminar entrega]",1,0xFFFF00;
	end;

OnTimer120000:
	mapannounce "airwog","[WoG Mission: 3 Minutos para terminar entrega]",1,0xFFFF00;
	end;
	
OnTimer180000:
	mapannounce "airwog","[WoG Mission: 2 Minutos para terminar entrega]",1,0xFFFF00;
	end;

OnTimer240000:
	mapannounce "airwog","[WoG Mission: 1 Minutos para terminar entrega]",1,0xFFFF00;
	end;

OnTimer300000:
	stopnpctimer;
	set $@WoG_Entregando, 0;
	mapannounce "airwog","[Misiones W.o.G | Entrega Compledada]",1,0xFFFF00;
	set $WoG_MP, 0;
	setd "$WoG_M_" + $WoG_guild_id, getd("$WoG_M_" + $WoG_guild_id) + 1; // Progreso de la Guild a Siguiente Mision
	mapannounce "airwog","[Puntos de Producción de Tesoros +2 en siguiente entrega]",1,0xFFFF00;
	mapannounce $@WoG_map$[$WoG_Cmap],"[Wings of Gaia | Embarque entregado]",1,0xFFFF00;
	setd "$WoG_T_" + $WoG_guild_id, getd("$WoG_T_" + $WoG_guild_id) + 2; // Tesoro Aumentado
	killmonster "airwog","WoGMission2::OnMobs"; // Elimina los mobs creados por mision
	end;

OnCaptured:
	// Sucede si capturan la Nave
	if (!$WoG_guild_id) end; // No tiene Guild
	if ($WoG_MP <= 0) end; // No tiene Progreso o Embarque
	if ($@WoG_Entregando) {
		set $@WoG_Entregando, 0;
		stopnpctimer;
		mapannounce "airwog","[Misiones W.o.G | Entrega Fallida | Embarque robado por Piratas]",1,0xFFFF00;
	}
	set $WoG_MP, 0; // Perdida del Progreso
	// El mismo script de Toma de Empe destruye todos los mobs
	end;

OnMobs:
	// Equitaqueta usada solamente para los Mobs creados y poder borrarlos
	end;

OnInit:
	// Creación de Tabla de misiones
	setarray $@WoG_M_Type[1],    1,   1,   1,   2,  2,   1,   1,   2;
	setarray $@WoG_M_id[1],   1002,1010,1063,7206,904,1413,1087,7561;
	setarray $@WoG_M_Total[1],2000,1500,1000,1200,800, 600,  10, 800;
	setarray $@WoG_M_Orig[1],   11,  18,   0,  17,  0,   9,  40,  32;
	setarray $@WoG_M_Dest[1],   13,   5,  15,   8, 16,   1,  19,  18;
	
	// Solamente creación de los Mobs segun el progreso
	if (!$WoG_guild_id) end; // No tiene Guild

	set .@Temp, getd("$WoG_M_" + $WoG_guild_id);
	if (.@Temp <= 0) end;
	if (.@Temp > getarraysize($@WoG_M_Type)) end;
	
	set .@Total, 1 + ($WoG_MP / 100);
	
	switch ($@WoG_M_Type[.@Temp]) {
		case 1:
			for (set .@i, 0; .@i < .@Total; set .@i, .@i + 1) {
				mobevent "airwog",rand(71,85),rand(172,175),"--ja--",$@WoG_M_id[.@Temp],0,1,0,0,0,1,1,1,0,0,0,0,0,"WoGMission2::OnMobs";
			}
		break;
		case 2:
			for (set .@i, 0; .@i < .@Total; set .@i, .@i + 1) {
				mobevent "airwog",rand(71,85),rand(172,175),"Embarque de Items",1326,0,1,0,0,0,1,1,1,0,0,0,0,0,"WoGMission2::OnMobs";
			}
		break;
	}
	end;
}

// ***************************** Global NPCKillEvent *************************************

-	script	GlobalKillNPC	-1,{
	end;

OnNPCKillEvent:
	// Aditional Storage Quest
	if( #K_Contract == 1 )
	{
		if( killedrid == $@K_Monsters[#K_MobID] )
		{
			set #K_MobCount, #K_MobCount + 1; // Incrementa el Contador
			dispbottom "[Contrato Kafra - " + #K_MobCount + " " + strmobinfo(2,$@K_Monsters[#K_MobID]) + " eliminados]";
			if (#K_MobCount >= 150)
			{
				// Finalizó esta mision
				set #K_MobID, #K_MobID + 1;
				set #K_MobCount, 0;
				dispbottom "[Contrato Kafra - Mision " + #K_MobID + " Completada]";
			}
		}
	}
	
	// Puppy Event
	if( Zeph_Puppy == 1 )
	{
		set @i, rand(10000);
		
		switch( killedrid )
		{
			case 1252:
				if (@i <= 4000) {
					getitem 8902,30;
					specialeffect2 363;
					dispbottom "[PERROTE!! (+30) Llevas " + Zeph_PuppyP + " puntos puppy]";
				}
				break;
			case 1032:
			case 1515:
			case 1282:
			case 1133:
			case 1134:
			case 1135:
			case 1296:
			case 1107:
			case 1106:
				if (@i <= 4000) {
					getitem 8902,1;
					specialeffect2 363;
					dispbottom "[Perro Blanco (+1 puppy coin)]";
				} else if (@i <= 4100) {
					getitem 8902,10;
					specialeffect2 10;
					dispbottom "[Perro Dorado (+10 puppy coin)]";
				} else if (@i <= 4150) {
					delitem 8902,3;
					specialeffect2 372;
					dispbottom "[Perro Negro (-3 puppy coin)]";
				}
				break;
		}
	}
	
	// Neko Event
	if( Zeph_Neko == 1 )
	{
		set @i, rand(10000);
		
		switch( killedrid )
		{
			case 1115:
				if (@i <= 4000) {
					// GATOTE!!
					getitem 8901,30;
					specialeffect2 363;
					dispbottom "[GATOTE!! (+30 neko coin)]";
				}
				break;
			case 1261:
			case 1586:
			case 1415:
			case 1517:
			case 1513:
				if (@i <= 4000) {
					getitem 8901,1;
					specialeffect2 363;
					dispbottom "[Gato Blanco (+1 neko coin)]";
				} else if (@i <= 4100) {
					getitem 8901,10;
					specialeffect2 10;
					dispbottom "[Gato Dorado (+10 neko coin)]";
				} else if (@i <= 4150) {
					delitem 8901,3;
					specialeffect2 372;
					dispbottom "[Gato Negro (-3 neko coin)]";
				}
				break;
		}
	}
	
	// Wings of Gaia Quest
	if( getcharid(2) )
	{
		switch( killedrid )
		{
			case 1418:
				if (getd("$WoG_q_" + getcharid(2)) == 6) {
					setd "$WoG_q_" + getcharid(2), 7;
					announce "[Tesoro de Heimdall - Avance en la Quest por " + strcharinfo(0) + "]",4,0xCC9900;
					announce "[La caida de la Serpiente]",4,0xCC9900;
				}
				break;
			case 1623:
				if (getd("$WoG_q_" + getcharid(2)) == 15) {
					setd "$WoG_q_" + getcharid(2), 16;
					announce "[Tesoro de Heimdall - Avance en la Quest por " + strcharinfo(0) + "]",4,0xCC9900;
					announce "[Destrucción del proyecto RSX - Planos recuperados]",4,0xCC9900;
				}
				break;
			case 1688:
				if (getd("$WoG_q_" + getcharid(2)) == 23) {
					setd "$WoG_q_" + getcharid(2), 24;
					announce "[Tesoro de Heimdall - Avance en la Quest por " + strcharinfo(0) + "]",4,0xCC9900;
					announce "[Lady Tanee y el Secreto de Ancient Shrine revelado]",4,0xCC9900;
					donpcevent "Switch A#WoG_q_12::OnLady";
				}
				break;
		}
	}
	
	// Wings of Gaia Missions
	if (!$WoG_guild_id) end; // No hay guild en WoG
	if (getcharid(2) != $WoG_guild_id) end; // Diferente guild a la WoG
	if ($@WoG_access) end; // En modo aventura no funciona
	
	set .@Temp, getd("$WoG_M_" + $WoG_guild_id);
	
	if (.@Temp <= 0) end; // No registrado en las misiones
	if (.@Temp > getarraysize($@WoG_M_Type)) end; // Ya superó todas las misiones
	
	if ($@WoG_M_Type[.@Temp] != 1) end; // No es una mision de mob
	if ($@WoG_M_Orig[.@Temp] != $WoG_Cmap) end; // No está la nave en el mapa requerido
	if ($WoG_status != 0) end; // No se encuentra en Tierra

	if (killedrid != $@WoG_M_id[.@Temp]) end; // No es el mob buscado
	
	if ($WoG_MP < $@WoG_M_Total[.@Temp]) {
		set $WoG_MP, $WoG_MP + 1;
		specialeffect2 131;
		
		// Respawn en la Nave
		if (($WoG_MP % 100) == 1)
			mobevent "airwog",70 + rand(1,15),171 + rand(1,4),"--ja--",$@WoG_M_id[.@Temp],0,1,0,0,0,1,1,1,0,0,0,0,0,"WoGMission2::OnMobs";
	}
	
	if ($WoG_MP == $@WoG_M_Total[.@Temp]) {
		announce "[Wings of Gaia Mission | Pedido Completo]",4,0xCC9900;
		announce "[Lugar de Entrega: " + $@WoG_nam$[$@WoG_M_Dest[.@Temp]] + "]",4,0xCC9900;
	}
	
	end;
}

izlude,125,38,7	script	Contratista::WoGMission1	804,{
	mes "^0000FF[Contratista]^000000";
	
	if (!getcharid(2)) {
		// No tiene guild del todo
		mes "Disculpa joven, estoy muy ocupado en mis negocios como para charlar ahora.";
		close;
	}
	
	if (getd("$WoG_M_" + getcharid(2)) > 0) {
		// Inscrito en las misiones

		if ($WoG_guild_id != getcharid(2)) {
			mes "Si, me enteré que piratas les tomaron el control de la Wings of Gaia";
			mes "Espero la puedan recuperar para continuar con el comercio.";
			close;
		}

		mes "Hola, espero que el contrato que te asigné te esté dando frutos.";
		mes "Recuerda que cada misión que termines te dará un tesoro en tus producciones de la Nave.";
		next;
		mes "^0000FF[Contratista]^000000";
		mes "Cuando termines todas las 125 misiones, recibirás un tesoro adicional diario.";
		close;

	} else {
		// No es parte de las misiones
		mes "Demonios!!... nadie quiere trabajar para mí en los servicios de Transporte de Mercancías por temor a los piratas.";
		mes "Me vienen diciendo que nó en la Administración del Aeropuerto de Izlude";
		next;
		mes "^0000FF[Contratista]^000000";
		mes "Si tan solo algún buen grupo tuvieran en su control una Aeronave, les daría el contrato de comercio.";
		mes "Realmente se gana muy bien con ello.";
		
		if ($WoG_guild_id != getcharid(2))
			close;
		
		next;
		mes "^0000FF[Contratista]^000000";
		mes "Que me dices? ustedes tienen una nave llamada Wings of Gaia?";
		mes "Genial... me gustaría hablar con el lider de tu guild para ofrecerle un negocio";
		
		if (strcharinfo(0) != GetGuildMaster(getcharid(2)))
			close;
			
		next;
		mes "^0000FF[Contratista]^000000";
		mes "Oh... genial, tu eres el lider de ^0000FF" + GetGuildName(getcharid(2)) + ".^000000";
		mes "Te interesaría trabajar para mí?";
		next;
		mes "^0000FF[" + strcharinfo(0) + "]^000000";
		mes "Que se supone que tenemos que hacer?";
		next;
		mes "^0000FF[Contratista]^000000";
		mes "Existen 125 misiones que necesito que alguien termine. Hay 2 tipos de misiones:";
		mes "- Captura de Animales y Bestias";
		mes "- Colecta de Items";
		next;
		mes "^0000FF[Contratista]^000000";
		mes "En la Captura de Animales, deben atrapar (* Matar *) el mob que se les diga por misión.";
		mes "La aeronave debe estar en tierra, en el mapa de Origen para que puedan cargar las criaturas.";
		next;
		mes "^0000FF[Contratista]^000000";
		mes "En la Colecta de Items simplemente deben buscar el artículo que se les diga y llevarselo a tu encargado de Embarque en tu nave.";
		mes "Solamente se entrega en paquetes de 100";
		next;
		mes "^0000FF[Contratista]^000000";
		mes "En ambos casos, cuando terminen la cantidad solicitada, deben llevarla al mapa de Destino y esperar allí 5 minutos hasta que se termine de descargar todo.";
		next;
		mes "^0000FF[" + strcharinfo(0) + "]^000000";
		mes "Y que ganamos con esto?";
		next;
		mes "^0000FF[Contratista]^000000";
		mes "Por cada misión que terminen, se les enviarán dos Tesoros a la nave y les llegarán con la entrega de Tesoros cada 24 horas.";
		next;
		mes "^0000FF[Contratista]^000000";
		mes "Adicionalmente, al terminar las 125 misiones, se les enviará un tesoro adicional diario.";
		next;
		mes "^0000FF[" + strcharinfo(0) + "]^000000";
		mes "Algun riesgo del que deba preocuparme?";
		next;
		mes "^0000FF[Contratista]^000000";
		mes "Si durante una misión o en el momento en que se esté entregando, pierdes la Nave por invasores o piratas, perderás todo el embarque que lleves.";
		next;
		mes "^0000FF[Contratista]^000000";
		mes "Debes ser cuidado en tus horarios de Colecta y Entrega, y tratar de hacerlo con privacidad ni espias de otros clanes.";
		next;
		mes "^0000FF[" + strcharinfo(0) + "]^000000";
		mes "Como sabré en que misión voy y que tengo que colectar?";
		next;
		mes "^0000FF[Contratista]^000000";
		mes "En todo momento puedes hablar con el Vigilante de la sala de Embarque para que te diga tu Misión y Progreso.";
		mes "En fin, estas interesado en ayudarme en el comercio?";
		next;
		menu "Claro, te ayudaré",-,"No, no gracias",L_No;
		
		mes "^0000FF[Contratista]^000000";
		mes "Genial!!, permiteme llenar el contrato de una vez. Solamente firma acá";
		next;
		mes "^0000FF[Contratista]^000000";
		mes "Muchas gracias, y pues, a empezar a trabajar para volvernos millonarios";
		setd "$WoG_M_" + getcharid(2), 1;
		announce "[Guild " + GetGuildName(getcharid(2)) + " ha firmado contrato W.o.G Missions]",8;
		close;
	}
		
L_No:
	mes "^0000FF[Contratista]^000000";
	mes "Una lástima, si te arrepientes vuelve, porque mis posibilidades son pocas.";
	close;
}
