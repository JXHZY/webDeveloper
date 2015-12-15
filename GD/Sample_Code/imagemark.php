<?php
//@YingZhou
$src = "nailiang.jpg";
$info = getimagesize($src);
$type = image_type_to_extension($info[2],false);
$fun = "imagecreatefrom{$type}";
$image = $fun($src);

$image_Mark = "12.jpg";
$info2 = getimagesize($image_Mark);
$type2 = image_type_to_extension($info2[2],false);
$fun2 = "imagecreatefrom{$type2}";
$water = $fun2($image_Mark);

imagecopymerge($image, $water, 20, 30, 0, 0, $info2[0], $info2[1], 30);
imagedestroy($water);

header("Content-type:".$info['mime']);
$func = "image{$type}";
$func($image);
$func($image,'newiamge.'.$type);
imagedestroy($image);
?>