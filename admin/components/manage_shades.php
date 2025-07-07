<?php
require_once('../../dbconnection/connection.php');

// Handle delete operation
if (isset($_POST['delete'])) {
    $ID = $_POST['delete'];
    $delete = "DELETE FROM product_shades WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete);
    mysqli_stmt_bind_param($stmt, 'i', $ID);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Product shade deleted successfully'); window.location.href='manage_shades.php';</script>";
    } else {
        echo "<script>alert('Error deleting product shade: " . mysqli_stmt_error($stmt) . "');</script>";
    }
}

// Handle edit operation
if (isset($_POST['edit_product_id'])) {
    $P_Id = $_POST['edit_id'];
    $product_id = $_POST['edit_product_id'];
    $shade = $_POST['edit_shade'];

    // Handle file uploads
    $image_1 = $_FILES['edit_image_1']['name'] ?: $_POST['existing_image_1'];
    $image_2 = $_FILES['edit_image_2']['name'] ?: $_POST['existing_image_2'];
    $image_3 = $_FILES['edit_image_3']['name'] ?: $_POST['existing_image_3'];
    $image_4 = $_FILES['edit_image_4']['name'] ?: $_POST['existing_image_4'];

    // Move uploaded files to the uploads directory
    if ($_FILES['edit_image_1']['name']) move_uploaded_file($_FILES['edit_image_1']['tmp_name'], "uploads/" . $image_1);
    if ($_FILES['edit_image_2']['name']) move_uploaded_file($_FILES['edit_image_2']['tmp_name'], "uploads/" . $image_2);
    if ($_FILES['edit_image_3']['name']) move_uploaded_file($_FILES['edit_image_3']['tmp_name'], "uploads/" . $image_3);
    if ($_FILES['edit_image_4']['name']) move_uploaded_file($_FILES['edit_image_4']['tmp_name'], "uploads/" . $image_4);

    $edit = "UPDATE product_shades SET product_id = ?, shade = ?, image_1 = ?, image_2 = ?, image_3 = ?, image_4 = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $edit);
    mysqli_stmt_bind_param($stmt, 'ssssssi', $product_id, $shade, $image_1, $image_2, $image_3, $image_4, $P_Id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Product shade edited successfully'); window.location.href='manage_shades.php';</script>";
    } else {
        echo "<script>alert('Error editing product shade: " . mysqli_stmt_error($stmt) . "');</script>";
    }
}

// Fetch data from the database
$sel = "SELECT id, product_id, shade, image_1, image_2, image_3, image_4 FROM product_shades";
$res = mysqli_query($conn, $sel);

// Start output buffering
ob_start();
?>
<div class="mt-12 mx-4 sm:mx-8">
    <div class="mx-auto glass p-8 rounded-2xl shadow-2xl fade-in">
        <h2 class="text-3xl font-extrabold text-center text-teal-700 mb-2 tracking-wide flex items-center justify-center gap-2">
            <i class="fas fa-palette"></i> Product Shades Table
        </h2>
        <hr class="border-t-2 border-teal-400 w-24 mx-auto mb-6">
        <!-- Desktop Table/Grid -->
        <div class="hidden md:block w-full border border-teal-200 rounded-lg overflow-hidden bg-white/80">
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-9 gap-1 bg-teal-100 font-semibold text-teal-800">
                <div class="px-2 py-1">Id</div>
                <div class="px-2 py-1">Product Id</div>
                <div class="px-2 py-1">Shade</div>
                <div class="px-2 py-1">Image 1</div>
                <div class="px-2 py-1">Image 2</div>
                <div class="px-2 py-1">Image 3</div>
                <div class="px-2 py-1">Image 4</div>
                <div class="px-2 py-1"></div>
                <div class="px-2 py-1"></div>
            </div>
            <div id="table-body" class="divide-y divide-teal-100">
                <?php mysqli_data_seek($res, 0);
                while ($row = mysqli_fetch_assoc($res)) : ?>
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-9 gap-1 text-lg md:text-sm bg-white/60 hover:bg-teal-50 transition-all duration-150">
                        <div class="px-1 md:px-2 py-1"><?php echo htmlspecialchars($row['id']); ?></div>
                        <div class="px-1 md:px-2 py-1 truncate"><?php echo htmlspecialchars($row['product_id']); ?></div>
                        <div class="px-1 md:px-2 py-1 truncate"><?php echo htmlspecialchars($row['shade']); ?></div>
                        <div class="px-1 md:px-2 py-1 truncate"><img src="uploads/<?php echo htmlspecialchars($row['image_1']); ?>" class="w-20 h-20 rounded-lg border-2 border-teal-200 object-cover"></div>
                        <div class="px-1 md:px-2 py-1 truncate"><img src="uploads/<?php echo htmlspecialchars($row['image_2']); ?>" class="w-20 h-20 rounded-lg border-2 border-teal-200 object-cover"></div>
                        <div class="px-1 md:px-2 py-1 truncate"><img src="uploads/<?php echo htmlspecialchars($row['image_3']); ?>" class="w-20 h-20 rounded-lg border-2 border-teal-200 object-cover"></div>
                        <div class="px-1 md:px-2 py-1 truncate"><img src="uploads/<?php echo htmlspecialchars($row['image_4']); ?>" class="w-20 h-20 rounded-lg border-2 border-teal-200 object-cover"></div>
                        <div class="px-1 md:px-2 py-1">
                            <button onclick="openModal(this, <?php echo htmlspecialchars($row['id']); ?>)" class="edit-btn flex items-center gap-1 bg-teal-500 text-white px-3 py-1 rounded shadow hover:bg-teal-700 transition-all duration-150"><i class="fas fa-edit"></i> Edit</button>
                        </div>
                        <div class="px-1 md:px-2 py-1">
                            <form method="POST">
                                <button type="submit" name="delete" value="<?php echo htmlspecialchars($row['id']); ?>" class="delete-btn flex items-center gap-1 bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition-all duration-150"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <!-- Mobile Cards -->
        <div class="block md:hidden space-y-4">
            <?php mysqli_data_seek($res, 0);
            while ($row = mysqli_fetch_assoc($res)) : ?>
                <div class="bg-white/80 rounded-xl shadow p-4 flex flex-col gap-2">
                    <div><span class="font-bold text-teal-700">Id:</span> <?php echo htmlspecialchars($row['id']); ?></div>
                    <div class="flex justify-center my-2">
                        <img src="uploads/<?php echo htmlspecialchars($row['image_1']); ?>" class="w-24 h-24 rounded-lg border-2 border-teal-200 object-cover" alt="Image 1">
                    </div>
                    <div><span class="font-bold text-teal-700">Product Id:</span> <?php echo htmlspecialchars($row['product_id']); ?></div>
                    <div><span class="font-bold text-teal-700">Shade:</span> <?php echo htmlspecialchars($row['shade']); ?></div>
                    <div class="flex gap-2 justify-center my-2">
                        <?php for ($i = 1; $i <= 4; $i++): $img = $row['image_' . $i];
                            if ($img): ?>
                                <img src="uploads/<?php echo htmlspecialchars($img); ?>" class="w-12 h-12 rounded border border-teal-200 object-cover" alt="Image <?php echo $i; ?>">
                        <?php endif;
                        endfor; ?>
                    </div>
                    <div class="flex gap-2 mt-2">
                        <button
                            onclick="openModal(this, <?php echo htmlspecialchars($row['id']); ?>)"
                            class="edit-btn flex items-center gap-1 bg-teal-500 text-white px-3 py-1 rounded shadow hover:bg-teal-700 transition-all duration-150 text-xs"
                            data-id="<?php echo htmlspecialchars($row['id']); ?>"
                            data-product_id="<?php echo htmlspecialchars($row['product_id']); ?>"
                            data-shade="<?php echo htmlspecialchars($row['shade']); ?>"
                            data-image_1="<?php echo htmlspecialchars($row['image_1']); ?>"
                            data-image_2="<?php echo htmlspecialchars($row['image_2']); ?>"
                            data-image_3="<?php echo htmlspecialchars($row['image_3']); ?>"
                            data-image_4="<?php echo htmlspecialchars($row['image_4']); ?>">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form method="POST">
                            <button type="submit" name="delete" value="<?php echo htmlspecialchars($row['id']); ?>" class="delete-btn flex items-center gap-1 bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition-all duration-150 text-xs"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<!-- Modal for Editing -->
<form method="POST" id="editForm" enctype="multipart/form-data">
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="glass bg-white/90 p-4 rounded-xl shadow-2xl w-full max-w-xs fade-in">
            <h3 class="text-lg font-bold mb-3 text-teal-700 flex items-center gap-2"><i class="fas fa-edit"></i> Edit Product Shade</h3>
            <input type="hidden" name="edit_id" id="edit-id">
            <input type="hidden" name="existing_image_1" id="existing-image-1">
            <input type="hidden" name="existing_image_2" id="existing-image-2">
            <input type="hidden" name="existing_image_3" id="existing-image-3">
            <input type="hidden" name="existing_image_4" id="existing-image-4">
            <input type="text" name="edit_product_id" id="edit-product-id" placeholder="Product Id" class="w-full mb-2 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-teal-400 text-xs" required>
            <input type="text" name="edit_shade" id="edit-shade" placeholder="Shade" class="w-full mb-2 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-teal-400 text-xs" required>
            <div class="mb-2">
                <label for="edit-image-1" class="block text-xs font-medium text-teal-700">Image 1</label>
                <div class="flex items-center justify-center gap-2">
                    <input type="file" name="edit_image_1" id="edit-image-1" class="mt-1 text-xs" onchange="previewImage(event, 'preview-image-1')">
                    <img id="preview-image-1" src="" class="mt-2 w-16 h-16 rounded border-2 border-teal-200 object-cover">
                </div>
            </div>
            <div class="mb-2">
                <label for="edit-image-2" class="block text-xs font-medium text-teal-700">Image 2</label>
                <div class="flex items-center justify-center gap-2">
                    <input type="file" name="edit_image_2" id="edit-image-2" class="mt-1 text-xs" onchange="previewImage(event, 'preview-image-2')">
                    <img id="preview-image-2" src="" class="mt-2 w-16 h-16 rounded border-2 border-teal-200 object-cover">
                </div>
            </div>
            <div class="mb-2">
                <label for="edit-image-3" class="block text-xs font-medium text-teal-700">Image 3</label>
                <div class="flex items-center justify-center gap-2">
                    <input type="file" name="edit_image_3" id="edit-image-3" class="mt-1 text-xs" onchange="previewImage(event, 'preview-image-3')">
                    <img id="preview-image-3" src="" class="mt-2 w-16 h-16 rounded border-2 border-teal-200 object-cover">
                </div>
            </div>
            <div class="mb-2">
                <label for="edit-image-4" class="block text-xs font-medium text-teal-700">Image 4</label>
                <div class="flex items-center justify-center gap-2">
                    <input type="file" name="edit_image_4" id="edit-image-4" class="mt-1 text-xs" onchange="previewImage(event, 'preview-image-4')">
                    <img id="preview-image-4" src="" class="mt-2 w-16 h-16 rounded border-2 border-teal-200 object-cover">
                </div>
            </div>
            <div class="flex gap-2 mt-3">
                <button type="submit" class="w-1/2 bg-teal-600 text-white py-1 rounded font-bold shadow hover:bg-teal-700 transition-all duration-150 flex items-center justify-center gap-1 text-xs"><i class="fas fa-save"></i> Save</button>
                <button type="button" onclick="closeModal()" class="w-1/2 bg-gray-200 text-gray-700 py-1 rounded font-bold shadow hover:bg-gray-300 transition-all duration-150 text-xs">Cancel</button>
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

    .object-cover {
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .grid-cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid-cols-4 {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid-cols-9 {
            grid-template-columns: repeat(3, 1fr);
        }

        .truncate {
            white-space: normal;
        }
    }

    @media (max-width: 480px) {

        .grid-cols-2,
        .grid-cols-4,
        .grid-cols-9 {
            grid-template-columns: 1fr;
        }
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
<script>
    function openModal(button, id) {
        // Try to use data attributes (mobile card)
        if (button.dataset && button.dataset.id) {
            document.getElementById('edit-id').value = button.dataset.id;
            document.getElementById('edit-product-id').value = button.dataset.product_id;
            document.getElementById('edit-shade').value = button.dataset.shade;
            document.getElementById('existing-image-1').value = button.dataset.image_1;
            document.getElementById('existing-image-2').value = button.dataset.image_2;
            document.getElementById('existing-image-3').value = button.dataset.image_3;
            document.getElementById('existing-image-4').value = button.dataset.image_4;
            document.getElementById('preview-image-1').src = 'uploads/' + button.dataset.image_1;
            document.getElementById('preview-image-2').src = 'uploads/' + button.dataset.image_2;
            document.getElementById('preview-image-3').src = 'uploads/' + button.dataset.image_3;
            document.getElementById('preview-image-4').src = 'uploads/' + button.dataset.image_4;
        } else {
            // Fallback to desktop/table logic
            const row = button.parentElement.parentElement.children;
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-product-id').value = row[1].innerText;
            document.getElementById('edit-shade').value = row[2].innerText;
            document.getElementById('existing-image-1').value = row[3].querySelector('img').src.split('/').pop();
            document.getElementById('existing-image-2').value = row[4].querySelector('img').src.split('/').pop();
            document.getElementById('existing-image-3').value = row[5].querySelector('img').src.split('/').pop();
            document.getElementById('existing-image-4').value = row[6].querySelector('img').src.split('/').pop();
            document.getElementById('preview-image-1').src = row[3].querySelector('img').src;
            document.getElementById('preview-image-2').src = row[4].querySelector('img').src;
            document.getElementById('preview-image-3').src = row[5].querySelector('img').src;
            document.getElementById('preview-image-4').src = row[6].querySelector('img').src;
        }
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function previewImage(event, previewId) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>