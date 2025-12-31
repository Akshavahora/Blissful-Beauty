<?php
session_start(); // Start the session at the beginning
require_once('../dbconnection/connection.php');

// Retrieve and sanitize user inputs
$Email = mysqli_real_escape_string($conn, $_POST['Email']);
$Password = mysqli_real_escape_string($conn, $_POST['Password']);

// Query to check if the user exists
$select = "SELECT * FROM registration WHERE Email = '$Email' AND Password = '$Password'";
$query = mysqli_query($conn, $select);

if (mysqli_num_rows($query) == 1) {
    $res = mysqli_fetch_assoc($query);
    // Set session variables
    $_SESSION['Id'] = $res['id'];
    // echo '<script>alert('.$res['id'].')</script>';
    $_SESSION['Email'] = $res['Email'];
    header("Location: index.php"); // Redirect to the home page
    exit();
} else {
    header("Location: login.php"); // Redirect to the login page with an error
    exit();
}
?>