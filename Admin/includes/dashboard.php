<?php
session_start();

// Check if the user is not logged in
if (!isset ($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header("Location: ../../index.php");
    exit();
}
// The rest of your dashboard code goes here
?>
<?php include_once "sidebar.php" ?>
<?php include "dbconnect.php" ?>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
<div id="layoutSidenav_content">
    <main>

        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">

                <?php
                // Assuming you have established a database connection
                
                // Get the session id of the user
                $sessionId = $_SESSION['user_id'];

                // Query to count the total groups in the session
                $query = "SELECT COUNT(id) AS totalGroups FROM projects WHERE f_id = $sessionId";
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_assoc($result);
                $totalGroups = $row['totalGroups'];

                ?>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Total Groups</div>
                        <a href="list_projects.php" style="text-decoration: none; color: inherit;">
                            <div
                                class="card-footer d-flex align-items-center justify-content-between sb-card-hover-blue">
                                <?php echo $totalGroups; ?>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                    </div>
                    </a>
                </div>

                <?php
                // Assuming you have established a database connection
                
                // Query to fetch projects based on session id
                $projectQuery = "SELECT id FROM projects WHERE f_id = $sessionId";
                $projectResult = mysqli_query($connection, $projectQuery);

                // Count the total number of projects
                $totalProjects = mysqli_num_rows($projectResult);

                // Count the total number of members for each project
                $totalMembers = 0;

                while ($row = mysqli_fetch_assoc($projectResult)) {
                    $projectId = $row['id'];

                    // Query to count members for the current project
                    $memberQuery = "SELECT COUNT(member_id) AS totalMembers FROM members WHERE project_id = $projectId";
                    $memberResult = mysqli_query($connection, $memberQuery);
                    $memberRow = mysqli_fetch_assoc($memberResult);
                    $totalMembers += $memberRow['totalMembers'];
                }

                ?>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Total Users</div>
                        <a href="users.php" style="text-decoration: none; color: inherit;">
                            <div
                                class="card-footer d-flex align-items-center justify-content-between sb-card-hover-yellow">
                                <?php echo $totalMembers; ?>
                                <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                    </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Approved Projects</div>
                        <a href="list_projects.php" style="text-decoration: none; color: inherit;">
                            <div
                                class="card-footer d-flex align-items-center justify-content-between sb-card-hover-green">
                                <?php

                                // Execute the query to count approved projects with the specified session ID
                                $query = "SELECT COUNT(*) FROM projects WHERE status = 1 AND f_id = '$sessionId'";
                                $result = mysqli_query($connection, $query);
                                $row = mysqli_fetch_row($result);
                                $count = $row[0];

                                echo $count;
                                ?>
                                <!--<a class="small text-white stretched-link" href="#">View Details</a>-->
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </a>
                    </div>
                </div>

                <style>
                    .sb-card-hover-red:hover {
                        /* Define the styles for the card footer on hover */
                        background-color: rgba(202, 45, 59, 0.8);
                        color: #fff;
                        /* Add any other desired styles */
                    }

                    .sb-card-hover-yellow:hover {

                        /* Define the styles for the card footer on hover */
                        background-color: #e6b216;
                        color: #fff;
                        /* Add any other desired styles */
                    }

                    .sb-card-hover-blue:hover {
                        /* Define the styles for the card footer on hover */
                        background-color: #1365dd;
                        color: #fff;
                        /* Add any other desired styles */
                    }

                    .sb-card-hover-green:hover {
                        /* Define the styles for the card footer on hover */
                        background-color: #187b4d;
                        color: #fff;
                        /* Add any other desired styles */
                    }

                    .modal-header {
                        border-bottom: none;
                    }

                    .modal-title {
                        font-weight: bold;
                        text-transform: uppercase;
                        margin-bottom: 10px;
                    }

                    .modal-body {
                        padding: 20px;
                    }

                    .form-group label {
                        font-weight: bold;
                        margin-bottom: 5px;
                    }

                    /* .form-control {
                                        border-radius: 0;
                                        box-shadow: none;
                                        margin-bottom: 10px;
                                    } */
                    .custom_form {
                        border-radius: 0;
                        box-shadow: none;
                        margin-bottom: 10px;
                    }

                    .form-control:focus {
                        box-shadow: none;
                    }

                    .modal-footer {
                        border-top: none;
                        padding: 15px 20px;
                    }

                    /* Custom modal width */
                    #addProjectModal .modal-dialog {
                        max-width: 1000px;
                        /* Set your desired width */
                    }
                </style>


                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Pending Project</div>
                        <a href="list_projects.php" style="text-decoration: none; color: inherit;">
                            <div
                                class="card-footer d-flex align-items-center justify-content-between sb-card-hover-red">
                                <?php

                                // Execute the query to count approved projects with the specified session ID
                                $query = "SELECT COUNT(*) FROM projects WHERE status = 2 AND f_id = '$sessionId'";
                                $result = mysqli_query($connection, $query);
                                $row = mysqli_fetch_row($result);
                                $count = $row[0];

                                echo $count;
                                ?>
                                <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
            <!-- <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Area Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div> -->
            <!-- Feedback Popup Modal -->
            <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="feedbackModalLabel">
                                <i class="fas fa-envelope"></i> Provide Feedback
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Feedback Form -->
                            <form method="post" action="feedback.php" onsubmit="return validateForm()"
                                class="needs-validation" novalidate>
                                <div class="form-group">
                                    <label for="issue">Describe the issue:</label>
                                    <textarea class="form-control" id="issue" name="issue" rows="3" required></textarea>
                                    <div class="invalid-feedback">Please enter the issue.</div>
                                </div>
                                <input type="hidden" name="f_id" value="<?php echo $sessionId; ?>">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function validateForm() {
                    var form = document.querySelector('.needs-validation');
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                    return form.checkValidity();
                }
            </script>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Project Progress
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Project</th>
                                <th>Progress</th>
                                <th>Status</th>
                                <th>Work</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Project</th>
                                <th>Progress</th>
                                <th>Status</th>
                                <th>Work</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $query = "SELECT id, project_name, start_date, end_date FROM projects WHERE f_id = '$sessionId' AND status = 1";
                            $result = mysqli_query($connection, $query);

                            // Loop through the query results and generate table rows
                            while ($row = mysqli_fetch_assoc($result)) {
                                $projectId = $row['id'];
                                $projectName = $row['project_name'];
                                $startDate = $row['start_date'];
                                $endDate = $row['end_date'];

                                // Calculate the total days
                                $startDateObj = new DateTime($startDate);
                                $endDateObj = new DateTime($endDate);
                                $interval = $startDateObj->diff($endDateObj);
                                $totalDays = $interval->days;

                                // Count the completed rows for the project dynamically
                                $countQuery = "SELECT COUNT(*) AS completed_rows FROM weekly WHERE project_id = $projectId AND status = 1";
                                $countResult = mysqli_query($connection, $countQuery);
                                $countRow = mysqli_fetch_assoc($countResult);
                                $completedRows = $countRow['completed_rows'];

                                // Calculate the progress percentage and limit it to a maximum of 100
                                if ($totalDays < 7) {
                                    $progressPercentage = ($completedRows / $totalDays) * 100;
                                } else {
                                    $totalWeeks = ceil($totalDays / 7);
                                    $progressPercentage = ($completedRows / $totalWeeks) * 100;
                                }
                                $progressPercentage = min($progressPercentage, 100);
                                $progressPercentage = round($progressPercentage);

                                // Determine the color based on the progress percentage
                                $progressColor = '';
                                if ($progressPercentage <= 10) {
                                    $progressColor = 'bg-danger';
                                } else if ($progressPercentage <= 25) {
                                    $progressColor = 'bg-warning';
                                } else if ($progressPercentage <= 50) {
                                    $progressColor = 'bg-info';
                                } else {
                                    $progressColor = 'bg-success';
                                }

                                // Determine the status badge based on the progress percentage
                                $statusBadge = '';
                                if ($progressPercentage <= 25) {
                                    $statusBadge = '<span class="badge bg-danger">Started</span>';
                                } else if ($progressPercentage >= 100) {
                                    $statusBadge = '<span class="badge bg-success">Completed</span>';
                                } else {
                                    $statusBadge = '<span class="badge bg-info">In Progress</span>';
                                }

                                // Generate the table row
                                echo "<tr>
                                        <td>$projectId</td>
                                        <td>$projectName</td>
                                        <td>
                                            <div class='progress' style='margin-bottom: 0;'>
                                                <div id='progress-bar-$projectId' class='progress-bar progress-bar-striped progress-bar-animated $progressColor' role='progressbar' aria-valuemin='0' aria-valuemax='100' style='width: $progressPercentage%; display: inline-block;'></div>
                                            </div>
                                            <span id='progress-text-$projectId' style='display: inline-block; margin-top: 5px;'>$progressPercentage% completed</span>
                                        </td>
                                        <td>
                                            $statusBadge
                                        </td>
                                        <td>
                                        <a href='weekly.php?groupId=$projectId' class='btn btn-secondary'>View</a>
                                        </td>
                                    </tr>";
                            }
                            ?>
                        </tbody>




                    </table>
                </div>
            </div>

        </div>

        <!-- <div class="row">
            <div class="col">
                <a href="download_csv.php" class="btn btn-primary">Download CSV</a>
            </div>
        </div> -->
    </main>

</div>

<!-- Add this code inside the <body> section of your HTML file, where you want to display the toast modals -->
<div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

<script>
    // Check if the form toast message and status are not empty, then show the toast
    <?php if (!empty ($_SESSION['form_toast_message']) && !empty ($_SESSION['form_toast_status'])) { ?>
        $(document).ready(function () {
            var type = '<?php echo $_SESSION['form_toast_status']; ?>';
            var message = '<?php echo $_SESSION['form_toast_message']; ?>';
            showToast(type, message);
            clearFormToastSession(); // Clear the form toast session variables
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

    function getIconClassByType(type) {
        if (type === "success") {
            return "bi bi-check-circle-fill";
        } else if (type === "error") {
            return "bi bi-exclamation-circle-fill";
        } else {
            return "bi bi-bell-fill";
        }
    }

    function clearFormToastSession() {
        <?php unset($_SESSION['form_toast_message']); ?>
        <?php unset($_SESSION['form_toast_status']); ?>
    }
</script>



<!-- Add this line inside the <body> section, where you want to display the toast modals -->
<div id="toast-container1" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

<script>
    $(document).ready(function () {
        var type = "info";
        var message = "If you have any problem, please let us know in the feedback section.";

        // Generate a random number between 0 and 1
        var random = Math.random();

        // Show the toast message with a 10% chance
        if (random < 0.3) {
            showToast(type, message);
        }
    });

    function showToast(type, message) {
        var toastContainer = $("#toast-container1");
        var toast = $("<div>").addClass("toast").addClass("bg-" + type).addClass("text-white")
            .attr("role", "alert").attr("aria-live", "assertive").attr("aria-atomic", "true");

        var toastHeader = $("<div>").addClass("toast-header").addClass("bg-" + type).addClass("text-white")
            .append($("<i>").addClass(getIconClassByType(type)).addClass("me-2"))
            .append($("<strong>").addClass("mr-auto").text("Notification"))
            .append($("<button>").addClass("btn-close close-icon").attr("type", "button").attr("data-bs-dismiss", "toast").attr("aria-label", "Close").css("margin-left", "auto"));

        var toastBody = $("<div>").addClass("toast-body").text(message);

        toast.append(toastHeader).append(toastBody);
        toastContainer.append(toast);

        toast.toast({ delay: 5000 });
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