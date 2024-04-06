<?php
require 'databaseconnect.php';
session_start();
if (isset ($_SESSION['Designation'])) {
  if ($_SESSION['Designation'] == 'student') {
    header("location:Student/dashboard_student.php");
  }
  // elseif($_SESSION['Designation'] == 'faculty'){
  //   header("location:Admin/includes/dashboard.php");
  // }
}
?>


<!DOCTYPE html>
<html>

<head>
  <title>Login Form</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      background-image: url('Assets/back.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      overflow-y: hidden;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-form {
      background-color: #cacaca;
      padding: 30px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 400px;
      /* Adjust the width as needed */
      margin: 0 auto;
      /* Center the form horizontally */
    }

    .login-form h2 {
      margin-top: 0;
      margin-bottom: 30px;
      color: #696f6d;
    }

    .login-form input {
      width: 89%;
      padding: 12px;
      margin-bottom: 20px;
      border: none;
      border-radius: 5px;
      background-color: #f2f2f2;
    }

    .login-form input:focus {
      outline: none;
      background-color: #e6e6e6;
    }

    .login-form button {
      width: 50%;
      padding: 12px;
      background-color: #696f6d;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .login-form button:hover {
      background-color: #4d5250;
    }

    label {
      position: relative;
      display: block;
      margin-bottom: 20px;
    }

    label i {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #888;
    }
  </style>
</head>

<body>
  <div class="container">
    <form class="login-form" action="Login.php" method="POST">
      <img src="Assets/L.png" alt="" id="img">
      <input type="text" id="Username" name="Username" placeholder="Username" required>
      <input type="password" id="Password" name="Password" placeholder="Password" required>
      <button type="submit" name="sign_in">Login</button>
    </form>
  </div>
</body>

</html>