<?php
require_once(__DIR__ . "/../config/constants.php");
require_once(__DIR__ . "/domain.php");
error_reporting(E_ALL);

//-----------------------------Global Variable--------------------------------
$users_db_file = __DIR__ . "/../data/users.json";


$users_json_string = file_get_contents($users_db_file);
$usersDB = json_decode($users_json_string);

$todosDB = array();

//-----------------Get the user's Id which user already login for this web------------------
function get_current_user_id(){
	if(session_id() == '' || !isset($_SESSION)) {
	    // session isn't started
	    session_start();
	}

	if(isset($_SESSION[CURRENT_USER])){
		$cusr = $_SESSION[CURRENT_USER];
		return $cusr;
	}
	return false;
}

//----------------------save the new user to the json file--------------------------
function save_user_object($user){
	global $users_db_file;
	global $users_json_string;
	global $usersDB;
    $newUser=(object)$user;
    array_push($usersDB, $newUser);
    $data=json_encode($usersDB);
    file_put_contents($users_db_file,$data);
    $todoFile=__DIR__ . "/../data/".$user[user_EMAIL].".json";
    $tododata='{"nextId": 1,"todos": []}';
    file_put_contents($todoFile, $tododata);
}

function get_user_array(){
	return array (
		//map,
		//map
	);
}

//-------------Get the user's information, and change it to PHP may array style by call convert_usr_stdclass_to_map()---------------
function get_user_object($userId){
	global $usersDB;
	$userCount = count($usersDB);
	
	if($userCount > 0) {
		$user = false;
		for($index=0;$index<$userCount;$index++){
			$usr = $usersDB[$index];			
			if($usr->email===$userId){
				//convert $usr to map
				$user = convert_usr_stdclass_to_map($usr);
				break;
			}
		}
		return $user;
	}

	return false;
}

//---------------------------change json style to PHP may array-----------------------
function convert_usr_stdclass_to_map($usr){
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

//---------------------------change json style to PHP may array---------------------------
function convert_todo_stdclass_to_map($tdo){
	return array(
		todo_ID=> $tdo->id,
		todo_DESCRIPTION=> $tdo->desc,
		todo_DATE=> $tdo->date,
		todo_STATUS=> $tdo->status
	);
}

/*-------------------------------------------------------
load todo json file into PHP array style
todosDB[
	"nextId" => number;
	"todos" => array();
]
-------------------------------------------------------*/
function init_todos_db(){
	global $todosDB;
	if(!$todosDB){
		$currentUserId = get_current_user_id();
		if(!$currentUserId){
			trigger_error("Please login before trying to access your To Do list");
		}
		$todos_db_file = __DIR__ . "/../data/${currentUserId}.json";
		
		$todos_json_string = file_get_contents($todos_db_file);
		$tmpDB = json_decode($todos_json_string);

		$stdTodos = $tmpDB->todos;
		$todoCount = count($stdTodos);
		//print_r($todoCount);

		if($todoCount > 0) {
			$todosDB = array(
				"nextId"=>$tmpDB->nextId				
			);

			$tmpTodos = array();
			for($index=0;$index<$todoCount;$index++){
				$tdo = $stdTodos[$index];
				$todoObj = convert_todo_stdclass_to_map($tdo);
				array_push($tmpTodos, $todoObj);
			}

			$todosDB["todos"] = $tmpTodos;
		}
		else
		{
			$todosDB = array(
				"nextId"=>1,
				"todos"=>array()
				);
		}
	}
}


//----------------------save the new todo object to the list---------------------
function save_todo_object($todo){
	global $todosDB;
	init_todos_db();
	$currentUserId = get_current_user_id();
	$filename = __DIR__ . "/../data/${currentUserId}.json";
	$data = $todosDB;
	$data['nextId']++;
	array_push($data['todos'],$todo);
	file_put_contents($filename, json_encode($data));
}

//---------------------------------get the record with this id-----------------------
function get_todo_object($id){
	global $todosDB; 		//has all the record list, save in the global $todosDB	
	init_todos_db();
	$data = $todosDB;
	$taskInfo = array();
	for ($i = 0; $i < count($data['todos']); $i++)
    {
        if ($data['todos'][$i]['id'] == $id)
        {
        	$taskInfo["description"] = $data['todos'][$i]['desc'];
        	$taskInfo["status"] = $data['todos'][$i]['status'];
        }
    }
    return $taskInfo;
}

//----------------------------------Get all the user's todo list, and save in a array---------------
function get_todo_array($user){	
	global $todosDB;
	init_todos_db();	
	return $todosDB["todos"] ? $todosDB["todos"] : array() ;
}

/*---------------get the note id, how many notes, this one's id will be what number
Generate the new todo id number--------------------------*/
function generate_todo_id(){
	$currentUserId = get_current_user_id();
	$filename = __DIR__ . "/../data/${currentUserId}.json";
    $data = json_decode(file_get_contents($filename));
	return $data->nextId;
}

//---------------------------------Delete the selected record-------------------------- 
function delete_todo_list($taskId){
	global $todosDB;
    init_todos_db();
    $data = $todosDB;
    //find the record and remove it
    for ($i = 0; $i < count($data['todos']); $i++)
    {
        if ($data['todos'][$i]['id'] == $taskId)
        {
            array_splice($data['todos'],$i,1);
            $data['nextId']--;
        }
    }    
    //update the josn file
	$currentUserId = get_current_user_id();
	$filename = __DIR__ . "/../data/${currentUserId}.json";
	file_put_contents($filename, json_encode($data));
}

//---------------------------------Update the user's todo record-------------------------- 
function update_todo_list($taskId,$desc,$status){
	global $todosDB;
    init_todos_db();
    $data = $todosDB;
    //find the resord and update it's inforamtion
    for ($i = 0; $i < count($data['todos']); $i++)
    {
        if ($data['todos'][$i]['id'] == $taskId)
        {
        	$data['todos'][$i]['desc'] = $desc;
        	$data['todos'][$i]['status'] = $status;
        }
    }    
    //update the josn file
	$currentUserId = get_current_user_id();
	$filename = __DIR__ . "/../data/${currentUserId}.json";
	file_put_contents($filename, json_encode($data));
}
?>