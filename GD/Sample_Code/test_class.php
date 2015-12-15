<?php
//@YingZhou
require "gd_class.php";
$src = "nailiang.jpg";
$water = "12.jpg";
$content = 'Hello World';
$font = "1.ttf";
$color = array(
	0 => 0,
	1 => 0,
	2 => 0,
	3 => 20,
	);
$local = array(
	'x' => 20,
	'y' => 30,
	);
$size = 20;
$angle = 10;
$image = new Image($src);
//$image->fontmark($font,$content,$color,$size,$local,$angle);
$image->imagemark($water,$local,30);
//$image->thumb(300,150);
$image->show();
$image->save("kk");
?>