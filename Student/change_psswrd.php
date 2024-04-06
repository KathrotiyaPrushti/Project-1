<!DOCTYPE html>
<?php
include "Loading/databaseconnect.php";
session_start();
?>
<?php
if (!isset ($_SESSION['collage_id'])) {
    header("location:../index.php");
}
?>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./Student_css/sidebardtest.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&family=Roboto+Slab:wght@100;200;300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    .container {
        margin-top: 30px;
        padding: 20px;
        margin-left: 270px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .invalid-feedback {
        color: #dc3545;
        display: none;
        margin-top: 5px;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .card {
        border: none;
    }

    .card-title {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .card-body {
        padding: 0;
    }

    /* Responsive styles */
    @media (max-width: 600px) {
        .container {
            padding: 10px;
        }
    }
</style>

<body>

    <nav class="open">
        <div class="logo-name">
            <div class="logo-image">
                <img src="./images/Logo_side.png" alt="logo">
            </div>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="javascript:void(0)" id="add_g">
                        <i class="uil uil-plus-circle"></i>
                        <span class="link-name">Create Group</span>
                    </a></li>
                <li><a href="./dashboard_student.php">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dashboard</span>
                    </a></li>
                <li><a href="./Open_projects.php">
                        <i class="uil uil-file"></i>
                        <span class="link-name">Open Projects</span>
                    </a></li>
            </ul>
            <ul class="logout-mod">
                <li><a href="../Logout.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                    </a></li>
            </ul>
        </div>
    </nav>
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="card border-primary">
                    <div class="card-body">
                        <h2 class="card-title"><i class="bi bi-gear"></i> Change Password</h2>
                        <form method="POST" action="javascript:void(0)" id="passwordForm" class="needs-validation"
                            novalidate>
                            <div class="form-group">
                                <label for="currentPassword">Current Password:</label>
                                <input type="password" class="form-control" id="currentPassword" name="currentPassword"
                                    placeholder="Enter new password" required>
                                <div class="invalid-feedback">Please enter a password.</div>
                            </div>
                            <div class="form-group">
                                <label for="newPassword">New Password:</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword"
                                    placeholder="Enter new password" required>
                                <div class="invalid-feedback">Please enter a new password.</div>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password:</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                    placeholder="Confirm new password" required>
                                <div class="invalid-feedback invalid-confirm">Please enter the confirm password.</div>
                                <div class="error">
                                    <p class="msg"></p>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Add the following JavaScript code to enable Bootstrap validation -->
    <script>
        // JavaScript to handle form submission and validation
        (function () {
            'use strict';
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation');

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        })();

        $(function () {

            // 



            $('#passwordForm').on('submit', function (event) {
                event.preventDefault();
                var pElement = document.querySelector(".error .msg");
                // pElement.textContent = "";
                var currentPassword = document.getElementById('currentPassword').value;
                console.log(currentPassword);
                var newPassword = document.getElementById('newPassword').value;
                var confirmPassword = document.getElementById('confirmPassword').value;
                console.log(newPassword);
                data = {
                    currentPassword: currentPassword,
                    newPassword: newPassword,
                    confirmPassword: confirmPassword
                }
                $.ajax({
                    url: './Loading/new_password_set.php',
                    type: 'POST',
                    data: data,
                    success: function (e) {
                        pElement.textContent = e;
                        console.log(e);
                    }
                })
            })
        })
    </script>

</body>

</html>