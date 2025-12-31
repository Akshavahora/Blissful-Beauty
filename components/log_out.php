<?php
session_start();
session_destroy();
?>
<script>
    localStorage.removeItem('cart');
    window.location.href = "login.php";
</script>
