<?php

    require 'databaseconnect.php';
    session_start();

    $id = $_POST['id'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $notify = $_POST['notify'];
    
    $sql = "UPDATE `notifications` SET `status` = 'seen' WHERE `id` = '".$id."'";
    $obj = mysqli_query($conn,$sql);
?>

<p><?php echo $name?></p>
<p><?php echo $notify?></p>
<p><?php echo $date?></p>

