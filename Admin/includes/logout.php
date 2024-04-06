<?php
session_start(); // Start or resume the session

// Expire the session
session_destroy();

// Redirect the user to a login page or any other desired page
header("Location: ../../index.php");
exit();
?>
