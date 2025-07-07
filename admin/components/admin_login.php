<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin Login</title>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

<div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8 space-y-6">
    <div class="text-center">
        <h2 class="text-2xl font-bold text-gray-800">Admin Login</h2>
        <p class="text-gray-500 text-sm mt-2">Enter your credentials to access the admin panel</p>
    </div>

    <!-- Login Form -->
    <form id="adminLoginForm" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" id="username" placeholder="Enter your username"
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" placeholder="Enter your password"
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
        </div>

        <div class="flex justify-between items-center">
            <label class="flex items-center text-sm">
                <input type="checkbox" class="text-blue-500">
                <span class="ml-2">Remember me</span>
            </label>
            <a href="#" class="text-blue-600 text-sm hover:underline">Forgot Password?</a>
        </div>

        <button type="button" onclick="handleLogin()"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition">
            Login
        </button>
    </form>

    <!-- Error Message -->
    <p id="errorMessage" class="text-red-500 text-sm text-center hidden">Invalid Username or Password</p>

    <!-- Footer -->
    <p class="text-center text-sm text-gray-500">© 2025 Admin Dashboard. All rights reserved.</p>
</div>

<script>
    function handleLogin() {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const errorMessage = document.getElementById('errorMessage');

        // Example validation logic
        if (username === 'admin' && password === 'admin123') {
            alert('Login successful');
            errorMessage.classList.add('hidden');
            // Redirect to dashboard or something
            // window.location.href = '/admin-dashboard';
        } else {
            errorMessage.classList.remove('hidden');
        }
    }
</script>

</body>
</html>
