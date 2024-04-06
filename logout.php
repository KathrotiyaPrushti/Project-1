<?php
    session_start();
    session_unset();
    session_destroy();
    echo header("location:index.php");
    exit;
    // echo "You have been logged out";
?>
