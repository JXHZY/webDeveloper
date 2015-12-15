<?php
//接收页面--服务器端设置限制
header('content-type:text/html;charset=utf-8');

$fileInfo = $_FILES['myFile'];
$maxSize = 2097152;					//字节大小
$allowExt = array('jpeg','jpg','png','gif','wbmp');			//允许上传文件的类型(大小写是有区别的)
$flag = true; 		//是否要求检测上传的图片为真实的图片类型，真=>检测
//1.判断下错误号，只有为0或者是UPLOAD_ERR_OK，没有发生错误上传成功
if($fileInfo['error']===UPLOAD_ERR_OK)
{
	//判断上传文件大小
	if($fileInfo['size'] > $maxSize)
	{
		exit('Over Size!');
	}
	//判断上传文件类型
	//用strtolower是为了统一大小写,为了allowExt可以只写小写就可以了
	//$ext = strtolower(end(explode('.',$fileInfo['name'])));			//取得上传文件的扩展名,方法一
	$ext = strtolower(pathinfo($fileInfo['name'],PATHINFO_EXTENSION));			//取得上传文件的扩展名,方法二
	if(!in_array($ext,$allowExt))
	{
		exit('Wrong file type!!'); 				//非法文件类型
	}
	//判断文件是否是通过HTTP POST方式上传来的
	if(!is_uploaded_file($fileInfo['tmp_name']))
	{
		exit('The file is not upload by HTTP POST'); 			//文件不是通过HTTP POST方式上传来的
	}
	//检测上传的是否为真实的图片类型(防止病毒 和故意调皮更改文件后缀)
	//getimagesize($filename)=>得到指定图片的信息，如果是图片，数组形式返回图片信息；否则如果不是图片，返回false
	if($flag)
	{
		if(!getimagesize($fileInfo['tmp_name']))
		{
			exit('Not the really picture!!');		//不是真正的图片类型
		}
	}

	$path = 'uploads';
	if(!file_exists($path)) 			//当上传目录不存在的时候，创建目录
	{
		mkdir($path,0777,true);
		chmod($path,0777);
	}
	$uniName = md5(uniqid(microtime(true),true)).'.'.$ext;			// 确保文件名唯一，防止文件名重复式，旧文件被覆盖
	$destination = $path.'/'.$uniName;
	if(move_uploaded_file($fileInfo['tmp_name'],$destination))			//把临时文件移动到指定目录
	{
		echo 'File'.$uniName.' upload success!';
	}
	else
	{
		echo 'File'.$uniName.' upload Fail!';
	}
}
else
{
	//匹配错误信息
	switch($fileInfo['error'])
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