<?php
	if (is_ajax())
	{
	    if (isset($_POST["action"]) && !empty($_POST["action"]))
	    { //Checks if action value exists
	      $action = $_POST["action"];
	      switch($action) //Switch case for value of action
	      {
	      	case "first": firstline(); break;
	      	case "fatherid": subline($_POST["fatherid"],$_POST["deep"]);break;
	      }
	    }
  	}
    //Function to check if the request is an AJAX request
  	function is_ajax(){
    	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
  	}
  
  	function firstline()
  	{
  		$fileName = "data.json";
		$contents = file_get_contents($fileName);
		$contents = json_decode($contents,true);
  		$length = count($contents['level1']);
  		$returnString = "";
		$i=0;
		while($i<$length)
		{
			$returnString .= '<div class="row firstline" id="'.$contents['level1'][$i]['id'].'" style="background-color:'.$contents['level1'][$i]['color'].'" onclick="subside('.$contents['level1'][$i]['id'].','.$contents['level1'][$i]['level'].')"> '.$contents['level1'][$i]['name'].'</div>';
			$i++;
		}
		echo $returnString;
  	}

  	function subline($fatherid,$deep)
  	{
  		$fileName = "data.json";
		$contents = file_get_contents($fileName);
		$contents = json_decode($contents,true);
		$returnString = "";
		switch($deep) //Switch case for value of action
	      {
	      	case "1": $level="level2";break;
	      	case "2": $level="level3";break;
	      	case "3": $level="level4";break;
	      	case "4": $level="level5";break;
	      }
  		$length = count($contents[$level]);
		$i=0;
		while($i<$length)
		{
			if($contents[$level][$i]['father']==$fatherid)
			{
				$returnString .= '<div class="row" id="'.$contents[$level][$i]['id'].'" style="background-color:'.$contents[$level][$i]['color'].'" onclick="subside('.$contents[$level][$i]['id'].','.$contents[$level][$i]['level'].')"> '.$contents[$level][$i]['name'].'</div>';
			}
			$i++;
		}
		echo $returnString;
  	}
?>