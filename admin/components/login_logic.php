<?php

session_start();
include('../../dbconnection/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];  // Hash the password

    $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');  // Redirect on successful login
        exit();
    } else {
        echo '<script>alert("Invalid username or password."); window.location="index.php";</script>';
    }

    $stmt->close();
    $conn->close();
}
?>