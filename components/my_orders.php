<?php
session_start();
require_once('../dbconnection/connection.php');

if (!isset($_SESSION['Email'])) {
    echo "<script>
        alert('User Not Logged In. Please Login');
        window.location.href = 'login.php';
    </script>";
    exit;
}

$user_Email = $_SESSION['Email'];

// Get user ID
$stmt = $conn->prepare("SELECT `id` FROM `registration` WHERE `Email` = ?");
$stmt->bind_param("s", $user_Email);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$stmt->close();

if (!$user) {
    die("User not found");
}

$user_Id = $user['id'];

// Handle cancel order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);

    // Check if order exists and belongs to user
    $stmt = $conn->prepare("SELECT Status FROM `order` WHERE Id = ? AND User_Id = ?");
    $stmt->bind_param("ii", $order_id, $user_Id);
    $stmt->execute();
    $result = $stmt->get_result();
    $orderCheck = $result->fetch_assoc();
    $stmt->close();

    if ($orderCheck && $orderCheck['Status'] !== 'Cancelled') {
        // Cancel order
        $conn->begin_transaction();
        try {
            $stmt = $conn->prepare("UPDATE `order` SET Status='Cancelled' WHERE Id=?");
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("UPDATE `payment` SET Status='Cancelled' WHERE Payment_Id=(SELECT Payment_Id FROM `order` WHERE Id=?)");
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $stmt->close();

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            echo "<script>alert('Failed to cancel order');</script>";
        }
    }
}

// Get all orders of user
$stmt = $conn->prepare("SELECT `Id`, `Address_Id`, `Payment_Id`, `Total_Price`, `Status`, `Created_Date`
                        FROM `order`
                        WHERE `User_Id` = ?
                        ORDER BY `Created_Date` DESC");
$stmt->bind_param("i", $user_Id);
$stmt->execute();
$order_result = $stmt->get_result();
$orders = $order_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-5">
<div class="max-w-4xl mx-auto bg-white p-5 rounded-lg shadow-md">
    <h1 class="text-center text-2xl font-bold mb-4">My Orders</h1>
    <p class="text-center mb-6">View and manage your orders below.</p>

    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <?php
            // Get order items for this order
            $order_items = [];
            $stmt = $conn->prepare("SELECT `Order_Id`, `Product_Id`, `Price`, `Qty` FROM `order_item` WHERE `Order_Id` = ?");
            $stmt->bind_param("i", $order['Id']);
            $stmt->execute();
            $items_result = $stmt->get_result();
            while ($item = $items_result->fetch_assoc()) {
                $order_items[] = $item;
            }
            $stmt->close();

            // Get product details and image
            foreach ($order_items as &$item) {
                $stmt = $conn->prepare("SELECT `P_Name`, `P_Price` FROM `product` WHERE `P_Id`=?");
                $stmt->bind_param("i", $item['Product_Id']);
                $stmt->execute();
                $product_result = $stmt->get_result();
                $product = $product_result->fetch_assoc();
                $stmt->close();

                if ($product) {
                    $item['Product_Name'] = $product['P_Name'];
                    $item['Product_Price'] = $product['P_Price'];
                }

                $stmt = $conn->prepare("SELECT `image_1` FROM `product_shades` WHERE `product_id`=?");
                $stmt->bind_param("i", $item['Product_Id']);
                $stmt->execute();
                $shade_result = $stmt->get_result();
                $shade = $shade_result->fetch_assoc();
                $stmt->close();

                $item['Product_Image'] = !empty($shade['image_1']) ? 'admin/components/uploads/' . $shade['image_1'] : 'assets/no-image.png';
            }
            ?>
            
            <div class="mb-6 border rounded-lg overflow-hidden shadow-sm">
                <div class="flex justify-between items-center p-4 bg-gray-50 border-b">
                    <div class="text-gray-600">Order #<?php echo htmlspecialchars($order['Id']); ?></div>
                    
                </div>

                <?php foreach ($order_items as $item): ?>
                    <div class="flex p-4 border-b items-center">
                        <a href="product.php?id=<?php echo $item['Product_Id']; ?>">
                            <img src="<?php echo htmlspecialchars($item['Product_Image']); ?>" alt="Product Image" class="w-24 h-24 object-cover rounded">
                        </a>
                        <div class="flex-1 px-4">
                            <h3 class="font-semibold"><?php echo htmlspecialchars($item['Product_Name']); ?></h3>
                            <p class="text-gray-600">Qty: <?php echo htmlspecialchars($item['Qty']); ?></p>
                        </div>
                        <div class="text-right font-bold">Rs. <?php echo htmlspecialchars($item['Product_Price'] * $item['Qty']); ?></div>
                    </div>
                <?php endforeach; ?>

                <div class="flex justify-between items-center p-4 bg-gray-50">
                    <?php if ($order['Status'] !== 'Cancelled'): ?>
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $order['Id']; ?>">
                            <button type="submit" class="text-yellow-500 hover:text-yellow-700 font-bold">CANCEL ORDER</button>
                        </form>
                    <?php else: ?>
                        <span class="text-red-500 font-semibold">Order Cancelled</span>
                    <?php endif; ?>

                    <div class="text-right">
                        <p class="text-gray-600">Payment Method: Credit Card</p>
                        <p class="font-bold">Total: Rs. <?php echo htmlspecialchars($order['Total_Price']); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="p-6 text-center text-gray-500">
            <p>No orders found.</p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
