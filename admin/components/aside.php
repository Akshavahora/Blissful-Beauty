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
        body {
            background: linear-gradient(120deg, #f0fdfa 0%, #e0f2f1 100%);
            min-height: 100vh;
        }

        .glass-sidebar {
            background: rgba(17, 24, 39, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-right: 2px solid #14b8a6;
            box-shadow: 4px 0 32px 0 rgba(20, 184, 166, 0.10);
            border-radius: 0 2rem 2rem 0;
            animation: fade-in 1s;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 0 2px 16px 0 rgba(20, 184, 166, 0.10);
            border-radius: 0 0 1.5rem 1.5rem;
            animation: fade-in 1.2s;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            border-radius: 0.75rem;
            font-weight: 500;
            color: #fff;
            transition: background 0.2s, box-shadow 0.2s, color 0.2s;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: #14b8a6;
            color: #fff;
            box-shadow: 0 2px 12px #14b8a6aa;
        }

        .sidebar-icon {
            font-size: 1.2rem;
            color: #14b8a6;
        }

        .sidebar-section-title {
            color: #a7f3d0;
            font-size: 0.95rem;
            font-weight: 700;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            letter-spacing: 0.05em;
        }

        .sidebar-dropdown {
            transition: max-height 0.3s ease;
            overflow: hidden;
        }

        .sidebar-dropdown.open {
            max-height: 500px;
        }

        .sidebar-dropdown.closed {
            max-height: 0;
        }

        .fade-in {
            animation: fade-in 1s;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script>
        // Toggle dropdown visibility
        function toggleDropdown(id) {
            const el = document.getElementById(id);
            el.classList.toggle('open');
            el.classList.toggle('closed');
        }

        // Toggle sidebar visibility on small screens
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("-translate-x-full");
        }
    </script>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div id="sidebar" class="glass-sidebar w-64 text-white p-5 space-y-6 fixed top-0 left-0 h-screen transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-2xl font-bold tracking-wide text-teal-200">Blissfil Beauty</span>
            </div>
            <nav>
                <div class="sidebar-section-title">PRODUCTS</div>
                <button class="sidebar-link w-full text-left" onclick="toggleDropdown('productsDropdown')">
                    <i class="fas fa-box sidebar-icon"></i> Product Management <i class="fas fa-chevron-down ml-auto"></i>
                </button>
                <div id="productsDropdown" class="sidebar-dropdown closed ml-4">
                    <a href="./add_products_form.php" class="sidebar-link"><i class="fas fa-plus sidebar-icon"></i> Add Product</a>
                    <a href="./manage_products.php" class="sidebar-link"><i class="fas fa-cogs sidebar-icon"></i> Manage Products</a>
                </div>
                <div class="sidebar-section-title">SHADES</div>
                <button class="sidebar-link w-full text-left" onclick="toggleDropdown('ShadesDropdown')">
                    <i class="fas fa-palette sidebar-icon"></i> Shade Management <i class="fas fa-chevron-down ml-auto"></i>
                </button>
                <div id="ShadesDropdown" class="sidebar-dropdown closed ml-4">
                    <a href="./add_shades.php" class="sidebar-link"><i class="fas fa-plus sidebar-icon"></i> Add Shades</a>
                    <a href="./manage_shades.php" class="sidebar-link"><i class="fas fa-cogs sidebar-icon"></i> Manage Shades</a>
                </div>
                <div class="sidebar-section-title">ORDERS</div>
                <a href="./view_order.php" class="sidebar-link"><i class="fas fa-shopping-cart sidebar-icon"></i> View Order</a>
                <div class="sidebar-section-title">USERS</div>
                <a href="view_user.php" class="sidebar-link"><i class="fas fa-users sidebar-icon"></i> User Management</a>
                <!-- <div class="sidebar-section-title">STOCK</div>
                <button class="sidebar-link w-full text-left" onclick="toggleDropdown('categoryDropdown')">
                    <i class="fas fa-warehouse sidebar-icon"></i> Stock <i class="fas fa-chevron-down ml-auto"></i>
                </button>
                <div id="categoryDropdown" class="sidebar-dropdown closed ml-4">
                    <a href="./add_stock.php" class="sidebar-link"><i class="fas fa-plus sidebar-icon"></i> Add Stock</a>
                    <a href="./view_stock.php" class="sidebar-link"><i class="fas fa-cogs sidebar-icon"></i> Manage Stock</a>
                </div> -->
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col md:ml-64">
            <!-- Header -->
            <header class="glass-header bg-white shadow p-4 flex justify-between items-center fade-in">
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