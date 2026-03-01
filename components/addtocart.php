<?php
session_start();
$content = '';
require_once('header.php');

if (!isset($_SESSION['Id'])) {
  echo "<script>
        localStorage.removeItem('cart');
        alert('User Not Logged In. Please Login');
        window.location.href = 'login.php';
    </script>";
}
?>

<div class="min-h-screen bg-gradient-to-br from-teal-50 to-pink-50 flex justify-center">

  <div class="w-full max-w-6xl px-4 py-10">

    <h1 class="text-4xl font-extrabold mb-10 text-center text-teal-700">
      Shopping Cart
    </h1>

    <!-- Cart Items -->
    <div id="cart" class="space-y-6"></div>

    <!-- Summary Section -->
    <div class="bg-white shadow-2xl rounded-2xl p-6 mt-12 max-w-xl mx-auto border-t-4 border-teal-400">

      <div class="text-center mb-6">
        <p class="text-2xl font-bold text-gray-700">
          Total Price:
          <span id="grand-total" class="text-teal-600">₹0.00</span>
        </p>
      </div>

      <div class="flex justify-between">
        <a href="./index.php"
          class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-300 font-semibold transition">
          <i class="fas fa-arrow-left mr-2"></i>Back
        </a>

        <a href="./checkout.php"
          class="bg-teal-500 text-white px-6 py-2 rounded-lg hover:bg-teal-600 font-bold shadow transition">
          Checkout <i class="fas fa-arrow-right ml-2"></i>
        </a>
      </div>

    </div>

  </div>
</div>

  <script>
    function loadCart() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      const cartContainer = document.getElementById('cart');
      let grandTotal = 0;
      if (cart.length === 0) {
        cartContainer.innerHTML = `
          <div class="flex flex-col items-center justify-center py-16">
            <i class="fa-solid fa-box text-6xl text-gray-300 mb-4"></i>
            <p class="text-xl text-gray-500 font-semibold mb-2">Your cart is empty.</p>
            <a href="./shop.php" class="text-teal-600 font-bold hover:underline">Go to Shop <i class="fas fa-arrow-right ml-2"></i></a>
          </div>
        `;
        return;
      }

      cartContainer.innerHTML = '';
      cart.forEach((product, index) => {
        const total = (product.price * product.quantity).toFixed(2);
        grandTotal += parseFloat(total);
        cartContainer.innerHTML += `
          <div class="flex flex-col sm:flex-row items-center bg-white shadow-xl rounded-2xl border-2 border-gray-100 p-6 transition-box-shadow duration-200 hover:shadow-lg hover:border-teal-400 hover:-translate-y-1 hover:scale-[1.01]">
            <div class="flex-shrink-0 mb-4 sm:mb-0">
              <img class="w-36 h-36 rounded-2xl shadow-lg border-2 border-teal-100 object-cover" src="${product.images[0]}" alt="${product.name}">
            </div>
            <div class="ml-72 -mr-44 sm:ml-6 flex-1 w-full">
              <h2 class="text-xl font-bold text-gray-800 mb-2">${product.name}</h2>
              <div class="flex items-center mb-2">
                <div class="group relative cursor-pointer rounded-full w-10 h-10 mr-3 border-2 border-gray-300 hover:border-teal-500 transition-colors duration-200" style="background-color: ${product.shade_color}">
                  <span class="hidden group-hover:block absolute left-1/2 top-[110%] -translate-x-1/2 bg-white text-teal-600 px-3 py-1 rounded-lg text-sm shadow-[0_2px_8px_rgba(0,0,0,0.08)] z-10 whitespace-nowrap">${product.shade_name || 'Shade'}</span>
                </div>
                <span class="text-gray-500 text-sm">Shade</span>
              </div>
            </div>
            <div class="text-center mx-2">
              <p class="text-xs text-gray-500">Price</p>
              <p class="font-bold text-teal-600 text-lg">₹${product.price}</p>
            </div>
            <div class="flex items-center mx-2">
              <button onclick="decreaseQuantity(${index})" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-l-lg hover:bg-teal-100 font-bold text-lg transition-all">-</button>
              <input id="quantity-${index}" type="number" value="${product.quantity}" class="w-12 text-center border border-gray-300 text-lg font-semibold" readonly>
              <button onclick="increaseQuantity(${index})" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-r-lg hover:bg-teal-100 font-bold text-lg transition-all">+</button>
            </div>
            <div class="mx-2 text-center">
              <p class="text-xs text-gray-500">Total</p>
              <p id="total-${index}" class="font-bold text-teal-700 text-lg">₹${total}</p>
            </div>
            <button onclick="removeItem(${index})" class="ml-2 text-red-500 hover:text-red-700 text-2xl transition-all" title="Remove"><i class="fas fa-trash"></i></button>
          </div>`;
      });
      document.getElementById('grand-total').textContent = `₹${grandTotal.toFixed(2)}`;
    }

    function increaseQuantity(index) {
      const cart = JSON.parse(localStorage.getItem('cart'));
      cart[index].quantity += 1;
      localStorage.setItem('cart', JSON.stringify(cart));
      loadCart();
    }

    function decreaseQuantity(index) {
      const cart = JSON.parse(localStorage.getItem('cart'));
      if (cart[index].quantity > 1) {
        cart[index].quantity -= 1;
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart();
      }
    }

    function removeItem(index) {
      const cart = JSON.parse(localStorage.getItem('cart'));
      cart.splice(index, 1);
      localStorage.setItem('cart', JSON.stringify(cart));
      loadCart();
    }
    document.addEventListener('DOMContentLoaded', loadCart);
  </script>

  <!-- Back to Top Button -->
  <button onclick="window.scrollTo({top: 0, behavior: 'smooth'});" id="backToTopBtn" class="fixed bottom-20 right-8 z-50 bg-teal-500 text-white p-4 rounded-full shadow-lg hover:bg-teal-600 transition-all duration-200 hidden" title="Back to Top"><i class="fas fa-arrow-up"></i></button>
  <script>
    window.addEventListener('scroll', function() {
      const btn = document.getElementById('backToTopBtn');
      if (window.scrollY > 300) {
        btn.classList.remove('hidden');
      } else {
        btn.classList.add('hidden');
      }
    });
  </script>

  <!-- Include footer page -->
  <?php include("./footer.php"); ?>

<!-- </html> -->
