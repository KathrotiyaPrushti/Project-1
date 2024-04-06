<?php
// session_start();
// Check if the user is not logged in
if (!isset ($_SESSION['user_id'])) {
  // Redirect the user to the login page
  header("Location: ../../index.php");
  exit();
}
?>
<?php include "dbconnect.php" ?>


<div id="preloader">
  <!-- Preloader content goes here -->
  <div class="preloader-content">
    <!-- Your preloader content -->
    <div class="spinner"></div>
    <p>Loading...</p>
  </div>
</div>


<!DOCTYPE html>
<html lang="en">
<div id="toast" class="offline-toast">You are offline</div>
<style>
  #toast {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    padding: 12px 20px;
    border-radius: 6px;
    background-color: #333;
    color: #fff;
    font-size: 14px;
    display: none;
    z-index: 999;
  }

  .online-toast {
    background-color: #28a745;
  }

  .offline-toast {
    background-color: #dc3545;
  }




  #preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #ffffff;
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .preloader-content {
    text-align: center;
  }

  .hidden {
    display: none;
  }

  .spinner {
    width: 100px;
    /* Increased size */
    height: 100px;
    /* Increased size */
    border-radius: 50%;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #3498db;
    animation: spin 1s linear infinite;
    margin-bottom: 20px;
    /* Increased spacing */
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .loading-text {
    font-size: 24px;
    /* Increased font size */
    color: #333333;
    animation: blink 1s infinite;
    margin-bottom: 10px;
  }

  .sb-nav-fixed #layoutSidenav #layoutSidenav_nav .sb-sidenav .sb-sidenav-menu {
    overflow-y: scroll;
  }
</style>

<head>

  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>
    Admin Panel
  </title>
  <link rel="icon" type="image/x-icon" href="assets/images/charusat_symbol.jpg">

  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>


<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="dashboard.php">Admin Panel</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
        class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
      <div class="input-group">
        <input class="form-control" type="text" id="searchInput" placeholder="Search for..." aria-label="Search for..."
          aria-describedby="btnNavbarSearch" />
        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
      </div>
    </form>

    <!-- Notification Dropdown -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 ml-auto">


      <!-- Profile Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          <img src="https://cdn-icons-png.flaticon.com/512/6596/6596121.png" class="profile-photo" alt="Profile Photo">
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#!"><i class="fas fa-user fa-fw"></i> Administrator</a></li>
          <li><a class="dropdown-item" href="setting.php"><i class="fas fa-key fa-fw"></i> Change Password</a></li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-fw"></i> Logout</a></li>
        </ul>
      </li>
    </ul>
  </nav>

  <style>
    .profile-photo {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      object-fit: cover;
    }
  </style>




  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="dashboard.php">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Dashboard
            </a>
            <div class="sb-sidenav-menu-heading">Interface</div>
            <a class="nav-link" href="openworld.php">
              <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
              Openworld
            </a>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
              aria-expanded="false" aria-controls="collapseLayouts">
              <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
              Projects
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <!-- <a class="nav-link" href="layout-static.html">
                                    <div class="sb-nav-link-icon"><i class="fas fa-file"></i></div>
                                    Add Project</a> -->

                <a class="nav-link" href="list_projects.php">
                  <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                  List Project
                </a>
              </nav>
            </div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
              aria-expanded="false" aria-controls="collapsePages">
              <div class="sb-nav-link-icon"><i class="fas fa-file"></i></div>
              Report
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <?php

            // Check if the connection was successful
            if ($connection->connect_errno) {
              echo "Failed to connect to MySQL: " . $connection->connect_error;
              exit();
            }

            // Get the session ID
            
            $sessionId = $_SESSION['user_id'];

            $query = "SELECT id, status FROM projects WHERE f_id = $sessionId";
            $result = $connection->query($query);
            ?>

            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                <a class="nav-link collapsed" href="daily.php" data-bs-toggle="collapse"
                  data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                  <div class="sb-nav-link-icon"><i class="fas fa-calendar-day"></i></div>
                  Daily
                  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                  data-bs-parent="#sidenavAccordionPages">
                  <nav class="sb-sidenav-menu-nested nav">
                    <?php
                    $projectPending = false;
                    $groupFound = false;

                    if ($result && $result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $groupId = $row['id'];
                        $status = $row['status'];

                        if ($status == 0) {
                          $projectPending = true;
                        } elseif ($status == 1) {
                          $randomNumber = mt_rand(); // Generate a random number
                          $timestamp = time(); // Get the current timestamp
                    
                          echo '<a class="nav-link" href="daily.php?XuTSGWHSYDSBWS4451544148356887248788=' . urlencode($groupId . $randomNumber . $timestamp) . '">';
                          echo '<div class="sb-nav-link-icon"><i class="fas fa-users"></i></div> Group ' . $groupId;
                          echo '</a>';
                          $groupFound = true;
                        }
                      }
                      $result->free();
                    }

                    if ($projectPending && !$groupFound) {
                      echo '<div class="sb-nav-link-icon"><i class="fas fa-clock-rotate-left"></i> Status is Pending</div>';
                    } elseif (!$groupFound) {
                      echo '<div class="sb-nav-link-icon"><i class="fas fa-exclamation-circle"></i> No group found</div>';
                    }
                    ?>
                  </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseWeekly"
                  aria-expanded="false" aria-controls="pagesCollapseWeekly">
                  <div class="sb-nav-link-icon"><i class="fas fa-calendar-week"></i></div>
                  Weekly
                  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="pagesCollapseWeekly" aria-labelledby="headingOne"
                  data-bs-parent="#sidenavAccordionPages">
                  <nav class="sb-sidenav-menu-nested nav">
                    <?php
                    // Re-run the query if needed
                    $result = $connection->query($query);

                    $projectPending = false;
                    $groupFound = false;

                    if ($result && $result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $groupId = $row['id'];
                        $status = $row['status'];

                        if ($status == 0) {
                          $projectPending = true;
                        } elseif ($status == 1) {
                          echo '<a class="nav-link" href="weekly.php?groupId=' . $groupId . '">';
                          echo '<div class="sb-nav-link-icon"><i class="fas fa-users"></i></div> Group ' . $groupId;
                          echo '</a>';
                          $groupFound = true;
                        }
                      }
                      $result->free();
                    }

                    if ($projectPending && !$groupFound) {
                      echo '<div class="sb-nav-link-icon"><i class="fas fa-clock-rotate-left"></i> Status is Pending</div>';
                    } elseif (!$groupFound) {
                      echo '<div class="sb-nav-link-icon"><i class="fas fa-exclamation-circle"></i> No group found</div>';
                    }
                    ?>
                  </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError"
                  aria-expanded="false" aria-controls="pagesCollapseError">
                  <div class="sb-nav-link-icon"><i class="fas fa-image"></i></div>
                  Photos
                  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                  data-bs-parent="#sidenavAccordionPages">
                  <nav class="sb-sidenav-menu-nested nav">
                    <?php
                    // Re-run the query if needed
                    $result = $connection->query($query);

                    $projectPending = false;
                    $groupFound = false;

                    if ($result && $result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $groupId = $row['id'];
                        $status = $row['status'];

                        if ($status == 0) {
                          $projectPending = true;
                        } elseif ($status == 1) {
                          echo '<a class="nav-link" href="photos.php?groupId=' . $groupId . '">';
                          echo '<div class="sb-nav-link-icon"><i class="fas fa-users"></i></div> Group ' . $groupId;
                          echo '</a>';
                          $groupFound = true;
                        }
                      }
                      $result->free();
                    }

                    if ($projectPending && !$groupFound) {
                      echo '<div class="sb-nav-link-icon"><i class="fas fa-clock-rotate-left"></i> Status is Pending</div>';
                    } elseif (!$groupFound) {
                      echo '<div class="sb-nav-link-icon"><i class="fas fa-exclamation-circle"></i> No group found</div>';
                    }
                    ?>
                  </nav>
                </div>
              </nav>
            </div>


            <div class="sb-sidenav-menu-heading">Addons</div>

            <a class="nav-link" id="user-link" href="users.php?user_id=<?php echo $sessionId; ?>">
              <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
              Users
            </a>

            <?php
            // Check if the current page is dashboard.php
            $current_page = basename($_SERVER['PHP_SELF']);
            if ($current_page === 'dashboard.php') {
              ?>
              <a class="nav-link" id="user-link" href="#" data-toggle="modal" data-target="#feedbackModal">
                <div class="sb-nav-link-icon"><i class="fas fa-message"></i></div>
                Feedback
              </a>
              <?php
            }
            ?>




          </div>
        </div>


        <?php
        // Assuming you have established a database connection
        
        // Query to fetch the username based on session id
        $userQuery = "SELECT Name FROM faculty WHERE id = $sessionId";
        $userResult = mysqli_query($connection, $userQuery);
        $userRow = mysqli_fetch_assoc($userResult);
        $username = $userRow['Name'];

        ?>
        <div class="sb-sidenav-footer">
          <div class="small">Logged in as:</div>
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <?php echo $username; ?> (faculty)
            </div>
            <div>
              <a href="logout.php" class="logout-icon" style="color: rgba(255, 255, 255, 0.5);">
                <i class="bi bi-box-arrow-right fs-4 logout-icon-hover" style="font-size: 24px;"></i>
              </a>
            </div>
          </div>
        </div>

        <style>
          .logout-icon-hover {
            color: rgba(255, 255, 255, 0.5);
            transition: color 0.3s ease;
          }

          .logout-icon-hover:hover {
            color: #fff;
          }
        </style>






      </nav>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
      crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>

<script>
  window.addEventListener('DOMContentLoaded', event => {
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
      if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        document.body.classList.add('sb-sidenav-toggled');
      }
      sidebarToggle.addEventListener('click', event => {
        event.preventDefault();
        document.body.classList.toggle('sb-sidenav-toggled');
        localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
      });
    }
  });


  // datatables 
  window.addEventListener('DOMContentLoaded', event => {
    const table = new simpleDatatables.DataTable("#datatablesSimple");

    // Add event listener for search input
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function () {
      table.search(this.value);
    });
  });


  // // Function to show toast notification
  // function showToast(message, type) {
  //   var toast = document.getElementById('toast');
  //   toast.innerText = message;

  //   if (navigator.onLine && type !== 'offline-toast') {
  //     toast.style.display = 'none'; // Hide the toast if online and not an offline-toast
  //   } else {
  //     toast.classList.remove('online-toast', 'offline-toast');
  //     toast.classList.add(type);
  //     toast.style.display = 'block';

  //     setTimeout(function() {
  //       toast.style.display = 'none';
  //     }, 3000); // Toast will be hidden after 3 seconds (3000 milliseconds)
  //   }
  // }

  // // Check online/offline status
  // function checkStatus() {
  //   if (navigator.onLine) {
  //     showToast('You are online', 'online-toast');
  //     if (window.location.href.includes('404.html')) {
  //       window.location.href = 'dashboard.php'; // Redirect to index.html if currently on 404.html
  //     }
  //   } else {
  //     showToast('', 'offline-toast');
  //     if (!window.location.href.includes('404.html')) {
  //       window.location.href = '404.html'; // Redirect to 404.html if currently not on 404.html
  //     }
  //   }
  // }

  // // Add event listener for online/offline events
  // window.addEventListener('online', checkStatus);
  // window.addEventListener('offline', checkStatus);

  // // Initial check on page load
  // checkStatus();



  // Function to show the preloader
  function showPreloader() {
    var preloader = document.getElementById('preloader');
    preloader.style.display = 'flex';
  }

  // Function to hide the preloader and show the main content
  function hidePreloader() {
    var preloader = document.getElementById('preloader');
    var mainContent = document.getElementById('main-content');
    preloader.style.display = 'none';
    mainContent.classList.remove('hidden');
  }

  // Show preloader when the page loads
  window.addEventListener('DOMContentLoaded', event => {
    showPreloader();

    // Simulate loading time
    setTimeout(function () {
      hidePreloader();
    }, 1000); // Preloader will be hidden after 2 seconds (2000 milliseconds)
  });


  // // JavaScript
  const userLink = document.getElementById("user-link");

  // Function to generate a random string
  function generateRandomString(length) {
    const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    let result = "";
    for (let i = 0; i < length; i++) {
      const randomIndex = Math.floor(Math.random() * characters.length);
      result += characters.charAt(randomIndex);
    }
    return result;
  }

  // Add an event listener to the userLink
  userLink.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent the default link behavior

    // Generate a random string for the user_id parameter
    const randomString = generateRandomString(20); // Specify the desired length of the random string here

    // Replace the user_id parameter with the random string
    const url = new URL(userLink.href);
    url.searchParams.set("user_id", randomString);

    // Replace the URL with the modified version
    history.replaceState(null, "", url.href);

    // Navigate to the modified URL
    window.location.href = url.href;
  });



</script>