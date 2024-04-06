<?php
    require 'databaseconnect.php';
    session_start();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<!-- <script src="Js/Report_data.js"></script> -->
 <style>
    .edit-button button {
    background: none;
    border: none;
    cursor: pointer;
    }
        .weeklycontainer{
            /* position: absolute;
            left: 50%;
            transform: translate(-50%, -50%); */
            display: block;
            background: #f0f0f0;
            width: 95%;
            margin: 2%;
            /* margin-right:50px; */
            margin-bottom: 7px;
            height: auto;
            border-radius: 10px;
            /* box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 12px 40px 0 rgba(0, 0, 0, 0.19); */
            padding: 10px 20px;
            word-wrap: break-word;
        }
        body {
            /* overflow:hidden; */
            margin-top: 10px;
            margin-bottom:20px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .guide{
            /* background-color: #B0DAFF; */
            color: black;
            border-radius: 10px;
            /* padding: 1px; */
            margin: 5px;
            width: 220px;
            height: auto;
            text-align: center;
            /* display: block; */
            /* position: unset; */
            bottom: 0;
            right: 0;
            margin-left: 75%;
        }

        .status{
            color: black;
            border-radius: 10px;
            /* padding: 1px; */
            margin: 5px;
            width: 220px;
            height: auto;
            text-align: center;
            /* display: block; */
            /* position: unset; */
            bottom: 0;
            right: 0;
            margin-left: 75%;
        }

        
    </style>
    
    
    <?php
        $report = "SELECT * FROM `weekly` WHERE `project_id` = '".$_SESSION['group']."'";
        $res1 = mysqli_query($conn , $report);
        
        while($obj = mysqli_fetch_assoc($res1)){
            ?>
            <div class="weeklycontainer">
                <h3>Work done:</h3>
                <p class="work_done"><?php echo $obj['this_week']  ?></p>

                <h3>Individual Work</h3>
                <?php
                    $individual = "SELECT * from `indevidual` WHERE `week_id` = '".$obj['id']."'";
                    $res2 = mysqli_query($conn , $individual);

                    while ($obj2 = mysqli_fetch_assoc($res2)) {
                        $name = " SELECT * from `student` WHERE `Collage_id` = '".$obj2['user_id']."'";
                        $res3 = mysqli_query($conn , $name);

                        $obj3 = mysqli_fetch_assoc($res3);
                        ?>
                        <span><p><?php echo $obj3['Collage_id']?> <?php echo $obj3['First_name']?>   :   </p></span>
                        <p class="individual" id="<?php echo $obj3['Collage_id']?>" ><?php echo $obj2['work']?></p>
                        <?php
                    }
                ?>
        
                <h3>Future Work</h3>
                <p class="next_week"><?php echo $obj['next_week']?></p>

                <h3>Marks</h3>
                <p class="next_week"><?php echo $obj['marks']?>/10</p>

                <div class="status">
                    <h4>
                        <?php 
                            if($obj['status'] == '1'){
                                echo "Approved";
                            }
                            else if($obj['status'] == '2'){
                                echo "Rejected";
                            }
                            else{
                                echo "Pending";
                            }
                        ?>
                    </h4>
                </div>   
                <?php
                        if($obj['status'] ==0 or $obj['status'] ==2)
                        {
                    ?>
                    <div class="edit-button">
                        <button onclick="editWeekly(event,this ,<?php echo $obj['id']?>)" id=""><i class="fas fa-edit" ></i></button>
                    </div>
                    <?php
                        }
                    ?>
            </div>

            <?php
        }
    ?>