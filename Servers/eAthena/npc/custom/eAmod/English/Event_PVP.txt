// ****************************
// * Eventos PVP Terra Online *
// ****************************
2009rwc_03	mapflag	pvp_event	20,20,79,79
2009rwc_03	mapflag	nobranch
2009rwc_03	mapflag	nomemo
2009rwc_03	mapflag	nopenalty
2009rwc_03	mapflag	noreturn
2009rwc_03	mapflag	nosave	SavePoint
2009rwc_03	mapflag	noteleport
2009rwc_03	mapflag	nowarp
2009rwc_03	mapflag	nowarpto
2009rwc_03	mapflag	partylock
2009rwc_03	mapflag	party_max	6

-	script	PVPEvent	-1,{
	end;

OnInit:
OnClock2100:
OnClock2200:
	if( gettime(4) == 4 )
	{
		if( gettime(3) >= 21 && gettime(3) < 22 )
			goto OnStartPVPEvent;
		if( gettime(3) == 22 )
			goto OnStopPvPEvent;
	}
	end;

OnClock2059:
	if( gettime(4) == 4 )
		announce "--- [ PVP Event - One Minute to Start ] ---",8;
	end;

OnClock2159:
	if( gettime(4) == 4 )
		announce "--- [ PVP Event - One Minute to End ] ---",8;
	end;

OnStartPVPEvent:
	killmonsterall "2009rwc_03";
	announce "--- [ PVP Event has Started ] ---",8;
	maprespawnguildid "2009rwc_03",0,3;
	initnpctimer;
	donpcevent "PVPEventMC::OnIniciar";
	donpcevent "PVPEventBI::OnStart";
	deletearray $pvpevent_reward[0],10;
	deletearray $pvpevent_id[0],10;
	deletearray $pvpevent_fame[0],10;
	deletearray $pvpevent_name$[0],10;
	set $pvpevent_count, 0;
	pvpeventstart;
	end;

OnStopPVPEvent:
	killmonsterall "2009rwc_03";
	announce "--- [ PVP Event has Ended ] ---",8;
	stopnpctimer;
	donpcevent "PVPEventMC::OnDetener";
	donpcevent "PVPEventBI::OnStop";
	pvpeventstop;

	// mobevent <map>,<x>,<y>,<fakename>,<mobid>,<size>,<amount>,<teamid>,<showhp>,<increasehp>,<allied>,<noslaves>,<noexpnodrop>,<poringcoins>,<event>
	mobevent "2009rwc_03",39,60,"Earth Chest",1324,0,1,0,0,300000,0,0,1,0,0,0,0,0,"PVPEvent::OnChestA";
	mobevent "2009rwc_03",39,39,"Fire Chest",1324,0,1,0,0,300000,0,0,1,0,0,0,0,0,"PVPEvent::OnChestB";
	mobevent "2009rwc_03",60,39,"Wind Chest",1324,0,1,0,0,300000,0,0,1,0,0,0,0,0,"PVPEvent::OnChestC";
	mobevent "2009rwc_03",60,60,"Water Chest",1324,0,1,0,0,300000,0,0,1,0,0,0,0,0,"PVPEvent::OnChestD";
	mobevent "2009rwc_03",50,50,"Holy Chest",1324,0,1,0,0,500000,0,0,1,0,0,0,0,0,"PVPEvent::OnChestE";
	end;

// Rewards for lastest players on Arena

OnChestA:
	flooritem2xy "2009rwc_03",39,60,14542,30;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,60,13832,30;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,60,14537,30;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,60,504,50;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,60,505,50;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,60,510,75;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,60,547,50;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,60,678,20;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,60,12104,10;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,60,7135,75;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,60,7136,75;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,60,7619,5;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,60,7620,5;
	end;

OnChestB:
	flooritem2xy "2009rwc_03",39,39,14544,30;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,39,13833,30;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,39,12274,30;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,39,504,50;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,39,505,50;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,39,510,75;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,39,547,50;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,39,678,20;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,39,12104,10;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,39,7135,75;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,39,7136,75;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,39,7619,5;
	sleep 1000;
	flooritem2xy "2009rwc_03",39,39,7620,5;
	end;

OnChestC:
	flooritem2xy "2009rwc_03",60,39,13830,30;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,39,14536,30;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,39,12275,30;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,39,504,50;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,39,505,50;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,39,510,75;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,39,547,50;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,39,678,20;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,39,12104,10;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,39,7135,75;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,39,7136,75;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,39,7619,5;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,39,7620,5;
	end;

OnChestD:
	flooritem2xy "2009rwc_03",60,60,13831,30;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,60,14535,30;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,60,12214,10;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,60,504,50;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,60,505,50;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,60,510,75;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,60,547,50;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,60,678,20;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,60,12104,10;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,60,7135,75;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,60,7136,75;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,60,7619,5;
	sleep 1000;
	flooritem2xy "2009rwc_03",60,60,7620,5;
	end;

OnChestE:
	switch(rand(9))
	{
		case 0: flooritem2xy "2009rwc_03",50,50,616,1; break;
		case 1: flooritem2xy "2009rwc_03",50,50,12103,1; break;
		case 2: flooritem2xy "2009rwc_03",50,50,14596,3; break;
		case 3: flooritem2xy "2009rwc_03",50,50,14597,3; break;
		case 4: flooritem2xy "2009rwc_03",50,50,14598,3; break;
		case 5: flooritem2xy "2009rwc_03",50,50,14602,3; break;
		case 6: flooritem2xy "2009rwc_03",50,50,14603,3; break;
		case 7: flooritem2xy "2009rwc_03",50,50,14604,3; break;
		case 8: flooritem2xy "2009rwc_03",50,50,14605,3; break;
	}
	end;

// Creacion de Mob en el centro de la Sala

OnTimer120000:
	stopnpctimer;
	mobevent "2009rwc_03",50,50,"CheckPoint",1288,2,1,0,1,100000,0,0,1,0,0,0,0,0,"PVPEvent::OnControl";
	mapannounce "2009rwc_03", "--- [ New CheckPoint has Appeared ] ---",0,0x9ACD32;
	end;

OnControl:
	if( pvpeventcheck() )
	{
		pvpevent_addpoints 50;
		mapannounce "2009rwc_03", "--- [ CheckPoint Captured by " + strcharinfo(0) + " ] ---",0,0x9ACD32;
		mobevent "2009rwc_03",0,0,"Explosive",1142,1,20,0,0,200000,0,0,1,0,0,0,0,0;
		flooritem2xy "2009rwc_03",50,50,12134,rand(50,100);
		initnpctimer;
	}
	end;
}

// Bonus Items Spawn
-	script	PVPEventBI	-1,{
	end;

OnStart:
	initnpctimer;
	end;

OnTimer60000:
	mobevent "2009rwc_03",rand(20,79),rand(20,79),"Bonus Box",1324,0,1,0,0,50000,0,0,1,0,0,0,0,0,"PVPEventBI::OnBoxKilled";
	initnpctimer; // Restart
	end;

OnBoxKilled:
	pvpevent_addpoints 25;
	flooritem 715,10;
	flooritem 716,10;
	flooritem 717,15;
	switch( rand(8) )
	{
		case 0: flooritem 504,45; break;
		case 1: flooritem 505,25; break;
		case 2: flooritem 510,50; break;
		case 3: flooritem 547,30; break;
		case 4: flooritem 678,5; break;
		case 5: flooritem 12104,2; break;
		case 6: flooritem 7135,15; break;
		case 7: flooritem 7136,15; break;
	}
	end;

OnStop:
	stopnpctimer;
	end;
}

// Reality Controler
-	script	PVPEventMC	-1,{
	end;

OnInit:
	// Mobs ID's y Arrays
	setarray .Reality$[0],"Einbech","Plasma","Ice","Ayothaya","Louyang","Umbala","Niflheim";
	setarray .Real_0_mobs[0],1614,1615,1616,1617,1620,1621,1622;
	setarray .Real_1_mobs[0],1693,1694,1695,1696,1697;
	setarray .Real_2_mobs[0],1775,1775,1776,1776,1777,1778;
	setarray .Real_3_mobs[0],1584,1584,1587,1587,1586,1586;
	setarray .Real_4_mobs[0],1512,1513,1514,1516,1517,1519;
	setarray .Real_5_mobs[0],1493,1495,1497,1498,1499,1500;
	setarray .Real_6_mobs[0],1503,1504,1505,1506,1507,1508,1509,1510;
	end;

OnIniciar:
	initnpctimer;
	end;
OnDetener:
	stopnpctimer;
	end;

OnTimer600000:
	set .@m, rand(getarraysize(.Reality$));
	set .@t, getarraysize(getd(".Real_" + .@m + "_mobs"));
	mapannounce "2009rwc_03", "--- [ Reality Changed - " + .Reality$[.@m] + " ] ---",0,0x008000;

	for( set .@i, 0; .@i < .@t; set .@i, .@i + 1 )
	{
		set .@j, getd(".Real_" + .@m + "_mobs[" + .@i + "]");
		mobevent "2009rwc_03",0,0,"--ja--",.@j,0,1,0,1,0,0,0,1,0,0,0,0,0,"PVPEventMC::OnMonster";
	}
	
	if( pvpeventcheck() )
		initnpctimer;
	end;

OnMonster:
	pvpevent_addpoints 25;
	end;
}
