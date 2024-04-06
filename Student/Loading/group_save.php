<?php
     require 'databaseconnect.php';
     session_start();   
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
                $p_id = $_POST['p_id'];
                $projectName = $_POST['Project_name'];
                $memberCount = $_POST['Members'];
                $user  = $_SESSION['collage_id'];
                $faculty_id = $_POST['faculty_id'];
                $description = $_POST['desc'];
                if($p_id == 0)
                {
                    $sql = "INSERT INTO `projects` (`project_name`,`Description`, `member_count`,`f_id`) VALUES ('$projectName','$description', '$memberCount' , '$faculty_id')";
                
                    $rel1 = mysqli_query($conn , $sql);

                    if($rel1){
                        $projectid = $conn->insert_id;
                        
                        $sql2 = "INSERT INTO `members` (`project_id`, `member_id`,`Designation`) VALUES ('$projectid', '$user','Leader')";
                        $rel2 = mysqli_query($conn , $sql2);


                        for ($i = 1; $i < $memberCount; $i++) {
                            $fieldName = "id".($i+1);
                            $memberName = $_POST[$fieldName];
                
                            $sql3 = "INSERT INTO `members` (`project_id`, `member_id`) VALUES ('$projectid', '$memberName')";
                            $rel3 = mysqli_query($conn , $sql3);
                        }
                    }
                }
                else{
                    $sql = "UPDATE `projects` SET `project_name` = '".$projectName."' ,`Description` =  '".$description."' , `f_id` = '".$faculty_id."' WHERE `id` = '".$p_id."'";
                    $rel1 = mysqli_query($conn , $sql);

                    $sql2 = "DELETE FROM `members` WHERE `project_id` = '".$p_id."'";
                    $rel2 = mysqli_query($conn , $sql2);

                    $sql3 = "INSERT INTO `members` (`project_id`, `member_id`,`Designation`) VALUES ('".$p_id."', '$user','Leader')";
                    $rel3 = mysqli_query($conn , $sql3);

                    for ($i = 1; $i < $memberCount; $i++) {
                        $fieldName = "id".($i+1);
                        $memberName = $_POST[$fieldName];
            
                        $sql4 = "INSERT INTO `members` (`project_id`, `member_id`) VALUES ('".$p_id."', '$memberName')";
                        $rel4 = mysqli_query($conn , $sql4);
                    }
                }
            } 

        
    ?>