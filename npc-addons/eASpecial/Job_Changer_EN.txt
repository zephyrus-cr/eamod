// Reward Exchanges

-	shop	Renewal_Shop	-1,7931:1000,6124:2500,12341:10000,12734:1000

prontera,149,192,4	script	Helper	831,{
	mes "[^FFA500 Aluna ^000000]";
	mes "I hope you're enjoying your stay in our servers Lyk Ragnarok Online.";
	mes "What I can do for you?";
	next;
	switch( select("Reset Skills:Reset Stats:Reset Both:Job Change Renewal:Renewal Shop") )
	{
	case 1: // Reset Skills
		mes "[^FFA500Aluna^000000]";
		mes "The cost of the Skills ^0000FFReset de Skills^000000 zeny is 50,000. To do this you must not exceed 1000 weight in your inventory and not bring Pecopeco, Falcon or truck.";
		next;
		if( select("Proceed with reset","No thanks..") == 2 )
		{
			mes "[^FFA500Aluna^000000]";
			mes "Come back when you need some special service.";
			close;
		}

		if( Zeny < 50000 )
		{
			mes "[^FFA500Aluna^000000]";
			mes "You do not bring enough Zeny you, sorry..";
			close;
		}

		if( Weight > 10000 )
		{
			mes "[^FFA500Aluna^000000]";
			mes "I need to reset your skills that do not exceed more than 1000 items of weight with you, so leave some things in Storage and returns.";
			close;
		}

		if( checkriding() || checkfalcon() || checkcart() )
		{
			mes "[^FFA500Aluna^000000]";
			mes "Reset Skills required to come without Car / PecoPeco / Falcon. remove them and talk again.";
			close;
		}

		sc_end SC_ALL;
		resetskill;
		set Zeny, Zeny - 50000;

		mes "[^FFA500Aluna^000000]";
		mes "Your skills have been reset, think about your options. Luck!!";
		close;
	case 2:
		mes "[^FFA500Aluna^000000]";
		mes "The cost for ^0000FFReset de Stats^000000 zeny is 50,000. To do this you must not exceed 1000 weight in your inventory.";
		next;
		if( select("Proceed with reset","No thanks...") == 2 )
		{
			mes "[^FFA500Aluna^000000]";
			mes "Come back when you need some special service.";
			close;
		}

		if( Zeny < 50000 )
		{
			mes "[^FFA500Aluna^000000]";
			mes "You do not bring enough Zeny you, sorry.";
			close;
		}

		if( Weight > 10000 )
		{
			mes "[^FFA500Aluna^000000]";
			mes "I need to reset your stats that do not exceed more than 1000 items of weight with you, so leave some things in Storage and returns.";
			close;
		}

		sc_end SC_ALL;
		resetstatus;
		set Zeny, Zeny - 50000;

		mes "[^FFA500Aluna^000000]";
		mes "Your stats have been reset, think about your options. Luck!!";
		close;
	case 3:
		mes "[^FFA500Aluna^000000]";
		mes "The cost of the ^0000FFReset de Skills y Stats^000000 is 75,000 zeny. To do this you must not exceed more than 1000 weight and not bring Pecopeco, Falcon or truck.";
		mes "Solamente te puedo hacer un reset total si no te has hecho reset de skills o stats en las ultimas 2 horas.";
		next;
		if( select("Proceed with reset","No thanks...") == 2 )
		{
			mes "[^FFA500Aluna^000000]";
			mes "Come back when you need some special service.";
			close;
		}

		if( Zeny < 75000 )
		{
			mes "[^FFA500Aluna^000000]";
			mes "You do not bring enough Zeny you, sorry.";
			close;
		}

		if( Weight > 10000 )
		{
			mes "[^FFA500Aluna^000000]";
			mes "To reset your skills and stats need not overdo over 1000 items weight with you, so leave some things in Storage and returns.";
			close;
		}

		if( checkriding() || checkfalcon() || checkcart() )
		{
			mes "[^FFA500Gaia Girl^000000]";
			mes "Reset Skills required to come without Car / PecoPeco / Falcon. remove them and talk again..";
			close;
		}

		sc_end SC_ALL;
		resetskill;
		resetstatus;
		set Zeny, Zeny - 75000;

		mes "[^FFA500Aluna^000000]";
		mes "Your skills and stats have been reset, think about your options. Luck!!";
		close;
	case 5: // Renewal Shop
		mes "[^FFA500Aluna^000000]";
		mes "Close this window to access the Renewal Store where you materials required.";
		close2;
		callshop "Renewal_Shop",1;
		end;
	case 4: // Renewal Job Change
		if( checkriding() || checkfalcon() || checkcart() )
		{
			mes "[^FFA500Aluna^000000]";
			mes "In order to proceed with this service and see if you reborn, you must take your Pecopoco / Falco / Truck";
			close;
		}
		if( SkillPoint != 0 )
		{
			mes "[^FFA500Aluna^000000]";
			mes "You need to use all your skill points before career change.";
			mes "Come back soon!!.";
			close;
		}
		if( BaseLevel < 99 )
		{
			mes "[^FFA500Aluna^000000]";
			mes "Your next career change can be processed when you are level 99 base..";
			close;
		}

		set .@target_job, 0;
		if( Class >= Job_Knight && Class <= Job_Crusader2 )
		{ // Comming from Second Class
			if( JobLevel < 50 )
			{
				mes "[^FFA500Aluna^000000]";
				mes "Your next career change can be processed when you are level 99/50.";
				close;
			}

			switch( Class )
			{
			case Job_Knight:		set .@target_job, Job_Rune_Knight; break;
			case Job_Priest:		set .@target_job, Job_Arch_Bishop; break;
			case Job_Wizard:		set .@target_job, Job_Warlock; break;
			case Job_Blacksmith:		set .@target_job, Job_Mechanic; break;
			case Job_Hunter:		set .@target_job, Job_Ranger; break;
			case Job_Assassin:		set .@target_job, Job_Guillotine_Cross; break;
			case Job_Crusader:		set .@target_job, Job_Royal_Guard; break;
			case Job_Monk:			set .@target_job, Job_Sura; break;
			case Job_Sage:			set .@target_job, Job_Sorcerer; break;
			case Job_Rogue:			set .@target_job, Job_Shadow_Chaser; break;
			case Job_Alchemist:		set .@target_job, Job_Genetic; break;
			case Job_Bard:			set .@target_job, Job_Minstrel; break;
			case Job_Dancer:		set .@target_job, Job_Wanderer; break;
			}
		}
		else if( Class >= Job_Lord_Knight && Class <= Job_Paladin2 )
		{ // Comming from Advanced
			if( JobLevel < 50 )
			{
				mes "[^FFA500Aluna^000000]";
				mes "Your next career change can be processed when you are level 99/70.";
				close;
			}

			switch( Class )
			{
			case Job_Lord_Knight:		set .@target_job, Job_Rune_Knight_T; break;
			case Job_High_Priest:		set .@target_job, Job_Arch_Bishop_T; break;
			case Job_High_Wizard:		set .@target_job, Job_Warlock_T; break;
			case Job_Whitesmith:		set .@target_job, Job_Mechanic_T; break;
			case Job_Sniper:		set .@target_job, Job_Ranger_T; break;
			case Job_Assassin_Cross:	set .@target_job, Job_Guillotine_Cross_T; break;
			case Job_Paladin:		set .@target_job, Job_Royal_Guard_T; break;
			case Job_Champion:		set .@target_job, Job_Sura_T; break;
			case Job_Professor:		set .@target_job, Job_Sorcerer_T; break;
			case Job_Stalker:		set .@target_job, Job_Shadow_Chaser_T; break;
			case Job_Creator:		set .@target_job, Job_Genetic_T; break;
			case Job_Clown:			set .@target_job, Job_Minstrel_T; break;
			case Job_Gypsy:			set .@target_job, Job_Wanderer_T; break;
			}
		}
		else if( Class >= Job_Baby_Knight && Class <= Job_Baby_Crusader2 )
		{ // Comming from Baby Classes
			if( JobLevel < 50 )
			{
				mes "[^FFA500Aluna^000000]";
				mes "Your next career change can be processed when you are level 99/50.";
				close;
			}

			switch( Class )
			{
			case Job_Baby_Knight:		set .@target_job, Job_Baby_Rune; break;
			case Job_Baby_Priest:		set .@target_job, Job_Baby_Bishop; break;
			case Job_Baby_Wizard:		set .@target_job, Job_Baby_Warlock; break;
			case Job_Baby_Blacksmith:	set .@target_job, Job_Baby_Mechanic; break;
			case Job_Baby_Hunter:		set .@target_job, Job_Baby_Ranger; break;
			case Job_Baby_Assassin:		set .@target_job, Job_Baby_Cross; break;
			case Job_Baby_Crusader:		set .@target_job, Job_Baby_Guard; break;
			case Job_Baby_Monk:		set .@target_job, Job_Baby_Sura; break;
			case Job_Baby_Sage:		set .@target_job, Job_Baby_Sorcerer; break;
			case Job_Baby_Rogue:		set .@target_job, Job_Baby_Chaser; break;
			case Job_Baby_Alchemist:	set .@target_job, Job_Baby_Genetic; break;
			case Job_Baby_Bard:		set .@target_job, Job_Baby_Minstrel; break;
			case Job_Baby_Dancer:		set .@target_job, Job_Baby_Wanderer; break;
			}
		}

		if( .@target_job == 0 )
		{
			mes "[^FFA500Aluna^000000]";
			mes "It seems that your class can not evolve to 3rd Class.";
			close;
		}

		mes "[^FFA500Aluna^000000]";
		mes "Your character is ready to evolve to 3rd Class. want to come now?";
		next;
		if( select("Yes, change to 3rd Class:No, I will not even change") == 2 )
		{
			mes "[^FFA500Aluna^000000]";
			mes "Come back when you've finally decided.";
			close;
		}

		callfunc "Job_Change", .@target_job;
		mes "[^FFA500Aluna^000000]";
		mes "Ok, now you're ready to continue your progress..";
		close;		
		
	}
}
