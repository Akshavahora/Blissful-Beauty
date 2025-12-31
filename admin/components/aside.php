<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmetic Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js CDN link -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- fontawesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom scrollbar for sidebar */
        #sidebar::-webkit-scrollbar {
            width: 10px;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #14b8a6 60%, #0f766e 100%);
            border-radius: 8px;
        }

        #sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        /* For Firefox */
        #sidebar {
            scrollbar-width: thin;
            scrollbar-color: #14b8a6 #111827;
        }
    </style>
    <script>
        // Toggle dropdown visibility
        function toggleDropdown(id) {
            const el = document.getElementById(id);
            el.classList.toggle('max-h-0');
            el.classList.toggle('max-h-64');
        }
        // Toggle sidebar visibility on small screens
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("-translate-x-full");
        }
    </script>
</head>

<body class="bg-gradient-to-br from-[#f0fdfa] to-[#e0f2f1] min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-[#111827]/85 backdrop-blur-lg border-r-2 border-[#14b8a6] shadow-xl rounded-tr-3xl w-64 text-white p-5 space-y-6 fixed top-0 left-0 h-screen overflow-y-auto transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-2xl font-bold tracking-wide text-teal-200">Blissfil Beauty</span>
            </div>
            <nav>
                <div class="text-[#a7f3d0] text-sm font-bold mt-6 mb-2 tracking-wide">PRODUCTS</div>
                <a href="./dashboard.php" class="flex items-center gap-3 px-5 py-3 rounded-xl font-medium group transition hover:bg-[#14b8a6] hover:shadow-lg">
                    <i class="fas fa-tachometer-alt text-[#14b8a6] group-hover:text-white text-lg"></i> Dashboard
                </a>
                <button class="flex items-center gap-3 px-5 py-3 rounded-xl font-medium group w-full text-left transition hover:bg-[#14b8a6] hover:shadow-lg" onclick="toggleDropdown('productsDropdown')">
                    <i class="fas fa-box text-[#14b8a6] group-hover:text-white text-lg"></i> Product Management <i class="fas fa-chevron-down ml-auto"></i>
                </button>
                <div id="productsDropdown" class="overflow-hidden max-h-0 transition-all duration-300 flex flex-col ml-4">
                    <a href="./add_products_form.php" class="flex items-center gap-3 px-5 py-3 rounded-xl font-medium group transition hover:bg-[#14b8a6] hover:shadow-lg">
                        <i class="fas fa-plus text-[#14b8a6] group-hover:text-white text-lg"></i> Add Product
                    </a>
                    <a href="./manage_products.php" class="flex items-center gap-3 px-5 py-3 rounded-xl font-medium group transition hover:bg-[#14b8a6] hover:shadow-lg">
                        <i class="fas fa-cogs text-[#14b8a6] group-hover:text-white text-lg"></i> Manage Products
                    </a>
                </div>
                <div class="text-[#a7f3d0] text-sm font-bold mt-6 mb-2 tracking-wide">SHADES</div>
                <button class="flex items-center gap-3 px-5 py-3 rounded-xl font-medium group w-full text-left transition hover:bg-[#14b8a6] hover:shadow-lg" onclick="toggleDropdown('ShadesDropdown')">
                    <i class="fas fa-palette text-[#14b8a6] group-hover:text-white text-lg"></i> Shade Management <i class="fas fa-chevron-down ml-auto"></i>
                </button>
                <div id="ShadesDropdown" class="overflow-hidden max-h-0 transition-all duration-300 flex flex-col ml-4">
                    <a href="./add_shades.php" class="flex items-center gap-3 px-5 py-3 rounded-xl font-medium group transition hover:bg-[#14b8a6] hover:shadow-lg">
                        <i class="fas fa-plus text-[#14b8a6] group-hover:text-white text-lg"></i> Add Shades
                    </a>
                    <a href="./manage_shades.php" class="flex items-center gap-3 px-5 py-3 rounded-xl font-medium group transition hover:bg-[#14b8a6] hover:shadow-lg">
                        <i class="fas fa-cogs text-[#14b8a6] group-hover:text-white text-lg"></i> Manage Shades
                    </a>
                </div>
                <div class="text-[#a7f3d0] text-sm font-bold mt-6 mb-2 tracking-wide">ORDERS</div>
                <a href="./view_order.php" class="flex items-center gap-3 px-5 py-3 rounded-xl font-medium group transition hover:bg-[#14b8a6] hover:shadow-lg">
                    <i class="fas fa-shopping-cart text-[#14b8a6] group-hover:text-white text-lg"></i> View Order
                </a>
                <div class="text-[#a7f3d0] text-sm font-bold mt-6 mb-2 tracking-wide">USERS</div>
                <a href="view_user.php" class="flex items-center gap-3 px-5 py-3 rounded-xl font-medium group transition hover:bg-[#14b8a6] hover:shadow-lg">
                    <i class="fas fa-users text-[#14b8a6] group-hover:text-white text-lg"></i> User Management
                </a>
                <!-- STOCK MANAGEMENT -->
                <div class="text-[#a7f3d0] text-sm font-bold mt-6 mb-2 tracking-wide">STOCK</div>
                <button class="flex items-center gap-3 px-5 py-3 rounded-xl font-medium group w-full text-left transition hover:bg-[#14b8a6] hover:shadow-lg" onclick="toggleDropdown('StockDropdown')">
                    <i class="fas fa-warehouse text-[#14b8a6] group-hover:text-white text-lg"></i> Stock Management <i class="fas fa-chevron-down ml-auto"></i>
                </button>
                <div id="StockDropdown" class="overflow-hidden max-h-0 transition-all duration-300 flex flex-col ml-4">
                    <a href="./add_stock.php" class="flex items-center gap-3 px-5 py-3 rounded-xl font-medium group transition hover:bg-[#14b8a6] hover:shadow-lg">
                        <i class="fas fa-plus text-[#14b8a6] group-hover:text-white text-lg"></i> Add Stock
                    </a>
                    <a href="./view_stock.php" class="flex items-center gap-3 px-5 py-3 rounded-xl font-medium group transition hover:bg-[#14b8a6] hover:shadow-lg">
                        <i class="fas fa-eye text-[#14b8a6] group-hover:text-white text-lg"></i> View Stock
                    </a>
                </div>

            </nav>
        </div>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col md:ml-64">
            <!-- Header -->
            <header class="bg-white/85 backdrop-blur-md shadow p-4 flex justify-between items-center rounded-b-2xl mt-2 mx-2">
                <!-- Sidebar Toggle Button (Visible on small screens) -->
                <button class="md:hidden p-2 focus:outline-none" onclick="toggleSidebar()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                <!-- Logo -->
                <div class="flex items-center">
                    <span class="text-xl font-bold ml-2 text-teal-700">Blissfil Beauty Admin</span>
                </div>
                <!-- Admin Profile -->
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Aksha&background=14b8a6&color=fff&rounded=true&size=48" alt="Admin" class="h-10 w-10 rounded-full border-2 border-teal-400 shadow">
                        <span class="absolute -bottom-1 -right-1 bg-teal-500 text-white text-xs rounded-full px-2 py-0.5 font-bold shadow">Admin</span>
                    </div>
                    <span class="text-gray-700 font-semibold">Aksha</span>
                </div>
            </header>
            <!-- Dynamic Content -->
            <div class="p-4">
                <?php echo $content ?>
            </div>
        </div>
    </div>
</body>

</html>