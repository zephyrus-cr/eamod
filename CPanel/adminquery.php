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

$revision = 0;

//adminaccounts
DEFINE('ACCOUNTS_SEARCH_ACCOUNT_ID', "SELECT `account_id`, `userid`, `sex`, `email`, `level`, `last_ip`, `unban_time`, `state`, 
`user_pass`, `lastlogin` FROM `login` WHERE `account_id` = '%d'");
DEFINE('ACCOUNTS_SEARCH_EMAIL', "SELECT `account_id`, `userid`, `sex`, `email`, `level`, `last_ip`, `unban_time`, `state`, `user_pass`
FROM `login` WHERE `email` LIKE '%%%s%%'");
DEFINE('ACCOUNTS_SEARCH_IP', "SELECT `account_id`, `userid`, `sex`, `email`, `level`, `last_ip`, `unban_time`, `state`, `user_pass`
FROM `login` WHERE `last_ip` LIKE '%%%s%%'");
DEFINE('ACCOUNTS_SEARCH_USERID', "SELECT `account_id`, `userid`, `sex`, `email`, `level`, `last_ip`, `unban_time`, `state`, `user_pass`
FROM `login` WHERE `userid` LIKE '%%%s%%'");
DEFINE('ACCOUNTS_BROWSE', "SELECT `account_id`, `userid`, `sex`, `email`, `level`, `last_ip`, `unban_time`, `state`, `user_pass`
FROM `login` ORDER BY `account_id` LIMIT %d, 100");

//adminaccedit
DEFINE('ACCEDIT_UPDATE', "UPDATE `login` SET `userid` = '%s', `user_pass` = '%s', `sex` = '%s', `email` = '%s', `level` = '%d'
WHERE `account_id` = '%d'
");

//adminaccchars
DEFINE('ACCCHARS_ID', "SELECT `char_id`, `char_num`, `name`, `class`, `base_level`, `job_level`, `online`, `last_map`, `last_x`, `last_y`
FROM `char` WHERE `account_id` = '%d' ORDER BY `char_num`
");

//admincharinfo
DEFINE('CHARINFO_CHAR', "SELECT * FROM `char` WHERE `char_id` = '%d'");
DEFINE('CHARINFO_INVENTORY', "SELECT `nameid`, `amount`, `card0`, `card1`, `card2`, `card3`, `refine` FROM `inventory`
WHERE `char_id` = '%d'
");
DEFINE('CHARINFO_STORAGE', "SELECT `nameid`, `amount`, `card0`, `card1`, `card2`, `card3`, `refine` FROM `storage`
WHERE `account_id` = '%d'
");
DEFINE('CHARINFO_CART',"SELECT `nameid`, `amount`, `card0`, `card1`, `card2`, `card3`, `refine` FROM `cart_inventory`
WHERE char_id = '%d'
");

//adminaccban
DEFINE('ACCBAN_UPDATE', "UPDATE `login` SET `unban_time` = '%d', `state` = '%d' WHERE `account_id` = '%d'");

//adminchars
DEFINE('CHARS_SEARCH_ACCOUNT_ID', "SELECT `account_id`, `char_id`, `name`, `class`, `base_level`, `job_level`, `online`
FROM `char` WHERE `account_id` = '%d' ORDER BY `account_id`");
DEFINE('CHARS_SEARCH_CHAR_ID', "SELECT `account_id`, `char_id`, `name`, `class`, `base_level`, `job_level`, `online`
FROM `char` WHERE `char_id` = '%d' ORDER BY `account_id`");
DEFINE('CHARS_SEARCH_NAME', "SELECT `account_id`, `char_id`, `name`, `class`, `base_level`, `job_level`, `online`
FROM `char` WHERE `name` LIKE '%%%s%%' ORDER BY `account_id`");
DEFINE('CHARS_BROWSE', "SELECT `account_id`, `char_id`, `name`, `class`, `base_level`, `job_level`, `online`
FROM `char` ORDER BY `account_id` LIMIT %d, 100");
DEFINE('CHARS_TOTAL', "SELECT COUNT(1) FROM `char` WHERE `account_id` > '0'");

?>
