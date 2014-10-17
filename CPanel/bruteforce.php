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
include_once 'functions.php';

DEFINE('BF_IP', "SELECT `ban`, `user` FROM `bruteforce` WHERE `IP` = '%s' AND (`date` > '%d' OR `ban` > '%d')");
DEFINE('BF_USER', "SELECT `ban` FROM `bruteforce` WHERE `user` = '%s' AND (`date` > '%d' OR `ban` > '%d')");
DEFINE('BF_ADD', "INSERT INTO `bruteforce` (`user`, `IP`, `date`, `ban`) VALUES('%s', '%s', '%d', '%d')");


function bf_check_user($username) {
	$log_ip = $_SERVER['REMOTE_ADDR'];
	$current = time();
	
	$query = sprintf(BF_IP, $log_ip, $current - 300, $current);
	$result = execute_query($query, "check_user", 1, 0);
	$tentativas = $result->count();
	while ($line = $result->fetch_row()) {
		if ($line[0] > $current)
			return (int)(($line[0] - $current) / 60);
	}
	$result->free();

	if ($tentativas > 9) {
		$query = sprintf(BF_ADD, "Random Try", $log_ip, $current, $current + 600);
		$result = execute_query($query, "check_user", 1, 0);
		return (int)(600 / 60);
	}

	if (inject($username))
		return 0;

	$query = sprintf(BF_USER, $username, $current - 300, $current);
	$result = execute_query($query, "check_user", 1, 0);
	$tentativas = $result->count();
	while ($line = $result->fetch_row()) {
		if ($line[0] > $current)
			return (int)(($line[0] - $current) / 60);
	}
	$result->free();

	if ($tentativas > 2) {
		$query = sprintf(BF_ADD, $username, $log_ip, $current, $current + 300);
		$result = execute_query($query, "check_user", 1, 0);
		return (int)(300 / 60);
	}
	
	return 0;
}

function bf_error($username) {
	$log_ip = $_SERVER['REMOTE_ADDR'];
	$current = time();

	$query = sprintf(BF_ADD, $username, $log_ip, $current, 0);
	$result = execute_query($query, "check_user", 1, 0);
	return 1;
}

?>
