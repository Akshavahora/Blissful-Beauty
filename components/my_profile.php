<?php
session_start();
$content = '';
require_once('../dbconnection/connection.php');

if (!isset($_SESSION['Id'])) {
    echo "<script>alert('Please login to view your profile.'); window.location.href = 'login.php';</script>";
    exit();
}

$user_id = $_SESSION['Id'];
$successMsg = $errorMsg = "";

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address_type'] ?? '';
    $password = $_POST['password'] ?? '';
    $delete_photo = $_POST['delete_photo'] ?? '0';

    $profile_photo = null;
    $uploadDir = __DIR__ . '/../components/profile_uploads/';

    // Handle photo
    if ($delete_photo === '1') {
        $profile_photo = null;
    } elseif (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['profile_photo']['tmp_name'];
        $filename = time() . "_" . basename($_FILES['profile_photo']['name']);
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($tmp_name, $targetPath)) {
            $profile_photo = $filename;
        } else {
            $errorMsg = "Failed to upload file!";
        }
    }

    // Update DB
    if (!$errorMsg) {
        $sql = "UPDATE registration SET Name=?, Email=?, Phone=?, Address=?";
        $params = [$full_name, $email, $phone, $address];
        $types = "ssss";

        if (!empty($password)) {
            $sql .= ", Password=?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
            $types .= "s";
        }

        if ($delete_photo === '1') {
            $sql .= ", profile_photo=NULL";
        } elseif ($profile_photo) {
            $sql .= ", profile_photo=?";
            $params[] = $profile_photo;
            $types .= "s";
        }

        $sql .= " WHERE id=?";
        $params[] = $user_id;
        $types .= "i";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $successMsg = "Profile updated successfully!";
        } else {
            $errorMsg = "Database update failed: " . $conn->error;
        }

        $stmt->close();
    }
}

// ✅ Fetch updated user
$sql = "SELECT * FROM registration WHERE id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$profile_photo = isset($user['profile_photo']) && $user['profile_photo']
    ? '../components/profile_uploads/' . $user['profile_photo']
    : "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($user['Name']);

include('header.php');
?>

<div class="min-h-screen bg-gradient-to-br from-indigo-50 to-white py-16 px-4">
    <div class="max-w-5xl mx-auto bg-white shadow-2xl rounded-3xl p-12">
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-10">Update Your Profile</h1>

        <?php if ($successMsg): ?>
            <div class="mb-6 text-center font-semibold border rounded-lg py-2 px-4 text-green-600 bg-green-100 border-green-300">
                <?= htmlspecialchars($successMsg) ?>
            </div>
        <?php elseif ($errorMsg): ?>
            <div class="mb-6 text-center font-semibold border rounded-lg py-2 px-4 text-red-600 bg-red-100 border-red-300">
                <?= htmlspecialchars($errorMsg) ?>
            </div>
        <?php endif; ?>

        <form id="profileForm" enctype="multipart/form-data" method="POST" class="space-y-10">
            <!-- Profile Image Section -->
            <div class="flex flex-col items-center">
                <img id="profileImg" src="<?= $profile_photo ?>" class="w-36 h-36 rounded-full border-4 border-indigo-300 shadow object-cover mb-4 transition hover:scale-105" />
                <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                <button type="button" onclick="document.getElementById('profile_photo').click()" class="mb-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Change Photo</button>
                <input type="hidden" name="delete_photo" id="delete_photo" value="0">
                <button type="button" onclick="deletePhoto()" class="text-sm text-red-600 underline hover:text-red-800">Remove Photo</button>
            </div>

            <!-- Personal Info -->
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Full Name</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($user['Name']) ?>" required class="w-full px-4 py-3 border border-gray-300 rounded-xl text-lg shadow-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['Email']) ?>" required class="w-full px-4 py-3 border border-gray-300 rounded-xl text-lg shadow-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Phone</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($user['Phone']) ?>" required pattern="\d{10}" title="Phone must be 10 digits" class="w-full px-4 py-3 border border-gray-300 rounded-xl text-lg shadow-sm focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-gray-700">New Password</label>
                <input type="password" name="password" placeholder="Leave blank to keep current" class="w-full px-4 py-3 border border-gray-300 rounded-xl text-lg shadow-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block font-semibold mb-1 text-gray-700">Address</label>
                <input type="text" name="address_type" value="<?= htmlspecialchars($user['Address'] ?? '') ?>" class="w-full px-4 py-3 border border-gray-300 rounded-xl text-lg shadow-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Submit -->
            <div class="text-right">
                <button type="submit" class="px-8 py-3 rounded-xl bg-indigo-600 text-white font-bold text-lg shadow hover:bg-indigo-700 transition duration-300">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewPhoto(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('profileImg').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
        document.getElementById('delete_photo').value = '0';
    }

    function deletePhoto() {
        document.getElementById('profileImg').src = 'https://api.dicebear.com/7.x/avataaars/svg?seed=User';
        document.getElementById('profile_photo').value = '';
        document.getElementById('delete_photo').value = '1';
    }
</script>
