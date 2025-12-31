<?php

session_start();
if(!isset($_SESSION['Name'])) {
    header("Location: index.php");
    exit();
}

?>