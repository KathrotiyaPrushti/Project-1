<?php
    require 'databaseconnect.php';
    session_start();
?>
<style>
  .msg {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100px; /* Adjust the width as per your requirement */
  }
</style>
<div class="close_btn">
        <button type="button" class="close text-white" id="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
<?php
    $project_id = "SELECT `project_id` FROM `members` WHERE `member_id`= '".$_SESSION['collage_id']."' ";
    $total_projects = mysqli_query($conn , $project_id);
    if ($total_projects && mysqli_num_rows($total_projects) > 0){
        $project_ids = array();
        while ($row = mysqli_fetch_assoc($total_projects)) {
            $project_ids[] = $row['project_id'];
        }
        $project_ids_string = implode(',', $project_ids);

        $notify = "SELECT * FROM `notifications` WHERE `project_id` IN (".$project_ids_string.") AND `status`='not seen'";

        $rel = mysqli_query($conn,$notify);
        $count=0;
        $no_of_row = mysqli_num_rows($rel);
    while($no_of_row!=$count){
        $obj = mysqli_fetch_assoc($rel);
        $p_name = "SELECT `project_name` FROM `projects` WHERE `id` = '".$obj['project_id']."'";
        $project = mysqli_query($conn,$p_name);
        $obj2 = mysqli_fetch_assoc($project);
    ?>
    <ul style = "list-style: none;">
        <li>
        <div class="notify_content" id="notify_content"  data-notification="<?php echo $obj['notification']; ?>" onclick = "notificationhandler(event , this , <?php echo $obj['id']?> , '<?php echo $obj2['project_name']?>' ,'<?php echo $obj['date']?>')">
        <h4 class="group">Project_id: <?php echo $obj['project_id']?></h4>
                <p class="msg"><?php echo $obj['notification']?></p>
        </div>
        <hr>
        </li>
    </ul>
    </div>     
    <?php
    $count=$count+1;
}
}?>          

<script>
    $(function(){
        $('.fas').on('click',function(e){
            // clearinterval();
            $('.notification-box').show();
        })
        $('.close').on('click',function(e){
            $('.notification-box').hide();
            $('#notification_detail').hide();
        })
    })

</script>