
  <!-- Include the Bootstrap CSS CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<?php include_once "sidebar.php"?>
<body>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Activity Log</h1>
            <br>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Activity Log
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>ip address</th>
                                <th>url</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>ip address</th>
                                <th>url</th>
                                <th>Date</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        include "dbconnect.php";
                        include "cookie.php";

                        // Get the session ID or replace it with your actual session ID retrieval logic

                        $sessionId = $_SESSION['user_id'];

                        // Fetch the username from the users table based on the session ID
                        $query = "SELECT username FROM users WHERE id = '$sessionId'";
                        $result = mysqli_query($connection, $query);
                        $username = "";
                        if ($row = mysqli_fetch_assoc($result)) {
                            $username = $row['username'];
                        }

                        // Assuming you have a database connection, you can fetch data dynamically and populate the table rows
                        $query = "SELECT * FROM cookies WHERE userid = '$sessionId' ORDER BY date DESC";
                        $results = mysqli_query($connection, $query);

                        if (mysqli_num_rows($results) > 0) {
                            while ($row = mysqli_fetch_assoc($results)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $username . "</td>"; // Display the username here
                                echo "<td>" . $row['ip_address'] . "</td>";
                                echo "<td>" . $row['page_url'] . "</td>";
                                echo "<td>" . $row['date'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr>";
                            echo "<td colspan='6'>No data found.</td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
