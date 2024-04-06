<?php
require 'databaseconnect.php';
session_start();

// Retrieve the 'g_id' value from the AJAX request
$g_id = $_POST['g_id'];

// Set the 'group' key in the session to the 'g_id' value
$_SESSION['group'] = $g_id;

?>
