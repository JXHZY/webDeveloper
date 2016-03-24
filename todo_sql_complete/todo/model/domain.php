<?php
require_once(__DIR__."/../config/constants.php");

function create_user_object($firstName,$lastName,$email,$password,$salt,$type,$enabled=true){
	$user = array (
		user_FIRST_NAME=>$firstName,
		user_LAST_NAME=>$lastName,
		user_EMAIL=>$email,
		user_PASSWORD=>$password,
		user_SALT=>$salt,
		user_TYPE=>$type,
		user_ENABLED=>$enabled
	);

	return $user;
}

//'owner' may not be used in all implementations. for instance, json data access does not need this
//however, relational db implementations will need it. since we are using a common data format
//we will have the field
function create_todo_object($id,$desc,$date,$owner,$status=todo_status_NOT_STARTED){
	$todo = array (
		todo_ID=>$id,
		todo_DESCRIPTION=>$desc,
		todo_DATE=>$date,
		todo_OWNER=>$owner,
		todo_STATUS=>$status
	);

	return $todo;
}

?>