<?php
	header('content-type:text/html;charset=utf-8');
	include_once 'singleFileUpload.php';

	//print_r($_FILES);    返回的是一个二维数组
	foreach($_FILES as $fileInfo)
	{
		$files[] = singleFileUpload($fileInfo);
	}
	print_r($files);


	/*
	此方法有弊端：
	一个长传不成功，有可能所有都上传不上去了
	*/
?>