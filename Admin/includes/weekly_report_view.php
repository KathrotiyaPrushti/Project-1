<?php
    $project = $_POST['_project'];
    $name = $_POST['_name'];
    $title = $_POST['_title'];
    $description = $_POST['_description'];
    $marks = $_POST['_marks'];
    $faculty = $_POST['_facultyinput'];
    $status = $_POST['status'];
    $link = $_POST['_link'];
    $agendaStatus = 0;
    if($status == "Reject"){
        $agendaStatus = 2;
    }
    elseif ($status == "Approve"){
        $agendaStatus = 1;
    }
    // echo "Bhavya";
?>
<p><strong>Project:</strong><br><?php echo $name?></p>
<p><strong>Group:</strong><br><?php echo $name ?></p>
<p><strong>Description:</strong><br><?php echo $description ?></p>
<p><strong>Faculty input:   </strong><input type="text"  size="90" placeholder="Enter faculty input" id="f_input" name="f_input" value="<?php echo isset($faculty) ?>"></p>
<p><strong>Marks:   </strong><input type="number" placeholder="Enter marks" id="marks" name="marks" value="<?php echo $marks ?>"></p>
<a href="<?php echo $link;?>" target="_blank">Drive link to documents</a>

<div class="modal-footer">
                <!-- <button class="btn btn-primary print-report">Print</button> -->
                 <!-- <button class="sub">Submit</button>
                 -->
    <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      Actions
                                                  </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="#" onclick="updateHrefAndSubmit('weekly_status.php', 1)">
            <i class="bi bi-check"></i> Approve
        </a></li>
        <li><a class="dropdown-item" href="#" onclick="updateHrefAndSubmit('weekly_status.php', 2)">
            <i class="bi bi-x"></i> Reject
        </a></li>           
    </ul>
</div>
          <button class="btn btn-secondary close-modal" data-dismiss="modal" >Close</button>
                </div>
            </div>


