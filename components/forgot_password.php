<?php
date_default_timezone_set('Asia/Kolkata');
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
session_start();
require_once('../dbconnection/connection.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $stmt = $conn->prepare('SELECT * FROM registration WHERE Email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $token = bin2hex(random_bytes(32));
            date_default_timezone_set('Asia/Kolkata');
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $update = $conn->prepare('UPDATE registration SET reset_token = ?, reset_token_expiry = ? WHERE Email = ?');
            $update->bind_param('sss', $token, $expiry, $email);
            $update->execute();
            $resetLink = "reset_password.php?token=$token";
            header("Location: $resetLink");
            exit;
        } else {
            $error = 'No account found with that email.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-teal-50 flex items-center justify-center">
    <div class="w-full max-w-md mx-auto bg-white rounded-3xl shadow-2xl p-10 mt-12 animate-fade-in">
        <div class="flex flex-col items-center mb-8">
            <div class="bg-teal-500 rounded-full p-4 mb-4 shadow-lg">
                <i class="fa fa-unlock-alt text-3xl text-white"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-teal-700 mb-2">Forgot Password?</h2>
            <p class="text-gray-500 text-center">Enter your email address to reset your password.</p>
        </div>
        <?php if ($error): ?>
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4 text-center animate-pulse">
                <i class="fa fa-exclamation-circle mr-2"></i> <?= $error ?>
            </div>
        <?php endif; ?>
        <form method="POST" class="space-y-6">
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email Address</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-teal-400"><i class="fa fa-envelope"></i></span>
                    <input type="email" id="email" name="email" required class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200" placeholder="Enter your email">
                </div>
            </div>
            <button type="submit" class="w-full bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200 shadow-md font-bold">Send Reset Link <i class="fa fa-arrow-right ml-2"></i></button>
        </form>
        <div class="mt-8 text-center">
            <a href="login.php" class="text-teal-600 hover:underline font-semibold"><i class="fa fa-arrow-left mr-1"></i>Back to Login</a>
        </div>
    </div>
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fade-in 1s ease;
        }
    </style>
</body>

</html>