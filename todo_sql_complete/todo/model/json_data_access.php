<?php
require_once(__DIR__ . "/../config/config.php");
require_once(__DIR__ . "/domain.php");

//Database files
$users_db_file = __DIR__ . "/../data/users.json";
$todos_db_file = "";
//Database in-memory cache
$usersDB = array();
$todosDB = array();

/**
Private API
*/

function init_users_db(){
	todolog("json_data_access.php | initializing usersDB");
	global $usersDB;
	global $users_db_file;
	if(!$usersDB){		
		$users_json_string = file_get_contents($users_db_file);
		$tmpDB = json_decode($users_json_string);
		$usersCount = count($tmpDB);
		if($usersCount > 0) {
			todolog("json_data_access.php | found $usersCount users");
			$tmpUsers = array();
			for($index=0;$index<$usersCount;$index++){
				$user = $tmpDB[$index];
				$userObj = convert_usr_stdclass_to_map($user);
				array_push($tmpUsers, $userObj);
			}

			$usersDB = $tmpUsers;
		} else {
			$usersDB = array();
		}
	}
}

function init_todos_db(){
	todolog("json_data_access.php | initializing todosDB");
	global $todosDB;
	global $todos_db_file;
	if(!$todosDB){
		$currentUserId = get_current_user_id();
		if(!$currentUserId){
			trigger_error("Please login before trying to access your To Do list");
		}
		$todos_db_file = __DIR__ . "/../data/${currentUserId}.json";
		
		$todos_json_string = file_get_contents($todos_db_file);
		$tmpDB = json_decode($todos_json_string);

		$stdTodos = $tmpDB->todos;
		//print_r($stdTodos);

		$todoCount = count($stdTodos);
		//print_r($todoCount);
		$todosDB = array(
			"nextId"=>$tmpDB->nextId				
		);

		if($todoCount > 0) {
			todolog("json_data_access.php | found $todoCount todos");
			$tmpTodos = array();
			for($index=0;$index<$todoCount;$index++){
				$tdo = $stdTodos[$index];
				$todoObj = convert_todo_stdclass_to_map($tdo);
				array_push($tmpTodos, $todoObj);
			}

			$todosDB["todos"] = $tmpTodos;
		} else {
			$todosDB["todos"] = array();
		}
	}
}

function get_current_user_id(){
	if(session_id() == '' || !isset($_SESSION)) {
	    // session isn't started
	    session_start();
	}

	if(isset($_SESSION[CURRENT_USER])){
		$cusr = $_SESSION[CURRENT_USER];
		$split = explode("@",$cusr);
		return $split[0];
	}
	return false;
}

function convert_usr_stdclass_to_map($usr){
	todolog("json_data_access.php | converting stdclass to usr obj: " . print_r($usr,true));
	return array(
		user_FIRST_NAME=> $usr->firstName,
		user_LAST_NAME=> $usr->lastName,
		user_EMAIL=> $usr->email,
		user_PASSWORD=> $usr->password,
		user_SALT=> $usr->salt,
		user_TYPE=> $usr->type,
		user_ENABLED=> $usr->enabled
	);
}

function convert_todo_stdclass_to_map($tdo){
	todolog("json_data_access.php | converting stdclass to todo obj: " . print_r($tdo,true));
	return array(
		todo_ID=> $tdo->id,
		todo_DESCRIPTION=> $tdo->desc,
		todo_DATE=> $tdo->date,
		todo_STATUS=> $tdo->status
	);
}

function format_todo_for_storage($tdo){
	$map = array();
	$map["id"] = $tdo[todo_ID];
	$map["desc"] = $tdo[todo_DESCRIPTION];
	$map["date"] = $tdo[todo_DATE];
	$map["status"] = $tdo[todo_STATUS];

	return $map;
}

function write_todos_db(){
	global $todosDB;
	global $todos_db_file;
	//convert to file structure
	$db = array();
	$db["nextId"] = $todosDB["nextId"];
	$dbTodos = array();
	$tmpTodos = $todosDB["todos"];
	$noTodos = count($tmpTodos);	
	for($index=0;$index<$noTodos;$index++){
		$tmpTodo = $tmpTodos[$index];
		array_push($dbTodos, format_todo_for_storage($tmpTodo));
	}

	$db["todos"] = $dbTodos;
	//Write to file
	$todos_json_string = json_encode($db);
	file_put_contents($todos_db_file, $todos_json_string);
}



/**
Public API
*/

function save_user_object($user){

}

function get_user_array(){
	return array (
		//map,
		//map
	);
}

function get_user_object($userId){
	global $usersDB;
	init_users_db();
	$userCount = count($usersDB);
	
	if($userCount > 0) {
		todolog("json_data_access.php | trying to retrieve user obj: $userId");
		$user = false;
		for($index=0;$index<$userCount;$index++){
			$usr = $usersDB[$index];
			todolog("json_data_access.php | checking with user obj: " . print_r($usr,true));
			if($usr[user_EMAIL]===$userId){
				//convert $usr to map
				$user = $usr;
				break;
			}
		}

		return $user;
	} else {
		todolog("json_data_access.php | no users in usersDB");
		todolog("json_data_access.php | dumping usersDB: " . print_r($usersDB,true));
	}

	return false;
}


function save_todo_object($todo){
	init_todos_db();
	global $todosDB;	
	//We do not want owner information in the JSON format
	unset($todo[todo_OWNER]);	
	//write JSON record
	$tmpTodos = $todosDB["todos"];
	array_push($tmpTodos, $todo);

	$todosDB["todos"] = $tmpTodos;
	//ensure we have nextId incremented
	$todosDB["nextId"] = $id + 1;
	todolog("json_data_access.php | generated next todo id: " . $todosDB["nextId"]);

	write_todos_db();
}

function get_todo_object($id){
	init_todos_db();
}

function get_todo_array($user){	
	global $todosDB;
	init_todos_db();
	return $todosDB["todos"] ? $todosDB["todos"] : array() ;
}

function delete_todo_object($id){
	global $todosDB;
	init_todos_db();	
	//write JSON record
	$tmpTodos = $todosDB["todos"];
	todolog("json_data_access.php | db: " . print_r($tmpTodos, true));
	$noTodos = count($tmpTodos);
	todolog("json_data_access.php | current no todos: $noTodos");
	$arrayIndex = -1;
	for($index=0;$index<$noTodos;$index++){
		$tmpTodo = $tmpTodos[$index];
		todolog("json_data_access.php | " . print_r($tmpTodo, true));
		if($tmpTodo[todo_ID]==$id){
			$arrayIndex = $index;
			todolog("json_data_access.php | found record at index: $arrayIndex");
			break;
		}
	}

	unset($tmpTodos[$arrayIndex]);

	//Reindex array
	$todosDB["todos"] = array_values($tmpTodos);
	write_todos_db();
}

function generate_todo_id(){
	global $todosDB;
	//ensure db is initialized and available
	init_todos_db();	
	$id = $todosDB["nextId"];
	todolog("json_data_access.php | pulled todo id: $id");	

	return $id;
}


?>