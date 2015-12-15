<?php
//@YingZhou
 class Image{
 	private $info;
 	private $image;

 	public function __construct($src)
 	{
 		$this->info = getimagesize($src);
 		//$type= image_type_to_extension($this->info[2],false);
 		$this->info = array(
 			'width'=>$this->info[0],
 			'height'=>$this->info[1],
 			'type'=>image_type_to_extension($this->info[2],false),
 			'mime'=>$this->info['mime'],
 			);
		$fun = "imagecreatefrom{$this->info['type']}";
		$this->image = $fun($src);
 	}

 	public function thumb($width, $height)
 	{
 		$image_thumb = imagecreatetruecolor($width, $height);
		imagecopyresampled($image_thumb,$this->image,0,0,0,0,$width,$height,$this->info['width'],$this->info['height']);
		imagedestroy($this->image);
		$this->image = $image_thumb;
 	}

 	public function fontmark($ttf,$content,$color,$size,$local,$angle)
 	{
		$col = imagecolorallocatealpha($this->image, $color[0], $color[1], $color[2], $color[3]);
		imagettftext($this->image, $size, $angle, $local['x'], $local['y'], $col, $ttf, $content);
 	}

 	public function imagemark($water_url,$local,$alpha)
 	{
 		$info2 = getimagesize($water_url);
 		$info2 = array(
 			'width'=>$info2[0],
 			'height'=>$info2[1],
 			'type'=>image_type_to_extension($info2[2],false),
 			'mime'=>$info2['mime'],
 			);
		$fun2 = "imagecreatefrom{$info2['type']}";
		$water = $fun2($water_url);
		imagecopymerge($this->image, $water, $local['x'],$local['y'], 0, 0, $info2['width'], $info2['height'], $alpha);
		imagedestroy($water);
 	}

 	public function show()
 	{
 		header("Content-type:".$this->info['mime']);
		$funs = "image{$this->info['type']}";
		$funs($this->image);
 	}

 	public function save($newName)
 	{
 		$funs = "image{$this->info['type']}";
 		$funs($this->image,$newName.'.'.$this->info['type']);
 	}

 	public function __destruct()
 	{
 		imagedestroy($this->image);

 	}
 }
?>