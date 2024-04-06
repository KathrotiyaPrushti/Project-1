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
    <?php include "dbconnect.php"?>
    <div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Users Details</h1>
            <br>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Users 
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>

                            </tr>
                        </tfoot>
                        <?php
    // Assuming you have a MySQLi connection named $mysqli established
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "Project_reports";

    // Create a new MySQLi instance
    $mysqli = new mysqli($host, $dbUsername, $dbPassword, $database);
    // Get the sessionId from the URL parameter
    $sessionId = $_SESSION['user_id'];

    // Fetch unique records from the projects table based on the sessionId and status
    $projectsQuery = "SELECT DISTINCT * FROM projects WHERE f_id = $sessionId AND status = 1";
    $projectsResult = $mysqli->query($projectsQuery);

    if ($projectsResult) {
        $rowCounter = 1; // Initialize the row counter
        $uniqueData = array(); // Array to store unique username and email combinations

        while ($projectRow = $projectsResult->fetch_assoc()) {
            $projectId = $projectRow['id'];

            // Fetch unique records from the members table based on the projectId
            $membersQuery = "SELECT DISTINCT * FROM members WHERE project_id = $projectId";
            $membersResult = $mysqli->query($membersQuery);

            if ($membersResult) {
                while ($memberRow = $membersResult->fetch_assoc()) {
                    $memberId = $memberRow['member_id'];

                    // Fetch unique records from the student table based on the memberId
                    $studentQuery = "SELECT DISTINCT * FROM student WHERE Collage_id = '".$memberId."'";
                    $studentResult = $mysqli->query($studentQuery);

                    if ($studentResult && $studentRow = $studentResult->fetch_assoc()) {
                        $name = $studentRow['First_name'];
                        $email = $studentRow['Email'];

                        // Check if the username and email combination is unique or not
                        $isUnique = true;
                        $projectNames = ""; // Variable to store project names

                        foreach ($uniqueData as $data) {
                            if ($data['name'] === $name && $data['email'] === $email) {
                                $isUnique = false;
                            }
                        }

                        if ($isUnique) {
                            // Store the unique username, email, and project name combination in the array
                            $uniqueData[] = array('name' => $name, 'email' => $email);

                            // Display the data in the HTML table
                            ?>
                            <tr>
                                <td><?php echo $rowCounter; ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo $email; ?></td>
                            </tr>
                            <?php

                            $rowCounter++; // Increment the row counter
                        }
                    }
                }
                $membersResult->free();
            }
        }
        $projectsResult->free();
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