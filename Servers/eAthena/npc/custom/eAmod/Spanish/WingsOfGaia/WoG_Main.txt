// Wings of Gaia
// Airship de Guilds - Proyecto Zephyrus

// **************
// ** Mapflags **
// **************

airwog	mapflag	nobranch
airwog	mapflag	noicewall
airwog	mapflag	nomemo
airwog	mapflag	noreturn
airwog	mapflag	noteleport
airwog	mapflag	nopenalty
airwog	mapflag	nosave	SavePoint
airwog	mapflag	nowarp
airwog	mapflag	nowarpto
airwog	mapflag	gvg
airwog	mapflag	clouds2

// ********************
// ** Airplane Warps **
// ********************

airwog,254, 54,0	warp	air_3wp01	1,1,airwog, 91, 67
airwog, 87, 67,0	warp	air_3wp01a	1,1,airwog,250, 54
airwog,208, 53,0	warp	air_3wp02	1,1,airwog,239,160
airwog,245,160,0	warp	air_3wp02a	1,1,airwog,214, 54
airwog,104,199,0	warp	air_3wp03	1,1,airwog,105, 72
airwog,103, 72,0	warp	air_3wp03a	1,1,airwog,102,199
airwog,104,176,0	warp	air_3wp04	1,1,airwog,105, 52
airwog,103, 52,0	warp	air_3wp04a	1,1,airwog,102,176

// Function: Random enter to the airplane

function	script	WoG_entrar	{
	misceffect 314;
	set @entrada, rand(2);
	if(@entrada == 1) warp "airwog",243,67;
	else warp "airwog",243,36;
	return(0);
}

// ***********************************
// ** Landing and Takeoff functions **
// ***********************************

function	script	WoG_Landing	{
	enablenpc "#WoG_m_" + $@WoG_mid$[$WoG_Cmap];
	enablenpc "Soldier#WoG_m_" + $@WoG_mid$[$WoG_Cmap];
	donpcevent "#WoG_m_" + $@WoG_mid$[$WoG_Cmap] + "::OnUnhide";
	return(1);
}

function	script	WoG_TakeOff	{
	donpcevent "#WoG_m_" + $@WoG_mid$[$WoG_Cmap] + "::OnHide";
	sleep 1000;
	disablenpc "#WoG_m_" + $@WoG_mid$[$WoG_Cmap];
	disablenpc "Soldier#WoG_m_" + $@WoG_mid$[$WoG_Cmap];
	return(1);
}

// ****************************
// ** Landing points * Citys **
// ****************************

comodo,67,248,4	script	#WoG_m_com	45,1,1,{
	callfunc "WoG_entrar"; 
	end;
OnHide:
	// Takeoff
	misceffect 461;
	misceffect 537;
	end;
OnUnhide:
	// Landing
	misceffect 247;
	misceffect 537;
	end;
}

comodo,63,248,5	script	Soldier#WoG_m_com	852,{
	mes "[W.o.G Soldier]";
	mes "Esta es la entrada de la aeronave ^FF0000Wings of Gaia^000000, estaremos en esta ciudad por un tiempo";
	if($WoG_guild_id > 0) {
		mes "Actualmente estamos bajo el mandato de la Guild ^FF0000" + GetGuildName($WoG_guild_id) + "^000000.";
		mes "Si deseas pasar debes tener autorización de ellos, sino, te puedes meter en problemas.";
	} else {
		mes "Debimos aterrizar porque fuimos invadidos por unas criaturas.";
		mes "Nuestro comandante lider de Wings of Gaia ha caído y ahora no tenemos quien nos ayude.";
		mes "Te lo advierto, puedes pasar pero ten cuidado.";
	}
	close;
}

alberta,220,99,4	duplicate(#WoG_m_com)	#WoG_m_alb	45,1,1
alberta,216,99,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_alb	852
aldebaran,112,140,4	duplicate(#WoG_m_com)	#WoG_m_ald	45,1,1
aldebaran,108,140,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_ald	852
amatsu,236,90,4	duplicate(#WoG_m_com)	#WoG_m_ama	45,1,1
amatsu,232,90,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_ama	852
niflheim,334,257,4	duplicate(#WoG_m_com)	#WoG_m_nif	45,1,1
niflheim,330,257,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_nif	852
morocc,234,54,4	duplicate(#WoG_m_com)	#WoG_m_mor	45,1,1
morocc,230,54,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_mor	852
payon,160,85,4	duplicate(#WoG_m_com)	#WoG_m_pay	45,1,1
payon,156,85,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_pay	852
jawaii,258,194,4	duplicate(#WoG_m_com)	#WoG_m_jaw	45,1,1
jawaii,254,194,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_jaw	852
izlude,107,132,4	duplicate(#WoG_m_com)	#WoG_m_izl	45,1,1
izlude,103,132,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_izl	852
prontera,220,66,4	duplicate(#WoG_m_com)	#WoG_m_pro	45,1,1
prontera,216,66,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_pro	852
geffen,49,149,4	duplicate(#WoG_m_com)	#WoG_m_gef	45,1,1
geffen,45,149,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_gef	852
prt_monk,141,187,4	duplicate(#WoG_m_com)	#WoG_m_cap	45,1,1
prt_monk,137,187,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_cap	852
lighthalzen,336,284,4	duplicate(#WoG_m_com)	#WoG_m_lig	45,1,1
lighthalzen,332,284,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_lig	852
xmas,205,106,4	duplicate(#WoG_m_com)	#WoG_m_lut	45,1,1
xmas,201,106,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_lut	852
gonryun,164,178,4	duplicate(#WoG_m_com)	#WoG_m_gon	45,1,1
gonryun,160,178,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_gon	852
louyang,245,94,4	duplicate(#WoG_m_com)	#WoG_m_lou	45,1,1
louyang,241,94,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_lou	852
einbroch,158,298,4	duplicate(#WoG_m_com)	#WoG_m_ebr	45,1,1
einbroch,154,298,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_ebr	852
einbech,42,206,4	duplicate(#WoG_m_com)	#WoG_m_ebe	45,1,1
einbech,38,206,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_ebe	852
ayothaya,151,163,4	duplicate(#WoG_m_com)	#WoG_m_ayo	45,1,1
ayothaya,147,163,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_ayo	852
yuno,157,168,4	duplicate(#WoG_m_com)	#WoG_m_yun	45,1,1
yuno,153,168,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_yun	852
hugel,196,198,4	duplicate(#WoG_m_com)	#WoG_m_hug	45,1,1
hugel,192,198,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_hug	852
rachel,64,123,4	duplicate(#WoG_m_com)	#WoG_m_rac	45,1,1
rachel,60,123,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_rac	852
umbala,141,150,4	duplicate(#WoG_m_com)	#WoG_m_umb	45,1,1
umbala,137,150,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_umb	852
veins,190,213,4	duplicate(#WoG_m_com)	#WoG_m_vei	45,1,1
veins,186,213,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_vei	852
thor_camp,250,64,4	duplicate(#WoG_m_com)	#WoG_m_tho	45,1,1
thor_camp,246,64,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_tho	852

// *******************************
// ** Landing points * Dungeons **
// *******************************

hu_fild05,182,320,4	duplicate(#WoG_m_com)	#WoG_m_abb	45,1,1
hu_fild05,178,320,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_abb	852
ayo_fild02,257,150,4	duplicate(#WoG_m_com)	#WoG_m_anc	45,1,1
ayo_fild02,253,150,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_anc	852
moc_fild20,347,328,4	duplicate(#WoG_m_com)	#WoG_m_ant	45,1,1
moc_fild20,343,328,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_ant	852
pay_arche,62,139,4	duplicate(#WoG_m_com)	#WoG_m_arc	45,1,1
pay_arche,58,139,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_arc	852
izlu2dun,110,143,4	duplicate(#WoG_m_com)	#WoG_m_bya	45,1,1
izlu2dun,106,143,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_bya	852
gefenia02,76,207,4	duplicate(#WoG_m_com)	#WoG_m_gff	45,1,1
gefenia02,72,207,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_gff	852
glast_01,241,240,4	duplicate(#WoG_m_com)	#WoG_m_ghe	45,1,1
glast_01,237,240,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_ghe	852
ra_fild01,244,315,4	duplicate(#WoG_m_com)	#WoG_m_ice	45,1,1
ra_fild01,240,315,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_ice	852
yuno_fild07,236,175,4	duplicate(#WoG_m_com)	#WoG_m_jup	45,1,1
yuno_fild07,232,175,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_jup	852
yuno_fild08,248,205,4	duplicate(#WoG_m_com)	#WoG_m_kie	45,1,1
yuno_fild08,244,205,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_kie	852
cmd_fild02,259,267,4	duplicate(#WoG_m_com)	#WoG_m_kok	45,1,1
cmd_fild02,255,267,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_kok	852
prt_maze02,77,60,4	duplicate(#WoG_m_com)	#WoG_m_hid	45,1,1
prt_maze02,73,60,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_hid	852
yuno_fild03,56,148,4	duplicate(#WoG_m_com)	#WoG_m_mag	45,1,1
yuno_fild03,52,148,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_mag	852
mjolnir_02,81,325,4	duplicate(#WoG_m_com)	#WoG_m_mjo	45,1,1
mjolnir_02,77,325,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_mjo	852
odin_tem02,94,226,4	duplicate(#WoG_m_com)	#WoG_m_odi	45,1,1
odin_tem02,90,226,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_odi	852
gef_fild10,91,341,4	duplicate(#WoG_m_com)	#WoG_m_orc	45,1,1
gef_fild10,87,341,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_orc	852
moc_ruins,86,163,4	duplicate(#WoG_m_com)	#WoG_m_pyr	45,1,1
moc_ruins,82,163,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_pyr	852
ra_temple,94,186,4	duplicate(#WoG_m_com)	#WoG_m_rat	45,1,1
ra_temple,90,186,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_rat	852
lou_dun01,89,203,4	duplicate(#WoG_m_com)	#WoG_m_roy	45,1,1
lou_dun01,85,203,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_roy	852
moc_fild19,148,120,4	duplicate(#WoG_m_com)	#WoG_m_sph	45,1,1
moc_fild19,144,120,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_sph	852
alb2trea,45,90,4	duplicate(#WoG_m_com)	#WoG_m_sun	45,1,1
alb2trea,41,90,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_sun	852
hu_fild01,124,143,4	duplicate(#WoG_m_com)	#WoG_m_tha	45,1,1
hu_fild01,120,143,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_tha	852
tur_dun01,104,82,4	duplicate(#WoG_m_com)	#WoG_m_tur	45,1,1
tur_dun01,100,82,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_tur	852
ve_fild03,176,230,4	duplicate(#WoG_m_com)	#WoG_m_thd	45,1,1
ve_fild03,172,230,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_thd	852

// ********************************
// ** Landing points * Strategic **
// ********************************

xmas_fild01,180,190,4	duplicate(#WoG_m_com)	#WoG_m_f01	45,1,1
xmas_fild01,176,190,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_f01	852
gef_fild14,75,230,4	duplicate(#WoG_m_com)	#WoG_m_f02	45,1,1
gef_fild14,71,230,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_f02	852
ra_fild03,150,110,4	duplicate(#WoG_m_com)	#WoG_m_f03	45,1,1
ra_fild03,146,110,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_f03	852
mjolnir_04,175,195,4	duplicate(#WoG_m_com)	#WoG_m_f04	45,1,1
mjolnir_04,171,195,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_f04	852
pay_fild11,130,95,4	duplicate(#WoG_m_com)	#WoG_m_f05	45,1,1
pay_fild11,126,95,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_f05	852
prt_maze03,100,145,4	duplicate(#WoG_m_com)	#WoG_m_f06	45,1,1
prt_maze03,96,145,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_f06	852
odin_tem03,283,232,4	duplicate(#WoG_m_com)	#WoG_m_f07	45,1,1
odin_tem03,279,232,4	duplicate(Soldier#WoG_m_com)	Soldier#WoG_m_f07	852

// Function: warp the player outside the airplane, if it isn't flying, in the current city or map.

function	script	WoG_leave	{
	if($WoG_status == 0) warp $@WoG_map$[$WoG_Cmap],$@WoG_mapX[$WoG_Cmap],$@WoG_mapY[$WoG_Cmap];
	return(0);
}

// *****************************************
// ** Warps to go outside of the airplane **
// *****************************************

airwog,243,74,4	script	#AirshipWarp-5	45,2,2,{
OnTouch:
	callfunc "WoG_leave";
	end;
OnHide:
	misceffect 16;
	end;
OnUnhide:
	misceffect 215;
	end;
}

airwog,243,29,4	script	#AirshipWarp-6	45,2,2,{
OnTouch:
	callfunc "WoG_leave";
	end;
OnHide:
	misceffect 16;
	end;
OnUnhide:
	misceffect 215;
	end;
}

// ****************************************************************************
// ** Main Control of the Airplane * Landing * Flying to a map * Just Flying **
// ****************************************************************************

airwog,0,0,0	script	WoG_main	-1,{
	end;
OnInit:
	// This "mobevent" is a custom mob creation with Guild ID or Party ID and the mobs created with this command acts like allied of the guild/party
	// For a normal server commend this line...
	mobevent "airwog",20,188,"Wings of Gaia",1288,0,1,$WoG_guild_id,0,0,0,0,1,0,0,0,0,0,"WoG_main::OnEmpeTake";
	// And uncomment this one, but the guild owner can attack the Emperium too
	// monster "airwog",20,188,"Wings of Gaia",1288,1,"WoG_main::OnEmpeTake";
	// **** WoG_status **** 
	// 0: on Land 
	// 1: Takeoff with Map destiny (1:20 seconds)
	// 2: Takeoff without destiny (just fly on the map) (20 seconds)
	// 3: Just Flying on the map
	// 4: Flying to a map (takes 1 minute)
	// 5: Landing in the current map
	set $WoG_status, 0;
	// Access Control of the Airplane
	// 0: Only guild members - GvG Mode
	// 1: Only GM's can use the Airplane
	set $@WoG_access, 0;
	set .@i, 0;
	// Table of Maps and Coordenates - Citys 25
	
	set $@WoG_City_start, .@i;

	set $@WoG_mid$[.@i],"alb"; set $@WoG_nam$[.@i],"Alberta";		set $@WoG_map$[.@i],"alberta";		set $@WoG_mapX[.@i],220; set $@WoG_mapY[.@i], 95; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 0
	set $@WoG_mid$[.@i],"ald"; set $@WoG_nam$[.@i],"Aldebaran";		set $@WoG_map$[.@i],"aldebaran";	set $@WoG_mapX[.@i],112; set $@WoG_mapY[.@i],136; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 1
	set $@WoG_mid$[.@i],"ama"; set $@WoG_nam$[.@i],"Amatsu";		set $@WoG_map$[.@i],"amatsu";		set $@WoG_mapX[.@i],236; set $@WoG_mapY[.@i], 86; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 2
	set $@WoG_mid$[.@i],"ayo"; set $@WoG_nam$[.@i],"Ayothaya";		set $@WoG_map$[.@i],"ayothaya";		set $@WoG_mapX[.@i],151; set $@WoG_mapY[.@i],159; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 3
	set $@WoG_mid$[.@i],"cap"; set $@WoG_nam$[.@i],"Capitolina Abbey";	set $@WoG_map$[.@i],"prt_monk";		set $@WoG_mapX[.@i],141; set $@WoG_mapY[.@i],183; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 4
	set $@WoG_mid$[.@i],"com"; set $@WoG_nam$[.@i],"Comodo";		set $@WoG_map$[.@i],"comodo";		set $@WoG_mapX[.@i], 67; set $@WoG_mapY[.@i],244; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 5
	set $@WoG_mid$[.@i],"ebe"; set $@WoG_nam$[.@i],"Einbech";		set $@WoG_map$[.@i],"einbech";		set $@WoG_mapX[.@i], 42; set $@WoG_mapY[.@i],202; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 6
	set $@WoG_mid$[.@i],"ebr"; set $@WoG_nam$[.@i],"Einbroch";		set $@WoG_map$[.@i],"einbroch";		set $@WoG_mapX[.@i],158; set $@WoG_mapY[.@i],294; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 7
	set $@WoG_mid$[.@i],"gef"; set $@WoG_nam$[.@i],"Geffen";		set $@WoG_map$[.@i],"geffen";		set $@WoG_mapX[.@i], 49; set $@WoG_mapY[.@i],145; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 8
	set $@WoG_mid$[.@i],"gon"; set $@WoG_nam$[.@i],"Gonryun";		set $@WoG_map$[.@i],"gonryun";		set $@WoG_mapX[.@i],164; set $@WoG_mapY[.@i],174; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 9
	set $@WoG_mid$[.@i],"hug"; set $@WoG_nam$[.@i],"Hugel";			set $@WoG_map$[.@i],"hugel";		set $@WoG_mapX[.@i],196; set $@WoG_mapY[.@i],194; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 10
	set $@WoG_mid$[.@i],"izl"; set $@WoG_nam$[.@i],"Izlude";		set $@WoG_map$[.@i],"izlude";		set $@WoG_mapX[.@i],107; set $@WoG_mapY[.@i],128; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 11
	set $@WoG_mid$[.@i],"jaw"; set $@WoG_nam$[.@i],"Jawaii";		set $@WoG_map$[.@i],"jawaii";		set $@WoG_mapX[.@i],258; set $@WoG_mapY[.@i],190; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 12
	set $@WoG_mid$[.@i],"lig"; set $@WoG_nam$[.@i],"Lighthalzen";		set $@WoG_map$[.@i],"lighthalzen";	set $@WoG_mapX[.@i],336; set $@WoG_mapY[.@i],280; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 13
	set $@WoG_mid$[.@i],"lou"; set $@WoG_nam$[.@i],"Louyang";		set $@WoG_map$[.@i],"louyang";		set $@WoG_mapX[.@i],245; set $@WoG_mapY[.@i], 90; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 14
	set $@WoG_mid$[.@i],"lut"; set $@WoG_nam$[.@i],"Lutie";			set $@WoG_map$[.@i],"xmas";		set $@WoG_mapX[.@i],205; set $@WoG_mapY[.@i],102; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 15
	set $@WoG_mid$[.@i],"mor"; set $@WoG_nam$[.@i],"Morroc";		set $@WoG_map$[.@i],"morocc";		set $@WoG_mapX[.@i],234; set $@WoG_mapY[.@i], 58; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 16
	set $@WoG_mid$[.@i],"nif"; set $@WoG_nam$[.@i],"Niflheim";		set $@WoG_map$[.@i],"niflheim";		set $@WoG_mapX[.@i],334; set $@WoG_mapY[.@i],253; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 17
	set $@WoG_mid$[.@i],"pay"; set $@WoG_nam$[.@i],"Payon";			set $@WoG_map$[.@i],"payon";		set $@WoG_mapX[.@i],160; set $@WoG_mapY[.@i], 81; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 18
	set $@WoG_mid$[.@i],"pro"; set $@WoG_nam$[.@i],"Prontera";		set $@WoG_map$[.@i],"prontera";		set $@WoG_mapX[.@i],220; set $@WoG_mapY[.@i], 62; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 19
	set $@WoG_mid$[.@i],"rac"; set $@WoG_nam$[.@i],"Rachel";		set $@WoG_map$[.@i],"rachel";		set $@WoG_mapX[.@i], 64; set $@WoG_mapY[.@i],119; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 20
	set $@WoG_mid$[.@i],"tho"; set $@WoG_nam$[.@i],"Thor Camp";		set $@WoG_map$[.@i],"thor_camp";	set $@WoG_mapX[.@i],250; set $@WoG_mapY[.@i], 60; set $@WoG_public[.@i],0; set .@i, .@i + 1; // 21
	set $@WoG_mid$[.@i],"umb"; set $@WoG_nam$[.@i],"Umbala";		set $@WoG_map$[.@i],"umbala";		set $@WoG_mapX[.@i],141; set $@WoG_mapY[.@i],146; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 22
	set $@WoG_mid$[.@i],"vei"; set $@WoG_nam$[.@i],"Veins";			set $@WoG_map$[.@i],"veins";		set $@WoG_mapX[.@i],190; set $@WoG_mapY[.@i],209; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 23
	set $@WoG_mid$[.@i],"yun"; set $@WoG_nam$[.@i],"Yuno";			set $@WoG_map$[.@i],"yuno";		set $@WoG_mapX[.@i],157; set $@WoG_mapY[.@i],164; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 24

	set $@WoG_CMenu, "";
	for( set .@j, $@WoG_City_start; .@j < .@i; set .@j, .@j + 1 )
	{ // Build Cities Menu
		set $@WoG_CMenu$, $@WoG_CMenu$ + $@WoG_nam$[.@j] + ":";
	}

	// Table of Maps and Coordenates - Dungeons 24
	
	set $@WoG_Dun_start, .@i;
	
	set $@WoG_mid$[.@i],"abb"; set $@WoG_nam$[.@i],"Abbys Lake";		set $@WoG_map$[.@i],"hu_fild05";	set $@WoG_mapX[.@i],182; set $@WoG_mapY[.@i],316; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 25
	set $@WoG_mid$[.@i],"anc"; set $@WoG_nam$[.@i],"Ancient Shrine";	set $@WoG_map$[.@i],"ayo_fild02";	set $@WoG_mapX[.@i],257; set $@WoG_mapY[.@i],146; set $@WoG_public[.@i],0; set .@i, .@i + 1; // 26
	set $@WoG_mid$[.@i],"ant"; set $@WoG_nam$[.@i],"Ant Hell";		set $@WoG_map$[.@i],"moc_fild20";	set $@WoG_mapX[.@i],347; set $@WoG_mapY[.@i],324; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 27
	set $@WoG_mid$[.@i],"arc"; set $@WoG_nam$[.@i],"Archer Village";	set $@WoG_map$[.@i],"pay_arche";	set $@WoG_mapX[.@i], 62; set $@WoG_mapY[.@i],135; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 28
	set $@WoG_mid$[.@i],"bya"; set $@WoG_nam$[.@i],"Byalan Island";		set $@WoG_map$[.@i],"izlu2dun";		set $@WoG_mapX[.@i],110; set $@WoG_mapY[.@i],139; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 29
	set $@WoG_mid$[.@i],"gff"; set $@WoG_nam$[.@i],"Geffenia";		set $@WoG_map$[.@i],"gefenia02";	set $@WoG_mapX[.@i], 76; set $@WoG_mapY[.@i],203; set $@WoG_public[.@i],0; set .@i, .@i + 1; // 30
	set $@WoG_mid$[.@i],"ghe"; set $@WoG_nam$[.@i],"Glast Heim";		set $@WoG_map$[.@i],"glast_01";		set $@WoG_mapX[.@i],241; set $@WoG_mapY[.@i],236; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 31
	set $@WoG_mid$[.@i],"ice"; set $@WoG_nam$[.@i],"Ice Dungeon";		set $@WoG_map$[.@i],"ra_fild01";	set $@WoG_mapX[.@i],244; set $@WoG_mapY[.@i],311; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 32
	set $@WoG_mid$[.@i],"jup"; set $@WoG_nam$[.@i],"Juperos";		set $@WoG_map$[.@i],"yuno_fild07";	set $@WoG_mapX[.@i],236; set $@WoG_mapY[.@i],171; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 33
	set $@WoG_mid$[.@i],"kie"; set $@WoG_nam$[.@i],"Kiel Khayr";		set $@WoG_map$[.@i],"yuno_fild08";	set $@WoG_mapX[.@i],248; set $@WoG_mapY[.@i],201; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 34
	set $@WoG_mid$[.@i],"kok"; set $@WoG_nam$[.@i],"Kokomo Beach";		set $@WoG_map$[.@i],"cmd_fild02";	set $@WoG_mapX[.@i],259; set $@WoG_mapY[.@i],263; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 35
	set $@WoG_mid$[.@i],"hid"; set $@WoG_nam$[.@i],"Hiding Forest";		set $@WoG_map$[.@i],"prt_maze02";	set $@WoG_mapX[.@i], 77; set $@WoG_mapY[.@i], 56; set $@WoG_public[.@i],0; set .@i, .@i + 1; // 36
	set $@WoG_mid$[.@i],"mag"; set $@WoG_nam$[.@i],"Magma Dungeon";		set $@WoG_map$[.@i],"yuno_fild03";	set $@WoG_mapX[.@i], 56; set $@WoG_mapY[.@i],144; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 37
	set $@WoG_mid$[.@i],"mjo"; set $@WoG_nam$[.@i],"Mjolnir Pit";		set $@WoG_map$[.@i],"mjolnir_02";	set $@WoG_mapX[.@i], 81; set $@WoG_mapY[.@i],321; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 38
	set $@WoG_mid$[.@i],"odi"; set $@WoG_nam$[.@i],"Odin Temple";		set $@WoG_map$[.@i],"odin_tem02";	set $@WoG_mapX[.@i], 94; set $@WoG_mapY[.@i],222; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 39
	set $@WoG_mid$[.@i],"orc"; set $@WoG_nam$[.@i],"Orc Dungeon";		set $@WoG_map$[.@i],"gef_fild10";	set $@WoG_mapX[.@i], 91; set $@WoG_mapY[.@i],337; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 40
	set $@WoG_mid$[.@i],"pyr"; set $@WoG_nam$[.@i],"Pyramid";		set $@WoG_map$[.@i],"moc_ruins";	set $@WoG_mapX[.@i], 86; set $@WoG_mapY[.@i],159; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 41
	set $@WoG_mid$[.@i],"rat"; set $@WoG_nam$[.@i],"Rachel Temple";		set $@WoG_map$[.@i],"ra_temple";	set $@WoG_mapX[.@i], 94; set $@WoG_mapY[.@i],182; set $@WoG_public[.@i],0; set .@i, .@i + 1; // 42
	set $@WoG_mid$[.@i],"roy"; set $@WoG_nam$[.@i],"Royal Tomb";		set $@WoG_map$[.@i],"lou_dun01";	set $@WoG_mapX[.@i], 89; set $@WoG_mapY[.@i],199; set $@WoG_public[.@i],0; set .@i, .@i + 1; // 43
	set $@WoG_mid$[.@i],"sph"; set $@WoG_nam$[.@i],"Sphinx";		set $@WoG_map$[.@i],"moc_fild19";	set $@WoG_mapX[.@i],148; set $@WoG_mapY[.@i],116; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 44
	set $@WoG_mid$[.@i],"sun"; set $@WoG_nam$[.@i],"Sunken Ship";		set $@WoG_map$[.@i],"alb2trea";		set $@WoG_mapX[.@i], 45; set $@WoG_mapY[.@i], 86; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 45
	set $@WoG_mid$[.@i],"tha"; set $@WoG_nam$[.@i],"Thanatos Tower";	set $@WoG_map$[.@i],"hu_fild01";	set $@WoG_mapX[.@i],124; set $@WoG_mapY[.@i],139; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 46
	set $@WoG_mid$[.@i],"thd"; set $@WoG_nam$[.@i],"Thor's Volcano";	set $@WoG_map$[.@i],"ve_fild03";	set $@WoG_mapX[.@i],176; set $@WoG_mapY[.@i],226; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 47
	set $@WoG_mid$[.@i],"tur"; set $@WoG_nam$[.@i],"Turtle Island";		set $@WoG_map$[.@i],"tur_dun01";	set $@WoG_mapX[.@i],104; set $@WoG_mapY[.@i], 78; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 48
	
	set $@WoG_DMenu, "";
	for( set .@j, $@WoG_Dun_start; .@j < .@i; set .@j, .@j + 1 )
	{ // Build Cities Menu
		set $@WoG_DMenu$, $@WoG_DMenu$ + $@WoG_nam$[.@j] + ":";
	}
	
	// Table of Maps and Coordenates - Fields
	
	set $@WoG_Field_start, .@i;
	
	set $@WoG_mid$[.@i],"f05"; set $@WoG_nam$[.@i],"Forest of the Tiger";	set $@WoG_map$[.@i],"pay_fild11";	set $@WoG_mapX[.@i],130; set $@WoG_mapY[.@i], 91; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 49
	set $@WoG_mid$[.@i],"f06"; set $@WoG_nam$[.@i],"Labyrinth Forest";	set $@WoG_map$[.@i],"prt_maze03";	set $@WoG_mapX[.@i],100; set $@WoG_mapY[.@i],141; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 50
	set $@WoG_mid$[.@i],"f03"; set $@WoG_nam$[.@i],"Lycanthrope's Lair";	set $@WoG_map$[.@i],"ra_fild03";	set $@WoG_mapX[.@i],150; set $@WoG_mapY[.@i],106; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 51
	set $@WoG_mid$[.@i],"f07"; set $@WoG_nam$[.@i],"Odin Shrine";		set $@WoG_map$[.@i],"odin_tem03";	set $@WoG_mapX[.@i],283; set $@WoG_mapY[.@i],228; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 52
	set $@WoG_mid$[.@i],"f04"; set $@WoG_nam$[.@i],"Queen's Maountain";	set $@WoG_map$[.@i],"mjolnir_04";	set $@WoG_mapX[.@i],175; set $@WoG_mapY[.@i],191; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 53
	set $@WoG_mid$[.@i],"f01"; set $@WoG_nam$[.@i],"Snow Field";		set $@WoG_map$[.@i],"xmas_fild01";	set $@WoG_mapX[.@i],180; set $@WoG_mapY[.@i],186; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 54
	set $@WoG_mid$[.@i],"f02"; set $@WoG_nam$[.@i],"West Orc Village";	set $@WoG_map$[.@i],"gef_fild14";	set $@WoG_mapX[.@i], 75; set $@WoG_mapY[.@i],226; set $@WoG_public[.@i],1; set .@i, .@i + 1; // 55
	
	set $@WoG_FMenu, "";
	for( set .@j, $@WoG_Field_start; .@j < .@i; set .@j, .@j + 1 )
	{ // Build Cities Menu
		set $@WoG_FMenu$, $@WoG_FMenu$ + $@WoG_nam$[.@j] + ":";
	}

	// *********************************************
	// * Total of the landing points - Currenly 22 *
	// *********************************************
	
	// Disabling all the map warps and soldiers.
	for (set .@j, 0; .@j < .@i; set .@j, .@j + 1) {
		disablenpc "#WoG_m_" + $@WoG_mid$[.@j];
		disablenpc "Soldier#WoG_m_" + $@WoG_mid$[.@j];
	}

	// Enabling the current map warp of the airplane (because it start on land)
	// $WoG_Cmap : index of the current map
	enablenpc "#WoG_m_" + $@WoG_mid$[$WoG_Cmap];
	enablenpc "Soldier#WoG_m_" + $@WoG_mid$[$WoG_Cmap];
	// This this the starting "no owner" event. Just like a GvG Castle full of mob. I added just flying mobs.
	if( $WoG_guild_id <= 0 )
	{
		// B2
		monster "airwog",26,188,"Valkyrie Randgris",1751,1;
		monster "airwog",45,188,"Gryphon",1259,10;
		monster "airwog",78,188,"Explosion",1383,20;
		monster "airwog",93,179,"Acidus",1713,4;
		monster "airwog",93,197,"Acidus",1713,4;
		// B1
		monster "airwog",112,62,"Wraith Dead",1291,10;
		monster "airwog",112,62,"Wraith Dead",1192,10;
		monster "airwog",75,62,"Acidus",1713,10;
		monster "airwog",75,62,"Acidus",1716,10;
		// Top
		monster "airwog",237,52,"Valkyrie Randgris",1765,1;
		monster "airwog",237,52,"Acidus",1713,15;
		monster "airwog",237,52,"Acidus",1716,15;
	}
	else
		donpcevent "WoG_main::OnJustFly"; // Keep Airship in the Air at Server Restart
	end;
	
OnEmpeTake:
	// Owner change of the Airplane
	donpcevent "WoGMission2::OnCaptured";
	set $WoG_guild_id, getcharid(2);
	set $WOG_GLMode, 0; // Removes GLOnlyMode
	announce "[Wings of Gaia] capturado por [" + strcharinfo(0) + "] para [" + GetGuildName($WoG_guild_id) + "]",0;
	killmonsterall "airwog"; // Si habian tesoros... son destruidos
	// Just like in the OnInit. Comment this line and uncomment the next one:
	mobevent "airwog",20,188,"Wings of Gaia",1288,0,1,$WoG_guild_id,0,0,0,0,1,0,0,0,0,0,"WoG_main::OnEmpeTake";
	donpcevent "WoG_guildflag::OnGuildUpdate";
	donpcevent "WoG_guildflag2::OnGuildUpdate";
	// Take out intruders
	MapRespawnGuildID "airwog",$WoG_guild_id,2;
	
	if ($WoG_TCiclos == 35)
		set $WoG_TCiclos, 34;
	
	set $WoG_TAmount, 0;
	end;

OnJustFly:
	// From land to air, but just leave the Airplane flying on the current map with no destiny
	set $WoG_status, 2;
	donpcevent "#AirshipWarp-5::OnHide";
	donpcevent "#AirshipWarp-6::OnHide";
	disablenpc "#AirshipWarp-5";
	disablenpc "#AirshipWarp-6";
	// Close the current land warp to the airplane
	callfunc "WoG_TakeOff";
	mapannounce "airwog","[Wings of Gaia esta despegando]",1,0xFFFFFF;
	mapannounce $@WoG_map$[$WoG_Cmap],"[Wings of Gaia esta despegando]",1,0xFFFFFF;
	initnpctimer;
	setnpctimer 0;
	donpcevent "::OnAirplaneMove";
	end;
	
OnDestiny:
	// From air (JustFly mode) to another destiny.
	stopnpctimer;
	mapannounce "airwog","[Wings of Gaia en el Aire - Destino " + $@WoG_nam$[$@WoG_Dmap] + "]",1,0xFFFFFF;
	set $WoG_status, 4;
	initnpctimer;
	end;

OnTakeOff:
	// For land to air with a new map destiny. When the airplane arrives at the new destiny, it doesn't land, and the state changes to JustFly
	stopnpctimer;
	set $WoG_status, 1;
	donpcevent "#AirshipWarp-5::OnHide";
	donpcevent "#AirshipWarp-6::OnHide";
	disablenpc "#AirshipWarp-5";
	disablenpc "#AirshipWarp-6";
	// Close the current land warp to the airplane
	callfunc "WoG_TakeOff";
	mapannounce "airwog","[Wings of Gaia esta despegando]",1,0xFFFFFF;
	mapannounce $@WoG_map$[$WoG_Cmap],"[Wings of Gaia esta despegando]",1,0xFFFFFF;
	initnpctimer;
	donpcevent "::OnAirplaneMove";
	end;

OnLanding:
	// From air (JustFly) to land. Beining of the process. It takes 20 seconds to arrive to earth.
	stopnpctimer;
	set $WoG_status, 5;
	mapannounce "airwog","[Wings of Gaia está descendiendo en " + $@WoG_nam$[$WoG_Cmap] + "]",1,0xFFFFFF;
	initnpctimer;
	end;

OnTimer20000:
	switch ($WoG_status) {
		case 1:
			// Takeoff with destiny - Chances mode to OnDestiny
			stopnpctimer;
			mapannounce "airwog","[Wings of Gaia en el Aire - Destino " + $@WoG_nam$[$@WoG_Dmap] + "]",1,0xFFFFFF;
			set $WoG_status, 4;
			initnpctimer;
		break;
		case 2:
			// Takeoff without destiny - Chance mode to JustFly and it initiates the process of fuel consumption
			stopnpctimer;
			mapannounce "airwog","[Wings of Gaia en el Aire]",1,0x00FF00;
			mapannounce $@WoG_map$[$WoG_Cmap],"[Wings of Gaia sobrevolando " + $@WoG_nam$[$WoG_Cmap] + "]",1,0xFFFFFF;
			set $WoG_status, 3;
			initnpctimer;
			donpcevent "WoG_combustible::OnConsumir";
		break;
		case 3:
			// Just Flying on a map - announces
			stopnpctimer;
			mapannounce "airwog","[Wings of Gaia sobrevolando " + $@WoG_nam$[$WoG_Cmap] + "]",1,0xFFFFFF;
			initnpctimer;
		break;
		case 4:
			// Flying to another destiny - Just announces
			mapannounce "airwog","[Wings of Gaia - Viajando a " + $@WoG_nam$[$@WoG_Dmap] + "]",1,0xFFFFFF;
		break;
		case 5:
			// Landing completed - Stop the Timmer
			donpcevent "WoG_combustible::OnDetener";
			stopnpctimer;
			set $WoG_status, 0;
			enablenpc "#AirshipWarp-5";
			enablenpc "#AirshipWarp-6";
			donpcevent "#AirshipWarp-5::OnUnhide";
			donpcevent "#AirshipWarp-6::OnUnhide";
			mapannounce "airwog","[Wings of Gaia ha llegado a " + $@WoG_nam$[$WoG_Cmap] + "]",1,0x00FF00;
			mapannounce $@WoG_map$[$WoG_Cmap],"[Wings of Gaia ha llegado a " + $@WoG_nam$[$WoG_Cmap] + "]",1,0xFFFFFF;
			callfunc "WoG_Landing";
			donpcevent "::OnAirplaneMove";
			donpcevent "::OnWoGLanded"; // Used for special Events and Quests
		break;
	}
	end;
	
OnTimer40000:
	// Flying to another map and announces
	mapannounce "airwog","[Wings of Gaia - Pronto llegaremos a " + $@WoG_nam$[$@WoG_Dmap] + "]",1,0xFFFFFF;
	end;
	
OnTimer60000:
	// reached destiny - change mode to Just Fly and it initiates the process of fuel consumption
	stopnpctimer;
	set $WoG_Cmap, $@WoG_Dmap;
	set $@WoG_Dmap, 0;
	set $WoG_status, 3;
	mapannounce "airwog","[Wings of Gaia sobre " + $@WoG_nam$[$WoG_Cmap] + " - Esperando ordenes]",1,0x00FF00;
	mapannounce $@WoG_map$[$WoG_Cmap],"[Wings of Gaia sobrevolando " + $@WoG_nam$[$WoG_Cmap] + "]",1,0xFFFF00;
	initnpctimer;
	donpcevent "WoG_combustible::OnConsumir";
	end;
}

// *********************************
// ** NPC Captain of the Airplane **
// *********************************

airwog,221,158,2	script	Capitan#WoG	852,{
	mes "[Capitan W.o.G]";
	// Checks if the player is GM - member of the guild owner of the airplane
	if($@WoG_access == 1 && getgmlevel() >= 1) goto L_Autorizado;
	if(getgmlevel() >= 1 || (($@WoG_access == 0) && ($WoG_guild_id == getcharid(2)) && (getcharid(2) > 0))) goto L_Autorizado;
	if($@WoG_access == 1) {
		mes "Bienvenido a la cabina del capitán. Puedes mirar todo lo que quieras, pero no tocar.";
		mes "La aeronave se encuentra bajo el mandado de la administración Terra.";
	} else if($WoG_guild_id > 0) {
		mes "Solamente obedezco a los miembros de la guild ^FF0000" + GetGuildName($WoG_guild_id) + "^000000.";
		mes "Por favor, retirese antes que llame a seguridad, o mantengase como visitante solamente.";	
	} else {
		mes "Disculpa, pero recibo solamente instrucciones de la Guild que tenga el poder de adueñarse de la aeronave ^FF0000Wings of Gaia^000000.";
		mes "En nuestra base inferior se encuentra el corazón de la Aeronave, y la guild que logre tomarla será quien comande la nave.";
	}
	close;
	
L_Autorizado:
	// Checks if the Captain is busy.
	if($WoG_status == 1 || $WoG_status == 4) {
		mes "Mi señor, tengo ordenes de viajar a ^FF0000" + $@WoG_nam$[$@WoG_Dmap] + "^000000. Por favor espere a que el viaje termine.";
		close;
	}
	if($WoG_status == 2) {
		mes "Mi señor, en estos momentos estamos despegando. Por favor espere a que nos encontremos en el aire.";
		close;
	}
	if($WoG_status == 5) {
		mes "Mi señor, en estos momentos estoy aterrizando la nave. Por favor espere.";
		close;
	}
	if($@WoG_Entregando != 0) {
		mes "Mi señor, en estos momentos estamos entregando un embarque. Por favor espere a que terminemos.";
		close;
	}
	if($@WoG_Retirando != 0) {
		mes "Mi señor, no podemos despegar hasta que terminemos de cargar proviciones en Alberta.";
		close;
	}
	
	// Guild Lider Only mode check
	if( $WOG_GLMode && strcharinfo(0) != getguildmaster($WoG_guild_id) && getgmlevel() <= 1 )
	{
		mes "Tengo instrucciones de solamente obedecer al lider de la Guild, lo lamento.";
		close;
	}

	// Awaiting orders...
	mes "Bienvenido a la cabina del capitán mi señor.";
	mes "Cuales son sus ordenes?";
	next;
	switch( select ("Viajar a otro mapa:Aterrizar / Despegar:Nada por ahora" + ( (strcharinfo(0) == getguildmaster($WoG_guild_id)) ? ":^FF0000Modalidad Guild Lider^000000" : "" ) ) )
	{
		case 1:
			// Go to another map ********************************************************************************
			mes "[Capitan W.o.G]";
			mes "Si Señor!!. Cual es nuestro destino?";
			next;
			switch( select("Ciudades:Dungeons:Fields:Ninguno por ahora") )
			{
				case 1: // Ciudades
					set $@WoG_Dmap, $@WoG_City_start + select($@WoG_CMenu$) - 1;
					break;

				case 2: // Dungeons
					set $@WoG_Dmap, $@WoG_Dun_start + select($@WoG_DMenu$) - 1;
					break;

				case 3: // Fields
					set $@WoG_Dmap, $@WoG_Field_start + select($@WoG_FMenu$) - 1;
					break;

				case 4: // No acción
					mes "[Capitan W.o.G]";
					mes "Regrese cuando lo desee. Estaré alerta.";
					close;					
				break;
			}
			
			if ($WoG_status == 0 && $WoG_Combustible >= 800 && $@WoG_Dmap != $WoG_Cmap) {
				if($@WoG_public[$@WoG_Dmap] == 0 && $@WoG_access == 0) {
					mes "[Capitan W.o.G]";
					mes "Lo lamento señor, pero el acceso a este mapa está restringido.";
					close;
				}
				// On land with destiny
				set $WoG_Combustible, $WoG_Combustible - 800;
				donpcevent "WoG_main::OnTakeOff";
				mes "[Capitan W.o.G]";
				mes "Si señor!! a toda máquina";
			} else if ($WoG_status == 3 && $WoG_Combustible >= 600 && $@WoG_Dmap != $WoG_Cmap) {
				if($@WoG_public[$@WoG_Dmap] == 0 && $@WoG_access == 0) {
					mes "[Capitan W.o.G]";
					mes "Lo lamento señor, pero el acceso a este mapa está restringido.";
					close;
				}
				// On Air with destiny
				set $WoG_Combustible, $WoG_Combustible - 600;
				donpcevent "WoG_combustible::OnDetener";
				donpcevent "WoG_main::OnDestiny";
				mes "[Capitan W.o.G]";
				mes "Si señor!! a toda máquina";
			} else if (($WoG_status == 0 && $WoG_Combustible < 800) || ($WoG_status == 3 && $WoG_Combustible < 600)) {
				mes "[Capitan W.o.G]";
				mes "Lo lamento señor, pero no tenemos combustible para el viaje.";
				mes "Puedes hablar con el encargado, en la base de la aeronave para mayor información.";
			} else if ($@WoG_Dmap == $WoG_Cmap && ($WoG_status == 0 || $WoG_status == 3)) {
				mes "[Capitan W.o.G]";
				mes "Disculpe señor, actualmente nos encontramos en este mapa.";
			} else {
				mes "[Capitan W.o.G]";
				mes "Disculpe señor, pero he recibido nuevas ordenes.";
			}
			// **************************************************************************************************
		break;
		case 2:
			// Takeoff or Landing
			if ($WoG_status == 0 && $WoG_Combustible >= 200) {
				set $WoG_Combustible, $WoG_Combustible - 200;
				donpcevent "WoG_main::OnJustFly";
				mes "[Capitan W.o.G]";
				mes "Si Señor!!. Despegando...";
			} else if ($WoG_status == 0 && $WoG_Combustible < 200) {
				mes "[Capitan W.o.G]";
				mes "Disculpe señor, pero no tenemos suficiente combustible para despegar.";
				mes "Puedes hablar con el encargado, en la base de la aeronave.";
			} else if ($WoG_status == 3) {
				donpcevent "WoG_combustible::OnDetener";
				donpcevent "WoG_main::OnLanding";
				mes "[Capitan W.o.G]";
				mes "Si Señor!!. Aterrizando...";
			} else {
				mes "[Capitan W.o.G]";
				mes "Disculpe señor... Mis ordenes han cambiado, espere que termine.";
			}
		break;
		case 3:
			// Nothing right now
			mes "[Capitan W.o.G]";
			mes "Regrese cuando lo desee. Estaré alerta.";
		break;
		case 4:
			// Modalidad Guild Lider
			mes "[Capitan W.o.G]";
			if( $WOG_GLMode )
			{
				set $WOG_GLMode, 0;
				mes "Entendido señor. Obedeceré instrucciones de cualquier miembro de la Guild.";
			}
			else
			{
				set $WOG_GLMode, 1;
				mes "Entendido señor. Solamente obedeceré tus instrucciones.";
				mes "Otros miembros de la guild no podrán dirigir a Wings of Gaia.";
			}
		break;
	}
	close;
}

// ***********************************
// ** Airplane warper and announcer **
// ***********************************

airwog,62,41,7	script	Anunciador::WoG_announcer	852,{
	mes "[Anunciador]";
	mes "Soy el encargado de anunciar las visitas a la aeronave.";
	mes "Recuerda que puedes accesar a la nave si eres miembro de la guild poseedora. El piloto se encuentra en prontera, pero solo puede traer a una persona por viaje.";
	close;
	
OnAnunciar:
	set $@WoG_r1, rand(4);
	switch ($@WoG_r1) {
		case 0: npctalk "Bienvenido a Wings of Gaia"; break;
		case 1: npctalk "Tenemos visitantes..."; break;
		case 2: npctalk "Atención a las visitas!!"; break;
		case 3: npctalk "¿Tiene permiso de acceso? Adelante"; break;
	}
	end;
}

prontera,124,262,3	script	Teleporter::WoG_teleport	852,{
	mes "[Teleporter]";
	mes "Soy el encargado de transportar personal a Wings of Gaia.";
	if ($@WoG_intruso == 1) mes "Atento, la aeronave se encuentra en estado de Alerta de intrusos.!!";
	if ($WoG_guild_id <= 0)
	{
		mes "Pero lamentablemente la nave perdió a su comandante en una invasión y ahora no tenemos lider, y no puedo brindar este servicio";
		close;
	}
	else if ($WoG_guild_id == getcharid(2) || $@WoG_access == 1)
	{
		mes "¿Deseas ser llevado a la aeronave ahora?";
		next;
		menu "Por favor",L_warp,"No gracias...",L_nowarp;
	}
	else
	{
		if( $WoG_Suministros && rand(1000) < 5 )
		{
			mes "¿Deseas ser llevado a la aeronave ahora?";
			mes "Me importa muy poco si subes a ella, igual nos tienen sin suministros.";
			next;
			menu "Por favor",L_warp,"No gracias...",L_nowarp;
		}
		else
			mes "Tu no eres miembro de la guild que comanda Wings of Gaia, por favor no molestes.";
		close;		
	}

L_warp:
	mes "[Teleporter]";
	mes "Notificaré de tu transporte. Espera un momento.";
	close2;
	warp "airwog",66,29;
	donpcevent "WoG_announcer::OnAnunciar";
	end;

L_nowarp:
	mes "[Teleporter]";
	mes "Vuelve si necesitas del transporte.";
	close;
}

// ********************
// ** Flags de Guild **
// ********************

airwog,233,162,4	script	Wings of Gaia::WoG_guildflag	722,{
	end;
OnInit:
OnGuildUpdate:
	flagemblem $WoG_guild_id;
	end;
}

prontera,142,225,4	script	Wings of Gaia::WoG_guildflag2	722,{
	mes "[Wings of Gaia]";
	mes "Este es el estandarte de Wings of Gaia";
	mes "la mejor aeronave en todo Midgard.";
	if ($WoG_guild_id > 0)
		mes "Actualmente la nave se encuentra bajo el poder de la guild ^0000FF" + GetGuildName($WoG_guild_id) + "^000000.";
	else
		mes "La nave no tiene dueño actualmente y se encuentra en problemas.";
	close;

OnInit:
OnGuildUpdate:
	FlagEmblem $WoG_guild_id;
	end;
}

// ******************************
// ** Airplane Security System **
// ******************************

airwog,226,161,5	script	Security System::WoG_secupanel	858,{
	mes "[Security System]";
	if (getgmlevel() >= 1) goto L_gmmenu;
	if ($@WoG_access == 1) {
		mes ">...";
		mes ">Acceso denegado";
		mes ">...";
		close;
	}
	if ($WoG_guild_id <= 0) {
		mes ">...";
		mes ">Error...";
		mes ">...";
		mes ">Error...";
		mes ">...";
		close;
	}
	if ($WoG_guild_id != getcharid(2)) {
		mes ">...";
		mes ">Acceso denegado";
		mes ">Identificación denegada";
		mes ">...";
		if ($@WoG_security == 1) mapannounce "airwog","[ALERTA!! Intrusos en la cabina del Capitán]",1,0xFF0000;
		close;
	}
	goto L_autorizado;
	
L_gmmenu:
	mes ">Accesando opciones administrativas.";
	mes ">...";
	if($@WoG_Entregando != 0) {
		mes ">Entregando Embarque, sistema detenido...";
		close;
	}
	if($@WoG_Retirando != 0) {
		mes ">Retirando Proviciones, sistema detenido...";
		close;
	}
	next;
	menu "Modo Guild - GvG",L_gvg,"Modo Aventura GM",L_nogvg,"Usar panel normal",L_normal;

L_gvg:
	mes "[Security System]";
	if ($@WoG_access == 0) {
		mes ">Opción incorrecta...";
		mes ">Este modo ya está activado.";
		next;
		mes "[Security System]";
		goto L_gmmenu;
	} else {
		gvgon "airwog";
		// New Emperium
		mobevent "airwog",20,188,"Wings of Gaia",1288,0,1,$WoG_guild_id,0,0,0,0,1,0,0,0,0,0,"WoG_main::OnEmpeTake";
		set $@WoG_access, 0;
		mes ">Modo Guild - GVG activado...";
		mes ">Las guilds lucharán por el control.";
		next;
		goto L_normal;
	}
	
L_nogvg:
	mes "[Security System]";
	if ($@WoG_access == 1) {
		mes ">Opción incorrecta...";
		mes ">Este modo ya está activado.";
		next;
		mes "[Security System]";
		goto L_gmmenu;
	} else {
		gvgoff "airwog";
		// Removes the Emperium
		killmonster "airwog","WoG_main::OnEmpeTake";
		set $@WoG_access, 1;
		mes ">Modo aventura activado...";
		mes ">Solo Terra Staff puede manejar el Airplane.";
		next;
		goto L_normal;
	}
	
L_normal:
	mes "[Security System]";
L_autorizado:
	if ($@WoG_security == 1) mes ">Sensores laser ^006600activados^000000.";
	else mes ">Sensores laser ^FF0000desactivados^000000.";
	if ($@WoG_intruso == 1) mes ">Precausión. Alerta de Intrusos";
	mes ">Escaneo de humanos...";
	mes ">... ^99CCFF" + getmapusers("airwog") + "^000000 en la nave.";
	if ($WoG_status != 4) mes ">... ^99CCFF" + getmapusers($@WoG_map$[$WoG_Cmap]) + "^000000 en " + $@WoG_nam$[$WoG_Cmap] + ".";
	mes ">Ingrese su opción...";
	next;
	menu "^006600Activar sensores^000000",L_activar,"^FF0000Desactivar sensores^000000",L_desactivar,"Cancelar Alerta",-;
	if ($@WoG_intruso == 1) {
		set $@WoG_intruso, 0;
		donpcevent "WoG_security::OnDesactivar";
		mes "[Security System]";
		mes ">Cancelada alerta de seguridad...";
		mes ">Sistemas vuelven a la normalidad.";
	} else {
		mes "[Security System]";
		mes ">Opción incorrecta...";
		mes ">Las alertas no están activas.";
	}
	mes ">...";
	close;

L_activar:
	if ($@WoG_security == 0) {
		set $@WoG_security, 1;
		mapannounce "airwog","[Sensores y Sistemas de Seguridad Activados]",1,0xFF0000;
		mes "[Security System]";
		mes ">Sensores de seguridad activados.";
		donpcevent "WoG_security::OnSeguridadON";
	} else {
		mes "[Security System]";
		mes ">Opción incorrecta...";
		mes ">El sistema ya se encuentra activo.";
	}
	close;

L_desactivar:
	if ($@WoG_security == 1) {
		set $@WoG_security, 0;
		if ($@WoG_intruso == 1) {
			set $@WoG_intruso, 0;
			donpcevent "WoG_security::OnDesactivar";
		}
		mapannounce "airwog","[Sensores y Sistemas de Seguridad desactivados]",1,0xFF0000;
		mes "[Security System]";
		mes ">Sensores de seguridad desactivados.";
		donpcevent "WoG_security::OnSeguridadOFF";
	} else {
		mes "[Security System]";
		mes ">Opción incorrecta...";
		mes ">El sistema ya se encuentra inactivo.";
	}
	mes ">...";
	close;
	
OnAirplaneMove:
	misceffect 537;
	end;
}

// **************************
// ** Main Security Script **
// **************************

airwog,0,0,0	script	WoG_security	-1,{
	end;

OnActivar:
	if ($@WoG_security != 1) end;
	initnpctimer;
	setnpctimer 0;
	mapannounce "airwog","[ALERTA!! Intrusos - Seguridad Nivel 3]",1,0x00FF00;
	if ($@WoG_intruso == 0) set $@WoG_intruso, 1;
	end;

OnAlerta:
	set $@WoG_lasers, $@WoG_lasers + 1;
	if ($@WoG_lasers == 4) mapannounce "airwog","[ALERTA MAXIMA!! Sistemas de Defensa Activados]",1,0x00FF00;
	if ($@WoG_lasers > 6) set $@WoG_lasers, 6;
	stopnpctimer;
	setnpctimer 0;
	startnpctimer;
	end;

OnDesactivar:
	stopnpctimer;
	setnpctimer 0;
	set $@WoG_intruso, 0;
	set $@WoG_lasers, 0;
	end;

OnTimer20000:
	if ($@WoG_lasers > 0) set $@WoG_lasers, $@WoG_lasers - 1;
	mapannounce "airwog","[Bajando Seguridad a Nivel 2]",1,0x00FF00;
	end;

OnTimer40000:
	if ($@WoG_lasers > 0) set $@WoG_lasers, $@WoG_lasers - 1;
	mapannounce "airwog","[Bajando Seguridad a Nivel 1]",1,0x00FF00;
	end;

OnTimer60000:
	stopnpctimer;
	setnpctimer 0;
	mapannounce "airwog","[Sistemas de Alerta vuelven a la normalidad]",1,0x0000FF;
	set $@WoG_intruso, 0;
	set $@WoG_lasers, 0;
	end;
	
OnSeguridadON:
	donpcevent "WoG_Sensor1::OnActivar";
	donpcevent "WoG_Sensor2::OnActivar";
	donpcevent "WoG_Sensor3::OnActivar";
	donpcevent "WoG_Sensor4::OnActivar";
	donpcevent "WoG_Sensor5::OnActivar";
	donpcevent "WoG_Sensor6::OnActivar";
	donpcevent "WoG_Sensor7::OnActivar";
	donpcevent "WoG_Sensor8::OnActivar";
	donpcevent "WoG_Sensor9::OnActivar";
	donpcevent "WoG_Sensor10::OnActivar";
	donpcevent "WoG_Sensor11::OnActivar";
	donpcevent "WoG_Sensor12::OnActivar";
	donpcevent "WoG_Sensor13::OnActivar";
	donpcevent "WoG_Sensor14::OnActivar";
	donpcevent "WoG_Sensor15::OnActivar";
	donpcevent "WoG_Sensor16::OnActivar";
	donpcevent "WoG_Sensor17::OnActivar";
	donpcevent "WoG_Sensor18::OnActivar";
	donpcevent "WoG_Sensor19::OnActivar";
	donpcevent "WoG_Sensor20::OnActivar";
	donpcevent "WoG_Sensor21::OnActivar";
	end;
	
OnSeguridadOFF:
	donpcevent "WoG_Sensor1::OnDesactivar";
	donpcevent "WoG_Sensor2::OnDesactivar";
	donpcevent "WoG_Sensor3::OnDesactivar";
	donpcevent "WoG_Sensor4::OnDesactivar";
	donpcevent "WoG_Sensor5::OnDesactivar";
	donpcevent "WoG_Sensor6::OnDesactivar";
	donpcevent "WoG_Sensor7::OnDesactivar";
	donpcevent "WoG_Sensor8::OnDesactivar";
	donpcevent "WoG_Sensor9::OnDesactivar";
	donpcevent "WoG_Sensor10::OnDesactivar";
	donpcevent "WoG_Sensor11::OnDesactivar";
	donpcevent "WoG_Sensor12::OnDesactivar";
	donpcevent "WoG_Sensor13::OnDesactivar";
	donpcevent "WoG_Sensor14::OnDesactivar";
	donpcevent "WoG_Sensor15::OnDesactivar";
	donpcevent "WoG_Sensor16::OnDesactivar";
	donpcevent "WoG_Sensor17::OnDesactivar";
	donpcevent "WoG_Sensor18::OnDesactivar";
	donpcevent "WoG_Sensor19::OnDesactivar";
	donpcevent "WoG_Sensor20::OnDesactivar";
	donpcevent "WoG_Sensor21::OnDesactivar";
	end;
}

// **********************
// ** Movement Sensors **
// **********************

// **** Main Sensor - Handles the switch system ****
airwog,26,188,3	script	Sensor M::WoG_Sensor1	858,5,5,{
	end;
OnTouch:
	if (getgmlevel() < 1 && $@WoG_visor == 1 && $WoG_guild_id > 0 && $WoG_guild_id != getcharid(2) && $@WoG_security == 1) {
		misceffect 300;
		if ($@WoG_intruso == 0) donpcevent "WoG_security::OnActivar";
		else donpcevent "WoG_security::OnAlerta";
		if ($@WoG_lasers >= 4) { specialeffect2 106; percentheal -5,-5; }
	}
	end;
OnActivar:
	set $@WoG_visor, 0;
	initnpctimer;
	setnpctimer 0;
	end;
OnDesactivar:
	set $@WoG_visor, 0;
	stopnpctimer;
	setnpctimer 0;
	end;
OnTimer6000:
	if ($@WoG_visor == 1) {
		misceffect 52;
		set $@WoG_visor, 0;
	} else {
		misceffect 238;
		set $@WoG_visor, 1;
	}
	stopnpctimer;
	setnpctimer 0;
	startnpctimer;
	end;
OnAirplaneMove:
	misceffect 537;
	end;
}
// **** Base Sensor Type A ****
airwog,55,188,1	script	Sensor A::WoG_Sensor2	858,5,5,{
	end;
OnTouch:
	if (getgmlevel() < 1 && $@WoG_visor == 1 && $WoG_guild_id > 0 && $WoG_guild_id != getcharid(2) && $@WoG_security == 1) {
		misceffect 300;
		if ($@WoG_intruso == 0) donpcevent "WoG_security::OnActivar";
		else donpcevent "WoG_security::OnAlerta";
		if ($@WoG_lasers >= 4) { specialeffect2 106; percentheal -5,-5; }
	}
	end;
OnActivar:
	initnpctimer;
	setnpctimer 0;
	end;
OnDesactivar:
	stopnpctimer;
	setnpctimer 0;
	end;
OnTimer6000:
	if ($@WoG_visor == 0) misceffect 52;
	else misceffect 238;
	stopnpctimer;
	setnpctimer 0;
	startnpctimer;
	end;
OnAirplaneMove:
	misceffect 537;
	end;
}
// **** Base Sensor Type B ****
airwog,40,77,1	script	Sensor B::WoG_Sensor10	858,5,5,{
	end;
OnTouch:
	if (getgmlevel() < 1 && $@WoG_visor == 0 && $WoG_guild_id > 0 && $WoG_guild_id != getcharid(2) && $@WoG_security == 1) {
		misceffect 300;
		if ($@WoG_intruso == 0) donpcevent "WoG_security::OnActivar";
		else donpcevent "WoG_security::OnAlerta";
		if ($@WoG_lasers >= 4) { specialeffect2 106; percentheal -5,-5; }
	}
	end;
OnActivar:
	initnpctimer;
	setnpctimer 0;
	end;
OnDesactivar:
	stopnpctimer;
	setnpctimer 0;
	end;
OnTimer6000:
	if ($@WoG_visor == 1) misceffect 52;
	else misceffect 238;
	stopnpctimer;
	setnpctimer 0;
	startnpctimer;
	end;
OnAirplaneMove:
	misceffect 537;
	end;	
}

// **** Sensors Type A ****
airwog,69,167,1	duplicate(WoG_Sensor2)	Sensor A::WoG_Sensor3	858,5,5
airwog,92,178,1	duplicate(WoG_Sensor2)	Sensor A::WoG_Sensor4	858,5,5
airwog,92,199,3	duplicate(WoG_Sensor2)	Sensor A::WoG_Sensor5	858,5,5
airwog,111,62,2	duplicate(WoG_Sensor2)	Sensor A::WoG_Sensor6	858,5,5
airwog,58,60,6	duplicate(WoG_Sensor2)	Sensor A::WoG_Sensor7	858,5,5
airwog,27,62,4	duplicate(WoG_Sensor2)	Sensor A::WoG_Sensor8	858,5,5
airwog,247,48,3	duplicate(WoG_Sensor2)	Sensor A::WoG_Sensor9	858,5,5
airwog,62,82,5	duplicate(WoG_Sensor2)	Sensor A::WoG_Sensor17	858,5,5
// **** Sensors Type B ****
airwog,40,46,7	duplicate(WoG_Sensor10)	Sensor B::WoG_Sensor11	858,5,5
airwog,77,60,7	duplicate(WoG_Sensor10)	Sensor B::WoG_Sensor12	858,5,5
airwog,69,41,1	duplicate(WoG_Sensor10)	Sensor B::WoG_Sensor13	858,5,5
airwog,69,82,4	duplicate(WoG_Sensor10)	Sensor B::WoG_Sensor14	858,5,5
airwog,230,59,5	duplicate(WoG_Sensor10)	Sensor B::WoG_Sensor15	858,5,5
airwog,212,44,6	duplicate(WoG_Sensor10)	Sensor B::WoG_Sensor16	858,5,5
airwog,97,50,6	duplicate(WoG_Sensor10)	Sensor B::WoG_Sensor18	858,5,5
airwog,91,82,6	duplicate(WoG_Sensor10)	Sensor B::WoG_Sensor19	858,5,5
airwog,117,191,3	duplicate(WoG_Sensor10)	Sensor B::WoG_Sensor20	858,5,5
airwog,62,167,7	duplicate(WoG_Sensor10)	Sensor B::WoG_Sensor21	858,5,5

// Airplane position informer

prontera,115,262,5	script	Soldier#WoG_Radar	852,{
	mes "[Soldier]";
	mes "Hola, soy parte del equipo de la aeronave ^0000FFWings of Gaia^000000.";
	if ($WoG_guild_id > 0) mes "Actualmente la nave se encuentra bajo el poder de la guild ^0000FF" + GetGuildName($WoG_guild_id) + "^000000.";
	else mes "La nave no tiene dueño actualmente y se encuentra en problemas.";
	mes "Mi deber es informar su posición.";
	next;
	mes "[Soldier]";
	switch ($WoG_status) {
		case 0: mes "Actualmente la nave se encuentra en tierra, en " + $@WoG_nam$[$WoG_Cmap] + "."; break;
		case 1: mes "Actualmente la nave esta despegando de " + $@WoG_nam$[$WoG_Cmap] + ", y no tiene destino."; break;
		case 2: mes "Actualmente la nave esta despegando de " + $@WoG_nam$[$WoG_Cmap] + " y con destino a " + $@WoG_nam$[$@WoG_Dmap]; break;
		case 3: mes "Actualmente la nave esta sobrevolando " + $@WoG_nam$[$WoG_Cmap] + "."; break;
		case 4: mes "Actualmente la nave esta volando con rumbo a " + $@WoG_nam$[$@WoG_Dmap] + "."; break;
		case 5: mes "Actualmente la nave esta aterrizando en " + $@WoG_nam$[$WoG_Cmap] + "."; break;
	}
	close;
}

airwog,215,56,5	duplicate(Soldier#WoG_Radar)	Soldier#WoG_Radar2	852
airwog,62,86,7	duplicate(Soldier#WoG_Radar)	Soldier#WoG_Radar3	852

// **************************
// * Treasure Room Guardian *
// **************************

airwog,61,163,7	script	Guardian del Tesoro::WoG_Treasure	852,{
	mes "[Guardian]";
	if ($WoG_guild_id != getcharid(2) && getgmlevel() < 80) {
		mes "Esta es la sala del tesoro de Wings of Gaia.";
		mes "No deberias estar aquí, si eres un invitado regresa al segundo nivel, o deberé llamar a seguridad";
	} else {
		set @t, 36 - $WoG_TCiclos;
		mes "Hola señor, le recuerdo que faltan " + @t + " horas aproximadamente para que nuestros soldados traigan los tesoros.";
		next;
		mes "[Guardian]";
		mes "Si existe algun lio o alguien toma el poder la nave, los tesoros se atrasarán 1 hora, y la producción de estos depende de tu progreso en la Misión principal";
		next;
		set @t, callfunc("WoG_CalcTreasures");
		mes "[Guardian]";
		mes "Tu producción actual de tesoros es de " + @t + " cada 36 horas.";
		mes "Por misiones completadas de WoG tienes: " + getd("$WoG_T_" + $WoG_guild_id) + " tesoros.";
		if( $WoG_Suministros )
		{
			next;
			mes "[Guardian]";
			mes "Lamentablemente Wings of Gaia se quedó sin suministros por esta semana, los tesoros no llegarán pues los soldados se niegan a trabajar.";
		}
	}
	close;

OnInit:
	// Tipos de Tesoros
	setarray $@WoG_TreasureIDs[0],1324,1325,1326,1328;
	// Respawn de Tesoros no abiertos
	if ($WoG_TAmount > 0)
		callfunc "WoG_TreasureSpawn",$WoG_TAmount;
	// Inicio de Timer
	initnpctimer;
	end;
	
OnTimer3600000: // 1 Hora
	stopnpctimer;
	if ($@WoG_access != 0 || $WoG_Suministros == 1) {
		initnpctimer;
		end;
	}
	
	set $WoG_TCiclos, $WoG_TCiclos + 1;
	if ($WoG_TCiclos >= 36)
	{
		set $WoG_TCiclos, 0; // 24 horas cumplidas
		set .@k, callfunc("WoG_CalcTreasures");
		callfunc "WoG_TreasureSpawn",.@k;
		set $WoG_TAmount, $WoG_TAmount + .@k;
		mapannounce "airwog","[Wings of Gaia - Nuevo Embarque de Tesoros ha llegado]",1,0xFF0000;
		setd "$WoG_T_" + $WoG_guild_id, 0; // Entregos Tesoros por Missions
	}
	initnpctimer;
	end;

OnTreasure:
	mapannounce "airwog","[Wings of Gaia - Un Tesoro ha sido abierto]",1,0xFF0000;
	set $WoG_TAmount, $WoG_TAmount - 1;
	end;
}

function	script	WoG_CalcTreasures	{
	// Calcutation of the Treasure Spawn amount by the WoG Quest progress
	set .@amount, 0;
	if (getd("$WoG_q_" + $WoG_guild_id) >= 20) 
		set .@amount, .@amount + 1; // First Chapter
	if (getd("$WoG_q_" + $WoG_guild_id) >= 26) 
		set .@amount, .@amount + 1; // Second Chapter
	
	set .@amount, .@amount + getd("$WoG_T_" + $WoG_guild_id); // Tesoros por WoG Missions

	return .@amount;
}

function	script	WoG_TreasureSpawn	{
	// Treasure Spawns
	set .@j, getarg(0); // Amount to Spawn
	for (set .@i, 0; .@i < .@j; set .@i, .@i + 1) {
		set .@m, $@WoG_TreasureIDs[rand(4)];
		areamonster "airwog",62,155,69,164,"Tesoros WoG",.@m,1,"WoG_Treasure::OnTreasure";
	}

	return 0;
}

// Fuel consumption control
// **** Captain Room announcer ****
airwog,226,154,7	script	Panel Combustible::WoG_Panel	858,{
	end;
OnAnuncio:
	npctalk $WoG_Combustible + "u.";
	end;
}
// **** Main Fuel Control ****
airwog,0,0,0	script	WoG_combustible	-1,{
	end;

OnDetener:
	stopnpctimer;
	end;

OnConsumir:
	initnpctimer;
	end;

OnTimer10000:
	set $WoG_Combustible, $WoG_Combustible - 100;
	donpcevent "WoG_Panel::OnAnuncio";
	if ($WoG_Combustible <= 0) {
		set $WoG_Combustible, 0;
		stopnpctimer;
		mapannounce "airwog","[Wings of Gaia sin combustible - Aterrizaje de Emergencia]",1,0xFF0000;
		donpcevent "WoG_main::OnLanding";
		end;
	}
	stopnpctimer;
	initnpctimer;
	end;
}
// **** Fuel Administrator ****
airwog,88,188,2	script	Ingeniero	851,{
	mes "[Ingeniero]";
	mes "Esta es la entrada al cuarto de máquinas de la aeronave. El indicador marca " + $WoG_Combustible + " unidades de combustible";
	mes "Deseas alimentar el motor con todo lo que puedas?";
	mes "(Solo se puede un máximo de 5 materiales por carga)";
	next;
	menu "Sí señor",-,"Explicame con más detalle",L_Explicar,"No por ahora.",L_Fin;
	if ($WoG_status != 0) {
		mes "[Ingeniero]";
		mes "Por seguridad de la Aeronave y toda la tripulación, no se puede alimentar el motor mientras estemos en vuelo.";
		mes "Vuelve cuando estemos en tierra.";
		close;
	} else if ($@WoG_intruso == 1) {
		mes "[Ingeniero]";
		mes "La aeronave se encuentra en estado de alerta. Lo lamento pero por seguridad, tenemos prohibido el acceso al cuarto de máquinas.";
		close;
	}
	set @Contador, 0;
	set @Combustible, 0;

L_Trunks:
	if ((countitem(1019) >= 1) && ($WoG_Combustible + 1000 <= 200000) && (@Contador < 5)) {
		set @Contador, @Contador + 1;
		set $WoG_Combustible,$WoG_Combustible + 1000;
		set @Combustible,@Combustible + 1000;
		delitem 1019,1;
		goto L_Trunks;
	}

L_Coals:
	if ((countitem(1003) >= 1) && ($WoG_Combustible + 2000 <= 200000) && (@Contador < 5)) {
		set @Contador, @Contador + 1;
		set $WoG_Combustible,$WoG_Combustible + 2000;
		set @Combustible,@Combustible + 2000;
		delitem 1003,1;
		goto L_Coals;
	}

L_LiveCoals:
	if ((countitem(7098) >= 1) && ($WoG_Combustible + 3000 <= 200000) && (@Contador < 5)) {
		set @Contador, @Contador + 1;
		set $WoG_Combustible,$WoG_Combustible + 3000;
		set @Combustible,@Combustible + 3000;
		delitem 7098,1;
		goto L_LiveCoals;
	}

	mes "[Ingeniero]";
	if (@Combustible <= 0) {
		mes "No tenias ningún item para alimentar el motor.";
		mes "Vuelve cuando tengas Trunks, Coals o Life Coals.";
	} else {
		mes "Has dado un total de " + @Combustible + " unidades de combustible al motor.";
		mes "Gracias por tu aporte, sigue disfrutando de la Aeronave.";
		npctalk "Cargando " + @Combustible + " unidades.";
	}

	close;
	
L_Explicar:
	mes "[Ingeniero]";
	mes "En la aeronave ^FF0000Wings of Gaia^000000 puedes recorrer el mundo completo en cuestion de un minuto.";
	mes "Pero mantener una Aeronave como esta no es fácil, ya que requiere combustible.";
	next;
	mes "[Ingeniero]";
	mes "El tanke de la nave tiene una capacidad de 200.000 unidades de combustible, y este se alimenta con Trunks, Coals y Live Coals.";
	mes "Cada Trunk da 1000 unidades, los Coals 2000 unidades y el Live Coal 3000 unidades de gas.";
	next;
	mes "[Ingeniero]";
	mes "Cuando la nave se encuentra sobrevolando una ciudad o mapa, esta consume por 100 unidades de gas por cada 10 segundos.";
	mes "El despegue consume 200 unidades de gas, y un viaje a otro mapa requiere de 600 unidades.";
	next;
	mes "[Ingeniero]";
	mes "Para alimentar de combustible se requiere que la nave esté en tierra, sin importar el mapa... No queremos un incendio.";
	mes "Por último, si quieres dejar la aeronave sola con tanque lleno se puede mantener por aproximadamente 3 horas 30 minutos.";
	close;
	
L_Fin:
	mes "[Ingeniero]";
	mes "En todo caso, recuerda que sin combustible la aeronave no podrá volar.";
	mes "Vuelve cuando quieras";
	close;
}

// Others NPC's
// **** Kafra ****
airwog,100,68,3	script	Kafra Employee::WoG_Kafra	113,{
	cutin "kafra_05",2;
	callfunc "F_KafSetMoc";
	mes "[Kafra Employee]";
	mes "The Kafra Corporation";
	mes "is always working to provide";
	mes "you with convenient services.";
	mes "How may I be of assistance?";
	callfunc "F_Kafra",5,7,0,60,930;

	M_Save:
		savepoint "prontera",124,259;
		callfunc "F_KafEnd",0,1,"in front of the Teleporter, in prontera";
}

// **** Foods ****
airwog,60,74,4	shop	Milk Merchant#WoG	90,519:-1
airwog,55,83,4	shop	Fruit Merchant#WoG	102,512:-1,513:-1
airwog,94,74,2	shop	Butcher#WoG	87,517:-1,528:-1
airwog,79,81,3	duplicate(IceCreamer)	Ice Cream Maker#WoG	85
airwog,90,47,2	shop	Vegetable Gardener#WoG	91,515:-1,516:-1,535:-1
airwog,47,60,6	shop	Food Seller#WoG	83,7455:-1,7456:-1,7452:-1,7482:-1

// **** Weapon and Armors ****
airwog,102,182,1	shop	Weapon Dealer#WoG	54,1750:-1,1751:-1,1701:-1,1201:-1,1204:-1,1207:-1,1601:-1,1101:-1,1104:-1,1107:-1,1110:-1,1113:-1,1122:-1,1119:-1,1123:-1,1126:-1,1157:-1,1129:-1,1116:-1,1301:-1,1771:-1
airwog,103,195,4	shop	Armor Dealer#WoG	48,2101:-1,2103:-1,2401:-1,2403:-1,2501:-1,2503:-1,2220:-1,2226:-1,2301:-1,2303:-1,2305:-1,2328:-1,2307:-1,2309:-1,2312:-1,2314:-1,2627:-1

// **** Tool Dealer ****
airwog,229,41,7	shop	Tool Dealer#WoG	83,1753:-1,501:-1,502:-1,503:-1,504:-1,645:-1,656:-1,657:-1,601:-1,602:-1,611:-1,1065:-1

// **** Inn ****
airwog,75,209,5	script	Inn Maid::WoG_I1	53,{
	mes "[Anna]";
	mes "Bienvenidos al Inn de 'Wings of Gaia'.";
	mes "Como te puedo ayudar?";
	next;
	menu "Tomar un descanzo -> 1000 zeny",Mrent, "Cancelar",Mend;

Mrent:
	mes "[Anna]";
	if($@WoG_access == 0 && ((getcharid(2) != $WoG_guild_id) || ($WoG_guild_id == 0))) {
		// Inn only works for owners of the airplane
		mes "Lo lamento, pero solo atiendo a los dueños de la aeronave.";
		close;
	} else if ($@WoG_intruso == 1) {
		mes "Lo lamento mucho... pero no puedo atenderte ahora, mientras la aeronave se encuentre en estado de alerta.";
		close;
	}
	if(Zeny < 1000){
		mes "Lo lamento, pero el cargo por el servicio";
		mes "es de 1,000 z. Por favor, revisa";
		mes "que tienes suficiente dinero";
		mes "la próxima vez, bien?";
		close;
	}
	set Zeny,Zeny - 1000;
	percentheal 100,100;
	mes "Gracias.";
	mes "Espero que disfrutes";
	mes "de tu descanzo.";
	close2;
	set @WoG_bed, rand(4);
	switch (@WoG_bed) {
		case 0: warp "airwog",78,202; break;
		case 1: warp "airwog",54,202; break;
		case 2: warp "airwog",42,174; break;
		case 3: warp "airwog",42,202; break;
	}
	end;
Mend:
	mes "[Anna]";
	mes "Estoy esperando por un trabajo que hacer.";
	close;
}

// **** Refiner and company ****
airwog,67,216,3	script	Hollengrhen#WoG	85,{
	callfunc "refinemain","Hollengrhen",1;
	end;
}

airwog,61,218,5	script	Vurewell#WoG	86,{
	callfunc "phramain","Vurewell";
	end;
}

airwog,59,211,6	script	Dietrich#WoG	99,{
	callfunc "orimain","Dietrich";
	end;
}

airwog,71,211,2	script	Repairman#WoG	84,{
	callfunc "repairmain","Repairman";
	end;
}

// Sistema de Suministros Obligatorios

airwog,96,55,1	script	Suministros::WoG_Sum	701,{
	mes "^0000FF[Martha]^000000";
	if (!callfunc("get_WoGID")) {
		mes "Lo lamento, no puedo hablar con personas fuera de la guild de Wings of Gaia.";
		mes "...";
		close;
	}
	
	mes "Hola, soy quien maneja las proviciones de la Nave, con lo que los Soldados y Personal de la nave se mantienen durante las semanas.";
	next;
	if ($WoG_Suministros) {
		mes "^0000FF[Martha]^000000";
		mes "Por ahora no tenemos suministros para esta semana. El personal no le agradará enterarse de esto.";
		next;
	}
	mes "^0000FF[Martha]^000000";
	mes "Recuerda que debemos viajar todos los lunes a Alberta, para recoger suministros durante una hora.";
	next;
	mes "^0000FF[Martha]^000000";
	mes "Si no hacemos esto, los soldados trabajarán más lento, y la producción de Tesoros se detendrá.";
	mes "También, posiblemente la tripulación hasta te traicione y permita acceso a Personal no autorizado.";
	next;
	mes "^0000FF[Martha]^000000";
	mes "Para evitar esto, tenemos que viajar a Alberta los Lunes entre 6 a.m. y 6 p.m. y esperar allí 1 hora mientras la nave recarga sus proviciones.";
	close;

OnClock0600:
	if (gettime(4) != 1) end; // Solamente Lunes
	
	mapannounce "airwog","[Wings of Gaia - Día de Proviciones]",1,0x00FF00;
	set $WoG_Suministros, 1;
	
	if ($WoG_status == 0 && $WoG_Cmap == 0)
		goto L_Iniciar; // Autoinicio si ya está en el mapa
	
	end;

OnInit:
OnWoGLanded:
	if ($WoG_Suministros == 1 && $WoG_Cmap == 0 && gettime(4) == 1 && gettime(3) >= 6 && gettime(3) < 18)
		goto L_Iniciar;
	
	end;

L_Iniciar:
	set $@WoG_Retirando, 1; // Retirando suministros, no podrá despegar
	mapannounce "airwog","[Wings of Gaia - Cargando proviciones]",1,0x00FF00;
	mapannounce "alberta","[Wings of Gaia - Cargando proviciones]",1,0x00FF00;
	initnpctimer;
	end;

OnTimer600000:
	mapannounce "airwog","[Wings of Gaia - Cargando proviciones - Faltan 50 minutos]",1,0x00FF00;
	end;
OnTimer1200000:
	mapannounce "airwog","[Wings of Gaia - Cargando proviciones - Faltan 40 minutos]",1,0x00FF00;
	end;
OnTimer1800000:
	mapannounce "airwog","[Wings of Gaia - Cargando proviciones - Faltan 30 minutos]",1,0x00FF00;
	end;
OnTimer2400000:
	mapannounce "airwog","[Wings of Gaia - Cargando proviciones - Faltan 20 minutos]",1,0x00FF00;
	end;
OnTimer3000000:
	mapannounce "airwog","[Wings of Gaia - Cargando proviciones - Faltan 10 minutos]",1,0x00FF00;
	end;

OnTimer3600000:
	set $@WoG_Retirando, 0; // Fin de Entrega
	set $WoG_Suministros, 0; // Ya no requiere suministros
	mapannounce "airwog","[Wings of Gaia - Proviciones cargadas]",1,0x00FF00;
	stopnpctimer;
	end;

}
