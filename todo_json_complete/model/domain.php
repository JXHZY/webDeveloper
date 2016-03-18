<?php
require_once(__DIR__."/../config/constants.php");

function create_user_object($firstName,$lastName,$email,$password,$salt,$type,$enabled=true){
	$user = array (
		user_FIRST_NAME=>$firstName,
		user_LAST_NAME=>$lastName,
		user_EMAIL=>$email,
		user_PASSWORD=>$password,
		user_SALT=>$salt,
		user_TYPE=>$userType,
		user_ENABLED=>$enabled
	);

	return $user;
}

// nextId means the next one node's id will be, you can see the value "nextId" 
function create_todo_object($id,$desc,$date,$status=todo_status_NOT_STARTED){
	$todo = array (
		todo_ID=>$id,
		todo_DESCRIPTION=>$desc,
		todo_DATE=>$date,
		todo_STATUS=>$status		
	);
	return $todo;
}

?>