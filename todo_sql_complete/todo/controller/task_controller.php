<?php
require_once(__DIR__ . "/../util/web.php");
require_once(__DIR__ . "/../service/data_service.php");
require_once(__DIR__ . "/../util/validators.php");


require_once(__DIR__."/../config/constants.php");
require_once(__DIR__."/../controller/ensure_session.php");

if (!isset($_SESSION["todoId"]))
{    
    redirect(VIEWS . "/home.php");
}
$taskId = $_SESSION["todoId"];
$taskDesc = $_POST["description"];
$taskStatus = $_POST["status"];

//validate task description
$valid = validateRequired($taskDesc);
if ($valid) 
{
    update_todo($taskId,$taskDesc,$taskStatus);
} 
else 
{
    $_SESSION["error"] = "Task description is required and can have upto 120 characters";
}

redirect(VIEWS. "/home.php");
exit;
?>
