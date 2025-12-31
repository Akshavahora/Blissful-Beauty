<?php
session_start();
require_once('../dbconnection/connection.php');
$content = '';
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQ Section</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #f472b6 0%, #14b8a6 100%);
      min-height: 100vh;
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1.5px solid rgba(20, 184, 166, 0.15);
      box-shadow: 0 8px 32px 0 rgba(20, 184, 166, 0.10);
    }

    .faq-animate {
      transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
    }

    .faq-animate.closed {
      max-height: 0;
      opacity: 0;
      padding-bottom: 0 !important;
    }

    .faq-animate.open {
      max-height: 200px;
      opacity: 1;
      padding-bottom: 1rem !important;
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center py-10 px-2">
  <div class="w-full max-w-5xl mx-auto">
    <!-- Header -->
    <div class="mb-8 text-center mt-8">
      <div class="inline-block px-8 py-3 rounded-3xl shadow-xl bg-gradient-to-r from-pink-500 via-teal-400 to-black text-white font-extrabold text-3xl tracking-wide mb-2 animate-pulse">
        <i class="fas fa-question-circle mr-2"></i> Frequently Asked Questions
      </div>
      <p class="text-lg text-gray-100 mt-2">Find answers to common questions. Need more help? <a href="../components/contactus.php" class="text-teal-200 underline hover:text-pink-200 transition font-semibold">Contact Support</a></p>
    </div>

    <!-- FAQ List -->
    <div class="flex flex-col gap-5">
      <?php
      $faqs = [
        ["What are the top 5 cosmetic products featured on your website?", "Our website features the best products from MAC, Maybelline, Huda Beauty, L'Oréal, and Lakmé. Explore our detailed reviews and recommendations.", "fa-star"],
        ["Are these products suitable for sensitive skin?", "Many of the products we feature are dermatologically tested. Check the product descriptions for specific skin-type compatibility.", "fa-leaf"],
        ["Are these products available globally?", "Availability may vary depending on your location. Please check shipping options during checkout.", "fa-globe"],
        ["How do you ensure the quality of the products?", "We only source products from authorized distributors and official brand partners to ensure 100% authenticity and quality.", "fa-check-circle"],
        ["What is the average delivery time?", "Delivery usually takes 3–7 business days, depending on your location and the selected shipping method.", "fa-truck"],
        ["Are your products original and sealed?", "Yes, all products are original, factory-sealed, and come with brand authenticity assurance.", "fa-shield-alt"],
        ["Do the products have expiry dates?", "Yes, every product comes with a manufacturing and expiry date clearly mentioned on the packaging.", "fa-certificate"],
        ["What payment options are available?", "We accept all major credit/debit cards, UPI, net banking, and wallet payments like Paytm and Google Pay.", "fa-credit-card"],
        ["Do you ship to rural or remote areas?", "Yes, we partner with top courier services to ensure delivery across urban and remote pin codes in India.", "fa-map-marked-alt"],
        ["Is my personal information safe on your site?", "Absolutely. We use SSL encryption and follow best practices for data security to keep your information protected.", "fa-user-shield"],
        ["Do you support eco-friendly packaging?", "Yes, we are committed to sustainability and use recyclable and minimal packaging wherever possible.", "fa-hand-holding-heart"],
      ];

      foreach ($faqs as $index => $faq) {
        $question = ($index + 1) . ". " . $faq[0];
        $answer = $faq[1];
        $icon = $faq[2];
        echo '
      <div class="glass-card rounded-2xl shadow-lg">
        <button class="w-full flex justify-between items-center p-5 focus:outline-none faq-toggle" aria-expanded="false">
            <div class="flex items-center gap-3 text-3xl font-semibold text-teal-700 flex-grow">
              <i class="fas ' . $icon . '"></i> ' . $question . '
        </div>
            <span class="toggle-icon text-5xl text-pink-500 flex-shrink-0"><i class="fas fa-plus"></i></span>
        </button>
          <div class="answer faq-animate closed px-5 pb-0 text-gray-700">' . $answer . '</div>
        </div>';
      }
      ?>
    </div>
  </div>

  <script>
    // FAQ toggle logic
    document.querySelectorAll('.faq-toggle').forEach(btn => {
      btn.addEventListener('click', function() {
        const answer = this.nextElementSibling;
        const icon = this.querySelector('.toggle-icon i');
        const isOpen = answer.classList.contains('open');

        // Close all others
        document.querySelectorAll('.faq-animate').forEach(a => {
          a.classList.add('closed');
          a.classList.remove('open');
        });
        document.querySelectorAll('.faq-toggle .toggle-icon i').forEach(i => {
          i.classList.remove('fa-minus');
          i.classList.add('fa-plus');
        });

        // Toggle this one
        if (!isOpen) {
          answer.classList.remove('closed');
          answer.classList.add('open');
          icon.classList.remove('fa-plus');
          icon.classList.add('fa-minus');
        } else {
          answer.classList.add('closed');
          answer.classList.remove('open');
          icon.classList.remove('fa-minus');
          icon.classList.add('fa-plus');
        }
      });
    });
  </script>
</body>

</html>

<?php include("./footer.php"); ?>