<?php
require_once('../../dbconnection/connection.php');
header('Content-Type: application/json');
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$shades = [];
if ($product_id > 0) {
    $result = mysqli_query($conn, "SELECT id, shade FROM product_shades WHERE product_id = $product_id");
    while ($row = mysqli_fetch_assoc($result)) {
        $shades[] = $row;
    }
}
echo json_encode($shades);
