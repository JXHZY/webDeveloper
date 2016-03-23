<?php
include_once 'config.php';
// Create connection
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
// Check connection
if ($mysqli->connect_error){
    die("Connection failed: " . $conn->connect_error);
} 
?>