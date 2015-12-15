<?php
//down load file, @YingZhou
$filename = $_GET['filename'];
//头信息
//header('content-disposition:attachment;filename='.$filename);
header('content-disposition:attachment;filename='.basename($filename));			//去掉多余的路劲
//header('content-disposition:attachment;filename=king_'.$filename);  //带固定名字前缀
header('content-length:'.filesize($filename));

readfile($filename);
?>