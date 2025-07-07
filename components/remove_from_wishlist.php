<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['productId'];

    if (isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = array_filter($_SESSION['wishlist'], function($item) use ($productId) {
            return $item['id'] != $productId;
        });

        // Reindex the array
        $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Wishlist not found in session']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
