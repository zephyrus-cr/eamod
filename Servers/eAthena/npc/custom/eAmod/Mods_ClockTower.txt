// Clock Tower

aldebaran,0,0,0	script	ControlReloj	-1,{
	end;

OnInit:
	if( gettime(3) >= 7 && gettime(3) < 19 )
		day;
	else
		night;
	end;

OnClock0000:
OnClock0100:
OnClock0200:
OnClock0300:
OnClock0400:
OnClock0500:
OnClock0600:
OnClock0700:
OnClock0800:
OnClock0900:
OnClock1000:
OnClock1100:
	set .Sufijo$, "a.m.";
	goto L_Bells;
	end;

OnClock1200:
OnClock1300:
OnClock1400:
OnClock1500:
OnClock1600:
OnClock1700:
OnClock1800:
OnClock1900:
OnClock2000:
OnClock2100:
OnClock2200:
OnClock2300:
	set .Sufijo$, "p.m.";
	goto L_Bells;
	end;
	
L_Bells:
	set .Count, 0;
	set .Hour, gettime(3);

	if( .Hour == 7 ) day;
	if( .Hour == 19 ) night;
	
	if( .Hour > 12 ) set .NHour, .Hour - 12;
	else if( .Hour == 0 ) set .NHour, 12;
	else set .NHour, .Hour;
	
	announce "[Aldebaran Clock Tower - " + .NHour + " " + .Sufijo$ + "]",0,0x00CCFF;
	initnpctimer;
	end;

OnTimer1000:
OnTimer3000:
OnTimer5000:
OnTimer7000:
OnTimer9000:
OnTimer11000:
OnTimer13000:
OnTimer15000:
OnTimer17000:
OnTimer19000:
OnTimer21000:
OnTimer23000:
	soundeffectall "effect\\ef_angelus.wav",0,"prontera";
	soundeffectall "effect\\ef_angelus.wav",0,"morocc";
	soundeffectall "effect\\ef_angelus.wav",0,"payon";
	soundeffectall "effect\\ef_angelus.wav",0,"aldebaran";
	soundeffectall "effect\\ef_angelus.wav",0,"geffen";
	soundeffectall "effect\\ef_angelus.wav",0,"izlude";

	set .Count, .Count + 1;
	if( .Count >= .NHour )
	{
		stopnpctimer;
		set .Count, 0;
	}

	end;
}
