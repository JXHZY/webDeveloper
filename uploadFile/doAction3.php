<?php
header('content-type:text/html;charset=utf-8');

include_once 'singleFileUpload.php';
$fileInfo = $_FILES['myFile'];

//function singleFileUpload($fileInfo,$allowExt = array('jpeg','jpg','png','gif','wbmp'),$maxSize = 2097152,$path = 'uploads',$flag = true)
$newFile = singleFileUpload($fileInfo,$allowExt = array('jpeg','jpg','png','gif','wbmp'),$maxSize = 2097152,$path = 'hello',$flag = true);
print_r($newFile);

// $newFile = singleFileUpload($fileInfo);
// print_r($newFile);
?>