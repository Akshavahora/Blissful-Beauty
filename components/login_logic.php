<?php
session_start(); // Start the session at the beginning
require_once('../dbconnection/connection.php');

// Retrieve and sanitize user inputs
$Email = mysqli_real_escape_string($conn, $_POST['Email']);
$Password = $_POST['Password']; // No need to escape; we'll verify using password_verify

// Query to fetch the user by email only
$select = "SELECT * FROM registration WHERE Email = ?";
$stmt = $conn->prepare($select);
$stmt->bind_param("s", $Email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $res = $result->fetch_assoc();

    // Verify hashed password
    if (password_verify($Password, $res['Password'])) {
        // Set session variables
        $_SESSION['Id'] = $res['id'];
        $_SESSION['Email'] = $res['Email'];

        header("Location: index.php"); // Redirect to home page
        exit();
    } else {
        header("Location: login.php?login_error=1"); // Incorrect password
        exit();
    }
} else {
    header("Location: login.php?login_error=1"); // Email not found
    exit();
}
