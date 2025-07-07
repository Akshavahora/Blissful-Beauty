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
    <style>
        body {
            background: linear-gradient(120deg, #f0fdfa 0%, #e0f2f1 100%);
            min-height: 100vh;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1.5px solid rgba(20, 184, 166, 0.15);
            box-shadow: 0 8px 32px 0 rgba(20, 184, 166, 0.10);
            border-radius: 1.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
            animation: fade-in 1s;
        }

        .glass:hover {
            transform: scale(1.03);
            box-shadow: 0 12px 32px 0 #14b8a6aa;
        }

        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: 0.02em;
            text-align: center;
            margin-bottom: 1.5rem;
            margin-top: 1rem;
        }

        .dashboard-divider {
            border: none;
            border-top: 3px solid #14b8a6;
            width: 80px;
            margin: 0 auto 2rem auto;
        }

        .dashboard-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            color: #14b8a6;
            filter: drop-shadow(0 2px 8px #14b8a655);
        }

        .dashboard-label {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.25rem;
        }

        .dashboard-value {
            font-size: 2.2rem;
            font-weight: 900;
            color: #222;
            letter-spacing: 0.01em;
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

        @media (max-width: 900px) {
            .grid-cols-3 {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</head>

<body>
    <div class="p-6">
        <div class="dashboard-title fade-in">Dashboard Overview</div>
        <hr class="dashboard-divider fade-in">
        <div class="grid grid-cols-3 gap-6 mt-6">
            <div class="glass flex flex-col justify-center items-center p-8 fade-in">
                <i class="fas fa-box dashboard-icon"></i>
                <div class="dashboard-label">Total Products</div>
                <div class="dashboard-value" id="productsCount">
                    <?php
                    $sql = "SELECT COUNT(*) AS total FROM product";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['total'];
                    ?>
                </div>
            </div>
            <div class="glass flex flex-col justify-center items-center p-8 fade-in">
                <i class="fas fa-shopping-cart dashboard-icon"></i>
                <div class="dashboard-label">Total Orders</div>
                <div class="dashboard-value" id="ordersCount">
                    <?php
                    $sql = "SELECT COUNT(*) AS total FROM `order`";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['total'];
                    ?>
                </div>
            </div>
            <div class="glass flex flex-col justify-center items-center p-8 fade-in">
                <i class="fas fa-user dashboard-icon"></i>
                <div class="dashboard-label">Total Users</div>
                <div class="dashboard-value" id="usersCount">
                    <?php
                    $sql = "SELECT COUNT(*) AS total FROM registration";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['total'];
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Animated counters
        function animateValue(id, start, end, duration) {
            let range = end - start;
            let current = start;
            let increment = end > start ? 1 : -1;
            let stepTime = Math.abs(Math.floor(duration / range));
            const obj = document.getElementById(id);
            if (!obj) return;
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