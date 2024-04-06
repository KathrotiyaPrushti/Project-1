<?php
session_start();
include_once "dbconnect.php";

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or perform any other necessary action
    header("Location: ../../index.php");
    exit("Unauthorized access");
}

// Check if the request method is GET and required parameters are set
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['weekly_id']) && isset($_GET['status']) && isset($_GET['groupId'])) {
    // Validate and sanitize the input values
    $id = $_GET['weekly_id'];
    $status = $_GET['status'];
    $groupId = $_GET['groupId'];
    $mark =$_GET['marks'];
    $input = $_GET['f_inp'];
    // Perform any additional validation or checks as needed
    
    // Update the weekly status in the database
    $query = "UPDATE weekly SET `status` = ? , `Faculty_input` =? ,`marks` =? WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("isii", $status, $input ,$mark, $id);

    if ($stmt->execute()) {
        // Update successful
        $statusText = ($status == 1) ? "approved" : "rejected";
        $message = "The weekly entry has been " . $statusText . ".";
        // Store the message and status in session variables
        $_SESSION['toast_message'] = $message;
        $_SESSION['toast_status'] = $status;
    } else {
        // Update failed
        $message = "Failed to update weekly status. Please try again.";
        // Store the error message in a session variable
        $_SESSION['toast_message'] = $message;
        $_SESSION['toast_status'] = 0;
    }
}

// Redirect to the weekly.php page with the groupId parameter
header("Location: weekly.php?groupId=" . $groupId);
exit();
?>