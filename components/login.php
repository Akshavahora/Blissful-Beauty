<?php
session_start(); // Start the session
$isLoggedIn = isset($_SESSION['Email']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- tailwind css link  -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1.5px solid rgba(0, 128, 128, 0.15);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #0d9488;
        }

        .input-with-icon {
            padding-left: 2.5rem;
        }

        .login-image-bg {
            background-image: url('../Images/Slider-Images/Slider-03.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
            min-height: 100vh;
            animation: zoomIn 10s ease-in-out infinite alternate;
        }

        @keyframes zoomIn {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.05);
            }
        }

        .login-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(16, 185, 129, 0.3) 0%, rgba(236, 72, 153, 0.2) 100%);
            z-index: 1;
        }

        @media (max-width: 768px) {
            .login-image-bg {
                min-height: 220px;
                height: 220px;
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-stretch bg-gradient-to-br from-teal-100 via-pink-50 to-yellow-100 relative overflow-hidden">
    <div class="flex flex-1 w-full min-h-screen">
        <!-- Left: Image -->
        <div class="hidden md:block md:w-1/2 relative login-image-bg">
            <div class="login-image-overlay"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center z-10">
                <img src="../Images/B.png" alt="Brand Logo" class="h-24 w-24 rounded-full shadow-xl border-4 border-white bg-white/80 mb-6">
                <h2 class="text-4xl font-extrabold text-white drop-shadow-lg text-center mb-2">Welcome to <span class="text-teal-200">Cosmetic Store</span></h2>
                <p class="text-lg text-white/90 text-center max-w-xs">Discover the best in beauty, curated just for you.</p>
            </div>
        </div>
        <!-- Mobile Image -->
        <div class="md:hidden w-full login-image-bg relative">
            <div class="login-image-overlay"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center z-10">
                <img src="../Images/B.png" alt="Brand Logo" class="h-16 w-16 rounded-full shadow-xl border-4 border-white bg-white/80 mb-3 mt-6">
                <h2 class="text-2xl font-extrabold text-white drop-shadow-lg text-center mb-1">Welcome to <span class="text-teal-200">Cosmetic Store</span></h2>
            </div>
        </div>
        <!-- Right: Login Card -->
        <div class="flex flex-col justify-center items-center flex-1 md:w-1/2 z-20 relative">
            <div class="w-full max-w-md glass rounded-3xl shadow-2xl p-8 border-t-4 border-teal-400 mx-4 my-8">
                <div class="flex justify-center mb-4 md:hidden">
                    <img src="../Images/B.png" alt="Logo" class="h-12 w-12 rounded-full shadow-lg border-2 border-teal-400 bg-white">
                </div>
                <h2 class="text-3xl font-extrabold text-center text-teal-700 mb-2 tracking-wide">Welcome Back</h2>
                <p class="text-center text-gray-500 mb-6">Sign in to your account</p>
                <form id="loginForm" class="mt-2" method="POST" action="./login_logic.php">
                    <div class="mb-5 relative">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <i class="fas fa-envelope input-icon"></i>
                        <input
                            type="email"
                            id="email"
                            name="Email"
                            class="input-with-icon mt-6 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 text-base bg-white/80"
                            placeholder="Enter your email"
                            required>
                        <span id="emailError" class="text-sm text-red-500 hidden transition-all duration-200">Please enter a valid email address.</span>
                    </div>
                    <div class="mb-5 relative">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <i class="fas fa-lock input-icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="Password"
                            class="input-with-icon mt-8 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 text-base bg-white/80"
                            placeholder="Enter your password"
                            required>
                        <span id="passwordError" class="text-sm text-red-500 hidden transition-all duration-200">Password must be at least 6 characters long.</span>
                    </div>
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center text-sm text-gray-600">
                            <input type="checkbox" class="h-4 w-4 text-teal-500 focus:ring-teal-500 border-gray-300 rounded">
                            <span class="ml-2">Remember me</span>
                        </label>
                        <a href="./forgot_password.php" id="forgotPasswordLink" class="text-sm text-teal-600 hover:underline font-semibold">Forgot password?</a>
                    </div>
                    <button
                        type="submit"
                        class="w-full bg-teal-500 text-white py-3 px-4 rounded-lg font-bold text-lg shadow-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:ring-offset-2 transition-all duration-200">Login
                    </button>
                </form>
                <p class="mt-6 text-sm text-gray-600 text-center">Don't have an account? <a href="./signup.php" class="text-teal-600 font-semibold hover:underline">Sign up</a></p>
            </div>
        </div>
    </div>
    <script>
        // Check if there is a login error in the URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('login_error')) {
            if (urlParams.get('login_error') == 1) {
                // Show animated error toast
                const toast = document.createElement('div');
                toast.className = 'fixed top-8 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-bounce';
                toast.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>Email or password does not match.';
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
        }
    </script>
</body>

</html>