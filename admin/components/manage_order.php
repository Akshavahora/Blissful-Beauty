<?php
session_start();
require_once('../../dbconnection/connection.php');

$order = null;
$order_items = [];
if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    $stmt = $conn->prepare("SELECT * FROM `order` WHERE `Id` = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    // Fetch order items with product and shade info
    $sql = "SELECT oi.*, p.P_Name, ps.shade, ps.image_1
            FROM order_item oi
            LEFT JOIN product p ON oi.Product_Id = p.P_Id
            LEFT JOIN product_shades ps ON ps.product_id = p.P_Id
            WHERE oi.Order_Id = ?
            GROUP BY oi.id";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param('i', $order_id);
    $stmt2->execute();
    $order_items = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt2->close();
}
?>

<?php
include('./aside.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1.5px solid rgba(20, 184, 166, 0.15);
            box-shadow: 0 8px 32px 0 rgba(20, 184, 166, 0.10);
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

        .order-label {
            font-weight: 600;
            color: #0f766e;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full flex items-center justify-center min-h-screen">
        <div class="glass w-full max-w-3xl mx-auto p-4 sm:p-10 rounded-3xl shadow-2xl fade-in">
            <h1 class="text-4xl font-extrabold text-center text-teal-700 mb-4 tracking-wide flex items-center justify-center gap-2">
                <i class="fas fa-receipt"></i> Manage Orders
            </h1>
            <hr class="border-t-2 border-teal-400 w-32 mx-auto mb-8">
            <?php if ($order): ?>
                <!-- Product(s) Ordered -->
                <?php if (!empty($order_items)): ?>
                    <?php var_dump($order_items); ?>
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-teal-700 mb-2 flex items-center gap-2"><i class="fas fa-box"></i> Ordered Product(s)</h2>
                        <div class="flex flex-col gap-4">
                            <?php foreach ($order_items as $item): ?>
                                <div class="flex flex-col sm:flex-row items-center gap-4 bg-white/80 rounded-xl shadow p-4">
                                    <img src="../components/uploads/<?php echo htmlspecialchars($item['image_1']); ?>" alt="Product Image" class="w-24 h-24 rounded-lg border-2 border-teal-200 object-cover">
                                    <div class="flex-1">
                                        <div class="font-bold text-teal-700 text-lg mb-1"><?php echo htmlspecialchars($item['P_Name']); ?></div>
                                        <div><span class="font-semibold text-gray-700">Product Id:</span> <?php echo htmlspecialchars($item['Product_Id']); ?></div>
                                        <div class="mb-1"><span class="font-semibold text-gray-700">Qty:</span> <?php echo htmlspecialchars($item['Qty']); ?></div>
                                        <div class="mb-1 flex items-center gap-2">
                                            <span class="font-semibold text-gray-700">Shade:</span>
                                            <?php if ($item['shade']): ?>
                                                <span class="inline-block w-6 h-6 rounded-full border border-gray-300 align-middle" style="background: <?php echo htmlspecialchars($item['shade']); ?>;"></span>
                                                <span class="text-xs text-gray-500"><?php echo htmlspecialchars($item['shade']); ?></span>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-400">N/A</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Desktop Table -->
                <div class="hidden md:block w-full overflow-x-auto">
                    <table class="w-full min-w-[600px]">
                        <thead class="bg-teal-100 font-semibold text-teal-800 text-lg">
                            <tr>
                                <th class="px-2 py-2 md:px-6 md:py-4 text-left text-xs md:text-lg">Total Amount</th>
                                <th class="px-2 py-2 md:px-6 md:py-4 text-left text-xs md:text-lg">Payment Method</th>
                                <th class="px-2 py-2 md:px-6 md:py-4 text-left text-xs md:text-lg">Status</th>
                                <th class="px-2 py-2 md:px-6 md:py-4 text-left text-xs md:text-lg">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white/60 hover:bg-teal-50 transition-all duration-150 text-xs md:text-lg">
                                <td class="px-2 py-2 md:px-6 md:py-4 font-semibold text-gray-800">₹<?php echo number_format($order['Total_Price'], 2); ?></td>
                                <td class="px-2 py-2 md:px-6 md:py-4 text-blue-600 break-all"> <?php echo htmlspecialchars($order['Payment_Id']); ?> </td>
                                <td class="px-2 py-2 md:px-6 md:py-4">
                                    <span class="inline-flex items-center gap-1 px-4 py-2 rounded-full text-white font-bold text-xs md:text-base
                                        <?php echo strtolower($order['Status']) === 'pending' ? 'bg-yellow-500' : (strtolower($order['Status']) === 'completed' ? 'bg-teal-600' : 'bg-red-500'); ?>">
                                        <i class="fas fa-circle"></i> <?php echo htmlspecialchars(ucfirst($order['Status'])); ?>
                                    </span>
                                </td>
                                <td class="px-2 py-2 md:px-6 md:py-4 text-gray-700 whitespace-nowrap"> <?php echo htmlspecialchars($order['Created_Date']); ?> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Mobile Card -->
                <div class="block md:hidden w-full">
                    <div class="bg-white/80 rounded-xl shadow p-4 flex flex-col gap-3">
                        <div class="flex justify-between"><span class="font-bold text-teal-700">Total Amount:</span> <span>₹<?php echo number_format($order['Total_Price'], 2); ?></span></div>
                        <div class="flex justify-between"><span class="font-bold text-teal-700">Payment Method:</span> <span class="text-blue-600 break-all"><?php echo htmlspecialchars($order['Payment_Id']); ?></span></div>
                        <div class="flex justify-between"><span class="font-bold text-teal-700">Status:</span> <span><span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-white font-bold text-xs
                                        <?php echo strtolower($order['Status']) === 'pending' ? 'bg-yellow-500' : (strtolower($order['Status']) === 'completed' ? 'bg-teal-600' : 'bg-red-500'); ?>">
                                    <i class="fas fa-circle"></i> <?php echo htmlspecialchars(ucfirst($order['Status'])); ?>
                                </span></span></div>
                        <div class="flex justify-between"><span class="font-bold text-teal-700">Created At:</span> <span><?php echo htmlspecialchars($order['Created_Date']); ?></span></div>
                        <div class="flex justify-center mt-4">
                            <a href="view_order.php" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded-xl text-base font-semibold shadow hover:bg-teal-700 transition-all duration-150 hover:scale-105">
                                <i class="fas fa-arrow-left"></i> Back to Orders
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center text-2xl text-gray-500 py-20">
                    <i class="fas fa-info-circle text-5xl text-teal-400 mb-6"></i><br>
                    No order selected.<br>
                    <a href="view_order.php" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-teal-600 text-white rounded-xl text-lg font-semibold shadow hover:bg-teal-700 transition-all duration-150 hover:scale-105">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>