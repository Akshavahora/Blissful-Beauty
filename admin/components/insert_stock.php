<?php
include("../../dbconnection/connection.php"); // Ensure this connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Validate input
    if (!empty($product_id) && is_numeric($quantity) && $quantity > 0) {
        // Insert stock entry
        $query = "INSERT INTO stock (product_id, quantity) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $product_id, $quantity);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Stock added successfully'); window.location.href='view_stock.php';</script>";
        } else {
            echo "<script>alert('Error adding stock');</script>";
        }
    } else {
        echo "<script>alert('Invalid input!');</script>";
    }
}
?>
