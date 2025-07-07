// Menu Toggle
let menu = document.querySelector('#menu-bars');
let navbar = document.querySelector('.navbar');


let valueDisplays = document.querySelectorAll(".num");
let interval = 4000;
valueDisplays.forEach((valueDisplay) => {
  let startValue = 0;
  let endValue = parseInt(valueDisplay.getAttribute("data-val"));
  let duration = Math.floor(interval / endValue);
  let counter = setInterval(function () {
    startValue += 1;
    valueDisplay.textContent = startValue;
    if (startValue == endValue) {
      clearInterval(counter);
    }
  }, duration);
});


menu.onclick = () => {
    console.log('Hamburger clicked');
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
};

// Remove active class on scroll or click outside
window.onscroll = () => {
    menu.classList.remove('fa-times');
    navbar.classList.remove('active');
};

document.addEventListener('click', function(event) {
    if (!menu.contains(event.target) && !navbar.contains(event.target)) {
        menu.classList.remove('fa-times');
        navbar.classList.remove('active');
    }
});

// Cart Alerts
document.getElementById("addToCartBtn").addEventListener("click", function () {
    alert("Product added to cart!");
});

document.getElementById("buyNowBtn").addEventListener("click", function () {
    alert("Proceeding to checkout!");
});

// User Dropdown Toggle
document.getElementById('userDropdown').addEventListener('click', function(event) {
    event.preventDefault();
    const dropdownMenu = document.getElementById('userDropdownMenu');
    dropdownMenu.classList.toggle('hidden');
});

// Close the dropdown if clicking outside of it
document.addEventListener('click', function(event) {
    const dropdownMenu = document.getElementById('userDropdownMenu');
    const userDropdown = document.getElementById('userDropdown');
    if (!userDropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
        dropdownMenu.classList.add('hidden');
    }
});


function toggleFAQ(element) {
    const answer = element.nextElementSibling;
    const button = element.querySelector(".toggle-btn");
  
    // Toggle visibility
    if (answer.classList.contains("hidden")) {
      answer.classList.remove("hidden");
      button.textContent = "-";
    } else {
      answer.classList.add("hidden");
      button.textContent = "+";
    }
  }