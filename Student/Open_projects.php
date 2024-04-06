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
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Open Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />

    <link href="./Student_css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        tbody td button {
            background-color: #005366;
            /* Green */
            border: none;
            color: white;
            padding: 5px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="./dashboard_student.php">KDPIT Projects</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="./dashboard_student.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Open Projects</h1>
                    <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol> -->
                    <!-- <div class="card mb-4">
                            <div class="card-body">
                                DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
                                <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                                .
                            </div>
                        </div> -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Example
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
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
                                <tfoot>
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
                                </tfoot>
                                <tbody class="actionbtn">
                                    <?php
                                    $query = "SELECT * FROM `openproject`";
                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                        $projects = array();
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $projects[] = $row;
                                        }
                                    } else {
                                        // Handle the case when the query fails
                                        $projects = array(); // Empty array if no projects are found
                                    }
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
                                            <td id='no'>
                                                <?php echo $rowNumber; ?>
                                            </td>
                                            <td id='p_name'>
                                                <?php echo $projectName; ?>
                                            </td>
                                            <td id='projectAbstract'>
                                                <?php echo $projectAbstract; ?>
                                            </td>
                                            <td id='techonlogy'>
                                                <?php echo $projectTechnology; ?>
                                            </td>
                                            <td id='no_of_members'>
                                                <?php echo $projectMembers; ?>
                                            </td>
                                            <td id='status'>
                                                <?php echo $projectStatus; ?>
                                            </td>
                                            <td id='duration'>
                                                <?php echo $projectDuration; ?>
                                            </td>
                                            <td><button onclick="apply_project(this)">Apply</button></td>
                                            <td><button onclick="generatePDF(this)">View</button></td>
                                            <?php
                                    } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            // Simple-DataTables
            // https://github.com/fiduswriter/Simple-DataTables/wiki

            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

    </script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {

            // Toggle the side navigation
            const sidebarToggle = document.body.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                // Uncomment Below to persist sidebar toggle between refreshes
                // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
                //     document.body.classList.toggle('sb-sidenav-toggled');
                // }
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
                });
            }

        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <!-- <script src="js/scripts.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <!-- <script src="js/datatables-simple-demo.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>

    <script>

        function apply_project(button) {
            // var row = button.parentNode.parentNode;
            console.log("apply");
            var project_id = '<?php echo $projectId ?>';
            // Get the cell values from the row
            // var cells = row.getElementsByTagName('td');
            var data = {
                // p_name: cells[1].textContent,
                // techonlogy: cells[3].textContent
                project_id: project_id
            }; // Create an empty object to store the values

            // for (var i = 0; i < cells.length; i++) {
            //     var cellId = cells[i].textContent;
            //     console.log(cellId);
            //     // var cellValue = cells[i].textContent;
            //     // data[cellId] = cellValue; // Store the value in the object using the ID as the key
            // }

            // Send the data to the PHP file via AJAX
            // console.log(data);
            $.ajax({
                url: './Loading/open_project_apply.php',
                method: 'POST',
                data: data,
                success: function (response) {
                    console.log('Data sent successfully to PHP file');
                    console.log(response); // Optional: Handle the response from the PHP file
                },
                error: function (xhr, status, error) {
                    console.log('Error sending data to PHP file');
                    console.log(error); // Optional: Handle the error
                }
            });
        }
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


</body>

</html>