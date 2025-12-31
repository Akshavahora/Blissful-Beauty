<?php
require_once('../../dbconnection/connection.php');

// Handle delete operation
if (isset($_POST['delete'])) {
    $ID = $_POST['delete'];
    $del = "DELETE FROM registration WHERE id = ?";
    $stmt = mysqli_prepare($conn, $del);
    mysqli_stmt_bind_param($stmt, 'i', $ID);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('User deleted successfully'); window.location.href='view_user.php';</script>";
    } else {
        echo "<script>alert('Error deleting user: " . mysqli_error($conn) . "');</script>";
    }
}

// Handle edit operation
if (isset($_POST['edit_id'])) {
    $ID = $_POST['edit_id'];
    $Profile_photo = $_POST['edit_photo'];
    $name = $_POST['edit_name'];
    $email = $_POST['edit_email'];
    $phone = $_POST['edit_phone'];
    $address = $_POST['edit_address'];
    $password = $_POST['edit_password'];

    $edit = "UPDATE registration SET profile_photo = ?, Name = ?, Email = ?, Phone = ?, Address = ?, Password = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $edit);
    mysqli_stmt_bind_param($stmt, 'ssssssi', $Profile_photo, $name, $email, $phone, $address, $password, $ID);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('User edited successfully'); window.location.href='view_user.php';</script>";
    } else {
        echo "<script>alert('Error editing user: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch data from the database
$sel = "SELECT * FROM registration";
$res = mysqli_query($conn, $sel);

// Start output buffering
ob_start();
?>

<div class="mt-12 mx-4 sm:mx-12">
    <div class="mx-auto bg-white/70 backdrop-blur-lg border border-teal-200 shadow-2xl p-8 rounded-2xl transition-transform duration-200 hover:scale-105">
        <h2 class="text-3xl font-extrabold text-center text-teal-700 mb-2 tracking-wide flex items-center justify-center gap-2">
            <i class="fas fa-users"></i> Registration Table
        </h2>
        <hr class="border-t-2 border-teal-400 w-24 mx-auto mb-6">

        <!-- Desktop Table/Grid -->
        <div class="hidden md:block w-full border border-teal-200 rounded-lg overflow-hidden bg-white/80">
            <div class="grid grid-cols-9 bg-teal-100 font-semibold text-teal-800">
                <div class="px-4 py-2">ID</div>
                <div class="px-4 py-2">Profile</div>
                <div class="px-4 py-2">Name</div>
                <div class="px-4 py-2">Email</div>
                <div class="px-4 py-2">Phone</div>
                <div class="px-4 py-2">Address</div>
                <div class="px-4 py-2">Password</div>
                <div class="px-4 py-2"></div>
                <div class="px-4 py-2"></div>
            </div>

            <div id="table-body" class="divide-y divide-teal-100">
                <?php
                mysqli_data_seek($res, 0);
                while ($row = mysqli_fetch_assoc($res)) : ?>
                    <div class="grid grid-cols-9 text-sm md:text-base bg-white/60 hover:bg-teal-50 transition-all duration-150">
                        <div class="px-2 md:px-4 py-2"><?php echo $row['id']; ?></div>

                        <div class="px-2 md:px-4 py-2 relative z-20">
                            <?php
                            $photoPath = "../../components/uploads/" . $row['profile_photo'];
                            if (!empty($row['profile_photo']) && file_exists($photoPath)) : ?>
                            <!-- Open the profile photo in another window -->
                                <a href="<?php echo $photoPath; ?>" target="_blank" class="inline-block">
                                    <img src="<?php echo $photoPath; ?>"
                                        alt="Profile"
                                        class="w-24 h-24 object-cover border-2 border-teal-300 shadow-md hover:scale-105 transform transition-all duration-300 rounded-md cursor-pointer relative z-30">
                                </a>
                            <?php else: ?>
                                <img src="../../components/uploads/default.png"
                                    alt="No Photo"
                                    class="w-12 h-12 rounded-full object-cover border-2 border-gray-300 opacity-70">
                            <?php endif; ?>
                        </div>


                        <div class="px-2 md:px-4 py-2 "><?php echo htmlspecialchars($row['Name']); ?></div>
                        <div class="px-2 md:px-4 py-2 truncate"><?php echo htmlspecialchars($row['Email']); ?></div>
                        <div class="px-2 md:px-4 py-2"><?php echo htmlspecialchars($row['Phone']); ?></div>
                        <div class="px-2 md:px-4 py-2 "><?php echo htmlspecialchars($row['Address']); ?></div>
                        <div class="px-2 md:px-4 py-2">******</div>
                        <div class="px-2 md:px-4 py-2">
                            <button onclick="openModal(this, <?php echo $row['id']; ?>)"
                                class="flex items-center gap-1 bg-teal-500 text-white px-3 py-1 rounded shadow hover:bg-teal-700 transition-all duration-150">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </div>
                        <div class="px-2 md:px-4 py-2">
                            <form method="POST">
                                <button type="submit" name="delete" value="<?php echo $row['id']; ?>"
                                    class="flex items-center gap-1 bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition-all duration-150">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Mobile Cards -->
        <div class="block md:hidden space-y-4">
            <?php
            mysqli_data_seek($res, 0);
            while ($row = mysqli_fetch_assoc($res)) :
                $photoPath = "../../components/uploads/" . $row['profile_photo'];
            ?>
                <div class="bg-white/80 rounded-xl shadow p-4 flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <?php if (!empty($row['profile_photo']) && file_exists($photoPath)): ?>
                            <!-- <img src="<?php echo $photoPath; ?>" 
                                 alt="Profile" 
                                 class="w-10 h-10 rounded-full object-cover border-2 border-teal-300 shadow-md"> -->

                            <div class="relative z-10">
                                <a href="<?php echo $photoPath; ?>" target="_blank" class="inline-block">
                                    <img src="<?php echo $photoPath; ?>"
                                        alt="Profile"
                                        class="w-24 h-24 object-cover border-2 border-teal-300 shadow-md hover:scale-105 transform transition-all duration-300 rounded-md cursor-pointer">
                                </a>
                            </div>



                        <?php else: ?>
                            <img src="../../components/uploads/default.png"
                                alt="No Photo"
                                class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 opacity-70">
                        <?php endif; ?>
                        <span class="font-bold text-teal-700"><?php echo htmlspecialchars($row['Name']); ?></span>
                    </div>
                    <div><span class="font-bold text-teal-700">Email:</span> <span class="text-blue-600 break-all"><?php echo htmlspecialchars($row['Email']); ?></span></div>
                    <div><span class="font-bold text-teal-700">Phone:</span> <?php echo htmlspecialchars($row['Phone']); ?></div>
                    <div><span class="font-bold text-teal-700">Address:</span> <?php echo htmlspecialchars($row['Address']); ?></div>
                    <div><span class="font-bold text-teal-700">Password:</span> ******</div>
                    <div class="flex gap-2 mt-2">
                        <button onclick="openModal(this, <?php echo $row['id']; ?>)"
                            class="flex items-center gap-1 bg-teal-500 text-white px-3 py-1 rounded shadow hover:bg-teal-700 transition-all duration-150 text-xs">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form method="POST">
                            <button type="submit" name="delete" value="<?php echo $row['id']; ?>"
                                class="flex items-center gap-1 bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition-all duration-150 text-xs">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<!-- Modal for Editing -->
<form method="POST" id="editForm">
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white/90 p-8 rounded-2xl shadow-2xl w-full max-w-md transition-transform duration-200 hover:scale-105">
            <h3 class="text-2xl font-bold mb-4 text-teal-700 flex items-center gap-2"><i class="fas fa-user-edit"></i> Edit User Details</h3>
            <input type="hidden" name="edit_id" id="edit-id">
            <input type="hidden" name="edit_photo" id="edit-photo">
            <input type="text" name="edit_name" id="edit-name" placeholder="Name" class="w-full mb-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
            <input type="email" name="edit_email" id="edit-email" placeholder="Email" class="w-full mb-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
            <input type="tel" name="edit_phone" id="edit-phone" placeholder="Phone" class="w-full mb-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
            <input type="text" name="edit_address" id="edit-address" placeholder="Address" class="w-full mb-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
            <input type="password" name="edit_password" id="edit-password" placeholder="Password" class="w-full mb-4 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
            <div class="flex gap-4 mt-4">
                <button type="submit" class="w-1/2 bg-teal-600 text-white py-2 rounded-lg font-bold shadow hover:bg-teal-700 transition-all duration-150 flex items-center justify-center gap-2"><i class="fas fa-save"></i> Save</button>
                <button type="button" onclick="closeModal()" class="w-1/2 bg-gray-200 text-gray-700 py-2 rounded-lg font-bold shadow hover:bg-gray-300 transition-all duration-150">Cancel</button>
            </div>
        </div>
    </div>
</form>

<?php
$content = ob_get_clean();
include("./aside.php");
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
<script>
    function openModal(button, id) {
        const row = button.parentElement.parentElement.children;
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-photo').value = row[1].querySelector('img').getAttribute('src').split('/').pop();
        document.getElementById('edit-name').value = row[2].innerText.trim();
        document.getElementById('edit-email').value = row[3].innerText.trim();
        document.getElementById('edit-phone').value = row[4].innerText.trim();
        document.getElementById('edit-address').value = row[5].innerText.trim();
        document.getElementById('edit-password').value = "";
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>