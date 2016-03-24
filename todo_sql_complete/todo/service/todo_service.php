<?php

	function is_todo_description_valid($desc){
		$valid = false;
		//desc needs to be less than 256 chars
		$valid = !is_null($desc) && !empty($desc);
		$noChars = strlen($desc);
		if($valid && $noChars <= 256){
			$valid = true;
		}

		return $valid;
	}

	function is_scheduled_date_valid($date){
		//validate
		return true;
	}

?>