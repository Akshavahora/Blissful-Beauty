<?php
session_start();
require_once('../dbconnection/connection.php');
$content = '';
include('./header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    </style>
</head>

<body class="bg-gradient-to-br from-white via-gray-50 to-teal-50">

    <!-- Hero/Banner Section -->
    <section class="relative h-[32rem] flex items-center justify-center bg-cover bg-center mb-8 animate-fade-in rounded-b-3xl shadow-lg" style="background-image: url('../Images/Slider-Images/Slider-03.jpg');">
        <div class="absolute inset-0 bg-black opacity-60 rounded-b-3xl"></div>
        <div class="relative z-10 text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white drop-shadow-lg mb-4 animate-fade-in">Welcome to <span class="text-teal-300">Cosmetic Store</span></h1>
            <p class="text-lg md:text-2xl text-gray-200 mb-8 animate-fade-in delay-200">Discover the best in beauty, curated just for you.</p>
            <a href="shop.php" class="inline-block bg-teal-600 text-white text-xl font-semibold px-8 py-3 rounded-lg shadow-lg hover:bg-teal-700 transition-all duration-200 animate-fade-in-up">Shop Now <i class="fa fa-arrow-right ml-2"></i></a>
        </div>
    </section>

    <!-- Home section starts (Swiper) -->
    <section class="home px-4 md:px-36 animate-fade-in-up bg-gradient-to-br from-pink-50 via-white to-pink-100 py-16 rounded-3xl shadow-md mb-16">
        <div class="swiper mySwiper home-slider pt-12" id="id1">
            <div class="swiper-wrapper wrapper">
                <div class="swiper-slide slide">
                    <div class="content">
                        <span>New Arrival</span>
                        <h3>MAC Glitter Eye Shadow</h3>
                        <p>A carefully designed palette with a range of rich burgundy shades for creating stunning looks.</p>
                        <a href="ordernow.php" class="btn hover:bg-[#008080] hover:tracking-wide mt-4 text-3xl inline-block text-white bg-black rounded-lg cursor-pointer py-2 px-12">Order Now <i class="fa fa-arrow-right ml-2"></i></a>
                    </div>
                    <div class="image">
                        <img src="../Images/Slider-Images/mac glitter eyeshadow.avif" alt="MAC Glitter Eye Shadow">
                    </div>
                </div>
                <div class="swiper-slide slide">
                    <div class="content">
                        <span>New Arrival</span>
                        <h3>MAC Lustre Lipstick</h3>
                        <p>Enjoy a creamy lipstick that feels soft on your lips, offers medium to full coverage, and has a smooth satin finish.</p>
                        <a href="ordernow.php" class="btn hover:bg-[#008080] hover:tracking-wide mt-4 text-3xl inline-block text-white bg-black rounded-lg cursor-pointer py-2 px-12">Order Now <i class="fa fa-arrow-right ml-2"></i></a>
                    </div>
                    <div class="image">
                        <img src="../Images/Slider-Images/Slider-2.png" alt="MAC Lustre Lipstick">
                    </div>
                </div>
                <div class="swiper-slide slide">
                    <div class="content">
                        <span>New Arrival</span>
                        <h3>MAC Liquid Concealer</h3>
                        <p>A lightweight concealer with a wand that provides comfortable all-day wear, medium to full coverage, and a natural matte finish.</p>
                        <a href="#" class="btn hover:bg-[#008080] hover:tracking-wide mt-4 text-3xl inline-block text-white bg-black rounded-lg cursor-pointer py-2 px-12">Order Now <i class="fa fa-arrow-right ml-2"></i></a>
                    </div>
                    <div class="image">
                        <img src="../Images/Slider-Images/Slider_003.avif" alt="MAC Liquid Concealer">
                    </div>
                </div>
                <div class="swiper-slide slide">
                    <div class="content">
                        <span>New Arrival</span>
                        <h3>Makeup Brushes Kit</h3>
                        <p>A smooth, clump-free mascara that you can layer for incredible volume and length, giving you a bold look with every swipe.</p>
                        <a href="#" class="btn hover:bg-[#008080] hover:tracking-wide mt-4 text-3xl inline-block text-white bg-black rounded-lg cursor-pointer py-2 px-12">Order Now <i class="fa fa-arrow-right ml-2"></i></a>
                    </div>
                    <div class="image">
                        <img src="../Images/Slider-Images/Slider-4.png" alt="Makeup Brushes Kit">
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- Home section ends -->

    <!-- Top-rated section start -->
    <?php
    $sel = "SELECT * FROM product p INNER JOIN product_shades ps ON p.P_Id = ps.product_id WHERE p.filter_name = 'Top-rated' ORDER BY p.P_Id DESC LIMIT 8;";
    $res = mysqli_query($conn, $sel);
    ?>
    <section class="Products px-4 md:px-36 pt-32 pb-16 animate-fade-in-up bg-gradient-to-br from-teal-50 via-white to-teal-100 rounded-3xl shadow-md mb-16" id="Products">
        <h1 class="heading text-center text-teal-700 text-[2.5rem] md:text-[3rem] pb-8 uppercase font-extrabold tracking-wide animate-fade-in">Top-rated</h1>
        <div class="box-container grid grid-cols-1 sm:grid-cols-2 gap-9 lg:grid-cols-4 md:grid-cols-4 animate-fade-in-up">
            <?php while ($row = mysqli_fetch_assoc($res)) : ?>
                <?php $productType = isset($row['type']) ? strtolower($row['type']) : 'unknown'; ?>
                <div class="product" data-id="<?php echo $row['P_Id']; ?>" data-brand="<?php echo strtolower($row['P_Category']); ?>" data-type="<?php echo $productType; ?>">
                    <div class="box p-10 bg-white overflow-hidden shadow-xl rounded-2xl border border-opacity-20 text-center relative hover:shadow-2xl hover:scale-105 hover:border-teal-400 border transition-all duration-300 cursor-pointer animate-fade-in-up">
                        <span class="absolute top-2 left-2 bg-teal-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">Top</span>
                        <a href="#" class="fas fa-heart absolute top-6 right-6 rounded-full h-10 w-10 text-2xl text-black flex items-center justify-center wishlist-button transition-all duration-200"></a>
                        <a href="product.php?id=<?php echo $row['P_Id']; ?>" class="fas fa-eye absolute top-6 left-6 rounded-full h-10 w-10 text-2xl text-black flex items-center justify-center  transition-all duration-200"></a>
                        <img class="w-full h-full p-2 rounded-lg shadow" src='../admin/components/uploads/<?php echo $row['image_1']; ?>' alt="Product Image">
                        <h3 class="text-xl text-teal-700 h-24 font-semibold mt-2 mb-1"><?php echo $row['P_Name']; ?></h3>
                        <p class="text-teal-500 text-3xl md:text-4xl mt-2 font-bold">₹<?php echo $row['P_Price']; ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <a href="./top_rated.php"><button class="hover:bg-teal-500 hover:tracking-wide mt-4 text-xl inline-block text-white bg-black rounded-lg cursor-pointer py-2 px-6 transition-all duration-200 shadow-md">Explore More <i class="fa fa-arrow-right ml-2"></i></button></a>
    </section>
    <!-- Top-rated section ends -->

    <!-- New Arrivals section start -->
    <?php
    $sel = "SELECT * FROM product p INNER JOIN product_shades ps ON p.P_Id = ps.product_id WHERE p.filter_name = 'New Arrivals' ORDER BY p.P_Id DESC LIMIT 4;";
    $res = mysqli_query($conn, $sel);
    ?>
    <section class="Products px-4 md:px-36 pt-32 pb-16 animate-fade-in-up bg-gradient-to-br from-teal-50 via-white to-teal-100 rounded-3xl shadow-md mb-16" id="Products">
        <h1 class="heading text-center text-teal-700 text-[2.5rem] md:text-[3rem] pb-8 uppercase font-extrabold tracking-wide animate-fade-in">New Arrivals</h1>
        <div class="box-container grid grid-cols-1 sm:grid-cols-2 gap-9 lg:grid-cols-4 md:grid-cols-4 animate-fade-in-up">
            <?php while ($row = mysqli_fetch_assoc($res)) : ?>
                <?php $productType = isset($row['type']) ? strtolower($row['type']) : 'unknown'; ?>
                <div class="product" data-id="<?php echo $row['P_Id']; ?>" data-brand="<?php echo strtolower($row['P_Category']); ?>" data-type="<?php echo $productType; ?>">
                    <div class="box p-10 bg-white overflow-hidden shadow-xl rounded-2xl border border-opacity-20 text-center relative hover:shadow-2xl hover:scale-105 hover:border-teal-400 border transition-all duration-300 cursor-pointer animate-fade-in-up">
                        <span class="absolute top-2 left-2 bg-teal-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">New</span>
                        <a href="#" class="fas fa-heart absolute top-6 right-6 rounded-full h-10 w-10 text-2xl text-black flex items-center justify-center wishlist-button transition-all duration-200"></a>
                        <a href="product.php?id=<?php echo $row['P_Id']; ?>" class="fas fa-eye absolute top-6 left-6 rounded-full h-10 w-10 text-2xl text-black flex items-center justify-center  transition-all duration-200"></a>
                        <div class="image-container flex items-center justify-center h-full p-2">
                            <img class="max-w-full max-h-full rounded-lg shadow" src='../admin/components/uploads/<?php echo $row['image_1']; ?>' alt="Product Image">
                        </div>
                        <h3 class="text-xl text-teal-700 h-24 font-semibold mt-2 mb-1"><?php echo $row['P_Name']; ?></h3>
                        <p class="text-teal-500 text-3xl md:text-4xl mt-2 font-bold">₹<?php echo $row['P_Price']; ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <a href="./new_arrivals.php"><button class="hover:bg-teal-500 hover:tracking-wide mt-4 text-xl inline-block text-white bg-black rounded-lg cursor-pointer py-2 px-6 transition-all duration-200 shadow-md">Explore More <i class="fa fa-arrow-right ml-2"></i></button></a>
    </section>
    <!-- New Arrivals section ends -->

    <!-- Features section start -->
    <section class="features px-4 md:px-36 pt-40 -mt-24 animate-fade-in-up bg-gradient-to-br from-purple-50 via-white to-purple-100 rounded-3xl shadow-md mb-16" id="features">
        <h1 class="heading text-center text-purple-700 text-[2.5rem] md:text-[3rem] pb-8 uppercase font-extrabold tracking-wide animate-fade-in">Why Choose Us</h1>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-12 p-4 h-90">
            <div class="fe-box p-4 h-64 w-64 text-center shadow-xl shadow-gray-300 border-2 hover:border-teal-400 rounded-2xl mt-4 mb-4 hover:shadow-md hover:border-gray-100 bg-white transition-all duration-300 animate-fade-in-up">
                <img src="../Images/features/f1.png" alt="Free Shipping" class="w-full mb-4">
                <h6 class="p-1 mt-2 rounded-md bg-red-100 text-[#088178]">Free Shipping</h6>
            </div>
            <div class="fe-box p-4 h-64 w-64 text-center shadow-xl shadow-gray-300 border-2 hover:border-teal-400 rounded-2xl mt-4 mb-4 hover:shadow-md hover:border-gray-100 bg-white transition-all duration-300 animate-fade-in-up">
                <img src="../Images/features/f2.png" alt="Online Order" class="w-full mb-4">
                <h6 class="p-1 mt-2 rounded-md bg-[#cdebbc] text-[#088178]">Online Order</h6>
            </div>
            <div class="fe-box p-4 h-64 w-64 text-center shadow-xl shadow-gray-300 border-2 hover:border-teal-400 rounded-2xl mt-4 mb-4 hover:shadow-md hover:border-gray-100 bg-white transition-all duration-300 animate-fade-in-up">
                <img src="../Images/features/f3.png" alt="Save Money" class="w-full mb-4">
                <h6 class="p-1 mt-2 rounded-md bg-[#d1e8f2] text-[#088178]">Save Money</h6>
            </div>
            <div class="fe-box p-4 h-64 w-64 text-center shadow-xl shadow-gray-300 border-2 hover:border-teal-400 rounded-2xl mt-4 mb-4 hover:shadow-md hover:border-gray-100 bg-white transition-all duration-300 animate-fade-in-up">
                <img src="../Images/features/f4.png" alt="Promotions" class="w-full mb-4">
                <h6 class="p-1 mt-2 rounded-md bg-[#cdd4f8] text-[#088178]">Promotions</h6>
            </div>
            <div class="fe-box p-4 h-64 w-64 text-center shadow-xl shadow-gray-300 border-2 hover:border-teal-400 rounded-2xl mt-4 mb-4 hover:shadow-md hover:border-gray-100 bg-white transition-all duration-300 animate-fade-in-up">
                <img src="../Images/features/f5.png" alt="Happy Sell" class="w-full mb-4">
                <h6 class="p-1 mt-2 rounded-md bg-[#f6dbf6] text-[#088178]">Happy Sell</h6>
            </div>
            <div class="fe-box p-4 h-64 w-64 text-center shadow-xl shadow-gray-300 border-2 hover:border-teal-400 rounded-2xl mt-4 mb-4 hover:shadow-md hover:border-gray-100 bg-white transition-all duration-300 animate-fade-in-up">
                <img src="../Images/features/f6.png" alt="24/7 Support" class="w-full mb-4">
                <h6 class="p-1 mt-2 rounded-md bg-[#fff2e5] text-[#088178]">24/7 Support</h6>
            </div>
        </div>
    </section>
    <!-- Features section end -->

    <!-- Brands section start -->
    <section class="features px-4 md:px-36 pt-40 -mt-24 mb-24 animate-fade-in-up bg-gradient-to-br from-pink-100 via-white to-pink-200 rounded-3xl shadow-md" id="features">
        <h1 class="heading text-center text-pink-700 text-[2.5rem] md:text-[3rem] pb-8 uppercase font-extrabold tracking-wide animate-fade-in">Brands</h1>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-10 animate-fade-in-up">
            <div class="shadow-sm h-60 bg-white shadow-xl border-4 hover:border-teal-400 rounded-2xl transition-all duration-300 flex items-center justify-center">
                <a href="./maccosmetic.php"><img src="../Images/brands/MAC-Logo.png" alt="MAC" class="p-6"></a>
            </div>
            <div class="shadow-sm bg-white h-60 shadow-xl border-4 hover:border-teal-400 rounded-2xl transition-all duration-300 flex items-center justify-center">
                <a href="./lakme.php"><img src="../Images/brands/Lakme-Logo.png" alt="Lakme" class="p-6"></a>
            </div>
            <div class="shadow-sm bg-white h-60 shadow-xl border-4 hover:border-teal-400 rounded-2xl transition-all duration-300 flex items-center justify-center">
                <a href="./loreal.php"><img src="../Images/brands/Loreal-Paris-Logo.png" alt="L'Oreal" class="p-6"></a>
            </div>
            <div class="shadow-sm bg-white h-60 shadow-xl border-4 hover:border-teal-400 rounded-2xl transition-all duration-300 flex items-center justify-center">
                <a href="./hudabeauty.php"><img src="../Images/brands/hudabeauty-logo.png" alt="Huda Beauty" class="p-4"></a>
            </div>
            <div class="shadow-sm bg-white h-60 shadow-xl border-4 hover:border-teal-400 rounded-2xl transition-all duration-300 flex items-center justify-center">
                <a href="./maybelline.php"><img src="../Images/brands/Maybelline-Logo.png" alt="Maybelline" class="p-8"></a>
            </div>
        </div>
    </section>
    <!-- Brands section end -->

    <!-- Reviews section start -->
    <section class="review px-4 md:px-36 animate-fade-in-up bg-gradient-to-br from-yellow-50 via-white to-yellow-100 rounded-3xl shadow-md mb-16" id="Review">
        <h1 class="heading text-center text-yellow-700 text-[2.5rem] md:text-[3rem] pb-8 uppercase font-extrabold tracking-wide animate-fade-in">Customer Reviews</h1>
        <div class="swiper review-Swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide items-center bg-white shadow-lg p-6 rounded-lg">
                    <div class="flex h-28 w-28">
                        <img src="../Images/reviews/pic-1.jpg" alt="Customer 1" class="w-20 h-full rounded-full object-cover mr-6">
                        <i class="fas fa-quote-right text-teal-500 text-6xl ml-[220px]"></i>
                    </div>
                    <div>
                        <p class="text-gray-700 mt-6">"As a professional makeup artist, I'm super picky about the products I use. This site offers an amazing selection of top-tier brands. The delivery was fast, and the customer service is outstanding!"</p>
                        <p class="mt-2 font-bold text-gray-900">- Jane Doe</p>
                        <div class="text-teal-500 flex mt-1 justify-center">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide items-center bg-white shadow-lg p-6 rounded-lg">
                    <div class="flex h-28 w-28">
                        <img src="../Images/reviews/pic-2.jpg" alt="Customer 2" class="w-20 h-full rounded-full object-cover mr-6">
                        <i class="fas fa-quote-right text-teal-500 text-6xl ml-[220px]"></i>
                    </div>
                    <div>
                        <p class="text-gray-700 mt-6">"I am absolutely obsessed with the variety of products available here. From high-end foundations to the creamiest lipsticks, this site has everything I need."</p>
                        <p class="mt-2 font-bold text-gray-900">- Jane Doe</p>
                        <div class="text-teal-500 flex mt-1 justify-center">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide items-center bg-white shadow-lg p-6 rounded-lg">
                    <div class="flex h-28 w-28">
                        <img src="../Images/reviews/pic-3.jpg" alt="Customer 3" class="w-20 h-full rounded-full object-cover mr-6">
                        <i class="fas fa-quote-right text-teal-500 text-6xl ml-[220px]"></i>
                    </div>
                    <div>
                        <p class="text-gray-700 mt-6">"I bought a complete makeup set from here, and the pricing is so reasonable for premium brands. Highly recommended!"</p>
                        <p class="mt-2 font-bold text-gray-900">- Jane Doe</p>
                        <div class="text-teal-500 flex mt-1 justify-center">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide items-center bg-white shadow-lg p-6 rounded-lg">
                    <div class="flex h-28 w-28">
                        <img src="../Images/reviews/pic-4.jpg" alt="Customer 4" class="w-20 h-full rounded-full object-cover mr-6">
                        <i class="fas fa-quote-right text-teal-500 text-6xl ml-[220px]"></i>
                    </div>
                    <div>
                        <p class="text-gray-700 mt-6">"I've been shopping here for months, and it never disappoints. The selection is amazing, and I love the little samples they include with my orders."</p>
                        <p class="mt-2 font-bold text-gray-900">- Jane Doe</p>
                        <div class="text-teal-500 flex mt-1 justify-center">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide items-center bg-white shadow-lg p-6 rounded-lg">
                    <div class="flex h-28 w-28">
                        <img src="../Images/reviews/pic-5.jpg" alt="Customer 5" class="w-20 h-full rounded-full object-cover mr-6">
                        <i class="fas fa-quote-right text-teal-500 text-6xl ml-[220px]"></i>
                    </div>
                    <div>
                        <p class="text-gray-700 mt-6">"This site is a treasure trove for makeup lovers! The user-friendly interface and swift delivery make shopping here an absolute delight. Five stars all the way!"</p>
                        <p class="mt-2 font-bold text-gray-900">- Jane Doe</p>
                        <div class="text-teal-500 flex mt-1 justify-center">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide items-center bg-white shadow-lg p-6 rounded-lg">
                    <div class="flex h-28 w-28">
                        <img src="../Images/reviews/pic-6.jpg" alt="Customer 6" class="w-20 h-full rounded-full object-cover mr-6">
                        <i class="fas fa-quote-right text-teal-500 text-6xl ml-[220px]"></i>
                    </div>
                    <div>
                        <p class="text-gray-700 mt-6">"I can't believe how easy it is to get luxury makeup products delivered to my doorstep. The packaging is beautiful, and the products from brands like Huda Beauty are always authentic. Will definitely order again!"</p>
                        <p class="mt-2 font-bold text-gray-900">- Jane Doe</p>
                        <div class="text-teal-500 flex mt-1 justify-center">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination mt-6"></div>
        </div>
    </section>
    <!-- Reviews section end -->

    <script>
        // Function to add a product to the wishlist
        function addToWishlist(productId, productName, productPrice, productImage) {
            const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const existingProduct = wishlist.find(item => item.id === productId);

            if (!existingProduct) {
                wishlist.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    image: productImage
                });
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                alert(productName + ' added to wishlist!');
            } else {
                alert(productName + ' is already in your wishlist!');
            }
        }

        // Add event listeners to "Add to Wishlist" buttons
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
                    window.location.href = 'login.php'; // Redirect to the login page
                }
            });
        });

        // Toggle Other Filter Panel
        document.getElementById('otherFilterBtn').addEventListener('click', function() {
            const panel = document.getElementById('otherFilterPanel');
            const arrow = document.getElementById('otherFilterArrow');
            panel.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        });

        // Apply Other Filter
        document.getElementById('applyOtherFilter').addEventListener('click', function() {
            let selectedBrands = [];
            document.querySelectorAll('#otherFilterPanel input[type="checkbox"]:checked').forEach(checkbox => {
                selectedBrands.push(checkbox.nextElementSibling.textContent.trim().toLowerCase());
            });

            let products = document.querySelectorAll('.product');
            products.forEach(product => {
                let productBrand = product.getAttribute('data-brand').trim().toLowerCase();
                if (selectedBrands.length === 0 || selectedBrands.includes(productBrand)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });

            document.getElementById('otherFilterPanel').classList.add('hidden');
        });

        // Clear Brand Filter Functionality
        document.getElementById('clearBrandFilter').addEventListener('click', function() {
            document.querySelectorAll('.brand-checkbox').forEach(checkbox => checkbox.checked = false);
            document.querySelectorAll('.product').forEach(product => product.style.display = 'block');
            updateBrandFilterCount();
        });

        // Update Brand Filter Selection Count
        function updateBrandFilterCount() {
            let selectedBrands = document.querySelectorAll('.brand-checkbox:checked').length;
            document.getElementById('selectedBrandCount').textContent = selectedBrands;
        }

        document.querySelectorAll('.brand-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBrandFilterCount);
        });

        // Toggle Filter Dropdown
        document.getElementById('filterDropdownBtn').addEventListener('click', function() {
            const dropdown = document.getElementById('filterDropdown');
            const arrow = document.getElementById('filterArrow');
            dropdown.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        });

        // Apply Filter Functionality
        document.getElementById('applyFilter').addEventListener('click', function() {
            let selectedTypes = [];
            document.querySelectorAll('.filter-checkbox:checked').forEach(checkbox => {
                selectedTypes.push(checkbox.value.toLowerCase());
            });

            let products = document.querySelectorAll('.product');
            products.forEach(product => {
                let productType = product.getAttribute('data-type');
                if (selectedTypes.length === 0 || selectedTypes.includes(productType)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });

            document.getElementById('filterDropdown').classList.add('hidden');
            document.getElementById('filterArrow').classList.remove('rotate-180');
        });

        // Clear Filter Functionality
        document.getElementById('clearFilter').addEventListener('click', function() {
            document.querySelectorAll('.filter-checkbox').forEach(checkbox => checkbox.checked = false);
            document.querySelectorAll('.product').forEach(product => product.style.display = 'block');
            updateFilterCount();
        });

        // Update Filter Selection Count & Show "Other" Button
        function updateFilterCount() {
            let selectedFilters = document.querySelectorAll('.filter-checkbox:checked').length;
            document.getElementById('selectedCount').textContent = selectedFilters;
        }

        document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateFilterCount);
        });

        // Close dropdown when clicking outside
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

<?php
include('./footer.php');
?>