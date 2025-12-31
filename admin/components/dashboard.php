<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

require_once('../../dbconnection/connection.php');
// Start building the content
ob_start(); // Start output buffering
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-[#f0fdfa] to-[#e0f2f1] min-h-screen">
    <div class="p-6">
        <div class="text-4xl md:text-5xl font-extrabold text-center text-[#0f172a] tracking-tight mb-6 mt-4">Dashboard Overview</div>
        <div class="flex justify-center mb-10">
            <div class="w-20 h-1 bg-[#14b8a6] rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="bg-white/70 backdrop-blur-lg border border-teal-200 shadow-2xl rounded-2xl flex flex-col justify-center items-center p-8 transition-transform duration-200 hover:scale-105 hover:shadow-teal-200/60">
                <i class="fas fa-box text-5xl mb-2 text-[#14b8a6] drop-shadow-lg"></i>
                <div class="text-lg font-bold text-[#0f172a] mb-1">Total Products</div>
                <div class="text-3xl font-extrabold text-[#222] tracking-wide" id="productsCount">
                    <?php
                    $sql = "SELECT COUNT(*) AS total FROM product";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo isset($row['total']) && $row['total'] ? $row['total'] : 0;
                    ?>
                </div>
            </div>
            <div class="bg-white/70 backdrop-blur-lg border border-teal-200 shadow-2xl rounded-2xl flex flex-col justify-center items-center p-8 transition-transform duration-200 hover:scale-105 hover:shadow-teal-200/60">
                <i class="fas fa-shopping-cart text-5xl mb-2 text-[#14b8a6] drop-shadow-lg"></i>
                <div class="text-lg font-bold text-[#0f172a] mb-1">Total Orders</div>
                <div class="text-3xl font-extrabold text-[#222] tracking-wide" id="ordersCount">
                    <?php
                    $sql = "SELECT COUNT(*) AS total FROM `order`";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo isset($row['total']) && $row['total'] ? $row['total'] : 0;
                    ?>
                </div>
            </div>
            <div class="bg-white/70 backdrop-blur-lg border border-teal-200 shadow-2xl rounded-2xl flex flex-col justify-center items-center p-8 transition-transform duration-200 hover:scale-105 hover:shadow-teal-200/60">
                <i class="fas fa-user text-5xl mb-2 text-[#14b8a6] drop-shadow-lg"></i>
                <div class="text-lg font-bold text-[#0f172a] mb-1">Total Users</div>
                <div class="text-3xl font-extrabold text-[#222] tracking-wide" id="usersCount">
                    <?php
                    $sql = "SELECT COUNT(*) AS total FROM registration";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo isset($row['total']) && $row['total'] ? $row['total'] : 0;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Animated counters
        function animateValue(id, start, end, duration) {
            end = isNaN(end) || end < 0 ? 0 : end;
            let range = end - start;
            let current = start;
            let increment = end > start ? 1 : -1;
            let stepTime = Math.abs(range) > 0 ? Math.abs(Math.floor(duration / range)) : duration;
            const obj = document.getElementById(id);
            if (!obj) return;
            if (range === 0) {
                obj.textContent = end;
                return;
            }
            let timer = setInterval(function() {
                current += increment;
                obj.textContent = current;
                if (current == end) {
                    clearInterval(timer);
                }
            }, stepTime);
        }
        window.onload = function() {
            animateValue('productsCount', 0, parseInt(document.getElementById('productsCount').textContent), 1000);
            animateValue('ordersCount', 0, parseInt(document.getElementById('ordersCount').textContent), 1000);
            animateValue('usersCount', 0, parseInt(document.getElementById('usersCount').textContent), 1000);
        };
    </script>

    <?php
    $content = ob_get_clean(); // Store the output in $content
    include("./aside.php");
    ?>

</body>

</html>