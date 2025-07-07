<?php
$content = '';
include('./header.php');
?>

<body class="bg-gray-100">
    <!-- Hero Section -->
    <section class="relative h-64 flex items-center justify-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=1500&q=80');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white drop-shadow-lg mb-2 animate-fade-in">Contact Us</h1>
            <p class="text-lg text-gray-200 animate-fade-in delay-200">We would love to hear from you!</p>
        </div>
    </section>

    <!-- Contact Form & Map Section -->
    <section class="max-w-6xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-2 gap-10 animate-fade-in-up">
        <!-- Contact Form Card -->
        <div class="bg-white p-8 rounded-2xl shadow-2xl border border-gray-100 flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-teal-700 mb-4 text-center">Get in Touch</h2>
            <p class="text-center text-gray-500 mb-6">Fill out the form below and we will get back to you shortly.</p>
            <form id="contactForm" class="space-y-6">
                <div class="relative">
                    <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
                    <span class="absolute left-3 top-10 text-teal-400"><i class="fa fa-user"></i></span>
                    <input type="text" id="name" name="name" class="w-full mt-2 p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200" placeholder="Your Name" required>
                    <p id="nameError" class="text-red-500 text-sm hidden">Name is required and must be at least 3 characters.</p>
                </div>
                <div class="relative">
                    <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                    <span class="absolute left-3 top-10 text-teal-400"><i class="fa fa-envelope"></i></span>
                    <input type="email" id="email" name="email" class="w-full mt-2 p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200" placeholder="Your Email" required>
                    <p id="emailError" class="text-red-500 text-sm hidden">Please enter a valid email address.</p>
                </div>
                <div class="relative">
                    <label for="message" class="block text-gray-700 font-medium mb-1">Message</label>
                    <span class="absolute left-3 top-10 text-teal-400"><i class="fa fa-comment"></i></span>
                    <textarea id="message" name="message" rows="5" class="w-full mt-2 p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200" placeholder="Your Message" required></textarea>
                    <p id="messageError" class="text-red-500 text-sm hidden">Message must be at least 10 characters long.</p>
                </div>
                <button type="submit" class="w-full bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200 shadow-md">Send Message <i class="fa fa-paper-plane ml-2"></i></button>
            </form>
            <p id="successMessage" class="text-green-500 text-center mt-4 hidden">Thank you for contacting us! We will get back to you soon.</p>
        </div>
        <!-- Google Map Card -->
        <div class="bg-white p-6 rounded-2xl shadow-2xl border border-gray-100 flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-teal-700 mb-4 text-center">Find Us</h2>
            <div class="rounded-lg overflow-hidden border border-gray-200 shadow-md">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3769.830313194165!2d72.85875187511026!3d19.115098650744127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c9ce246611f1%3A0x3e0b82a825ccce33!2sKanakia%20Wall%20Street!5e0!3m2!1sen!2sin!4v1739591258653!5m2!1sen!2sin" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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

    <script>
        // Contact form validation and submission handler
        document.getElementById("contactForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get form elements
            const name = document.getElementById("name");
            const email = document.getElementById("email");
            const message = document.getElementById("message");

            // Get error message elements
            const nameError = document.getElementById("nameError");
            const emailError = document.getElementById("emailError");
            const messageError = document.getElementById("messageError");

            // Validation flags
            let isValid = true;

            // Validate name
            if (name.value.trim().length < 3) {
                nameError.classList.remove("hidden");
                isValid = false;
            } else {
                nameError.classList.add("hidden");
            }

            // Validate email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value.trim())) {
                emailError.classList.remove("hidden");
                isValid = false;
            } else {
                emailError.classList.add("hidden");
            }

            // Validate message
            if (message.value.trim().length < 10) {
                messageError.classList.remove("hidden");
                isValid = false;
            } else {
                messageError.classList.add("hidden");
            }

            // If all validations pass
            if (isValid) {
                // Display success message
                const successMessage = document.getElementById("successMessage");
                successMessage.classList.remove("hidden");

                // Clear form inputs
                this.reset();
            }
        });
    </script>
</body>

<?php
include('./footer.php');
?>