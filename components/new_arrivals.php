<?php
session_start();
require_once('../dbconnection/connection.php');
$content = '';
include('header.php');

$sel = "SELECT * FROM product p INNER JOIN product_shades ps ON p.P_Id = ps.product_id WHERE p.filter_name = 'New Arrivals' ORDER BY p.P_Id DESC;";
$res = mysqli_query($conn, $sel);
?>

<!-- Hero/Banner Section -->
<section class="relative h-72 flex items-center justify-center bg-gradient-to-br from-teal-100 via-white to-teal-200 mb-8">
    <div class="absolute inset-0 bg-gradient-to-br from-black/30 via-transparent to-teal-400/30 animate-gradient-move"></div>
    <div class="relative z-10 text-center">
        <h1 class="text-5xl md:text-6xl font-extrabold text-black drop-shadow-lg mb-2 animate-fade-in">New Arrivals</h1>
        <p class="text-lg text-gray-700 animate-fade-in delay-200 mb-4">Discover the latest trends and hottest products, just landed in our collection!</p>
        <a href="#Products" class="inline-block bg-black text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg hover:bg-teal-700 transition-all duration-200 animate-fade-in-up">Shop Now <i class="fa fa-arrow-down ml-2"></i></a>
    </div>
</section>

<section class="Products px-4 md:px-36 pt-6 pb-16 bg-gradient-to-br from-white via-teal-50 to-teal-100 animate-fade-in-up" id="Products">
    <h1 class="heading text-center text-black text-[2.5rem] md:text-[3rem] pb-8 uppercase font-bold tracking-wide animate-fade-in">Products</h1>

    <!-- Brand Filter -->
    <div class="inline-block relative mb-12 animate-fade-in-up">
        <button id="otherFilterBtn" class="border border-black px-4 py-2 rounded-md text-black font-bold flex items-center space-x-2 bg-white shadow hover:bg-teal-50 transition-all duration-200">
            <i class="fa fa-tags text-teal-600"></i>
            <span>BRAND (<span id="selectedBrandCount">0</span>)</span>
            <svg class="w-4 h-4 transition-transform duration-200" id="otherFilterArrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div id="otherFilterPanel" class="hidden absolute bg-white border border-gray-300 shadow-2xl w-96 p-4 mt-2 rounded-xl z-50 animate-fade-in-up">
            <span class="block text-gray-600 text-sm font-bold mb-2">Brand:</span>
            <div class="grid grid-cols-1 gap-2 mt-2">
                <?php
                $brands = ["MAC", "MAYBELLINE", "L'OREAL", "HUDA BEAUTY", "LAKME"];
                $brandIcons = [
                    "MAC" => "fa-brush",
                    "MAYBELLINE" => "fa-star",
                    "L'OREAL" => "fa-crown",
                    "HUDA BEAUTY" => "fa-gem",
                    "LAKME" => "fa-leaf",
                ];
                foreach ($brands as $brand) : ?>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="brand-checkbox" value="<?php echo strtolower($brand); ?>">
                        <i class="fa <?php echo $brandIcons[$brand] ?? 'fa-dot-circle'; ?> text-teal-400"></i>
                        <span><?php echo $brand; ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="flex justify-between mt-4">
                <button id="clearBrandFilter" class="border border-black px-4 py-2 text-black rounded-md hover:bg-teal-100 hover:text-teal-800 transition-all duration-200 shadow">CLEAR</button>
                <button id="applyOtherFilter" class="bg-black text-white px-4 py-2 rounded-md hover:bg-teal-700 transition-all duration-200 shadow">APPLY</button>
            </div>
        </div>
    </div>

    <!-- Type Filter -->
    <div class="inline-block relative animate-fade-in-up">
        <button id="filterDropdownBtn" class="border border-black px-4 py-2 rounded-md text-black font-bold flex items-center space-x-2 bg-white shadow hover:bg-teal-50 transition-all duration-200">
            <i class="fa fa-filter text-teal-600"></i>
            <span>TYPE (<span id="selectedCount">0</span>)</span>
            <svg class="w-4 h-4 transition-transform duration-200" id="filterArrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div id="filterDropdown" class="hidden absolute bg-white border border-gray-300 shadow-2xl w-64 p-4 mt-2 rounded-xl z-50 animate-fade-in-up">
            <span class="block text-gray-600 text-sm font-bold mb-2">Sort By:</span>
            <div class="grid grid-cols-1 gap-2 mt-2">
                <?php
                $types = ["Primer", "Foundation", "Concealer", "Setting Powder", "Blush", "Highlighter", "Eyebrow pencil", "Lipstick", "Mascara", "Eyeshadow Palette", "Eyelinear", "Primer"];
                $icons = [
                    "Primer" => "fa-flask",
                    "Foundation" => "fa-pump-soap",
                    "Concealer" => "fa-magic",
                    "Setting Powder" => "fa-cloud",
                    "Blush" => "fa-brush",
                    "Highlighter" => "fa-star",
                    "Eyebrow pencil" => "fa-pen",
                    "Lipstick" => "fa-lipstick",
                    "Mascara" => "fa-eye",
                    "Eyeshadow Palette" => "fa-palette",
                    "Eyelinear" => "fa-pen-nib",
                ];
                foreach ($types as $type) : ?>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="filter-checkbox" value="<?php echo strtolower($type); ?>">
                        <i class="fa <?php echo $icons[$type] ?? 'fa-dot-circle'; ?> text-teal-400"></i>
                        <span><?php echo $type; ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="flex justify-between mt-4">
                <button id="clearFilter" class="border border-black px-4 py-2 text-black rounded-md hover:bg-teal-100 hover:text-teal-800 transition-all duration-200 shadow">CLEAR</button>
                <button id="applyFilter" class="bg-black text-white px-4 py-2 rounded-md hover:bg-teal-700 transition-all duration-200 shadow">APPLY</button>
            </div>
        </div>
    </div>

    <div class="box-container grid grid-cols-1 sm:grid-cols-2 gap-9 lg:grid-cols-4 md:grid-cols-4 animate-fade-in-up" data-id="1">
        <?php while ($row = mysqli_fetch_assoc($res)) : ?>
            <div class="product" data-id="<?php echo $row['P_Id']; ?>" data-brand="<?php echo strtolower($row['P_Category']); ?>" data-type="<?php echo strtolower($row['P_Product']); ?>">
                <div class="box p-6 bg-white overflow-hidden shadow-lg rounded-2xl border border-opacity-20 text-center relative hover:shadow-2xl hover:scale-105 hover:border-teal-600 border transition-all duration-300 cursor-pointer animate-fade-in-up">
                    <a href="product.php?id=<?php echo $row['P_Id']; ?>" class="fas fa-eye absolute top-6 left-6 rounded-full h-10 w-10 text-2xl text-teal-700 flex items-center justify-center white transition-all duration-200"></a>
                    <a href="#" class="fas fa-heart absolute top-6 right-6 rounded-full h-10 w-10 text-2xl text-teal-700 flex items-center justify-center wishlist-button transition-all duration-200"></a>
                    <div class="image-container flex items-center justify-center h-full p-2">
                        <img class="max-w-full max-h-full rounded-lg shadow" src='../admin/components/uploads/<?php echo $row['image_1']; ?>' alt="Product Image">
                    </div>
                    <h3 class="text-2xl h-24 text-teal-700 font-semibold mt-2 mb-1"><?php echo $row['P_Name']; ?></h3>
                    <p class="text-teal-600 text-3xl md:text-4xl mt-2 font-bold">₹<?php echo $row['P_Price']; ?></p>
                    <button class="add-to-cart hover:bg-[#008080] hover:tracking-wide mt-4 text-xl inline-block text-white bg-black rounded-lg cursor-pointer py-2 px-6">Add to Bag <i class="fa fa-arrow-right ml-2"></i></button>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <div id="noProductMessage" class="flex flex-col items-center justify-center text-center text-teal-700 text-xl hidden mt-12 animate-fade-in-up">
        <img src="../Images/empty-box.png" alt="No Products" class="w-32 h-32 mx-auto mb-4 opacity-70">
        <span>No Product Added Yet</span>
    </div>

    <!-- Back to Top Button -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'});" id="backToTopBtn" class="fixed bottom-8 right-8 z-50 bg-teal-500 text-white p-4 rounded-full shadow-lg hover:bg-teal-600 transition-all duration-200 hidden" title="Back to Top"><i class="fas fa-arrow-up"></i></button>
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .animate-fade-in {
        animation: fade-in 1s ease;
    }

    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 1s ease;
    }

    @keyframes gradient-move {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .animate-gradient-move {
        background-size: 200% 200%;
        animation: gradient-move 6s ease-in-out infinite;
    }
</style>

<?php include('footer.php'); ?>

<script>
    document.getElementById('otherFilterBtn').addEventListener('click', function() {
        const panel = document.getElementById('otherFilterPanel');
        const arrow = document.getElementById('otherFilterArrow');
        panel.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    });

    document.getElementById('applyOtherFilter').addEventListener('click', function() {
        let selectedBrands = [];
        document.querySelectorAll('#otherFilterPanel input[type="checkbox"]:checked').forEach(checkbox => {
            selectedBrands.push(checkbox.nextElementSibling.textContent.trim().toLowerCase());
        });

        let products = document.querySelectorAll('.product');
        let visibleProducts = 0;
        products.forEach(product => {
            let productBrand = product.getAttribute('data-brand').trim().toLowerCase();
            if (selectedBrands.length === 0 || selectedBrands.includes(productBrand)) {
                product.style.display = 'block';
                visibleProducts++;
            } else {
                product.style.display = 'none';
            }
        });

        document.getElementById('otherFilterPanel').classList.add('hidden');
        document.getElementById('noProductMessage').classList.toggle('hidden', visibleProducts > 0);
    });

    document.getElementById('clearBrandFilter').addEventListener('click', function() {
        document.querySelectorAll('.brand-checkbox').forEach(checkbox => checkbox.checked = false);
        document.querySelectorAll('.product').forEach(product => product.style.display = 'block');
        updateBrandFilterCount();
        document.getElementById('noProductMessage').classList.add('hidden');
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
        let selectedTypes = [];
        document.querySelectorAll('.filter-checkbox:checked').forEach(checkbox => {
            selectedTypes.push(checkbox.value.toLowerCase());
        });

        let products = document.querySelectorAll('.product');
        let visibleProducts = 0;
        products.forEach(product => {
            let productType = product.getAttribute('data-type');
            if (selectedTypes.length === 0 || selectedTypes.includes(productType)) {
                product.style.display = 'block';
                visibleProducts++;
            } else {
                product.style.display = 'none';
            }
        });

        document.getElementById('filterDropdown').classList.add('hidden');
        document.getElementById('filterArrow').classList.remove('rotate-180');
        document.getElementById('noProductMessage').classList.toggle('hidden', visibleProducts > 0);
    });

    document.getElementById('clearFilter').addEventListener('click', function() {
        document.querySelectorAll('.filter-checkbox').forEach(checkbox => checkbox.checked = false);
        document.querySelectorAll('.product').forEach(product => product.style.display = 'block');
        updateFilterCount();
        document.getElementById('noProductMessage').classList.add('hidden');
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

    function addToCart(productId, productName, productPrice, productImage) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const existingProduct = cart.find(item => item.id === productId);

        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage,
                quantity: 1
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        alert(`${productName} added to cart!`);
        updateCartCount();
    }

    function addToWishlist(productId, productName, productPrice, productImage) {
        fetch('add_to_wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    productId,
                    productName,
                    productPrice,
                    productImage
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`${productName} added to wishlist!`);
                } else {
                    alert(`${productName} is already in your wishlist!`);
                }
            });
    }

    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartCountElement = document.querySelector('.cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = cart.length;
        }
    }

    updateCartCount();

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', (event) => {
            const isLoggedIn = <?php echo isset($_SESSION['Email']) ? 'true' : 'false'; ?>;

            if (isLoggedIn) {
                const productElement = event.target.closest('.product');
                const productId = parseInt(productElement.getAttribute('data-id'));
                const productName = productElement.querySelector('h3').textContent;
                const productPrice = parseFloat(productElement.querySelector('p').textContent.replace('₹', ''));
                const productImage = productElement.querySelector('img').src;

                addToCart(productId, productName, productPrice, productImage);
            } else {
                alert('Please log in first to add products to your cart.');
                window.location.href = 'login.php';
            }
        });
    });

    document.querySelectorAll('.wishlist-button').forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const isLoggedIn = <?php echo isset($_SESSION['Email']) ? 'true' : 'false'; ?>;

            if (isLoggedIn) {
                const productElement = event.target.closest('.product');
                const productId = parseInt(productElement.getAttribute('data-id'));
                const productName = productElement.querySelector('h3').textContent;
                const productPrice = parseFloat(productElement.querySelector('p').textContent.replace('₹', ''));
                const productImage = productElement.querySelector('img').src;

                addToWishlist(productId, productName, productPrice, productImage);
            } else {
                alert('Please log in first to add products to your wishlist.');
                window.location.href = 'login.php';
            }
        });
    });

    function logout() {
        localStorage.removeItem('cart');
        localStorage.removeItem('wishlist');
        updateCartCount();
        window.location.href = 'login.php';
    }

    document.querySelector('#logoutButton').addEventListener('click', logout);

    window.addEventListener('scroll', function() {
        const btn = document.getElementById('backToTopBtn');
        if (window.scrollY > 300) {
            btn.classList.remove('hidden');
        } else {
            btn.classList.add('hidden');
        }
    });
</script>

</html>