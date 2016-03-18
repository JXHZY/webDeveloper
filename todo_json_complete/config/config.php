<?php

require_once(__DIR__."/constants.php");
require_once(__DIR__."/errors.php");

//Error reporting and handling
error_reporting(E_ALL);
set_error_handler("dev_error_handler");

//Data source configuration
define("DATASOURCE_TYPE", DATASOURCE_JSON);

?>