<?php
require_once('../../dbconnection/connection.php');

$P_Name = $_POST['P_Name'];
$P_Description = $_POST['P_Description'];
$P_Price = $_POST['P_Price'];
$P_Category = $_POST['P_Category'];
$P_Product = $_POST['P_Product'];

// Combine filters into a comma-separated string (like "Swiper,Top-rated")
$filter_name = '';
if (isset($_POST['filters'])) {
    $filter_name = implode(',', $_POST['filters']);
}

// Handle image upload
$upload_file_name = "default-image.jpg";  // Fallback image

if (!empty($_FILES['P_Image']['name'])) {
    $file_name = $_FILES['P_Image']['name'];
    $f_name = date('ymdhis');
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $new_file_name = $f_name . '.' . $ext;
    $source = $_FILES['P_Image']['tmp_name'];
    $destination = "uploads/" . $new_file_name;

    if (move_uploaded_file($source, $destination)) {
        $upload_file_name = $new_file_name;  // Use uploaded image if successful
    }
}

// Insert product into database
$insert = "INSERT INTO product (P_Name, P_Category, P_Price, P_Description, P_Product, filter_name) 
           VALUES ('$P_Name', '$P_Category', '$P_Price', '$P_Description', '$P_Product', '$filter_name')";

if (mysqli_query($conn, $insert)) {
    echo "<script>
            alert('Product inserted successfully!');
            window.location.href = 'add_products_form.php';
          </script>";
} else {
    echo "<script>
            alert('Error inserting product: " . mysqli_error($conn) . "');
          </script>";
}
?>
