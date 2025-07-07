<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Blissful Beauty</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

<div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold text-center text-gray-700 mb-4">Login to Dashboard</h2>

    <form action="login_logic.php" method="POST" class="space-y-4">
        <div>
            <label for="username" class="block text-gray-900 mb-4">Username</label>
            <input type="text" name="username" id="username" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-black ">
        </div>

        <div>
            <label for="password" class="block text-gray-900 mb-4">Password</label>
            <input type="password" name="password" id="password" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-black">
        </div>

        <button type="submit"
            class="w-full bg-black text-white py-2 rounded-lg hover:bg-teal-700 transition">
            Login
        </button>
    </form>

    <!-- <p class="text-center text-sm text-gray-500 mt-4"></p> -->
</div>

</body>
</html>