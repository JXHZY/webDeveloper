<?php
	header('content-type:text/html;charset=utf-8');
	require_once 'upload.class.php';
	//$upload = new upload('myFile1');
	$upload = new upload('myFile1','test');
	$dest = $upload->uploadFile();
	echo $dest;
?>