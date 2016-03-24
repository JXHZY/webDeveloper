<?php
//data source
define("DATASOURCE_MEMORY","MEMORY");
define("DATASOURCE_JSON","JSON");
define("DATASOURCE_CSV","CSV");
define("DATASOURCE_MYSQL","MYSQL");
//domain
define("user_type_USER", "user_type.USER");
define("user_type_ADMIN", "user_type.ADMIN");
define("user_FIRST_NAME","user.FIRST_NAME");
define("user_LAST_NAME","user.LAST_NAME");
define("user_EMAIL","user.EMAIL");
define("user_PASSWORD","user.PASSWORD");
define("user_SALT","user.SALT");
define("user_TYPE","user.TYPE");
define("user_ENABLED","user.ENABLED");
define("todo_ID","todo.ID");
define("todo_DESCRIPTION","todo.DESCRIPTION");
define("todo_DATE","todo.DATE");
define("todo_OWNER","todo.OWNER");
define("todo_STATUS","todo.STATUS");

define("todo_status_NOT_STARTED","Not Started");
define("todo_status_STARTED","Started");
define("todo_status_MIDWAY","Midway");
define("todo_status_COMPLETE","Complete");

define("todo_format_DATE","m-d-Y");
//Application paths


define("APPLICATION_NAME","todo_sql_complete/todo");
//echo $_SERVER["SERVER_NAME"];
define("APPLICATION_ROOT", "http://".$_SERVER["SERVER_NAME"] . "/" . APPLICATION_NAME);
//echo APPLICATION_ROOT;
define("CSS", APPLICATION_ROOT . "/resources/css");
define("JS", APPLICATION_ROOT . "/resources/js");
define("CONTROLLER", APPLICATION_ROOT . "/controller");
define("VIEWS", APPLICATION_ROOT . "/views");

define("CURRENT_USER","CURRENT_USER");

define("mysql_HOSTNAME", "localhost");
define("mysql_PORT", "3306");
define("mysql_USERNAME", "root");
define("mysql_PASSWORD", "root");
define("mysql_DATABASE","todo");
?>