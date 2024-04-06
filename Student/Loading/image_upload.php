<?php
require 'databaseconnect.php';
session_start();

if (isset($_FILES['imageFile'])) {
    $file_name = $_FILES['imageFile']['name'];
    $file_path = $_FILES['imageFile']['tmp_name'];
    $file_size = $_FILES['imageFile']['size'];
    $error = $_FILES['imageFile']['error'];
    $type = $_POST['type'];
    $imageData = file_get_contents($file_path);

    if ($error == 0) {
        if ($file_size > 300000) {
            $msg = "Sorry! Your file is too large.";
            echo $msg;
        } else {
            $image_extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $image_extension = strtolower($image_extension);
            $allowed_extensions = array("jpg", "jpeg", "png");

            if (in_array($image_extension, $allowed_extensions)) {
                $new_file_name = uniqid('IMG-', true) . '.' . $image_extension;

                // Using prepared statement to insert the image data
                $insert_photo = "INSERT INTO `image` (`name`, `image_data`,`type`, `Group_id` ,`Collage_id`) VALUES (?, ?, ? ,? , ?)";
                $stmt = $conn->prepare($insert_photo);
                $stmt->bind_param("sssss", $new_file_name, $imageData,$type,$_SESSION['group'],$_SESSION['collage_id']);
                
                if ($stmt->execute()) {
                    $msg = "Image uploaded.";
                    echo $msg;
                } else {
                    $msg = "Error: Unable to insert data.";
                    echo $msg;
                }
                $stmt->close();
            } else {
                $msg = "Add an appropriate file (jpg, jpeg, png).";
                echo $msg;
            }
        }
    }
} else {
    $msg = "Can't upload file. Try again!";
    echo $msg;
}
?>
