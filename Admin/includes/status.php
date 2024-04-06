<?php
session_start();

// Assuming you have a MySQLi connection named $mysqli established
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$database = "project_reports";

// Create a new MySQLi instance
$mysqli = new mysqli($host, $dbUsername, $dbPassword, $database);

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or perform any other necessary action
    exit("Unauthorized access");
}

// Check if the request method is GET and required parameters are set
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['projectId']) && isset($_GET['status'])) {
    // Validate and sanitize the input values
    $projectId = $_GET['projectId'];
    $status = $_GET['status'];

    // Perform any additional validation or checks as needed

    // Update the project status in the database
    $query = "UPDATE projects SET status = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $status, $projectId);

    if ($stmt->execute()) {
        // Update successful
        $statusText = ($status == 1) ? "approved" : "rejected";
        $folderName = "../../Documents/"."group" . $projectId;
        if($status == 1){
            if (mkdir($folderName, 0755, true)) { 
                echo "Folder '$folderName' created successfully.";
            } else {
                echo "Failed to create folder '$folderName'.";
            }
        }
        // if($status == 2){
        //     if (is_dir($folderName)) {
        //         if (rmdir($folderName)) {
        //             echo "Folder '$folderName' removed successfully.";
        //         } else {
        //             echo "Failed to remove the folder '$folderName'.";
        //         }
        //     }
        // }
        $message = "Project status updated successfully. The project has been " . $statusText . ".";
        // Store the message and status in session variables
        $_SESSION['toast_message'] = $message;
        $_SESSION['toast_status'] = $status;
        // Redirect to the list_projects.php page
        header("Location: list_projects.php");
        exit();
    } else {
        // Update failed
        $message = "Failed to update project status. Please try again.";
        // Store the error message in a session variable
        $_SESSION['toast_message'] = $message;
        // Redirect to the list_projects.php page
        header("Location: list_projects.php");
        exit();
    }
} else {
    // Invalid request method or missing parameters
    $message = "Invalid request";
    // Store the error message in a session variable
    $_SESSION['toast_message'] = $message;
    // Redirect to the list_projects.php page
    header("Location: list_projects.php");
    exit();
}
?>
