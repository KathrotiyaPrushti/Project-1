<?php
require 'dbconnect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the image data from the database based on the provided 'id'
    $select_photo = "SELECT `name`, `image_data` FROM `image` WHERE `id`='$id'";
    $stmt = $connection->prepare($select_photo);
    // $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    // Check if the record exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($name, $imageData);
        $stmt->fetch();

        // Output the appropriate headers to display the image content
        header("Content-type: image/jpeg"); // Change the content type based on the image type you have stored

        // Output the binary image data directly
        echo $imageData;
    } else {
        // Image record with the provided 'id' not found
        echo "Image not found!";
    }

    $stmt->close();
} else {
    // 'id' parameter is not provided
    echo "Image ID not specified!";
}
?>
