<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-teal-100 via-pink-50 to-yellow-100">
    <div class="flex flex-col justify-center items-center w-full min-h-screen">
        <!-- Signup Card Only, No Image -->
        <div class="w-full max-w-2xl bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl border-t-4 border-teal-400 p-8 mx-2 my-8">
            <div class="flex justify-center mb-2">
                <img src="../Images/B.png" alt="Logo" class="h-10 w-10 rounded-full shadow-lg border-2 border-pink-400 bg-white">
            </div>
            <h2 class="text-2xl font-extrabold text-center text-teal-700 mb-1 tracking-wide">Create Account</h2>
            <p class="text-center text-gray-500 mb-3 text-sm">Sign up to access exclusive beauty deals and more.</p>
            <form id="signupform" method="POST" action="insert_user.php">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-3 relative">
                        <label class="block font-semibold text-pink-600 mb-1 text-sm">Full Name</label>
                        <input type="text" id="fullName" name="Name" class="w-full p-2 border rounded-lg focus:ring-pink-400 focus:border-pink-400 text-base pl-10" placeholder="Enter your full name" required>
                        <i class="fas fa-user absolute left-3 top-8 text-pink-300"></i>
                        <p class="text-pink-500 text-xs hidden mt-1 transition-all duration-200" id="nameError">Full name is required.</p>
                    </div>
                    <div class="mb-3 relative">
                        <label class="block font-semibold text-pink-600 mb-1 text-sm">Email</label>
                        <input type="email" id="email" name="Email" class="w-full p-2 border rounded-lg focus:ring-pink-400 focus:border-pink-400 text-base pl-10" placeholder="Enter your email" required>
                        <i class="fas fa-envelope absolute left-3 top-8 text-pink-300"></i>
                        <p class="text-pink-500 text-xs hidden mt-1 transition-all duration-200" id="emailError">Enter a valid email.</p>
                    </div>
                    <div class="mb-3 relative">
                        <label class="block font-semibold text-pink-600 mb-1 text-sm">Phone Number</label>
                        <input type="tel" id="phone" name="Phone" class="w-full p-2 border rounded-lg focus:ring-pink-400 focus:border-pink-400 text-base pl-10" placeholder="Enter your phone number" required>
                        <i class="fas fa-phone absolute left-3 top-8 text-pink-300"></i>
                        <p class="text-pink-500 text-xs hidden mt-1 transition-all duration-200" id="phoneError">Enter a valid phone number.</p>
                    </div>
                    <div class="mb-3 relative">
                        <label class="block font-semibold text-pink-600 mb-1 text-sm">Address</label>
                        <textarea id="address" name="Address" class="w-full p-2 border rounded-lg focus:ring-pink-400 focus:border-pink-400 text-base pl-10" placeholder="Enter your address" required></textarea>
                        <i class="fas fa-map-marker-alt absolute left-3 top-8 text-pink-300"></i>
                        <p class="text-pink-500 text-xs hidden mt-1 transition-all duration-200" id="addressError">Address is required.</p>
                    </div>
                    <div class="mb-3 relative">
                        <label class="block font-semibold text-pink-600 mb-1 text-sm">Password</label>
                        <input type="password" id="password" name="Password" class="w-full p-2 border rounded-lg focus:ring-pink-400 focus:border-pink-400 text-base pl-10 pr-10" placeholder="Enter your password" required>
                        <i class="fas fa-lock absolute left-3 top-8 text-pink-300"></i>
                        <span class="absolute right-3 top-8 cursor-pointer text-pink-400" onclick="togglePassword('password')"><i class="fas fa-eye"></i></span>
                        <p class="text-pink-500 text-xs hidden mt-1 transition-all duration-200" id="passwordError">Password must be at least 6 characters.</p>
                    </div>
                    <div class="mb-3 relative">
                        <label class="block font-semibold text-pink-600 mb-1 text-sm">Confirm Password</label>
                        <input type="password" id="confirmPassword" name="ConfirmPassword" class="w-full p-2 border rounded-lg focus:ring-pink-400 focus:border-pink-400 text-base pl-10 pr-10" placeholder="Confirm your password" required>
                        <i class="fas fa-lock absolute left-3 top-8 text-pink-300"></i>
                        <span class="absolute right-3 top-8 cursor-pointer text-pink-400" onclick="togglePassword('confirmPassword')"><i class="fas fa-eye"></i></span>
                        <p class="text-pink-500 text-xs hidden mt-1 transition-all duration-200" id="confirmPasswordError">Passwords do not match.</p>
                    </div>
                </div>
                <button type="submit" class="w-full bg-teal-500 hover:bg-teal-600 py-2 rounded-lg font-bold text-base text-white flex items-center justify-center gap-2 transition-all duration-200 shadow mt-4 focus:outline-none focus:ring-2 focus:ring-teal-400">
                    <i class="fas fa-user-plus"></i>Sign Up
                </button>
            </form>
            <p class="text-center mt-4 text-sm">Already have an account? <a href="./login.php" class="text-teal-600 font-bold hover:underline">Login</a></p>
        </div>
    </div>
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.nextElementSibling.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        document.getElementById("signupform").addEventListener("submit", function(event) {
            event.preventDefault();
            let isValid = true;
            const name = document.getElementById("fullName").value.trim();
            const email = document.getElementById("email").value.trim();
            const phone = document.getElementById("phone").value.trim();
            const address = document.getElementById("address").value.trim();
            const password = document.getElementById("password").value.trim();
            const confirmPassword = document.getElementById("confirmPassword").value.trim();
            if (name === "") {
                document.getElementById("nameError").classList.remove("hidden");
                isValid = false;
            } else {
                document.getElementById("nameError").classList.add("hidden");
            }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                document.getElementById("emailError").classList.remove("hidden");
                isValid = false;
            } else {
                document.getElementById("emailError").classList.add("hidden");
            }
            if (!/^[0-9]{10}$/.test(phone)) {
                document.getElementById("phoneError").classList.remove("hidden");
                isValid = false;
            } else {
                document.getElementById("phoneError").classList.add("hidden");
            }
            if (address === "") {
                document.getElementById("addressError").classList.remove("hidden");
                isValid = false;
            } else {
                document.getElementById("addressError").classList.add("hidden");
            }
            if (password.length < 6) {
                document.getElementById("passwordError").classList.remove("hidden");
                isValid = false;
            } else {
                document.getElementById("passwordError").classList.add("hidden");
            }
            if (password !== confirmPassword) {
                document.getElementById("confirmPasswordError").classList.remove("hidden");
                isValid = false;
            } else {
                document.getElementById("confirmPasswordError").classList.add("hidden");
            }
            if (isValid) {
                this.submit();
            }
        });
    </script>
</body>

</html>