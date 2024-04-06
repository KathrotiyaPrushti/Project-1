<?php
session_start();
include_once "dbconnect.php";

// Check if the form was submitted
if (isset($_POST['submit'])) {
  // Get the issue and f_id from the form
  $issue = $_POST['issue'];
  $f_id = $_POST['f_id'];

  // Check if the connection was successful
  if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Prepare the SQL statement to insert the feedback into the database
  $sql = "INSERT INTO feedback (f_id, feedback, date) VALUES ('$f_id', '$issue', CURDATE())";

  // Execute the SQL statement
  if (mysqli_query($connection, $sql)) {
    // Feedback submitted successfully
    $message = "Thank you for your feedback";
    $status = "info";

    // Set the session toast message and status
    $_SESSION['form_toast_message'] = $message;
    $_SESSION['form_toast_status'] = $status;

    // Redirect to the dashboard.php page
    header("Location: dashboard.php");
    exit();
  } else {
    // Error submitting feedback
    $message = "Error: " . $sql . "<br>" . mysqli_error($connection);
    $status = "error";

    // Set the session toast message and status
    $_SESSION['form_toast_message'] = $message;
    $_SESSION['form_toast_status'] = $status;
  }

  // Close the database connection
  mysqli_close($connection);
}
?>