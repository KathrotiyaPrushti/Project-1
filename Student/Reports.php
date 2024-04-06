<!DOCTYPE html>
<html lang="en">
<?php
require 'Loading/databaseconnect.php';
session_start();
?>
<?php
    if(!isset($_SESSION['collage_id'])){
        header("location:../index.php");
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Student_css/daily_cardt.css">
    <link rel="stylesheet" href="Student_css/Card_Form.css">
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> -->
    <script src="Js/Report_dashboard.js"></script>
    <!-- <script src="Js/report_edit.js"></script> -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="./Student_css/sidebardtest.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&family=Roboto+Slab:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            transition: filter 0.5s;
        }

        /* #add-notes {
            cursor: pointer;
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border-radius: 15px;
        }
        
        #add-notes:hover {
            background-color: #333;
            color: #fff;
        } */

        .add_search {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color: #f2f2f2;
            width: 95%;
            margin: 2%;
            border-radius: 10px;
        }

        .add_search .button {
            order: 1;
            /* Place the button as the first item */
        }

        .add_search input[type="search"],
        .add_search input[type="date"] {
            flex-grow: 1;
            margin-left: 10px;
        }

        .add_search input[type="search"] {
            border: none;
            border-radius: 5px;
            padding: 5px;
            outline: none;
        }

        .add_search input[type="date"] {
            border: none;
            padding: 5px;
            outline: none;
        }

        #nav_dash {
            top: 0;
            left: 0;
            right: 0;
            /* background-color: #fff; */
            /* z-index: 999; */
        }

        #note-full-container {
            margin-top: 30px;
            /* border-radius: 10px; Add border-radius property to create curved borders
            border: 1px solid #ccc;  */
            /* margin-bottom:10px Adjust the top margin value to create space for the fixed navigation bar and add-group */
            height: calc(90vh - 50px);
            overflow-y: auto;
        }

        #note-full-container::-webkit-scrollbar {
            display: none;
            /* Hide the scrollbar for Chrome and Safari */
        }

        body {
            overflow: hidden;
            margin-top: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <nav class="open"> <!-- Added the "open" class to the nav element -->
        <div class="logo-name">
            <div class="logo-image">
                <img src="./images/Logo_side.png" alt="logo">
            </div>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="javascript:void(0)" id="add-notes">
                        <i class="uil uil-plus-circle"></i>
                        <span class="link-name">Insert</span>
                    </a></li>
                <li><a href="./dashboard_student.php">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dashboard</span>
                    </a></li>
                <li><a href="./Reports.php">
                        <i class="uil uil-file"></i>
                        <span class="link-name">Daily Report</span>
                    </a></li>
                <li><a href="javascript:void(0)" id="weekly">
                        <i class="uil uil-window"></i>
                        <span class="link-name">Weekly Report</span>
                    </a></li>
                <li><a href="photos.php">
                        <i class="uil uil-image-v"></i>
                        <span class="link-name">Photos</span>
                    </a></li>
            </ul>
            <ul class="logout-mod">
            
                <li><a href="../Logout.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                    </a></li>
                    <li><h4 style="color: #f2f2f2; margin-left:15px;">Loged in as : <?php echo $_SESSION['collage_id']?></h4></li>
            </ul>
        </div>
    </nav>
    <div class="toggle-button open" id="toggle-sidebar"></div> 

    <div class="main_page" id="main_page">
        <div class="add_search">
            <!-- <div class="button" id="btn">
                <a href="javascript:void(0)" id="add-notes" style="font-size: 24px;font-weight:400; padding:5px"><i class="uil uil-plus-circle" ></i>ADD</a>
            </div> -->
            <div>
                <input type="search" name="name_search" id="name_search" placeholder="name">
                <input type="date" name="date_fil" id="date_fil">
            </div>
        </div>
        <div id="note-full-container">
        </div>

        <!-- pop for daily Report -->
        <div class="modal fade" id="addnotesmodal" tabindex="-1" role="dialog" aria-labelledby="addnotesmodalTitle" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title text-white">Add Notes</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="notes-box">
                            <div class="notes-content">
                                <form action="javascript:void(0);" id="addnotesmodalTitle">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="note-title">
                                                <input type="text" id="note-has-title" class="form-control" minlength="25" name="title" placeholder="Title"  required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="note-description">
                                                <!-- <label>Note Description</label> -->
                                                <textarea id="note-has-description" class="form-control" minlength="60" name="Desc" placeholder="Description" rows="3"  required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button name="add-btn" id="btn-n-add" class="btn btn-info" disabled="disabled">Add</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- POP UP FOR Weekly Report -->
        <div class="Week fade" id="addnotesmodal" tabindex="-1" role="dialog" aria-labelledby="addnotesmodalTitle" style="display: none;" aria-hidden="true">
            <div class="weekly-dialog modal-dialog-centered" role="document">
                <div class="weekly-content border-0">
                    <div class="weekly-header bg-info text-white">
                        <h5 class="weekly-title text-white">Add Weekly Report</h5>
                        <button type="button" class="close text-white" data-dismiss="weeky" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="weekly-body">
                        <div class="notes-box">
                            <div class="notes-content">
                                <form action="javascript:void(0);" id="addweeklyreport">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="weekly-title">
                                                <!-- <label>Note Title</label> -->
                                                <input type="text" 
                                                id = "weekly-has-title" 
                                                name="weekly-has-title" class="form-control" minlength="25" placeholder="Week's Agenda"  required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="individual_work">
                                                <!-- <label>Note Description</label> -->
                                                <?php
                                                $s2 = "SELECT * FROM `members` WHERE `project_id`= '" . $_SESSION['group'] . "'";
                                                $r2 = mysqli_query($conn, $s2);
                                                $no_of_m = mysqli_num_rows($r2);
                                                $c = 0;
                                                while ($no_of_m != $c) {
                                                    $obj1 = mysqli_fetch_assoc($r2);
                                                    $s3 = " SELECT * from `student` WHERE `Collage_id` = '" . $obj1['member_id'] . "'";
                                                    $r3 = mysqli_query($conn, $s3);
                                                    $obj2 = mysqli_fetch_assoc($r3);
                                                ?>

                                                    <textarea id="individual<?php echo $obj1['member_id'] ?>" class="form-control" minlength="60" name="individual_work" placeholder="<?php echo $obj2['Collage_id'] ?>" rows="2"></textarea  required>

                                                <?php
                                                    $c = $c + 1;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="next_weekly">
                                                <!-- <label>Note Description</label> -->
                                                <textarea id="future_work" class="form-control" minlength="60" name="Desc" placeholder="Future work" rows="3"  required></textarea>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button name="add-btn" id="btn-n-ad" class="btn btn-info" disabled="disabled">Add</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const sidebar = document.querySelector('nav');
            const toggleButton = document.querySelector('#toggle-sidebar');
            // const main_div = document.getElementById('#main_page');

            toggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                toggleButton.classList.toggle('open');
                // Toggle the sidebar's position based on the open class
                if (sidebar.classList.contains('open')) {
                    sidebar.style.left = '0';
                    document.getElementById('main_page').style.marginLeft = "280px";
                } else {
                    sidebar.style.left = '-300px';
                    document.getElementById('main_page').style.marginLeft = "50px";
                }
            });
        </script>
</html>