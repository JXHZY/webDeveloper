<?php
	//<!--Calaulator @YingZhou 03/14/2016-->
	if (is_ajax())
	{
	    if (isset($_POST["action"]) && !empty($_POST["action"]))
	    { //Checks if action value exists
	      $action = $_POST["action"];
	      switch($action) //Switch case for value of action
	      {
	      	case "mul": cal($_POST["value1"],$_POST["value2"],$_POST["operate"]); break;
	      	case "=": cal($_POST["value1"],$_POST["value2"],$_POST["operate"]);break;
	      }
	    }
  	}
    //Function to check if the request is an AJAX request
  	function is_ajax(){
    	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
  	}
  
  	function cal($value1,$value2,$operate)
  	{
  		$number1 = floatval($value1);
  		$number2 = floatval($value2);

  		if($operate=="+"){
		echo $value1 + $value2;
		}

		if($operate=="-"){
		echo $value1 - $value2;
		}

		if($operate=="*"){
		echo $value1 * $value2;
		}

		if($operate=="/"){
		echo $value1 / $value2;
		}
  	}
 ?>