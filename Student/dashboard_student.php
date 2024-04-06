<?php
require 'Loading/databaseconnect.php';
session_start();
?>
<?php
if (!isset ($_SESSION['collage_id'])) {
    header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="./Student_css/groupform.css">
    <link rel="stylesheet" href="./Student_css/searchbard.css">
    <link rel="stylesheet" href="./Student_css/groupload.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400&display=swap" rel="stylesheet"> -->
    <script src="./Js/groupd.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="./Student_css/sidebardtest.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&family=Roboto+Slab:wght@100;200;300;400;500&display=swap"
        rel="stylesheet">
</head>
<style>
    .container {
        width: 20%;
        height: auto;
        box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 5px 10px 0 rgba(0, 0, 0, 0.19);
        background-color: #fb771a;
        word-wrap: break-word;
        padding: 5px 10px;
        border-radius: 10px;
        z-index: 2;
        right: 315px;
        top: 165px;
        position: absolute;
    }


    .notification-bell {
        cursor: pointer;
        position: inherit;
        display: inline-block;
        font-size: 18px;
    }


    /* Style the notification badge */

    .notification-box {
        /* cursor: pointer; */
        position: absolute;
        top: 70px;
        /* Adjust the positioning as per your requirement */
        right: 35px;
        width: 250px;
        /* Adjust the width as per your requirement */
        background-color: #fb771a;
        border: 1px solid #ccc;
        border-radius: 7px;
        box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 12px 40px 0 rgba(0, 0, 0, 0.19);
        padding: 10px;
        /* display: none; */
        z-index: 2;
        overflow: hidden;
        overflow-y: scroll;

    }

    .msg {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }




    /* Add margin to body to account for the fixed elements */

    body {
        overflow: hidden;
        margin-top: 15px;
        margin-bottom: 20px;
    }
</style>

<body>
    <nav class="open"> <!-- Added the "open" class to the nav element -->
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
                <li><a href="change_psswrd.php">
                        <i class="uil uil-key-skeleton-alt"></i>
                        <span class="link-name">Change Password</span>
                    </a></li>
                <li><a href="../Logout.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                    </a></li>
                <li>
                    <h4 style="color: #f2f2f2;">Logged in as :
                        <?php echo $_SESSION['collage_id'] ?>
                    </h4>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Added the "open" class to the toggle button -->


    <div id="search-bar" class="Searchbar">
        <div class="toggle-button open" id="toggle-sidebar"></div>
        <div class="Search">
            <div class="addcontainer">

                <!-- <a href="javascript:void(0)" id="add_g" >Add</a> -->
                <a href="#" id="all">All</a>
                <a href="#" id="pending">Pending</a>
                <a href="#" id="approved">Approved</a>
                <a href="#" id="rejected">Rejected</a>
            </div>
        </div>

        <div id="notification">
            <div class="container" id="notification_detail" style="display:none">

            </div>
            <div class="notify">
                <div class="notification-bell" onclick="reloadContainer()">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="notification-box" id="notification-box" style="display:none;">
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var intervalID;

        function notificationhandler(event, data, projectId, name, date) {
            // event.stopPropagation();
            // event.preventDefault();
            // Handle the click event here
            // You can access the projectId and perform any necessary actions
            // var groupDiv = data.closest('.Group');
            const notificationData = document.getElementById('notify_content');
            const notification = notificationData.getAttribute('data-notification');

            console.log("Clicked on notify_content for project ID: " + projectId);
            clearInterval(intervalID);

            $.ajax({
                type: 'POST',
                data: {
                    id: projectId,
                    name: name,
                    date: date,
                    notify: notification
                },
                url: './Loading/notification_update.php',
                success: function (e) {
                    console.log("NOtification updated to seen !..");
                    $('#notification_detail').html(e);
                    reloadContainer();

                }

            })
            $('#notification_detail').show();
        }

        function startInterval() {
            intervalID = setInterval(function () {
                // Code to reload the container periodically
                reloadContainer();
            }, 5000); // Adjust the interval time as needed
        };

        function reloadContainer() {
            // Code to reload the container content
            startInterval()
            $.ajax({
                // type:'POST',
                url: './Loading/notification.php',
                success: function (e) {
                    $('#notification-box').html(e);
                }
            })
        };
    </script>


    <div id="groupload"></div>

    <script type="text/javascript">
        var intervalId; // Variable to hold the interval ID
        var tab = 'all'; // Variable to keep track of the active tab

        function loadGroups(status) {
            $.ajax({
                type: 'GET',
                url: 'Loading/groupload.php',
                data: {
                    status: status
                }, // Pass the status to the server
                success: function (response) {
                    $('#groupload').html(response);
                }

            });
        }

        $(function () {
            startGroupReload(tab); // Load the initial group data for the active tab

            // Function to start the interval for reloading groups
            function startGroupReload(status) {
                intervalId = setInterval(function () {
                    loadGroups(status);
                }, 500); // Adjust the interval duration as needed
            }

            // Click event for the group tabs
            $('#all').click(function (e) {
                e.preventDefault();
                tab = 'all';
                clearInterval(intervalId); // Clear the interval for other tabs
                startGroupReload('all');
            });

            $('#pending').click(function (e) {
                e.preventDefault();
                tab = 'pending';
                clearInterval(intervalId); // Clear the interval for other tabs
                startGroupReload('pending');
            });

            $('#approved').click(function (e) {
                e.preventDefault();
                tab = 'approved';
                clearInterval(intervalId); // Clear the interval for other tabs
                startGroupReload('approved');
            });

            $('#rejected').click(function (e) {
                e.preventDefault();
                tab = 'rejected';
                clearInterval(intervalId); // Clear the interval for other tabs
                startGroupReload('rejected');
            });
        });
    </script>
    <div class="popup" tabindex="-1" role="dialog" aria-labelledby="addgroup" aria-hidden="true" style="display:none">
        <div class="form-container" id="form">
            <form class="add_group" action="group_save.php" method="POST" id="add_group">
                <div class="close_btn">
                    <button type="button" class="close text-white" id="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="form-group">
                    <label for="Project_name">Enter group name:</label>
                    <input type="text" name="Project_name" id="Project_name" required>
                </div>

                <div class="form-group">
                    <label for="Members">Total Members:</label>
                    <input type="number" name="Members" id="Members" max="3" oninput="generateMember()" required>
                </div>

                <div id="memberFieldsContainer" class="member-fields"></div>
                <div id="description">
                    <textarea type="text" name="desc" cols="35" rows="5" placeholder="Project Description"
                        required></textarea>
                </div>
                <div id="faculty_selsect">
                    <select name="faculty_id" id="faculty_id">
                        <option value="none" selected disabled hidden>Select a Guide</option>
                        <?php
                        $fac = "SELECT * from `faculty`";
                        $all_facutly = mysqli_query($conn, $fac);

                        while ($row = mysqli_fetch_assoc($all_facutly)) {
                            ?>
                            <option value="<?php echo $row['id'] ?>">
                                <?php echo $row['Name'] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <label for="dateofbirth">Project End Date</label>
                <input type="date" name="end-date" id="end-date" required>

                <div class="create">
                    <button type="submit" id="form_sub" onclick=" ">Create</button>
                </div>

            </form>
        </div>
    </div>
    </div>
    <script>
        var project_id = 0;
        $(function () {
            $('#add_g').on('click', function (event) {
                $('.popup').show();
            });

            $('#close').on('click', function (event) {
                event.preventDefault();
                $('.popup').hide();
                // document.getElementById('#add_group').reset();
            });
            $('#add_group').on('submit', function (event) {
                // console.log("Bhavya");
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: 'Loading/group_save.php',
                    method: 'POST',
                    data: formData + '&p_id=' + project_id,
                    success: function (response) {
                        // Handle the response from the server
                        alert('Form submitted successfully!');
                        $('#add_group')[0].reset();
                    }
                });
                project_id = 0;
                $('.popup').hide();
            });

        });

        function editHandler(event, button, members, faculty) {
            event.stopPropagation(); // Stop the click event from propagating to parent elements
            // Add your edit functionality here
            // console.log("Edit clicked for project ID: " + projectId);

            var groupDiv = button.closest('.Group');
            project_id = groupDiv.querySelector('.Group_No h2').textContent;
            document.getElementById('Project_name').value = groupDiv.querySelector('.Title h2').textContent;
            // document.getElementById('desc').value = groupDiv.querySelector('.Description').textContent;
            document.getElementById('Members').value = members;
            generateMember();

            var member = groupDiv.getElementsByClassName('members_list');

            console.log(member);

            // member.forEach(function (e) {
            //     console.log(e);
            // })
            // for(let i=2 ; i<=member.length ; i++){
            //     console.log(member[i]);
            // }
            var i = 1;
            Array.from(member).forEach(element => {
                if (i != 1) {
                    document.getElementById('id' + (i)).value = element.id;
                    console.log(element.id);
                }
                i = i + 1;
            });
            // console.log(dropedown.value);
            $('.popup').show();
            // document.querySelector(".popup").classList.add("active");   
        }
        function deleteGroup(event, button) {
            event.stopPropagation();
            var groupDiv = button.closest('.Group');
            var project_id = groupDiv.querySelector('.Group_No h2').textContent;
            console.log(project_id);

            $.ajax({
                url: './Loading/delete_group.php',
                data: { id: project_id },
                method: 'POST',
                success: function (e) {
                    console.log('Group is deleted');
                    alert('Group is deleted');
                }
            });
        }
    </script>


    <script>
        const sidebar = document.querySelector('nav');
        const toggleButton = document.querySelector('#toggle-sidebar');
        // const main_div = document.getElementById('#main_page');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            toggleButton.classList.toggle('open');
            // Toggle the sidebar's position based on the open class
            if (sidebar.classList.contains('open')) {
                document.getElementById('groupload').style.marginLeft = "280px";
                document.getElementById('search-bar').style.marginLeft = "280px";
                document.getElementById('search-bar').style.width = "78%";
                sidebar.style.left = '0';
            } else {
                sidebar.style.left = '-300px';
                document.getElementById('groupload').style.marginLeft = "50px";
                document.getElementById('search-bar').style.marginLeft = "70px";
                document.getElementById('search-bar').style.width = "90%";
            }
        });
    </script>
</body>

</html>