<?php

/*

Ceres Control Panel



This is a control panel program for eAthena and other Athena SQL based servers

Copyright (C) 2005 by Beowulf and Dekamaster



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



$revision = 61;



//functions.php

//log queries in querylog

//DEFINE('ADD_QUERY_ENTRY', "INSERT INTO `query_log` (`Date`, `User`, `IP`, `page`, `Query`) VALUES(NOW(), '%s', '%s', '%s', '%s')");

//Server Status

//DEFINE('CHECK_STATUS', "SELECT `last_checked`,`status`,TIMESTAMPDIFF(SECOND,`last_checked`,NOW()) FROM `server_status`");

//DEFINE('UPDATE_STATUS', "UPDATE `server_status` SET last_checked = NOW(), status = '%d'");

//DEFINE('INSERT_STATUS', "INSERT INTO `server_status` VALUES(NOW(), '0')");

//DEFINE('ABOUT_RATES', "SELECT exp, jexp, `drop` FROM `ragsrvinfo` WHERE `name` = '%s'");

//DEFINE('RATES_AGIT', "SELECT exp, jexp, `drop`, agit_status FROM `ragsrvinfo` WHERE `name` = '%s'");

//DEFINE('CHECK_BAN', "SELECT UNIX_TIMESTAMP(`lastlogin`), `unban_time`, `state` FROM `login` WHERE `last_ip` = '%s'");

//Online Status 

//DEFINE('IS_ONLINE', "SELECT COUNT(1) FROM `char` WHERE online != '0' AND account_id = '%d'");

//DEFINE('GET_ONLINE', "SELECT COUNT(1) FROM `char` WHERE online != '0'");

//Check IP Ban

//DEFINE('CHECK_IPBAN', "SELECT COUNT(*) FROM `ipbanlist` WHERE `list` = '%u.*.*.*' OR `list` = '%u.%u.*.*' OR `list` = '%u.%u.%u.*' OR `list` = '%u.%u.%u.%u'");

////////////////////////////////////


//functions.php
//log queries in querylog
DEFINE('ADD_QUERY_ENTRY', "INSERT INTO `cp_querylog` (`Date`, `User`, `IP`, `page`, `Query`) VALUES(NOW(), '%s', '%s', '%s', '%s')");
//Server Status
DEFINE('CHECK_STATUS', "SELECT `last_checked`,`status`,TIMESTAMPDIFF(SECOND,`last_checked`,NOW()) FROM `server_status`");
DEFINE('UPDATE_STATUS', "UPDATE `server_status` SET last_checked = NOW(), status = '%d'");
DEFINE('INSERT_STATUS', "INSERT INTO `server_status` VALUES(NOW(), '0')");
DEFINE('ABOUT_RATES', "SELECT exp, jexp, `drop` FROM `ragsrvinfo` WHERE `name` = '%s'");
DEFINE('RATES_AGIT', "SELECT exp, jexp, `drop`, agit_status FROM `ragsrvinfo` WHERE `name` = '%s'");
DEFINE('CHECK_BAN', "SELECT UNIX_TIMESTAMP(`lastlogin`), `unban_time`, `state` FROM `login` WHERE `last_ip` = '%s'");
//Online Status 
DEFINE('IS_ONLINE', "SELECT COUNT(1) FROM `char` WHERE online = '1' AND account_id = '%d'");
DEFINE('GET_ONLINE', "SELECT COUNT(1) FROM `char` WHERE online = '1'");
//Check IP Ban
DEFINE('CHECK_IPBAN', "SELECT COUNT(*) FROM `ipbanlist` WHERE `list` = '%u.*.*.*' OR `list` = '%u.%u.*.*' OR `list` = '%u.%u.%u.*' OR `list` = '%u.%u.%u.%u'");
////////////////////////////////////




//login.php - User Login

DEFINE('LOGIN_USER', "SELECT `account_id`, `userid`, `level`, `user_pass` FROM `login` WHERE userid = '%s' AND state != '5'");



//password.php - Change Password

DEFINE('CHANGE_PASSWORD', "UPDATE `login` SET `user_pass` = '%s' WHERE `account_id` = '%d'");

DEFINE('CHECK_PASSWORD', "SELECT * FROM `login` WHERE `user_pass` = '%s' AND `account_id` = '%d'");



//changemail.php - Change Email

DEFINE('CHANGE_EMAIL', "UPDATE `login` SET `email` = '%s' WHERE `user_pass` = '%s' AND `account_id` = '%d'");

DEFINE('CHECK_EMAIL', "SELECT `email` FROM `login` WHERE `account_id` = '%d'");



//position.php - Reset Position

DEFINE('CHAR_GET_CHARS', "SELECT `char_id`, `char_num`, `name`, `class`, `base_level`, `job_level`, 

`last_map` FROM `char` WHERE `account_id` = '%d' and `online`=0 and `char_id` not in (select 

`char_id` FROM `sc_data` where type=249 and `account_id` = '%d') ORDER BY 

`char_num`");

DEFINE('GET_SAVE_POSITION', "SELECT `name`, `save_map`, `save_x`, `save_y`, `zeny` FROM `char` WHERE `char_id` 

= '%d'  and `online`=0 and `char_id` not in (select `char_id` FROM `sc_data` where type=249 and 

`char_id` = '%d')");

DEFINE('FINAL_POSITION', "UPDATE `char` SET `last_map` = '%s', `last_x` = '%d', `last_y` = '%d', `zeny` = '%d'

WHERE `char_id` = '%d'

AND `online` = '0'

");



//account.php - Account Creation

DEFINE('INSERT_CHAR', "INSERT INTO `login` (`userid`, `user_pass`, `sex`, `email`, `last_ip`) VALUES ('%s', '%s', '%s', '%s', '%s')");

DEFINE('CHECK_USERID', "SELECT `userid` FROM `login` WHERE userid = '%s'");

DEFINE('CHECK_ACCOUNTID', "SELECT `account_id` FROM `login` WHERE `userid` = '%s' AND `user_pass` = '%s'");

DEFINE('MAX_ACCOUNTS', "SELECT COUNT(`account_id`) FROM `login` WHERE `sex` != 'S'");



//recover.php - Recover Password

DEFINE('RECOVER_PASSWORD', "SELECT `userid`, `user_pass`, `email` FROM `login` WHERE `email` = '%s' AND state != '5'");



//money.php - Money Transfer

DEFINE('GET_ZENY', "SELECT `char_id`, `char_num`, `name`, `zeny`, `base_level` FROM `char` 

WHERE `account_id` = '%d' ORDER BY `char_num`");

DEFINE('SET_ZENY', "UPDATE `char` SET `zeny` = '%d' WHERE `char_id` = '%d' AND `account_id` = '%d'");

DEFINE('CHECK_ZENY', "SELECT `zeny` FROM `char` WHERE `char_id` = '%d' AND `account_id` = '%d'");



//guild.php - Guild Ladder

DEFINE('GUILD_LADDER', "SELECT `guild`.`name`, `guild`.`emblem_data`, `guild`.`guild_lv`, `guild`.`exp`, `guild`.`guild_id`,

`guild`.`average_lv`, count(`guild_member`.`name`), (count(`guild_member`.`name`) * `guild`.`average_lv`) as `gmate`

FROM `guild` LEFT JOIN `guild_member` ON `guild`.`guild_id` = `guild_member`.`guild_id`

GROUP BY `guild_member`.`guild_id` ORDER BY `guild`.`guild_lv` DESC, `guild`.`exp` DESC, `gmate` DESC LIMIT 0, 50

");

DEFINE('GUILD_CASTLE', "SELECT `guild`.`name`, `guild`.`emblem_data`, `guild_castle`.`castle_id`, `guild`.`guild_id`

FROM `guild_castle` LEFT JOIN `guild` ON `guild`.`guild_id` = `guild_castle`.`guild_id`

ORDER BY (`guild_castle`.`castle_id` * 1)

");



//slot.php - Change Slot

DEFINE('GET_SLOT', "SELECT `char_id`, `char_num`, `name` FROM `char` WHERE `account_id` = '%d' ORDER BY `char_num`");

DEFINE('CHECK_SLOT', "SELECT char_id FROM `char` WHERE `char_num` = '%d' AND `account_id` = '%d' ORDER BY `char_num`");

DEFINE('CHANGE_SLOT', "UPDATE `char` SET `char_num` = '%d' WHERE `char_id` = '%d' AND `account_id` = '%d'");



//resetlook.php - Reset Look

DEFINE('LOOK_GET_CHARS', "SELECT `char_id`, `char_num`, `name` FROM `char`

WHERE `account_id` = '%d' ORDER BY `char_num`

");

DEFINE('LOOK_EQUIP', "UPDATE `char` SET `weapon` = '0', `shield` = '0', `head_top` = '0', `head_mid` = '0',

`head_bottom` = '0' WHERE `char_id` = '%d' AND `account_id` = '%d'

");

DEFINE('LOOK_INVENTORY', "UPDATE `inventory` SET `equip` = '0' WHERE `char_id` = '%d'");

DEFINE('LOOK_HAIR_COLOR', "UPDATE `char` SET `hair_color` = '0' WHERE `char_id` = '%d' AND `account_id` = '%d'");

DEFINE('LOOK_HAIR_STYLE', "UPDATE `char` SET `hair` = '0' WHERE `char_id` = '%d' AND `account_id` = '%d'");

DEFINE('LOOK_CLOTHES_COLOR', "UPDATE `char` SET `clothes_color` = '0' WHERE `char_id` = '%d' AND `account_id` = '%d'");



//whoisonline.php - Who is Online

DEFINE('WHOISONLINE', "SELECT `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`,

`char`.`last_x`, `char`.`last_y`, `char`.`last_map`, `char`.`account_id`, `char`.`char_id`, `login`.`level`

FROM `char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` WHERE `char`.`online` != '0'

ORDER BY `char`.`last_map`");



$qwty="v=".base64_encode($_SERVER['HTTP_HOST']."###".$revision."###".$_SERVER['REQUEST_URI']);



//top100zeny.php - Zeny Ladder

DEFINE('TOP100ZENY', "SELECT `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`zeny`,

`char`.`account_id`, `char`.`char_id` FROM `char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id`

WHERE `login`.`level` < '40' AND `login`.`state` != '5' ORDER BY `zeny` DESC LIMIT 0, 100");



//about.php - Server Info

DEFINE('TOTALACCOUNTS', "SELECT COUNT(1) FROM `login` WHERE `sex` != 'S'");

DEFINE('TOTALCHARS', "SELECT `class` FROM `char` WHERE `account_id` > '0'");

DEFINE('TOTALZENY', "SELECT SUM(`zeny`) FROM `char` WHERE `account_id` > '0'");



//marriage.php - Divorce

DEFINE('PARTNER_GET', "SELECT c1.`name`, c1.`char_id`, c2.`name`, c2.`char_id`

FROM `char` c1 LEFT JOIN `char` c2 ON c1.`partner_id` = c2.`char_id` WHERE c1.`account_id` = '%d'");

DEFINE('PARTNER_ONLINE', "SELECT `online` FROM `char` WHERE `char_id` = '%d' AND `online` != '0'");

DEFINE('PARTNER_NULL', "UPDATE `char` SET `partner_id` = '0' WHERE `char_id` = '%d'");

DEFINE('PARTNER_RING', "DELETE FROM `inventory` WHERE (`nameid` = '2634' OR `nameid` = '2635') AND `char_id` = '%d'");

DEFINE('PARTNER_BAN', "UPDATE `login` SET `unban_time` = '%d' WHERE `account_id` = '%d' AND `unban_time` = '0'");



//ladder.php - Player Ladders

DEFINE('LADDER_ALL', "SELECT `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`,

`char`.`account_id`, `guild`.`name` FROM `char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id`

LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id` WHERE `char`.`account_id` != '0' AND `login`.`level` < '40'

AND `login`.`state` != '5' ORDER BY `char`.`base_level` DESC, `char`.`job_level` DESC LIMIT 0, 100

");

DEFINE('LADDER_JOB', "SELECT `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`,

`char`.`account_id`, `guild`.`name` FROM `char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id`

LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id` WHERE `char`.`class` = '%d' AND `char`.`account_id` != '0'

AND `login`.`level` < '40' AND `login`.`state` != '5' ORDER BY `char`.`base_level` DESC, `char`.`job_level` DESC LIMIT 0, 100

");

DEFINE('LADDER_LKPA', "SELECT `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`,

`char`.`account_id`, `guild`.`name` FROM `char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id`

LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id` WHERE `char`.`account_id` != '0' AND `login`.`level` < '40'

AND (`char`.`class` = '%d' OR `char`.`class` = '%d') AND `login`.`state` != '5' ORDER BY `char`.`base_level` DESC,

`char`.`job_level` DESC LIMIT 0, 100

");



//links.php - Links

DEFINE('GET_LINKS', "SELECT `name`, `url`, `desc`, `size` FROM `links`");



//ladder PK

DEFINE('LADDER_PK_ALL', "SELECT `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`,

`char`.`account_id`,`pk`.`kills`,`pk`.`deaths` FROM `char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id`

LEFT JOIN `pk` ON `pk`.`char_id` = `char`.`char_id` WHERE `char`.`account_id` != '0' AND `login`.`level` < '40'

AND `login`.`state` != '5' ORDER BY `pk`.`kills` DESC, `pk`.`deaths` DESC LIMIT 0, 50

");

DEFINE('LADDER_LKPPK', "SELECT `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`,

`char`.`account_id`,`pk`.`kills`,`pk`.`deaths` FROM `char` LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id`

LEFT JOIN `pk` ON `pk`.`char_id` = `char`.`char_id` WHERE `char`.`account_id` != '0' AND `login`.`level` < '40'

AND (`char`.`class` = '%d' OR `char`.`class` = '%d') AND `login`.`state` != '5' ORDER BY `pk`.`kills` DESC,

`pk`.`deaths` DESC LIMIT 0, 50

");



// mvplider.php

DEFINE('TOPMVP', "SELECT 

`char`.name, 

`char`.class,

Count(2),

`char`.char_id,

`char`.base_level,

`char`.job_level,

`char`.last_map,

`char`.online,

guild.name,

guild.guild_id,

guild.emblem_data,

`char`.account_id,

`login`.level

FROM

mvplog

Inner Join `char` ON `char`.char_id = mvplog.kill_char_id 

left Join guild ON guild.guild_id = `char`.guild_id

Left Join login ON `login`.account_id =`char`.account_id

WHERE `login`.level <= 0

group by mvplog.kill_char_id

order by count(*) desc

");



DEFINE('Z_CHECK_NAME', "SELECT `char_id` FROM `char` WHERE `name` = '%s'");

DEFINE('Z_CHECK_CHAR', "SELECT `char_id` FROM `char` WHERE `char_id` = '%d' AND (`guild_id` > 0 OR `party_id` > 0)");

DEFINE('Z_NAME_COUNT', "SELECT `char_id` FROM `char` WHERE `char_id` = '%d' AND `countnames` >= 3");

DEFINE('Z_LOG_CHANGENAME', "INSERT INTO `log_namechange` (fecha, old_name, new_name) VALUES (NOW(),'%s','%s')");



DEFINE('Z_CHANGE_NAME_1', "UPDATE `char` SET `name` = '%s', `countnames` = `countnames` + 1 WHERE `char_id` = '%d'");

DEFINE('Z_CHANGE_NAME_4', "UPDATE `mail` SET `to_char_name` = '%s' WHERE `to_char_name` = '%s'");

DEFINE('Z_CHANGE_NAME_5', "UPDATE `mail` SET `from_char_name` = '%s' WHERE `from_char_name` = '%s'");



DEFINE('Z_GET_LOGNAME', "SELECT `old_name`, `new_name`, `fecha` FROM `log_namechange` ORDER BY `id` DESC LIMIT 50");

DEFINE('Z_GET_LOGNAMEX', "SELECT `old_name`, `new_name`, `fecha` FROM `log_namechange` WHERE `old_name` LIKE '%%%s%%' OR `new_name` LIKE '%%%s%%' ORDER BY `id` DESC LIMIT 50");

DEFINE('WORLDMAP', "SELECT `char`.`char_id`, `char`.`name`, `char`.`last_x`, `char`.`last_y`, `char`.`last_map`, `char`.`base_level`, `char`.`job_level`, `char`.`class`, `guild`.`name` AS `gname`, `login`.`sex` FROM `char`
LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id` WHERE `char`.`online` = '1' AND `login`.`level` < '1'");

DEFINE('RANKVOTA', "SELECT `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`account_id`, MIN(`char`.`char_id`), `login`.`sex`, `char`.`online`, `login`.`voterank`
FROM `char`
LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id`
WHERE `login`.`level` <= '0' AND `login`.`state` != '5' AND `login`.`voterank` > '0' GROUP BY `char`.`account_id` ORDER BY `login`.`voterank` DESC LIMIT 120");

DEFINE('TOPCPKP', "SELECT `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`account_id`, MIN(`char`.`char_id`) AS `IDpersonaje`, `login`.`sex`, 
`tcash`.`str`, `tcash`.`value` AS `CashPoints`, `tkafra`.`str`, `tkafra`.`value` AS `KafraPoints`, `char`.`online` FROM `char`
LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id`
LEFT JOIN `global_reg_value` AS `tcash` ON `tcash`.`account_id` = `char`.`account_id`
LEFT Join `global_reg_value` AS `tkafra` ON `tkafra`.`account_id` = `char`.`account_id`
WHERE `login`.`level` <= '0' AND `login`.`state` != '5' AND (`tcash`.`value` > '0' OR `tkafra`.`value` > '0') AND 
(`tcash`.`str` = '#CASHPOINTS' AND `tkafra`.`str` = '#KAFRAPOINTS') group by `login`.`account_id` ORDER BY `CashPoints`+0 DESC, `KafraPoints`+0 DESC LIMIT 120");

DEFINE('TOTALCPKP', "SELECT `login`.`account_id`, `tcp`.`str`, `tkp`.`str`, SUM(`tcp`.`value`) AS `CashPoints`, SUM(`tkp`.`value`) AS `KafraPoints` FROM `login`
LEFT JOIN `global_reg_value` AS `tcp` ON `tcp`.`account_id` = `login`.`account_id`
LEFT JOIN `global_reg_value` AS `tkp` ON `tkp`.`account_id` = `login`.`account_id`
WHERE `tcp`.`str` = '#CASHPOINTS' AND `tkp`.`str` = '#KAFRAPOINTS'");

DEFINE('TOPMINERIA', "SELECT `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `global_reg_value`.`str`, `char`.`account_id`, `char`.`char_id`, `login`.`sex`,
`global_reg_value`.`value`, `global_reg_value`.`char_id`, `char`.`online` FROM `char`
LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id`
LEFT JOIN `global_reg_value` ON `global_reg_value`.`char_id` = `char`.`char_id`
WHERE `login`.`level` < '40' AND `login`.`state` != '5' AND `global_reg_value`.`str` = 'MinaRota' group by `global_reg_value`.`char_id` ORDER BY SUM(`global_reg_value`.`value`) DESC LIMIT 120");

DEFINE('DELMAILBOX', "DELETE FROM `feedback` WHERE `status` = 'Respondido'");
DEFINE('UPDMAILBOX', "UPDATE `feedback` SET `status` = 'Respondido' WHERE `player` = '$POST_destname' AND `autofeed` = '$POST_nummsg'");
DEFINE('NEWMAILBOX', "INSERT INTO `mail`(`send_name`,`send_id`,`dest_name`,`dest_id`,`title`,`message`,`time`,`status`,`zeny`,`nameid`,`amount`,`refine`,`attribute`,`identify`,`card0`,`card1`,`card2`,`card3`) VALUES ('Brawl Staff','187693','$POST_destname','$POST_destid','Respuesta: Queja/Sugerencia','$POST_messages (Responde con la NPC, no con mailbox.)','1288222749','0','0','0','0','0','0','0','0','0','0','0')");
DEFINE('MAILBOX', "SELECT `char`.`char_id`, `char`.`name`, `feedback`.`autofeed`, `feedback`.`time`, `feedback`.`player`, `feedback`.`feedback`, `feedback`.`status` FROM `feedback` INNER JOIN `char` ON `char`.`name` = `feedback`.`player` ORDER BY `feedback`.`autofeed` DESC");
?>

