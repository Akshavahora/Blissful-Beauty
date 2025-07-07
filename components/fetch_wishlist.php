<?php
session_start();

if (isset($_SESSION['wishlist'])) {
    echo json_encode(['wishlist' => $_SESSION['wishlist']]);
} else {
    echo json_encode(['wishlist' => []]);
}
?>
