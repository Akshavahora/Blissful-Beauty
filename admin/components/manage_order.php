<?php
session_start();
require_once('../../dbconnection/connection.php');
$content = '';

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

<?php include('./aside.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Page Content with margin for sidebar -->
    <div class="ml-64 px-10 py-10 sm:px-14 sm:py-12 bg-gradient-to-b from-teal-50 to-white min-h-screen transition-all duration-300">
        
        <!-- Main Container -->
        <div class="max-w-6xl mx-auto bg-white/70 backdrop-blur-lg border border-teal-200 shadow-2xl 
                    p-10 sm:p-12 rounded-2xl transition-transform duration-300 hover:scale-[1.02]">

            <!-- Header -->
            <h1 class="text-4xl font-extrabold text-center text-teal-700 mb-4 tracking-wide flex items-center justify-center gap-2">
                <i class="fas fa-receipt"></i> Manage Orders
            </h1>
            <hr class="border-t-2 border-teal-400 w-32 mx-auto mb-8">

            <?php if ($order): ?>
                <!-- Ordered Products Section -->
                <?php if (!empty($order_items)): ?>
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-teal-700 mb-5 flex items-center gap-2">
                            <i class="fas fa-box"></i> Ordered Product(s)
                        </h2>

                        <div class="flex flex-col gap-5">
                            <?php foreach ($order_items as $item): ?>
                                <div class="flex flex-col sm:flex-row items-center gap-6 bg-white/80 rounded-xl shadow p-6 
                                            hover:bg-teal-50 hover:scale-[1.02] transition-all duration-200">
                                    <img src="../components/uploads/<?php echo htmlspecialchars($item['image_1']); ?>" 
                                         alt="Product Image" 
                                         class="w-28 h-28 rounded-lg border-2 border-teal-200 object-cover">
                                    
                                    <div class="flex-1 text-center sm:text-left">
                                        <div class="font-bold text-teal-700 text-lg mb-2">
                                            <?php echo htmlspecialchars($item['P_Name']); ?>
                                        </div>
                                        <div class="text-gray-700">
                                            <span class="font-semibold">Product Id:</span> <?php echo htmlspecialchars($item['Product_Id']); ?>
                                        </div>
                                        <div class="mb-1 text-gray-700">
                                            <span class="font-semibold">Qty:</span> <?php echo htmlspecialchars($item['Qty']); ?>
                                        </div>
                                        <div class="flex items-center justify-center sm:justify-start gap-2">
                                            <span class="font-semibold text-gray-700">Shade:</span>
                                            <?php if ($item['shade']): ?>
                                                <span class="inline-block w-6 h-6 rounded-full border border-gray-300" 
                                                      style="background: <?php echo htmlspecialchars($item['shade']); ?>;"></span>
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
                    <table class="w-full min-w-[600px] text-center">
                        <thead class="bg-teal-100 font-semibold text-teal-800 text-lg">
                            <tr>
                                <th class="px-6 py-4">Total Amount</th>
                                <th class="px-6 py-4">Payment Method</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white/60 hover:bg-teal-50 hover:scale-[1.01] transition-all duration-200 text-lg">
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    ₹<?php echo number_format($order['Total_Price'], 2); ?>
                                </td>
                                <td class="px-6 py-4 text-blue-600 break-all">
                                    <?php echo htmlspecialchars($order['Payment_Id']); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 px-5 py-2 rounded-full text-white font-bold text-base
                                        <?php echo strtolower($order['Status']) === 'pending' ? 'bg-yellow-500' : (strtolower($order['Status']) === 'completed' ? 'bg-teal-600' : 'bg-red-500'); ?>">
                                        <i class="fas fa-circle"></i> <?php echo htmlspecialchars(ucfirst($order['Status'])); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                                    <?php echo htmlspecialchars($order['Created_Date']); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="block md:hidden w-full mt-6">
                    <div class="bg-white/80 rounded-xl shadow p-6 flex flex-col gap-3">
                        <div class="flex justify-between text-sm sm:text-base">
                            <span class="font-bold text-teal-700">Total Amount:</span> 
                            <span>₹<?php echo number_format($order['Total_Price'], 2); ?></span>
                        </div>
                        <div class="flex justify-between text-sm sm:text-base">
                            <span class="font-bold text-teal-700">Payment Method:</span> 
                            <span class="text-blue-600 break-all"><?php echo htmlspecialchars($order['Payment_Id']); ?></span>
                        </div>
                        <div class="flex justify-between text-sm sm:text-base">
                            <span class="font-bold text-teal-700">Status:</span>
                            <span>
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-white font-bold text-xs
                                    <?php echo strtolower($order['Status']) === 'pending' ? 'bg-yellow-500' : (strtolower($order['Status']) === 'completed' ? 'bg-teal-600' : 'bg-red-500'); ?>">
                                    <i class="fas fa-circle"></i> <?php echo htmlspecialchars(ucfirst($order['Status'])); ?>
                                </span>
                            </span>
                        </div>
                        <div class="flex justify-between text-sm sm:text-base">
                            <span class="font-bold text-teal-700">Created At:</span> 
                            <span><?php echo htmlspecialchars($order['Created_Date']); ?></span>
                        </div>
                        <div class="flex justify-center mt-6">
                            <a href="view_order.php" 
                               class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 text-white rounded-xl text-base font-semibold shadow hover:bg-teal-700 transition-all duration-200 hover:scale-[1.05]">
                                <i class="fas fa-arrow-left"></i> Back to Orders
                            </a>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <!-- No Order Selected -->
                <div class="text-center text-2xl text-gray-500 py-20">
                    <i class="fas fa-info-circle text-5xl text-teal-400 mb-6"></i><br>
                    No order selected.<br>
                    <a href="view_order.php" 
                       class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-teal-600 text-white rounded-xl text-lg font-semibold shadow hover:bg-teal-700 transition-all duration-200 hover:scale-[1.05]">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
