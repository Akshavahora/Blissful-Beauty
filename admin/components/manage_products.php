<?php
require_once('../../dbconnection/connection.php');

// Handle delete operation
if (isset($_POST['delete'])) {
    $ID = $_POST['delete'];
    $delete = "DELETE FROM product WHERE P_Id = ?";
    $stmt = mysqli_prepare($conn, $delete);
    mysqli_stmt_bind_param($stmt, 'i', $ID);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Product deleted successfully'); window.location.href='manage_products.php';</script>";
    } else {
        echo "<script>alert('Error deleting product: " . mysqli_error($conn) . "');</script>";
    }
}

// Handle edit operation
if (isset($_POST['edit_id'])) {
    $P_Id = $_POST['edit_id'];
    $P_Name = $_POST['edit_name'];
    $P_Description = $_POST['edit_description'];
    $P_Price = $_POST['edit_price'];
    $P_Category = $_POST['edit_category'];
    $P_Product = $_POST['edit_product'];

    $edit = "UPDATE product SET P_Name = ?, P_Description = ?, P_Price = ?, P_Category = ?, P_Product = ? WHERE P_Id = ?;";
    $stmt = mysqli_prepare($conn, $edit);
    mysqli_stmt_bind_param($stmt, 'ssissi', $P_Name, $P_Description, $P_Price, $P_Category, $P_Product, $P_Id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Product edited successfully'); window.location.href='manage_products.php';</script>";
    } else {
        echo "<script>alert('Error editing product: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch data from the database
$sel = "SELECT * FROM product";
$res = mysqli_query($conn, $sel);

// Start output buffering
ob_start();
?>
<div class="mt-12 mx-4 sm:mx-12">
    <div class="mx-auto glass p-8 rounded-2xl shadow-2xl fade-in">
        <h2 class="text-3xl font-extrabold text-center text-teal-700 mb-2 tracking-wide flex items-center justify-center gap-2">
            <i class="fas fa-table"></i> Product Table
        </h2>
        <hr class="border-t-2 border-teal-400 w-24 mx-auto mb-6">
        <!-- Desktop Table/Grid -->
        <div class="hidden md:block w-full border border-teal-200 rounded-lg overflow-hidden bg-white/80">
            <div class="grid grid-cols-6 md:grid-cols-8 bg-teal-100 font-semibold text-teal-800">
                <div class="px-4 py-2">Id</div>
                <div class="px-4 py-2">Name</div>
                <div class="px-4 py-2">Description</div>
                <div class="px-4 py-2">Price</div>
                <div class="px-4 py-2">Category</div>
                <div class="px-4 py-2">Product</div>
                <div class="px-4 py-2"></div>
                <div class="px-4 py-2"></div>
            </div>
            <div id="table-body" class="divide-y divide-teal-100">
                <?php mysqli_data_seek($res, 0);
                while ($row = mysqli_fetch_row($res)) : ?>
                    <div class="grid grid-cols-6 md:grid-cols-8 text-sm md:text-base bg-white/60 hover:bg-teal-50 transition-all duration-150">
                        <div class="px-2 md:px-4 py-2"><?php echo $row[0]; ?></div>
                        <div class="px-2 md:px-4 py-2 truncate"><?php echo $row[1]; ?></div>
                        <div class="px-2 md:px-4 py-2 truncate"><?php echo $row[2]; ?></div>
                        <div class="px-2 md:px-4 py-2">₹<?php echo $row[3]; ?></div>
                        <div class="px-2 md:px-4 py-2"><?php echo $row[4]; ?></div>
                        <div class="px-2 md:px-4 py-2"><?php echo $row[5]; ?></div>
                        <div class="px-2 md:px-4 py-2">
                            <button onclick="openModal(this, <?php echo $row[0]; ?>)" class="edit-btn flex items-center gap-1 bg-teal-500 text-white px-3 py-1 rounded shadow hover:bg-teal-700 transition-all duration-150"><i class="fas fa-edit"></i> Edit</button>
                        </div>
                        <div class="px-2 md:px-4 py-2">
                            <form method="POST">
                                <button type="submit" name="delete" value="<?php echo $row[0]; ?>" class="delete-btn flex items-center gap-1 bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition-all duration-150"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <!-- Mobile Cards -->
        <div class="block md:hidden space-y-4">
            <?php mysqli_data_seek($res, 0);
            while ($row = mysqli_fetch_row($res)) : ?>
                <div class="bg-white/80 rounded-xl shadow p-4 flex flex-col gap-2">
                    <div><span class="font-bold text-teal-700">Id:</span> <?php echo $row[0]; ?></div>
                    <div><span class="font-bold text-teal-700">Name:</span> <?php echo $row[1]; ?></div>
                    <div><span class="font-bold text-teal-700">Description:</span> <?php echo $row[2]; ?></div>
                    <div><span class="font-bold text-teal-700">Price:</span> ₹<?php echo $row[3]; ?></div>
                    <div><span class="font-bold text-teal-700">Category:</span> <?php echo $row[4]; ?></div>
                    <div><span class="font-bold text-teal-700">Product:</span> <?php echo $row[5]; ?></div>
                    <div class="flex gap-2 mt-2">
                        <button onclick="openModal(this, <?php echo $row[0]; ?>)" class="edit-btn flex items-center gap-1 bg-teal-500 text-white px-3 py-1 rounded shadow hover:bg-teal-700 transition-all duration-150 text-xs"><i class="fas fa-edit"></i> Edit</button>
                        <form method="POST">
                            <button type="submit" name="delete" value="<?php echo $row[0]; ?>" class="delete-btn flex items-center gap-1 bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition-all duration-150 text-xs"><i class="fas fa-trash"></i> Delete</button>
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
        <div class="glass bg-white/90 p-8 rounded-2xl shadow-2xl w-full max-w-md fade-in">
            <h3 class="text-2xl font-bold mb-4 text-teal-700 flex items-center gap-2"><i class="fas fa-edit"></i> Edit Product Details</h3>
            <input type="hidden" name="edit_id" id="edit-id">
            <input type="text" name="edit_name" id="edit-name" placeholder="Name" class="w-full mb-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
            <input type="text" name="edit_description" id="edit-description" placeholder="Description" class="w-full mb-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
            <input type="text" name="edit_price" id="edit-price" placeholder="Price" class="w-full mb-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
            <input type="text" name="edit_category" id="edit-category" placeholder="Category" class="w-full mb-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
            <input type="text" name="edit_product" id="edit-product" placeholder="Product" class="w-full mb-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
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

<style>
    .glass {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1.5px solid rgba(20, 184, 166, 0.15);
        box-shadow: 0 8px 32px 0 rgba(20, 184, 166, 0.10);
    }

    .fade-in {
        animation: fade-in 1s;
    }

    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .edit-btn,
    .delete-btn {
        font-size: 1rem;
        font-weight: 600;
        border: none;
        outline: none;
        cursor: pointer;
    }

    .edit-btn:active,
    .delete-btn:active {
        transform: scale(0.97);
    }

    @media (max-width: 768px) {
        .grid-cols-6 {
            grid-template-columns: repeat(3, 1fr);
        }

        .grid-cols-8 {
            grid-template-columns: repeat(4, 1fr);
        }

        .truncate {
            white-space: normal;
        }
    }

    @media (max-width: 480px) {

        .grid-cols-6,
        .grid-cols-8 {
            grid-template-columns: 1fr;
        }
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
<script>
    function openModal(button, id) {
        const row = button.parentElement.parentElement.children;
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-name').value = row[1].innerText;
        document.getElementById('edit-description').value = row[2].innerText;
        document.getElementById('edit-price').value = row[3].innerText.replace('₹', '');
        document.getElementById('edit-category').value = row[4].innerText;
        document.getElementById('edit-product').value = row[5].innerText;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>