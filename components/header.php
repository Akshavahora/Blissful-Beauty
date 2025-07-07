<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blissful Beauty Cosmetics</title>
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    .swiper {
      width: 100%;
      padding-top: 50px;
      padding-bottom: 50px;
    }

    .swiper-slide img {
      display: block;
      width: 100%;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .fade-in {
      animation: fadeIn .5s ease-in;
    }

    .user-btn:hover+#userDropdownMenu,
    #userDropdownMenu.show {
      display: block;
    }

    #userDropdownMenu {
      display: none;
    }
  </style>
</head>

<body class="fade-in">
  <!-- Header -->
  <header class="flex justify-between items-center p-4 bg-white shadow-md sticky top-0 z-50 border-b border-teal-100">
    <a href="./index.php" class="flex items-center space-x-2">
      <img src="../Images/B.png" class="logo drop-shadow-md" alt="Logo" style="height: 56px;">
      <!-- Optional: <span class="font-extrabold text-2xl text-teal-700 tracking-widest ml-2">Blissful Beauty</span> -->
    </a>

    <nav class="navbar space-x-4">
      <a href="index.php" class="uppercase font-bold tracking-wide text-black hover:text-teal-700 border-b-2 border-transparent hover:border-teal-600 transition-all duration-200">home</a>
      <a href="Shop.php" class="uppercase font-bold tracking-wide text-black hover:text-teal-700 border-b-2 border-transparent hover:border-teal-600 transition-all duration-200">Shop</a>
      <a href="aboutus.php" class="uppercase font-bold tracking-wide text-black hover:text-teal-700 border-b-2 border-transparent hover:border-teal-600 transition-all duration-200">about us</a>
      <a href="contactus.php" class="uppercase font-bold tracking-wide text-black hover:text-teal-700 border-b-2 border-transparent hover:border-teal-600 transition-all duration-200">contact us</a>
    </nav>

    <div class="icons flex items-center space-x-2">
      <i class="fas fa-bars text-xl p-3 bg-gray-200 rounded-full cursor-pointer hover:bg-teal-100 transition-all duration-200 md:hidden" id="menu-bars"></i>

      <!-- Search box -->
      <div class="relative w-96">
        <input type="text" id="searchBox" placeholder="Search product..."
          class="border border-gray-300 rounded-md px-4 py-2 w-full text-lg focus:outline-none focus:ring-2 focus:ring-[var(--teal)]"
          autocomplete="off">
      </div>
      <!-- Search Results Container -->
      <div id="searchResultsContainer" class="fixed inset-0 bg-white z-50" style="display: none; margin-top: 80px;">
        <div id="mainSearchResults" class="h-full overflow-y-auto"></div>
      </div>


      <a href="./whishlist.php" class="fas fa-heart text-xl p-3 bg-gray-200 rounded-full hover:bg-teal-100 hover:text-teal-700 transition-all duration-200"></a>

      <div class="relative">
        <a href="#" class="fas fa-user user-btn text-xl p-3 bg-gray-200 rounded-full hover:bg-teal-100 hover:text-teal-700 transition-all duration-200" id="userDropdown"></a>
        <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg">
          <?php
          if (isset($_SESSION['Id'])) {
            echo "<a href='log_out.php' class='block px-4 py-2'>Logout</a>";
          } else {
            echo "<a href='login.php' class='block px-4 py-2'>Login</a>";
          }
          ?>
        </div>
      </div>

      <div class="cart relative">
        <a href="./addtocart.php" class="fas fa-shopping-cart text-xl p-3 bg-gray-200 rounded-full relative hover:bg-teal-100 hover:text-teal-700 transition-all duration-200">
          <span class="cart-count absolute -top-2 -right-2 bg-teal-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">0</span>
        </a>
      </div>
    </div>
  </header>

  <?php echo $content; ?>

  <!-- Dropdown toggle -->
  <script>
    document.getElementById('userDropdown').addEventListener('click', function(event) {
      event.preventDefault();
      document.getElementById('userDropdownMenu').classList.toggle('show');
    });

    window.onclick = function(event) {
      if (!event.target.matches('#userDropdown')) {
        const dropdown = document.getElementById('userDropdownMenu');
        if (dropdown.classList.contains('show')) {
          dropdown.classList.remove('show');
        }
      }
    };
  </script>

  <!-- search script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const searchBox = document.getElementById('searchBox');
      const searchResultsContainer = document.getElementById('searchResultsContainer');
      const mainContent = document.querySelector('main');
      let searchTimeout;

      // Function to close search results
      function closeSearchResults() {
        searchResultsContainer.style.display = 'none';
        if (mainContent) {
          mainContent.style.display = 'block';
        }
        document.body.style.overflow = 'auto';
      }

      // Function to perform search
      function performSearch(query) {
        if (query.length < 2) {
          closeSearchResults();
          return;
        }

        fetch(`search.php?query=${encodeURIComponent(query)}`)
          .then(response => response.text())
          .then(html => {
            if (mainContent) {
              mainContent.style.display = 'none';
            }
            document.body.style.overflow = 'hidden';
            document.getElementById('mainSearchResults').innerHTML = html;
            searchResultsContainer.style.display = 'block';
          })
          .catch(error => {
            console.error('Search error:', error);
            closeSearchResults();
          });
      }

      // Search box input handler
      searchBox.addEventListener('keyup', function(e) {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        searchTimeout = setTimeout(() => {
          performSearch(query);
        }, 300);
      });

      // Close search results when clicking outside
      document.addEventListener('click', function(e) {
        if (!searchBox.contains(e.target) && !searchResultsContainer.contains(e.target)) {
          closeSearchResults();
        }
      });

      // Make closeSearchResults function globally available
      window.closeSearchResults = closeSearchResults;
    });
  </script>
</body>

</html>