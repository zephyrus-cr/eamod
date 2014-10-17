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

function ipban() {
	$p = split('\.', $_SERVER['REMOTE_ADDR']);

	$query = sprintf(CHECK_IPBAN, $p[0], $p[0],$p[1], $p[0],$p[1],$p[2], $p[0],$p[1],$p[2],$p[3]);
	$result = execute_query($query, 'ipban.php', 0, 0);

	$result->fetch_row();

	return $result->row[0];
}

?>
