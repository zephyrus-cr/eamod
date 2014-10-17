// *****************************************
// * Sistema de Armamento de Wings of Gaia *
// *****************************************

function	script	WoG_CanonF	{
	// Script Base de Cañones
	if ($WoG_status != 3) {
		mes "^0000FF* Solo se puede atacar sobrevolando el mapa *^000000";
		close;
	}
	
	if (getd("$@WoG_CanonB" + getarg(0))) {
		mes "^0000FF* Recargando Cañon *^000000";
		mes "(Se debe esperar 20 segundos después de cada disparo)";
		close;
	}
	
	if (countitem(12018) <= 0) {
		mes "^0000FF* Item Firecracker es requerido para disparar *^000000";
		close;
	}
	
	mes "^0000FF[Sistema de Ataque]^000000";
	mes "Atacar: ^FF0000" + $@WoG_nam$[$WoG_Cmap] + "^000000";
	mes "Ultimo Ataque en:";
	
	if (getd("$@WoG_CanonX" + getarg(0)) == 0 && getd("$@WoG_CanonY" + getarg(0)) == 0)
		mes "Ultimo Ataque: ^FF0000Aleatorio^000000";
	else
		mes "Ultimo Ataque: ^FF0000" + getd("$@WoG_CanonX" + getarg(0)) + ", " + getd("$@WoG_CanonY" + getarg(0)) + "^000000.";
	
	switch (select("Nueva Coordenada","Misma Coordenada","Asegurar Aterrizaje")) {
		case 1:
			mes "Coordenada X:";
			input @Px;
			mes "Coordenada Y:";
			input @Py;
		break;

		case 2:
			set @Px, getd("$@WoG_CanonX" + getarg(0));
			set @Py, getd("$@WoG_CanonY" + getarg(0));
		break;

		case 3:
			set @Px, $@WoG_mapX[$WoG_Cmap];
			set @Py, $@WoG_mapY[$WoG_Cmap];
		break;
	}

	mes ">> X= ^0000FF" + @Px + "^000000 Y= ^0000FF" + @Py + "^000000 <<";
	
	menu "FUEGO!!!",-,"ALTO AL FUEGO",L_Stop;
	
	if (getd("$@WoG_CanonB" + getarg(0))) {
		mes "> ^0000FFNo se puede disparar tan seguido. Debes esperar 20 segundos luego de cada disparo...^000000";
		goto L_Stop;
	}
	
	if ($WoG_status != 3) {
		mes "> ^0000FFAeronave cambió de estado...^000000";
		goto L_Stop;
	}
	
	if ($WoG_Shots <= 0) {
		mes "> ^0000FFArmamento agotado...^000000";
		goto L_Stop;
	}
	
	// Nueva Limitante de Disparar en Ciudades
	if ($WoG_Cmap >= 0 && $WoG_Cmap <= 24) {
		mes "> ^0000FFDisparar a las Ciudades es considerado Traición al Reino!!...^000000";
		goto L_Stop;
	}
	
	if ($@WoG_STimer + 60 <= gettimetick(2)) {
		mapannounce $@WoG_map$[$WoG_Cmap],"[" + $@WoG_nam$[$WoG_Cmap] + " esta siendo atacado por Wings of Gaia]",1,0xFFFF00;
		set $@WoG_STimer, gettimetick(2);
	}
	
	delitem 12018,1;
	set $WoG_Shots, $WoG_Shots - 1;
	
	// Ultima Coordenada
	setd "$@WoG_CanonX" + getarg(0), @Px;
	setd "$@WoG_CanonY" + getarg(0), @Py;

	misceffect 170;
	donpcevent "::OnAirplaneMove";
	
	if ($WoG_Suministros)
		set @Presicion,20;
	else
		set @Presicion,6;

	mobdemolition $@WoG_map$[$WoG_Cmap],@Px,@Py,@Presicion,0,1,rand(500,5000);
	setd "$@WoG_CanonB" + getarg(0), 1;
	initnpctimer;
	close;
	
L_Stop:
	mes "> ^0000FFCancelando...^000000";
	close;
}

// Cañones

airwog,91,205,0	script	Cañon A::WoG_Canon1	111,{
	callfunc "WoG_CanonF",1;
	end;

OnTimer20000:
	set $@WoG_CanonB1, 0;
	misceffect 104;
	stopnpctimer;
	end;

OnAirplaneMove:
	misceffect 537;
	end;
}

airwog,95,204,0	script	Cañon B::WoG_Canon2	111,{
	callfunc "WoG_CanonF",2;
	end;

OnTimer20000:
	set $@WoG_CanonB2, 0;
	misceffect 104;
	stopnpctimer;
	end;

OnAirplaneMove:
	misceffect 537;
	end;
}

airwog,99,203,0	script	Cañon C::WoG_Canon3	111,{
	callfunc "WoG_CanonF",3;
	end;

OnTimer20000:
	set $@WoG_CanonB3, 0;
	misceffect 104;
	stopnpctimer;
	end;

OnAirplaneMove:
	misceffect 537;
	end;
}

airwog,91,169,0	script	Cañon D::WoG_Canon4	111,{
	callfunc "WoG_CanonF",4;
	end;

OnTimer20000:
	set $@WoG_CanonB4, 0;
	misceffect 104;
	stopnpctimer;
	end;

OnAirplaneMove:
	misceffect 537;
	end;
}

airwog,95,171,0	script	Cañon E::WoG_Canon5	111,{
	callfunc "WoG_CanonF",5;
	end;

OnTimer20000:
	set $@WoG_CanonB5, 0;
	misceffect 104;
	stopnpctimer;
	end;

OnAirplaneMove:
	misceffect 537;
	end;
}

airwog,99,172,0	script	Cañon F::WoG_Canon6	111,{
	callfunc "WoG_CanonF",6;
	end;

OnTimer20000:
	set $@WoG_CanonB6, 0;
	misceffect 104;
	stopnpctimer;
	end;

OnAirplaneMove:
	misceffect 537;
	end;
}

// Recargado de Balas

airwog,88,169,5	script	Blacksmith::WoGSCanon1	63,{
	mes "^0000FF[Blacksmith]^000000";
	if (!callfunc("get_WoGID") && getgmlevel() <= 5) {
		mes "No eres miembro de los propietarios de la Nave.";
		mes "Por favor retiraré o activaré la alerta.";
		close;
	}
	
	mes "Soy el encargado de las Balas de Cañon en la nave.";
	mes "Tenemos ^FF0000" + $WoG_Shots + "^000000 de un máximo de 200 balas.";
	mes "Se necesitan ^0000FF5 Detonators^000000 por bala.";
	if( countitem(1051) < 5 )
		close;

	mes "¿Deseas crear balas ahora?";
	next;
	menu "Sí, aportar lo máximo",-,"No gracias",L_Salir;
	set @Total, 0;

L_Loop:
	if( $WoG_Shots < 200 && countitem(1051) > 4 ) {
		set $WoG_Shots, $WoG_Shots + 1;
		set @Total, @Total + 1;
		delitem 1051,5;
		goto L_Loop;
	}
	
	misceffect 154;
	mes "^0000FF[Blacksmith]^000000";
	mes "Aportaste un total de " + @Total + " balas para Wings of Gaia";
	mes "Recuerda que necesitas ^0000FFFirecracker^000000 para disparar desde los cañones.";
	close;

L_Salir:
	mes "^0000FF[Blacksmith]^000000";
	mes "Pasa buen día";
	close;
}

airwog,88,203,5	script	Comandante::WoGSCanon2	56,{
	mes "^0000FF[Comandante]^000000";
	mes "Este es el sistema de Defensa y Ataque de ^0000FFWings of Gaia^000000.";
	mes "Hay 6 cañones en total y una capacidad de 200 balas para transportar en los viajes.";
	next;
	mes "^0000FF[Comandante]^000000";
	mes "Cualquier miembro de la Guild propietaria de la nave puede disparar los cañones utilizando ^0000FFFirecrackers^000000.";
	next;
	mes "^0000FF[Comandante]^000000";
	mes "Luego de cada disparo se debe esperar 20 segundos para que el cañon se enfrie y recargue el siguiente tiro.";
	next;
	mes "^0000FF[Comandante]^000000";
	mes "Solamente se puede disparar cuando la nave está sobrevolando un mapa, y el daño por disparo es enorme.";
	close;
}

