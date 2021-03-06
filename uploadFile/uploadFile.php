<?php
	
	//构建上传文件的信息
	function getFiles()
	{
		foreach($_FILES as $file)
		{
			$i = 0;
			//判断是单位件上传还是多文件上传
			if(is_string($file['name']))	//单个文件上传	
			{
				$files[$i]=$file;			//写成$files[$i]是为了统一return
				$i++;
			}
			elseif(is_array($file['name']))		//多个文件上传
			{
				foreach($file['name'] as $key=>$val)
				{
					$files[$i]['name']=$file['name'][$key];
					$files[$i]['type']=$file['type'][$key];
					$files[$i]['tmp_name']=$file['tmp_name'][$key];
					$files[$i]['error']=$file['error'][$key];
					$files[$i]['size']=$file['size'][$key];
					$i++;
				}
			}
		}

		return $files;
	}

	function uploadFile($fileInfo,$allowExt = array('jpeg','jpg','png','gif','wbmp'),$maxSize = 2097152,$path = 'uploads',$flag = true)
	{
		// $allowExt = array('jpeg','jpg','png','gif','wbmp');
		// $maxSize = 2097152;
		// $path = 'uploads';
		// $flag = true;
		$res['mes']='';
		$res['dest']='';

		if($fileInfo['error']===UPLOAD_ERR_OK)
		{
			//判断上传文件类型
			//用strtolower是为了统一大小写,为了allowExt可以只写小写就可以了
			//$ext = strtolower(end(explode('.',$fileInfo['name'])));			//取得上传文件的扩展名,方法一
			$ext = strtolower(pathinfo($fileInfo['name'],PATHINFO_EXTENSION));			//取得上传文件的扩展名,方法二
			
			if(!in_array($ext,$allowExt))
			{
				$res['mes']=$fileInfo['name'].' Wrong file type!!'; 				//非法文件类型
			}

			//判断上传文件大小
			if($fileInfo['size'] > $maxSize)
			{
				$res['mes']= $fileInfo['name'].' Over Size!';
			}

			//判断文件是否是通过HTTP POST方式上传来的
			if(!is_uploaded_file($fileInfo['tmp_name']))
			{
				$res['mes']= $fileInfo['name'].' The file is not upload by HTTP POST'; 			//文件不是通过HTTP POST方式上传来的
			}

			//检测上传的是否为真实的图片类型(防止病毒 和故意调皮更改文件后缀)
			//getimagesize($filename)=>得到指定图片的信息，如果是图片，数组形式返回图片信息；否则如果不是图片，返回false
			if($flag)
			{
				if(!getimagesize($fileInfo['tmp_name']))
				{
					$res['mes'] = $fileInfo['name'].' Not the really picture!!';		//不是真正的图片类型
				}
			}

			if($res['mes']!=='')
				return $res;

			//当上传目录不存在的时候，创建目录
			if(!file_exists($path)) 			//当上传目录不存在的时候，创建目录
			{
				mkdir($path,0777,true);
				chmod($path,0777);
			}

			// 确保文件名唯一，防止文件名重复式，旧文件被覆盖
			$uniName = md5(uniqid(microtime(true),true)).'.'.$ext;			// 确保文件名唯一，防止文件名重复式，旧文件被覆盖
			$destination = $path.'/'.$uniName;

			if(move_uploaded_file($fileInfo['tmp_name'],$destination))			//把临时文件移动到指定目录
			{
				$res['dest'] = $destination;
				$res['mes'] = $fileInfo['name'].' upload Success!';
				return $res;
			}
			else
			{
				$res['mes'] = $fileInfo['name'].' upload Fail!';
			}
		}
		else
		{
			//匹配错误信息
			switch($fileInfo['error'])
			{
				case 1:
					$res['mes'] = 'Oversize of upload_max_filesize in PHP.ini';			//上传文件超过了PHP配置文件中upload_max_filesize选项的值
					break;
				case 2:
					$res['mes'] = 'Over size of MAX_FILE_SIZE!';      //超过了表单MAX_FILE_SIZE限制的大小
					break;
				case 3:
					$res['mes'] = 'Just upload some parts of the file!';		//文件部分被上传
					break;
				case 4:
					$res['mes'] = 'Didn\'t choose any file to upload!';		//没有选择上传文件
					break;
				case 6:
					$res['mes'] = 'Didn\'t find the temporary directory!';		//没有找到临时目录
					break;
				case 7:
				case 8:
					$res['mes'] = 'System Error!';				//系统错误
					break;
			}
		}
		return $res;
	}




?>