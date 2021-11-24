<?php

$server = "localhost";
$user = "root";
$pass = "root";
$database = "crud_registeration";

$conn = mysqli_connect($server, $user, $pass, $database);
error_reporting(0);

if (!$conn)
{
    die("Connection failed: " . $conn->connect_error);
}

?>
