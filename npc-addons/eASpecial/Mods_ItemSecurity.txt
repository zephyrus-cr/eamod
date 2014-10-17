// *****************************************************
//                 Item Security System
// *****************************************************

-	script	SecuritySystem	-1,{
	end;

OnSettings:
	while( 1 )
	{
		mes "[^FFA500Security System^000000]";
		mes "Current Status";

		mes "- Security Code:";
		if( #SECURITYCODE )
		{
			mes "^FFFFFF__________^2E8B57Enable^000000.";

			mes "- Item transfers:";
			if( getsecurity() )
			{
				mes "^FFFFFF__________^2E8B57Blocked^000000.";
				set .@Menu2$, "Allow Item transfers";
			}
			else
			{
				mes "^FFFFFF__________^FF0000Allowed^000000.";
				set .@Menu2$, "Block Item transfers";
			}

			next;
			set .@Option, select("Change Password",.@Menu2$,"Remove Password","Exit");
		}
		else
		{
			mes "^FFFFFF__________^FF0000Disable^000000.";
			next;
			set .@Option, select("Set Password","Exit") + 4;
		}
		
		switch( .@Option )
		{
			case 1: // Cambiar Clave
				mes "[^FFA500Security System^000000]";
				mes "Password is a number between 1000 and 9999.";
				mes "Enter your current password...";
				next;

				input .@Pass;
				if( .@Pass != #SECURITYCODE )
				{
					mes "[^FFA500Security System^000000]";
					mes "Wrong password!!.";
					close;
				}
			
			case 5:
				mes "[^FFA500Security System^000000]";
				mes "Enter your new password...";
				mes "Password is a number between 1000 and 9999.";
				next;
				
				input .@Pass;
				if( .@Pass < 1000 || .@Pass > 9999 )
				{
					mes "[^FFA500Security System^000000]";
					mes "Invalid value!!.";
					close;
				}
				
				mes "[^FFA500Security System^000000]";
				mes "Confirm your new password.";
				next;

				input .@CPass;
				if( .@CPass != .@Pass )
				{
					mes "[^FFA500Security System^000000]";
					mes "The passwords are different.";
					mes "Operation canceled.";
					close;
				}
				
				set #SECURITYCODE, .@Pass;
				break;
			case 2: // Permitir Salidas - Bloquear Salidas
				if( getsecurity() )
				{
					mes "[^FFA500Security System^000000]";
					mes "Please enter your Password to allow item transfers.";
					next;
					
					input .@Pass;
					if( #SECURITYCODE != .@Pass )
					{
						mes "[^FFA500Security System^000000]";
						mes "Wrong password!!.";
						close;
					}
					
					setsecurity 0;
				}
				else if( #SECURITYCODE > 0 )
					setsecurity 1;
				else
					setsecurity 0;
				break;
			case 3: // Quitar Clave
				mes "[^FFA500Security System^000000]";
				mes "Enter your current password.";
				next;
				
				input .@Pass;
				if( #SECURITYCODE != .@Pass )
				{
					mes "[^FFA500Security System^000000]";
					mes "Wrong password!!.";
					close;
				}
				
				set #SECURITYCODE, 0;
				setsecurity 0;
				break;
			case 4:
			case 6:
				mes "[^FFA500Security System^000000]";
				mes "Use @security if you need to configure your services again.";
				mes "Good Day...";
				close;
		}
	}
	
	end;
}