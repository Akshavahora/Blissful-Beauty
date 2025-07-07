<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once('../dbconnection/connection.php');

// Fetch user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">User Settings</h2>
        <form id="userSettingsForm" method="POST" action="update_user.php">
            <div class="mb-4">
                <label class="block font-medium">Full Name</label>
                <input type="text" id="fullName" name="Name" class="w-full p-2 border rounded-lg" value="<?php echo htmlspecialchars($user['Name']); ?>" required>
                <p class="text-red-500 text-sm hidden" id="nameError">Full name is required.</p>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Email</label>
                <input type="email" id="email" name="Email" class="w-full p-2 border rounded-lg" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                <p class="text-red-500 text-sm hidden" id="emailError">Enter a valid email.</p>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Phone Number</label>
                <input type="tel" id="phone" name="Phone" class="w-full p-2 border rounded-lg" value="<?php echo htmlspecialchars($user['Phone']); ?>" required>
                <p class="text-red-500 text-sm hidden" id="phoneError">Enter a valid phone number.</p>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Address</label>
                <textarea id="address" name="Address" class="w-full p-2 border rounded-lg" required><?php echo htmlspecialchars($user['Address']); ?></textarea>
                <p class="text-red-500 text-sm hidden" id="addressError">Address is required.</p>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Password</label>
                <input type="password" id="password" name="Password" class="w-full p-2 border rounded-lg" placeholder="Enter new password (leave blank to keep current)">
                <p class="text-red-500 text-sm hidden" id="passwordError">Password must be at least 6 characters.</p>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Confirm Password</label>
                <input type="password" id="confirmPassword" name="ConfirmPassword" class="w-full p-2 border rounded-lg" placeholder="Confirm new password">
                <p class="text-red-500 text-sm hidden" id="confirmPasswordError">Passwords do not match.</p>
            </div>
            <button type="submit" class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800">Update</button>
        </form>
        <p class="text-center mt-4"><a href="logout.php" class="text-blue-500">Logout</a></p>
    </div>

    <script>
        document.getElementById("userSettingsForm").addEventListener("submit", function(event) {
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

            if (password !== "" && password.length < 6) {
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