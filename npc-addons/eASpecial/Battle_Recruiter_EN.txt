// Kapra Teleport Function ==================================================================

2009rwc_03,7,47,0	script	Click to Jump#1	802,{
	getmapxy .@map$, .@cx, .@cy, 0; // Current Char Position
	getmapxy .@mapn$, .@cxn, .@cyn, 1; // Current NPC Position
	set .@x1, .@cxn - 3;
	set .@x2, .@cxn + 3;
	set .@y1, .@cyn - 3;
	set .@y2, .@cyn + 3;
	if( .@cx < .@x1 || .@cx > .@x2 || .@cy < .@y1 || .@cy > .@y2 )
		end;
	warp "2009rwc_03",90,49;
	end;
}

2009rwc_03,92,52,0	script	Click to Jump#2	802,{
	getmapxy .@map$, .@cx, .@cy, 0; // Current Char Position
	getmapxy .@mapn$, .@cxn, .@cyn, 1; // Current NPC Position
	set .@x1, .@cxn - 3;
	set .@x2, .@cxn + 3;
	set .@y1, .@cyn - 3;
	set .@y2, .@cyn + 3;
	if( .@cx < .@x1 || .@cx > .@x2 || .@cy < .@y1 || .@cy > .@y2 )
		end;
	warp "2009rwc_03",9,50;
	end;
}

-	script	PVP_Warper	-1,{
	mes "[^FFA500Battle Recruiter^000000]";
	mes "Good day, adventurer.";
	mes "Are you looking for battle?";
	next;
	set @ArenaPVP_out, atoi(strnpcinfo(2));
	switch( select("-- ^0000FFJoin BattleGround Waiting Room^000000 --",
		       "-- ^FFA500Join PVP Event Arena^000000 --",
		       "^000080[" + (getmapusers("guild_vs1")) + " users] ^4169E1PvP Arena 1",
		       "^000080[" + (getmapusers("guild_vs2")) + " users] ^4169E1PvP Arena 2",
		       "^000080[" + (getmapusers("guild_vs3")) + " users] ^4169E1PvP Arena 3",
		       "^000080[" + (getmapusers("2009rwc_01")) + " users] ^4169E1PvP Arena 4",
		       "^000080[" + (getmapusers("2009rwc_02")) + " users] ^4169E1PvP Arena 5 ^FFA500(Ancient)",
		       "^8B0000[" + (getmapusers("guild_vs4")) + " users] ^FF0000GvG Arena 1",
		       "^8B0000[" + (getmapusers("guild_vs5")) + " users] ^FF0000GvG Arena 2",
		       "^8B0000[" + (getmapusers("2009rwc_04")) + " users] ^FF0000GvG Arena 3 ^FFA500(Ancient)",
		       "-- ^FFA500Join Event Arena^000000 --") )
	{
		case 1: // Battleground info Board
			if( $@FlaviusCTF == 1 )
				mes "^A0522DFlavious CTF^000000 * ^FF0000(" + bg_get_data($@FlaviusCTF_id2, 0) + ")^000000 vs ^0000FF(" + bg_get_data($@FlaviusCTF_id1, 0) + ")^000000";
			else
				mes "^A0522DFlavious CTF^000000 * ^808080idle^000000";
			if( $@FlaviusTD == 1 )
				mes "^808000Flavious TD^000000 * ^FF0000(" + bg_get_data($@FlaviusTD_id2, 0) + ")^000000 vs ^0000FF(" + bg_get_data($@FlaviusTD_id1, 0) + ")^000000";
			else
				mes "^808000Flavious TD^000000 * ^808080idle^000000";
			if( $@FlaviusSC == 1 )
				mes "^9ACD32Flavious SC^000000 * ^FF0000(" + bg_get_data($@FlaviusSC_id2, 0) + ")^000000 vs ^0000FF(" + bg_get_data($@FlaviusSC_id1, 0) + ")^000000";
			else
				mes "^9ACD32Flavious SC^000000 * ^808080idle^000000";
			if( $@TierraEOS == 1 )
				mes "^4169E1Tierra EoS^000000 * ^FF0000(" + bg_get_data($@TierraEOS_id2, 0) + ")^000000 vs ^0000FF(" + bg_get_data($@TierraEOS_id1, 0) + ")^000000";
			else
				mes "^4169E1Tierra EoS^000000 * ^808080idle^000000";
			if( $@TierraBoss == 1 )
				mes "^483D8BTierra Boss^000000 * ^FF0000(" + bg_get_data($@TierraBoss_id2, 0) + ")^000000 vs ^0000FF(" + bg_get_data($@TierraBoss_id1, 0) + ")^000000";
			else
				mes "^483D8BTierra Boss^000000 * ^808080idle^000000";
			if( $@TierraTI == 1 )
				mes "^696969Tierra TI^000000 * ^008000(" + bg_get_data($@TierraTI_id3, 0) + ")^000000 vs ^FF0000(" + bg_get_data($@TierraTI_id2, 0) + ")^000000 vs ^0000FF(" + bg_get_data($@TierraTI_id1, 0) + ")^000000";
			else
				mes "^696969Tierra TI^000000 * ^808080idle^000000";
			if( $@Conquest == 1 )
				mes "^FFA500Conquest^000000 * ^FF0000(" + bg_get_data($@Conquest_id2, 0) + ")^000000 vs ^0000FF(" + bg_get_data($@Conquest_id1, 0) + ")^000000";
			else
				mes "^FFA500Conquest^000000 * ^808080idle^000000";
			next;

			if( bg_logincount() > 0 )
			{
				mes "[^FFA500Battle Recruiter^000000]";
				mes "Double Login is forbidden in Battlegrounds Maps";
				close;
			}

			warp "bat_room",155,150;
			set $@AnnouncePVPArena$, "Battleground Room";
			break;

		case 2: mes "[^FFA500Battle Recruiter^000000]";
			mes "Standings:";
			for( set .@i, 0; .@i < $pvpevent_count; set .@i, .@i + 1 )
				mes "(" + (.@i + 1) + ") - ^4169E1" + $pvpevent_name$[.@i] + "^000000 [" + $pvpevent_fame[.@i] + "]";
			next;
			switch( select("^000080[" + (getmapusers("2009rwc_03")) + " users] ^4169E1Enter Event","Information","^FF0000Get my rewards^000000") )
			{
				case 1: if( pvpeventcheck() == 0 )
					{
						mes "[^FFA500Battle Recruiter^000000]";
						mes "I am sorry, there is no PvP Event at this time.";
						mes "Check my information if you need help.";
						close;
					}

					mes "[^FFA500Battle Recruiter^000000]";
					mes "Please choose your entering point.";
					mes "Remember, only a maximum of 6 members of the same party can enter the map.";
					mes "If more players try to join, they will be send to their respawn point.";
					
					set .@i, select("[<] Left","[>] Right");
					if( pvpeventcheck() == 0 )
					{
						mes "[^FFA500Battle Recruiter^000000]";
						mes "I am sorry, the PvP Event is over.";
						close;
					}

					switch( .@i )
					{
						case 1: warp "2009rwc_03",9,50; break;
						case 2: warp "2009rwc_03",90,49; break;
					}

					break;

				case 2: mes "[^FFA500Battle Recruiter^000000]";
					mes "You can join PVP Event Arena every ^0000FFFriday, starting at 8p.m. and ending at 9p.m^000000.";
					next;
					mes "[^FFA500Battle Recruiter^000000]";
					mes "This is a PvP arena where players can win Items and Cash Points by playing and killing other players.";
					mes "You can join the battle alone or in a maximum of 6 members party";
					next;
					mes "[^FFA500Battle Recruiter^000000]";
					mes "Also there is a Top 10 Fame List of this event.";
					mes "To increase your points and enter this list, you need to kill others players, monsters and boxes without leaving the Arena.";
					mes "Your party members will share you points if they kill players too.";
					next;
					mes "[^FFA500Battle Recruiter^000000]";
					mes "If you get into the Top 10 list at the end of the event, you can come to me and reclaim your Reward.";
					mes "The 1st place will receive ^0000FF2.500 Kafra Points^000000.";
					mes "The 2nd place will receive ^0000FF2.000 Kafra Points^000000.";
					mes "Each next place will receive -250 Kafra Points, until 10th.";
					next;
					mes "[^FFA500Battle Recruiter^000000]";
					mes "Prepare yourself and your friends, come and participate. We will wait for you.";
					close;

				case 3: mes "[^FFA500Battle Recruiter^000000]";
					mes "Are you on the Top 10 PVP Event Fame List of this week?";
					mes "Let me see...";
					next;
					if( pvpeventcheck() )
					{
						mes "[^FFA500Battle Recruiter^000000]";
						mes "I am sorry, but you need to wait until PvP Event is over...";
						close;
					}

					for( set .@i, 0; .@i < $pvpevent_count; set .@i, .@i + 1 )
					{
						if( $pvpevent_id[.@i] == getcharid(0) )
						{ // Found in the Top 10
							mes "[^FFA500Battle Recruiter^000000]";
							mes "Congratulations, you are on the Top 10 PvP Event Fame List of this week at position " + (.@i + 1) + "!!";

							if( $pvpevent_reward[.@i] )
								mes "But... i have already give you the reward.";
							else
							{
								set $pvpevent_reward[.@i], 1;
								set .@reward, (10 - .@i) * 250;
								set #KAFRAPOINTS, #KAFRAPOINTS + .@reward;
								mes "Here is your reward of ^0000FF" + .@reward + " Kafra Points^000000.";
							}
							close;
						}
					}

					mes "[^FFA500Battle Recruiter^000000]";
					mes "Mmm...";
					mes "I am sorry but you are not on the Top 10 List of this week.";
					close;
			}
			break;

		case 3: switch( rand(4) )
			{
				case 0: warp "guild_vs1",7,50; break;
				case 1: warp "guild_vs1",50,92; break;
				case 2: warp "guild_vs1",50,7; break;
				case 3: warp "guild_vs1",91,50; break;
			}
			set $@AnnouncePVPArena$, "PvP Arena 1";
			break;

		case 4:	switch( rand(4) )
			{
				case 0: warp "guild_vs2",7,50; break;
				case 1: warp "guild_vs2",50,92; break;
				case 2: warp "guild_vs2",50,7; break;
				case 3: warp "guild_vs2",91,50; break;
			}
			set $@AnnouncePVPArena$, "PvP Arena 2";
			break;

		case 5:	switch( rand(4) )
			{
				case 0: warp "guild_vs3",14,51; break;
				case 1: warp "guild_vs3",85,51; break;
				case 2: warp "guild_vs3",51,14; break;
				case 3: warp "guild_vs3",49,85; break;
			}
			set $@AnnouncePVPArena$, "PvP Arena 3";
			break;

		case 6:	switch( rand(2) )
			{
				case 0: warp "2009rwc_01",87,50; break;
				case 1: warp "2009rwc_01",12,49; break;
			}
			set $@AnnouncePVPArena$, "PvP Arena 4";
			break;

		case 7:	// Ancient PVP
			if( !class2ancientwoe() )
			{
				mes "[^FFA500Battle Recruiter^000000]";
				mes "I am sorry, but this Arena is only for Ancient Class.";
				close;
			}

			switch( rand(2) )
			{
				case 0: warp "2009rwc_02",7,50; break;
				case 1: warp "2009rwc_02",92,49; break;
			}
			set $@AnnouncePVPArena$, "PvP Arena 5";
			break;

		case 8:	switch( rand(4) )
			{
				case 0: warp "guild_vs4",8,49; break;
				case 1: warp "guild_vs4",91,49; break;
				case 2: warp "guild_vs4",49,91; break;
				case 3: warp "guild_vs4",49,8; break;
			}
			set $@AnnouncePVPArena$, "GvG Arena 1";
			break;

		case 9:	switch( rand(4) )
			{
				case 0: warp "guild_vs5",22,50; break;
				case 1: warp "guild_vs5",49,75; break;
				case 2: warp "guild_vs5",79,49; break;
				case 3: warp "guild_vs5",49,24; break;
			}
			set $@AnnouncePVPArena$, "GvG Arena 2";
			break;
		
		case 10: // GvG Ancient
			if( !class2ancientwoe() )
			{
				mes "[^FFA500Battle Recruiter^000000]";
				mes "I am sorry, but this Arena is only for Ancient Class.";
				close;
			}
		
			switch( rand(2) )
			{
				case 0: warp "2009rwc_04",7,49; break;
				case 1: warp "2009rwc_04",92,50; break;
			}
			set $@AnnouncePVPArena$, "GvG Arena 3";
			break;

		case 11: // Event Arena
			if( .TClasses == 0 ) donpcevent "PVP_Warper::OnInit"; // Load Starting settings
			if( getgmlevel() > 1 )
			{ // Game Master Options
				mes "[^FFA500Battle Recruiter^000000]";
				mes "Hi Game Master, do you want to configure the Event Warper?";
				next;
				if( select("Go to Configuration:Go to Normal Menu") == 1 )
				{
					while( 1 )
					{
						mes "[^FFA500Karol^000000]";
						mes "What do you want to configure?";
						next;
						switch( select("Enable Warper:Disable Warper:Set Event Map:Class Restrictions:Sex Restrictions:Close") )
						{
						case 1:
							mes "[^FFA500Battle Recruiter^000000]";
							mes "The Event is currently Enable.";
							set .Event, 1;
							next;
							break;
						case 2:
							mes "[^FFA500Battle Recruiter^000000]";
							mes "The Event is currently Disable.";
							set .Event, 0;
							next;
							break;
						case 3:
							mes "[^FFA500Battle Recruiter^000000]";
							mes "Please choose the Destiny Map.";
							next;
							set .@Menu$, "";
							for( set .@i, 0; .@i < getarraysize(.Destiny$); set .@i, .@i + 1 )
								set .@Menu$, .@Menu$ + .Destiny$[.@i] + ":";

							set .Destiny, select(.@Menu$) - 1;
							mes "[^FFA500Battle Recruiter^000000]";
							mes "Destiny changed to " + .Destiny$[.Destiny] + ".";
							next;
							break;
						case 4:
							mes "[^FFA500Battle Recruiter^000000]";
							mes "Double Click the Class you want to Enable/Disable for the event.";
							mes "To finish, click on close";
							next;

							while( 1 )
							{
								// Build Currenty Menu
								set .@Menu$, "";
								for( set .@i, 0; .@i < .TClasses; set .@i, .@i + 1 )
								{
									if( .BlockClass[.@i] )
										set .@Menu$, .@Menu$ + "[-] ^FF0000" + jobname(.Classes[.@i]) + "^000000:";
									else
										set .@Menu$, .@Menu$ + "[+] ^0000FF" + jobname(.Classes[.@i]) + "^000000:";
								}

								set .@Menu$, .@Menu$ + "^FFA500Allow All Classes^000000:^FFA500Block All Classes^000000";

								set .@Class, select(.@Menu$) - 1;
								if( .@Class == .TClasses + 1 )
									cleararray .BlockClass[0],1,.TClasses;
								else if( .@Class == .TClasses )
									cleararray .BlockClass[0],0,.TClasses;
								else if( .BlockClass[.@Class] )
									set .BlockClass[.@Class], 0;
								else
									set .BlockClass[.@Class], 1;
							}
							end;
						case 5:
							mes "[^FFA500Battle Recruiter^000000]";
							mes "Please select the event restriction for sex.";
							next;
							set .Sex, select("Only for Girls","Only for Boys","Allow Both Sexs") - 1;

							mes "[^FFA500Battle Recruiter^000000]";
							mes "Sex restriction changed.";
							next;
							break;
						case 6:
							mes "[^FFA500Battle Recruiter^000000]";
							mes "Good day, Game Master.";
							close;
						}
					}
				}
			}

			if( .Event == 0 )
			{
				mes "[^FFA500Battle Recruiter^000000]";
				mes "Hi, i am here to warp users to special events maps.";
				mes "Sorry, right now there is no event.";
				close;
			}

			mes "[^FFA500Battle Recruiter^000000]";
			mes "Hi, there is an Special Event right now, do you want to join it?";
			next;
			if( select("Yes, i want to go to the event!","No thanks.") == 2 )
			{
				mes "[^FFA500Battle Recruiter^000000]";
				mes "Ok... see ya!.";
				close;
			}

			if( .Sex != 2 && .Sex != Sex )
			{
				mes "[^FFA500Battle Recruiter^000000]";
				mes "I am sorry, but this event is not for your sex.";
				close;
			}

			for( set .@i, 0; .@i < .TClasses; set .@i, .@i + 1 )
			{
				if( .Classes[.@i] == Class )
					break;
			}

			if( .@i == .TClasses )
			{
				mes "[^FFA500Battle Recruiter^000000]";
				mes "There is an error on this Script. Please report it to the Game Master.";
				close;
			}

			if( .BlockClass[.@i] == 1 )
			{
				mes "[^FFA500Battle Recruiter^000000]";
				mes "I am sorry, this event is not for " + jobname(Class) + ".";
				close;
			}

			switch( .Destiny )
			{
			case 0: warp "bat_a05",353,344; break;
			case 1: warp "bat_b05",311,223; break;
			}
			end;			
	}

	set $@AnnouncePVPName$, strcharinfo(0);
	donpcevent "::OnAnnouncePVP";
	end;

OnInit:
	if( strnpcinfo(3) != "PVP_Warper" )
		end;

	set .Event, 0; // Event Disable
	setarray .Destiny$[0],"bat_a05","bat_b05";
	setarray .Classes[0],
		Job_Novice,
		Job_Swordman,Job_Mage,Job_Archer,Job_Acolyte,Job_Merchant,Job_Thief,
		Job_Knight,Job_Priest,Job_Wizard,Job_Blacksmith,Job_Hunter,Job_Assassin,
		Job_Crusader,Job_Monk,Job_Sage,Job_Rogue,Job_Alchem,Job_Bard,Job_Dancer,
		Job_SuperNovice,
		Job_Gunslinger,Job_Ninja,
		Job_Novice_High,
		Job_Swordman_High,
		Job_Mage_High,Job_Archer_High,Job_Acolyte_High,Job_Merchant_High,Job_Thief_High,
		Job_Lord_Knight,Job_High_Priest,Job_High_Wizard,Job_Whitesmith,Job_Sniper,Job_Assassin_Cross,
		Job_Paladin,Job_Champion,Job_Professor,Job_Stalker,Job_Creator,Job_Clown,Job_Gypsy,
		Job_Baby,
		Job_Baby_Swordman,Job_Baby_Mage,Job_Baby_Archer,Job_Baby_Acolyte,Job_Baby_Merchant,Job_Baby_Thief,
		Job_Baby_Knight,Job_Baby_Priest,Job_Baby_Wizard,Job_Baby_Blacksmith,Job_Baby_Hunter,Job_Baby_Assassin,
		Job_Baby_Crusader,Job_Baby_Monk,Job_Baby_Sage,Job_Baby_Rogue,Job_Baby_Alchem,Job_Baby_Bard,Job_Baby_Dancer,
		Job_Super_Baby,
		Job_Taekwon,Job_Star_Gladiator,Job_Soul_Linker;

	deletearray .BlockClass[0],127;
	set .TClasses, getarraysize(.Classes);
	set .Destiny, 0; // Event Destiny Warp
	set .Sex, 2; // Allow Both Sexs
	end;

OnAnnouncePVP:
	if( strnpcinfo(3) == "PVP_Warper" )
		end;
	emotion e_go;
	// npctalk "" + $@AnnouncePVPName$ + " is entering " + $@AnnouncePVPArena$ + "";
	end;
}

-	script	PVP_Warper_Out	-1,{
	mes "[^FFA500Battle Support^000000]";
	mes "Good day, adventurer.";
	mes "Do you want to leave the Battle?";
	
	if( select("^0000FFBack to the City:^FF0000I will stay to the end!!^000000") == 2 )
	{
		mes "That's the spirit of a True Warrior!!";
		close;
	}

	getmapxy .@map$, .@cx, .@cy, 0; // Current Char Position
	getmapxy .@mapn$, .@cxn, .@cyn, 1; // Current NPC Position
			
	set .@x1, .@cxn - 2;
	set .@x2, .@cxn + 2;
	set .@y1, .@cyn - 2;
	set .@y2, .@cyn + 2;
	if( .@cx < .@x1 || .@cx > .@x2 || .@cy < .@y1 || .@cy > .@y2 )
	{
		mes "Please come closer...";
		mes "I can't take you out of the battle.";
		close;
	}

	npctalk "" + strcharinfo(0) + " is leaving the battlefield";

	switch( @ArenaPVP_out )
	{
		// Rune Midgard Republic
		case 2: warp "payon",165,98; break;
		case 3: warp "morocc",153,94; break;
		case 4: warp "umbala",121,143; break;
		case 5: warp "comodo",196,140; break;
		case 6: warp "niflheim",214,193; break;
		case 7: warp "aldebaran",143,111; break;
		case 8: warp "geffen",107,53; break;
		// Schwarzard Republic
		case 9: warp "yuno",151,177; break;
		case 10: warp "hugel",99,143; break;
		case 11: warp "lighthalzen",167,93; break;
		case 12: warp "einbroch",70,194; break;
		case 13: warp "einbech",168,130; break;
		// Arunafelz Republic
		case 14: warp "rachel",118,114; break;
		case 15: warp "veins",207,122; break;
		// Islands
		case 16: warp "nameless_n",161,179; break;
		case 17: warp "louyang",213,106; break;
		case 18: warp "gonryun",154,111; break;
		case 19: warp "ayothaya",197,179; break;
		case 20: warp "moscovia",229,195; break;
		case 21: warp "xmas",151,127; break;
		case 22: warp "amatsu",203,107; break;
		case 23: warp "izlude",126,114; break;
		case 24: warp "brasilis",195,211; break;
		case 25: warp "manuk",279,214; break;
		case 26: warp "splendide",200,174; break;

		default: warp "prontera",149,92; break;
	}
	
	set @ArenaPVP_out, 0;
	end;
}

//============================= Entradas =======================================

prontera,146,92,5	duplicate(PVP_Warper)	Battle Recruiter#1	728
payon,165,98,6	duplicate(PVP_Warper)	Battle Recruiter#2	728
morocc,153,97,3	duplicate(PVP_Warper)	Battle Recruiter#3	728
umbala,118,146,3	duplicate(PVP_Warper)	Battle Recruiter#4	728
comodo,193,137,7	duplicate(PVP_Warper)	Battle Recruiter#5	728
niflheim,211,190,7	duplicate(PVP_Warper)	Battle Recruiter#6	728
aldebaran,146,111,2	duplicate(PVP_Warper)	Battle Recruiter#7	728
geffen,104,56,5	duplicate(PVP_Warper)	Battle Recruiter#8	728
yuno,148,180,5	duplicate(PVP_Warper)	Battle Recruiter#9	728
hugel,102,143,2	duplicate(PVP_Warper)	Battle Recruiter#10	728
lighthalzen,170,90,1	duplicate(PVP_Warper)	Battle Recruiter#11	728
einbroch,73,191,1	duplicate(PVP_Warper)	Battle Recruiter#12	728
einbech,165,130,6	duplicate(PVP_Warper)	Battle Recruiter#13	728
rachel,115,111,6	duplicate(PVP_Warper)	Battle Recruiter#14	728
veins,210,119,1	duplicate(PVP_Warper)	Battle Recruiter#15	728
nameless_n,158,179,6	duplicate(PVP_Warper)	Battle Recruiter#16	728
louyang,213,109,4	duplicate(PVP_Warper)	Battle Recruiter#17	728
gonryun,151,111,6	duplicate(PVP_Warper)	Battle Recruiter#18	728
ayothaya,194,176,6	duplicate(PVP_Warper)	Battle Recruiter#19	728
moscovia,232,198,3	duplicate(PVP_Warper)	Battle Recruiter#20	728
xmas,154,127,2	duplicate(PVP_Warper)	Battle Recruiter#21	728
amatsu,206,104,1	duplicate(PVP_Warper)	Battle Recruiter#22	728
izlude,126,118,5	duplicate(PVP_Warper)	Battle Recruiter#23	728
brasilis,193,211,6	duplicate(PVP_Warper)	Battle Recruiter#24	728

manuk,282,214,2	duplicate(PVP_Warper)	Battle Recruiter#25	728
splendide,200,177,4	duplicate(PVP_Warper)	Battle Recruiter#26	728

//============================= Salidas =======================================

guild_vs1,31,68,5	duplicate(PVP_Warper_Out)	Battle Support#1	413
guild_vs1,68,31,1	duplicate(PVP_Warper_Out)	Battle Support#2	417
guild_vs2,35,64,5	duplicate(PVP_Warper_Out)	Battle Support#3	413
guild_vs2,64,35,1	duplicate(PVP_Warper_Out)	Battle Support#4	417
guild_vs3,30,69,5	duplicate(PVP_Warper_Out)	Battle Support#5	413
guild_vs3,69,30,1	duplicate(PVP_Warper_Out)	Battle Support#6	417
guild_vs4,31,68,5	duplicate(PVP_Warper_Out)	Battle Support#7	413
guild_vs4,68,31,1	duplicate(PVP_Warper_Out)	Battle Support#8	417
guild_vs5,31,66,5	duplicate(PVP_Warper_Out)	Battle Support#9	413
guild_vs5,64,32,1	duplicate(PVP_Warper_Out)	Battle Support#10	417
2009rwc_03,7,52,5	duplicate(PVP_Warper_Out)	Battle Support#11	417
2009rwc_03,92,47,3	duplicate(PVP_Warper_Out)	Battle Support#12	413
2009rwc_01,17,53,3	duplicate(PVP_Warper_Out)	Battle Support#17	417
2009rwc_01,82,46,7	duplicate(PVP_Warper_Out)	Battle Support#18	413
2009rwc_02,14,54,3	duplicate(PVP_Warper_Out)	Battle Support#19	417
2009rwc_02,85,45,7	duplicate(PVP_Warper_Out)	Battle Support#20	413
2009rwc_04,11,53,3	duplicate(PVP_Warper_Out)	Battle Support#21	417
2009rwc_04,88,46,7	duplicate(PVP_Warper_Out)	Battle Support#22	413

//============================= Mapflags =======================================

guild_vs1	mapflag	nopenalty
guild_vs1	mapflag	nosave	SavePoint
guild_vs1	mapflag	nowarp
guild_vs1	mapflag	noteleport
guild_vs1	mapflag	nomemo
guild_vs1	mapflag	pvp
guild_vs1	mapflag	loadevent
guild_vs1	mapflag	noreturn
guild_vs1	mapflag	nobranch
guild_vs1	mapflag	pvp_noguild

guild_vs2	mapflag	nopenalty
guild_vs2	mapflag	nosave	SavePoint
guild_vs2	mapflag	nowarp
guild_vs2	mapflag	noteleport
guild_vs2	mapflag	nomemo
guild_vs2	mapflag	pvp
guild_vs2	mapflag	loadevent
guild_vs2	mapflag	noreturn
guild_vs2	mapflag	nobranch
guild_vs2	mapflag	pvp_noguild

guild_vs3	mapflag	nopenalty
guild_vs3	mapflag	nosave	SavePoint
guild_vs3	mapflag	nowarp
guild_vs3	mapflag	noteleport
guild_vs3	mapflag	nomemo
guild_vs3	mapflag	pvp
guild_vs3	mapflag	loadevent
guild_vs3	mapflag	noreturn
guild_vs2	mapflag	nobranch
guild_vs3	mapflag	pvp_noguild

2009rwc_01	mapflag	nopenalty
2009rwc_01	mapflag	nosave	SavePoint
2009rwc_01	mapflag	nowarp
2009rwc_01	mapflag	noteleport
2009rwc_01	mapflag	nomemo
2009rwc_01	mapflag	pvp
2009rwc_01	mapflag	loadevent
2009rwc_01	mapflag	noreturn
2009rwc_01	mapflag	nobranch
2009rwc_01	mapflag	pvp_noguild

2009rwc_02	mapflag	nopenalty
2009rwc_02	mapflag	nosave	SavePoint
2009rwc_02	mapflag	nowarp
2009rwc_02	mapflag	noteleport
2009rwc_02	mapflag	nomemo
2009rwc_02	mapflag	pvp
2009rwc_02	mapflag	loadevent
2009rwc_02	mapflag	noreturn
2009rwc_02	mapflag	nobranch
2009rwc_02	mapflag	pvp_noguild
2009rwc_02	mapflag	ancient

guild_vs4	mapflag	nopenalty
guild_vs4	mapflag	nosave	SavePoint
guild_vs4	mapflag	nowarp
guild_vs4	mapflag	noteleport
guild_vs4	mapflag	nomemo
guild_vs4	mapflag	gvg
guild_vs4	mapflag	loadevent
guild_vs4	mapflag	noreturn
guild_vs4	mapflag	nobranch
guild_vs4	mapflag	noicewall

guild_vs5	mapflag	nopenalty
guild_vs5	mapflag	nosave	SavePoint
guild_vs5	mapflag	nowarp
guild_vs5	mapflag	noteleport
guild_vs5	mapflag	nomemo
guild_vs5	mapflag	gvg
guild_vs5	mapflag	loadevent
guild_vs5	mapflag	noreturn
guild_vs5	mapflag	nobranch
guild_vs5	mapflag	gvg_noalliance
guild_vs5	mapflag	noicewall

2009rwc_04	mapflag	nopenalty
2009rwc_04	mapflag	nosave	SavePoint
2009rwc_04	mapflag	nowarp
2009rwc_04	mapflag	noteleport
2009rwc_04	mapflag	nomemo
2009rwc_04	mapflag	gvg
2009rwc_04	mapflag	loadevent
2009rwc_04	mapflag	noreturn
2009rwc_04	mapflag	nobranch
2009rwc_04	mapflag	gvg_noalliance
2009rwc_04	mapflag	noicewall
2009rwc_04	mapflag	ancient

//============================= Event Warper Exit =======================================

bat_a05,353,54,0	duplicate(PVP_Warper_Out)	Battle Support#13	413
bat_b05,87,75,7	duplicate(PVP_Warper_Out)	Battle Support#14	413

//============================= Event Warper Mapflags =======================================

bat_a05	mapflag	allowks
bat_a05	mapflag	nomemo
bat_a05	mapflag	nowarp
bat_a05	mapflag	nowarpto
bat_a05	mapflag	nobranch
bat_a05	mapflag	nopenalty
bat_a05	mapflag	noteleport
bat_a05	mapflag	nosave	SavePoint
bat_a05	mapflag	monster_noteleport

bat_b05	mapflag	allowks
bat_b05	mapflag	nomemo
bat_b05	mapflag	nowarp
bat_b05	mapflag	nowarpto
bat_b05	mapflag	nobranch
bat_b05	mapflag	nopenalty
bat_b05	mapflag	noteleport
bat_b05	mapflag	nosave	SavePoint
bat_b05	mapflag	monster_noteleport