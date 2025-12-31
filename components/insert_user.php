<?php

require_once("../dbconnection/connection.php");
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Phone = $_POST['Phone'];
    $Address = $_POST['Address'];
    $Password = $_POST['Password'];

    // Prepare and bind
    $insert = "INSERT INTO registration (Name,Email,Phone,Address,Password) VALUES ('$Name', '$Email', '$Phone', '$Address', '$Password')";
    
    $select = "SELECT * FROM registration Where Email = '$Email'";
    $query = mysqli_query($conn, $select);
    if (mysqli_num_rows($query) > 0) {
        echo "<script>alert('User already exist!');
        window.location.href = 'signup.php';
        </script>";
    }
    else {
        mysqli_query($conn, $insert);
        echo "<script>
            alert('User register successfully!');
            window.location.href = 'login.php';
            </script>";
    }
?>