<?php
$content = '
<div class="w-full max-w-screen-md mx-auto glass p-8 rounded-2xl shadow-2xl mt-8 fade-in">
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
                class="modern-dropdown w-full p-3 pl-12 pr-10 border-2 border-teal-400 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-400 shadow-lg transition-all duration-200 text-lg font-semibold text-gray-800 bg-white/70 appearance-none"
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
        <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-bold text-lg shadow-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200 flex items-center justify-center gap-2 animate-bounce-on-hover">
            <i class="fas fa-paper-plane"></i> Submit
        </button>
    </form>
</div>
<style>
    .glass {
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1.5px solid rgba(20,184,166,0.15);
        box-shadow: 0 8px 32px 0 rgba(20, 184, 166, 0.10);
    }
    .fade-in {
        animation: fade-in 1s;
    }
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-bounce-on-hover:hover {
        animation: bounce 0.5s;
    }
    @keyframes bounce {
        0% { transform: scale(1); }
        30% { transform: scale(1.08); }
        50% { transform: scale(0.97); }
        70% { transform: scale(1.03); }
        100% { transform: scale(1); }
    }
    .glass-dropdown {
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1.5px solid rgba(20,184,166,0.25);
        box-shadow: 0 4px 16px 0 rgba(20,184,166,0.10);
    }
    .modern-dropdown {
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 2px solid #14b8a6;
        box-shadow: 0 4px 24px 0 rgba(20,184,166,0.13);
        font-size: 1.18rem;
        color: #222;
        font-family: "Segoe UI", Arial, sans-serif;
        border-radius: 1rem;
        padding-top: 0.85rem;
        padding-bottom: 0.85rem;
        padding-left: 2.8rem;
        padding-right: 2.5rem;
        transition: border 0.2s, box-shadow 0.2s;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
    }
    .modern-dropdown:focus, .modern-dropdown:hover {
        border-color: #0d9488;
        box-shadow: 0 0 0 3px #5eead4;
        background: rgba(255,255,255,0.95);
    }
    .modern-dropdown option {
        background: #f0fdfa;
        color: #134e4a;
        font-size: 1.08rem;
        font-family: "Segoe UI", Arial, sans-serif;
        padding: 1rem 2rem;
        border-radius: 0.5rem;
    }
</style>
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
