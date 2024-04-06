
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background-image: url("https://c4.wallpaperflare.com/wallpaper/992/545/78/abstract-shapes-hd-wallpaper-preview.jpg");
      background-size: cover;
      background-position: center center;
      background-attachment: fixed;
      
    }

    .card {
      width: 480px;
      /* max-width: 100%; Ensure the card fits within the viewport */
      border: 2px solid #ddd;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.5s;
    }

    .card-header {
      background-color: #f8f9fa;
      border-bottom: none;
      border-radius: 8px 8px 0 0;
    }

    .card-body {
      padding: 30px;
    }

    .card-footer {
      background-color: #f8f9fa;
      border-top: none;
      border-radius: 0 0 8px 8px;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>

</head>

<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h3>Security Checkup</h3>
          </div>
          <div class="card-body">
          <?php
session_start(); // Start the session

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    // Redirect the user to a dashboard or home page
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $email = $_POST['email'];
    $verificationCode = $_POST['verification'];

    // Validate form inputs
    if (empty($email) || empty($verificationCode)) {
        // Display error message if email or verification code is empty
        echo '<script>alert("Please enter both email and verification code.");</script>';
    } else {
        // Process the verification logic here (e.g., check if the email and verification code match)
        // Replace the following lines with your database connection and query

        // Database connection parameters
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $database = "daily_report";

        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$database", $dbUsername, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the query
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND verification_code = ?");
        $stmt->execute([$email, $verificationCode]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Email and verification code match, redirect to signup.php
            header("Location: signup.php");
            exit();
        } else {
            // Display error message if email or verification code is incorrect
            echo '<script>alert("Email or verification code is incorrect.");</script>';
        }
    }
}
?>

<!-- HTML Form -->
<form method="POST">
    <div class="form-group">
        <label for="verification">E-mail:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
        </div>
    </div>
    <div class="form-group">
        <label for="verification">Verification Code:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" class="form-control" id="verification" name="verification" placeholder="Enter verification code">
        </div>
    </div>
    <!-- Info Alert -->
    <div class="alert alert-info alert-dismissible d-flex align-items-center fade show">
        <i class="bi-info-circle-fill"></i>
        <strong class="mx-2">Info!</strong> Please read the comments carefully.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Submit</button>
</form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
</body>

</html>
