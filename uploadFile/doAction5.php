<?php
	header('content-type:text/html;charset=utf-8');
	require_once 'uploadFile.php';
	$files = getFiles();
	//print_r($files);
	foreach ($files as $fileInfo)
	{
		$res = uploadFile($fileInfo);
		echo $res['mes'],'<br/>';
		$uploadFiles[] = $res['dest'];
	}
	$uploadFiles = array_values(array_filter($uploadFiles));
	print_r($uploadFiles);
?>