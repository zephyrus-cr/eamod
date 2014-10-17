<?php
/*
Ceres Control Panel

This is a control pannel program for Athena and Freya
Copyright (C) 2005 by Beowulf and Nightroad

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

To contact any of the authors about special permissions send
an e-mail to cerescp@gmail.com
*/

//Do not change tags %s e %d ou %%

//misc
$lang['LOGGED'] = 'You are now logged in.';
$lang['LOGGEDOFF'] = 'You are now logged off.';
$lang['COOKIE_REJECTED'] = 'Cookie rejected.';
$lang['INCORRECT_CHARACTER'] = 'Incorrect Character Detected.';
$lang['UNKNOWN_MAIL'] = 'Unknown Email.';
$lang['INCORRECT_CODE'] = 'Incorrect Code.';
$lang['INCORRECT_PASSWORD'] = 'Incorrect Password.';
$lang['PASSWORD_CHANGED'] = 'Password Changed.';
$lang['CHANGE_PASSWORD'] = 'Change Password';
$lang['USERNAME_LENGTH'] = 'Username must be between 4 and 23 characters.';
$lang['PASSWORD_LENGTH_OLD'] = 'Password must be between 4 and 23 characters.';
$lang['PASSWORD_LENGTH'] = 'Password must be between 6 and 23 characters.';
$lang['WRONG_USERNAME_PASSWORD'] = 'Wrong Username/Password.';
$lang['USERNAME'] = 'Username';
$lang['PASSWORD'] = 'Password';
$lang['NEW_PASSWORD'] = 'New Pass';
$lang['CONFIRM'] = 'Confirm Password';
$lang['CODE'] = 'Code';
$lang['SECURITY_CODE'] = 'Security Code';
$lang['RECOVER'] = 'Recover';
$lang['PASSWORD_NOT_MATCH'] = 'Passwords do not match.';
$lang['PASSWORD_REJECTED'] = 'Password rejected: Not Safe. It must be at least 6 characters long and contain 2 numbers.';
$lang['EMAIL_NEEDED'] = 'Email is needed.';
$lang['INVALID_BIRTHDAY'] = 'Invalid Birthday.';
$lang['SEX'] = 'Sex';
$lang['REAL_SEX'] = 'Real Sex';
$lang['JANUARY'] = 'January';
$lang['FEBRUARY'] = 'February';
$lang['MARCH'] = 'March';
$lang['APRIL'] = 'April';
$lang['MAY'] = 'May';
$lang['JUNE'] = 'June';
$lang['JULY'] = 'July';
$lang['AUGUST'] = 'August';
$lang['SEPTEMBER'] = 'September';
$lang['OCTOBER'] = 'October';
$lang['NOVEMBER'] = 'November';
$lang['DECEMBER'] = 'December';
$lang['MAIL'] = 'E-Mail';
$lang['CREATE'] = 'Create';
$lang['NEED_TO_LOGIN'] = 'You need to be logged on to use this page.';
$lang['NEED_TO_LOGIN_F'] = 'You must be logged on to use this function.';
$lang['DB_ERROR'] = 'Sorry! DB error found, please try again later.';
$lang['TXT_ERROR'] = 'Error in text file.';
$lang['NEED_TO_LOGOUT_F'] = 'You must be out of the game to use this function.';
$lang['CHANGE'] = 'Change';
$lang['SUNDAY'] = 'Sunday';
$lang['MONDAY'] = 'Monday';
$lang['TUESDAY'] = 'Tuesday';
$lang['WEDNSDAY'] = 'Wednesday';
$lang['THURSDAY'] = 'Thursday';
$lang['FRIDAY'] = 'Friday';
$lang['SATURDAY'] = 'Saturday';
$lang['BLOCKED'] = 'You have been blocked, try again in %d min';

//menu.php
$lang['MENU_HOME'] = "Home";
$lang['MENU_MYACCOUNT'] = "My Account";
$lang['MENU_MYCHARS'] = "My Chars";
$lang['MENU_RANKING'] = "Ranking";
$lang['MENU_INFORMATION'] = "Information";
$lang['MENU_PROBLEMS'] = "Problems";
$lang['MENU_MESSAGE'] = "Message";
$lang['MENU_CHANGEPASS'] = "Change Password";
$lang['MENU_CHANGEMAIL'] = "Change e-mail";
$lang['MENU_TRANFMONEY'] = "Transfer Money";
$lang['MENU_CHANGESLOT'] = "Change Slot";
$lang['MENU_MARRIAGE'] = "Marriage";
$lang['MENU_PLAYERLADDER'] = "Player Ladder";
$lang['MENU_GUILDLADDER'] = "Guild Ladder";
$lang['MENU_ZENYLADDER'] = "Zeny Ladder";
$lang['MENU_WHOSONLINE'] = "Who Is Online";
$lang['MENU_ABOUT'] = "About";
$lang['MENU_RESETPOS'] = "Reset Position";
$lang['MENU_RESETLOOK'] = "Reset look";
$lang['MENU_OTHER'] = "Other";
$lang['MENU_LINKS'] = "Links";

//common
$lang['NAME'] = 'Name';
$lang['CLASS'] = 'Class';
$lang['BLVLJLVL'] = 'Blvl/Jlvl';
$lang['MAP'] = 'Map';
$lang['UNKNOWN'] = 'Unknown';
$lang['POS'] = 'Pos';
$lang['ZENY'] = 'Zeny';
$lang['SLOT'] = 'Slot';
$lang['ONE_CHAR'] = 'You must have at least one character.';
$lang['WOE_TIME'] = 'You can\'t see this function during WoE time.';

//whoisonline.php
$lang['WHOISONLINE_WHOISONLINE'] = 'Who is online';
$lang['WHOISONLINE_COORDS'] = 'Coords';

//top100zeny.php
$lang['TOP100ZENY_TOP100ZENY'] = 'Top 100 Zeny';

//slot.php
$lang['SLOT_NOT_SELECTED'] = 'No new slot selected.';
$lang['SLOT_CHANGE_FAILED'] = 'Change Failed.';
$lang['SLOT_WRONG_NUMBER'] = 'Wrong slot number detected.';
$lang['SLOT_CHANGE_SLOT'] = 'Change Char Slot';
$lang['SLOT_NEW_SLOT'] = 'New Slot';
$lang['SLOT_PS1'] = '*If there is a char in the selected slot it will be changed too';
$lang['SLOT_PS2'] = '*You can only change one char at time';

//server_status.php
$lang['SERVERSTATUS_LOGIN'] = 'Login Server';
$lang['SERVERSTATUS_CHAR'] = 'Char Server';
$lang['SERVERSTATUS_MAP'] = 'Map Server';
$lang['SERVERSTATUS_ONLINE'] = 'Online';
$lang['SERVERSTATUS_OFFLINE'] = 'Offline';
$lang['SERVERSTATUS_USERSONLINE'] = 'Users Online';
$LANG['AGIT'] = 'WoE';
$LANG['AGIT_OFF'] = 'Off';
$LANG['AGIT_ON'] = 'On';
//resetlook.php
$lang['RESETLOOK_RESET_LOOK'] = 'Reset Look Failed.';
$lang['RESETLOOK_EQUIP_OK'] = 'Equipment has been reset.';
$lang['RESETLOOK_HAIRC_OK'] = 'Hair Color has been reset.';
$lang['RESETLOOK_HAIRS_OK'] = 'Hair Style has been reset.';
$lang['RESETLOOK_CLOTHESC_OK'] = 'Clothes Color has been reset.';
$lang['RESETLOOK_SELECT'] = 'Select at least one look to reset.';
$lang['RESETLOOK_RESETLOOK'] = 'Reset Look';

//recover.php
$lang['RECOVER_RECOVER'] = 'Recover Password';

//position.php
$lang['POSITION_RESET'] = 'Reset Position Failed.';
$lang['POSITION_NO_ZENY'] = 'Not enough zeny.';
$lang['POSITION_OK'] = 'Position has been reset.';
$lang['POSITION_TITLE'] = 'Reset Position';
$lang['POSITION_LEVEL'] = 'Level';
$lang['POSITION_SELECT'] = 'Select';
$lang['POSITION_RESET'] = 'Reset';
$lang['POSITION_PS1'] = '*There will be a cost of %d zenys to use this service';
$lang['POSITION_JAIL'] = 'You may not use this while in jail.';

//motd.php
$lang['NEWS_MESSAGE'] = 'Message';

//money.php
$lang['MONEY_INCORRECT_NUMBER'] = 'Incorrect Number Detected.';
$lang['MONEY_CHEAT_DETECTED'] = 'Cheat Detected.';
$lang['MONEY_OPER_IMPOSSIBLE'] = 'This operation is impossible.';
$lang['MONEY_OK'] = 'Zeny Transfer Complete.';
$lang['MONEY_AMMOUNT'] = 'Transfer Zeny Amount';
$lang['MONEY_AVAILABLE'] = 'Amount available';
$lang['MONEY_TRANSFER'] = 'Amount to transfer';
$lang['MONEY_CHANGE'] = 'Transfer';
$lang['MONEY_TWO_CHAR'] = 'You must have at least two characters.';
$lang['MONEY_TRANSFER_FROM'] = 'Transfer Zeny From';
$lang['MONEY_TRANSFER_TO'] = 'Transfer Zeny To';
$lang['MONEY_PS1'] = '*There will be a cost of %d%%, from the transferred amount, to use this service';

//marriage.php
$lang['MARRIAGE'] = 'Marriage';
$lang['MARRIAGE_COUPLE_OFF'] = 'This function can only be used when the couple is offline. Your partner is online now.';
$lang['MARRIAGE_DIVORCE_OK'] = 'Character is now divorced.';
$lang['MARRIAGE_NOTHING'] = 'Nothing to be done.';
$lang['MARRIAGE_PARTNER'] = 'Partner';
$lang['MARRIAGE_DIVORCE'] = 'Divorce';
$lang['MARRIAGE_SINGLE'] = 'Single';
$lang['MARRIAGE_PS1'] = '*Check and confirm to divorce, both must be offline to do it';
$lang['MARRIAGE_PS2'] = '*You can only change one char at time';
$lang['MARRIAGE_PS3'] = '*You will be banned for 2 minutes to save the changes';

//ladder.php
$lang['LADDER_TOP100'] = 'Ladder Top 100 Rank';
$lang['LADDER_GUILD'] = 'Guild';
$lang['LADDER_STATUS'] = 'Status';
$lang['LADDER_STATUS_ON'] = 'On';
$lang['LADDER_STATUS_OFF'] = 'Off';

//guild.php
$lang['GUILD_TOP50'] = 'Top 50 Guild Ladder';
$lang['GUILD_EMBLEM'] = 'Emblem';
$lang['GUILD_GNAME'] = 'Guild Name';
$lang['GUILD_GLEVEL'] = 'Level';
$lang['GUILD_GEXPERIENCE'] = 'Experience';
$lang['GUILD_GAVLEVEL'] = 'Average Level';
$lang['GUILD_GCASTLES'] = 'Guild Castles';
$lang['GUILD_GCASTLE'] = 'Castle';
$lang['GUILD_MEMBERS'] = 'Members';

//changemail.php
$lang['CHANGEMAIL_MAIL_INVALID'] = 'New e-mail is not a valid e-mail.';
$lang['CHANGEMAIL_CHANGEMAIL'] = 'Change E-Mail';
$lang['CHANGEMAIL_CHANGE'] = 'Change';
$lang['CHANGEMAIL_NEW_MAIL'] = 'New e-mail';
$lang['CHANGEMAIL_CURRENT_MAIL'] = 'Current e-mail';

//account.php
$lang['USERNAME_IN_USE'] = 'Username already in use.';
$lang['ABR_SEX_MALE'] = 'M';
$lang['ABR_SEX_FEMALE'] = 'F';
$lang['SEX_MALE'] = 'Male';
$lang['SEX_FEMALE'] = 'Female';
$lang['ACCOUNT_CREATED'] = 'Account Created. You may now login.';
$lang['ACCOUNT_PROBLEM'] = 'Error creating account please try again later.';
$lang['INTERNAL_STATISTIC'] = '(for internal statistics)';
$lang['BIRTHDAY'] = 'Birthday';
$lang['ACCOUNT_MAX_REACHED'] = 'There are too many accounts registered, please try again later.';

//index.php
$lang['NEW_ACCOUNT'] = 'New Account';
$lang['RECOVER_PASSWORD'] = 'Recover your password';

//links.php
$lang['LINKS_LINKS'] = 'Links';
$lang['LINKS_NAME'] = 'Name';

//login.php
$lang['LOGIN_WELCOME'] = 'Welcome';
$lang['LOGIN_HELLO'] = 'Hello';
$lang['LOGIN_REMEMBER'] = 'remember me';

//about.php
$lang['ABOUT_ABOUT'] = 'About the server';
$lang['ABOUT_SERVER_NAME'] = 'Server name';
$lang['ABOUT_RATE'] = 'Rates';
$lang['ABOUT_TOTAL_ACCOUNTS'] = 'Total Accounts';
$lang['ABOUT_TOTAL_CHAR'] = 'Total Characters';
$lang['ABOUT_TOTAL_ZENY'] = 'Total Zeny';
$lang['ABOUT_TOTAL_CLASS'] = 'Total by class';
$lang['ABOUT_WOE_TIMES'] = 'WoE times';

//ceres.php
$lang['ABOUT_CERES'] = 'Ceres Control Panel Information';
$lang['CERES_TITLE'] = 'Ceres Control Panel';
