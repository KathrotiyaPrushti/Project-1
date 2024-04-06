<?php
    require 'databaseconnect.php';
    session_start();
    if($_SERVER['REQUEST_METHOD']=="POST")
    {   $user = $_SESSION['collage_id'];
        $title=$_POST['title'];
        $desc=$_POST['description'];
        // $index=$_POST['index'];
        $g_id = $_SESSION['group'];
        $sql = "INSERT INTO `daily`(`Collage_id`,`Title`,`Description`,`Group_id`) VALUES('$user','$title','$desc','$g_id')";
        $res=mysqli_query($conn,$sql);
    };
    // echo $desc;
    mysqli_close($conn);
?>