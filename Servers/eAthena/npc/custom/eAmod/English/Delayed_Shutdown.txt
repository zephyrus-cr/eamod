//============================================================ 
//= Server Delayed Shutdown Script
//============================================================ 

// Whisp to NPC:Shutdown
// You should whis 2 different thinks:
// - A number, representing the minutes for the server shutdown
// - stop, to stop the shutdown process.


-	script	Shutdown	-1,{
	end;

OnWhisperGlobal:
	if( getgmlevel() < 60 )
		end;
	if( @whispervar0$ == "stop" )
	{
		stopnpctimer;
		announce "-- Server Shutdown canceled by Game Master --",0,0xFFA500;
		end;
	}

	if( set(.Minutes, atoi(@whispervar0$)) <= 0 )
		end; // Direct Shutdown? use @mapexit instead

	initnpctimer;
	announce "-- Server Shutdown in " + .Minutes + " minute(s) --",0,0xFFA500;
	end;

OnTimer60000:
	set .Minutes, .Minutes - 1;
	announce "-- Server Shutdown in " + .Minutes + " minute(s) --",0,0xFFA500;
	if( .Minutes == 1 )
	{
		// Do not restart Timer to announce seconds.
		end;
	}

	initnpctimer; // Keep working
	end;

OnTimer90000:
	announce "-- Server Shutdown in 30 seconds --",0,0xFFA500;
	end;

OnTimer100000:
	announce "-- Server Shutdown in 20 seconds --",0,0xFFA500;
	end;

OnTimer110000:
	announce "-- Server Shutdown in 10 seconds --",0,0xFFA500;
	end;

OnTimer115000:
	announce "-- We will be back soon. Bye bye --",0,0x00BFFF;
	end;

OnTimer120000:
	atcommand "@mapexit";
	end;
}
