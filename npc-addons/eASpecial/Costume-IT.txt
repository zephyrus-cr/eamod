// --------------------------------------------------------------------------
// --------------------------------------------------------------------------
// eAmod Project - Scripts
// --------------------------------------------------------------------------
// Script Name : Headgear to Costume converter
// --------------------------------------------------------------------------
// Description :
// Allows a user to convert the equipped headgear (on Top, Mid or Low) into a
// costume item. It will remove any card and refine of the Item.
// --------------------------------------------------------------------------

-	script	CostumeIT	-1,{
	mes "[Costume-IT]";
	mes "Hello and welcome to the Costume-IT service.";
	mes "Here you can convert your headgears into a Costume Headgear.";
	next;
	mes "[Costume-IT]";
	mes "Please, select what to convert.";
	mes "Remember, cards and refine will be removed.";
	next;

	setarray .@Position$[1],"Top","Mid","Low";
	setarray .@Position[1],     1,    9,   10;

	set .@Menu$,"";
	for( set .@i, 1; .@i < 4; set .@i, .@i + 1 )
	{
		if( getequipisequiped(.@Position[.@i]) )
			set .@Menu$, .@Menu$ + .@Position$[.@i] + "-" + "[" + getequipname(.@Position[.@i]) + "]";

		set .@Menu$, .@Menu$ + ":";
	}

	set .@Part, .@Position[ select(.@Menu$) ];
	if( !getequipisequiped(.@Part) )
	{
		mes "[Costume-IT]";
		mes "Your not wearing anything there...";
		close;
	}

	mes "[Costume-IT]";
	mes "You want to Costume your " + getitemname(getequipid(.@Part)) + "?";
	next;
	if( select("Yes, proceed:No, I am sorry.") == 2 )
	{
		mes "[Costume-IT]";
		mes "Need some time to think about it, huh?";
		mes "Alright, I can understand.";
		close;
	}
	
	costume .@Part; // Convert the Headgear

	mes "[Costume-IT]";
	mes "Done, enjoy your costume headgear.";
	close;
}

// --------------------------------------------------------------------------
// Use duplicates to put your npc on different cities
// --------------------------------------------------------------------------

// prontera,155,180,4	duplicate(Costume-IT)	Costume-IT#1	864
