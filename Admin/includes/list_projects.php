<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header("Location: ../../index.php");
    exit();
}

// Check if the toast message and status are set in the session variables
if (isset($_SESSION['toast_message']) && isset($_SESSION['toast_status'])) {
    $toastMessage = $_SESSION['toast_message'];
    $toastStatus = $_SESSION['toast_status'];
    unset($_SESSION['toast_message']);
    unset($_SESSION['toast_status']);
} else {
    $toastMessage = "";
    $toastStatus = "";
}
// The rest of your dashboard code goes here
?>

<?php include_once "sidebar.php" ?>
<?php include_once "dbconnect.php" ?>

<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $projectId = $_POST['projectId'];
    $feedback = $_POST['feedback'];
    $currentDate = date("Y-m-d"); // Get the current date

    // Insert the form data into the notification table
    $insertQuery = "INSERT INTO notifications (notification, project_id, date) VALUES ('$feedback', '$projectId', '$currentDate')";
    $result = $connection->query($insertQuery);

    if ($result) {
        // Set the toast message and status
        $formToastMessage = "Form submitted successfully.";
        $formToastStatus = "info";
    } else {
        // Failed to insert the form data
        $formToastMessage = "Error: " . $connection->error;
        $formToastStatus = "danger";
    }
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Projects</h1>
            <br>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Project Progress
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Project</th>
                                <th>Group no</th>
                                <th>Members</th>
                                <th>Work</th>
                                <th>Status</th> 
                                <th>Feedback</th> 

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Project</th>
                                <th>Group no</th>
                                <th>Members</th>
                                <th>Work</th>
                                <th>Status</th> 
                                <th>Feedback</th> 

                            </tr>
                        </tfoot>
                        <tbody>
<?php



// Get the session ID
$sessionId = $_SESSION['user_id'];

// Fetch project details from the projects table
$query2 = "SELECT id, project_name, status FROM projects WHERE f_id = $sessionId";
$result2 = $connection->query($query2);

if ($result2) {
    $rowCounter = 1; // Initialize the row counter

    while ($row2 = $result2->fetch_assoc()) {
        $projectId = $row2['id'];
        $projectName = $row2['project_name'];
        $status = $row2['status']; // Retrieve the status

        // Fetch members' names from the members table based on the project ID
        $query3 = "SELECT member_id FROM members WHERE project_id = $projectId";
        $result3 = $connection->query($query3);

        // Construct a string of member names
        $memberNames = "";
        if ($result3) {
            while ($row3 = $result3->fetch_assoc()) {
                $memberNames .="'". $row3['member_id'] . "', ";
            }
            $result3->free();
        }
        // Remove the trailing comma and space
        $memberNames = rtrim($memberNames, ", ");
        // $memberIds = implode("', '", $memberNames);
        // echo $memberNames;
        // Select User_name from students table where id = members_name
        $query4 = "SELECT * FROM student WHERE Collage_id IN ($memberNames) ";

        $result4 = $connection->query($query4);

        // Construct a string of user names
        $userNames = "";
        if ($result4) {
            while ($row4 = $result4->fetch_assoc()) {
                $userNames .= $row4['First_name'] . ", ";
            }
            $result4->free();
        }
        // Remove the trailing comma and space
        $userNames = rtrim($userNames, ", ");
?>
        <tr>
            <td><?php echo $rowCounter; ?></td>
            <td><?php echo $projectName; ?></td>
            <td><?php echo $projectId; ?></td>
            <td><?php echo $userNames; ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php if ($status == 0) : ?>
                        <li><a class="dropdown-item" href="status.php?projectId=<?php echo $projectId; ?>&status=1"
                            onclick="trackButtonClick('Approve')">
                                <i class="bi bi-check"></i> Approve
                            </a></li>
                        <li><a class="dropdown-item" href="status.php?projectId=<?php echo $projectId; ?>&status=2"
                            onclick="trackButtonClick('Reject')">
                                <i class="bi bi-x"></i> Reject
                            </a></li>
                    <?php elseif ($status == 1) : ?>
                        <li><a class="dropdown-item disabled" href="#">
                                <i class="bi bi-check"></i> Approved
                            </a></li>
                        <li><a class="dropdown-item" href="status.php?projectId=<?php echo $projectId; ?>&status=2"
                            onclick="trackButtonClick('Reject')">
                                <i class="bi bi-x"></i> Reject
                            </a></li>
                    <?php elseif ($status == 2) : ?>
                        <li><a class="dropdown-item disabled" href="#">
                                <i class="bi bi-x"></i> Rejected
                            </a></li>
                        <li><a class="dropdown-item" href="status.php?projectId=<?php echo $projectId; ?>&status=1"
                            onclick="trackButtonClick('Approve')">
                                <i class="bi bi-check"></i> Approve
                            </a></li>
                    <?php endif; ?>
                </ul>


                </div>
            </td>
            <td>
                <?php if ($status == 0) : ?>
                    <span class="custom-badge custom-badge-pending">Pending</span>
                <?php elseif ($status == 1) : ?>
                    <span class="custom-badge custom-badge-approved">Approved</span>
                <?php elseif ($status == 2) : ?>
                    <span class="custom-badge custom-badge-rejected">Rejected</span>
                <?php endif; ?>
            </td>
            <td>
                <div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
                <button type="button"  onclick="trackButtonClick('Feedback')" class="btn btn-primary" data-toggle="modal" data-target="#popupForm_<?php echo $projectId; ?>">Feedback</button>
                <div class="modal fade" id="popupForm_<?php echo $projectId; ?>" tabindex="-1" role="dialog" aria-labelledby="popupFormLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="popupFormLabel">Message</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="feedbackForm_<?php echo $projectId; ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <div class="mb-3">
                                        <label for="groupNo" class="form-label">Group No:</label>
                                        <input type="text" class="form-control" id="groupNo" name="groupNo" placeholder="Enter Group No" disabled value="<?php echo $projectId; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="project" class="form-label">Project:</label>
                                        <input type="text" class="form-control" id="project" name="project" placeholder="Enter Project" disabled value="<?php echo $projectName; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status:</label>
                                        <input type="text" class="form-control" id="status" name="status" placeholder="Enter Status" disabled value="<?php
                                            if ($status == 0) {
                                                echo 'Pending';
                                            } elseif ($status == 1) {
                                                echo 'Approved';
                                            } elseif ($status == 2) {
                                                echo 'Rejected';
                                            }
                                        ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="feedback" class="form-label">Feedback:</label>
                                        <div class="textarea-container">
                                            <textarea class="form-control" id="feedback_<?php echo $projectId; ?>" name="feedback" placeholder="Enter Feedback" maxlength="100" required></textarea>
                                            <div id="characterCount_<?php echo $projectId; ?>" class="text-end position-absolute bottom-0 end-0 character-count"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="projectId" name="projectId" value="<?php echo $projectId; ?>">
                                    <div class="modal-footer">
                                        <button type="submit" form="feedbackForm_<?php echo $projectId; ?>" class="btn btn-primary"  onclick="trackButtonClick('Feedback-submit')">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // Get the textarea element and character count element for the current project
                    var textarea_<?php echo $projectId; ?> = document.getElementById('feedback_<?php echo $projectId; ?>');
                    var characterCount_<?php echo $projectId; ?> = document.getElementById('characterCount_<?php echo $projectId; ?>');

                    // Add input event listener to the textarea for the current project
                    textarea_<?php echo $projectId; ?>.addEventListener('input', function() {
                        // Get the current value of the textarea for the current project
                        var value_<?php echo $projectId; ?> = textarea_<?php echo $projectId; ?>.value;

                        // Count the number of characters
                        var count_<?php echo $projectId; ?> = value_<?php echo $projectId; ?>.length;

                        // Calculate the remaining characters
                        var remaining_<?php echo $projectId; ?> = 100 - count_<?php echo $projectId; ?>;

                        // Update the character count display for the textarea for the current project
                        characterCount_<?php echo $projectId; ?>.textContent = count_<?php echo $projectId; ?> + '/100';

                        // Add class to indicate character count limit for the textarea for the current project
                        if (count_<?php echo $projectId; ?> > 100) {
                            characterCount_<?php echo $projectId; ?>.classList.add('text-danger');
                        } else {
                            characterCount_<?php echo $projectId; ?>.classList.remove('text-danger');
                        }
                    });
                </script>
            </td>
        </tr>
        <?php
        $rowCounter++; // Increment the row counter
    }
}
?>
</tbody>

                    </table>
                </div>
            </div>
        </div>
    </main>
    <?php include_once "footer.php"?>

</div>



<style>
  .textarea-container {
    position: relative;
    padding-bottom: 25px; /* Add padding to the bottom */
  }
  .character-count {
    font-family: "Arial", sans-serif;
    font-size: 14px;
    color: #999999;
    margin-top: 5px;
  }

 .dropdown-toggle::after {
    margin-left: 5px;
}

.dropdown-menu a {
    display: flex;
    align-items: center;
}

.dropdown-menu a i {
    margin-right: 5px;
}

.dropdown-menu a span {
    flex-grow: 1;
}


.custom-badge {
    display: inline-block;
    padding: 10px 10px;
    border-radius: 4px;
    font-size: 16px; /* Increased font size to 16px */
    font-weight: bold;
}

.custom-badge-pending {
    background-color: #0dcaf0; /* Bootstrap info color */
    color: white;
}

.custom-badge-approved {
    background-color: #28a745; /* Bootstrap success color */
    color: white;
}

.custom-badge-rejected {
    background-color: #dc3545; /* Bootstrap danger color */
    color: white;
}



/* Custom CSS for Popup Form */
.modal-content {
  border-radius: 10px;
}

.modal-header {
  background-color: #f8f9fa;
  border-bottom: none;
}

.modal-title {
  color: #333;
  font-weight: bold;
  margin-bottom: 0;
}

.modal-body {
  padding: 20px;
}

.modal-footer {
  background-color: #f8f9fa;
  border-top: none;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
  border-radius: 4px;
}

.btn-primary:hover {
  background-color: #0069d9;
  border-color: #0062cc;
}

.btn-secondary {
  background-color: #6c757d;
  border-color: #6c757d;
  border-radius: 4px;
}

.btn-secondary:hover {
  background-color: #5a6268;
  border-color: #545b62;
}

.form-label {
  font-weight: bold;
}

.form-control {
  border-radius: 4px;
}

textarea.form-control {
  resize: none;
}

    </style>


<!-- Add the jQuery and Bootstrap JavaScript code to your HTML file -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<!-- Add this line inside the <body> section, where you want to display the toast modals -->
<div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
<script>
    // Check if the toast message and status are not empty, then show the toast
    <?php if (!empty($toastMessage) && !empty($toastStatus)) { ?>
        $(document).ready(function() {
            var type = <?php echo ($toastStatus == 1) ? "'success'" : "'danger'"; ?>;
            var message = <?php echo json_encode($toastMessage); ?>;
            showToast(type, message);
        });
    <?php } ?>

    function showToast(type, message) {
        var toastContainer = $("#toast-container");
        var toast = $("<div>").addClass("toast").addClass("bg-" + type).addClass("text-white")
            .attr("role", "alert").attr("aria-live", "assertive").attr("aria-atomic", "true");

        var toastHeader = $("<div>").addClass("toast-header").addClass("bg-" + type).addClass("text-white")
            .append($("<i>").addClass(getIconClassByType(type)).addClass("me-2"))
            .append($("<strong>").addClass("mr-auto").text("Notification"));

        var toastBody = $("<div>").addClass("toast-body").text(message);

        toast.append(toastHeader).append(toastBody);
        toastContainer.append(toast);

        toast.toast({ delay: 2000 });
        toast.toast("show");
    }

    // Check if the form toast message and status are not empty, then show the toast
    <?php if (!empty($formToastMessage) && !empty($formToastStatus)) { ?>
        $(document).ready(function() {
            var type = <?php echo ($formToastStatus == "info") ? "'info'" : "'danger'"; ?>;
            var message = <?php echo json_encode($formToastMessage); ?>;
            showFormToast(type, message);
        });
    <?php } ?>

    function showFormToast(type, message) {
        var toastContainer = $("#toast-container");
        var toast = $("<div>").addClass("toast").addClass("bg-" + type).addClass("text-white")
            .attr("role", "alert").attr("aria-live", "assertive").attr("aria-atomic", "true");

        var toastHeader = $("<div>").addClass("toast-header").addClass("bg-" + type).addClass("text-white")
            .append($("<i>").addClass(getIconClassByType(type)).addClass("me-2"))
            .append($("<strong>").addClass("mr-auto").text("Notification"));

        var toastBody = $("<div>").addClass("toast-body").text(message);

        toast.append(toastHeader).append(toastBody);
        toastContainer.append(toast);

        toast.toast({ delay: 2000 });
        toast.toast("show");
    }

    function getIconClassByType(type) {
        if (type === "info") {
            return "bi bi-info-circle-fill";
        } else if (type === "danger") {
            return "bi bi-exclamation-circle-fill";
        } else {
            return "bi bi-bell-fill";
        }
    }



</script>
<script src="../assets/JS/script.js"></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

