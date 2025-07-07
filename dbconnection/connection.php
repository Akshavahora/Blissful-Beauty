<?php

$host = "localhost";
$config_username = "root";
$password = "";
$db = "cosmetic";

// Create a connection
$conn = mysqli_connect($host, $config_username, $password, $db);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
