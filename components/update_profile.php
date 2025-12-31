<?php
session_start();
header('Content-Type: application/json');
require_once('../dbconnection/connection.php');

if (!isset($_SESSION['Id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in.']);
    exit();
}

$user_id = $_SESSION['Id'];

try {
    // Basic input validation
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address_type = trim($_POST['address_type'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($full_name) || empty($email) || empty($phone)) {
        throw new Exception("All required fields must be filled.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format.");
    }

    if (!preg_match('/^\d{10}$/', $phone)) {
        throw new Exception("Phone number must be 10 digits.");
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // 1. Update registration table
        $sql = "UPDATE registration SET Name = ?, Email = ?, Phone = ?";
        $params = [$full_name, $email, $phone];
        $types = "sss";

        // Hash password if provided
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ", Password = ?";
            $params[] = $hashedPassword;
            $types .= "s";
        }

        // Handle profile picture if uploaded
        $photoName = null;
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
            $targetDir = "components/uploads/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $photoName = time() . '_' . basename($_FILES["profile_photo"]["name"]);
            $targetFile = $targetDir . $photoName;

            if (!move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $targetFile)) {
                throw new Exception("Failed to upload profile image.");
            }

            $sql .= ", profile_photo = ?";
            $params[] = $photoName;
            $types .= "s";
        }

        $sql .= " WHERE id = ?";
        $params[] = $user_id;
        $types .= "i";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Registration prepare failed: " . $conn->error);
        }

        $stmt->bind_param($types, ...$params);
        if (!$stmt->execute()) {
            throw new Exception("Registration execute failed: " . $stmt->error);
        }

        // 2. Update address table
        if (!empty($address_type)) {
            $sql_address = "UPDATE address SET Address_type = ? WHERE user_id = ?";
            $stmt_address = $conn->prepare($sql_address);
            if (!$stmt_address) {
                throw new Exception("Address prepare failed: " . $conn->error);
            }
            $stmt_address->bind_param("si", $address_type, $user_id);
            if (!$stmt_address->execute()) {
                throw new Exception("Address execute failed: " . $stmt_address->error);
            }
            $stmt_address->close();
        }

        // Commit transaction if all queries succeeded
        $conn->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Profile updated successfully!',
            'debug' => [
                'registration_affected_rows' => $stmt->affected_rows,
                'address_updated' => !empty($address_type)
            ]
        ]);
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        throw $e;
    }
} catch (Exception $e) {
    error_log("Profile update error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'debug_info' => [
            'user_id' => $user_id,
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'address_type' => $address_type
        ]
    ]);
}
