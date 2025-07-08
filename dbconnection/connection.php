<?php
$host = "mysql"; // Use service name from docker-compose.yml
$config_username = "root";
$password = "root";
$db = "cosmetic"; // or test_db, based on your setup

$conn = mysqli_connect($host, $config_username, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
