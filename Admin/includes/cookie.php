<?php

$sessionId = $_SESSION['user_id'];

// Get the button type if it is received, otherwise set it to null
$buttonType = isset($_POST['buttonType']) ? $_POST['buttonType'] : null;

// Get the user's IP address
$ipAddress = $_SERVER['REMOTE_ADDR'];

// Get the current page URL
$pageUrl = $_SERVER['REQUEST_URI'];

// Get the current date and time
$date = date("Y-m-d H:i:s");

// Store the data in the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "daily_report";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO cookies (userid ,ip_address, page_url, date, button_type) VALUES (?,?, ?, ?, ?)");

if (!$stmt) {
    die("Error in SQL statement preparation: " . $conn->error);
}

// Bind the parameters and execute the statement
$stmt->bind_param("sssss",$sessionId, $ipAddress, $pageUrl, $date, $buttonType);

if (!$stmt->execute()) {
    die("Error executing SQL statement: " . $stmt->error);
}

// Close the statement and database connection
$stmt->close();
$conn->close();

?>
