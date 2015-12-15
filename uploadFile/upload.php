<!DOCTYPE html PUBLIC "-//W3C//DTD XMTML 1.0 Transitional//EN" >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Upload File</title>
</head>
<body>
<form action="doAction3.php" method="post" enctype="multipart/form-data">   
	<!-- method和enctype缺一不可 才能保证上传><-->
	<!-- <input type="hidden" name="MAX_FILE_SIZE" value='176942'/> 控制上传大小 按表单来控制><-->
	Pleas choose the upload file：
	<!--input type="file" name="myFile" accept="image/jpeg,image/gif,image/png"/><-->
<input type="file" name="myFile"/> <br/>
<input type="submit" value="Upload"/>
</form>
</body>
</html>