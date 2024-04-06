<?php
include "dbconnect.php";
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header("Location: ../../index.php");
    exit();
}

// The rest of your dashboard code goes here

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $projectId = $_POST['projectId'];
    $feedback = $_POST['feedback'];
    $currentDate = date("Y-m-d"); // Get the current date

    // Insert the form data into the notification table
    $insertQuery = "INSERT INTO notifications (notification, project_id, date) VALUES ('$feedback', '$projectId', '$currentDate')";
    $result = $mysqli->query($insertQuery);

    if ($result) {
        // Success! Display a success message or redirect to a success page
        echo "Form submitted successfully.";
    } else {
        // Failed to insert the form data
        echo "Error: " . $mysqli->error;
    }
}
?>
