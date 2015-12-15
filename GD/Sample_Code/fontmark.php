<?php
//@YingZhou
$src = "nailiang.jpg";
$info = getimagesize($src);
$type = image_type_to_extension($info[2],false);
$fun = "imagecreatefrom{$type}";
$image = $fun($src);
$font = "1.ttf";
$content = "Ying";
$col = imagecolorallocatealpha($image, 0, 0, 0, 50);
imagettftext($image, 20, 0, 20, 30, $col, $font, $content);
header("Content-type:".$info['mime']);
$func = "image{$type}";
$func($image);
$func($image,'newiamge.'.$type);
imagedestroy($image);
?>