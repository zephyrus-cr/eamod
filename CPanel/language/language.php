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

include_once 'config.php'; // loads config variables

$load = "English.php";

if (isset($GET_lang)){ 
	$load = $GET_lang.".php";
} else if (isset($_COOKIE['language'])) {
	$load = $_COOKIE['language'].".php";
} else if (isset($CONFIG_language)) {
	$load = $CONFIG_language.".php";
}

if (!is_file("./language/".$load) || strpos($load, "..") !== false || inject($load))
	$load = "English.php";

include($load);

while (list($key, $val) = each($lang)) {  
	$lang[$key] = htmlentities($val);
}

?>
