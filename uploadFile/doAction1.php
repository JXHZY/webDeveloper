<?php
//接收页面
header('content-type:text/html;charset=utf-8');
//$_FILES 上传文件变量的信息
print_r($_FILES);
//1.通过$_FILES文件上传变量接收上传文件信息
$fileInfo = $_FILES['myFile'];
$filename = $fileInfo['name'];
$type = $fileInfo['type'];
$size = $fileInfo['size'];
$tmp_name = $fileInfo['tmp_name'];
$error = $fileInfo['error'];

//2.判断下错误号，只有为0或者是UPLOAD_ERR_OK，没有发生错误上传成功
if($error===UPLOAD_ERR_OK)
{
	if(move_uploaded_file($tmp_name,"uploads/".$filename))			//把临时文件移动到指定目录
	{
		echo 'File'.$filename.' upload success!';
	}
	else
	{
		echo 'File'.$filename.' upload Fail!';
	}
}
else
{
	//匹配错误信息
	switch($error)
	{
		case 1:
			echo 'Oversize of upload_max_filesize in PHP.ini';			//上传文件超过了PHP配置文件中upload_max_filesize选项的值
			break;
		case 2:
			echo 'Over size of MAX_FILE_SIZE!';      //超过了表单MAX_FILE_SIZE限制的大小
			break;
		case 3:
			echo 'Just upload some parts of the file!';		//文件部分被上传
			break;
		case 4:
			echo 'Didn\'t choose any file to upload!';		//没有选择上传文件
			break;
		case 6:
			echo 'Didn\'t find the temporary directory!';		//没有找到临时目录
			break;
		case 7:
		case 8:
			echo 'System Error!';				//系统错误
			break;
	}
}
?>