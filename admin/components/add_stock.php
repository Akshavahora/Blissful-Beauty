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

<div class="w-full max-w-lg mx-auto bg-white/70 backdrop-blur-lg border border-teal-200 shadow-2xl rounded-2xl p-8 mt-8 transition-transform duration-200 hover:scale-105 hover:shadow-teal-200/60">
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
        <!-- Shade -->
        <div>
            <label class="block font-semibold text-teal-700 mb-1">Shade</label>
            <select name="shade_id" id="shade" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400" required>
                <option value="">Select a Shade</option>
                <!-- Options will be populated by JS -->
            </select>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="w-full bg-teal-600 text-white py-3 rounded-lg font-bold shadow hover:bg-black hover:text-teal-200 transition-all duration-150 flex items-center justify-center gap-2 text-lg transform hover:scale-105">
            <i class="fas fa-plus"></i> Submit
        </button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
<script>
    document.getElementById('product').addEventListener('change', function() {
        var productId = this.value;
        var shadeSelect = document.getElementById('shade');
        shadeSelect.innerHTML = '<option value="">Loading...</option>';
        fetch('get_shades.php?product_id=' + productId)
            .then(response => response.json())
            .then(data => {
                shadeSelect.innerHTML = '<option value="">Select a Shade</option>';
                data.forEach(function(shade) {
                    shadeSelect.innerHTML += `<option value="${shade.id}" style="background:${shade.shade};color:#222;">${shade.shade}</option>`;
                });
            });
    });
</script>