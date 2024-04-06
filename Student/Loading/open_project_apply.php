<?php
    require 'databaseconnect.php';
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // $p_name = $_POST['p_name'];
        // $tech = $_POST['techonlogy'];
        $projectid = $_POST['project_id'];

        // $fetch = "SELECT *FROM `projects` WHERE "
        $sql ="SELECT `id` FROM `projects` WHERE `open_project_id` = '$projectid'";
        $rel = mysqli_query($conn , $sql);

        $p_id = mysqli_fetch_assoc($rel);
        // $projectid = $conn->insert_id;

        // echo $p_id;
        $sql2 = "INSERT INTO `members` (`project_id`, `member_id`,`Designation`) VALUES ('".$p_id['id']."', '".$_SESSION['collage_id']."','Leader')";
        $rel2 = mysqli_query($conn , $sql2);
    }
?>