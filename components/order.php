<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['Id'])) {
    echo "<script>
        alert('User Not Logged In. Please Login');
        window.location.href = 'login.php';
    </script>";
    exit;
}

$user_Id = $_SESSION['Id'];

// Database connection
include '../dbconnection/connection.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the latest order for the user
$stmt = $conn->prepare("SELECT `Id`, `Address_Id`, `Payment_Id`, `Total_Price`, `Status`, `Created_Date`
                        FROM `order`
                        WHERE `User_Id` = ?
                        ORDER BY `Created_Date` DESC
                        LIMIT 1");
$stmt->bind_param("i", $user_Id);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();
$stmt->close();

// Fetch order items
$order_items = [];
if ($order) {
    $stmt = $conn->prepare("SELECT `Order_Id`, `Product_Id`, `Price`, `Qty`
                            FROM `order_item`
                            WHERE `Order_Id` = ?");
    $stmt->bind_param("i", $order['Id']);
    $stmt->execute();
    $items_result = $stmt->get_result();
    while ($item = $items_result->fetch_assoc()) {
        $order_items[] = $item;
    }
    $stmt->close();

    // Fetch payment details
    $stmt = $conn->prepare("SELECT `Status` AS `Payment_Status`, `Total_Price`
                            FROM `payment`
                            WHERE `Payment_Id` = ?");
    $stmt->bind_param("s", $order['Payment_Id']);
    $stmt->execute();
    $payment_result = $stmt->get_result();
    $payment = $payment_result->fetch_assoc();
    $stmt->close();

    // Fetch address details
    $stmt = $conn->prepare("SELECT `Full_Name`, `Shipping_Address`, `City`, `Zip_Code`
                            FROM `address`
                            WHERE `address_id` = ?");
    $stmt->bind_param("i", $order['Address_Id']);
    $stmt->execute();
    $address_result = $stmt->get_result();
    $address = $address_result->fetch_assoc();
    $stmt->close();

    // Fetch product details for each order item
    foreach ($order_items as &$item) {
        $stmt = $conn->prepare("SELECT `Name`, `Price`
                                FROM `products`
                                WHERE `Product_Id` = ?");
        $stmt->bind_param("i", $item['Product_Id']);
        $stmt->execute();
        $product_result = $stmt->get_result();
        $product = $product_result->fetch_assoc();
        $stmt->close();

        if ($product) {
            $item['Product_Name'] = $product['Name'];
            $item['Product_Price'] = $product['Price'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <script src="https://cdn.tailwindcss.com/3.4.1"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="container mx-auto px-4 py-4">
                <h1 class="text-2xl font-bold text-gray-800">Order Details</h1>
            </div>
        </header>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <?php if ($order): ?>
                    <!-- Order Status Badge -->
                    <div class="bg-blue-50 p-4 border-b">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-sm text-gray-600">Order #<?php echo htmlspecialchars($order['Id']); ?></span>
                                <h2 class="text-xl font-semibold text-gray-800 mt-1">Order Placed on <?php echo date('F j, Y', strtotime($order['Created_Date'])); ?></h2>
                            </div>
                            <span class="px-4 py-2 rounded-full text-sm font-medium
                                <?php echo $order['Status'] == 'Pending' ? 'bg-yellow-100 text-yellow-800' :
                                    ($order['Status'] == 'Completed' ? 'bg-green-100 text-green-800' :
                                    'bg-blue-100 text-blue-800'); ?>">
                                <?php echo htmlspecialchars($order['Status']); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Order Information -->
                    <div class="p-6 space-y-8">
                        <!-- Order Summary -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Total Amount</h4>
                                    <p class="text-2xl font-bold text-gray-800">₹<?php echo htmlspecialchars($order['Total_Price']); ?></p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Payment Status</h4>
                                    <p class="text-lg font-medium text-green-600"><?php echo htmlspecialchars($payment['Payment_Status']); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Details -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-truck mr-2 text-blue-500"></i>
                                Shipping Details
                            </h3>
                            <div class="bg-white border rounded-lg p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Name</p>
                                        <p class="font-medium"><?php echo htmlspecialchars($address['Full_Name']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Address</p>
                                        <p class="font-medium"><?php echo htmlspecialchars($address['Shipping_Address']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">City</p>
                                        <p class="font-medium"><?php echo htmlspecialchars($address['City']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">ZIP Code</p>
                                        <p class="font-medium"><?php echo htmlspecialchars($address['Zip_Code']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-shopping-bag mr-2 text-blue-500"></i>
                                Order Items
                            </h3>
                            <?php if (!empty($order_items)): ?>
                                <div class="space-y-4">
                                    <?php foreach ($order_items as $item): ?>
                                        <div class="flex items-center bg-white border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                            <img src="path_to_product_image.jpg" alt="Product" class="w-20 h-20 rounded-lg object-cover">
                                            <div class="ml-4 flex-grow">
                                                <h4 class="font-medium text-gray-800"><?php echo htmlspecialchars($item['Product_Name']); ?></h4>
                                                <p class="text-sm text-gray-500">Quantity: <?php echo htmlspecialchars($item['Qty']); ?></p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-semibold text-gray-800">₹<?php echo htmlspecialchars($item['Product_Price']); ?></p>
                                                <p class="text-sm text-gray-500">Total: ₹<?php echo htmlspecialchars($item['Product_Price'] * $item['Qty']); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-500 text-center py-4">No items found in this order.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="p-6 text-center">
                        <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No orders found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
