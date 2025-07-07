<?php
$content = '';
include("./aside.php");

require_once('../../dbconnection/connection.php');

$query = "SELECT * FROM product";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<div class="max-w-lg mx-auto glass p-8 rounded-2xl shadow-2xl mt-8 fade-in">
    <h2 class="text-3xl font-extrabold text-center text-teal-700 mb-2 tracking-wide flex items-center justify-center gap-2">
        <i class="fas fa-palette"></i> Add Shades
    </h2>
    <hr class="border-t-2 border-teal-400 w-24 mx-auto mb-6">
    <form id="responsiveForm" class="space-y-6" method="POST" enctype="multipart/form-data" action="insert_product_shades.php">
        <!-- Product Dropdown -->
        <div class="relative mb-6">
            <label class="block font-semibold text-teal-700 mb-1">Select Product</label>
            <span class="absolute left-3 top-10 text-teal-400 pointer-events-none">
                <i class="fas fa-box"></i>
            </span>
            <select name="product_dropdown" id="product_dropdown"
                class="w-full p-3 pl-12 pr-10 rounded-xl border-2 border-teal-400 bg-white/70 shadow-lg focus:outline-none focus:ring-2 focus:ring-teal-400 text-lg font-semibold text-gray-800 glass transition-all duration-200 appearance-none"
                required>
                <option value="">-- Select Product --</option>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <option class="rounded-xl border-2 border-teal-400 bg-white/70 shadow-lg focus:outline-none focus:ring-2 focus:ring-teal-400 glass transition-all duration-200 appearance-none" value="<?= $row['P_Id'] ?>"><?= $row['P_Name'] ?></option>
                <?php endwhile; ?>
            </select>
            <!-- Custom dropdown arrow -->
            <span class="pointer-events-none absolute right-4 top-1/2 transform -translate-y-1/2 text-teal-400 text-xl">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                    <path d="M7 10l5 5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
        </div>
        <!-- Color Picker -->
        <div>
            <label class="block font-semibold text-teal-700 mb-1">Pick a Color</label>
            <div class="flex items-center gap-4">
                <input type="color" id="colorPicker" name="shade" class="w-16 h-16 border-2 border-teal-300 rounded-lg shadow focus:ring-2 focus:ring-teal-400 transition-all duration-200" required>
                <div id="colorBox" class="w-12 h-12 border-2 border-teal-200 rounded-lg shadow"></div>
            </div>
        </div>
        <!-- Image Uploads -->
        <div id="imageBoxes" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php for ($i = 1; $i <= 4; $i++) : ?>
                <div class="glass bg-white/80 border-2 border-teal-100 p-4 rounded-xl flex flex-col items-center gap-2 fade-in">
                    <label class="block font-semibold text-teal-700 mb-1">Insert Image <?= $i ?></label>
                    <input type="file" name="Image_<?= $i ?>" accept="image/*" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
                    <img id="imagePreview<?= $i ?>" class="mt-2 max-w-[100px] max-h-[100px] border-2 border-teal-200 rounded-lg object-cover bg-gray-50" src="#" alt="Image Preview">
                </div>
            <?php endfor; ?>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-bold text-lg shadow-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200 flex items-center justify-center gap-2 animate-bounce-on-hover">
            <i class="fas fa-paper-plane"></i> Submit
        </button>
    </form>
</div>
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

    .animate-bounce-on-hover:hover {
        animation: bounce 0.5s;
    }

    @keyframes bounce {
        0% {
            transform: scale(1);
        }

        30% {
            transform: scale(1.08);
        }

        50% {
            transform: scale(0.97);
        }

        70% {
            transform: scale(1.03);
        }

        100% {
            transform: scale(1);
        }
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
<script>
    document.getElementById("colorPicker").addEventListener("input", function() {
        document.getElementById("colorBox").style.backgroundColor = this.value;
    });
    // Add event listeners for image previews
    document.querySelectorAll('input[type="file"]').forEach((input, index) => {
        input.addEventListener("change", function(event) {
            const preview = document.getElementById(`imagePreview${index + 1}`);
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>