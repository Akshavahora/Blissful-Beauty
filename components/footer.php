<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Footer</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
  <!-- SVG Curve Divider -->
  <div class="-mb-1">
    <svg viewBox="0 0 1440 100" class="w-full" xmlns="http://www.w3.org/2000/svg">
      <path fill="#0f172a" fill-opacity="1" d="M0,64L1440,0L1440,320L0,320Z"></path>
    </svg>
  </div>
  <!-- footer content start  -->
  <footer class="text-gray-200 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-t-3xl shadow-2xl mt-40">
    <div class="container mx-auto px-6 md:px-12 py-14">
      <div class="grid grid-cols-1 md:grid-cols-5 gap-10 mt-6">
        <!-- About Us -->
        <div>
          <img class="h-24 w-24 -mt-6 mb-2 rounded-2xl shadow-lg border-4 border-teal-500" src="../Images/B.png" alt="">
          <h4 class="text-2xl font-extrabold mb-4 text-teal-400">About Us</h4>
          <p class="text-lg text-gray-300">Discover premium beauty products crafted with care and tailored to enhance your natural beauty.</p>
        </div>
        <!-- Quick Links 1 -->
        <div>
          <h4 class="text-xl font-bold mb-4 text-pink-300">Quick Links</h4>
          <ul>
            <li class="mb-2 text-lg"><a href="./index.php" class="hover:text-teal-400 transition">Home</a></li>
            <li class="mb-2 text-lg"><a href="./shop.php" class="hover:text-teal-400 transition">Shop</a></li>
            <li class="mb-2 text-lg"><a href="./aboutus.php" class="hover:text-teal-400 transition">About</a></li>
            <li class="mb-2 text-lg"><a href="./contactus.php" class="hover:text-teal-400 transition">Contact</a></li>
            <li class="mb-2 text-lg"><a href="./faq.php" class="hover:text-teal-400 transition">Faq</a></li>
          </ul>
        </div>
        <!-- Quick Links 2 -->
        <div>
          <h4 class="text-xl font-bold mb-4 text-yellow-300">Brands</h4>
          <ul>
            <li class="mb-2 text-lg"><a href="./maccosmetic.php" class="hover:text-yellow-300 transition">Mac</a></li>
            <li class="mb-2 text-lg"><a href="./loreal.php" class="hover:text-yellow-300 transition">L'Oreal</a></li>
            <li class="mb-2 text-lg"><a href="./lakme.php" class="hover:text-yellow-300 transition">Lakme</a></li>
            <li class="mb-2 text-lg"><a href="./hudabeauty.php" class="hover:text-yellow-300 transition">Hudabeauty</a></li>
            <li class="mb-2 text-lg"><a href="./maybelline.php" class="hover:text-yellow-300 transition">Maybelline</a></li>
          </ul>
        </div>
        <!-- Quick Links 3 -->
        <div>
          <h4 class="text-xl font-bold mb-4 text-purple-300">Explore</h4>
          <ul>
            <li class="mb-2 text-lg"><a href="./top_rated.php" class="hover:text-purple-300 transition">Top-rated</a></li>
            <li class="mb-2 text-lg"><a href="./new_arrivals.php" class="hover:text-purple-300 transition">New-Arrivals</a></li>
            <li class="mb-2 text-lg"><a href="./login.php" class="hover:text-purple-300 transition">Login</a></li>
            <li class="mb-2 text-lg"><a href="./signup.php" class="hover:text-purple-300 transition">Register</a></li>
          </ul>
        </div>
        <!-- Newsletter -->
        <div>
          <div class="bg-slate-800 rounded-2xl shadow-lg p-6">
            <h4 class="text-2xl font-bold mb-4 text-teal-300">Subscribe to Our Newsletter</h4>
            <p class="text-lg mb-4 text-gray-300">Stay updated with the latest offers and products.</p>
            <form id="newsletterForm" class="flex">
              <input type="email" id="email" placeholder="Enter your email" class="text-lg w-full p-2 border-0 rounded-l-md focus:ring-2 focus:ring-teal-400 focus:outline-none bg-slate-700 text-white placeholder-gray-400" required>
              <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-r-md hover:bg-teal-600 focus:ring-2 focus:ring-teal-400 text-lg font-bold transition">Subscribe</button>
            </form>
            <p id="newsletterMessage" class="text-lg mt-2"></p>
          </div>
          <!-- Social Media Icons -->
          <div class="flex space-x-4 mt-6 justify-center">
            <a href="#" class="text-gray-400 hover:text-teal-400 text-2xl transition"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-gray-400 hover:text-pink-400 text-2xl transition"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-gray-400 hover:text-blue-400 text-2xl transition"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-gray-400 hover:text-red-400 text-2xl transition"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
      </div>
      <!-- Bottom section -->
      <div class="mt-12 border-t border-slate-700 pt-6 flex flex-col md:flex-row justify-center items-center text-sm bg-slate-900 bg-opacity-80 rounded-b-2xl px-4 py-4 shadow-inner">
        <p class="text-gray-400 text-lg flex items-center w-full justify-center text-center">
          &copy; 2025 Blissful Beauty Cosmetic Brand. All rights reserved.
        </p>
      </div>
      <!-- Swiper JS -->
      <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
      <!-- simple js link  -->
      <script src="../js/script.js"></script>
      <script>
        // review swiper
        var swiper = new Swiper(".review-Swiper", {
          effect: "coverflow",
          grabCursor: true,
          centeredSlides: true,
          slidesPerView: "3",
          coverflowEffect: {
            rotate: 10,
            stretch: -20,
            depth: 200,
            modifier: 2,
            slideShadows: true,
          },
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
          loop: true,
        });
      </script>
      <!-- Home slider -->
      <script>
        var swiper = new Swiper(".home-slider", {
          spaceBetween: 30,
          centeredSlides: true,
          autoplay: {
            delay: 7500,
            disableOnInteraction: false,
          },
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
          loop: true,
        });
      </script>
      <script>
        document.getElementById('newsletterForm').addEventListener('submit', function(event) {
          event.preventDefault();
          const emailInput = document.getElementById('email');
          const message = document.getElementById('newsletterMessage');
          if (emailInput.validity.valid) {
            message.innerHTML = '<span class="text-green-400 font-bold flex items-center"><i class="fas fa-check-circle mr-2"></i>Thank you for subscribing!</span>';
          } else {
            message.innerHTML = '<span class="text-red-400 font-bold flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>Please enter a valid email address.</span>';
          }
        });
      </script>
  </footer>
</body>

</html>