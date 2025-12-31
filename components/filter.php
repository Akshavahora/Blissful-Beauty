<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- tailwind cdn link  -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>

    <!-- Brand Filter -->
    <div class="inline-block relative">
        <button id="otherFilterBtn" class="border border-black px-4 py-2 rounded-md text-black font-bold flex items-center space-x-2">
            <span>BRAND (<span id="selectedBrandCount">0</span>)</span>
            <svg class="w-4 h-4 transition-transform duration-200" id="otherFilterArrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div id="otherFilterPanel" class="hidden absolute bg-white border border-gray-300 shadow-lg w-96 p-4 mt-2 rounded-md z-50">
            <span class="block text-gray-600 text-sm font-bold">Brand:</span>
            <div class="grid grid-cols-1 gap-2 mt-2">
                <?php
                $brands = ["MAC", "MAYBELLINE", "L'OREAL", "HUDA BEAUTY", "LAKME"];
                foreach ($brands as $brand) : ?>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="brand-checkbox" value="<?php echo strtolower($brand); ?>">
                        <span><?php echo $brand; ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="flex justify-between mt-4">
                <button id="clearBrandFilter" class="border border-black px-4 py-2 text-black rounded-md">CLEAR</button>
                <button id="applyOtherFilter" class="bg-gray-500 text-white px-4 py-2 rounded-md">APPLY</button>
            </div>
        </div>
    </div>

    <!-- Type Filter -->
    <div class="inline-block relative">
        <button id="filterDropdownBtn" class="border border-black px-4 py-2 rounded-md text-black font-bold flex items-center space-x-2">
            <span>TYPE (<span id="selectedCount">0</span>)</span>
            <svg class="w-4 h-4 transition-transform duration-200" id="filterArrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div id="filterDropdown" class="hidden absolute bg-white border border-gray-300 shadow-lg w-64 p-4 mt-2 rounded-md z-50">
            <span class="block text-gray-600 text-sm font-bold">Sort By:</span>
            <div class="grid grid-cols-1 gap-2 mt-2">
                <?php
                $types = ["Primer", "Foundation", "Concealer", "Setting Powder", "Blush", "Highlighter", "Eyebrow pencil", "Lipstick", "Mascara", "Eyeshadow Palette", "Eyelinear", "Primer"];
                foreach ($types as $type) : ?>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="filter-checkbox" value="<?php echo strtolower($type); ?>">
                        <span><?php echo $type; ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="flex justify-between mt-4">
                <button id="clearFilter" class="border border-black px-4 py-2 text-black rounded-md">CLEAR</button>
                <button id="applyFilter" class="bg-gray-500 text-white px-4 py-2 rounded-md">APPLY</button>
            </div>
        </div>
    </div>
    </div>

    <script>
        function filterProducts() {
            let selectedBrands = Array.from(document.querySelectorAll('.brand-checkbox:checked')).map(cb => cb.value.toLowerCase());
            let selectedTypes = Array.from(document.querySelectorAll('.filter-checkbox:checked')).map(cb => cb.value.toLowerCase());

            let products = document.querySelectorAll('.product');
            products.forEach(product => {
                let productBrand = product.getAttribute('data-brand')?.trim().toLowerCase();
                let productType = product.getAttribute('data-type')?.trim().toLowerCase();

                let show = false;

                if (selectedBrands.length > 0 && selectedTypes.length > 0) {
                    // Both filters selected: must match both
                    show = selectedBrands.includes(productBrand) && selectedTypes.includes(productType);
                } else if (selectedBrands.length > 0) {
                    // Only brand(s) selected
                    show = selectedBrands.includes(productBrand);
                } else if (selectedTypes.length > 0) {
                    // Only type(s) selected
                    show = selectedTypes.includes(productType);
                } else {
                    // No filters: show all
                    show = true;
                }

                product.style.display = show ? 'block' : 'none';
            });
        }

        document.getElementById('otherFilterBtn').addEventListener('click', function() {
            const panel = document.getElementById('otherFilterPanel');
            const arrow = document.getElementById('otherFilterArrow');
            panel.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        });

        document.getElementById('applyOtherFilter').addEventListener('click', function() {
            filterProducts();
            document.getElementById('otherFilterPanel').classList.add('hidden');
        });

        document.getElementById('clearBrandFilter').addEventListener('click', function() {
            document.querySelectorAll('.brand-checkbox').forEach(checkbox => checkbox.checked = false);
            updateBrandFilterCount();
            filterProducts();
            document.getElementById('otherFilterPanel').classList.add('hidden');
        });

        function updateBrandFilterCount() {
            let selectedBrands = document.querySelectorAll('.brand-checkbox:checked').length;
            document.getElementById('selectedBrandCount').textContent = selectedBrands;
        }

        document.querySelectorAll('.brand-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBrandFilterCount);
        });

        document.getElementById('filterDropdownBtn').addEventListener('click', function() {
            const dropdown = document.getElementById('filterDropdown');
            const arrow = document.getElementById('filterArrow');
            dropdown.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        });

        document.getElementById('applyFilter').addEventListener('click', function() {
            filterProducts();
            document.getElementById('filterDropdown').classList.add('hidden');
            document.getElementById('filterArrow').classList.remove('rotate-180');
        });

        document.getElementById('clearFilter').addEventListener('click', function() {
            document.querySelectorAll('.filter-checkbox').forEach(checkbox => checkbox.checked = false);
            updateFilterCount();
            filterProducts();
            document.getElementById('filterDropdown').classList.add('hidden');
            document.getElementById('filterArrow').classList.remove('rotate-180');
        });

        function updateFilterCount() {
            let selectedFilters = document.querySelectorAll('.filter-checkbox:checked').length;
            document.getElementById('selectedCount').textContent = selectedFilters;
        }

        document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateFilterCount);
        });

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('filterDropdown');
            const button = document.getElementById('filterDropdownBtn');
            const otherButton = document.getElementById('otherFilterBtn');
            const otherPanel = document.getElementById('otherFilterPanel');

            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
                document.getElementById('filterArrow').classList.remove('rotate-180');
            }

            if (!otherButton.contains(event.target) && !otherPanel.contains(event.target)) {
                otherPanel.classList.add('hidden');
                document.getElementById('otherFilterArrow').classList.remove('rotate-180');
            }
        });
    </script>
</body>

</html>