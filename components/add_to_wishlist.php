<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['productId'];
    $productName = $data['productName'];
    $productPrice = $data['productPrice'];
    $productImage = $data['productImage'];
    
    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = [];
    }

    $existingProduct = null;
    foreach ($_SESSION['wishlist'] as $item) {
        if ($item['id'] == $productId) {
            $existingProduct = $item;
            break;
        }
    }

    if (!$existingProduct) {
        $_SESSION['wishlist'][] = [
            'id' => $productId,
            'name' => $productName,
            'price' => $productPrice,
            'image' => $productImage
        ];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Product already in wishlist']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
