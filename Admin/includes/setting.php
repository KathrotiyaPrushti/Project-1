<?php
session_start();
// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/notification.css">

  <?php include_once "sidebar.php"?>
  <?php include_once "dbconnect.php"?>

</head>
<style> 
.px-4 {
  padding-right: 1.5rem !important;
  padding-left: 1.5rem !important;
  padding-top: 1.5rem;
}
</style>
<body>
<?php
// Check if the connection was successful
if ($connection->connect_error) {
    die("Database connection failed: " . $connection->connect_error);
}

// Define variable for the new password
$newPassword = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve new password from the form
    $newPassword = $_POST["newPassword"];

    // Encrypt the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    try {
        $sessionId = $_SESSION['user_id']; // Assuming you have a user ID in the session
        $updateQuery = "UPDATE faculty SET Password = ? WHERE id = ?";
        $updateStatement = $connection->prepare($updateQuery);
        $updateStatement->bind_param("ss", $hashedPassword, $sessionId);
        $updateStatement->execute();
        $updateStatement->close();

        // Set toast message and status
        $toastMessage = "Password updated successfully.";
        $toastStatus = 1; // 1 for success, 0 for failure
    } catch (Exception $e) {
        die("Failed to update password: " . $e->getMessage());
        // Set toast message and status
        $toastMessage = "Failed to update password.";
        $toastStatus = 0; // 1 for success, 0 for failure
    }
}

// Close the connection
$connection->close();
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="card border-primary">
                <div class="card-body">
                    <h2 class="card-title"> <i class="bi bi-gear"></i> Change Password</h2>
                    <br>
                    <form method="POST" action="" id="passwordForm" novalidate>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="newPassword">New Password:</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password" required>
                                <div class="invalid-feedback">Please enter a new password.</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirmPassword">Confirm Password:</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password" required>
                                <div class="invalid-feedback invalid-confirm">Please enter the confirm password.</div>
                                <div class="invalid-feedback invalid-match">Passwords do not match.</div>
                            </div>
                        </div>
                      
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include_once "footer.php"?>
</div>

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

    function getIconClassByType(type) {
        if (type === "success") {
            return "bi bi-check-circle-fill";
        } else {
            return "bi bi-exclamation-circle-fill";
        }
    }
</script>


<script>
    document.getElementById("passwordForm").addEventListener("submit", function(event) {
        var newPasswordInput = document.getElementById("newPassword");
        var confirmPasswordInput = document.getElementById("confirmPassword");
        var invalidConfirmError = document.querySelector(".invalid-confirm");
        var invalidMatchError = document.querySelector(".invalid-match");

        // Reset error messages and invalid classes
        invalidConfirmError.style.display = "none";
        invalidMatchError.style.display = "none";
        confirmPasswordInput.classList.remove("is-invalid");

        // Check if form is valid
        if (!this.checkValidity()) {
            event.preventDefault(); // Prevent form submission if invalid
            event.stopPropagation();
        } else {
            // Check if confirm password field is empty
            if (confirmPasswordInput.value.trim() === '') {
                event.preventDefault(); // Prevent form submission
                invalidConfirmError.style.display = "block";
                confirmPasswordInput.classList.add("is-invalid");
            } else if (newPasswordInput.value !== confirmPasswordInput.value) {
                event.preventDefault(); // Prevent form submission
                invalidMatchError.style.display = "block";
                confirmPasswordInput.classList.add("is-invalid");
            }
        }

        this.classList.add("was-validated");
    });

    // Reset validation when changing the new password or confirm password
    document.getElementById("newPassword").addEventListener("input", resetValidation);
    document.getElementById("confirmPassword").addEventListener("input", resetValidation);

    function resetValidation() {
        var confirmPasswordInput = document.getElementById("confirmPassword");
        var invalidConfirmError = document.querySelector(".invalid-confirm");
        var invalidMatchError = document.querySelector(".invalid-match");

        invalidConfirmError.style.display = "none";
        invalidMatchError.style.display = "none";
        confirmPasswordInput.classList.remove("is-invalid");
    }
</script>
