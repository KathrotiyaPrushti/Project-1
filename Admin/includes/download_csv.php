<?php
// Include your database connection file
include "dbconnect.php";

// Check if the connection is successful
if (!$connection) {
  // If connection fails, return an error message
  die ("Connection failed: " . mysqli_connect_error());
}

// Query to fetch data
$query = "SELECT 
            s.Id AS Student_Id,
            s.Collage_id AS College_Id,
            s.First_name AS First_Name,
            s.Last_name AS Last_Name,
            s.Email AS Email,
            p.project_name AS Project_Name,
            p.Description AS Project_Description,
            f.Name AS Faculty_Name,
            f.Email AS Faculty_Email,
            o.projectTechnology AS Project_Technology,
            o.projectMembers AS Project_Members,
            o.projectStatus AS Project_Status,
            o.projectDuration AS Project_Duration,
            o.projectAbstract AS Project_Abstract,
            o.technologyKeywords AS Technology_Keywords
          FROM 
            student s
          INNER JOIN 
            members m ON s.Collage_id = m.member_id
          INNER JOIN 
            projects p ON m.project_id = p.id
          INNER JOIN 
            openproject o ON p.open_project_id = o.id
          INNER JOIN 
            faculty f ON p.f_id = f.id";

$result = mysqli_query($connection, $query);

// Check if the query was successful
if (!$result) {
  // If query fails, return an error message
  die ("Query failed: " . mysqli_error($connection));
}

// Set the CSV headers
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

// Open the output stream
$output = fopen('php://output', 'w');

// Write the headers to the CSV file
fputcsv(
  $output,
  array(
    'Student_Id',
    'College_Id',
    'First_Name',
    'Last_Name',
    'Email',
    'Project_Name',
    'Project_Description',
    'Faculty_Name',
    'Faculty_Email',
    'Project_Technology',
    'Project_Members',
    'Project_Status',
    'Project_Duration',
    'Project_Abstract',
    'Technology_Keywords'
  )
);

// Loop through the query results and write each row to the CSV file
while ($row = mysqli_fetch_assoc($result)) {
  fputcsv($output, $row);
}

// Close the output stream
fclose($output);

// Exit the script
exit();
?>