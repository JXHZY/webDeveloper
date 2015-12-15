<?php
	class captchCode
	{
		private $image;

		public function __construct()
		{
			session_start();
		}

		// $style==0, just has the number
		// $style == 1 has it own content lib(any character)
		public function createCaptchCode($width,$height,$number,$style,$fontsize)
		{
			$captch_code = "";

			$this->image = imagecreatetruecolor($width,$height);
			$bgcolor = imagecolorallocate($this->image,255,255,255);
			imagefill($this->image,0,0,$bgcolor);

			if($style == 0)
			{
				for($i = 0; $i<$number; $i++){
				//the color of the number
				$fontcolor = imagecolorallocate($this->image,rand(0,120),rand(0,120),rand(0,120));
				$fontcontent = rand(0,9);
				$captch_code .= $fontcontent;
				//where to write these numbers
				$x = ($i*$width/$number) + rand(5,10);
				$y = rand(5,10);
				//write number to the picture
				imagestring($this->image,$fontsize,$x,$y,$fontcontent,$fontcolor);
				}
			}
			else
			{
				for($i = 0; $i<$number; $i++){
				//the color
				$fontcolor = imagecolorallocate($this->image,rand(0,120),rand(0,120),rand(0,120));
				//创建字典=>验证码可能包含的数字＋字符
				$data='abcdefghijklmnpqrstuvwxyz123456789';
				$fontcontent = substr($data,rand(0,strlen($data)),1);

				$captch_code .= $fontcontent;
				//where to write these numbers
				$x = ($i*$width/$number) + rand(5,10);
				$y = rand(5,10);

				//write number to the picture
				imagestring($this->image,$fontsize,$x,$y,$fontcontent,$fontcolor);
				}
			}

			$_SESSION['authcode'] = $captch_code;

			//创建点干扰元素
			for($i=0;$i<200;$i++)
			{
				$pointcolor = imagecolorallocate($this->image, rand(50,200), rand(50,200), rand(50,200));
				imagesetpixel($this->image, rand(1,99), rand(1,29), $pointcolor);
			}

			//创建线的干扰元素
			for($i=0;$i<5;$i++)
			{
				$linecolor = imagecolorallocate($this->image, rand(80,200),rand(80,200),rand(80,200));
				//write line to the picture
				imageline($this->image,rand(1,99),rand(1,29),rand(1,99),rand(1,29),$linecolor);
			}

			header("Content-type:image/png");
			imagepng($this->image);
		}

		public function __destruct()
		{
			imagedestroy($this->image);
		}

	}



?>