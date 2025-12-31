<?php

    

    $content = '';

// Start output buffering
ob_start();




$content = ob_get_clean();
include("./aside.php");
?>


    <h1 class="text-2xl font-bold mb-6">Manage Suppliers</h1>

    <!-- Supplier List Header -->
    <div class="grid grid-cols-4 gap-4 font-bold mb-4">
        <div>Supplier Name</div>
        <div>Contact Information</div>
        <div>Items Supplied</div>
        <div>Actions</div>
    </div>

    <!-- Supplier Items -->
    <div id="supplier-list">
        <!-- Supplier 1 -->
        <div class="grid grid-cols-4 gap-4 mb-4 bg-white p-4 rounded-lg shadow">
            <div>Supplier 1</div>
            <div>contact@supplier1.com</div>
            <div>Item 1, Item 2</div>
            <div class="flex space-x-2">
                <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>
                <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Remove</button>
            </div>
        </div>

        <!-- Supplier 2 -->
        <div class="grid grid-cols-4 gap-4 mb-4 bg-white p-4 rounded-lg shadow">
            <div>Supplier 2</div>
            <div>contact@supplier2.com</div>
            <div>Item 3</div>
            <div class="flex space-x-2">
                <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>
                <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Remove</button>
            </div>
        </div>
    </div>

    <!-- Add New Supplier Button -->
    <button id="add-supplier" class="mt-6 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
        Add New Supplier
    </button>

    <!-- JavaScript for Adding New Supplier -->
    <script>
        document.getElementById('add-supplier').addEventListener('click', function() {
            const supplierList = document.getElementById('supplier-list');

            // Create a new supplier item
            const newSupplier = document.createElement('div');
            newSupplier.className = 'grid grid-cols-4 gap-4 mb-4 bg-white p-4 rounded-lg shadow';
            newSupplier.innerHTML = `
                <div>New Supplier</div>
                <div>new@supplier.com</div>
                <div>New Item</div>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>
                    <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Remove</button>
                </div>
            `;

            // Append the new supplier to the list
            supplierList.appendChild(newSupplier);
        });
    </script>
