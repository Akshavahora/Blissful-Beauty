<?php
require_once('../dbconnection/connection.php');

$token = isset($_GET['token']) ? $_GET['token'] : '';
$error = '';
$success = '';
$user_id = null;

if (!empty($token)) {
    $stmt = $conn->prepare('SELECT * FROM registration WHERE reset_token = ? AND reset_token_expiry > NOW()');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $user_id = $user ? $user['id'] : null;
    if (!$user) {
        $error = 'Invalid or expired token.';
    }
} else {
    $error = 'No token provided.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id) {
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    if (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $update = $conn->prepare('UPDATE registration SET Password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?');
        $update->bind_param('si', $hashed, $user_id);
        $update->execute();
        $success = 'Password has been reset successfully!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-teal-50 flex items-center justify-center">
    <div class="w-full max-w-md mx-auto bg-white rounded-3xl shadow-2xl p-10 mt-12 animate-fade-in">
        <div class="flex flex-col items-center mb-8">
            <div class="bg-teal-500 rounded-full p-4 mb-4 shadow-lg">
                <i class="fa fa-key text-3xl text-white"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-teal-700 mb-2">Reset Password</h2>
        </div>
        <?php if ($error): ?>
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4 text-center animate-pulse">
                <i class="fa fa-exclamation-circle mr-2"></i> <?= $error ?>
            </div>
        <?php elseif ($success): ?>
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4 text-center animate-pulse">
                <i class="fa fa-check-circle mr-2"></i> <?= $success ?>
            </div>
        <?php endif; ?>
        <?php if (!$success && $user_id): ?>
            <form method="POST" class="space-y-6">
                <div>
                    <label for="password" class="block text-gray-700 font-semibold mb-2">New Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-teal-400"><i class="fa fa-lock"></i></span>
                        <input type="password" id="password" name="password" required minlength="6" class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200" placeholder="Enter new password">
                    </div>
                </div>
                <div>
                    <label for="confirm" class="block text-gray-700 font-semibold mb-2">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-teal-400"><i class="fa fa-lock"></i></span>
                        <input type="password" id="confirm" name="confirm" required minlength="6" class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200" placeholder="Confirm new password">
                    </div>
                </div>
                <button type="submit" class="w-full bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200 shadow-md font-bold">Set New Password <i class="fa fa-arrow-right ml-2"></i></button>
            </form>
        <?php endif; ?>
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