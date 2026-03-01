<?php
session_start();

// header location
$content = '';
require_once('header.php');

if (!isset($_SESSION['Id'])) {
    // User is not logged in, set a flag to show the alert
    $showAlert = true;
} else {
    // User is logged in, proceed with the wishlist logic
    $user_id = $_SESSION['Id'];
    $content = '';

    // Initialize wishlist in session if not already set
    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = [];
    }

    $wishlist = $_SESSION['wishlist'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/instantsearch.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="flex flex-col min-h-screen bg-gradient-to-br from-pink-50 to-teal-50">
    <section class="px-4 md:px-32 pt-16 pb-16 flex flex-col items-center flex-1" id="Wishlist">
        <h1 class="text-center text-pink-600 text-3xl md:text-5xl pb-10 uppercase font-extrabold tracking-wide">Wishlist</h1>
        <div class="box-container grid grid-cols-1 sm:grid-cols-2 gap-12 lg:grid-cols-4 md:grid-cols-3 w-full max-w-full" id="wishlist-container">
            <?php if (isset($showAlert)): ?>
                <script>
                    alert('User Not Logged In. Please Login');
                    window.location.href = 'login.php';
                </script>
            <?php elseif (empty($wishlist)): ?>
                <div class="col-span-full flex flex-col items-center justify-center py-20 w-full">
                    <img src="https://cdn.jsdelivr.net/gh/edent/SuperTinyIcons/images/svg/heart.svg" alt="Empty Wishlist" class="w-20 h-20 mb-4">
                    <p class="text-xl text-gray-500 font-semibold mb-2">Your wishlist is empty.</p>
                    <a href="./shop.php" class="text-pink-600 font-bold hover:underline text-xl">Go to Shop</a>
                </div>
            <?php else: ?>
                <?php foreach ($wishlist as $item): ?>
                    <div class="product" data-id="<?php echo $item['id']; ?>">
                        <div class="p-10 bg-white overflow-hidden shadow-2xl rounded-3xl border-2 border-gray-100 transition-all duration-200 hover:shadow-2xl hover:scale-105 hover:border-pink-500 border-opacity-100 cursor-pointer text-center relative">
                            <span class="absolute top-3 right-3 text-pink-500 text-2xl bg-white rounded-full p-2 shadow-md z-10"><i class="fas fa-heart"></i></span>
                            <div class="flex items-center justify-center mb-6">
                                <div class="w-56 h-56 bg-gradient-to-br from-gray-100 to-pink-50 rounded-2xl flex items-center justify-center border border-gray-200 shadow-lg">
                                    <a href="product.php?id=<?php echo $item['id']; ?>">
                                        <img class="max-w-full max-h-full object-contain rounded-xl"
                                            src="<?php echo $item['image']; ?>"
                                            alt="Product Image">
                                    </a>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2"><?php echo $item['name']; ?></h3>
                            <p class="text-pink-600 text-3xl font-extrabold mt-2">₹<?php echo $item['price']; ?></p>
                            <button class="remove-from-wishlist mt-6 text-lg inline-flex items-center justify-center bg-pink-500 hover:bg-pink-600 transition-all text-white rounded-lg cursor-pointer py-3 px-8 font-bold shadow"><i class="fas fa-trash mr-2"></i>Remove</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>


    <?php include("./footer.php"); ?>
</body>

<!-- Back to Top Button -->
<button onclick="window.scrollTo({top: 0, behavior: 'smooth'});" id="backToTopBtn" class="fixed bottom-8 right-8 z-50 bg-teal-500 text-white p-4 rounded-full shadow-lg hover:bg-teal-600 transition-all duration-200 hidden" title="Back to Top"><i class="fas fa-arrow-up"></i></button>

<script>
    document.querySelectorAll('.remove-from-wishlist').forEach(button => {
        button.addEventListener('click', (event) => {
            const productElement = event.target.closest('.product');
            const productId = parseInt(productElement.getAttribute('data-id'));
            removeFromWishlist(productId);
        });
    });

    function removeFromWishlist(productId) {
        fetch('remove_from_wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    productId: productId
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayWishlist();
                } else {
                    console.error('Error removing item from wishlist:', data.message);
                }
            });
    }

    function displayWishlist() {
        fetch('fetch_wishlist.php')
            .then(response => response.json())
            .then(data => {
                const wishlistContainer = document.getElementById('wishlist-container');
                wishlistContainer.innerHTML = '';
                if (data.wishlist.length === 0) {
                    wishlistContainer.innerHTML = `<div class="col-span-full flex flex-col items-center justify-center py-12 w-full">          
                        <div class="flex flex-col items-center justify-center py-16">
                            <i class="fa-solid fa-box text-6xl text-gray-300 mb-4"></i>
                            <p class="text-xl text-gray-500 font-semibold mb-2">No products</p>
                        </div>
                        <span >No Product Added Yet</span>
                            <a href="./shop.php" class="text-pink-600 font-bold hover:underline text-base">Go to Shop</a>
                    </div>`;
                } else {
                    data.wishlist.forEach(item => {
                        const productDiv = document.createElement('div');
                        productDiv.classList.add('product');
                        productDiv.setAttribute('data-id', item.id);
                        productDiv.innerHTML = `
                                <div class="p-10 bg-white overflow-hidden shadow-2xl rounded-3xl border-2 border-gray-100 transition-all duration-200 hover:shadow-2xl hover:scale-105 hover:border-pink-500 border-opacity-100 cursor-pointer text-center relative">
                                    <span class="absolute top-3 right-3 text-pink-500 text-2xl bg-white rounded-full p-2 shadow-md z-10"><i class="fas fa-heart"></i></span>
                                    <div class="flex items-center justify-center mb-6">
                                        <div class="w-56 h-56 bg-gradient-to-br from-gray-100 to-pink-50 rounded-2xl flex items-center justify-center border border-gray-200 shadow-lg">
                                            <a href="product.php?id=${item.id}">
    <img class="max-w-full max-h-full object-contain rounded-xl" src="${item.image}" alt="Product Image">
</a>
                                        </div>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-800 mb-2">${item.name}</h3>
                                    <p class="text-pink-600 text-3xl font-extrabold mt-2">₹${item.price}</p>
                                    <button class="remove-from-wishlist mt-6 text-lg inline-flex items-center justify-center bg-pink-500 hover:bg-pink-600 transition-all text-white rounded-lg cursor-pointer py-3 px-8 font-bold shadow"><i class="fas fa-trash mr-2"></i>Remove</button>
                                </div>
                            `;
                        wishlistContainer.appendChild(productDiv);
                    });
                    document.querySelectorAll('.remove-from-wishlist').forEach(button => {
                        button.addEventListener('click', (event) => {
                            const productElement = event.target.closest('.product');
                            const productId = parseInt(productElement.getAttribute('data-id'));
                            removeFromWishlist(productId);
                        });
                    });
                }
            });
    }
    displayWishlist();

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