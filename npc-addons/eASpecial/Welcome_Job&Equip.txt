// This is a sample NPC. Allow a new character (novice 1/1) to enter a Class Selection and Basic and Bounded Equip Builder Services
// Great for High Rates or WoE Oriented Servers.

// Starting Class Selection NPC

new_1-1,58,108,0	script	Chronos Girl#job1	831,{
	mes "[^FFA500Chronos Girl^000000]";
	mes "Hi!, Welcome to Chronos, " + strcharinfo(0) + ".";
	mes "I am Chronos Girl, nice to meet you.";
	next;
	mes "[^FFA500Chronos Girl^000000]";
	mes "You will see me in every city, I am the manager of all the ^0000FFSpecial High Rates Services^000000.";
	next;
	mes "[^FFA500Chronos Girl^000000]";
	mes "Starting from here, my First Service for you is grant you a Class Convertion.";
	mes "Yeah!, you can become what you want here, without going as a Novice to the World.";
	next;
	mes "[^FFA500Chronos Girl^000000]";
	mes "Requisites are simple:";
	mes "- You must be a 1/1 Novice.";
	mes "- Only you can Convert 1 Character per account.";
	next;
	mes "[^FFA500Chronos Girl^000000]";
	mes "Are you interested?";
	mes "I can take you to a most private zone to proceed with the Class Convertion.";
	next;
	if( select("Yeah, sounds great:No thanks, I will take the normal way") == 2 )
	{
		mes "[^FFA500Chronos Girl^000000]";
		mes "Ok, I understand you like to take it normally.";
		mes "Well, see you in the World and Welcome!";
		close;
	}

	if( BaseLevel > 1 || JobLevel > 1 || Class != Job_Novice || #WelcomeBonus != 0 )
	{
		mes "[^FFA500Chronos Girl^000000]";
		mes "I am sorry, you do not meet all requeriments.";
		close;
	}

	warp "new_1-1",176,81;
	end;
}

new_1-1,176,85,4	script	Chronos Girl#job2	831,{
	mes "[^FFA500Chronos Girl^000000]";
	mes "Hello again!";
	mes "Tell me, what service do you need?";
	next;
	switch( select("Class Convertion:Equipment Building:Go to the World") )
	{
	case 1:
		mes "[^FFA500Chronos Girl^000000]";
		mes "Are you ready to choose your Class?";
		mes "Remember this service is only ^0000FF1 time per account^000000.";
		mes "So I hope you are sure about your choice.";
		next;

		if( BaseLevel > 1 || JobLevel > 1 || Class != Job_Novice )
		{
			mes "I am sorry, this service is for Novice Class with base level 1 and job level 1";
			close;
		}

		if( #WelcomeBonus != 0 )
		{
			mes "[^FFA500Chronos Girl^000000]";
			mes "Oh wait... You do not meet all requeriments.";
			mes "I am sorry you should not be here.";
			close;
		}

		mes "[^FFA500Chronos Girl^000000]";
		mes "Ok let me show you the Class Menu.";
		mes "It's sorted in Groups, where you can find Second, Advanced, Expanded and Baby Classes.";
		mes "So, check all the list first";
		next;

		if( getarraysize(.Classes) <= 0 )
			donpcevent "Chronos Girl#job2::OnInit";

		set .@Job, select(.Menu$) - 1;

		mes "[^FFA500Chronos Girl^000000]";
		mes "You choose ^0000FF" + jobname(.Classes[.@Job]) + "^000000.";
		mes "Please, think about it. Next button will be available in 10 seconds.";
		sleep2 10000;
		mes "Are you sure about your choise?";
		next;
		if( select("^0000FFYes, i am sure^000000:No, sorry... I will choose another Class.") == 2 )
		{
			mes "[^FFA500Chronos Girl^000000]";
			mes "Ok, take your time and think about it.";
			close;
		}

		if( (.Classes[.@Job] == Job_Bard || .Classes[.@Job] == Job_Clown || .Classes[.@Job] == Job_Baby_Bard) && Sex == 0 )
		{
			mes "[^FFA500Chronos Girl^000000]";
			mes "The selected class is not available for your gender.";
			close;
		}
		if( (.Classes[.@Job] == Job_Dancer || .Classes[.@Job] == Job_Gypsy || .Classes[.@Job] == Job_Baby_Dancer) && Sex == 1 )
		{
			mes "[^FFA500Chronos Girl^000000]";
			mes "The selected class is not available for your gender.";
			close;
		}

		mes "[^FFA500Chronos Girl^000000]";
		mes "Now let me do the Magic, you will become a ^0000FF" + jobname(.Classes[.@Job]) + "^000000.";
		next;

		// Convertion Process
		// =========================================================

		if( .Classes[.@Job] >= Job_Lord_Knight && .Classes[.@Job] <= Job_Paladin2 )
			atcommand "@job 4001"; // High Novice
		else if( .Classes[.@Job] >= Job_Baby_Knight && .Classes[.@Job] <= Job_Super_Baby )
			atcommand "@job 4023"; // Baby Novice
		else
			atcommand "@job 0"; // Novice

		atcommand "@reset";
		atcommand "@joblevel 9";
		atcommand "@baselevel 98";

		switch( .Classes[.@Job] )
		{
		// ****************
		// * Baby Classes *
		// ****************
		case Job_Baby_Knight:
			atcommand "@job 4024";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 144,1,0;
			skill 145,1,0;
			skill 146,1,0;
			atcommand "@job 4030";
			atcommand "@joblevel 49";
			skill 1001,1,0;
			break;
		case Job_Baby_Priest:
			atcommand "@job 4027";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 156,1,0;
			atcommand "@job 4031";
			atcommand "@joblevel 49";
			skill 1014,1,0;
			break;
		case Job_Baby_Wizard:
			atcommand "@job 4025";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 157,1,0;
			atcommand "@job 4032";
			atcommand "@joblevel 49";
			skill 1006,1,0;
			break;
		case Job_Baby_Blacksmith:
			atcommand "@job 4028";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 153,1,0;
			skill 154,1,0;
			skill 155,1,0;
			atcommand "@job 4033";
			atcommand "@joblevel 49";
			skill 1012,1,0;
			skill 1013,1,0;
			break;
		case Job_Baby_Hunter:
			atcommand "@job 4026";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 147,1,0;
			skill 148,1,0;
			atcommand "@job 4034";
			atcommand "@joblevel 49";
			skill 1009,1,0;
			break;
		case Job_Baby_Assassin:
			atcommand "@job 4029";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 149,1,0;
			skill 150,1,0;
			skill 151,1,0;
			skill 152,1,0;
			atcommand "@job 4035";
			atcommand "@joblevel 49";
			skill 1003,1,0;
			skill 1004,1,0;
			break;
		case Job_Baby_Crusader:
			atcommand "@job 4024";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 144,1,0;
			skill 145,1,0;
			skill 146,1,0;
			atcommand "@job 4037";
			atcommand "@joblevel 49";
			skill 1002,1,0;
			break;
		case Job_Baby_Monk:
			atcommand "@job 4027";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 156,1,0;
			atcommand "@job 4038";
			atcommand "@joblevel 49";
			skill 1015,1,0;
			skill 1016,1,0;
			break;
		case Job_Baby_Sage:
			atcommand "@job 4025";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 157,1,0;
			atcommand "@job 4039";
			atcommand "@joblevel 49";
			skill 1007,1,0;
			break;
		case Job_Baby_Rogue:
			atcommand "@job 4029";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 149,1,0;
			skill 150,1,0;
			skill 151,1,0;
			skill 152,1,0;
			atcommand "@job 4040";
			atcommand "@joblevel 49";
			skill 1005,1,0;
			break;
		case Job_Baby_Alchemist:
			atcommand "@job 4028";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 153,1,0;
			skill 154,1,0;
			skill 155,1,0;
			atcommand "@job 4041";
			atcommand "@joblevel 49";
			skill 238,1,0;
			break;
		case Job_Baby_Bard:
			atcommand "@job 4026";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 147,1,0;
			skill 148,1,0;
			atcommand "@job 4042";
			atcommand "@joblevel 49";
			skill 1010,1,0;
			break;
		case Job_Baby_Dancer:
			atcommand "@job 4026";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 147,1,0;
			skill 148,1,0;
			atcommand "@job 4043";
			atcommand "@joblevel 49";
			skill 1011,1,0;
			break;
		// ******************
		// * Second Classes *
		// ******************
		case Job_Knight:
			atcommand "@job 1";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 144,1,0;
			skill 145,1,0;
			skill 146,1,0;
			atcommand "@job 7";
			atcommand "@joblevel 49";
			skill 1001,1,0;
			break;
		case Job_Priest:
			atcommand "@job 4";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 156,1,0;
			atcommand "@job 8";
			atcommand "@joblevel 49";
			skill 1014,1,0;
			break;
		case Job_Wizard:
			atcommand "@job 2";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 157,1,0;
			atcommand "@job 9";
			atcommand "@joblevel 49";
			skill 1006,1,0;
			break;
		case Job_Blacksmith:
			atcommand "@job 5";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 153,1,0;
			skill 154,1,0;
			skill 155,1,0;
			atcommand "@job 10";
			atcommand "@joblevel 49";
			skill 1012,1,0;
			skill 1013,1,0;
			break;
		case Job_Hunter:
			atcommand "@job 3";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 147,1,0;
			skill 148,1,0;
			atcommand "@job 11";
			atcommand "@joblevel 49";
			skill 1009,1,0;
			break;
		case Job_Assassin:
			atcommand "@job 6";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 149,1,0;
			skill 150,1,0;
			skill 151,1,0;
			skill 152,1,0;
			atcommand "@job 12";
			atcommand "@joblevel 49";
			skill 1003,1,0;
			skill 1004,1,0;
			break;
		case Job_Crusader:
			atcommand "@job 1";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 144,1,0;
			skill 145,1,0;
			skill 146,1,0;
			atcommand "@job 14";
			atcommand "@joblevel 49";
			skill 1002,1,0;
			break;
		case Job_Monk:
			atcommand "@job 4";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 156,1,0;
			atcommand "@job 15";
			atcommand "@joblevel 49";
			skill 1015,1,0;
			skill 1016,1,0;
			break;
		case Job_Sage:
			atcommand "@job 2";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 157,1,0;
			atcommand "@job 16";
			atcommand "@joblevel 49";
			skill 1007,1,0;
			break;
		case Job_Rogue:
			atcommand "@job 6";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 149,1,0;
			skill 150,1,0;
			skill 151,1,0;
			skill 152,1,0;
			atcommand "@job 17";
			atcommand "@joblevel 49";
			skill 1005,1,0;
			break;
		case Job_Alchemist:
			atcommand "@job 5";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 153,1,0;
			skill 154,1,0;
			skill 155,1,0;
			atcommand "@job 18";
			atcommand "@joblevel 49";
			skill 238,1,0;
			break;
		case Job_Bard:
			atcommand "@job 3";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 147,1,0;
			skill 148,1,0;
			atcommand "@job 19";
			atcommand "@joblevel 49";
			skill 1010,1,0;
			break;
		case Job_Dancer:
			atcommand "@job 3";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 147,1,0;
			skill 148,1,0;
			atcommand "@job 20";
			atcommand "@joblevel 49";
			skill 1011,1,0;
			break;
		// ********************
		// * Advanced Classes *
		// ********************
		case Job_Lord_Knight:
		case Job_Lord_Knight2:
			atcommand "@job 4002";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 144,1,0;
			skill 145,1,0;
			skill 146,1,0;
			atcommand "@job 4008";
			atcommand "@joblevel 69";
			skill 1001,1,0;
			break;
		case Job_High_Priest:
			atcommand "@job 4005";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 156,1,0;
			atcommand "@job 4009";
			atcommand "@joblevel 69";
			skill 1014,1,0;
			break;
		case Job_High_Wizard:
			atcommand "@job 4003";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 157,1,0;
			atcommand "@job 4010";
			atcommand "@joblevel 69";
			skill 1006,1,0;
			break;
		case Job_Whitesmith:
			atcommand "@job 4006";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 153,1,0;
			skill 154,1,0;
			skill 155,1,0;
			atcommand "@job 4011";
			atcommand "@joblevel 69";
			skill 1012,1,0;
			skill 1013,1,0;
			break;
		case Job_Sniper:
			atcommand "@job 4004";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 147,1,0;
			skill 148,1,0;
			atcommand "@job 4012";
			atcommand "@joblevel 69";
			skill 1009,1,0;
			break;
		case Job_Assassin_Cross:
			atcommand "@job 4007";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 149,1,0;
			skill 150,1,0;
			skill 151,1,0;
			skill 152,1,0;
			atcommand "@job 4013";
			atcommand "@joblevel 69";
			skill 1003,1,0;
			skill 1004,1,0;
			break;
		case Job_Paladin:
		case Job_Paladin2:
			atcommand "@job 4002";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 144,1,0;
			skill 145,1,0;
			skill 146,1,0;
			atcommand "@job 4015";
			atcommand "@joblevel 69";
			skill 1002,1,0;
			break;
		case Job_Champion:
			atcommand "@job 4005";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 156,1,0;
			atcommand "@job 4016";
			atcommand "@joblevel 69";
			skill 1015,1,0;
			skill 1016,1,0;
			break;
		case Job_Professor:
			atcommand "@job 4003";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 157,1,0;
			atcommand "@job 4017";
			atcommand "@joblevel 69";
			skill 1007,1,0;
			break;
		case Job_Stalker:
			atcommand "@job 4007";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 149,1,0;
			skill 150,1,0;
			skill 151,1,0;
			skill 152,1,0;
			atcommand "@job 4018";
			atcommand "@joblevel 69";
			skill 1005,1,0;
			break;
		case Job_Creator:
			atcommand "@job 4006";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 153,1,0;
			skill 154,1,0;
			skill 155,1,0;
			atcommand "@job 4019";
			atcommand "@joblevel 69";
			skill 238,1,0;
			break;
		case Job_Clown:
			atcommand "@job 4004";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 147,1,0;
			skill 148,1,0;
			atcommand "@job 4020";
			atcommand "@joblevel 69";
			skill 1010,1,0;
			break;
		case Job_Gypsy:
			atcommand "@job 4004";
			atcommand "@joblevel 49";
			skill 142,1,0;
			skill 147,1,0;
			skill 148,1,0;
			atcommand "@job 4021";
			atcommand "@joblevel 69";
			skill 1011,1,0;
			break;
		// *******************
		// * Expanded Classes *
		// *******************
		case Job_Star_Gladiator:
			atcommand "@job 4046";
			atcommand "@joblevel 49";
			atcommand "@job 4047";
			atcommand "@joblevel 49";
			break;
		case Job_Soul_Linker:
			atcommand "@job 4046";
			atcommand "@joblevel 49";
			atcommand "@job 4049";
			atcommand "@joblevel 49";
			break;
		case Job_Gunslinger:
			atcommand "@job 24";
			atcommand "@joblevel 49";
			break;
		case Job_Ninja:
			atcommand "@job 25";
			atcommand "@joblevel 49";
			break;
		case Job_Taekwon:
			atcommand "@job 4046";
			atcommand "@joblevel 49";
			break;
		}

		set #WelcomeBonus, getcharid(0);
		// =========================================================

		mes "[^FFA500Chronos Girl^000000]";
		mes "Ok, Class service is done.";
		mes "Talk to me again, to work on your Equipment.";
		close;
	case 2:
		if( #WelcomeBonus == 0 )
		{
			mes "[^FFA500Chronos Girl^000000]";
			mes "I am sorry, to request Equipment you need first to use the Class Convertion service.";
			close;
		}
		else if( #WelcomeBonus != getcharid(0) )
		{
			mes "[^FFA500Chronos Girl^000000]";
			mes "This is not the Character in your game account set to use this bonus service.";
			close;
		}

		mes "[^FFA500Chronos Girl^000000]";
		mes "Remember, in the next menu, the first number is your current builds, and the second the max you can build per option.";
		mes "So, what do you want to build?";
		next;

		cleararray .@Items[0],0,127;
		cleararray .@Cards[0],0,127;
		set .@Build, select("HeadGears (" + Welcome_H + "/2):Garments (" + Welcome_G + "/2):Armors (" + Welcome_Ar + "/2):Footgear (" + Welcome_F + "/2):Accesories (" + Welcome_Ac + "/4):Shields (" + Welcome_S + "/2):Weapons (" + Welcome_W + "/3)");
		switch( .@Build )
		{
		case 1: // Headgears
			if( Welcome_H > 1 )
			{
				mes "[^FFA500Chronos Girl^000000]";
				mes "You already have received 2 headgears. Sorry!!";
				close;
			}
		
			setarray .@Items[0],5170,5165,2285,5122,5123;
			setarray .@Cards[0],4412,4411,4223,4269;
			break;

		case 2: // Garment
			if( Welcome_G > 1 )
			{
				mes "[^FFA500Chronos Girl^000000]";
				mes "You already have received 2 garments. Sorry!!";
				close;
			}
		
			setarray .@Items[0],2528,2517,2518;
			setarray .@Cards[0],4133,4334,4095,4109;
			break;

		case 3: // Armors
			if( Welcome_Ar > 1 )
			{
				mes "[^FFA500Chronos Girl^000000]";
				mes "You already have received 2 armors. Sorry!!";
				close;
			}
		
			setarray .@Items[0],2353,2365,2322,2367,2318,2336,2366;
			setarray .@Cards[0],4105,4141,4099,4089,4337;
			break;

		case 4: // FootGears
			if( Welcome_F > 1 )
			{
				mes "[^FFA500Chronos Girl^000000]";
				mes "You already have received 2 footgears. Sorry!!";
				close;
			}
		
			setarray .@Items[0],2424,2417,2418;
			setarray .@Cards[0],4097,4107,4381;
			break;

		case 5: // Accesorys
			if( Welcome_Ac > 3 )
			{
				mes "[^FFA500Chronos Girl^000000]";
				mes "You already have received 4 accesories. Sorry!!";
				close;
			}
		
			setarray .@Items[0],2624,2622,2621,2623,2625,2626;
			setarray .@Cards[0],4356,4044,4064,4079,4252;
			break;

		case 6: // Shield
			if( Welcome_S > 1 )
			{
				mes "[^FFA500Chronos Girl^000000]";
				mes "You already have received 2 shields. Sorry!!";
				close;
			}
		
			setarray .@Items[0],2115,2124,2123,2114;
			setarray .@Cards[0],4058,4045,4439,4136;
			break;

		case 7: // Weapons
			if( Welcome_W > 2 )
			{
				mes "[^FFA500Chronos Girl^000000]";
				mes "You already have received 3 weapons. Sorry!!";
				close;
			}

			mes "[^FFA500Chronos Girl^000000]";
			mes "What kind of weapon do you want to build?";
			next;
			switch( select("Axes:Spears:Swords:Book:Bow:Dagger:Fist:Katar:Maces:Instruments/Whips:Staff:Guns:Shurikens") )
			{
			case 1: // Axes
				setarray .@Items[0],1366,1387,1371,1363;
				break;
			case 2: // Spears
				setarray .@Items[0],1408,1471,1420,1422;
				break;
			case 3: // Swords
				setarray .@Items[0],1128,1133,1131;
				break;
			case 4: // Books
				setarray .@Items[0],1564,1557,1555,1553,1554,1556;
				break;
			case 5: // Bow
				setarray .@Items[0],1716,1705,1734;
				break;
			case 6: // Dagger
				setarray .@Items[0],1208,1231,1232,13011;
				break;
			case 7: // Fist
				setarray .@Items[0],1807,1814,1819,1818;
				break;
			case 8: // Katar
				setarray .@Items[0],1261,1251,1259,1270,1265;
				break;
			case 9: // Maces
				setarray .@Items[0],1544,1525,1528;
				break;
			case 10: // Instruments
				setarray .@Items[0],1902,1920,1925,1910,1951,1980,1979;
				break;
			case 11: // Staffs
				setarray .@Items[0],1602,1625,1624,1626,1618,1620;
				break;
			case 12: // Guns
				setarray .@Items[0],13150,13161,13153,13170,13107,13169;
				break;
			case 13: // Shurikens
				setarray .@Items[0],13302,13303,13304;
				break;
			}
			
			setarray .@Cards[0],4002,4072,4004,4035,4452,4076,4017,4024,4026,4082,4085;
			break;
		}

		// Build Item
		set .@MenuI$, "";
		set .@Sepa$, "";
		for( set .@i, 0; .@Items[.@i] != 0; set .@i, .@i + 1 )
		{
			if( getiteminfo(.@Items[.@i], 10) > 0 )
				set .@MenuI$, .@MenuI$ + .@Sepa$ + getitemname(.@Items[.@i]) + "[" + getiteminfo(.@Items[.@i], 10) + "]";
			else
				set .@MenuI$, .@MenuI$ + .@Sepa$ + getitemname(.@Items[.@i]);
			set .@Sepa$, ":";
		}

		set .@Item, select(.@MenuI$) - 1;
		setarray .@Card[0], 0, 0, 0, 0;

		if( !checkweight(.@Items[.@Item], 1) )
		{
			mes "[^FFA500Chronos Girl^000000]";
			mes "You cannot hold this weapons because of weight limits on your character. Please free some weight.";
			close;
		}

		if( !getitemisequipable(.@Items[.@Item]) )
		{
			mes "[^FFA500Chronos Girl^000000]";
			mes "This items cannot be used by your class.";
			close;
		}

		set .@MenuC$, "";
		set .@Sepa$, "";
		for( set .@i, 0; .@Cards[.@i] != 0; set .@i, .@i + 1 )
		{
			set .@MenuC$, .@MenuC$ + .@Sepa$ + getitemname(.@Cards[.@i]);
			set .@Sepa$, ":";
		}

		for( set .@i, 0; .@i < getiteminfo(.@Items[.@Item], 10); set .@i, .@i + 1 )
		{ // Cards
			mes "[^FFA500Chronos Girl^000000]";
			mes "Please, choose a card for slot [" + (.@i + 1) + "]";
			next;
			set .@Card[.@i], .@Cards[select(.@MenuC$) - 1];
		}

		mes "[^FFA500Chronos Girl^000000]";
		mes "You want to build a : ^0000FF" + getitemname(.@Items[.@Item]) + "^000000.";

		set .@Refine, 0;
		if( getitemisrefinable(.@Items[.@Item]) )
		{
			switch( getiteminfo(.@Items[.@Item], 13) )
			{
			case 0: set .@Refine, 7; break;
			case 1: set .@Refine, 10; break;
			case 2: set .@Refine, 7; break;
			case 3: set .@Refine, 6; break;
			case 4: set .@Refine, 5; break;
			}
		}

		mes "It will receive a ^0000FF" + .@Refine + "^000000 refine.";
		for( set .@i, 0; .@i < getiteminfo(.@Items[.@Item], 10); set .@i, .@i + 1 )
		{ // Info de Cards
			mes "Card on slot [" + (.@i + 1) + "] ^0000FF" + getitemname(.@Card[.@i]) + "^000000";
		}

		mes "Is this ok?";
		next;
		if( select("Yes, give me the item.:No, i will try another build...") == 1 )
		{
			mes "[^FFA500Chronos Girl^000000]";
			mes "Here is your item.";
			itembound2 .@Items[.@Item],1,1,.@Refine,0,.@Card[0],.@Card[1],.@Card[2],.@Card[3];

			switch( .@Build )
			{
				case 1: set Welcome_H,  Welcome_H + 1;  break;
				case 2: set Welcome_G,  Welcome_G + 1;  break;
				case 3: set Welcome_Ar, Welcome_Ar + 1; break;
				case 4: set Welcome_F,  Welcome_F + 1;  break;
				case 5: set Welcome_Ac, Welcome_Ac + 1; break;
				case 6: set Welcome_S,  Welcome_S + 1;  break;
				case 7: set Welcome_W,  Welcome_W + 1;  break;
			}
		}
		else
		{
			mes "[^FFA500Chronos Girl^000000]";
			mes "No items received.";
		}
		close;

	case 3:
		mes "[^FFA500Chronos Girl^000000]";
		mes "Once you return to the World of Ragnarok, you cannot return here again!";
		next;
		mes "[^FFA500Chronos Girl^000000]";
		mes "Are you ready? Did you build all your equipment and class selection?";
		next;
		if( select("Yes, return to Ragnarok:No, I will stay here a while") == 2 )
		{
			mes "[^FFA500Chronos Girl^000000]";
			mes "Fine, talk to me again if you need another service.";
			close;
		}
		
		mes "[^FFA500Chronos Girl^000000]";
		mes "Ok, my service is done.";
		mes "Now let warp you to the World.";
		mes "See you soon!";
		close2;

		// Remove unneeded variables
		set Welcome_H, 0;
		set Welcome_G, 0;
		set Welcome_Ar, 0;
		set Welcome_F, 0;
		set Welcome_Ac, 0;
		set Welcome_S, 0;
		set Welcome_W, 0;

		savepoint "prontera",142,168;
		warp "prontera",142,168;
		end;
	}

OnInit:
	setarray .Classes[0]
	// Second Class
		,Job_Knight,Job_Priest,Job_Wizard,Job_Blacksmith,Job_Hunter,Job_Assassin,Job_Crusader,Job_Monk,Job_Sage,Job_Rogue,Job_Alchemist,Job_Bard,Job_Dancer
	// Advanced
		,Job_Lord_Knight,Job_High_Priest,Job_High_Wizard,Job_Whitesmith,Job_Sniper,Job_Assassin_Cross,Job_Paladin,Job_Champion,Job_Professor,Job_Stalker,Job_Creator,Job_Clown,Job_Gypsy
	// Expanded Class
		,Job_Gunslinger,Job_Ninja,Job_Taekwon,Job_Star_Gladiator,Job_Soul_Linker
	// Baby Second Class
		,Job_Baby_Knight,Job_Baby_Priest,Job_Baby_Wizard,Job_Baby_Blacksmith,Job_Baby_Hunter,Job_Baby_Assassin,Job_Baby_Crusader,Job_Baby_Monk,Job_Baby_Sage,Job_Baby_Rogue,Job_Baby_Alchemist,Job_Baby_Bard,Job_Baby_Dancer
	;

	set .@Limit, getarraysize(.Classes);
	set .Menu$, "";
	for( set .@i, 0; .@i < .@Limit; set .@i, .@i + 1 )
		set .Menu$, .Menu$ + jobname(.Classes[.@i]) + ":";
	end;
}
