<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'your_database_name');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['Name'];
$email = $_POST['Email'];
$phone = $_POST['Phone'];
$address = $_POST['Address'];
$password = !empty($_POST['Password']) ? password_hash($_POST['Password'], PASSWORD_DEFAULT) : null;

// Update query
if ($password) {
    $sql = "UPDATE users SET Name = ?, Email = ?, Phone = ?, Address = ?, Password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $name, $email, $phone, $address, $password, $_SESSION['user_id']);
} else {
    $sql = "UPDATE users SET Name = ?, Email = ?, Phone = ?, Address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $_SESSION['user_id']);
}

if ($stmt->execute()) {
    echo "<script>
            alert('Profile updated successfully!');
            window.location.href = 'user_setting.php';
          </script>";
} else {
    echo "<script>
            alert('Error updating profile: " . $stmt->error . "');
            window.location.href = 'user_setting.php';
          </script>";
}

$stmt->close();
$conn->close();
?>