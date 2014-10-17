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

/*

Offline Muter Interface - Ceres CP Addon Script
Script By Latheesan (AKA Agito-Kun) Of SlyRO.com

*/

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';
include_once 'adminquery.php';

if (!isset($_SESSION[$CONFIG_name.'level']) || $_SESSION[$CONFIG_name.'level'] < $CONFIG['cp_admin'])
        die ("Not Authorized");

opentable("Offline Muter");
?>
<br />
<?php

if(isset($_GET["DeleteMute"]))
{
        $char_id = $_GET["DeleteMute"];
        $query = sprintf("DELETE FROM `manner` WHERE char_id = '". mysql_real_escape_string($char_id) ."' LIMIT 1");
                if(execute_query($query, "offline_muter.php"))
                {
                        echo("Character Mute Successfully Lifted!<br /><br />");
                }
                else
                {
                        echo("Character Mute Could NOT Be Lifted!<br /><br />");
                }
        echo '<span style="cursor:pointer" onMouseOver="this.style.color=\'#897cb4\'" onMouseOut="this.style.color=\'#000000\'" onclick="LINK_ajax(\'offline_muter.php\',\'main_div\',\'offline_muter\');"><strong>[ Go Back ]</strong></span>';
}
else
{
        if($GET_cmd == "Mute")
        {
                $error = 0;
                if(!is_numeric($GET_char_id)){ alert("Enter a valid Char ID"); $error++; }
                if(!is_numeric($GET_mute_for)){ alert("Enter a valid Mute For minutes"); $error++; }
                if($GET_mute_for <= 0){ alert("Mute For minutes must be minimum 1 minute"); $error++; }
                if(!$GET_reason){ alert("Enter a valid Reason for this mute"); $error++; }

                if(!$error || $error == 0)
                {
                        $query = sprintf("INSERT INTO `manner` VALUES ('". $GET_char_id ."', '". $GET_mute_for ."', '". $GET_reason ."')");
                        if(execute_query($query, "offline_muter.php"))
                        {
                                alert("Character Successfully Muted!");
                        }
                        else
                        {
                                alert("Character Coult NOT Be Muted!");
                        }
                }
        }

        ?>
        <form id="offline_muter" onsubmit="return GET_ajax('offline_muter.php','main_div','offline_muter')">
        <table width="504" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td align="center">Char ID : <input type="text" name="char_id" maxlength="20"></td>
          </tr>
          <tr>
            <td align="center">Mute por  : 
              <input size="5" type="text" name="mute_for" maxlength="3"> 
              Minutos</td>
          </tr>
          <tr>
            <td align="center">Razon de Mute :              <input size="50" type="text" name="reason" maxlength="200"></td>
          </tr>
          <tr>
            <td align="center"><input name="cmd" type="submit" id="cmd" value="Mute"> <input type="reset" value="Reset"></td>
          </tr>
        </table>
        <br />
        Trata de no dar Mute 2 veces al mismo char ya que puede causar conflictos
        </form>
        <hr size=1 noshade>
        <br />
Esta lista no se actualiza automaticamente es necesario hacer refresh para actualizarla.<br />
        <br />
        <br />
        <?php

        $query = sprintf("SELECT * FROM manner");
        $result = execute_query($query, "offline_muter.php");

        echo '<table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="50" align="center" bgcolor="#999999"><strong>Char ID</strong></td>
            <td width="60" align="center" bgcolor="#999999"><strong>Mute For</strong></td>
            <td width="310" align="center" bgcolor="#999999"><strong>Mute Reason</strong></td>
            <td width="55" align="center" bgcolor="#999999"><strong>Action</strong></td>
          </tr>';

        $i = 0;
        while($i < 200)
        {

          if (!($line = $result->fetch_row()))
          break;

          if ($i % 2 === 0) {
            $bgCol = '#CCCCCC';
          }
          else {
            $bgCol = '#FFFFFF';
          }

          $char_id = htmlformat($line[0]);
          $mute_for = htmlformat($line[1]);
          $reason = htmlformat($line[2]);

          echo '<tr>
            <td align="center" bgcolor="'. $bgCol .'">'. $char_id .'</td>
            <td align="center" bgcolor="'. $bgCol .'">'. $mute_for .' Mins</td>
            <td align="center" bgcolor="'. $bgCol .'">'. $reason .'</td>
            <td align="center" bgcolor="'. $bgCol .'"><span style="cursor:pointer" onMouseOver="this.style.color=\'#897cb4\'" onMouseOut="this.style.color=\'#000000\'" onclick="LINK_ajax(\'offline_muter.php?DeleteMute='.$char_id.'\',\'main_div\',\'offline_muter\');"><strong>Delete</strong></span></td>
          </tr>';

          $i++;

        }
        echo '</table>';
}

closetable();
fim();

?>