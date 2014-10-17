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
IHM
To contact any of the authors about special permissions send
an e-mail to cerescp@gmail.com
*/

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'adminquery.php';
include_once 'functions.php';

$database = "cp";
$rodb = "ragnarok2";

if (!isset($_SESSION[$CONFIG_name.'level']) || $_SESSION[$CONFIG_name.'level'] < $CONFIG['cp_admin'])
	die ("Not Authorized");

opentable("Administrador de Incentivos");

$sub = isset($_GET['sub']) ? $_GET['sub'] : NULL;

if(isset($_GET['addCents']))
{
	$code = md5(uniqid(rand(), true));
	$time = time();
	$dollars = intval($_GET['addDollars']);
	$dollars = $dollars*100;
	$cents = intval($_GET['addCents']);
	$amount = $dollars+$cents;
	if($amount > 0)
	{
		if(mysql_query("INSERT INTO $database.`incentivos`(time,code,amount) VALUES('$time','$code','$amount')"))
		{
			$dollars = substr($amount,0,strlen($amount)-2);
			$dollars = (strlen($dollars) > 0) ? $dollars : "0";
			$cents = substr($amount,-2);
			$cents = (strlen($cents) < 2) ? "0".$cents : $cents;
echo<<<ADMIN
 <CENTER>
  <DIV style='width:300px; border:2px solid #DEDEDE; background:#F8F8F8'><b>Codigo Agregado!</b><br />
   Amount: $dollars.$cents | Code:$code
  </DIV><br />
 </CENTER>
ADMIN;
		}
		else
		{
			alert("Error inserting donation: ".mysql_error());
		}
	}
}
echo<<<ADMIN

 <TABLE style="width:600px">
  <TR><TD>
    <CENTER>
     <FORM name="donations"><b>Cantidad:</b><br />
     $<INPUT id="addDollars" size=2 maxlength=2>.<INPUT id="addCents" size=2 maxlength=2>
     <input type="button" onClick="return LINK_ajax('adminincentivos.php?addDollars='+document.donations.addDollars.value+'&addCents='+document.donations.addCents.value,'main_div');" value="Add Donation">
     </FORM><br /><br />
    </CENTER>
   Donations to date:
   <TABLE style="width:100%">
    <TR style="font-weight:bold"><TD style="width:40px">
     ID
    </TD><TD style="width:120px">
     Fecha
    </TD><TD>
     Codigo
    </TD><TD style="width:60px">
     Cantidad
    </TD><TD style="width:160px">
     Recipient
    </TD></TR>
ADMIN;

 $donate_sql = "SELECT * FROM $database.`incentivos` ORDER BY `id` DESC";
 $donate_qry = mysql_query($donate_sql) or die(mysql_error());
 while($donate_row = mysql_fetch_object($donate_qry))
 {
	$id = $donate_row->id;
	$date = date("M d, Y",$donate_row->time);
	$code = $donate_row->code;
	$amount = $donate_row->amount;
	$dollars = substr($amount,0,strlen($amount)-2);
	$dollars = ($dollars > 0) ? $dollars : "0";
	$cents = substr($amount,-2);
	$cents = (strlen($cents) < 2) ? "0".$cents : $cents;
	if($donate_row->claimed)
	{
		$rec_id = $donate_row->recipient;
		$rec_qry = mysql_query("SELECT userid FROM $rodb.`login` WHERE account_id='$rec_id'");
		if(mysql_num_rows($rec_qry))
		{
			$rec_row = mysql_fetch_object($rec_qry);
			$recipient = $rec_row->userid;
		}
		else
		{
			$recipient = "Account removed";
		}
	}
	else
	{
		$recipient = "Not Claimed";
	}
echo<<<ADMIN
    <TR><TD>
     $id
    </TD><TD>
     $date
    </TD><TD>
     $code
    </TD><TD>
     $$dollars.$cents
    </TD><TD>
     $recipient
    </TD></TR>
ADMIN;
 }
echo<<<ADMIN
   </TABLE>

  </TD></TR>
 </TABLE>

ADMIN;
closetable();

fim();
?>
