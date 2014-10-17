// Hidding Slot Enchant NPC
// Important Note : Item ID 677 Platinum Coin is a special item that allow user to select the Enchant.

prontera,146,61,5	script	Shiriublem	84,{
	mes "[Shiriublem]";
	mes "I'm an engineer that specializes in Enchating Armors.";
	next;
	mes "[Shiriublem]";
	mes "Enchanting may seem simple, but it's far more complicated than it looks.";
	mes "If you're interested in my service, let me know.";
	next;
	switch( select( "^4169E1Weapon Enchant^000000:Enchant Armor:^0000FFHeadGear Enchant^000000:^FFA500Garment/Footgear Enchant^000000:^FF0000Shield Enchant^000000:^4169E1Accesory Enchant^000000:Information:Cancel" ) )
	{
		case 1:
			mes "[Shiriublem]";
			mes "^FFA500To enchant your Weapon^000000:";
			mes "a) Need 50 Bravery, 50 Valor and 50 Heroism Badges.";
			mes "b) 500.000 Zeny";
			mes "c) Enchant Type are Elemental or Racial.";
			mes "d) ^FF0000Weapon will loose refines and cards^000000.";
			mes "e) Weapon must be 3 slots or less";
			next;

			setarray .@Position$[3], "Left hand","Right hand";
			set .@Menu$,"";
			for( set .@i, 3; .@i <= 4; set .@i, .@i + 1 )
			{
				if( getequipisequiped(.@i) )
					set .@Menu$, .@Menu$ + .@Position$[.@i] + "-" + "[" + getequipname(.@i) + "]";
				set .@Menu$, .@Menu$ + ":";
			}

			set .@Part,select(.@Menu$ + "Cancel") + 2;
			if( .@Part >= 5 )
			{
				mes "[Shiriublem]";
				mes "Need some time to think about it, huh?";
				mes "Alright, I can understand.";
				mes "Just remember that life's no fun if you're always playing it safe~";
				close;
			}
			if( !getequipisequiped(.@Part) )
			{
				mes "[Shiriublem]";
				mes "Your not wearing anything there...";
				close;
			}
			if( getequipweaponlv(.@Part) == 0 )
			{
				mes "[Shiriublem]";
				mes "This enchant only work for Weapons, not Shields...";
				close;
			}
			set .@Slot0, getequipcardid(.@Part,0);
			if( .@Slot0 == 255 || .@Slot0 == 254 || .@Slot0 < 0 )
			{
				mes "[Shiriublem]";
				mes "I am sorry, i cannot work on Signed items.";
				close;
			}
			set .@Item, getequipid(.@Part);
			if( getitemslots(.@Item) >= 4 )
			{
				mes "[Shiriublem]";
				mes "I am sorry, i cannot work on 4 slots weapons.";
				close;
			}

			mes "[Shiriublem]";
			mes "You want to enchant your " + getitemname(.@Item) + "?";
			mes "The cost of this work is ^0000FF50 Bravery, 50 Valor and 50 Heroism Badges^000000.";
			next;
			mes "[Shiriublem]";
			mes "If you have the badges, we can go ahead with the Enchant attempt.";
			mes "But before that, I must warn you of the risk.";
			next;
			mes "[Shiriublem]";
			mes "Once the weapon receives the enchant ^FF0000it will loose refine and cards^000000.";
			mes "Do you still want to Enchant?";
			next;
			if( select("^FF0000Enchant it Elemental^000000:^0000FFEnchant it Racial^000000:^FFA500Let me choose (Platinum Coin)^000000:Cancel") == 4 )
			{
				mes "[Shiriublem]";
				mes "Need some time to think about it, huh?";
				mes "Alright, I can understand.";
				mes "Just remember that life's no fun if you're always playing it safe~";
				close;
			}

			set .@Type, @menu; // 1 : Elemental | 2 : Racial
			if( countitem(7828) < 50 || countitem(7829) < 50 || countitem(7773) < 50 || Zeny < 500000 )
			{
				mes "[Shiriublem]";
				mes "I'd like to go ahead with this Enchant attempt, but you're missing a few things.";
				mes "You sure that you have the badges?";
				close;
			}

			set .@Slot0, getequipcardid(.@Part,0);
			if( !getequipisequiped(.@Part) || !getequipweaponlv(.@Part) || .@Slot0 == 255 || .@Slot0 == 254 || .@Slot0 < 0 || .@Item != getequipid(.@Part) )
			{
				mes "[Shiriublem]";
				mes "This is not the equip we were talking about...";
				mes "Get out of here!!";
				close;
			}

			if( .@Type == 3 && countitem(677) < 1 )
			{
				mes "[Shiriublem]";
				mes "Oh.. ok... and where is the Platinum Coin?";
				mes "Platinum Coin is the reward for being in the Top 3 Battlegrounds players of the Week.";
				close;
			}

			switch( .@Type )
			{
			case 1: // Elemental
				set .@Enchant, 4964 + rand(5);
				break;
			case 2: // Racial
				set .@Enchant, 4969 + rand(10);
				break;
			case 3: // Selective
				set .@Menu$,"";
				for( set .@i, 4964; .@i <= 4978; set .@i, .@i + 1 )
					set .@Menu$, .@Menu$ + getitemname(.@i) + ":";

				set .@Enchant, 4963 + select(.@Menu$);
				delitem 677,1;
				break;
			}

			delitem 7828,50;
			delitem 7829,50;
			delitem 7773,50;
			set Zeny, Zeny - 500000;

			successenchant .@Part,.@Enchant;

			mes "[Shiriublem]";
			mes "Great, your weapon received ^0000FF" + getitemname(.@Enchant) + "^000000 enchant.";
			mes "It looks pretty well done. Congratulations!";
			next;
			mes "[Shiriublem]";
			mes "See you again, buddy!";
			close;
		case 2:
			mes "[Shiriublem]";
			mes "You want to enchant your Armor?";
			mes "Remember this item will lose previus enchants.";
			next;
			if ( select("Attempt Enchant","Cancel") == 2 )
			{
				mes "[Shiriublem]";
				mes "Need some time to think about it, huh?";
				mes "Alright, I can understand.";
				mes "Just remember that life's no fun if you're always playing it safe~";
				close;
			}
			
			if( !getequipisequiped(2) )
			{
				mes "[Shiriublem]";
				mes "You're not wearing any armor...";
				mes "I can´t enchant your body!";
				close;
			}
			
			deletearray .@Armor[0],127;
			setarray .@Armor[0],2358,2307,2309,2314,2316,2321,2325,2327,2330,2332,2334,2335,2341,2344,2346,2348,2350,2337,2386,2311,2318,2319,2320,2308,2310,2315,2317,2322,2324,2326,2331,2333,2336,2342,2345,2347,2349,2351,2364,2365,2374,2375,2387,2389,2391,2390,2376,2377,2378,2379,2380,2381,2382,2394,2395,2396;
			set .@Item, getequipid(2);
			
			for( set .@i, 0; .@i < getarraysize(.@Armor); set .@i, .@i + 1 )
			{
				if( .@Armor[.@i] == .@Item )
					break;
			}

			if( .@i >= getarraysize(.@Armor) )
			{
				mes "[Shiriublem]";
				mes "I am sorry, but i cannot work on this armor.";
				mes "If you need information, just ask me...";
				close;
			}

			mes "[Shiriublem]";
			mes "You want to enchant your " + getitemname(.@Item) + "?";
			mes "The cost of my work is 400.000 zeny.";
			next;
			mes "[Shiriublem]";
			mes "If you have my zeny service fee and the Armor, then we can go ahead with the Enchant attempt.";
			mes "But before that, I must warn you of the risk.";
			next;
			mes "[Shiriublem]";
			mes "^FF0000Your Armor will loose any Refine and Cards^000000.";
			mes "Also, if the attempt to Enchant fails, the ^FF0000Armor^000000 will be destroyed^000000.";
			mes "Do you still want to try to Enchant?";
			next;
			if ( select("Go with the enchant","Cancel") == 2 )
			{
				mes "[Shiriublem]";
				mes "Need some time to think about it, huh?";
				mes "Alright, I can understand.";
				mes "Just remember that life's no fun if you're always playing it safe~";
				close;
			}

			if( getequipisequiped(2) == 0 || getequipid(2) != .@Item || Zeny < 400000 )
			{
				mes "[Shiriublem]";
				mes "I'd like to go ahead with this Enchant attempt, but you're missing a few things.";
				mes "You sure that you have the equipment and the zeny?";
				close;
			}

			mes "[Shiriublem]";
			mes "Alright then, let the work begin!";
			mes "You'd better pray for a successful result.";
			mes "Let me take your armor...";
			next;
			set .@Enchant, 0;

			if( countitem(677) )
			{
				mes "[Shiriublem]";
				mes "Wooo!! You own a Platinum Coin.";
				mes "Look, I can let you choose a +3 Safe Enchant from one of my store armors.";
				mes "If you give me your current armor and that Coin.";
				next;
				if( select("Ok... let me choose:No thanks, just continue") == 1 )
				{
					set .@Menu$,"";
					for( set .@i, 0; .@i < 6; set .@i, .@i + 1 )
						set .@Menu$, .@Menu$ + getitemname(4702 + (.@i * 10)) + ":";

					set .@Enchant, 4702 + ((select(.@Menu$) - 1) * 10);
					delitem 677,1;
				}
			}

			set Zeny, Zeny - 400000;

			if( .@Enchant == 0 )
			{
				set .@Rate, rand(50);
				if( .@Rate < 14 )
				{ // 14% Break chance
					failedenchant 2;

					mes "[Shiriublem]";
					mes "Wah! ...I am so sorry, it failed.";
					mes "However, I am completely innocent.";
					mes "This is your luck, and it is destined by god, okay?";
					mes "Don't be so disappointed, and try next time.";
					next;
					mes "[Shiriublem]";
					mes "I wish you good luck next time!";
					close;
				}
				else if( .@Rate < 32 )
					set .@Enchant, 4700 + (rand(6) * 10); // 18% to become +1 stat
				else if( .@Rate < 44 )
					set .@Enchant, 4701 + (rand(6) * 10); // 12% to become +2 stat
				else
					set .@Enchant, 4702 + (rand(6) * 10); // 6% to become +3 stat
			}

			successenchant 2,.@Enchant;

			mes "[Shiriublem]";
			mes "Great, it seems to be successful.";
			mes "Your armor received ^0000FF" + getitemname(.@Enchant) + "^000000 enchant.";
			mes "It looks pretty well done. Congratulations!";
			next;
			mes "[Shiriublem]";
			mes "See you again, buddy!";
			close;
		case 3:
			mes "[Shiriublem]";
			mes "^FFA500To enchant your HeadGear^000000:";
			mes "a) Need 100 Bravery, 100 Valor and 100 Heroism Badges.";
			mes "b) 500.000 Zeny";
			mes "c) If it's already enchanted, it will require ^0000FF1 Terra's Bronze Coin^000000.";
			mes "d) Stats is +1 and random.";
			mes "e) ^FF0000Headgear will loose refines and cards^000000.";
			next;
			if ( select("Attempt Enchant","Cancel") == 2 )
			{
				mes "[Shiriublem]";
				mes "Need some time to think about it, huh?";
				mes "Alright, I can understand.";
				mes "Just remember that life's no fun if you're always playing it safe~";
				close;
			}
			if( !getequipisequiped(1) )
			{
				mes "[Shiriublem]";
				mes "You're not wearing any headgear...";
				mes "I can´t enchant your head!";
				close;
			}
			
			set .@Slot0, getequipcardid(1,0);
			set .@Slot3, getequipcardid(1,3);
			set .@NeedCP, 0;
			
			if( .@Slot0 == 255 || .@Slot0 == 254 || .@Slot0 < 0 )
			{
				mes "[Shiriublem]";
				mes "I am sorry, i cannot work on Signed items.";
				close;
			}
			
			if( .@Slot3 != 0 )
			{
				set .@NeedCP, 1;
				mes "[Shiriublem]";
				mes "This headgear is already enchanted. You will need also to pay me 1 ^0000FFTerra's Bronze Coin^000000.";
				next;
			}

			mes "[Shiriublem]";
			mes "You want to enchant your " + getitemname(getequipid(1)) + "?";
			mes "The cost of this work is ^0000FF100 Bravery, 100 Valor and 100 Heroism Badges^000000.";
			if( .@NeedCP ) mes "And 1 ^0000FFTerra's Bronze Coin^000000";
			next;
			mes "[Shiriublem]";
			mes "If you have the badges, we can go ahead with the Enchant attempt.";
			mes "But before that, I must warn you of the risk.";
			next;
			mes "[Shiriublem]";
			mes "Once the headgear receives the enchant, it cannot be enchanted anymore and ^FF0000it will loose refine and cards^000000.";
			mes "Do you still want to Enchant?";
			next;
			if ( select("Go with the enchant","Cancel") == 2 )
			{
				mes "[Shiriublem]";
				mes "Need some time to think about it, huh?";
				mes "Alright, I can understand.";
				mes "Just remember that life's no fun if you're always playing it safe~";
				close;
			}

			if( countitem(7828) < 100 || countitem(7829) < 100 || countitem(7773) < 100 || Zeny < 500000 || (.@NeedCP && countitem(8905) < 1) )
			{
				mes "[Shiriublem]";
				mes "I'd like to go ahead with this Enchant attempt, but you're missing a few things.";
				mes "You sure that you have the badges and Zeny?";
				if( .@NeedCP ) mes "And remember, a Terra's Bronze Coin.";
				close;
			}

			set .@Slot0, getequipcardid(1,0);
			set .@Slot3, getequipcardid(1,3);

			if( !getequipisequiped(1) || .@Slot0 == 255 || .@Slot0 == 254 || .@Slot0 < 0 || (.@NeedCP == 0 && .@Slot3 != 0) )
			{
				mes "[Shiriublem]";
				mes "This is not the headgear we were talking about...";
				mes "Get out of here!!";
				close;
			}

			set .@Enchant, 0;

			if( countitem(677) )
			{
				mes "[Shiriublem]";
				mes "Wooo!! You own a Platinum Coin.";
				mes "Look, I can let you choose a +1 Safe Enchant from one of my store headgers.";
				mes "If you give me your current headgear and that Coin.";
				next;
				if( select("Ok... let me choose:No thanks, just continue") == 1 )
				{
					set .@Menu$,"";
					for( set .@i, 0; .@i < 6; set .@i, .@i + 1 )
						set .@Menu$, .@Menu$ + getitemname(4700 + (.@i * 10)) + ":";

					set .@Enchant, 4700 + ((select(.@Menu$) - 1) * 10);
					delitem 677,1;
				}
			}

			delitem 7828,100;
			delitem 7829,100;
			delitem 7773,100;
			set Zeny, Zeny - 500000;
			if( .@Enchant == 0 ) set .@Enchant, 4700 + (rand(6) * 10);
			if( .@NeedCP ) delitem 8905,1;
			successenchant 1,.@Enchant;

			mes "[Shiriublem]";
			mes "Great, your headgear received ^0000FF" + getitemname(.@Enchant) + "^000000 enchant.";
			mes "It looks pretty well done. Congratulations!";
			next;
			mes "[Shiriublem]";
			mes "See you again, buddy!";
			close;
		case 4:
			mes "[Shiriublem]";
			mes "^FFA500To enchant Footgear or Garment.^000000:";
			mes "a) 30 Bravery, 30 Valor and 30 Heroism Badges.";
			mes "b) 200.000 Zeny";
			mes "c) Enchant Type are HP or SP bonus";
			mes "d) ^FF0000Equip will loose refines and cards^000000.";
			next;
			if ( select("Attempt enchant my Garment:Attempt enchant my Footgear:Cancel") == 3 )
			{
				mes "[Shiriublem]";
				mes "Need some time to think about it, huh?";
				mes "Alright, I can understand.";
				mes "Just remember that life's no fun if you're always playing it safe~";
				close;
			}
			
			set .@Equip, 4 + @menu; // Selected option
			if( !getequipisequiped(.@Equip) )
			{
				mes "[Shiriublem]";
				mes "You're not wearing nothing there...";
				mes "I can´t enchant your body!";
				close;
			}

			set .@Slot0, getequipcardid(.@Equip,0);
			if( .@Slot0 == 255 || .@Slot0 == 254 || .@Slot0 < 0 )
			{
				mes "[Shiriublem]";
				mes "I am sorry, i cannot work on Signed items.";
				close;
			}

			mes "[Shiriublem]";
			mes "You want to enchant your " + getitemname(getequipid(.@Equip)) + "?";
			mes "The cost of this work is ^0000FF30 Bravery, 30 Valor and 30 Heroism Badges^000000.";
			next;
			mes "[Shiriublem]";
			mes "If you have the badges, we can go ahead with the Enchant attempt.";
			mes "But before that, I must warn you of the risk.";
			next;
			mes "[Shiriublem]";
			mes "Once the equip receives the enchant ^FF0000it will loose refine and cards^000000.";
			mes "Do you still want to Enchant?";
			next;
			if ( select("^FFFF00Enchant it with HP^000000:^0000FFEnchant it with SP^000000:^FFA500Let me choose (Platinum Coin)^000000:Cancel") == 4 )
			{
				mes "[Shiriublem]";
				mes "Need some time to think about it, huh?";
				mes "Alright, I can understand.";
				mes "Just remember that life's no fun if you're always playing it safe~";
				close;
			}

			set .@Type, @menu - 1; // 0 : HP | 1 : SP
			if( countitem(7828) < 30 || countitem(7829) < 30 || countitem(7773) < 30 || Zeny < 200000 )
			{
				mes "[Shiriublem]";
				mes "I'd like to go ahead with this Enchant attempt, but you're missing a few things.";
				mes "You sure that you have the badges and Zeny?";
				close;
			}

			set .@Slot0, getequipcardid(.@Equip,0);
			if( !getequipisequiped(.@Equip) || .@Slot0 == 255 || .@Slot0 == 254 || .@Slot0 < 0 )
			{
				mes "[Shiriublem]";
				mes "This is not the equip we were talking about...";
				mes "Get out of here!!";
				close;
			}

			if( .@Type == 2 && countitem(677) < 1 )
			{
				mes "[Shiriublem]";
				mes "Oh.. ok... and where is the Platinum Coin?";
				mes "Platinum Coin is the reward for being in the Top 3 Battlegrounds players of the Week.";
				close;
			}

			if( .@Type == 2 )
			{
				set .@Menu$,"";
				for( set .@i, 0; .@i < 2; set .@i, .@i + 1 )
					set .@Menu$, .@Menu$ + getitemname(4996 + (.@i * 3)) + ":";

				set .@Enchant, 4996 + ((select(.@Menu$) - 1) * 3);
				delitem 677,1;
			}
			else
			{
				set .@Rate, rand(100);
				if( .@Rate < 50 )
					set .@Enchant, 4994 + (.@Type * 3);
				else if( .@Rate < 85 )
					set .@Enchant, 4995 + (.@Type * 3);
				else
					set .@Enchant, 4996 + (.@Type * 3);
			}

			delitem 7828,30;
			delitem 7829,30;
			delitem 7773,30;
			set Zeny, Zeny - 200000;

			successenchant .@Equip,.@Enchant;

			mes "[Shiriublem]";
			mes "Great, your equip received ^0000FF" + getitemname(.@Enchant) + "^000000 enchant.";
			mes "It looks pretty well done. Congratulations!";
			next;
			mes "[Shiriublem]";
			mes "See you again, buddy!";
			close;
		case 5:
			mes "[Shiriublem]";
			mes "^FFA500To enchant a Shield you need:^000000:";
			mes "a) Need 30 Bravery, 30 Valor and 30 Heroism Badges.";
			mes "b) 200.000 Zeny";
			mes "c) Enchant Type are Elemental or Racial.";
			mes "d) ^FF0000Shield will loose refines and cards^000000.";
			next;
			if ( select("Attempt enchant:Cancel") == 2 )
			{
				mes "[Shiriublem]";
				mes "Need some time to think about it, huh?";
				mes "Alright, I can understand.";
				mes "Just remember that life's no fun if you're always playing it safe~";
				close;
			}

			if( !getequipisequiped(3) )
			{
				mes "[Shiriublem]";
				mes "You're not wearing nothing there...";
				mes "I can´t enchant your hand!";
				close;
			}
			
			if( getequipweaponlv(3) )
			{
				mes "[Shiriublem]";
				mes "This Enchant is for Shield, not weapons...";
				close;
			}

			set .@Slot0, getequipcardid(3,0);
			if( .@Slot0 == 255 || .@Slot0 == 254 || .@Slot0 < 0 )
			{
				mes "[Shiriublem]";
				mes "I am sorry, i cannot work on Signed items.";
				close;
			}

			mes "[Shiriublem]";
			mes "You want to enchant your " + getitemname(getequipid(3)) + "?";
			mes "The cost of this work is ^0000FF30 Bravery, 30 Valor and 30 Heroism Badges^000000.";
			next;
			mes "[Shiriublem]";
			mes "If you have the badges, we can go ahead with the Enchant attempt.";
			mes "But before that, I must warn you of the risk.";
			next;
			mes "[Shiriublem]";
			mes "Once the equip receives the enchant ^FF0000it will loose refine and cards^000000.";
			mes "Do you still want to Enchant?";
			next;
			if ( select("^FFFF00Enchant it Elemental^000000:^0000FFEnchant it Racial^000000:^FFA500Let me choose (Platinum Coin)^000000:Cancel") == 4 )
			{
				mes "[Shiriublem]";
				mes "Need some time to think about it, huh?";
				mes "Alright, I can understand.";
				mes "Just remember that life's no fun if you're always playing it safe~";
				close;
			}

			set .@Type, @menu; // 1 : Elemental | 2 : Racial
			if( countitem(7828) < 30 || countitem(7829) < 30 || countitem(7773) < 30 || Zeny < 200000 )
			{
				mes "[Shiriublem]";
				mes "I'd like to go ahead with this Enchant attempt, but you're missing a few things.";
				mes "You sure that you have the badges?";
				close;
			}

			set .@Slot0, getequipcardid(3,0);
			if( !getequipisequiped(3) || getequipweaponlv(3) || .@Slot0 == 255 || .@Slot0 == 254 || .@Slot0 < 0 )
			{
				mes "[Shiriublem]";
				mes "This is not the equip we were talking about...";
				mes "Get out of here!!";
				close;
			}

			if( .@Type == 3 && countitem(677) < 1 )
			{
				mes "[Shiriublem]";
				mes "Oh.. ok... and where is the Platinum Coin?";
				mes "Platinum Coin is the reward for being in the Top 3 Battlegrounds players of the Week.";
				close;
			}

			switch( .@Type )
			{
			case 1: // Elemental
				set .@Enchant, 4979 + rand(5);
				break;
			case 2: // Racial
				set .@Enchant, 4984 + rand(10);
				break;
			case 3: // Selective
				set .@Menu$,"";
				for( set .@i, 4979; .@i <= 4993; set .@i, .@i + 1 )
					set .@Menu$, .@Menu$ + getitemname(.@i) + ":";

				set .@Enchant, 4978 + select(.@Menu$);
				delitem 677,1;
				break;
			}

			delitem 7828,30;
			delitem 7829,30;
			delitem 7773,30;
			set Zeny, Zeny - 200000;

			successenchant 3,.@Enchant;

			mes "[Shiriublem]";
			mes "Great, your equip received ^0000FF" + getitemname(.@Enchant) + "^000000 enchant.";
			mes "It looks pretty well done. Congratulations!";
			next;
			mes "[Shiriublem]";
			mes "See you again, buddy!";
			close;
		case 6:
			mes "[Shiriublem]";
			mes "^FFA500To enchant your Accesory^000000:";
			mes "a) Need 750 Bravery, 750 Valor and 500 Heroism Badges.";
			mes "b) 1.000.000 Zeny";
			mes "c) Enchant Type is a Bonus on Max Weight";
			mes "d) ^FF0000Accesory will loose cards^000000.";
			next;

			setarray .@Position$[7], "Accessory 1","Accessory 2";
			set .@Menu$,"";
			for( set .@i, 7; .@i <= 8; set .@i, .@i + 1 )
			{
				if( getequipisequiped(.@i) )
					set .@Menu$, .@Menu$ + .@Position$[.@i] + "-" + "[" + getequipname(.@i) + "]";
				set .@Menu$, .@Menu$ + ":";
			}

			set .@Part,select(.@Menu$ + "Cancel") + 6;
			if( .@Part >= 9 )
			{
				mes "[Shiriublem]";
				mes "Need some time to think about it, huh?";
				mes "Alright, I can understand.";
				mes "Just remember that life's no fun if you're always playing it safe~";
				close;
			}
			if( !getequipisequiped(.@Part) )
			{
				mes "[Shiriublem]";
				mes "Your not wearing anything there...";
				close;
			}

			set .@Slot0, getequipcardid(.@Part,0);
			if( .@Slot0 == 255 || .@Slot0 == 254 || .@Slot0 < 0 )
			{
				mes "[Shiriublem]";
				mes "I am sorry, i cannot work on Signed items.";
				close;
			}

			set .@Item, getequipid(.@Part);

			mes "[Shiriublem]";
			mes "You want to enchant your " + getitemname(.@Item) + "?";
			mes "The cost of this work is ^0000FF750 Bravery, 750 Valor and 500 Heroism Badges^000000.";
			next;
			mes "[Shiriublem]";
			mes "If you have the badges, we can go ahead with the Enchant attempt.";
			mes "But before that, I must warn you of the risk.";
			next;
			mes "[Shiriublem]";
			mes "Once the Accesory receives the enchant ^FF0000it will loose cards^000000.";
			mes "Do you still want to Enchant?";
			next;
			if ( select("^0000FFEnchant it^000000:Cancel") == 2 )
			{
				mes "[Shiriublem]";
				mes "Need some time to think about it, huh?";
				mes "Alright, I can understand.";
				mes "Just remember that life's no fun if you're always playing it safe~";
				close;
			}

			if( countitem(7828) < 750 || countitem(7829) < 750 || countitem(7773) < 500 || Zeny < 1000000 )
			{
				mes "[Shiriublem]";
				mes "I'd like to go ahead with this Enchant attempt, but you're missing a few things.";
				mes "You sure that you have the badges?";
				close;
			}

			set .@Slot0, getequipcardid(.@Part,0);
			if( !getequipisequiped(.@Part) || .@Slot0 == 255 || .@Slot0 == 254 || .@Slot0 < 0 || .@Item != getequipid(.@Part) )
			{
				mes "[Shiriublem]";
				mes "This is not the equip we were talking about...";
				mes "Get out of here!!";
				close;
			}

			delitem 7828,750;
			delitem 7829,750;
			delitem 7773,500;
			set Zeny, Zeny - 1000000;
			successenchant .@Part,4963;

			mes "[Shiriublem]";
			mes "Great, your weapon received ^0000FF" + getitemname(4963) + "^000000 enchant.";
			mes "It looks pretty well done. Congratulations!";
			next;
			mes "[Shiriublem]";
			mes "See you again, buddy!";
			close;
		case 7:
			mes "[Shiriublem]";
			mes "Well, I haven't really refined the art of Enchanting.";
			mes "It's so complicated that I'd be lying if I told you that I knew every factor that affected the process.";
			mes "Still, I do notice a few trends...";
			next;
			mes "[Shiriublem]";
			mes "When an armor become enchanted, it will show a special hiding slot with a gem on it.";
			mes "This will grant one aditional stat to the armor, and with different values.";
			next;
			mes "[Shiriublem]";
			mes "You should know that the Armor will lose their refine, cards and previous enchants.";
			mes "And maybe the armor too, if i fail...";
			next;
			mes "[Shiriublem]";
			mes "Do you want to know what armor can be enchanted?.";
			mes "Tell me what list do you want to explore...";
			next;
			deletearray .@Armor[0],127;
			switch( select( "Non Sloted Armors","Sloted Armors","High Class Armors" ) )
			{
				case 1: setarray .@Armor[0],2358,2307,2309,2314,2316,2321,2325,2327,2330,2332,2334,2335,2341,2344,2346,2348,2350,2337,2386; break;
				case 2: setarray .@Armor[0],2311,2318,2319,2320,2308,2310,2315,2317,2322,2324,2326,2331,2333,2336,2342,2345,2347,2349,2351; break;
				case 3: setarray .@Armor[0],2364,2365,2374,2375,2387,2389,2391,2390,2376,2377,2378,2379,2380,2381,2382,2394,2395,2396; break;
			}
			
			mes "^0000FF** Armor List **^000000";
			for( set .@i, 0; .@i < getarraysize(.@Armor); set .@i, .@i + 1 )
				mes "" + getitemname(.@Armor[.@i]) + "";
			
			next;
			mes "[Shiriublem]";
			mes "Talk me again if you want to enchant your armor or if you need more information.";
			close;
		case 8:
			mes "[Shiriublem]";
			mes "Take it easy, adventurer.";
			mes "If you ever want to try to enchant your armors, come back and let me know.";
			mes "Seeya~";
			close;
	}
}
