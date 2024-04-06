<?php
    require 'databaseconnect.php';
    session_start();
    if($_SERVER['REQUEST_METHOD']=="POST")
    { 
        $work = $_POST['work'];
        $future_work = $_POST['future_work'];
        $individualWork =$_POST['individualWork'];
        $g_id = $_SESSION['group'];
        $week_id = $_POST['week_id'];
        $link = $_POST['link']; 
    
        if($week_id == 0){
            //image upload
            $sql = "INSERT INTO `weekly`(`this_week`,`project_id`,`next_week`,`drive_link`) VALUES('$work','$g_id','$future_work','$link')";
            $run = mysqli_query($conn , $sql);
            $week_id = $conn->insert_id;
        
            foreach ($individualWork as $work) {
                $memberId = $work['memberId'];
                $workDesc = $work['work'];
                
                $sql1 = "INSERT INTO `indevidual` (`user_id`, `work` , `week_id`) VALUES ('$memberId', '$workDesc' , '$week_id')";
                $run2 = mysqli_query($conn, $sql1);
              }
        }
        else{
            $sql = "UPDATE `weekly` SET `this_week` = '$work', `next_week` = '$future_work' ,'drive_link' = '$link' WHERE `id` = '$week_id' AND `status` = '0'";
            $rel = mysqli_query($conn , $sql);
            echo $week_id;

            foreach ($individualWork as $work) {
                $memberId = $work['memberId'];
                $workDesc = $work['work'];
                
                $sql1 = "UPDATE `indevidual` SET  `work`='$workDesc'  WHERE `week_id`='$week_id' AND `user_id`='$memberId'";
                $run2 = mysqli_query($conn, $sql1);
            }
        }
    }
?>