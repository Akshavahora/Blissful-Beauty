<?php
$content = '';
include('./header.php');
?>

<!-- Hero Section -->
<section class="relative h-72 flex items-center justify-center bg-cover bg-center" style="background-image: url('../Images/aboutbg.jpeg');">
    <div class="absolute inset-0 bg-black opacity-60"></div>
    <div class="relative z-10 text-center">
        <h1 class="text-5xl md:text-7xl font-extrabold text-white drop-shadow-lg mb-2 animate-fade-in">About Us</h1>
        <p class="text-lg text-gray-200 animate-fade-in delay-200">Discover our mission, commitment, and values</p>
    </div>
</section>

<section class="px-4 md:px-36 even:bg-gray-200 mt-20 md:mt-52 animate-fade-in-up">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div>
                <h2 class="text-4xl md:text-7xl font-bold mb-8 md:mb-14 -mt-10 md:-mt-24 text-teal-700">Our Mission</h2>
                <p class="text-lg md:text-2xl text-black mb-6 md:mb-10">
                    At our core, we strive to revolutionize the beauty industry by making high-quality, sustainable, and inclusive products accessible to everyone. Our mission is to celebrate individuality and diversity, ensuring every customer finds something that truly complements their unique style.
                </p>
                <p class="text-lg md:text-2xl text-black">
                    With our curated collection of top brands, we aim to inspire confidence and empower individuals to embrace their natural beauty. Join us in our journey to make beauty ethical, innovative, and exciting.
                </p>
            </div>
            <div>
                <img src="../Images/b1.jpg" alt="Our Mission" class="rounded-2xl shadow-2xl h-64 md:h-90 w-full object-cover">
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center mt-12">
            <div class="lg:order-2 mt-14">
                <h2 class="text-4xl md:text-7xl font-bold mb-8 md:mb-14 mt-8 md:-mt-24 text-teal-700">Our Commitment</h2>
                <p class="text-lg md:text-2xl text-black mb-6 md:mb-10">
                    Sustainability is at the heart of everything we do. We partner with brands that share our values of reducing environmental impact, using cruelty-free methods, and delivering eco-friendly packaging.
                </p>
                <p class="text-lg md:text-2xl text-black">
                    By supporting us, you are joining a community that cares deeply about making a positive impact on the planet while enhancing the beauty experience for all.
                </p>
            </div>
            <div class="mt-28">
                <img src="../Images/commitement-image.jpg" alt="Our Commitment" class="rounded-2xl shadow-2xl h-64 md:h-90 w-full object-cover">
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="px-4 md:px-36 mt-20 md:mt-32 animate-fade-in-up">
    <div class="container mx-auto">
        <h2 class="text-3xl md:text-5xl font-bold text-center text-teal-700 mb-12">Why Choose Us?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl shadow-xl p-8 flex flex-col items-center hover:scale-105 transition-transform duration-300">
                <i class="fas fa-leaf text-5xl text-green-500 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Eco-Friendly</h3>
                <p class="text-gray-600 text-center">We are committed to sustainability and eco-friendly packaging in all our products.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-8 flex flex-col items-center hover:scale-105 transition-transform duration-300">
                <i class="fas fa-users text-5xl text-teal-500 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Inclusive</h3>
                <p class="text-gray-600 text-center">Our products celebrate diversity and are made for every skin tone and style.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-8 flex flex-col items-center hover:scale-105 transition-transform duration-300">
                <i class="fas fa-award text-5xl text-yellow-500 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Top Brands</h3>
                <p class="text-gray-600 text-center">We curate only the best, most innovative, and trusted brands in the beauty industry.</p>
            </div>
        </div>
    </div>
</section>

<section class="px-4 md:px-36 mt-20 md:mt-32">
    <div class="flex flex-wrap gap-8 md:gap-16 items-center justify-center mb-12 mt-12 animate-fade-in-up">
        <div class="w-64 h-64 md:w-80 md:h-80 flex flex-col justify-around items-center rounded-2xl border-b-4 shadow-2xl bg-gradient-to-br from-teal-100 to-white hover:from-teal-200 transition-all duration-300">
            <i class="fas fa-spa text-teal-500 text-5xl"></i>
            <span class="num text-black text-5xl md:text-6xl font-semibold" data-val="500">000</span>
            <span class="text-gray-800 text-lg md:text-2xl ">Products Sold</span>
        </div>
        <div class="w-64 h-64 md:w-80 md:h-80 flex flex-col justify-around items-center rounded-2xl border-b-4 shadow-2xl bg-gradient-to-br from-pink-100 to-white hover:from-pink-200 transition-all duration-300">
            <i class="fas fa-heart text-pink-500 text-5xl"></i>
            <span class="num text-black text-5xl md:text-6xl font-semibold" data-val="400">000</span>
            <span class="text-gray-800 text-lg md:text-2xl ">Happy Customers</span>
        </div>
        <div class="w-64 h-64 md:w-80 md:h-80 flex flex-col justify-around items-center rounded-2xl border-b-4 shadow-2xl bg-gradient-to-br from-yellow-100 to-white hover:from-yellow-200 transition-all duration-300">
            <i class="fas fa-magic text-yellow-500 text-5xl"></i>
            <span class="num text-black text-5xl md:text-6xl font-semibold" data-val="300">000</span>
            <span class="text-gray-800 text-lg md:text-2xl ">Makeovers</span>
        </div>
        <div class="w-64 h-64 md:w-80 md:h-80 flex flex-col justify-around items-center rounded-2xl border-b-4 shadow-2xl bg-gradient-to-br from-purple-100 to-white hover:from-purple-200 transition-all duration-300">
            <i class="fas fa-star text-purple-500 text-5xl"></i>
            <span class="num text-black text-5xl md:text-6xl font-semibold" data-val="350">000</span>
            <span class="text-gray-800 text-lg md:text-2xl ">Five-Star Reviews</span>
        </div>
    </div>
</section>

<!-- Font Awesome CDN for icons -->
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

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    let valueDisplays = document.querySelectorAll(".num");
    let interval = 4000;
    valueDisplays.forEach((valueDisplay) => {
        let startValue = 0;
        let endValue = parseInt(valueDisplay.getAttribute("data-val"));
        let duration = Math.floor(interval / endValue);
        let counter = setInterval(function() {
            startValue += 1;
            valueDisplay.textContent = startValue;
            if (startValue == endValue) {
                clearInterval(counter);
            }
        }, duration);
    });
</script>

<?php
include('./footer.php');
?>
<!-- <script src="../js/script.js"></script> -->
<script src="../js/script.js"></script>