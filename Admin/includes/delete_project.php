<?php
// Assuming you have already established a database connection
include_once "dbconnect.php";

session_start(); // Start the session
$sessionId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["projectId"])) {
  $projectId = $_GET["projectId"];

  // Delete the project from the database
  $sql = "DELETE FROM openproject WHERE id = ? AND f_id = ?";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param("ii", $projectId, $sessionId);

  if ($stmt->execute()) {
    // Deletion successful
    $_SESSION['toast_message'] = "Project deleted successfully.";
    $_SESSION['toast_status'] = "danger";
  } else {
    // Error occurred during deletion
    $_SESSION['toast_message'] = "Error deleting project.";
    $_SESSION['toast_status'] = "warning";
    echo "SQL Error: " . $stmt->error; // Output the SQL error message
  }
  
} else {
  // Invalid request
  $_SESSION['toast_message'] = "Invalid request.";
  $_SESSION['toast_status'] = "warning";
}

header("Location: openworld.php"); // Replace "openworld.php" with the appropriate page URL
exit();
?>
