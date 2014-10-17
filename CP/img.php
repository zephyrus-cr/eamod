<?php

	session_start();
	include_once 'config.php';

	if (!isset($_GET['cod']))
		exit(0);

	$code = $_SESSION[$CONFIG['Name'] . 'securitycode'];

	$im = imagecreate(60, 15);
	$bg = imagecolorallocate($im, 255, 255, 255);
	$ts = imagecolorallocate($im, 0, 255, 255);
	
	$textcolor = imagecolorallocate($im, 255, 0, 0);
	imagecolortransparent($im, $ts);
	
	imagestring($im, 5, 5, 0, substr(strtoupper(md5("Gaiaro" . $code)), 0, 6), $textcolor);
	
	for ($i = 0; $i < 40; $i++)
	{
		$pixelcolor = imagecolorallocate($im, rand()%256, rand()%256, rand()%256);
		imagesetpixel($im, rand()%55 , rand()%15, $pixelcolor);
	}
	
	imagepng($im);
	imagedestroy($im);

?>