<?php

require_once(__DIR__."/constants.php");
require_once(__DIR__."/errors.php");

//Error reporting and handling
ini_set('display_errors', 'On');
error_reporting(E_ALL);
set_error_handler("dev_error_handler");

//Data source configuration
define("DATASOURCE_TYPE", DATASOURCE_MYSQL);
define("LOG_FILE",__DIR__ . "/../logs/todo.log");

?>