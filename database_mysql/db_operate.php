<?php
include_once 'db_connect.php';

// sql to create table
$sql = "CREATE TABLE user
(
id int(11) NOT NULL AUTO_INCREMENT,
name varchar(255),
PRIMARY KEY (id)
)";

if ($mysqli->query($sql) === TRUE) {
    echo "Table user created successfully";
    echo "<br>";
} else {
    echo "Error creating table: " . $mysqli->error;
}

// sql to create table
$sql = "CREATE TABLE salary
(
  id int(11) NOT NULL,
  userId int(11) NOT NULL,
  saldate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  sum decimal(10,3) DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_user FOREIGN KEY (userId) REFERENCES user(id)
)";

if ($mysqli->query($sql) === TRUE) {
    echo "Table salary created successfully";
} else {
    echo "Error creating table: " . $mysqli->error;
}

?>
