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

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

opentable($lang['CERES_TITLE']);
?>
<table width="504">
<br>
Ceres Control Panel was originally created by Beowulf and Nightroad.
Entwined is further developing and maintaining the Ceres Control Panel with the use of <a href="http://subversion.tigris.org/">SVN</a>
I, Entwined, take no credit for what Beowulf and Nightroad originally created. The Ceres Control Panel is free to distribute and/or modify it under the terms of the GNU General Public License. <br><br>
Control Panel Links<ul><li><a href="http://cerescp.sourceforge.net/">http://cerescp.sourceforge.net</a></li><li><a href="http://paradoxnetwork.net:8000/svn/ceresv2">SVN repository</a></li></ul>
Contact Information<ul><li>cerescp@gmail.com</li><li>Entwined@digital-deception.org</li></ul>
</table>
<?php
closetable();
fim();
?>
