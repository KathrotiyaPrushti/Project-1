<?php
    require 'databaseconnect.php';
    session_start();

    $id = $_POST['id'];

    $del1 = "DELETE FROM `members` WHERE `project_id` = '".$id."'";
    $del2 = "DELETE FROM `projects` WHERE `id` = '".$id."'";

    $rel1 = mysqli_query($conn , $del1);
    $rel2 = mysqli_query($conn , $del2);
?>