<?php

require_once(__DIR__ . "/../config/config.php");
require_once(__DIR__ . "/../util/web.php");
//ensure only todologged in users are able to call this script
require_once(__DIR__ . "/../controller/ensure_session.php");
require_once(__DIR__ . "/../service/data_service.php");
require_once(__DIR__ . "/../service/todo_service.php");

if(session_id() == '' || !isset($_SESSION)) {
    todolog("todo.php | No session found. Starting new session");
    // session isn't started
    session_start();
}

if (!isset($_POST["action"])) {
    todolog("todo.php | No action found. Redirecting to home");
    redirect(VIEWS . "/home.php");
}

$action = $_POST["action"];
//------------------------------------ADD---------------------------------------
if ($action === "Add") {
    todolog("todo.php | Add action");
    if (isset($_POST["description"]) && isset($_POST["scheduledDate"])) {        
        $description = $_POST["description"];
        $scheduledDate = date("Y-m-d",strtotime($_POST["scheduledDate"])); //using this format for MySQL storage
        todolog("todo.php | description: $description");
        todolog("todo.php | scheduled date: $scheduledDate");
        //validate task description
        $descValid = is_todo_description_valid($description);
        $errors = array();
        if (!$descValid) {
            array_push($errors, "Description must not be empty and can have a max of 256 characters");
        }

        $dateValid = is_scheduled_date_valid($scheduledDate);
        if(!$dateValid){
            array_push($errors, "Scheduled date may only be a max of 7 days from today");
        }

        if(count($errors) > 0){
            todolog("todo.php | Validation errors found");
            $_SESSION["errors"] = $errors;
        } else {
            todolog("todo.php | Valid todo. Saving.");
            //valid todo. save.
            $todo = new_todo($description,$scheduledDate,$_SESSION[CURRENT_USER]);
            $_SESSION["success"] = "Saved todo";
        }

    } else {
        todolog("todo.php | No description or date found");
        $errors = array();
        array_push($errors, "Description is required");
        array_push($errors, "Scheduled date is required");
        $_SESSION["errors"] = $errors;
    }
    redirect(VIEWS . "/home.php");
    exit();
}
//------------------------------------EDIT---------------------------------------
else if ($action === "Edit") 
{
    if (isset($_POST["todoId"]))
    {
        $taskId = $_POST["todoId"];
        $_SESSION["todoId"] = $taskId;
        $_SESSION["success"] = "Edit success!!";
        redirect(VIEWS . "/update_task.php");
    }
    else
    {
        $_SESSION["error"] = array("Please select a task");
        redirect(VIEWS . "/home.php");
    }
    exit();
}
//------------------------------------DELETE---------------------------------------
else if ($action === "Delete") 
{
    todolog("todo.php | Trying to delete a todo");
    if (isset($_POST["todoId"])) {
        todolog("todo.php | todo id: " . $_POST["todoId"]);
        delete_todo($_POST["todoId"]);
    } else {
        $_SESSION["errors"] = array("Select a todo");
    }
    redirect(VIEWS . "/home.php");
    exit();
}
//------------------------------------UPDATE---------------------------------------
else if ($action == "Update") 
{
    $_SESSION["errors"] = array("Feature not implemented");
    redirect(VIEWS . "/home.php");
    exit();
}
?>