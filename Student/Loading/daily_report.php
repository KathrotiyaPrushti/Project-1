<?php
    require 'databaseconnect.php';
    session_start();
?>
<?php
            $group = $_SESSION['group'];
            $sql = "SELECT *FROM `DAILY` WHERE `Group_id` = '".$group."'";
            $res = mysqli_query($conn,$sql);
            $no_of_row = mysqli_num_rows($res);
            
            $count = 0;
            while($no_of_row!=$count){
                $obj = mysqli_fetch_assoc($res);
            ?>
        <div class="card-view" id="card">
            <span class="side-stick"></span>
            <h3 class="title"><?php echo $obj['Title']?><i class="point "></i></h3>             
            <p class="note-date"><?php echo $obj['Date']  ?></p>
            <p class="note-content text-muted" data-notecontent="<?php echo $obj['Description']?>">
                <?php echo $obj['Description']?>         
            </p>   
            
            <p class="user_name">By: <?php echo $obj['Collage_id'] ?></p>             
        </div>        
    <?php
            $count = $count + 1;
    }?>