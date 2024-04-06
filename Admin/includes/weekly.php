<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header("Location: ../../index.php");
    exit();
}

// The rest of your dashboard code goes here

?>
<?php include_once "sidebar.php"?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="assets/css/notification.css">


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Weekly Report</h1>
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
                                <th>No</th>
                                <th>Group No</th>
                                <th>Project</th>
                                <!-- <th>Name</th> -->
                                <th>Description</th>
                                <!-- <th>Date</th> -->
                                <th>Work</th>
                                <th>Status</th>
                                <!-- <th>View</th> -->

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Group No</th>
                                <th>Project</th>
                                <!-- <th>Name</th> -->
                                <th>Description</th>
                                <!-- <th>Date</th> -->
                                <th>Work</th>
                                <th>Status</th>
                                <!-- <th>View</th> -->

                            </tr>
                        </tfoot>
                        <tbody>
                        <?php
                          // Assuming you have a MySQLi connection named $mysqli established
                          $host = "localhost";
                          $dbUsername = "root";
                          $dbPassword = "";
                          $database = "project_reports";

                          // Create a new MySQLi instance
                          $mysqli = new mysqli($host, $dbUsername, $dbPassword, $database);

                          // Get the session ID
                          $sessionId = $_SESSION['user_id'];
                          $groupId = $_GET['groupId'];

                          // Fetch project details from the projects table
                          $query2 = "SELECT * FROM projects WHERE id = $groupId";
                          $result2 = $mysqli->query($query2);

                          if ($result2) {
                              $rowCounter = 1; // Initialize the row counter

                              while ($row2 = $result2->fetch_assoc()) {
                                  $projectId = $row2['id'];
                                  $projectName = $row2['project_name'];
                                  $projectStatus = $row2['status']; // Retrieve the project status

                                  // Fetch members' names from the members table based on the project ID
                                  $query3 = "SELECT member_id FROM members WHERE project_id = $projectId";
                                  $result3 = $mysqli->query($query3);

                                  // Construct an array of member names
                                  $memberNames = array();
                                  if ($result3) {
                                      while ($row3 = $result3->fetch_assoc()) {
                                          $memberNames[] = $row3['member_id'];
                                      }
                                      $result3->free();
                                  }

                                  // Select User_name from students table where Userid matches member_names
                                  $userNames = "";
                                  if (!empty($memberNames)) {
                                      $memberNamesList = "'" . implode("', '", $memberNames) . "'";
                                      $query4 = "SELECT First_name FROM student WHERE Collage_id IN ($memberNamesList)";
                                      $result4 = $mysqli->query($query4);

                                      // Construct a string of user names
                                      if ($result4) {
                                          while ($row4 = $result4->fetch_assoc()) {
                                              $userNames .= $row4['First_name'] . ", ";
                                          }
                                          $result4->free();
                                      }
                                      // Remove the trailing comma and space
                                      $userNames = rtrim($userNames, ", ");
                                  }

                                  // Fetch agenda from the weekly table
                                  $query5 = "SELECT * FROM weekly WHERE project_id = $projectId";
                                  $result5 = $mysqli->query($query5);

                                  // Generate a new table row for each agenda item
                                  while ($row5 = $result5->fetch_assoc()) {
                                      $agendaId = $row5['id']; // Fetch the agenda item ID
                                      $agendaStatus = $row5['status'];
                                      $agendaItem = $row5['this_week'];
                                      $marks = $row5['marks'];
                                      $faculty_input = $row5['Faculty_input'];
                                      $link = isset($row5['drive_link']);
                                      ?>
                                      <tr>
                                        <td><?php echo $rowCounter;?></td>
                                          <td><?php echo $projectId; ?></td>
                                          <td><?php echo $projectName; ?></td>
                                          <td class="description-cell"><?php echo $agendaItem; ?></td>
                                          <!-- <td><?php echo $date; ?></td> -->

                                          <td>
                                              <div class="dropdown">
                                                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      Action
                                                  </button>
                                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                      <a class="dropdown-item view-report" href="#" onclick="trackButtonClick('View')">
                                                          <i class="bi bi-eye-fill"></i> View
                                                      </a>
                                                      <a class="dropdown-item" href="photos.php?groupId=<?php echo $projectId ?>&weekId=<?php echo $agendaId ?>" onclick="trackButtonClick('Photos')">
                                                      <i class="bi bi-image-fill"></i> Photos
                                                  </a>

                                                      <!-- <a class="dropdown-item" href="#" onclick="trackButtonClick('Feedback daily')">
                                                          <i class="bi bi-chat-left-dots-fill"></i> Feedback
                                                      </a> -->
                                                  </div>
                                              </div>
                                          </td>                                        
                                          <td>
                                              <?php if ($agendaStatus == 0) : ?>
                                                  <span class="custom-badge custom-badge-pending">Pending</span>
                                              <?php elseif ($agendaStatus == 1) : ?>
                                                  <span class="custom-badge custom-badge-approved">Approved</span>
                                              <?php elseif ($agendaStatus == 2) : ?>
                                                  <span class="custom-badge custom-badge-rejected">Rejected</span>
                                              <?php endif; ?>
                                          </td>

                                         
                                      </tr>
                                      <?php
                                      $rowCounter++; // Increment the row counter
                                  }
                                  $result5->free();
                              }
                              $result2->free();
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

<div class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Report Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="report-details">
                      <!-- <p>Bhavya</p> -->
                    </div>
                </div>
                
   </div>
</div>
<script>
    function updateHrefAndSubmit(url, status) {
        // Get the input field value
        var inputValue = document.getElementById('f_input').value;
        var marks = document.getElementById('marks').value;
        // Build the dynamic URL with input field value
        var dynamicUrl = url + '?weekly_id=' + <?php echo $agendaId?> + '&status=' + status +'&groupId=' + <?php echo $groupId?>+'&f_inp='+ inputValue+'&marks='+marks;
        console.log(dynamicUrl);
        // Update the href attribute of the selected link
        console.log(dynamicUrl);
        document.querySelector('.dropdown-item').setAttribute('href', dynamicUrl);

        // Trigger the link click to navigate to the updated URL
        document.querySelector('.dropdown-item').click();
    }
</script>
<!-- Add the Bootstrap CSS link to your HTML file -->

<!-- Add your custom CSS styles -->
<style>
.modal-dialog {
            max-width: 800px;
        }

        .modal-content {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #007bff;
            color: #fff;
            border-radius: 10px 10px 0 0;
            padding: 15px;
        }

        .modal-title {
            font-size: 24px;
            font-weight: bold;
        }

        .btn-close {
            color: #fff;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            font-size: 16px;
            padding: 30px;
        }

        .report-details {
            padding: 20px;
            border-radius: 8px;
            background-color: #f4f4f4;
            border: 1px solid #e0e0e0;
            overflow-y: auto;
            /* Remove this line to disable scrolling */
            max-height: 500px;
            /* Adjust the height as per your requirement */
        }


        .report-details p {
            margin-bottom: 15px;
            color: #333;
        }
        .report-details input {
            margin-bottom: 15px;
            color: #333;
        }
</style>




<script src="../assets/JS/script.js"></script>


<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- Add the jQuery and Bootstrap JavaScript code to your HTML file -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function() {
    // Handler for "View" option click
    $(document).on('click', '.view-report', function(e) {
      e.preventDefault(); // Prevent the default link behavior

      // Get the row containing the clicked "View" option
      var row = $(this).closest('tr');

      // Extract the report details from the row
      var project = row.find('td:nth-child(1)').text();
      var name = row.find('td:nth-child(3)').text();
      var title = row.find('td:nth-child(2)').text();
      var description = row.find('td:nth-child(3)').text();
      var status = row.find('td:nth-child(6)').text();
    //   var date = row.find('td:nth-child(6)').text();
    //   var marks = $marks;
    // console.log(title);
      var data = {
        _project: project,
        _name: name,
        _title: title,
        _description: description,
        _link:"<?php echo $link; ?>",
        // _date: date
        _facultyinput:"<?php echo $faculty_input; // Output the trimmed value?>",
        _marks:<?php echo $marks?>,
        status: status,
      };

      $.ajax({
        url: 'weekly_report_view.php',
        type: 'POST',
        data: data,
        success: function(response) {
          $('.report-details').html(response);
          // Show the modal
          $('.modal').modal('show');
        },
        error: function(xhr, status, error) {
          // Handle error if the AJAX request fails
          console.log(error);
        }
      });
    });

    // Handler for "Print" option click
    $(document).on('click', '.print-report', function(e) {
      e.preventDefault(); // Prevent the default link behavior

      // Get the printable content
      var printContents = $('.report-details').html();

      // Create a new window for printing
      var printWindow = window.open('', '_blank', 'width=600,height=600');

      // Write the report details content to the print window
      printWindow.document.open();
      printWindow.document.write('<html><head><title>Print</title></head><body>');
      printWindow.document.write(printContents);
      printWindow.document.write('</body></html>');
      printWindow.document.close();

      // Call the print function on the print window
      printWindow.print();

      // Close the print window after printing
      printWindow.close();
    });

    // Handler for "Close" button click
    $(document).on('click', '.modal .close, .close-modal', function() {
      $(this).closest('.modal').modal('hide');
    });
  });
</script>


<!-- Add this line inside the <body> section, where you want to display the toast modals -->
<div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
<script>
    // Check if the toast message and status are not empty, then show the toast
    <?php if (!empty($_SESSION['toast_message']) && !empty($_SESSION['toast_status'])) { ?>
        $(document).ready(function() {
            var type = <?php echo ($_SESSION['toast_status'] == 1) ? "'success'" : "'danger'"; ?>;
            var message = <?php echo json_encode($_SESSION['toast_message']); ?>;
            showToast(type, message);
            clearToastSession(); // Clear the toast session variables
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
    <?php if (!empty($_SESSION['form_toast_message']) && !empty($_SESSION['form_toast_status'])) { ?>
        $(document).ready(function() {
            var type = <?php echo ($_SESSION['form_toast_status'] == "info") ? "'info'" : "'danger'"; ?>;
            var message = <?php echo json_encode($_SESSION['form_toast_message']); ?>;
            showFormToast(type, message);
            clearFormToastSession(); // Clear the form toast session variables
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

    function clearToastSession() {
        <?php unset($_SESSION['toast_message']); ?>
        <?php unset($_SESSION['toast_status']); ?>
    }

    function clearFormToastSession() {
        <?php unset($_SESSION['form_toast_message']); ?>
        <?php unset($_SESSION['form_toast_status']); ?>
    }
</script>



