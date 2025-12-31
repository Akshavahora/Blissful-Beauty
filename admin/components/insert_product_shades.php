<?php
require_once('../../dbconnection/connection.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_dropdown'];
    $shade = $_POST['shade'];

    $uploadDir = 'uploads/';  // Make sure this folder exists and is writable

    // Function to handle file upload
    function uploadImage($fileInputName) {
        global $uploadDir;
        $file = $_FILES[$fileInputName];

        if ($file['error'] === UPLOAD_ERR_OK) {
            $filename = time() . '_' . basename($file['name']);
            $targetFile = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                return $filename;  // Return the file name to store in the database
            } else {
                die("Failed to upload $fileInputName");
            }
        } else {
            die("Error uploading $fileInputName");
        }
    }

    // Upload images
    $image_1 = uploadImage('Image_1');
    $image_2 = uploadImage('Image_2');
    $image_3 = uploadImage('Image_3');
    $image_4 = uploadImage('Image_4');

    // Insert into product_2 table
    $query = "INSERT INTO product_shades (product_id, shade, image_1, image_2, image_3, image_4) 
              VALUES ('$product_id', '$shade', '$image_1', '$image_2', '$image_3', '$image_4')";

   
    if (mysqli_query($conn,$query)) {
        echo "<script>
                alert('Product shade and images inserted successfully!');
                window.location.href = 'add_shades.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
