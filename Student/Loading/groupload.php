<?php
    require 'databaseconnect.php';
    session_start();
?>
<style>
    .edit-button button {
    background: none;
    border: none;
    cursor: pointer;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<?php

    $status_code = 0;
    $status = $_GET['status'];
    if($status == 'all') {$status_code = -1; }
    elseif ($status == 'pending') {$status_code = 0;}
    elseif ($status == 'approved') {$status_code = 1;}
    elseif ($status == 'rejected') {$status_code = 2;}


    $project_num = "SELECT `project_id` FROM `members` WHERE `member_id` = '".$_SESSION['collage_id']."' ";
    $total_projects = mysqli_query($conn , $project_num);

    if ($total_projects && mysqli_num_rows($total_projects) > 0){
        $project_ids = array();
        while ($row = mysqli_fetch_assoc($total_projects)) {
            $project_ids[] = $row['project_id'];
        }
        $project_ids_string = implode(',', $project_ids);

        if($status_code == -1){
            $s = "SELECT * from `projects` WHERE `id` IN (" . $project_ids_string . ") ";
            $res1 = mysqli_query($conn,$s);
        }
        else
        {
            $s = "SELECT * from `projects` WHERE `id` IN (" . $project_ids_string . ") AND `status` = '".$status_code."'";
            $res1 = mysqli_query($conn,$s);
        }
        

        $no_of_row = mysqli_num_rows($res1);
        $count = 0;
        if($no_of_row == 0){
            ?>
            <p>No projects</p>
            <?php
        }
        else{
            while($no_of_row!=$count){
                $obj = mysqli_fetch_assoc($res1);
                ?>
                <div class="Group" onclick="
                    <?php
                    if($obj['status'] == 1){
                        echo 'groupdeirectionhandler(this)';
                    }
                    ?>
                ">

                    <div class="Title_bar">
                        <div class="Group_No">
                            <h2><?php echo $obj['id'] ?></h2>
                        </div>
                        <div class="Title">
                            <h2><?php echo $obj['project_name'] ?></h2>
                        </div>
                        
                    </div>
                    <div class="Description">
                            <p><?php echo $obj['Description']?></p>
                    </div>
                    
                    <div class="Group_Member">
                    <h4>Members:</h4>
                        <ul>
                            <?php
                            $s2 = "SELECT * FROM `members` WHERE `project_id`= '".$obj['id']."'";
                            $r2=mysqli_query($conn,$s2);
                            $no_of_m = mysqli_num_rows($r2);
                            $c = 0;
                            while($no_of_m != $c)
                            {
                                $obj1 = mysqli_fetch_assoc($r2);
                                $s3 = " SELECT * from `student` WHERE `Collage_id` = '".$obj1['member_id']."'";
                                $r3 = mysqli_query($conn,$s3);
                                $obj2 = mysqli_fetch_assoc($r3);
                                ?>
                                <li class="members_list" id="<?php echo $obj2['Collage_id']?>"><?php 
                                    if($obj1['Designation'] == 'Leader')
                                    {
                                        echo $obj2['Collage_id'].' '.$obj2['First_name'].' (Leader)';
                                    }
                                    else{
                                        echo $obj2['Collage_id'].' '.$obj2['First_name'];
                                    }
                                ?></li>
                                <?php
                                $c = $c+1;
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="guide">
                        <h4>Guided By: <?php
                            $name = "SELECT * FROM `faculty` WHERE `id` = '".$obj['f_id']."'";
                            $res = mysqli_query($conn,$name);
                            $f_name =mysqli_fetch_assoc($res);
                            echo $f_name['Name'];
                            ?></h4>
                    </div>
                    <div class="status">
                        <h4><?php
                            if($obj['status']==1){
                                echo "Approved";
                            }
                            else if($obj['status']==2){
                                echo "Rejected";
                            }
                            else{
                                echo "..Pending";
                            }
                            ?></h4>
                    </div>
                    <?php
                        if($obj['status'] !=1 and $obj['status'] !=2 and isset($obj['open_project_id']) == 0 )
                        {
                    ?>
                    <div class="edit-button">
                        <button onclick="editHandler(event , this , '<?php echo $no_of_m ?>' ,'<?php echo $f_name['Name']?>' , '<?php echo $obj['Description']?>')"><i class="fas fa-edit" ></i></button>
                        <button onclick="deleteGroup(event , this )"><i class="fas fa-trash-alt"></i></button>
                    </div>
                    <?php
                        }
                    ?>
                </div>
                <?php
                $count = $count + 1;
            }
        }
    }
?>

<script>
    function groupdeirectionhandler(clickedgroup) {
        var g_id = clickedgroup.querySelector('.Group_No h2').textContent;
        // Send an AJAX request to a PHP file that sets the session value
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'Loading/assign_gid.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Once the session value is set, redirect to 'dashboored.php'
                window.location.href = 'daily_report.php';
            }
        };
        // Send the 'g_id' value as data in the AJAX request
        xhr.send('g_id=' + encodeURIComponent(g_id));
    }

    
</script>
