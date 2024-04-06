<?php
session_start();
// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header("Location: ../../index.php");
    exit();
}

include_once "sidebar.php";
include_once "dbconnect.php";

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<link rel="stylesheet" href="assets/css/notification.css">
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- Add the jQuery and Bootstrap JavaScript code to your HTML file -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<style>
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
  .custom_form{
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
    max-width: 1000px; /* Set your desired width */
  }
</style>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $errors = array();
    $projectName = $_POST['projectName'];
    $projectTechnology = $_POST['projectTechnology'];
    $projectMembers = $_POST['projectMembers'];
    $projectStatus = $_POST['projectStatus'];
    $projectDuration = $_POST['projectDuration'];
    $projectAbstract = $_POST['projectAbstractInput'];
    $sessionId = $_SESSION['user_id'];


    // Perform form validation
    if (empty($projectName)) {
        $errors[] = "Project name is required.";
    }

    // Add more validation rules for other form fields as needed

    // Convert the project technology into keywords
    $technologyKeywords = strtolower(str_replace(' ', ',', $projectTechnology));

    // If there are no errors, save the data to the database
    if (empty($errors)) {
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        // Prepare and execute the SQL statement to insert the data
        $stmt = $connection->prepare("INSERT INTO openproject (f_id , projectName, projectTechnology, projectMembers, projectStatus, projectDuration, projectAbstract, technologyKeywords) VALUES (?,?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss",$sessionId,$projectName, $projectTechnology, $projectMembers, $projectStatus, $projectDuration, $projectAbstract, $technologyKeywords);
        $stmt->execute();

        // $currentDate = new DateTime();  // Current date and time
        // $duration = new DateInterval('P'.$projectDuration.'M');  // Duration of 1 month

        // $futureDate = $currentDate->add($duration);
        $open_project_id =$stmt->insert_id;
        $sql ="INSERT INTO `projects`(`project_name` , `member_count` ,`end_date`,`open_project_id`, `f_id`) VALUES ('$projectName','$projectMembers','$projectDuration','$open_project_id','$sessionId')";
        $rel = mysqli_query($connection , $sql);


        $stmt->close();
        

        // Set the toast message and status
        $toastMessage = "Project added successfully.";
        $toastStatus = "success";

        $_SESSION['toast_message'] = $toastMessage;
        $_SESSION['toast_status'] = $toastStatus;

    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OpenWorld Projects</title>
  <!-- Include CSS and JS dependencies -->
  <!-- Add your CSS and JS file links here -->
</head>
<body>
<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">
      <h1 class="mt-4">OpenWorld Projects</h1>
      <br>
      <div class="card mb-4">
        <div class="card-header">
          <button type="button" class="btn btn-danger float-end" data-toggle="modal" data-target="#addProjectModal">
            <i class="fas fa-plus-circle me-1"></i>
            Add
          </button>
          <i class="fas fa-table me-1"></i>
          OpenWorld Projects
        </div>
        <div class="card-body">
        <?php
          // Check if the connection to the database is successful
          if (!$connection) {
              die("Connection failed: " . mysqli_connect_error());
          }

          // Retrieve the project data from the database
          // Modify this code to match your database retrieval logic
          $query = "SELECT * FROM openproject WHERE f_id = '$sessionId'";
          $result = mysqli_query($connection, $query);

          // Check if the query was successful and fetch the data
          if ($result) {
              $projects = array();
              while ($row = mysqli_fetch_assoc($result)) {
                  $projects[] = $row;
              }
          } else {
              // Handle the case when the query fails
              $projects = array(); // Empty array if no projects are found
          }
          $connection->close();
          ?>


<table id="datatablesSimple" class="table">
  <thead>
    <tr>
      <th>No</th>
      <th>Project</th>
      <th>Abstract</th>
      <th>Technology</th>
      <th>Members</th>
      <th>Status</th>
      <th>Duration</th>
      <th>Action</th>
      <th>View</th>

    </tr>
  </thead>
  <tbody>
    <?php
    // Iterate over the projects and generate table rows
    foreach ($projects as $index => $project) {
      $rowNumber = $index + 1;
      $projectId = $project['id'];
      $projectName = $project['projectName'];
      $projectAbstract = $project['projectAbstract'];
      $projectTechnology = $project['projectTechnology'];
      $projectMembers = $project['projectMembers'];
      $projectStatus = $project['projectStatus'];
      $projectDuration = $project['projectDuration'];
      ?>
      <tr>
        <td><?php echo $rowNumber; ?></td>
        <td><?php echo $projectName; ?></td>
        <td><?php echo $projectAbstract; ?></td>
        <td><?php echo $projectTechnology; ?></td>
        <td><?php echo $projectMembers; ?></td>
        <td><?php echo $projectStatus; ?></td>
        <td><?php echo $projectDuration; ?></td>
        <style>
        .dropdown-item i {
          margin-right: 5px; /* Adjust the value as needed */
        }
      </style>

      <td>
        <div class="btn-group">
          <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Actions
          </button>
          <div class="dropdown-menu">
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editProjectModal">
          <i class="fas fa-pencil-alt" style="color: #0d6efd;"></i>&nbsp;Edit
          </a>
            <a class="dropdown-item btn-delete" href="delete_project.php?projectId=<?php echo $projectId; ?>">
            <i class="fas fa-trash-alt" style="color: red;"></i>&nbsp;Delete
          </a>


          </div>
        </div>
      </td>
        <td>
          <!-- Add a button with the "View" class -->
          <button class="btn btn-primary btn-view" onclick="generatePDF(this);">View</button>
        </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>


        </div>
      </div>
      <!-- Add Project Modal -->
      <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="addProjectModalLabel">Add Project</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                  <i class="fas fa-times"></i>
                </span>
              </button>
            </div>
            <div class="modal-body">
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="addProjectForm" novalidate>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="projectName">Project Name</label>
                      <input type="text" class="form-control custom_form" id="projectName" name="projectName" placeholder="Enter project name" required>
                      <div class="invalid-feedback">Project name is required.</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="projectStatus">Status</label>
                      <div class="input-group">
                        <select class="form-control custom_form" id="projectStatus" name="projectStatus" required>
                          <option value="">Select status</option>
                          <option value="Started">Started</option>
                          <option value="In-Progress">In-Progress</option>
                          <option value="Completed">Completed</option>
                        </select>
                        <div class="invalid-feedback">Status is required.</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="projectMembers">Members</label>
                      <input type="text" class="form-control custom_form" id="projectMembers" name="projectMembers" placeholder="Enter project members" required>
                      <div class="invalid-feedback">Members are required.</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="projectDuration">Duration</label>
                      <input type="date" class="form-control custom_form" id="projectDuration" name="projectDuration" placeholder="Enter project duration" required>
                      <div class="invalid-feedback">Duration is required.</div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="projectTechnology">Technology</label>
                  <div class="input-group">
                    <input type="text" class="form-control custom_form" id="projectTechnology" name="projectTechnology" placeholder="Enter project technology" required>
                    <div class="invalid-feedback">Technology is required.</div>
                  </div>
                  <div id="technologyBadgeContainer" class="mt-2"></div>
                </div>
                <div class="form-group">
                <label for="projectAbstract">Abstract</label>
                <div id="projectAbstract" class="quill-editor" style="height: 200px;"></div>
                <input type="hidden" name="projectAbstractInput" id="projectAbstractInput" required>
                <div class="invalid-feedback">Abstract is required.</div>
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
</body>
</html>


<script>
  var quill = new Quill('#projectAbstract', {
    theme: 'snow',
    placeholder: 'Enter project abstract',
  });

  var projectAbstractInput = document.querySelector('#projectAbstractInput');

  quill.on('text-change', function() {
    projectAbstractInput.value = quill.root.innerHTML;
  });

  // Client-side form validation
  document.getElementById('addProjectForm').addEventListener('submit', function(event) {
    if (!this.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }
    this.classList.add('was-validated');
  });
  // Client-side form validation
document.getElementById('addProjectForm').addEventListener('submit', function(event) {
  var abstractInput = document.getElementById('projectAbstractInput');
  if (abstractInput.value.trim() === '') {
    event.preventDefault();
    abstractInput.classList.add('is-invalid');
  } else {
    abstractInput.classList.remove('is-invalid');
  }
});

</script>


<!-- Added JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Added JavaScript -->
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.css" />

<script>
$(document).ready(function() {
    $('#projectTechnology').tagsinput({
        trimValue: true,
        confirmKeys: [13, 44, 32],
        focusClass: 'my-focus-class'
    });

    $('.bootstrap-tagsinput input').on('focus', function() {
        $(this).closest('.bootstrap-tagsinput').addClass('has-focus');
    }).on('blur', function() {
        $(this).closest('.bootstrap-tagsinput').removeClass('has-focus');
    });
});
</script>


<!-- Added CSS -->
<style>
.label-info {
    display: inline-block;
    background-color: #636c72;
    padding: 0 .4em .15em;
    border-radius: .25rem;
    margin-bottom: 0.4em;
}

.input-group {
    width: 100%;
}

.input-group .input-group-text {
    background-color: #636c72;
    border-color: #636c72;
    color: white;
}

.input-group .input-group-text i {
    color: white;
}
</style>

<div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
<script>
    // Check if the toast message and status are not empty, then show the toast
    <?php if (!empty($_SESSION['toast_message']) && !empty($_SESSION['toast_status'])) { ?>
        $(document).ready(function() {
            var type = <?php echo ($_SESSION['toast_status'] == "success") ? "'success'" : "'danger'"; ?>;
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
</script>

<!-- JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>


<!-- JavaScript -->
<!-- JavaScript -->
<script>
  // Function to generate the PDF
  function generatePDF(button) {
    // Get the table row associated with the clicked button
    var row = button.parentNode.parentNode;

    // Get the cell values from the row
    var cells = row.getElementsByTagName('td');
    var rowData = [];
    for (var i = 0; i < cells.length - 1; i++) { // Exclude the last cell with the "View" button
      rowData.push(cells[i].innerText);
    }

    // Get the technology list from the rowData
    var technologyList = rowData[3].split(',');

    // Format the technology list with dot line breaks
    var formattedTechnologyList = technologyList.map(function (technology) {
      return '\u2022 ' + technology.trim(); // Add dot and remove leading/trailing whitespace
    }).join('\n');

    // Define the document definition for pdfmake
    var docDefinition = {
      pageSize: 'A4',
      pageOrientation: 'portrait',
      content: [
        {
          text: rowData[1],
          style: 'title',
          alignment: 'center',
          margin: [0, 20, 0, 10]
        },
        {
          text: 'Abstract:',
          style: 'subheader',
          margin: [0, 20, 0, 10]
        },
        {
          text: rowData[2],
          style: 'content',
          margin: [0, 0, 0, 10]
        },
        {
          text: 'Technology:',
          style: 'subheader',
          margin: [0, 10, 0, 5]
        },
        {
          text: formattedTechnologyList,
          style: 'content',
          margin: [20, 0, 0, 10]
        },
        {
          text: 'Status:',
          style: 'subheader',
          margin: [0, 10, 0, 5]
        },
        {
          text: rowData[5],
          style: 'content',
          margin: [20, 0, 0, 10]
        },
        {
          text: 'Duration:',
          style: 'subheader',
          margin: [0, 10, 0, 5]
        },
        {
          text: rowData[6],
          style: 'content',
          margin: [20, 0, 0, 10]
        }
      ],
      styles: {
        header: {
          fontSize: 24,
          bold: true,
          margin: [0, 0, 0, 20]
        },
        title: {
          fontSize: 18,
          bold: true
        },
        subheader: {
          fontSize: 14,
          bold: true,
          margin: [0, 5]
        },
        content: {
          fontSize: 12,
          margin: [0, 5]
        }
      }
    };

    // Generate the PDF
    pdfMake.createPdf(docDefinition).open();
  }
</script>

