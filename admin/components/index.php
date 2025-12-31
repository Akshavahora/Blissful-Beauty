<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Blissful Beauty</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#22313F] to-[#14b8a6] font-sans">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border-2 border-[#e0e7ef] p-10 space-y-8 ring-4 ring-[#14b8a6]/20 hover:ring-[#14b8a6]/30 transition-all duration-300">
        <div class="flex flex-col items-center">
            <!-- Logo Placeholder -->
            <div class="mb-2">
                <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="28" cy="28" r="28" fill="#14b8a6" />
                    <path d="M28 16L33 28H23L28 16Z" fill="white" />
                    <rect x="26" y="30" width="4" height="10" rx="2" fill="white" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-[#22313F] tracking-tight">Login to Dashboard</h2>
            <p class="text-[#14b8a6] text-sm mt-1 font-medium">Welcome back! Please login to your account.</p>
        </div>
        <form action="login_logic.php" method="POST" class="space-y-6">
            <div class="relative">
                <label for="username" class="block text-sm font-semibold text-[#22313F] mb-1">Username</label>
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#14b8a6] text-lg"><i class="fa fa-user"></i></span>
                <input type="text" name="username" id="username" required
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#14b8a6] focus:border-[#14b8a6] transition outline-none bg-white/80 text-[#22313F] font-medium placeholder-gray-400">
            </div>
            <div class="relative">
                <label for="password" class="block text-sm font-semibold text-[#22313F] mb-1">Password</label>
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#14b8a6] text-lg"><i class="fa fa-lock"></i></span>
                <input type="password" name="password" id="password" required
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#14b8a6] focus:border-[#14b8a6] transition outline-none bg-white/80 text-[#22313F] font-medium placeholder-gray-400">
            </div>
            <button type="submit" class="w-full bg-[#14b8a6] hover:bg-[#22313F] text-white font-bold rounded-lg py-3 text-lg transition-all duration-200 shadow-md flex items-center justify-center gap-2">
                <span>Login</span>
            </button>
        </form>
    </div>
</body>

</html>