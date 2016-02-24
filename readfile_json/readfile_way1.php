<?php
	if (is_ajax())
	{
	    if (isset($_POST["action"]) && !empty($_POST["action"]))
	    { //Checks if action value exists
	      $action = $_POST["action"];
	      switch($action) //Switch case for value of action
	      {
	      	case "readfilejson": getJsonString(); break;
	      }
	    }
  	}
    //Function to check if the request is an AJAX request
  	function is_ajax(){
    	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
  	}
  
  	function getJsonString()
  	{
	  	//read the file and put the information into a array
		$result = array();
		$information = array("name"=>"",
							 "level"=>"level",
							 "id"=>"",
							 "father"=>"",
							 "details"=>"xxxxxxxxxxxxxxxx");
		$lastNumber = "";
		$myfile = fopen("spices.txt", "r") or die("Unable to open file!");
		while(!feof($myfile)) 
		{
			// echo "~~~~~~~~~~~~~~~~~~~~~~~Start~~~~~~~~~~~~~~~~~~~~~~~~~~";
			// echo "\r\n";
			// echo "lastNumber".$lastNumber;
			// echo "\r\n";
			$keepLine = fgets($myfile);
			$number = strstr($keepLine," ",true);
			// echo "Line;".$keepLine;
			// echo "\r\n";
			if(strlen($number) == 0) 		//Has no string part
			{
				$number = $keepLine;
				$lastNumber = $number;
				continue;
			}
			else 		//Has the string part
			{
				if(stripos($number,"."))     //Has the numebr part
				{
					$string = strstr($keepLine," ");
					$lastNumber = $number;
				}
				else 		//Has no number part
				{
					$string = $keepLine;
					$number = $lastNumber;
				}
			}
			// echo "String:".$string;
			// echo "\r\n";
			// echo "Number:".$number;
			// echo "\r\n";
			// echo "+++++++++++++++++++";
			// echo "\r\n";
			$finalNumber = str_ireplace(".","",$number);
			$information["name"]= trim($string);
			$information["id"] = $finalNumber;
			$information["level"] = strlen($finalNumber);
			$information["father"] = substr($finalNumber,0,-1);
			//var_dump($information);
			array_push($result,$information);
			// echo "--------------end-----------";
			// echo "\r\n";
		}
		fclose($myfile);

		//change the array into the string with the json style
		$arrlength=count($result);
		//echo $arrlength;
		$jsonString = "";
		for($x=0;$x<$arrlength;$x++)
		{
			if($x==($arrlength-1))
			{
				$jsonString .= "{\"name\":\"".$result[$x]["name"]."\",\"level\":\"".$result[$x]["level"]."\",\"id\":\"".$result[$x]["id"]."\",\"father\":\"".$result[$x]["father"]."\",\"details\":\"".$result[$x]["details"]."\"}\r\n";
			}
			else
			{
				$jsonString .= "{\"name\":\"".$result[$x]["name"]."\",\"level\":\"".$result[$x]["level"]."\",\"id\":\"".$result[$x]["id"]."\",\"father\":\"".$result[$x]["father"]."\",\"details\":\"".$result[$x]["details"]."\"},\r\n";
			}
		}
		echo $jsonString;
  	}
?>