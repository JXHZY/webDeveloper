<?php
	class upload
	{
		protected $fileName;
		protected $maxSize;
		protected $allowMime;
		protected $allowExt;
		protected $uploadPath;
		protected $imgFlag;
		protected $fileInfo;
		protected $error;
		protected $ext;
		protected $destination;

		/*-------------------------------构造函数--------------------------*/
		public function __construct($fileName = 'myFile', $uploadPath='./uploads',$imgFlag = true, $maxSize=52428809, $allowExt = array('jpeg','jpg','png','gif','wbmp'), $allowMime = array('image/jpeg','image/png','image/gif'))
		{
			$this->fileName = $fileName;
			$this->maxSize = $maxSize;
			$this->allowMime = $allowMime;
			$this->allowExt = $allowExt;
			$this->uploadPath = $uploadPath;
			$this->imgFlag = $imgFlag;
			$this->fileInfo = $_FILES[$this->fileName];
		}

		/*-------------------------------判断错误号，是否可以upload--------------*/
		protected function checkError()
		{
			if(!is_null($this->fileInfo))
			{
				if($this->fileInfo['error'] > 0)
				{
					//匹配错误信息
					switch($this->fileInfo['error'])
					{
						case 1:
							$this->error = 'Oversize of upload_max_filesize in PHP.ini';			//上传文件超过了PHP配置文件中upload_max_filesize选项的值
							break;
						case 2:
							$this->error = 'Over size of MAX_FILE_SIZE!';      //超过了表单MAX_FILE_SIZE限制的大小
							break;
						case 3:
							$this->error = 'Just upload some parts of the file!';		//文件部分被上传
							break;
						case 4:
							$this->error = 'Didn\'t choose any file to upload!';		//没有选择上传文件
							break;
						case 6:
							$this->error = 'Didn\'t find the temporary directory!';		//没有找到临时目录
							break;
						case 7:
							$this->error = 'You can\'t write this file!';			//文件不可写
							break;
						case 8:
							$this->error = 'System Error by PHP!';				//由于PHP的扩展程序中断文件上传
							break;
					}
					return false;
				}
				else
				{
					return true;
				}
			}
			else
			{
				$this->error = 'Upload File Error!!!!';
				return false;
			}			
		}

		/*-------------------------------判断文件大小是否超过限制--------------------------*/
		protected function checkSize()
		{
			if($this->fileInfo['size'] > $this->maxSize)
			{
				$this->error = 'Over Size!!';
				return false;
			}
			return true;
		}

		/*-------------------------------判断文件是否正确-------------------------*/
		protected function checkExt()
		{
			$this->ext = strtolower(pathinfo($this->fileInfo['name'],PATHINFO_EXTENSION));			//取得上传文件的扩展名,方法二
			if(!in_array($this->ext,$this->allowExt))
			{
				$this->error = 'Wrong file type!!'; 				//非法文件类型
				return false;
			}
			return true;
		}

		/*-------------------------------判断文件是否是允许的文件类型--------------*/
		protected function checkMime()
		{
			if(!in_array($this->fileInfo['type'],$this->allowMime))
			{
				$this->error = 'The file type is not allow!!'; 				//不允许的文件类型
				return false;
			}
			return true;
		}

		/*-------------------------------判断文件是否是真实的图片(不是仅仅后缀名正确)--------------*/
		protected function checkTrueImg()
		{
			if($this->imgFlag)
			{
				if(!@getimagesize($this->fileInfo['tmp_name']))
				{
					$this->error = 'Not the really picture!!';		//不是真正的图片类型
					return false;
				}
			}
			return true;
		}

		/*-------------------------------判断文件是否是通过HTTP POST方式上传来的--------------*/
		protected function checkHTTPPost()
		{
			if(!is_uploaded_file($this->fileInfo['tmp_name']))
			{
				$this->error = 'The file is not upload by HTTP POST'; 			//文件不是通过HTTP POST方式上传来的
				return false;
			}
			return true;
		}

		/*-------------------------------上传不成功，输出错误信息-------------------*/
		protected function showError()
		{
			exit('<span style="color:red">'.$this->error.'</span>');
		}

		/*-------------------------------判断上传的对应目录在不----------------------*/
		protected function checkUploadPath()
		{
			if(!file_exists($this->uploadPath)) 			//当上传目录不存在的时候，创建目录
			{
				mkdir($this->uploadPath,0777,true);
			}
		}

		/*-------------------------------确保文件名唯一，防止文件名重复式，旧文件被覆盖----------------------*/
		protected function getUniName()
		{
			return md5(uniqid(microtime(true),true));
		}

		/*-------------------------------上传文件----------------------*/
		public function uploadFile()
		{
			if($this->checkError() && $this->checkSize() && $this->checkExt() && $this->checkMime() && $this->checkTrueImg() && $this->checkHTTPPost())
			{
				$this->checkUploadPath();
				$this->uniName = $this->getUniName();
				$this->destination = $this->uploadPath.'/'.$this->uniName.'.'.$this->ext;
				if(@move_uploaded_file($this->fileInfo['tmp_name'],$this->destination))			//把临时文件移动到指定目录
				{
					return $this->destination;
				}
				else
				{
					$this->error = 'File upload faile!!';
					$this->showError();
				}
			}
			else
			{
				$this->showError();
			}
		}

	}
?>