<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "project_reports";

    $conn = mysqli_connect($servername,$username,$password,$database);

    if(!$conn)
    {
        // echo "Connection was successfull";
        die("Cant connect to the database");
        // echo "bye";
    }

?>