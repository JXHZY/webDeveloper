<?php
require_once(__DIR__ . "/../config/config.php");
require_once(__DIR__ . "/../model/domain.php");
require_once(__DIR__ ."/../config/constants.php");
require_once(__DIR__ . "/../util/security.php");

if(DATASOURCE_TYPE === DATASOURCE_JSON){
	require_once(__DIR__ . "/../model/json_data_access.php");
} else if(DATASOURCE_TYPE === DATASOURCE_CSV) {
	require_once(__DIR__ . "/../model/csv_data_access.php");
} else if(DATASOURCE_TYPE === DATASOURCE_MYSQL){
	require_once(__DIR__ . "/../model/mysql_data_access.php");
}

/**
	User Methods
*/

//Has to be called before newUser
function verify_username_availability($userName){
	$exists = false;
	if(get_user($userName)){
		$exists = true;
	}
	return $exists;
}

function new_todo_user($firstName,$lastName,$email,$password){
	return new_user($firstName,$lastName,$email,$password,user_type_USER);
}

function new_admin($firstName,$lastName,$email,$password){
	return new_user($firstName,$lastName,$email,$password,user_type_ADMIN);
}

//Username is assumed to be unique. Private. //Ensure that $email does not exist in the system
function new_user($firstName,$lastName,$email,$password,$userType){	
	$salt = generate_salt();
	$encPassword = encrypt_password($password,$salt);
	
	$user = create_user_object($firstName,$lastName,$email,$encPassword,$salt,$userType);
	save_user_object($user);

	return $user;
}

function get_users() {
	return get_user_array();
}

//Username is assumed to be unique
function get_user($userName){
	return get_user_object($userName);
}

/**
 	TODO Methods
*/
function new_todo($desc, $date, $owner) {
	$id = generate_todo_id();
	$todo = create_todo_object($id,$desc,$date,$owner);
	save_todo_object($todo);
}

function get_todos($owner){
	return get_todo_array($owner);
}

function get_todo($id){
	return get_todo_object($id);
}

function delete_todo($id){
	delete_todo_object($id);
}

function update_todo($taskId,$desc,$status){
	switch($status){
		case "N":
			$status = "Not Started";
			break;
		case "S":
			$status = "Started";
			break;
		case "M":
			$status = "Midway";
			break;
		case "C":
			$status = "Completed";
			break;
		default:
			break;
	}
	update_todo_list($taskId,$desc,$status);
}
?>
