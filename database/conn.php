<?php
session_start();

$db_server = "localhost";
$db_name = "asah_otak";
$db_username = "root";
$db_password = ""; 

$mysqli = new mysqli($db_server,$db_username,$db_password,$db_name);

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
?>