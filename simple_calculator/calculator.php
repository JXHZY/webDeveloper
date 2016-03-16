<?php
if(isset($_POST['submit'])){$value1 = $_POST['value1'];
$value2 = $_POST['value2'];
$action = $_POST['action'];
if((!is_numeric($value2))&&(!is_numeric($value1)))
{
	echo "You must input a number!!<br>";
}

if($action=="+"){
echo "<b>Your Answer is:</b><br>";
echo $value1+$value2;
}

if($action=="-"){
echo "<b>Your Answer is:</b><br>";
echo $value1-$value2;
}

if($action=="*"){
echo "<b>Your Answer is:</b><br>";
echo $value1*$value2;
}

if($action=="/"){
echo "<b>Your Answer is:</b><br>";
echo $value1/$value2;
}
}
?>