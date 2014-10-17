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

opentable("Sancion Log");
?>
<br />
<?php

if(isset($_GET["DeleteSancion"]))
{
        $char_id = $_GET["DeleteSancion"];
        $query = sprintf("DELETE FROM `sancion` WHERE char_id = '". mysql_real_escape_string($char_id) ."' LIMIT 1");
                if(execute_query($query, "sancion.php"))
                {
                        echo("Character Mute Successfully Lifted!<br /><br />");
                }
                else
                {
                        echo("Character Mute Could NOT Be Lifted!<br /><br />");
                }
        echo '<span style="cursor:pointer" onMouseOver="this.style.color=\'#897cb4\'" onMouseOut="this.style.color=\'#000000\'" onclick="LINK_ajax(\'sancion.php\',\'main_div\',\'sancion\');"><strong>[ Go Back ]</strong></span>';
}
else
{
       
        if($GET_cmd == "Mute")
        {
                $error = 0;
                if((!$GET_char_id)){ alert("Nombre de la cuenta o personaje"); $error++; }
                if((!$GET_mute_for)){ alert("Tipo de Sancion"); $error++; }
                if(!$GET_reason){ alert("Motivo de la Sancion"); $error++; }

                if(!$error || $error == 0)
                {
                        $query = sprintf("INSERT INTO `sancion` VALUES ('". $GET_char_id ."', '". $GET_mute_for ."', '". $GET_reason ."')");
                        if(execute_query($query, "sancion.php"))
                        {
                                alert("Se guardado Corectamente!");
                        }
                        else
                        {
                                alert("No se ha guardado");
                        }
                }
        }

        ?>
        <form id="sancion" onsubmit="return GET_ajax('sancion.php','main_div','sancion')">
        <table width="504" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td align="left">Nombre (cuenta o char) : <input type="text" name="char_id" maxlength="20"></td>
          </tr>
          <tr>
            <td align="left">Tipo de sancion  : 
              <input type="text" name="mute_for" maxlength="20"> 
              Minutos</td>
          </tr>
          <tr>
            <td align="left">Razon de sancion :              <input size="50" type="text" name="reason" maxlength="200"></td>
          </tr>
          <tr>
            <td align="left"><input name="cmd" type="submit" id="cmd" value="Mute"> <input type="reset" value="Reset"></td>
          </tr>
        </table>
        <br />
        
        </form>
        <hr size=1 noshade>
        <br />
Esta lista no se actualiza automaticamente es necesario hacer refresh para actualizarla.<br />
        <br />
        <br />
        <?php

        $query = sprintf("SELECT * FROM sancion");
        $result = execute_query($query, "sancion.php");

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
            $bgCol = '#656565';
          }
          else {
            $bgCol = '#2D2D2D';
          }

          $char_id = htmlformat($line[0]);
          $mute_for = htmlformat($line[1]);
          $reason = htmlformat($line[2]);

          echo '<tr>
            <td align="center" bgcolor="'. $bgCol .'">'. $char_id .'</td>
            <td align="center" bgcolor="'. $bgCol .'">'. $mute_for .' Mins</td>
            <td align="center" bgcolor="'. $bgCol .'">'. $reason .'</td>
            <td align="center" bgcolor="'. $bgCol .'"><span style="cursor:pointer" onMouseOver="this.style.color=\'#897cb4\'" onMouseOut="this.style.color=\'#000000\'" onclick="LINK_ajax(\'sancion.php?DeleteSancion='.$char_id.'\',\'main_div\',\'sancion\');"><strong>Delete</strong></span></td>
          </tr>';

          $i++;

        }
        echo '</table>';
        
 }

closetable();
fim();

?>