<!DOCTYPE html PUBLIC "-//W3C//DTD XMTML 1.0 Transitional//EN" >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Upload Files</title>
</head>
<body>
<form action="doAction5.php" method="post" enctype="multipart/form-data">   
	Pleas choose the upload file：<input type="file" name="myFile[]"/> <br/>
	Pleas choose the upload file：<input type="file" name="myFile[]"/> <br/>
	Pleas choose the upload file：<input type="file" name="myFile[]"/> <br/>
	Pleas choose the upload file：<input type="file" name="myFile[]"/> <br/>
	Pleas choose the upload file：<input type="file" name="myFile[]"/> <br/>
	<!-- html5的话 可以用一句代替上面五个   Pleas choose the upload file：<input type="file" name="myFile[]" multiple="multiple"/> <br/>><-->
	<!-- //print_r($_FILES);    //返回的是一个三维数组（name="myFile[]"）><-->
<input type="submit" value="Upload"/>
</form>
</body>
</html>