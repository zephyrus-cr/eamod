// Special Treasure Box Summon
// ================================================================
// How To Use: Whisp to NPC:DoTreasure the amount of HP the Treasure box
// will have. As a result, a treasure box will appears in your exact location.
// When a player kill it, a rain of items (potions, foods, some materials for skills)
// will start.

-	script	DoTreasure	-1,{
	end;

OnWhisperGlobal:
	if( getgmlevel() < 60 )
		end;
	
	if( set(.@Hp,atoi(@whispervar0$)) <= 0 )
		end;

	getmapxy .@m$, .@x, .@y, 0; // Game Master Position
	mobevent .@m$, .@x, .@y, "Treasure Chest", 1324, 0, 1, 0, 0, .@Hp, 0, 0, 1, 0, 0, 0, 0, 0, "DoTreasure::OnTreasureOpen";
	end;

OnTreasureOpen:
	// Stores Current x/y of the killed monster
	getmapxy .@m$, .@x, .@y, 0;
	set .@x, @killedx;
	set .@y, @killedy;

	// Start Area Drop process
	flooritem2xy .@m$,.@x,.@y,505,50;
	sleep 1000;
	flooritem2xy .@m$,.@x,.@y,510,75;
	sleep 1000;
	flooritem2xy .@m$,.@x,.@y,547,50;
	sleep 1000;
	flooritem2xy .@m$,.@x,.@y,678,10;
	sleep 1000;
	flooritem2xy .@m$,.@x,.@y,12104,10;
	sleep 1000;
	flooritem2xy .@m$,.@x,.@y,7135,50;
	sleep 1000;
	flooritem2xy .@m$,.@x,.@y,7136,50;
	sleep 1000;
	flooritem2xy .@m$,.@x,.@y,7137 + rand(3),50; // Random Other Alchemist material
	sleep 1000;
	flooritem2xy .@m$,.@x,.@y,7619 + rand(2),3; // Random Elu/Ori Enriched
	sleep 1000;
	flooritem2xy .@m$,.@x,.@y,12202 + rand(6),5; // Random Food
	sleep 1000;
	switch( rand(4) )
	{
	case 0:
		flooritem2xy .@m$,.@x,.@y,14542,30;
		sleep 1000;
		flooritem2xy .@m$,.@x,.@y,13832,30;
		sleep 1000;
		flooritem2xy .@m$,.@x,.@y,14537,30;
		break;
	case 1:
		flooritem2xy .@m$,.@x,.@y,14544,30;
		sleep 1000;
		flooritem2xy .@m$,.@x,.@y,13833,30;
		sleep 1000;
		flooritem2xy .@m$,.@x,.@y,12274,30;
		break;
	case 2:
		flooritem2xy .@m$,.@x,.@y,13830,30;
		sleep 1000;
		flooritem2xy .@m$,.@x,.@y,14536,30;
		sleep 1000;
		flooritem2xy .@m$,.@x,.@y,12275,30;
		break;
	case 3:
		flooritem2xy .@m$,.@x,.@y,13831,30;
		sleep 1000;
		flooritem2xy .@m$,.@x,.@y,14535,30;
		sleep 1000;
		flooritem2xy .@m$,.@x,.@y,12214,10;
		break;
	}
	end;
}
