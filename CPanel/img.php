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

if (!isset($GET_img))
	exit(0);

$session = $_SESSION[$CONFIG_name.'sessioncode'];
$code = $session[$GET_img];
$code=substr(strtoupper(md5("Mytext".$code)), 0,6);
captcha(135,40,$code);

exit(0);


function captcha($width,$height,$code) {

$font="./font/ChalkboardBold.ttf";

$font_size = 17;
$image = imagecreate($width, $height);
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 20, 40, 100);
$noise_color = imagecolorallocate($image, 100, 120, 180);

for( $i=0; $i<($width*$height)/3; $i++ ) imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
for( $i=0; $i<($width*$height)/150; $i++ ) imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
$x=3;$y=20;

imagettftext($image, $font_size, rand(-45,45), $x, $y+(rand()%16), $text_color, $font , $code[0]);
imagettftext($image, $font_size, rand(-45,45), $x+23, $y+(rand()%16), $text_color, $font , $code[1]);
imagettftext($image, $font_size, rand(-45,45), $x+46, $y+(rand()%16), $text_color, $font , $code[2]);
imagettftext($image, $font_size, rand(-45,45), $x+69, $y+(rand()%16), $text_color, $font , $code[3]);
imagettftext($image, $font_size, rand(-45,45), $x+92, $y+(rand()%16), $text_color, $font , $code[4]);
imagettftext($image, $font_size, rand(-45,45), $x+115, $y+(rand()%16), $text_color, $font , $code[5]);

header('Content-Type: image/jpeg');
imagejpeg($image);
imagedestroy($image);
}

?>
