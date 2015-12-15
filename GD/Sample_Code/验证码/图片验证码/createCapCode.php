<?php
//@YingZhou
	class captchCode
	{
		private $image;

		public function __construct()
		{
			session_start();
		}

		// $style==0, just has the number
		// $style == 1 has it own content lib(any character)
		public function createCaptchCode()
		{
			// 图片资料库
			$table = array(
				'pic0' => '猫',
				'pic1' => '狗',
				'pic2' => '熊',
				);
			// 随即获取图片
			$index = rand(0,2);
			$value = $table['pic'.$index];
			$_SESSION['authcode'] = $value;
			// 查找文件路径 获取文件内容
			$filename = dirname(__FILE__).'//pic'.$index.'.jpg';
			$content  = file_get_contents($filename);
			//输出图片到浏览器	
			header('content-type:image/jpg');
			echo $content;
		}

	}
?>