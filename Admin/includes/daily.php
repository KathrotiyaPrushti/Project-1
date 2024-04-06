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
<?php include_once "dbconnect.php"?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Daily Report</h1>
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

                                <th>Project</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>View</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                  
                                <th>Project</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>View</th>

                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                             if (isset($_GET['XuTSGWHSYDSBWS4451544148356887248788'])) {
                              // Get the parameter value from the URL
                              $parameterValue = $_GET['XuTSGWHSYDSBWS4451544148356887248788'];
                          
                              // Decode the parameter value
                              $decodedValue = urldecode($parameterValue);
                          
                              // Extract the groupId from the decoded value
                              $groupId = substr($decodedValue, 0, strlen($groupId));
                          
                              // Check if the groupId is valid
                              if ($groupId !== false) {
                                  // Rest of your code here
                              } else {
                                  // Handle the case when the parameter format is invalid
                                  echo 'Invalid parameter format.';
                              }
                          } else {
                              // Handle the case when the parameter is not present
                              http_response_code(404);
                              exit;
                          }
                          
                  
                  
                            // Fetch records from the daily table based on the groupId
                            $query = "SELECT * FROM daily WHERE Group_id = $groupId";
                            $result = $connection->query($query);

                            if ($result) {
                                $rowCounter = 1; // Initialize the row counter

                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['Id'];
                                    $username = $row['Collage_id'];
                                    $title = $row['Title'];
                                    $description = $row['Description'];
                                    $date = $row['Date'];

                                    // Fetch the project name from the projects table based on the groupId
                                    $projectQuery = "SELECT project_name FROM projects WHERE id = $groupId";
                                    $projectResult = $connection->query($projectQuery);

                                    if ($projectResult && $projectRow = $projectResult->fetch_assoc()) {
                                        $projectName = $projectRow['project_name'];
                                    } else {
                                        $projectName = "N/A";
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $rowCounter; ?></td>
                                        <td><?php echo $projectName; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo $title; ?></td>
                                        <td class="description-cell"><?php echo $description; ?></td>
                                        <td><?php echo $date; ?></td>
                                        <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item view-report" href="#" onclick="trackButtonClick('View')">
                                                    <i class="bi bi-eye-fill"></i> View
                                                </a>
                                                <!-- <a class="dropdown-item" href="photos.php" onclick="trackButtonClick('Photos')">
                                                    <i class="bi bi-image-fill"></i> Photos
                                                </a> -->
                                                <!-- <a class="dropdown-item" href="#" onclick="trackButtonClick('Feedback daily')">
                                                    <i class="bi bi-chat-left-dots-fill"></i> Feedback
                                                </a> -->
                                            </div>
                                        </div>
                                    </td>

                                    </tr>
                                    <?php
                                    $rowCounter++; // Increment the row counter
                                }
                                $result->free();
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
<!-- Add the Bootstrap CSS link to your HTML file -->

<!-- Add your custom CSS styles -->
<style>
  .modal-dialog {
    max-width: 600px;
  }

  .report-details {
    overflow-y: auto;
    max-height: 300px;
  }

  .report-details p {
    margin-bottom: 10px;
  }

  /* Add custom styles for grid and fonts */
  .container {
    padding: 20px;
  }

  h1 {
    font-size: 24px;
    font-weight: bold;
  }

  .table {
    font-size: 14px;
  }

  .modal-body {
    font-size: 16px;
  }
</style>

<!-- Add the jQuery and Bootstrap JavaScript code to your HTML file -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<!-- Add the following JavaScript code after including the jQuery and Bootstrap libraries -->
<script>
  $(document).ready(function() {
    // Handler for "View" option click
    $('.view-report').click(function(e) {
      e.preventDefault(); // Prevent the default link behavior

      // Get the row containing the clicked "View" option
      var row = $(this).closest('tr');

      // Extract the report details from the row
      var project = row.find('td:nth-child(2)').text();
      var name = row.find('td:nth-child(3)').text();
      var title = row.find('td:nth-child(4)').text();
      var description = row.find('td:nth-child(5)').text();
      var date = row.find('td:nth-child(6)').text();

      // Build the HTML content for the report details
      var content = '<div class="modal-body">' +
                    '<div class="report-details">' +
                    '<p><strong>Project:</strong><br>' + project + '</p>' +
                    '<p><strong>Name:</strong><br>' + name + '</p>' +
                    '<p><strong>Title:</strong><br>' + title + '</p>' +
                    '<p><strong>Description:</strong><br>' + description + '</p>' +
                    '<p><strong>Date:</strong><br>' + date + '</p>' +
                    '</div>' +
                    '</div>';

// Create a Bootstrap modal and set its content
var modal = $('<div class="modal fade" tabindex="-1" role="dialog">' +
    '<div class="modal-dialog" role="document">' +
    '<div class="modal-content">' +
    '<div class="modal-header">' +
    '<h5 class="modal-title">Report Details</h5>' +
    '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
    '</div>' +
    content +
    '<div class="modal-footer">' +
    '<button class="btn btn-primary print-report" onclick="trackButtonClick(\'print\')">Print</button>' +
    '<button class="btn btn-secondary close-modal" data-dismiss="modal" onclick="trackButtonClick(\'close\')">Close</button>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '</div>');


      // Show the modal
      modal.modal('show');

      // Handler for "Print" option click
      modal.find('.print-report').click(function(e) {
        e.preventDefault(); // Prevent the default link behavior

        // Get the printable content
        var printContents = modal.find('.report-details').html();

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
    });

        // Handler for "Close" button click
        $(document).on('click', '.modal .close', function() {
      $(this).closest('.modal').modal('hide');
  });
    // Handler for "Close" button click
    $(document).on('click', '.close-modal', function() {
      $(this).closest('.modal').modal('hide');
    });
  });
</script>


<script src="../assets/JS/script.js"></script>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>