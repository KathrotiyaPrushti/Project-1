<?php
// change_password.php

session_start();
require "databaseconnect.php"; // Replace with your database connection code

if (isset($_POST['currentPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if the new password and confirm password match
    if ($newPassword === $confirmPassword) {
        // Validate the current password against the one stored in the database
        $collage_id = $_SESSION['collage_id']; // Change this to the appropriate session variable
        $sql = "SELECT Password FROM student WHERE collage_id = ?"; // Replace 'users' with your user table
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $collage_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['Password'];
            // echo $hashedPassword;
            // Verify the current password with the hashed password
            if (password_verify($currentPassword, $hashedPassword)) {
                // Hash the new password
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the user's password in the database
                $updateSql = "UPDATE student SET Password = ? WHERE collage_id = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("ss", $hashedNewPassword, $collage_id);
                $updateStmt->execute();
                $updateStmt->close();

                echo "Password changed successfully.";
            } else {
                echo "Current password is incorrect.";
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "New password and confirm password do not match.";
    }
} else {
    echo "Invalid request.";
}
?>
