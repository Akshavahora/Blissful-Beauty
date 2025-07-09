<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #38bdf8 0%, #14b8a6 100%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            border: 1.5px solid rgba(255, 255, 255, 0.18);
        }

        .fade-in {
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="flex justify-center items-center min-h-screen">

    <div class="w-full max-w-md glass p-8 space-y-8 fade-in">
        <div class="flex flex-col items-center">
            <!-- Logo Placeholder -->
            <div class="mb-2">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="24" cy="24" r="24" fill="#14b8a6" />
                    <path d="M24 14L28 24H20L24 14Z" fill="white" />
                    <rect x="22" y="26" width="4" height="8" rx="2" fill="white" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Admin Login</h2>
            <p class="text-gray-500 text-sm mt-1">Enter your credentials to access the admin panel</p>
        </div>

        <!-- Login Form -->
        <form id="adminLoginForm" class="space-y-5">
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fa fa-user"></i></span>
                <input type="text" id="username" placeholder="Enter your username"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 transition outline-none bg-white/70">
            </div>
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fa fa-lock"></i></span>
                <input type="password" id="password" placeholder="Enter your password"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 transition outline-none bg-white/70">
            </div>
            <div class="flex justify-between items-center">
                <label class="flex items-center text-sm select-none">
                    <input type="checkbox" class="accent-cyan-500">
                    <span class="ml-2">Remember me</span>
                </label>
                <a href="#" class="text-cyan-600 text-sm hover:underline">Forgot Password?</a>
            </div>
            <button type="button" onclick="handleLogin()"
                class="w-full bg-cyan-500 hover:bg-cyan-600 text-white py-2 rounded-lg font-semibold transition-all duration-200 shadow-md flex items-center justify-center gap-2">
                <span id="loginBtnText">Login</span>
                <span id="loginSpinner" class="hidden animate-spin"><i class="fa fa-spinner"></i></span>
            </button>
        </form>

        <!-- Error Message -->
        <p id="errorMessage" class="text-red-500 text-sm text-center hidden transition-all duration-300">Invalid Username or Password</p>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-400">© 2025 Admin Dashboard. All rights reserved.</p>
    </div>

    <script>
        function handleLogin() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('errorMessage');
            const loginBtnText = document.getElementById('loginBtnText');
            const loginSpinner = document.getElementById('loginSpinner');

            // Show spinner
            loginBtnText.classList.add('opacity-50');
            loginSpinner.classList.remove('hidden');

            setTimeout(() => {
                // Example validation logic
                if (username === 'admin' && password === 'admin123') {
                    errorMessage.classList.add('hidden');
                    loginBtnText.classList.remove('opacity-50');
                    loginSpinner.classList.add('hidden');
                    // Animate card out and redirect
                    document.querySelector('.glass').classList.add('animate-bounce');
                    setTimeout(() => {
                        window.location.href = '/admin-dashboard';
                    }, 600);
                } else {
                    errorMessage.classList.remove('hidden');
                    errorMessage.classList.add('animate-shake');
                    loginBtnText.classList.remove('opacity-50');
                    loginSpinner.classList.add('hidden');
                    setTimeout(() => errorMessage.classList.remove('animate-shake'), 500);
                }
            }, 900);
        }
        // Add shake animation
        const style = document.createElement('style');
        style.innerHTML = `
    @keyframes shake {
        0% { transform: translateX(0); }
        20% { transform: translateX(-8px); }
        40% { transform: translateX(8px); }
        60% { transform: translateX(-8px); }
        80% { transform: translateX(8px); }
        100% { transform: translateX(0); }
    }
    .animate-shake { animation: shake 0.5s; }
    `;
        document.head.appendChild(style);
    </script>

</body>

</html>