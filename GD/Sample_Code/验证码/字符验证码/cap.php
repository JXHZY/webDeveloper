<?php
	require "createCapCode.php";
	$image = new captchCode();
	$image->createCaptchCode(100,30,5,2,6);
?>