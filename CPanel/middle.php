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
include_once 'functions.php';

if (!$CONFIG_disable_account) {
?>
<span title="Create a new account" style="cursor:pointer" onMouseOver="this.style.color='#FF3300'" onMouseOut="this.style.color='#000000'" onClick="return LINK_ajax('account.php','main_div');">
<b><?php echo $lang['NEW_ACCOUNT'] ?></b>
</span>
<?php
}
?>
<br>
<?php
if ($CONFIG_password_recover) {
?>
<span title="Send the account info to your e-mail" style="cursor:pointer" onMouseOver="this.style.color='#FF3300'" onMouseOut="this.style.color='#000000'" onClick="return LINK_ajax('recover.php','main_div');">
<b><?php echo $lang['RECOVER_PASSWORD'] ?></b>
</span>
<?php
}

fim();
?>
