<?php
include("../../dbconnection/connection.php"); // Ensure this connects to your database

// Fetch products from database
$query = "SELECT * FROM product"; // Adjust table/column names as per your DB
$result = mysqli_query($conn, $query);
?>

<?php
$content = '';
include("./aside.php");
?>

<div class="w-full max-w-lg mx-auto glass p-8 rounded-2xl shadow-2xl mt-8 fade-in">
    <h2 class="text-3xl font-extrabold text-center text-teal-700 mb-2 tracking-wide flex items-center justify-center gap-2">
        <i class="fas fa-box"></i> Add New Stock
    </h2>
    <hr class="border-t-2 border-teal-400 w-24 mx-auto mb-6">
    <form id="stockForm" action="./insert_stock.php" method="POST" class="space-y-5">
        <!-- Product Dropdown -->
        <div>
            <label class="block font-semibold text-teal-700 mb-1">Product Name</label>
            <select name="product_id" id="product" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
                <option value="">Select a Product</option>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['P_Id']}'>{$row['P_Name']}</option>";
                }
                ?>
            </select>
        </div>
        <!-- Quantity -->
        <div>
            <label class="block font-semibold text-teal-700 mb-1">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="w-full bg-teal-600 text-white py-3 rounded-lg font-bold shadow hover:bg-black hover:text-teal-200 transition-all duration-150 flex items-center justify-center gap-2 text-lg">
            <i class="fas fa-plus"></i> Submit
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
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>