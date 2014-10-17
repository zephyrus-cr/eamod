// *********************************
// *                               *
// * Miner System - GaiaRo Version *
// *                               *
// *********************************

// Used to draw HP bar string
function	script	DrawHP	{
	set .@Draw$, " [";
	set .@HP, getarg(0);
	// Starting Color
	if( .@HP > 20 ) set .@Draw$, .@Draw$ + "^0EAE1B";
	else if( .@HP > 15 ) set .@Draw$, .@Draw$ + "^7CAE0E";
	else if( .@HP > 10 ) set .@Draw$, .@Draw$ + "^E3C521";
	else if( .@HP > 5 ) set .@Draw$, .@Draw$ + "^D86112";
	else set .@Draw$, .@Draw$ + "^D82412";
	// Draw HP Bar
	for( set .@x, 0; .@x < 30; set .@x, .@x + 1 )
	{
		if( .@x == .@HP ) set .@Draw$, .@Draw$ + "^E0E0E0=";
		else set .@Draw$, .@Draw$ + "=";
	}
	
	set .@Draw$, .@Draw$ + "^000000]";
	
	return .@Draw$;
}

// Main Mining Engine
// arg(0) = NPC Name
function	script	Mining_Work	{
	// Check Requeriments
	if( getvariableofnpc(.Mine_Init, getarg(0)) == 0 )
	{
		callfunc "Mining_Init",getarg(0),getarg(1);
		end;
	}

	if( getvariableofnpc(.Mine_On, getarg(0)) == 0 ) end;
	mes "[^0000FF" + strcharinfo(0) + "^000000]";

	set @Mine_Ele, getvariableofnpc(.Mine_Ele, getarg(0));
	set @Mine_Lvl, $@Mine_Lvl[@Mine_Ele];

	// * Working Level
	if( MiningLvl < @Mine_Lvl ) {
		mes "No tengo entrenamiento para trabajar en minas de ^0000FF" + $@Mine_Name$[@Mine_Ele] + "^000000";
		mes "Nivel requerido: ^FF0000" + $@MiningLv$[@Mine_Lvl] + "^000000";
		mes " ";
		mes ">> ^FF0000" + $@MiningLv$[MiningLvl] + "^000000 <<";
		set @Progress, (MiningExp * 30) / $@MiningLUp[MiningLvl];
		mes "" + callfunc("DrawHP",@Progress) + "";
		close;
	}
	
	// * Premium Account
	/*
	if( isPremium() == 0 && @Mine_Lvl > 5 )
	{
		mes "Esta mina está reservada para cuentas Premium";
		close;
	}
	*/

	// * Old Pick
	if( countitem(7318) < 1 ) {
		mes "Para trabajar en esta mina debo tener una Old Pick en mi inventario.";
		mes " ";
		mes ">> ^FF0000Item requerido: " + getitemname(7318) + " ^000000 <<";
		close;
	}

	// * HeadGear
	if( getequipid(1) != 5009 && getequipid(1) != 5031 ) {
		mes "Por mi seguridad, antes de trabajar mejor me equipo un un ^FF0000" + getitemname(5009) + "^000000 o un ^FF0000" + getitemname(5031) + " ^000000.";
		close;
	}

	set @Pike_HP, rand(4,10) + (MiningLvl - @Mine_Lvl) * 2;
	set @Mine_WPF, 0;
	delitem 7318,1;

	mes "Que suerte, una ^0000FF" + $@Mine_Size$[getvariableofnpc(.Mine_SZ, getarg(0))] + "^000000 mina de ^0000FF" + $@Mine_Name$[@Mine_Ele] + "^000000!!, veamos que encontramos en ella.";
	mes " ";
	mes ">> ^FF0000" + $@MiningLv$[MiningLvl] + "^000000 <<";
	if( MiningLvl < 7 ) {
		set @Progress, (MiningExp * 30) / $@MiningLUp[MiningLvl];
		mes "" + callfunc("DrawHP",@Progress) + "";
	}
	next;
	
	// Working
L_BreakRock:
	if( getvariableofnpc(.Mine_On, getarg(0)) == 0 ) goto L_Close;
	mes "> Pica:";
	mes "" + callfunc("DrawHP",@Pike_HP) + "";
	mes "> Roca:";
	mes "" + callfunc("DrawHP",getvariableofnpc(.Mine_HP, getarg(0))) + "";
	mes " ";
	mes "[^0000FF" + strcharinfo(0) + "^000000]";
	if( @Mine_WPF )
		mes "Debo golpear ^0000FF" + $@PickLocation$[getvariableofnpc(.Mine_WP, getarg(0))] + "^000000";
	else
		mes "Debo encontrar el punto debil";
	next;
	
	if( getvariableofnpc(.Mine_On, getarg(0)) == 0 ) goto L_Close;

	// Random Menu Build
	set @i, 0;
	setarray @KPos[0],9,9,9,9,9,9,9,9,9;
	setarray @TPos[0],0,1,2,3,4,5,6,7,8;

	while( @i < 9 ) {
		set @Wrd, rand(9 - @i);

		set @KPos[@i], @TPos[@Wrd];
		deletearray @TPos[@Wrd],1;
		
		set @i, @i + 1;
	}

	set @tmpMenu$,"";
	for( set @x, 0; @x < 9; set @x, @x + 1 ) {
		set @tmpMenu$, @tmpMenu$ + $@PickLocation$[@KPos[@x]] + ":";
	}
	set @tmpMenu$, @tmpMenu$ + "Salir";
	// Menu Display
	set @Opcion, select(@tmpMenu$) - 1;
	if( @Opcion == 9 ) goto L_Exit;

	if( getvariableofnpc(.Mine_On, getarg(0)) == 0 ) goto L_Close;
	// Hit Point
	if( @KPos[@Opcion] == getvariableofnpc(.Mine_WP, getarg(0)) ) {
		set @Mine_WPF, 1;
		soundeffect "chepet_attack.wav",0;
		specialeffect 4;
		set @HPower1, rand(3,4);
		set @HPower2, rand(2);
	} else {
		soundeffect "apocalips_h_move.wav",0;
		specialeffect 5;
		set @HPower1, rand(2);
		set @HPower2, rand(1,3);
	}
	
	flooritem $@Stones[rand(2)],rand(1,2);
	
	// Update Mine and Pick HP
	set getvariableofnpc(.Mine_HP, getarg(0)), getvariableofnpc(.Mine_HP, getarg(0)) - @HPower1;
	set @Pike_HP, @Pike_HP - @HPower2;

	// Success ??
	if( getvariableofnpc(.Mine_HP, getarg(0)) < 1 ) {
		soundeffect "ice_titan_die.wav",0;
		specialeffect 135;
		mes "[^0000FF" + strcharinfo(0) + "^000000]";
		mes "Lo logré!! veamos los frutos del trabajo...";
		emotion e_what,1;

		// Exp Progress
		if( MiningLvl < 7 )
		{
			set MiningExp, MiningExp + $@Mine_Exp[@Mine_Ele];
			if( MiningExp >= $@MiningLUp[MiningLvl] ) {
				// Level Up
				set MiningLvl, MiningLvl + 1;
				set MiningExp, 0;
				specialeffect2 568;
				dispbottom "[Subiste tu Nivel de experiencia a " + $@MiningLv$[MiningLvl] + " en trabajo en Minas]";
			} else {
				set @Progress, (MiningExp * 100) / $@MiningLUp[MiningLvl];
				dispbottom "[ Current: " + $@MiningLv$[MiningLvl] + " -> " + @Progress + "% -> Next: " + $@MiningLv$[MiningLvl + 1] + " ]";
			}
		}

		// Hide NPC
		setnpcdisplay getarg(0),"Mining Spot",844,0;
		set getvariableofnpc(.Mine_Spawn, getarg(0)), rand($@Mine_SpawnMin[@Mine_Ele],$@Mine_SpawnMax[@Mine_Ele]);
		set getvariableofnpc(.Mine_On, getarg(0)), 0;
		initnpctimer getarg(0);
		disablenpc getarg(0);

		set @Mine_Size, getvariableofnpc(.Mine_SZ, getarg(0));
		close2;

		// @Mine_Lvl @Mine_Ele @Mine_Size allready set
		emotion e_cash,1;
		callfunc "Mining_Drop";
		end;
	}
	
	// Accidents
	if( !rand(10) ) {
		// Scream!!
		if( sex ) soundeffect "die_male.wav",0;
		else soundeffect "die_merchant_female.wav",0;
		
		percentheal -rand(5,20),0; // Damage
		
		mes "[^0000FF" + strcharinfo(0) + "^000000]";
		mes "^FF0000" + $@MNAccidents$[rand(getarraysize($@MNAccidents$))] + "^000000";
		emotion e_omg,1;

		if( HP < 1 ) close; // Killed by Mine
		next;
	} else if( !rand(500) ) {
		specialeffect 666;
		atcommand "@die";
		announce "Hubo un derrumbe, no lograste escapar con vida!",3;
		end;
	}

	// Pike Status
	if( @Pike_HP < 1 ) {
		specialeffect 155;
		mes "[^0000FF" + strcharinfo(0) + "^000000]";
		mes "Baahhhhh.... que mala suerte... rompí la Pica!";
		close;
	}

	goto L_BreakRock;

L_Close:
	mes "[^0000FF" + strcharinfo(0) + "^000000]";
	mes "Esta veta ha colapsado, no hay más que buscar aquí.";
	close;

L_Exit:
	mes "[^0000FF" + strcharinfo(0) + "^000000]";
	mes "No me siento con suerte, talvez vuelva luego.";
	close;
}

// Called on Init per Mine
// arg(0) = NPC Name
// arg(1) = Mine Element
function	script	Mining_Init	{
	setnpcdisplay getarg(0),"Mining Spot",844,111;
	if( !$@MiningReady ) donpcevent "MiningEngine::OnInit";
	
	set getvariableofnpc(.Mine_Spawn,getarg(0)), rand($@Mine_SpawnMin[atoi(getarg(1))],$@Mine_SpawnMax[atoi(getarg(1))]);
	set getvariableofnpc(.Mine_On, getarg(0)), 0; // Mine Inactive
	set getvariableofnpc(.Mine_Ele, getarg(0)), atoi(getarg(1));
	set getvariableofnpc(.Mine_Init, getarg(0)), 1;
	
	initnpctimer getarg(0);
	disablenpc getarg(0);
	return;
}

// CountDown to Mine Spawn
// arg(0) = NPC Name
function	script	Mining_Tick	{
	stopnpctimer;
	set getvariableofnpc(.Mine_Spawn,getarg(0)), getvariableofnpc(.Mine_Spawn,getarg(0)) - 1; // Tick
	if( getvariableofnpc(.Mine_Spawn,getarg(0)) < 1 ) {
		// Mine Spawn
		enablenpc getarg(0);
		set .@size, rand(100);
		if( .@size < 5 )
			set getvariableofnpc(.Mine_SZ, getarg(0)), 2; // Big 5%
		else if( .@size < 90 )
			set getvariableofnpc(.Mine_SZ, getarg(0)), 1; // Small 85%
		else
			set getvariableofnpc(.Mine_SZ, getarg(0)), 0; // Normal 10%

		set .@Mine_Ele, getvariableofnpc(.Mine_Ele, getarg(0));
		setnpcdisplay getarg(0), "" + $@Mine_Name$[.@Mine_Ele] + " Mine", $@Mine_Sprite[.@Mine_Ele], getvariableofnpc(.Mine_SZ, getarg(0));

		specialeffect 134;
		switch( getvariableofnpc(.Mine_SZ, getarg(0)) ) {
			// Mine Total HP
			case 0: set getvariableofnpc(.Mine_HP, getarg(0)), rand(15,25); break;
			case 1: set getvariableofnpc(.Mine_HP, getarg(0)), rand(10,15); break;
			case 2: set getvariableofnpc(.Mine_HP, getarg(0)), rand(25,30); break;
		}
		
		set getvariableofnpc(.Mine_WP, getarg(0)), rand(9); // Weak Point
		set getvariableofnpc(.Mine_On, getarg(0)), 1;
		end;
	}
	initnpctimer getarg(0);
	end;
}

// Mine Drop
// Uses: @Mine_Ele @Mine_Lvl @Mine_Size
function	script	Mining_Drop	{
	// Common Minerals
	if( rand(100) < 90 + @Mine_Lvl ) getitem $@CommonMinerals[rand(getarraysize($@CommonMinerals))],1;

	// Unique Drops
	set @size, getarraysize(getd("$@Minerals_" + @Mine_Ele + "_ID"));
	switch( @Mine_Size ) {
		case 0: set @bonus, 2; break;
		case 1: set @bonus, 1; break;
		case 2: set @bonus, 3; break;
	}

	for( set @i, 0; @i < @size; set @i, @i + 1 )
	{
		set @rate, getd("$@Minerals_" + @Mine_Ele + "_RT[" + @i + "]") * @bonus;

		if( @rate >= rand(1,10000) ) getitem getd("$@Minerals_" + @Mine_Ele + "_ID[" + @i + "]"), 1;
	}
	
	// Normal Minerals
	if( rand(100) < 20 + @Mine_Lvl ) getitem $@NormalMinerals[rand(getarraysize($@NormalMinerals))],1;
	// Special Minerals
	if( rand(100) < 2 + @Mine_Lvl ) getitem $@SpecialMinerals[rand(getarraysize($@SpecialMinerals))],1;

	return;
}

-	script	MiningEngine	-1,{
	end;

OnInit:
	if( $@MiningReady ) end;

	// Player Settings
	setarray $@MiningLv$[0],	"Aspirante","Novato","Aprendiz","Jornalero","Minero","Experto","Artesano","Maestro";
	setarray $@MiningLUp[0],	       9000,   21600,     37800,      57600,   81000,   108000,    157500,   999999;

	// Per Element - Mine Settings
	setarray $@Mine_Name$[0],	"Phracon","Emveretarcon","Iron","Steel","Star","Crystal","Oridecon","Elunium","Magic Crystal"; // * Mine Names
	setarray $@Mine_Lvl[0],		        0,             1,     2,      3,     4,        5,         6,        7,              7; // * Required Lvl to Work on It
	setarray $@Mine_Sprite[0],	     1915,          1907,  1908,   1908,  1907,     1914,      1914,     1915,           1907; // * Sprite
	setarray $@Mine_SpawnMin[0],	        3,             5,    20,     40,    90,       90,        90,       90,           1200; // * Minimum Spawn Time
	setarray $@Mine_SpawnMax[0],	        5,            20,    40,     80,   120,      180,       300,      360,           2400; // * Maximum Spawn Time
	setarray $@Mine_Exp[0],		       60,           140,   250,    360,   450,      540,       630,      720,            900; // * Experience

	// Other Stuff
	setarray $@Stones[0],		7067,7049;
	setarray $@Mine_Size$[0],	"mediana","pequeña","grande";
	setarray $@PickLocation$[0],	"[O] Centro","[/\\] Arriba","[<\\] Arriba Izquierda","[<] Izquierda","[</] Abajo Izquierda","[\\/] Abajo","[\\>] Abajo Derecha","[>] Derecha","[/>] Arriba Derecha";
	setarray $@MNAccidents$[0],	"Ouchhh!!! me saltó una piedra en el ojo... snifff",
					"OMG!!!!... me aplasté el dedo!",
					"Ouch!... me saltó una piedra en la cara...",
					"Auch!!!... siempre me pego con algo... grr...",
					"Arghhh!... me saltó una piedra en la cabeza...",
					"Ayy!!... me cayó una piedra en el pie... argghh...",
					"Grrr... siempre olvido quitar la mano del medio... malditas minas...";

	// Common Drops
	setarray $@CommonMinerals[0],	909,910,911,912,7067,7049,7067,7049;
	setarray $@NormalMinerals[0],	1003,7053,7054,7315,7321,7096,7300,7067,7049,7067,7049,7067,7049;
	setarray $@SpecialMinerals[0],	7231,7231,7231,7232,7232,7232,7233,7233,7233,12040,714,969,7067,7049,7067,7049,7067,7049,7067,7049,7067,7049;

	// Unique Drops Phracon
	setarray $@Minerals_0_ID[0],	 1010, 1010, 1010,  756,  757;
	setarray $@Minerals_0_RT[0],	 4000, 2000,  500,  150,  150;
	// Unique Drops Emveretarcon
	setarray $@Minerals_1_ID[0],	 1011, 1011, 1011,  756,  757,  714;
	setarray $@Minerals_1_RT[0],	 5000, 4000, 3000,  200,  200,   50;
	// Unique Drops Iron
	setarray $@Minerals_2_ID[0],	 1002, 1002, 1002,  998,  756,  757,  998, 1003;
	setarray $@Minerals_2_RT[0],	 3500, 3000, 1000, 1000,  300,  300,  750,  500;
	// Unique Drops Steel
	setarray $@Minerals_3_ID[0],	  999,  999, 1003,  756,  757, 1003, 1003;
	setarray $@Minerals_3_RT[0],	 3500, 2500, 3500,  700,  700,  500,  250;
	// Unique Drops Star
	setarray $@Minerals_4_ID[0],	 1001, 1001, 1001, 1000, 1000, 1000,  714, 7096, 7096, 7096;
	setarray $@Minerals_4_RT[0],	 5000, 3500, 2500, 3000, 1500,  500,  100, 5000, 5000, 5000;
	// Unique Drops Crystal
	setarray $@Minerals_5_ID[0],	  730,  731,  732,  733, 7315, 7321, 7053, 7054, 7066, 7066, 7066;
	setarray $@Minerals_5_RT[0],	 4000, 2500, 3500, 1250, 4000, 5000, 2000, 2000, 5000, 5000, 5000;
	// Unique Drops Oridecon
	setarray $@Minerals_6_ID[0],	  756,  756,  756,  756,  984,  984,  984, 7620;
	setarray $@Minerals_6_RT[0],	 5000, 4000, 3000, 2000, 2500, 1500,  500,   50;
	// Unique Drops Elunium
	setarray $@Minerals_7_ID[0],	  757,  757,  757,  757,  985,  985,  985, 7619;
	setarray $@Minerals_7_RT[0],	 5000, 4000, 3000, 2000, 2500, 1500,  500,   50;
	// Unique Drops Magic Crystal
	setarray $@Minerals_8_ID[0],	 8906,  717,  717,  717,  717,  716,  716,  716,  716,  715,  715,  715,  715;
	setarray $@Minerals_8_RT[0],	 7000, 9500, 7500, 5500, 3500, 9500, 7500, 5500, 3500, 9500, 7500, 5500, 3500;

	// Spawn Min-Max Time
	
	set $@MiningReady, 1;
	end;
}

// *****************
// * Mining Guides *
// *****************

function	script	Mining_DropInfo	{
	set @Size, getarraysize(getd("$@Minerals_" + getarg(0) + "_ID"));
	set .@Return$, "";
	set .@Comma$, "";
	for( set @i, 0; @i < @Size; set @i, @i + 1 )
	{
		set .@Return$, .@Return$ + .@Comma$ + "^0000FF" + getitemname(getd("$@Minerals_" + getarg(0) + "_ID[" + @i + "]")) + "^000000";
		set .@Comma$, ", ";
	}
	
	return .@Return$;
}

function	script	Mining_Common	{
	set @Size, getarraysize($@CommonMinerals);
	set .@Return$, "";
	set .@Comma$, "";
	for( set @i, 0; @i < @Size; set @i, @i + 1 )
	{
		set .@Return$, .@Return$ + .@Comma$ + "^0000FF" + getitemname($@CommonMinerals[@i]) + "^000000";
		set .@Comma$, ", ";
	}
	
	return .@Return$;
}

function	script	Mining_Normal	{
	set @Size, getarraysize($@NormalMinerals);
	set .@Return$, "";
	set .@Comma$, "";
	for( set @i, 0; @i < @Size; set @i, @i + 1 )
	{
		set .@Return$, .@Return$ + .@Comma$ + "^0000FF" + getitemname($@NormalMinerals[@i]) + "^000000";
		set .@Comma$, ", ";
	}
	
	return .@Return$;
}

function	script	Mining_Special	{
	set @Size, getarraysize($@SpecialMinerals);
	set .@Return$, "";
	set .@Comma$, "";
	for( set @i, 0; @i < @Size; set @i, @i + 1 )
	{
		set .@Return$, .@Return$ + .@Comma$ + "^0000FF" + getitemname($@SpecialMinerals[@i]) + "^000000";
		set .@Comma$, ", ";
	}
	
	return .@Return$;
}

// Information NPCs
// arg(0) Mine Ele
// arg(1) Zeny per Old Pick

function	script	Mining_Info	{
	set @Mine_Ele, getarg(0);
	set @Mine_Lvl, $@Mine_Lvl[@Mine_Ele];
	
	mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
	mes "Bienvenido a las minas de ^FF0000" + $@Mine_Name$[@Mine_Ele] + "^000000.";
	if( @Mine_Lvl < 7 )
		mes "Estoy trabajando fuertemente para convertirme en un ^FF0000" + $@MiningLv$[@Mine_Lvl + 1] + "^000000.";
	else
		mes "Soy un Maestro, experto en minería y con la habilidad de trabajar en cualquier mina.";
	next;
	mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
	mes "En que te puedo ayudar?";
	next;
	switch( select("Vendeme Old Picks:¿Trabajo en Minas?:Hablame de las Minas:¿Otros Drops?:¿Diferentes tamaños?:¿Al ser Maestro?:Nada gracias.") )
	{
		case 1:
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "Claro, traigo siempre muchas conmigo pues se rompen seguido.";
			mes "Te las puedo vender en " + getarg(1) + " zeny.";
			mes "Cuantas deseas comprar? (de 1 a 10)";
			next;
			input @Picks;
			if( @Picks < 1 || @Picks > 10 ) {
				mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
				mes "Por favor, un número de 1 a 10. No seas abusivo ni ilógico.";
				close;
			}
			
			set @Price, getarg(1) * @Picks;
			if( Zeny < @Price ) {
				mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
				mes "Lo lamento pero no tienes suficiente dinero para pagar lo que quieres.";
				close;
			}
			
			set Zeny, Zeny - @Price;
			getitem 7318, @Picks;
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "Aquí tienes, mucha suerte, son de buena calidad.";
			break;
		case 2:
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "La minería es una buena actividad en la cual trabajar. Extraer minerales de diferentes minas, en diferentes lugares te puede hacer buena fortuna.";
			next;
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "En muchos lugares de Midgard existen minas de diferentes elementos que otorgan una diferente variedad de Minerales.";
			mes "Pero para poder trabajar en Minas de Mayor nivel, se requiere que tengas experiencia.";
			next;
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "Existen 8 niveles diferentes de Trabajador:";
			mes "- Lvl 0 : ^FF0000Aspirante^000000";
			mes "- Lvl 1 : ^FF0000Novato^000000";
			mes "- Lvl 2 : ^FF0000Aprendiz^000000";
			mes "- Lvl 3 : ^FF0000Jornalero^000000";
			mes "- Lvl 4 : ^FF0000Minero^000000";
			mes "- Lvl 5 : ^FF0000Experto^000000";
			mes "- Lvl 6 : ^FF0000Artesano^000000";
			mes "- Lvl 7 : ^FF0000Maestro^000000";
			break;
		case 3:
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "Sobre cual tipo de Mina deseas averiguar?";
			set @Mine, 0;
			while( @Mine != 10 )
			{
				next;
				set @Mine, select("Phracon:Emveretarcon:Iron:Steel:Star:Crystal:Oridecon:Elunium:Magic Crystal:Gracias por la Info");
				switch( @Mine )
				{
					case 1:
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Las minas de Phracon las encontrarás en Payon Dungeon.";
						mes "De ellas puedes obtener los siguientes minerales:";
						mes "" + callfunc("Mining_DropInfo",0) + ".";
						next;
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Para trabajar en estas minas, debes ser Aspirante.";
						break;
					case 2:
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Las minas de Emveretarcon las encontrarás en Ant Hell.";
						mes "De ellas puedes obtener los siguientes minerales:";
						mes "" + callfunc("Mining_DropInfo",1) + ".";
						next;
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Para trabajar en estas minas, debes ser Novato.";
						break;
					case 3:
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Las minas de Iron las encontrarás en Einbech Dungeon.";
						mes "De ellas puedes obtener los siguientes minerales:";
						mes "" + callfunc("Mining_DropInfo",2) + ".";
						next;
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Para trabajar en estas minas, debes ser Aprendiz.";
						break;
					case 4:
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Las minas de Steel las encontrarás en Juperos.";
						mes "De ellas puedes obtener los siguientes minerales:";
						mes "" + callfunc("Mining_DropInfo",3) + ".";
						next;
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Para trabajar en estas minas, debes ser Jornalero.";
						break;
					case 5:
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Las minas de Star las encontrarás en Magma Dungeon.";
						mes "De ellas puedes obtener los siguientes minerales:";
						mes "" + callfunc("Mining_DropInfo",4) + ".";
						next;
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Para trabajar en estas minas, debes ser Minero.";
						break;
					case 6:
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Las minas de Crystal las encontrarás en Ice Dungeon.";
						mes "De ellas puedes obtener los siguientes minerales:";
						mes "" + callfunc("Mining_DropInfo",5) + ".";
						next;
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Para trabajar en estas minas, debes ser Experto.";
						break;
					case 7:
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Las minas de Oridecon las encontrarás en Abyss Lake.";
						mes "De ellas puedes obtener los siguientes minerales:";
						mes "" + callfunc("Mining_DropInfo",6) + ".";
						next;
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Para trabajar en estas minas, debes ser Artesano.";
						break;
					case 8:
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Las minas de Elunium las encontrarás en Thor Dungeon.";
						mes "De ellas puedes obtener los siguientes minerales:";
						mes "" + callfunc("Mining_DropInfo",7) + ".";
						next;
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Para trabajar en estas minas, debes ser Maestro.";
						break;
					case 9:
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Las minas de Magic Crystal son especiales y las encontrarás en medio de un mapa, en un pequeño oasis en el desierto al norte de Rachel.";
						mes "De ellas puedes obtener los siguientes minerales:";
						mes "" + callfunc("Mining_DropInfo",8) + ".";
						next;
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Para trabajar en estas minas, debes ser Maestro.";
						mes "A diferencia de las otras minas, estas producen un Crystal especial llamado ^FF0000Support Crystal Summoner^000000.";
						break;
					case 10:
						mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
						mes "Un gusto ayudarte en la información que necesites.";
						break;
				}
			}
			break;
		case 4:
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "Existen ciertos minerales que salen en las diferentes Minas, y en todas en común.";
			next;
			mes "Minerales ^0000FFComunes^000000 : 90% chance";
			mes "Puedes obtener uno de los siguientes minerales:";
			mes "" + callfunc("Mining_Common") + ".";
			next;
			mes "Minerales ^0000FFNormales^000000 : 20% chance";
			mes "Puedes obtener uno de los siguientes minerales:";
			mes "" + callfunc("Mining_Normal") + ".";
			next;
			mes "Minerales ^0000FFComunes^000000 : 2% chance";
			mes "Puedes obtener uno de los siguientes minerales:";
			mes "" + callfunc("Mining_Special") + ".";
			next;
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "El porcentaje base de obtenerlos no cambia por el tamaño de la Mina, pero si mejora entre mayor sea el nivel requerido esta.";
			next;
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "Por ejemplo, en Minas de Phracon tienes 2% suerte de minerales comunes, mientras que en minas de Elunium sube a 9%";
			break;
		case 5:
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "Las minas se presentan en diferentes tamaños, siendo más faciles de encontrar las pequeñas, luego las medianas y dificiles de aparecer las minas grandes.";
			next;
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "Entre mayor sea el tamaño de la mina, mayor es el chance de obtener todos sus drops.";
			break;
		case 6:
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "Oh... ser maestro es lo mejor, puedes trabajar en cualquier tipo de Mina y con muy buena suerte y habilidad.";
			mes "Pero también hay algo especial al ser Maestro...";
			next;
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "Los Maestros pueden trabajar en unas minas muy raras que se forman al norte de Rachel, en un pequeño oasis al medio de un mapa.";
			mes "Este objeto permite invocar un ^0000FFSupport Crystal^000000 por 20 minutos, el cual brinda diferentes bendiciones y mantiene saludabes a todos a su alrededor.";
			break;
		case 7:
			mes "[^0000FF" + $@MiningLv$[@Mine_Lvl] + " Minero^000000]";
			mes "Entonces ponte a trabajar!!";
			mes "Recuerda, necesitas Old Picks y proteger tu cabeza para trabajar aquí.";
			mes "Y mucho cuidado con los accidentes...";
			break;
	}
	close;
}

pay_dun00,149,171,1	script	Aspirante Minero::OPick1	848,{
	callfunc "Mining_Info",0,1400;
}

anthell01,85,261,3	script	Novato Minero::OPick2	848,{
	callfunc "Mining_Info",1,1510;
}

ein_dun02,261,210,5	script	Aprendiz Minero::OPick3	848,{
	callfunc "Mining_Info",2,1620;
}

juperos_01,146,51,5	script	Jornalero Minero::OPick4	848,{
	callfunc "Mining_Info",3,1730;
}

mag_dun01,229,62,7	script	Minero Minero::OPick5	848,{
	callfunc "Mining_Info",4,1840;
}

ice_dun03,32,252,3	script	Experto Minero::OPick6	848,{
	callfunc "Mining_Info",5,1950;
}

abyss_02,247,273,3	script	Artesano Minero::OPick7	848,{
	callfunc "Mining_Info",6,2060;
}

thor_v02,24,126,1	script	Maestro Minero::OPick8	848,{
	callfunc "Mining_Info",7,2170;
}

// *****************
// * Phracon Mines *
// *****************
pay_dun00,146,173,0	script	MiningSpot#0::MPay00	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,146,171,0	script	MiningSpot#0::MPay01	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,148,175,0	script	MiningSpot#0::MPay02	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,152,175,0	script	MiningSpot#0::MPay03	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,153,175,0	script	MiningSpot#0::MPay04	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,155,175,0	script	MiningSpot#0::MPay05	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,156,174,0	script	MiningSpot#0::MPay06	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,157,173,0	script	MiningSpot#0::MPay07	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,157,172,0	script	MiningSpot#0::MPay08	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,145,170,0	script	MiningSpot#0::MPay09	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,143,168,0	script	MiningSpot#0::MPay10	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,149,175,0	script	MiningSpot#0::MPay11	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,157,169,0	script	MiningSpot#0::MPay12	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,157,168,0	script	MiningSpot#0::MPay13	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,157,167,0	script	MiningSpot#0::MPay14	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,144,169,0	script	MiningSpot#0::MPay15	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,145,172,0	script	MiningSpot#0::MPay16	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,150,176,0	script	MiningSpot#0::MPay17	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,149,176,0	script	MiningSpot#0::MPay18	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,154,176,0	script	MiningSpot#0::MPay19	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,156,175,0	script	MiningSpot#0::MPay20	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,158,169,0	script	MiningSpot#0::MPay21	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

pay_dun00,158,172,0	script	MiningSpot#0::MPay22	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

// **********************
// * Emveretarcon Mines *
// **********************

anthell01,92,271,0	script	MiningSpot#1::MAnt00	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,91,270,0	script	MiningSpot#1::MAnt01	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,94,271,0	script	MiningSpot#1::MAnt02	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,97,271,0	script	MiningSpot#1::MAnt03	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,104,265,0	script	MiningSpot#1::MAnt04	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,107,264,0	script	MiningSpot#1::MAnt05	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,108,263,0	script	MiningSpot#1::MAnt06	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,108,261,0	script	MiningSpot#1::MAnt07	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,77,262,0	script	MiningSpot#1::MAnt08	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,78,263,0	script	MiningSpot#1::MAnt09	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,78,254,0	script	MiningSpot#1::MAnt10	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,86,264,0	script	MiningSpot#1::MAnt11	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,87,265,0	script	MiningSpot#1::MAnt12	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,101,252,0	script	MiningSpot#1::MAnt13	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,105,254,0	script	MiningSpot#1::MAnt14	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,94,272,0	script	MiningSpot#1::MAnt15	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,95,272,0	script	MiningSpot#1::MAnt16	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,96,272,0	script	MiningSpot#1::MAnt17	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,88,267,0	script	MiningSpot#1::MAnt18	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,76,259,0	script	MiningSpot#1::MAnt19	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,76,258,0	script	MiningSpot#1::MAnt20	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,75,257,0	script	MiningSpot#1::MAnt21	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

anthell01,78,252,0	script	MiningSpot#1::MAnt22	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

// **************
// * Iron Mines *
// **************

ein_dun02,287,183,0	script	MiningSpot#2::MEin00	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,286,183,0	script	MiningSpot#2::MEin01	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,283,184,0	script	MiningSpot#2::MEin02	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,281,187,0	script	MiningSpot#2::MEin03	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,276,192,0	script	MiningSpot#2::MEin04	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,275,193,0	script	MiningSpot#2::MEin05	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,269,199,0	script	MiningSpot#2::MEin06	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,270,200,0	script	MiningSpot#2::MEin07	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,267,207,0	script	MiningSpot#2::MEin08	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,267,211,0	script	MiningSpot#2::MEin09	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,266,216,0	script	MiningSpot#2::MEin10	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,276,222,0	script	MiningSpot#2::MEin11	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,277,222,0	script	MiningSpot#2::MEin12	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,278,222,0	script	MiningSpot#2::MEin13	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,281,223,0	script	MiningSpot#2::MEin14	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,266,209,0	script	MiningSpot#2::MEin15	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,266,210,0	script	MiningSpot#2::MEin16	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,266,211,0	script	MiningSpot#2::MEin17	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,266,203,0	script	MiningSpot#2::MEin18	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,267,203,0	script	MiningSpot#2::MEin19	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,283,223,0	script	MiningSpot#2::MEin20	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,284,223,0	script	MiningSpot#2::MEin21	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ein_dun02,285,223,0	script	MiningSpot#2::MEin22	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

// ***************
// * Steel Mines *
// ***************

juperos_01,160,49,0	script	MiningSpot#3::MJup00	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,158,49,0	script	MiningSpot#3::MJup01	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,157,48,0	script	MiningSpot#3::MJup02	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,153,47,0	script	MiningSpot#3::MJup03	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,150,46,0	script	MiningSpot#3::MJup04	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,151,46,0	script	MiningSpot#3::MJup05	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,148,44,0	script	MiningSpot#3::MJup06	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,147,44,0	script	MiningSpot#3::MJup07	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,146,42,0	script	MiningSpot#3::MJup08	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,145,40,0	script	MiningSpot#3::MJup09	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,135,34,0	script	MiningSpot#3::MJup10	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,137,36,0	script	MiningSpot#3::MJup11	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,128,37,0	script	MiningSpot#3::MJup12	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,129,36,0	script	MiningSpot#3::MJup13	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,147,42,0	script	MiningSpot#3::MJup14	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,149,68,0	script	MiningSpot#3::MJup15	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,150,67,0	script	MiningSpot#3::MJup16	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,151,66,0	script	MiningSpot#3::MJup17	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,161,55,0	script	MiningSpot#3::MJup18	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,160,56,0	script	MiningSpot#3::MJup19	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,161,53,0	script	MiningSpot#3::MJup20	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,150,47,0	script	MiningSpot#3::MJup21	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

juperos_01,151,47,0	script	MiningSpot#3::MJup22	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

// **************
// * Star Mines *
// **************

mag_dun01,227,85,0	script	MiningSpot#4::MMag00	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,229,83,0	script	MiningSpot#4::MMag01	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,229,80,0	script	MiningSpot#4::MMag02	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,229,82,0	script	MiningSpot#4::MMag03	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,215,68,0	script	MiningSpot#4::MMag04	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,212,75,0	script	MiningSpot#4::MMag05	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,232,67,0	script	MiningSpot#4::MMag06	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,242,58,0	script	MiningSpot#4::MMag07	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,243,57,0	script	MiningSpot#4::MMag08	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,219,62,0	script	MiningSpot#4::MMag09	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,219,67,0	script	MiningSpot#4::MMag10	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,235,51,0	script	MiningSpot#4::MMag11	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,213,74,0	script	MiningSpot#4::MMag12	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,211,76,0	script	MiningSpot#4::MMag13	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,229,79,0	script	MiningSpot#4::MMag14	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,216,67,0	script	MiningSpot#4::MMag15	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,217,67,0	script	MiningSpot#4::MMag16	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,218,67,0	script	MiningSpot#4::MMag17	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,215,67,0	script	MiningSpot#4::MMag18	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,235,62,0	script	MiningSpot#4::MMag19	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,236,61,0	script	MiningSpot#4::MMag20	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,236,51,0	script	MiningSpot#4::MMag21	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

mag_dun01,231,52,0	script	MiningSpot#4::MMag22	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

// *****************
// * Crystal Mines *
// *****************

ice_dun03,27,250,0	script	MiningSpot#5::MIce00	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,28,249,0	script	MiningSpot#5::MIce01	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,27,257,0	script	MiningSpot#5::MIce02	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,28,258,0	script	MiningSpot#5::MIce03	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,30,258,0	script	MiningSpot#5::MIce04	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,31,258,0	script	MiningSpot#5::MIce05	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,35,265,0	script	MiningSpot#5::MIce06	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,36,266,0	script	MiningSpot#5::MIce07	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,37,267,0	script	MiningSpot#5::MIce08	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,43,266,0	script	MiningSpot#5::MIce09	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,42,266,0	script	MiningSpot#5::MIce10	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,44,265,0	script	MiningSpot#5::MIce11	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,46,261,0	script	MiningSpot#5::MIce12	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,46,262,0	script	MiningSpot#5::MIce13	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,35,262,0	script	MiningSpot#5::MIce14	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,51,258,0	script	MiningSpot#5::MIce15	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,52,258,0	script	MiningSpot#5::MIce16	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,52,257,0	script	MiningSpot#5::MIce17	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,26,254,0	script	MiningSpot#5::MIce18	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,26,255,0	script	MiningSpot#5::MIce19	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,26,253,0	script	MiningSpot#5::MIce20	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,37,266,0	script	MiningSpot#5::MIce21	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ice_dun03,38,266,0	script	MiningSpot#5::MIce22	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

// ******************
// * Oridecon Mines *
// ******************

abyss_02,251,284,0	script	MiningSpot#6::MAby00	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,250,285,0	script	MiningSpot#6::MAby01	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,245,287,0	script	MiningSpot#6::MAby02	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,246,286,0	script	MiningSpot#6::MAby03	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,241,288,0	script	MiningSpot#6::MAby04	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,241,289,0	script	MiningSpot#6::MAby05	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,241,290,0	script	MiningSpot#6::MAby06	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,235,274,0	script	MiningSpot#6::MAby07	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,236,274,0	script	MiningSpot#6::MAby08	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,237,274,0	script	MiningSpot#6::MAby09	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,241,271,0	script	MiningSpot#6::MAby10	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,260,266,0	script	MiningSpot#6::MAby11	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,261,266,0	script	MiningSpot#6::MAby12	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,264,265,0	script	MiningSpot#6::MAby13	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,265,265,0	script	MiningSpot#6::MAby14	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,241,280,0	script	MiningSpot#6::MAby15	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,241,279,0	script	MiningSpot#6::MAby16	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,240,279,0	script	MiningSpot#6::MAby17	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,257,265,0	script	MiningSpot#6::MAby18	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,257,264,0	script	MiningSpot#6::MAby19	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,257,266,0	script	MiningSpot#6::MAby20	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,259,278,0	script	MiningSpot#6::MAby21	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

abyss_02,260,277,0	script	MiningSpot#6::MAby22	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

// *****************
// * Elunium Mines *
// *****************

thor_v02,23,136,0	script	MiningSpot#7::MTho00	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,24,137,0	script	MiningSpot#7::MTho01	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,27,137,0	script	MiningSpot#7::MTho02	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,28,136,0	script	MiningSpot#7::MTho03	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,33,136,0	script	MiningSpot#7::MTho04	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,34,137,0	script	MiningSpot#7::MTho05	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,40,137,0	script	MiningSpot#7::MTho06	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,41,137,0	script	MiningSpot#7::MTho07	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,42,138,0	script	MiningSpot#7::MTho08	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,56,145,0	script	MiningSpot#7::MTho09	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,57,145,0	script	MiningSpot#7::MTho10	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,59,139,0	script	MiningSpot#7::MTho11	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,60,138,0	script	MiningSpot#7::MTho12	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,64,137,0	script	MiningSpot#7::MTho13	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,65,137,0	script	MiningSpot#7::MTho14	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,15,128,0	script	MiningSpot#7::MTho15	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,15,129,0	script	MiningSpot#7::MTho16	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,16,129,0	script	MiningSpot#7::MTho17	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,21,132,0	script	MiningSpot#7::MTho18	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,20,128,0	script	MiningSpot#7::MTho19	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,45,143,0	script	MiningSpot#7::MTho20	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,45,144,0	script	MiningSpot#7::MTho21	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

thor_v02,46,144,0	script	MiningSpot#7::MTho22	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

// *****************
// * Magic Crystal *
// *****************

ra_fild03,220,267,0	script	MiningSpot#8::MRac00	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ra_fild03,212,272,0	script	MiningSpot#8::MRac01	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ra_fild03,208,262,0	script	MiningSpot#8::MRac02	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ra_fild03,217,261,0	script	MiningSpot#8::MRac03	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ra_fild03,213,265,0	script	MiningSpot#8::MRac04	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ra_fild03,218,268,0	script	MiningSpot#8::MRac05	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

ra_fild03,211,268,0	script	MiningSpot#8::MRac06	844,{
	callfunc "Mining_Work",strnpcinfo(3),strnpcinfo(2); end;
OnInit:		callfunc "Mining_Init",strnpcinfo(3),strnpcinfo(2); end;
OnTimer60000: 	callfunc "Mining_Tick",strnpcinfo(3); end;
}

// ***************
// * Event Mines *
// ***************

