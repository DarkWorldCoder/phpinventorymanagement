<?php
$localhost = "db";  // service name of the MySQL container in Docker Compose
$username = "ayush";
$password = "ayush123";  // Missing semicolon fixed here
$dbname = "store";

// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);

// check connection
if ($connect->connect_error) {
  die("Connection Failed: " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}
?>
