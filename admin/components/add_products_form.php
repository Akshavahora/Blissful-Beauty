<?php
$content = '
<div class="w-full max-w-screen-md mx-auto bg-white/70 backdrop-blur-lg border border-teal-200 shadow-2xl rounded-2xl p-8 mt-8 transition-transform duration-200 hover:scale-105 hover:shadow-teal-200/60">
    <h2 class="text-3xl font-extrabold text-center text-teal-700 mb-2 tracking-wide flex items-center justify-center gap-2">
        <i class="fas fa-plus-circle"></i> Add New Product
    </h2>
    <hr class="border-t-2 border-teal-400 w-24 mx-auto mb-6">
    <form id="productForm" action="./insert_product.php" method="POST" enctype="multipart/form-data" class="space-y-6">
        <!-- Product Name -->
        <div class="relative">
            <label class="block font-semibold text-teal-700 mb-1">Product Name</label>
            <span class="absolute left-3 top-10 text-teal-400"><i class="fas fa-tag"></i></span>
            <input type="text" name="P_Name" id="name" class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200" required>
            <p class="text-red-500 text-sm hidden" id="nameError">Minimum 3 characters required.</p>
        </div>
        <!-- Description -->
        <div class="relative">
            <label class="block font-semibold text-teal-700 mb-1">Description</label>
            <span class="absolute left-3 top-10 text-teal-400"><i class="fas fa-align-left"></i></span>
            <textarea name="P_Description" id="description" class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200" required></textarea>
            <p class="text-red-500 text-sm hidden" id="descError">Minimum 10 characters required.</p>
        </div>
        <!-- Price -->
        <div class="relative">
            <label class="block font-semibold text-teal-700 mb-1">Price (₹)</label>
            <span class="absolute left-3 top-10 text-teal-400"><i class="fas fa-rupee-sign"></i></span>
            <input type="text" name="P_Price" id="price" class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200" required>
            <p class="text-red-500 text-sm hidden" id="priceError">Enter a valid price.</p>
        </div>
        <!-- Category -->
        <div class="relative mb-4">
            <label class="block font-semibold text-teal-700 mb-1">Brand Category</label>
            <span class="absolute left-3 top-10 text-teal-400 z-10 pointer-events-none">
                <i class="fas fa-layer-group"></i>
            </span>
            <select name="P_Category" id="category"
                class="w-full p-3 pl-12 pr-10 border-2 border-teal-400 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-400 shadow-lg transition-all duration-200 text-lg font-semibold text-gray-800 bg-white/70 appearance-none"
                required>
                <option value="">Select a Category</option>
                <option value="Mac">Mac</option>
                <option value="Lakme">Lakme</option>
                <option value="Maybelline">Maybelline</option>
                <option value="Loreal">Loreal</option>
                <option value="Huda Beauty">Huda Beauty</option>
            </select>
            <!-- Custom dropdown arrow -->
            <span class="pointer-events-none absolute right-4 top-1/2 transform -translate-y-1/2 text-teal-400 text-xl">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <p class="text-red-500 text-sm hidden" id="categoryError">Please select a category.</p>
        </div>
        <!-- Type -->
        <div class="relative">
            <label class="block font-semibold text-teal-700 mb-1">Product Type</label>
            <span class="absolute left-3 top-10 text-teal-400"><i class="fas fa-cubes"></i></span>
            <select name="P_Product" id="type" class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200" required>
                <option value="">Select a Type</option>
                <option value="Primer">🧴 Primer</option>
                <option value="Foundation">💧 Foundation</option>
                <option value="Concealer">🖌️ Concealer</option>
                <option value="Setting Powder">🌬️ Setting Powder</option>
                <option value="Blush">🌸 Blush</option>
                <option value="Highlighter">✨ Highlighter</option>
                <option value="Eyebrow pencil">✏️ Eyebrow pencil</option>
                <option value="Lipstick">💄 Lipstick</option>
                <option value="Mascara">👁️ Mascara</option>
                <option value="Eyeshadow Palette">🎨 Eyeshadow Palette</option>
                <option value="Eyelinear">🖊️ Eyelinear</option>
            </select>
            <p class="text-red-500 text-sm hidden" id="typeError">Please select a type.</p>
        </div>
        <!-- Product Filters -->
        <div>
            <label class="block font-semibold text-teal-700 mb-1">Product Filters</label>
            <div class="flex flex-wrap gap-4">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="filters[]" value="Swiper" class="accent-teal-500 w-5 h-5 rounded border-gray-300 focus:ring-teal-400">
                    <span class="ml-2 text-gray-700">Swiper</span>
                </label>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="filters[]" value="Top-rated" class="accent-teal-500 w-5 h-5 rounded border-gray-300 focus:ring-teal-400">
                    <span class="ml-2 text-gray-700">Top-rated</span>
                </label>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="filters[]" value="Products" class="accent-teal-500 w-5 h-5 rounded border-gray-300 focus:ring-teal-400">
                    <span class="ml-2 text-gray-700">Products</span>
                </label>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="filters[]" value="New Arrivals" class="accent-teal-500 w-5 h-5 rounded border-gray-300 focus:ring-teal-400">
                    <span class="ml-2 text-gray-700">New Arrivals</span>
                </label>
            </div>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-bold text-lg shadow-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200 flex items-center justify-center gap-2 transform hover:scale-105">
            <i class="fas fa-paper-plane"></i> Submit
        </button>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
<script>
document.getElementById("productForm").addEventListener("submit", function(event) {
    let isValid = true;
    if (document.getElementById("name").value.length < 3) {
        document.getElementById("nameError").classList.remove("hidden");
        isValid = false;
    } else {
        document.getElementById("nameError").classList.add("hidden");
    }
    if (document.getElementById("description").value.length < 10) {
        document.getElementById("descError").classList.remove("hidden");
        isValid = false;
    } else {
        document.getElementById("descError").classList.add("hidden");
    }
    if (isNaN(document.getElementById("price").value) || document.getElementById("price").value <= 0) {
        document.getElementById("priceError").classList.remove("hidden");
        isValid = false;
    } else {
        document.getElementById("priceError").classList.add("hidden");
    }
    if (document.getElementById("category").value === "") {
        document.getElementById("categoryError").classList.remove("hidden");
        isValid = false;
    } else {
        document.getElementById("categoryError").classList.add("hidden");
    }
    if (document.getElementById("type").value === "") {
        document.getElementById("typeError").classList.remove("hidden");
        isValid = false;
    } else {
        document.getElementById("typeError").classList.add("hidden");
    }
    if (!isValid) {
        event.preventDefault();
    }
});
</script>
';
include("./aside.php");
