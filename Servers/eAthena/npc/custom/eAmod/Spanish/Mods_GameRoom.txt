// Simon Dice - Games
// ========================================================================

quiz_02	mapflag	nomemo
quiz_02	mapflag	nosave	SavePoint
quiz_02	mapflag	nowarp
quiz_02	mapflag	nowarpto
quiz_02	mapflag	noreturn
quiz_02	mapflag	noicewall
quiz_02	mapflag	nobranch
quiz_02	mapflag	nopenalty
quiz_02	mapflag	noteleport

// WoE Second Edition - Games
// ========================================================================

quiz_02,249,389,4	script	Game Master::RepairManager	903,{
	mes "[ ^FFA500Game Master^000000 ]";
	mes "Bienvenido a la Sala de práctica para reparaciones de WoE Second Edition.";
	mes "Hay 2 cuartos disponibles, busca alguno desocupado si deseas probar suerte.";
	close;
}

quiz_02,262,365,0	script	G. Stone Repair Test::RepairTestB	722,{
	mes "[ ^FFA500Guardian Stone Test^000000 ]";
	mes "Mejor Puntaje Reparador:";
	if( $RepairTestB_ID )
	{
		mes "- Jugador : ^0000FF" + $RepairTestB_Name$ + "^000000.";
		mes "- Tiempo : ^0000FF" + $RepairTestB_Time + "^000000 ms.";
	}
	else
	{
		mes "- Jugador : ^0000FF(ninguno)^000000.";
		mes "- Tiempo : ^0000FF(no establecido)^000000 ms.";
	}
	
	if( select("Intentar Prueba:Salir") == 2 )
		close;

	if( getvariableofnpc(.Char_ID,"MainRepairTestB") )
	{
		mes "La sala de pruebas está en uso.";
		close;
	}

	set getvariableofnpc(.Char_ID,"MainRepairTestB"),getcharid(0);
	set getvariableofnpc(.Char_Name$,"MainRepairTestB"),strcharinfo(0);
	set getvariableofnpc(.Test_Step,"MainRepairTestB"),0;

	initnpctimer "MainRepairTestB";

	warp "quiz_02",264,344;
	end;
}

quiz_02,264,346,0	script	MainRepairTestB	-1,13,13,{
	end;

OnTimer10000:
	if( .Test_Step != 0 )
		end;

	stopnpctimer;
	set .Char_ID, 0;
	end; // Maybe Lag

OnTouch:
	if( .Char_ID != getcharid(0) )
	{
		warp "SavePoint",0,0; // Kick Player
		end;
	}
	if( .Test_Step != 0 )
		end; // Touching but already inside? Maybe hiding/unhiding

	set .Test_Step, 1; // Announcing
	sleep 2000;
	areaannounce "quiz_02",252,334,275,357,"Preparate!! La prueba iniciará en 5 segundos.",8;
	sleep 2000;
	areaannounce "quiz_02",252,334,275,357,"3 segundos...",8;
	sleep 1000;
	areaannounce "quiz_02",252,334,275,357,"2 segundos...",8;
	sleep 1000;
	areaannounce "quiz_02",252,334,275,357,"1 segundo...",8;
	sleep 1000;
	areaannounce "quiz_02",252,334,275,357,"Adelante!! Repara la Guardian Stone!!",8;
	set .Test_Init, gettimetick(0);
	set .Test_Step, 2; // Repairing!!
	initnpctimer;
	end;

OnTimer30000:
	areaannounce "quiz_02",252,334,275,357,"60 segundos restantes para reparar la Guardian Stone...",8;
	end;

OnTimer60000:
	areaannounce "quiz_02",252,334,275,357,"30 segundos restantes para reparar la Guardian Stone...",8;
	end;

OnTimer80000:
	areaannounce "quiz_02",252,334,275,357,"10 segundos restantes para reparar la Guardian Stone...",8;
	end;

OnTimer90000:
	stopnpctimer;
	set .Test_Step, 3;
	areaannounce "quiz_02",252,334,275,357,"Tiempo Fuera!! No superaste la prueba!!",8;
	sleep 2000;
	areawarp "quiz_02",252,334,275,357,"quiz_02",262,370;
	set .Test_Step, 0;
	set .Char_ID, 0;
	end;

OnRepairDone:
	stopnpctimer;
	if( .Test_Step != 2 )
		end; // Time Out

	set .Test_Completed, gettimetick(0) - .Test_Init;
	areaannounce "quiz_02",252,334,275,357,"Prueba superada en " + .Test_Completed + " milisegundos!!",8;
	if( .Test_Completed < $RepairTestB_Time || $RepairTestB_Time == 0 )
	{
		set $RepairTestB_Time, .Test_Completed;
		set $RepairTestB_Name$, .Char_Name$;
		set $RepairTestB_ID, .Char_ID;
	}
	
	set .Test_Step, 3;
	sleep 2000;
	areawarp "quiz_02",252,334,275,357,"quiz_02",262,370;
	set .Test_Step, 0;
	set .Char_ID, 0;
	end;
}

quiz_02,264,346,4	script	Guardian Stone::DevRepairTestB	858,{
	if( getvariableofnpc(.Test_Step,"MainRepairTestB") != 2 )
		end;
	if( getvariableofnpc(.Char_ID,"MainRepairTestB") != getcharid(0) )
		end;

	mes "^3355FFYou will need the";
	mes "following materials to";
	mes "rebuild a destroyed";
	mes "Guardian Stone.^000000";
	next;
	mes "1 Oridecon";
	mes "1 Elunium";
	mes "30 Stones";
	mes "5 Blue Gemstones";
	mes "5 Yellow Gemstones";
	mes "5 Red Gemstones";
	next;
	mes "^3355FFDo you want to continue?^000000";
	switch( select("No:Continue") )
	{
		case 1:
			mes "^3355FFWork canceled.^000000";
			close;
		case 2:
			mes "^3355FFArrange Stones, Elunium, and";
			mes "Oridecon, in that order, in the";
			mes "center. Then you must arrange";
			mes "the enchanted Gemstones to";
			mes "rebuild the Guardian Stone.^000000";
			next;
			switch( select("Elunium:Oridecon:Stone") )
			{
				case 1:
					mes "^3355FFElunium has been";
					mes "placed in the center.^000000";
					next;
					break;
				case 2:
					mes "^3355FFOridecon has been";
					mes "placed in the center.^000000";
					next;
					break;
				case 3:
					mes "^3355FFStones have been";
					mes "placed in the center.^000000";
					set .@nice,.@nice + 10;
					next;
					break;
			}
			switch( select("Elunium:Oridecon:Stone") )
			{
				case 1:
					mes "^3355FFYou have lined the";
					mes "outside of the center";
					mes "with some Elunium.^000000";
					set .@nice,.@nice + 10;
					next;
					break;
				case 2:
					mes "^3355FFYou have lined the";
					mes "outside of the center";
					mes "with some Oridecon.^000000";
					next;
					break;
				case 3:
					mes "^3355FFYou have lined the";
					mes "outside of the center";
					mes "with some Stones.^000000";
					next;
					break;
			}
			switch( select("Elunium:Oridecon:Stone") )
			{
				case 1:
					mes "^3355FFYou covered the";
					mes "rest of the materials";
					mes "with some Elunium.^000000";
					next;
					break;
				case 2:
					mes "^3355FFYou covered the";
					mes "rest of the materials";
					mes "with some Oridecon.^000000";
					set .@nice,.@nice + 10;
					next;
					break;
				case 3:
					mes "^3355FFYou covered the";
					mes "rest of the materials";
					mes "with some Stones.^000000";
					next;
					break;
			}
			mes "^3355FFNow you need to arrange";
			mes "the enchanted Gemstones";
			mes "accordingly. You can identify";
			mes "their Magic properties by";
			mes "their casting effect.^000000";
			next;
			while( 1 )
			{
				if( .@roof0 > 7 )
				{
					break;
				}
				else
				{
					switch( rand(1,3) )
					{
						case 1:
							specialeffect EF_BEGINSPELL2;
							mes "^3355FFThe Gemstones must";
							mes "be arranged in the correct";
							mes "order according to their";
							mes "magic properties and power.^000000";
							next;
							switch( select("Red Gemstone:Yellow Gemstone:Blue Gemstone") )
							{
								case 1:
									mes "^3355FFYou placed the Red Gemstone.";
									mes "However, the Guardian Stone";
									mes "Repair System failed because";
									mes "of a magic power conflict.^000000";
									close;
								case 2:
									mes "^3355FFYou placed the Yellow Gemstone.";
									mes "However, the Guardian Stone";
									mes "Repair System failed because";
									mes "of a magic power conflict.^000000";
									close;
								case 3:
									mes "^3355FFYou placed the Blue Gemstone.^000000";
									set .@nice,.@nice + 10;
									set .@roof0,.@roof0 + 1;
									specialeffect EF_STEAL;
									next;
									break;
							}
							break;
						case 2:
							specialeffect EF_VOLCANO;
							mes "^3355FFThe Gemstones must";
							mes "be arranged in the correct";
							mes "order according to their";
							mes "magic properties and power.^000000";
							next;
							switch(select("Red Gemstone:Yellow Gemstone:Blue Gemstone"))
							{
								case 1:
									mes "^3355FFYou placed the Red Gemstone.^000000";
									set .@nice,.@nice + 10;
									set .@roof0,.@roof0 + 1;
									specialeffect EF_STEAL;
									next;
									break;
								case 2:
									mes "^3355FFYou placed the Yellow Gemstone.";
									mes "However, the Guardian Stone";
									mes "Repair System failed because";
									mes "of a magic power conflict.^000000";
									close;
								case 3:
									mes "^3355FFYou placed the Blue Gemstone.";
									mes "However, the Guardian Stone";
									mes "Repair System failed because";
									mes "of a magic power conflict.^000000";
									close;
							}
							break;
						case 3:
							specialeffect EF_BEGINSPELL4;
							mes "^3355FFThe Gemstones must";
							mes "be arranged in the correct";
							mes "order according to their";
							mes "magic properties and power.^000000";
							next;
							switch( select("Red Gemstone:Yellow Gemstone:Blue Gemstone") )
							{
								case 1:
									mes "^3355FFYou placed the Red Gemstone.";
									mes "However, the Guardian Stone";
									mes "Repair System failed because";
									mes "of a magic power conflict.^000000";
									close;
								case 2:
									mes "^3355FFYou placed the Yellow Gemstone.^000000";
									set .@nice,.@nice + 10;
									set .@roof0,.@roof0 + 1;
									specialeffect EF_STEAL;
									next;
									break;
								case 3:
									mes "^3355FFYou placed the Blue Gemstone.";
									mes "However, the Guardian Stone";
									mes "Repair System failed because";
									mes "of a magic power conflict.^000000";
									close;
							}
					}
				}
			}

			if( .@nice > 90 )
			{
				mes "^3355FFThe Gemstones have been";
				mes "arranged, and the Guardian";
				mes "Stone is successfully repaired.^000000";
				close2;
				specialeffect EF_ICECRASH;
				donpcevent "MainRepairTestB::OnRepairDone";
				end;
			}
			else
			{
				mes "^3355FFAfter all of that work...";
				mes "It looks like you failed";
				mes "to fix the Guardian Stone,";
				mes "and lost some materials.^000000";
				close;
			}
	}
	end;
}

quiz_02,237,365,0	script	Barricade Repair Test::RepairTestA	722,{
	mes "[ ^FFA500Barricade Test^000000 ]";
	mes "Mejor Puntaje Reparador:";
	if( $RepairTestA_ID )
	{
		mes "- Jugador : ^0000FF" + $RepairTestA_Name$ + "^000000.";
		mes "- Tiempo : ^0000FF" + $RepairTestA_Time + "^000000 ms.";
	}
	else
	{
		mes "- Jugador : ^0000FF(ninguno)^000000.";
		mes "- Tiempo : ^0000FF(no establecido)^000000 ms.";
	}
	
	if( select("Intentar Prueba:Salir") == 2 )
		close;

	if( getvariableofnpc(.Char_ID,"MainRepairTestA") )
	{
		mes "La sala de pruebas está en uso.";
		close;
	}

	set getvariableofnpc(.Char_ID,"MainRepairTestA"),getcharid(0);
	set getvariableofnpc(.Char_Name$,"MainRepairTestA"),strcharinfo(0);
	set getvariableofnpc(.Test_Step,"MainRepairTestA"),0;

	initnpctimer "MainRepairTestA";

	warp "quiz_02",236,344;
	end;
}

quiz_02,236,346,0	script	MainRepairTestA	-1,13,13,{
	end;

OnTimer10000:
	if( .Test_Step != 0 )
		end;

	stopnpctimer;
	set .Char_ID, 0;
	end; // Maybe Lag

OnTouch:
	if( .Char_ID != getcharid(0) )
	{
		warp "SavePoint",0,0; // Kick Player
		end;
	}
	if( .Test_Step != 0 )
		end; // Touching but already inside? Maybe hiding/unhiding

	set .Test_Step, 1; // Announcing
	sleep 2000;
	areaannounce "quiz_02",224,334,247,357,"Preparate!! La prueba iniciará en 5 segundos.",8;
	sleep 2000;
	areaannounce "quiz_02",224,334,247,357,"3 segundos...",8;
	sleep 1000;
	areaannounce "quiz_02",224,334,247,357,"2 segundos...",8;
	sleep 1000;
	areaannounce "quiz_02",224,334,247,357,"1 segundo...",8;
	sleep 1000;
	areaannounce "quiz_02",224,334,247,357,"Adelante!! Repara la Barricada!!",8;
	set .Test_Init, gettimetick(0);
	set .Test_Step, 2; // Repairing!!
	initnpctimer;
	end;

OnTimer30000:
	areaannounce "quiz_02",224,334,247,357,"60 segundos restantes para reparar la Barricada...",8;
	end;

OnTimer60000:
	areaannounce "quiz_02",224,334,247,357,"30 segundos restantes para reparar la Barricada...",8;
	end;

OnTimer80000:
	areaannounce "quiz_02",224,334,247,357,"10 segundos restantes para reparar la Barricada...",8;
	end;

OnTimer90000:
	stopnpctimer;
	set .Test_Step, 3;
	areaannounce "quiz_02",224,334,247,357,"Tiempo Fuera!! No superaste la prueba!!",8;
	sleep 2000;
	areawarp "quiz_02",224,334,247,357,"quiz_02",237,370;
	set .Test_Step, 0;
	set .Char_ID, 0;
	end;

OnRepairDone:
	stopnpctimer;
	if( .Test_Step != 2 )
		end; // Time Out

	set .Test_Completed, gettimetick(0) - .Test_Init;
	areaannounce "quiz_02",224,334,247,357,"Prueba superada en " + .Test_Completed + " milisegundos!!",8;
	if( .Test_Completed < $RepairTestA_Time || $RepairTestA_Time == 0 )
	{
		set $RepairTestA_Time, .Test_Completed;
		set $RepairTestA_Name$, .Char_Name$;
		set $RepairTestA_ID, .Char_ID;
	}
	
	set .Test_Step, 3;
	sleep 2000;
	areawarp "quiz_02",224,334,247,357,"quiz_02",237,370;
	set .Test_Step, 0;
	set .Char_ID, 0;
	end;
}

quiz_02,236,346,4	script	Control Device::DevRepairTestA	858,{
	if( getvariableofnpc(.Test_Step,"MainRepairTestA") != 2 )
		end;
	if( getvariableofnpc(.Char_ID,"MainRepairTestA") != getcharid(0) )
		end;

	mes "^3355FFDemolished Fortress";
	mes "Gates can be repaired,";
	mes "but you will need to gather";
	mes "the following materials.^000000";
	next;
	mes "^4D4DFF10 Steel^000000,";
	mes "^4D4DFF30 Trunks^000000,";
	mes "^4D4DFF5 Oridecon^000000, and";
	mes "^4D4DFF10 Emveretarcon^000000.";
	next;
	select("Continue");
	mes "^3355FFYou will need Trunks to";
	mes "repair the support frame,";
	mes "Oridecon to enhance the";
	mes "gate's endurance, and";
	mes "Emveretarcon to basically";
	mes "hold everything together.^000000";
	next;
	set .@ro_of01,rand(10,15);
	while( 1 )
	{
		if( .@ro_of02 == .@ro_of01 )
		{
			break;
		}
		else
		{
			switch( rand(1,4) )
			{
				case 1:
					mes "^3355FFThe support frame";
					mes "is badly damaged:";
					mes "fixing this part";
					mes "is a top priority.^000000";
					next;
					switch( select("Trunk:Steel:Emveretarcon:Oridecon") )
					{
						case 1:
							mes "^3355FFThe frame has been";
							mes "reinforced with wood.^000000";
							set .@rp_temp,.@rp_temp + 1;
							set .@ro_of02,.@ro_of02 + 1;
							specialeffect2 EF_REPAIRWEAPON;
							next;
							break;
						case 2:
							mes "^3355FFYou tried using steel,";
							mes "but it's not working very";
							mes "well. You'll have to try";
							mes "something else.^000000";
							close;
						case 3:
							mes "^3355FFYou tried using emveretarcon";
							mes "to reinforce the gate, but it's";
							mes "not working well at all.";
							mes "You'll have to start over.^000000";
							close;
						case 4:
							mes "^3355FFYou tried using oridecon,";
							mes "but it's not working very";
							mes "well. You'll have to try";
							mes "something else.^000000";
							close;
					}
					break;
				case 2:
					mes "^3355FFIt looks like the gate's";
					mes "overall endurance needs to";
					mes "be reinforced with something.^000000";
					next;
					switch( select("Trunk:Steel:Emveretarcon:Oridecon") )
					{
						case 1:
							mes "^3355FFYou tried using wood";
							mes "to reinforce the gate.^000000";
							set .@ro_of02,.@ro_of02 + 1;
							next;
							break;
						case 2:
							mes "^3355FFYou tried using steel";
							mes "to reinforce the gate, but";
							mes "it's not working well at all.";
							mes "You'll have to start over.^000000";
							close;
						case 3:
							mes "^3355FFYou tried using emveretarcon";
							mes "to reinforce the gate, but it's";
							mes "not working well at all.";
							mes "You'll have to start over.^000000";
							close;
						case 4:
							mes "^3355FFYou hammered the";
							mes "oridecon: it looks";
							mes "like this will work.^000000";
							set .@rp_temp,.@rp_temp + 1;
							set .@ro_of02,.@ro_of02 + 1;
							specialeffect2 EF_REPAIRWEAPON;
							next;
							break;
					}
					break;
				case 3:
					mes "^3355FFThe damage to the gate";
					mes "has caused all these";
					mes "cracks. You'll have to";
					mes "weld them solid somehow.^000000";
					next;
					switch( select("Trunk:Steel:Emveretarcon:Oridecon") )
					{
						case 1:
							mes "^3355FFYou tried using wood to fix";
							mes "this problem, but it seems";
							mes "to have made it worse.";
							mes "You'll have to start all over.^000000";
							close;
						case 2:
							mes "^3355FFYou used steel to weld";
							mes "all the cracks: the gate is";
							mes "is starting to look more solid.^000000";
							set .@rp_temp,.@rp_temp + 1;
							set .@ro_of02,.@ro_of02 + 1;
							specialeffect2 EF_REPAIRWEAPON;
							next;
							break;
						case 3:
							mes "^3355FFYou tried using emveretarcon";
							mes "to reinforce the gate, but it's";
							mes "not working well at all.";
							mes "You'll have to start over.^000000";
							close;
						case 4:
							mes "^3355FFYou tried using oridecon,";
							mes "but it's not working very";
							mes "well. You'll have to try";
							mes "something else.^000000";
							close;
					}
					break;
				case 4:
					mes "^3355FFNow you need to make";
					mes "sure that the gate is held";
					mes "together pretty solidly.^000000";
					next;
					switch( select("Trunk:Steel:Emveretarcon:Oridecon") )
					{
						case 1:
							mes "^3355FFYou tried using wood to fix";
							mes "this problem, but it seems";
							mes "to have made it worse.";
							mes "You'll have to start all over.^000000";
							close;
						case 2:
							mes "^3355FFYou tried using steel,";
							mes "but it's not working very";
							mes "well. You'll have to try";
							mes "something else.^000000";
							close;
						case 3:
							mes "^3355FFYou successfully used";
							mes "the emveretarcon to repair";
							mes "much of the gate's damage.^000000";
							set .@rp_temp,.@rp_temp + 1;
							set .@ro_of02,.@ro_of02 + 1;
							specialeffect2 EF_REPAIRWEAPON;
							next;
							break;
						case 4:
							mes "^3355FFYou tried using oridecon,";
							mes "but it's not working very";
							mes "well. You'll have to try";
							mes "something else.^000000";
							close;
					}
			}
		}
	}

	mes "^3355FFWell, it looks like";
	mes "you're just about done";
	mes "with repairing the gate.^000000";
	next;
	if( .@rp_temp == .@ro_of01 )
	{
		mes "^3355FFThe Fortress Gate has";
		mes "been successfully repaired!^000000";
		close2;
		donpcevent "MainRepairTestA::OnRepairDone";
		end;
	}
	else
	{
		mes "^3355FFThe wall has been breached,";
		mes "and the attempt to repair the";
		mes "Fortress Gate has failed.";
		mes "You lost some of your";
		mes "repair resources...^000000";
		close;
	}
}

// Emperium Breaker - Games
// ========================================================================

quiz_02,45,389,4	script	Game Master::EmpeManager	105,{
	mes "[ ^FFA500Game Master^000000 ]";
	mes "Bienvenido a la Sala de práctica para romper Emperium.";
	mes "Hay 2 cuartos disponibles, busca alguno desocupado si deseas probar suerte.";
	close;
}

quiz_02,33,365,0	script	EmpeTest Full Buff::EmpeTestA	722,{
	mes "[ ^FFA500Empe Test^000000 ]";
	mes "Mejor Puntaje EmpeBreaker:";
	if( $EmpeTestA_ID )
	{
		mes "- Jugador : ^0000FF" + $EmpeTestA_Name$ + "^000000.";
		mes "- Tiempo : ^0000FF" + $EmpeTestA_Time + "^000000 ms.";
	}
	else
	{
		mes "- Jugador : ^0000FF(ninguno)^000000.";
		mes "- Tiempo : ^0000FF(no establecido)^000000 ms.";
	}

	if( select("Intentar Prueba:Salir") == 2 )
		close;

	if( getvariableofnpc(.Char_ID,"MainEmpeTestA") )
	{
		mes "La sala de pruebas está en uso.";
		close;
	}

	set getvariableofnpc(.Char_ID,"MainEmpeTestA"),getcharid(0);
	set getvariableofnpc(.Char_Name$,"MainEmpeTestA"),strcharinfo(0);
	set getvariableofnpc(.Test_Step,"MainEmpeTestA"),0;

	initnpctimer "MainEmpeTestA";

	warp "quiz_02",32,342;
	end;
}

quiz_02,32,346,0	script	MainEmpeTestA	-1,13,13,{
	end;

OnTimer10000:
	if( .Test_Step != 0 )
		end;

	stopnpctimer;
	set .Char_ID, 0;
	end; // Maybe Lag

OnTouch:
	if( .Char_ID != getcharid(0) )
	{
		warp "SavePoint",0,0; // Kick Player
		end;
	}
	if( .Test_Step != 0 )
		end; // Touching but already inside? Maybe hiding/unhiding

	set .Test_Step, 1; // Announcing
	sleep 2000;
	areaannounce "quiz_02",20,334,43,357,"Preparate!! La prueba iniciará en 5 segundos.",8;
	sleep 2000;
	areaannounce "quiz_02",20,334,43,357,"3 segundos...",8;
	sleep 1000;
	areaannounce "quiz_02",20,334,43,357,"2 segundos...",8;
	sleep 1000;
	areaannounce "quiz_02",20,334,43,357,"1 segundo...",8;
	sleep 1000;
	areaannounce "quiz_02",20,334,43,357,"Adelante!! Destruye el Emperium!!",8;
	mobevent "quiz_02",32,346,"Emperium",1288,0,1,0,0,0,0,0,1,0,0,0,0,0,"MainEmpeTestA::OnEmpeBreak";
	set .Test_Init, gettimetick(0);
	set .Test_Step, 2; // Breaking!!
	initnpctimer;
	end;

OnTimer30000:
	areaannounce "quiz_02",20,334,43,357,"60 segundos restantes para romper el Emperium...",8;
	end;

OnTimer60000:
	areaannounce "quiz_02",20,334,43,357,"30 segundos restantes para romper el Emperium...",8;
	end;

OnTimer80000:
	areaannounce "quiz_02",20,334,43,357,"10 segundos restantes para romper el Emperium...",8;
	end;

OnTimer90000:
	stopnpctimer;
	killmonster "quiz_02","MainEmpeTestA::OnEmpeBreak";
	areaannounce "quiz_02",20,334,43,357,"Tiempo Fuera!! No superaste la prueba!!",8;
	sleep 2000;
	areawarp "quiz_02",20,334,43,357,"quiz_02",33,370;
	set .Test_Step, 0;
	set .Char_ID, 0;
	end;

OnEmpeBreak:
	stopnpctimer;
	set .Test_Completed, gettimetick(0) - .Test_Init;
	areaannounce "quiz_02",20,334,43,357,"Prueba superada en " + .Test_Completed + " milisegundos!!",8;
	if( .Test_Completed < $EmpeTestA_Time || $EmpeTestA_Time == 0 )
	{
		set $EmpeTestA_Time, .Test_Completed;
		set $EmpeTestA_Name$, .Char_Name$;
		set $EmpeTestA_ID, .Char_ID;
	}

	sleep 2000;
	areawarp "quiz_02",20,334,43,357,"quiz_02",33,370;
	set .Test_Step, 0;
	set .Char_ID, 0;
	end;
}

quiz_02,58,365,0	script	EmpeTest Full DeBuff::EmpeTestB	722,{
	mes "[ ^FFA500Empe Test^000000 ]";
	mes "Mejor Puntaje EmpeBreaker:";
	if( $EmpeTestB_ID )
	{
		mes "- Jugador : ^0000FF" + $EmpeTestB_Name$ + "^000000.";
		mes "- Tiempo : ^0000FF" + $EmpeTestB_Time + "^000000 ms.";
	}
	else
	{
		mes "- Jugador : ^0000FF(ninguno)^000000.";
		mes "- Tiempo : ^0000FF(no establecido)^000000 ms.";
	}

	if( select("Intentar Prueba:Salir") == 2 )
		close;

	if( getvariableofnpc(.Char_ID,"MainEmpeTestB") )
	{
		mes "La sala de pruebas está en uso.";
		close;
	}

	set getvariableofnpc(.Char_ID,"MainEmpeTestB"),getcharid(0);
	set getvariableofnpc(.Char_Name$,"MainEmpeTestB"),strcharinfo(0);
	set getvariableofnpc(.Test_Step,"MainEmpeTestB"),0;

	initnpctimer "MainEmpeTestB";
	sc_end SC_ALL;

	warp "quiz_02",60,342;
	end;
}

quiz_02,60,346,0	script	MainEmpeTestB	-1,13,13,{
	end;

OnTimer10000:
	if( .Test_Step != 0 )
		end;

	stopnpctimer;
	set .Char_ID, 0;
	end; // Maybe Lag

OnTouch:
	if( .Char_ID != getcharid(0) )
	{
		warp "SavePoint",0,0; // Kick Player
		end;
	}
	if( .Test_Step != 0 )
		end; // Touching but already inside? Maybe hiding/unhiding

	set .Test_Step, 1; // Announcing
	sleep 2000;
	areaannounce "quiz_02",48,334,71,357,"Preparate!! La prueba iniciará en 5 segundos.",8;
	sleep 2000;
	areaannounce "quiz_02",48,334,71,357,"3 segundos...",8;
	sleep 1000;
	areaannounce "quiz_02",48,334,71,357,"2 segundos...",8;
	sleep 1000;
	areaannounce "quiz_02",48,334,71,357,"1 segundo...",8;
	sleep 1000;
	areaannounce "quiz_02",48,334,71,357,"Adelante!! Destruye el Emperium!!",8;
	mobevent "quiz_02",60,346,"Emperium",1288,0,1,0,0,0,0,0,1,0,0,0,0,0,"MainEmpeTestB::OnEmpeBreak";
	set .Test_Init, gettimetick(0);
	set .Test_Step, 2; // Breaking!!
	initnpctimer;
	end;

OnTimer30000:
	areaannounce "quiz_02",48,334,71,357,"60 segundos restantes para romper el Emperium...",8;
	end;

OnTimer60000:
	areaannounce "quiz_02",48,334,71,357,"30 segundos restantes para romper el Emperium...",8;
	end;

OnTimer80000:
	areaannounce "quiz_02",48,334,71,357,"10 segundos restantes para romper el Emperium...",8;
	end;

OnTimer90000:
	stopnpctimer;
	killmonster "quiz_02","MainEmpeTestB::OnEmpeBreak";
	areaannounce "quiz_02",48,334,71,357,"Tiempo Fuera!! No superaste la prueba!!",8;
	sleep 2000;
	areawarp "quiz_02",48,334,71,357,"quiz_02",58,370;
	set .Test_Step, 0;
	set .Char_ID, 0;
	end;

OnEmpeBreak:
	stopnpctimer;
	set .Test_Completed, gettimetick(0) - .Test_Init;
	areaannounce "quiz_02",48,334,71,357,"Prueba superada en " + .Test_Completed + " milisegundos!!",8;
	if( .Test_Completed < $EmpeTestB_Time || $EmpeTestB_Time == 0 )
	{
		set $EmpeTestB_Time, .Test_Completed;
		set $EmpeTestB_Name$, .Char_Name$;
		set $EmpeTestB_ID, .Char_ID;
	}

	sleep 2000;
	areawarp "quiz_02",48,334,71,357,"quiz_02",58,370;
	set .Test_Step, 0;
	set .Char_ID, 0;
	end;
}

// Simon Says - Games
// ========================================================================

quiz_02,338,87,4	script	Game Master::SimonManager	98,{
	if( .Simon == 0 )
	{
		mes "[ ^FFA500Game Master^000000 ]";
		mes "Bienvenido a ^0000FFSimón Dice^000000, Jugarás?.";
		mes "El costo por juego es de ^FF000025.000 zeny^000000.";
		mes "Cuando subas a partir del nivel 10, empezarás a recibir premios";

		next;
		if( select("Si, estoy listo para jugar:No Gracias...") == 2 )
		{
			mes "[ ^FFA500Game Master^000000 ]";
			mes "Cuando estés preparado para el reto avisame.";
			close;
		}
		
		if( isPremium() == 0 )
		{
			mes "[ ^FFA500Game Master^000000 ]";
			mes "Las salas de Juegos solamente son para Cuentas Premium.";
			close;
		}

		if( Zeny < 25000 )
		{
			mes "[ ^FFA500Game Master^000000 ]";
			mes "Parece que no tienes suficiente dinero contigo.";
			close;
		}

		if( .Simon != 0 )
		{
			mes "[ ^FFA500Game Master^000000 ]";
			mes "Parece que alguien va a jugar primero que tu, espera un poco a que terminen.";
			close;
		}

		set Zeny, Zeny - 25000;
		set .Simon, 1;
		set .CharID, getcharid(3);
		set .Pos, 0;
		set .Max, 1;
		set .CharName$, strcharinfo(0);
		deletearray .Secuence[0],127;
		warp "quiz_02",338,73; // Center of the Event
		sleep 2000;
		areaannounce "quiz_02",328,64,347,83,"Game Master : Pon atencion a los porings, " + .CharName$ + "!",8;
		sleep 1000;
		initnpctimer;
	}
	else
	{
		if( .CharID == getcharid(3) )
		{
			mes "[ ^FFA500Game Master^000000 ]";
			mes "Hey!!! Yo no soy poring, atento al juego y no te distraigas...";
			close;
		}
		else
		{
			mes "[ ^FFA500Game Master^000000 ]";
			mes "Disculpa, alguien está jugando en este momento y no puedo distraerme...";
			close;
		}
	}
	end;

OnInit: setarray $@GameRewards[0],   909,  909,  909,  909,  909,  909,
				     501,  502,  503,  504,  505,  547,  645,  656,  657,
				   12016,12118,12119,12120,12121,
				     756,  757,
				     523,12020,12114,12115,12116,12117,
				     717,  716,  715, 7321,
				    7135, 7136, 7137, 7138, 7139,
				    1025,  678, 1065, 1771,  514;
	end;

OnTimer1000:
	if( .Simon == 1 )
	{ // Demo
		if( .Pos < .Max )
		{
			if( .Secuence[.Pos] < 1 || .Secuence[.Pos] > 8 )
				set .Secuence[.Pos], rand(1,8);
			
			donpcevent "SimonPoring" + .Secuence[.Pos] + "::OnEffect";
			set .Pos, .Pos + 1;
		}
		else
		{
			set .Time, .Max + 4;
			for( set .@i, 1; .@i < 9; set .@i, .@i + 1 )
				donpcevent "SimonPoring" + .@i + "::OnBegin";
			
			set .Pos, 0;
			set .Simon, 2;
			areaannounce "quiz_02",328,64,347,83,"Game Master : Tu turno, tienes " + .Time + " segundos!",8;
		}
	}
	else
	{ // Playing
		set .Time, .Time - 1;
		if( .Time <= 0 )
		{
			for( set .@i, 1; .@i < 9; set .@i, .@i + 1 )
				donpcevent "SimonPoring" + .@i + "::OnTime";

			set .Simon, 0;
			areaannounce "quiz_02",328,64,347,83,"Game Master : Finalizó el Tiempo, hiciste " + (.Max - 1) + " niveles...",8;
		}
	}

	if( .Simon > 0 ) initnpctimer;
	end;

OnNewGame:
	stopnpctimer;
	set .Simon, 1;
	set .Pos, 0;
	set .Max, .Max + 1;
	if( .Max < 125 )
	{
		switch( rand(5) )
		{
			case 0:	areaannounce "quiz_02",328,64,347,83,"Game Master : Perfecto, hiciste bien la ronda!",8; break;
			case 1: areaannounce "quiz_02",328,64,347,83,"Game Master : Genial, ahora más dificil",8; break;
			case 2: areaannounce "quiz_02",328,64,347,83,"Game Master : Parece que eres bueno, sigamos",8; break;
			case 3: areaannounce "quiz_02",328,64,347,83,"Game Master : Vaya!!... sorprendente",8; break;
			case 4: areaannounce "quiz_02",328,64,347,83,"Game Master : Wow... Concentrate vas bien",8; break;
		}

		for( set .@i, 1; .@i < 9; set .@i, .@i + 1 )
			donpcevent "SimonPoring" + .@i + "::OnGood";

		sleep 3000;
		areaannounce "quiz_02",328,64,347,83,"Game Master : Atención " + .CharName$ + ", ... listo?",8;
		sleep 3000;
		areaannounce "quiz_02",328,64,347,83,"Game Master : Nivel " + .Max + "!",8;
		sleep 2000;
		initnpctimer;
	}
	else
	{
		areaannounce "quiz_02",328,64,347,83,"Game Master : INCREIBLE!!! lograste 125 secuencias!",8;
		sleep 3000;
		areaannounce "quiz_02",328,64,347,83,"Game Master : Mis porings necesitan descanzar, pero te felicito",8;
		set .Simon, 0; // Fin del Juego
	}

	end;

OnFail:
	stopnpctimer;
	set .Simon, 1;
	for( set .@i, 1; .@i < 9; set .@i, .@i + 1 )
		donpcevent "SimonPoring" + .@i + "::OnFail";

	areaannounce "quiz_02",328,64,347,83,"Game Master : Oohh que lástima, fallaste.",8;
	sleep 3000;
	areaannounce "quiz_02",328,64,347,83,"Game Master : Lograste llegar al nivel " + (.Max - 1) + "!",8;
	sleep 3000;
	areaannounce "quiz_02",328,64,347,83,"Game Master : Vuelve a intentarlo cuando quieras.",8;
	set .Simon, 0;
	end;
}

quiz_02,332,79,5	script	Poring#1::SimonPoring1	909,{
	if( getvariableofnpc(.Simon,"SimonManager") == 2 && getcharid(3) == getvariableofnpc(.CharID,"SimonManager") )
	{
		if( getvariableofnpc(.Secuence[getvariableofnpc(.Pos,"SimonManager")],"SimonManager") == atoi(strnpcinfo(2)) )
		{
			specialeffect 363;
			set getvariableofnpc(.Pos,"SimonManager"), getvariableofnpc(.Pos,"SimonManager") + 1;
			if( getvariableofnpc(.Pos,"SimonManager") == getvariableofnpc(.Max,"SimonManager") )
			{ // Level Completed
				if( getvariableofnpc(.Max,"SimonManager") > 10 )
					getitem $@GameRewards[rand(getarraysize($@GameRewards))], 1;

				donpcevent "SimonManager::OnNewGame";
			}
		}
		else
			donpcevent "SimonManager::OnFail";
	}
	end;

OnEffect:
	specialeffect 363;
	end;

OnGood:
	emotion e_no1;
	end;

OnTime:
	emotion e_omg;
	end;

OnFail:
	emotion e_wah;
	end;

OnBegin:
	emotion e_go;
	end;
}

quiz_02,337,81,4	duplicate(SimonPoring1)	Poring#2::SimonPoring2	909
quiz_02,343,79,3	duplicate(SimonPoring1)	Poring#3::SimonPoring3	909
quiz_02,345,74,2	duplicate(SimonPoring1)	Poring#4::SimonPoring4	909
quiz_02,343,68,1	duplicate(SimonPoring1)	Poring#5::SimonPoring5	909
quiz_02,338,66,0	duplicate(SimonPoring1)	Poring#6::SimonPoring6	909
quiz_02,332,68,2	duplicate(SimonPoring1)	Poring#7::SimonPoring7	909
quiz_02,330,73,6	duplicate(SimonPoring1)	Poring#8::SimonPoring8	909

// Memory - Games
// ========================================================================

quiz_02,147,391,4	script	Game Master::MemoryManager	901,{
	if( .Status > 0 )
	{
		mes "[ ^FFA500Game Master^000000 ]";
		mes "Disculpa, ahora estoy ocupado atendiendo un juego, espera a que este termine.";
		close;
	}

	mes "[ ^FFA500Game Master^000000 ]";
	mes "Bienvenido a ^0000FFMemory Master^000000, Jugarás? El Costo es de ^FF000025.000 zeny^000000.";
	mes "Por cada ronda, si superas las 7 parejas empezarás a recibir items de premio.";
	next;
	if( select("Si, estoy listo para jugar:No Gracias...") == 2 )
	{
		mes "[ ^FFA500Game Master^000000 ]";
		mes "Cuando estés preparado para el reto avisame.";
		close;
	}

	if( isPremium() == 0 )
	{
		mes "[ ^FFA500Game Master^000000 ]";
		mes "Las salas de Juegos solamente son para Cuentas Premium.";
		close;
	}

	if( Zeny < 25000 )
	{
		mes "[ ^FFA500Game Master^000000 ]";
		mes "Parece que no tienes suficiente dinero contigo.";
		close;
	}

	if( .Status != 0 )
	{
		mes "[ ^FFA500Game Master^000000 ]";
		mes "Parece que alguien va a jugar primero que tu, espera un poco a que terminen.";
		close;
	}

	set Zeny, Zeny - 25000;
	set .Status, 1; // Game Status
	set .Score, 0; // Player Score
	set .Try, 5; // Lives Remaining
	set .Level, 0; // Levels Completed
	set .Char_Name$, strcharinfo(0);
	set .Char_ID, getcharid(3);
	warp "quiz_02",148,376; // Center of the Event
	sleep 2000;
	areaannounce "quiz_02",135,368,160,384,"Game Master : Preparate para iniciar el juego",8;
	sleep 2000;

OnNew:
	stopnpctimer;
	donpcevent "::OnShowMemory";
	set .Status, 1; // Game Status

	deletearray .@Emotions[0],127;
	setarray .@Emotions[0],2,2,4,4,8,8,9,9,15,15,16,16,17,17,18,18,20,20,21,21,22,22,23,23,26,26,27,27,28,28,29,29;

	// Randomize Array
	set .@Size, getarraysize(.@Emotions);
	deletearray .Gestos[0],127;
	set .@Head, .@Size;

	for( set .@i, 0; .@i < .@Size; set .@i, .@i + 1 )
	{
		set .@Pos, rand(.@Head);
		set .Gestos[.@i], .@Emotions[.@Pos];
		deletearray .@Emotions[.@Pos], 1;
		set .@Head, .@Head - 1;
	}

	set .Ge_1, -1;
	set .Level, .Level + 1;
	set .Try, .Try + 10;
	set .Couples, 0;
	areaannounce "quiz_02",135,368,160,384,"Game Master : Nivel " + .Level + ", mira bien los gestos!",8;
	sleep 2000;
	
	// Demostration View
	deletearray .@Temp[0],127;
	setarray .@Temp[0],0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31;

	set .@Size, getarraysize(.@Temp);
	deletearray .@Demo[0],127;
	set .@Head, .@Size;

	for( set .@i, 0; .@i < .@Size; set .@i, .@i + 1 )
	{
		set .@Pos, rand(.@Head);
		set .@Demo[.@i], .@Temp[.@Pos];
		deletearray .@Temp[.@Pos], 1;
		set .@Head, .@Head - 1;
	}

	for( set .@i, 0; .@i < 32; set .@i, .@i + 2 )
	{
		donpcevent "Memory" + .@Demo[.@i] + "::OnDoEmoti";
		donpcevent "Memory" + .@Demo[.@i + 1] + "::OnDoEmoti";
		sleep 200;
	}

	sleep 1600;
	areaannounce "quiz_02",135,368,160,384,"Game Master : Tienes " + .Try + " intentos. Llevas " + .Score + " puntos.",8;
	sleep 2000;
	areaannounce "quiz_02",135,368,160,384,"Game Master : Iniciamos, encuentra parejas de Gestos. 3 minutos restantes.",8;
	set .Status, 2;
	initnpctimer;
	end;

OnFine:
	switch( rand(4) )
	{
		case 0: areaannounce "quiz_02",135,368,160,384,"Game Master : Bien...",8; break;
		case 1: areaannounce "quiz_02",135,368,160,384,"Game Master : Genial...",8; break;
		case 2: areaannounce "quiz_02",135,368,160,384,"Game Master : Vamos lo lograrás!",8; break;
		case 3: areaannounce "quiz_02",135,368,160,384,"Game Master : Eres bueno",8; break;
	}
	end;

OnBad:
	switch( rand(4) )
	{
		case 0: areaannounce "quiz_02",135,368,160,384,"Game Master : Ouch (" + .Try + " vidas)",8; break;
		case 1: areaannounce "quiz_02",135,368,160,384,"Game Master : Error! (" + .Try + " vidas)",8; break;
		case 2: areaannounce "quiz_02",135,368,160,384,"Game Master : Que mal! (" + .Try + " vidas)",8; break;
		case 3: areaannounce "quiz_02",135,368,160,384,"Game Master : Mala memoria (" + .Try + " vidas)",8; break;
	}
	end;
	
OnEnd:
	stopnpctimer;
	donpcevent "::OnHideMemory";
	areaannounce "quiz_02",135,368,160,384,"Game Master : Se te acabaron los intentos. Fin del Juego.",8;
	set .Status, 0;
	end;

OnTimer180000:
	stopnpctimer;
	donpcevent "::OnHideMemory";
	areaannounce "quiz_02",135,368,160,384,"Game Master : Se acabó el Tiempo. Fin del Juego.",8;
	set .Status, 0;
	end;
}

quiz_02,137,370,4	script	Vamp#0::Memory0	799,{
	if( getvariableofnpc(.Status,"MemoryManager") < 2 || getvariableofnpc(.Char_ID,"MemoryManager") != getcharid(3) )
		end;
	
	set @Ge_v, atoi(strnpcinfo(2));
	emotion getvariableofnpc(.Gestos[@Ge_v],"MemoryManager");
	if( getvariableofnpc(.Status,"MemoryManager") == 2 )
	{ // Fist Touch
		set getvariableofnpc(.Ge_1,"MemoryManager"), @Ge_v;
		set getvariableofnpc(.Status,"MemoryManager"), 3;
	}
	else if( @Ge_v != getvariableofnpc(.Ge_1,"MemoryManager") )
	{ // Second Touch
		set @Ge_1, getvariableofnpc(.Ge_1,"MemoryManager");
		if( getvariableofnpc(.Gestos[@Ge_1],"MemoryManager") == getvariableofnpc(.Gestos[@Ge_v],"MemoryManager") )
		{ // Good Couple
			set getvariableofnpc(.Score,"MemoryManager"), getvariableofnpc(.Score,"MemoryManager") + 1; // Couples Founds
			set getvariableofnpc(.Couples,"MemoryManager"), getvariableofnpc(.Couples,"MemoryManager") + 1;

			if( getvariableofnpc(.Couples,"MemoryManager") > 7 )
				getitem $@GameRewards[rand(getarraysize($@GameRewards))], 1;

			set getvariableofnpc(.Status,"MemoryManager"), 2; // Back to first check

			donpcevent "Memory" + @Ge_1 + "::OnHideMemory";
			donpcevent "Memory" + @Ge_v + "::OnHideMemory";
			
			set getvariableofnpc(.Ge_1,"MemoryManager"), -1;

			if( getvariableofnpc(.Couples,"MemoryManager") > 15 )
				donpcevent "MemoryManager::OnNew";
			else
				donpcevent "MemoryManager::OnFine";
		}
		else
		{ // Bad Couple
			set getvariableofnpc(.Status,"MemoryManager"), 2; // Back to first check
			set getvariableofnpc(.Ge_1,"MemoryManager"), -1;
			set getvariableofnpc(.Try,"MemoryManager"), getvariableofnpc(.Try,"MemoryManager") - 1;
			if( getvariableofnpc(.Try,"MemoryManager") < 1 )
				donpcevent "MemoryManager::OnEnd";
			else
				donpcevent "MemoryManager::OnBad";
		}
	}
	end;

OnDoEmoti:	emotion getvariableofnpc(.Gestos[atoi(strnpcinfo(2))],"MemoryManager"); end;
OnHideMemory:	disablenpc "Memory" + atoi(strnpcinfo(2)) + ""; end;
OnShowMemory:	enablenpc "Memory" + atoi(strnpcinfo(2)) + ""; end;
}

quiz_02,140,370,4	duplicate(Memory0)	Vamp#1::Memory1	799
quiz_02,143,370,4	duplicate(Memory0)	Vamp#2::Memory2	799
quiz_02,146,370,4	duplicate(Memory0)	Vamp#3::Memory3	799
quiz_02,149,370,4	duplicate(Memory0)	Vamp#4::Memory4	799
quiz_02,152,370,4	duplicate(Memory0)	Vamp#5::Memory5	799
quiz_02,155,370,4	duplicate(Memory0)	Vamp#6::Memory6	799
quiz_02,158,370,4	duplicate(Memory0)	Vamp#7::Memory7	799

quiz_02,137,374,4	duplicate(Memory0)	Vamp#8::Memory8	799
quiz_02,140,374,4	duplicate(Memory0)	Vamp#9::Memory9	799
quiz_02,143,374,4	duplicate(Memory0)	Vamp#10::Memory10	799
quiz_02,146,374,4	duplicate(Memory0)	Vamp#11::Memory11	799
quiz_02,149,374,4	duplicate(Memory0)	Vamp#12::Memory12	799
quiz_02,152,374,4	duplicate(Memory0)	Vamp#13::Memory13	799
quiz_02,155,374,4	duplicate(Memory0)	Vamp#14::Memory14	799
quiz_02,158,374,4	duplicate(Memory0)	Vamp#15::Memory15	799

quiz_02,137,378,4	duplicate(Memory0)	Vamp#16::Memory16	799
quiz_02,140,378,4	duplicate(Memory0)	Vamp#17::Memory17	799
quiz_02,143,378,4	duplicate(Memory0)	Vamp#18::Memory18	799
quiz_02,146,378,4	duplicate(Memory0)	Vamp#19::Memory19	799
quiz_02,149,378,4	duplicate(Memory0)	Vamp#20::Memory20	799
quiz_02,152,378,4	duplicate(Memory0)	Vamp#21::Memory21	799
quiz_02,155,378,4	duplicate(Memory0)	Vamp#22::Memory22	799
quiz_02,158,378,4	duplicate(Memory0)	Vamp#23::Memory23	799
 
quiz_02,137,382,4	duplicate(Memory0)	Vamp#24::Memory24	799
quiz_02,140,382,4	duplicate(Memory0)	Vamp#25::Memory25	799
quiz_02,143,382,4	duplicate(Memory0)	Vamp#26::Memory26	799
quiz_02,146,382,4	duplicate(Memory0)	Vamp#27::Memory27	799
quiz_02,149,382,4	duplicate(Memory0)	Vamp#28::Memory28	799
quiz_02,152,382,4	duplicate(Memory0)	Vamp#29::Memory29	799
quiz_02,155,382,4	duplicate(Memory0)	Vamp#30::Memory30	799
quiz_02,158,382,4	duplicate(Memory0)	Vamp#31::Memory31	799

// Sounds Memory - Games
// ========================================================================

quiz_02,349,389,4	script	GameMaster::MusicManager	816,{
	if( .Status > 0 )
	{
		mes "[ ^FFA500Game Master^000000 ]";
		mes "Disculpa, ahora estoy ocupado atendiendo un juego, espera a que este termine.";
		close;
	}
	
	mes "[ ^FFA500Game Master^000000 ]";
	mes "Bienvenido a ^0000FFMusic Master^000000, Jugarás? El Costo es de ^FF000025.000 zeny^000000.";
	mes "Para aprender bien las notas, puedes prácticar si nadie juega.";
	next;
	if( select("Si, estoy listo para jugar:No Gracias...") == 2 )
	{
		mes "[ ^FFA500Game Master^000000 ]";
		mes "Cuando estés preparado para el reto avisame.";
		close;
	}

	if( isPremium() == 0 )
	{
		mes "[ ^FFA500Game Master^000000 ]";
		mes "Las salas de Juegos solamente son para Cuentas Premium.";
		close;
	}

	if( .Status != 0 )
	{
		mes "[ ^FFA500Game Master^000000 ]";
		mes "Parece que alguien va a jugar primero que tu, espera un poco a que terminen.";
		close;
	}

	if( Zeny < 25000 )
	{
		mes "[ ^FFA500Game Master^000000 ]";
		mes "Parece que no tienes suficiente dinero contigo.";
		close;
	}

	set Zeny, Zeny - 25000;	
	set .Status, 1;
	set .Max, 1;
	set .Pos, 0;
	set .Cicle, 1; // Song restart each 10 cicles
	set .Char_ID, getcharid(3);
	set .Char_Name$, strcharinfo(0);
	deletearray .Notes[0],127;
	warp "quiz_02",349,381;
	sleep 2000;
	areaannounce "quiz_02",342,375,357,386,"Game Master : Preparate para iniciar el juego",8;
	sleep 1000;
	areaannounce "quiz_02",342,375,357,386,"Game Master : Escucha las notas emitidas luego repitelas",8;
	sleep 1000;
	initnpctimer;
	end;

OnTimer1000:
	if( .Status == 1 )
	{ // Demo
		if( .Pos < .Cicle )
		{
			if( .Notes[.Pos] < 1 || .Notes[.Pos] > 8 )
				set .Notes[.Pos], rand(1,8);
			
			donpcevent "MusicNote" + .Notes[.Pos] + "::OnMusicPlay";
			set .Pos, .Pos + 1;
		}
		else
		{
			set .Time, .Cicle + 4;
			for( set .@i, 1; .@i < 9; set .@i, .@i + 1 )
				donpcevent "MusicNote" + .@i + "::OnMusicStart";

			set .Pos, 0;
			set .Status, 2;
			areaannounce "quiz_02",342,375,357,386,"Game Master : Tu turno, tienes " + .Time + " segundos!",8;
		}
	}
	else
	{ // Playing
		set .Time, .Time - 1;
		if( .Time <= 0 )
		{
			for( set .@i, 1; .@i < 9; set .@i, .@i + 1 )
				donpcevent "MusicNote" + .@i + "::OnMusicTime";

			set .Status, 0;
			areaannounce "quiz_02",342,375,357,386,"Game Master : Finalizó el Tiempo, hiciste " + (.Max - 1) + " niveles...",8;
		}
	}

	if( .Status > 0 ) initnpctimer;
	end;

OnNewGame:
	stopnpctimer;
	set .Status, 1;
	set .Pos, 0;
	set .Max, .Max + 1;
	
	if( .Max < 125 )
	{
		switch( rand(5) )
		{
			case 0:	areaannounce "quiz_02",342,375,357,386,"Game Master : Tienes buen oído, continuemos!",8; break;
			case 1: areaannounce "quiz_02",342,375,357,386,"Game Master : Corazón de Músico!",8; break;
			case 2: areaannounce "quiz_02",342,375,357,386,"Game Master : Genial, me sorprendes!",8; break;
			case 3: areaannounce "quiz_02",342,375,357,386,"Game Master : Increible, deberías ser Bardo!",8; break;
			case 4: areaannounce "quiz_02",342,375,357,386,"Game Master : Simplemente perfecto!",8; break;
		}

		for( set .@i, 1; .@i < 9; set .@i, .@i + 1 )
			donpcevent "MusicNote" + .@i + "::OnMusicGood";

		set .Cicle, .Cicle + 1;
		sleep 3000;

		if( .Cicle > 10 )
		{
			set .Cicle, 1;
			deletearray .Notes[0],127;
			areaannounce "quiz_02",342,375,357,386,"Game Master : Completaste las 10 Notas, ahora cambiemos de Melodía...",8;
			sleep 3000;
		}

		areaannounce "quiz_02",342,375,357,386,"Game Master : Atención " + .Char_Name$ + ", ... listo?",8;
		sleep 3000;
		areaannounce "quiz_02",342,375,357,386,"Game Master : Nivel " + .Max + "!",8;
		sleep 2000;
		areaannounce "quiz_02",342,375,357,386,"Game Master : Escuchas las notas y luego repitelas.",8;
		sleep 2000;
		initnpctimer;
	}
	else
	{
		areaannounce "quiz_02",342,375,357,386,"Game Master : INCREIBLE!!! lograste los 125 niveles!",8;
		sleep 3000;
		areaannounce "quiz_02",342,375,357,386,"Game Master : Mis ghostrings necesitan descanzar, pero te felicito",8;
		set .Status, 0; // Fin del Juego
	}
	end;

OnFail:
	areaannounce "quiz_02",342,375,357,386,"Game Master : Error!!! Repite la canción desde el inicio. Te quedan " + .Time + " segundos",8;
	for( set .@i, 1; .@i < 9; set .@i, .@i + 1 )
		donpcevent "MusicNote" + .@i + "::OnMusicFail";

	set .Pos, 0;
	end;

OnInit:
	setarray .Notes$[1],"sign_right","sign_center","sign_left","sign_down","sign_up","ef_coin1","ef_coin2","ef_coin3";
	end;
}

quiz_02,343,376,6	script	Ghostring#1::MusicNote1	950,{
	set .@NPC_ID, atoi(strnpcinfo(2));
	if( getvariableofnpc(.Status,"MusicManager") == 2 && getvariableofnpc(.Char_ID,"MusicManager") == getcharid(3) )
	{
		set .@Pos, getvariableofnpc(.Pos,"MusicManager");

		soundeffectall "effect\\" + getvariableofnpc(.Notes$[.@NPC_ID],"MusicManager") + ".wav",0,"quiz_02",342,375,357,386;
		if( getvariableofnpc(.Notes[.@Pos],"MusicManager") == .@NPC_ID )
		{
			set getvariableofnpc(.Pos,"MusicManager"),.@Pos + 1;
			if( getvariableofnpc(.Pos,"MusicManager") == getvariableofnpc(.Cicle,"MusicManager") )
			{
				if( getvariableofnpc(.Max,"MusicManager") > 5 )
					getitem $@GameRewards[rand(getarraysize($@GameRewards))], 1;

				donpcevent "MusicManager::OnNewGame";
			}
		}
		else
			donpcevent "MusicManager::OnFail";
	}
	else if( getvariableofnpc(.Status,"MusicManager") == 0 )
		soundeffectall "effect\\" + getvariableofnpc(.Notes$[.@NPC_ID],"MusicManager") + ".wav",0,"quiz_02",342,375,357,386;

	end;

OnMusicFail:	emotion e_wah; end;
OnMusicGood:	emotion e_no1; end;
OnMusicTime:	emotion e_omg; end;
OnMusicStart:	emotion e_go; end;

OnMusicPlay:
	set .@NPC_ID, atoi(strnpcinfo(2));
	soundeffectall "effect\\" + getvariableofnpc(.Notes$[.@NPC_ID],"MusicManager") + ".wav",0,"quiz_02",342,375,357,386;
	end;
}

quiz_02,343,379,6	duplicate(MusicNote1)	Ghostring#2::MusicNote2	950
quiz_02,343,382,6	duplicate(MusicNote1)	Ghostring#3::MusicNote3	950
quiz_02,343,385,6	duplicate(MusicNote1)	Ghostring#4::MusicNote4	950
quiz_02,356,376,2	duplicate(MusicNote1)	Ghostring#5::MusicNote5	950
quiz_02,356,379,2	duplicate(MusicNote1)	Ghostring#6::MusicNote6	950
quiz_02,356,382,2	duplicate(MusicNote1)	Ghostring#7::MusicNote7	950
quiz_02,356,385,2	duplicate(MusicNote1)	Ghostring#8::MusicNote8	950
