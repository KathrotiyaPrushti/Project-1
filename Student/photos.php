<?php
    require './Loading/databaseconnect.php';
    session_start();
?>
<?php
    if(!isset($_SESSION['collage_id'])){
        header("location:../index.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Photos</title>
    <!-- <link rel="stylesheet" href="./Student_css/photo.css"> -->
    <link rel="stylesheet" href="./Student_css/photo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Existing CSS code... */

        /* Add your additional CSS code here... */
        .search-bar {
            transition: width 0.3s ease;
        }

        .search-bar.closed {
            width: 90%;
        }
        .add_photo{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* /* display: flex; */
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .image-container {
            width: 200px;
            height: 300px;
            margin: 10px;
            overflow: hidden;
        }
        #add-photo-content {
            /* background-color: red; */
            width: 300px;
            border: 1px solid transparent;
            border-radius: 10px;
            background-color: #f0f0f0;
            padding: 20px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        #type{
            /* margin-right: 20px; */
            border: none;
            background: #6f6e6e;
            width: 250px;
            padding: 5px 0px;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: background .2s ease-in-out;
        }
        input[type=file]::file-selector-button {
            margin-top: 5px;
            margin-right: 20px;
            border: none;
            background: #6f6e6e;
            padding: 10px 20px;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: background .2s ease-in-out;
        }

        input[type=file]::file-selector-button:hover {
            background-color: #858585;
        }
        #submit {
            background-color: #6f6e6e;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 5px 0px;
            cursor: pointer;
            border-radius: 10px;
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
                <li><a href="javascript:void(0)" id="add-photo">
                        <i class="uil uil-plus-circle"></i>
                        <span class="link-name">Add Photos</span>
                    </a></li>
                <li><a href="./dashboard_student.php">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dashboard</span>
                    </a></li>
                <li><a href="./Reports.php">
                        <i class="uil uil-file"></i>
                        <span class="link-name">Daily Report</span>
                    </a></li>
                <li><a href="./weekly_report.php" id="weekly">
                        <i class="uil uil-window"></i>
                        <span class="link-name">Weekly Report</span>
                    </a></li>
                <li><a href="./Student/Loading/photos.php">
                        <i class="uil uil-image-v"></i>
                        <span class="link-name">Photos</span>
                    </a></li>
            </ul>
            <ul class="logout-mod">
                <li><a href="../Logout.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                    </a></li>
            </ul>
        </div>
    </nav>

    <!-- <div class="toggle-button open" id="toggle-sidebar"></div> -->
    <main>
        <div class="head-container">
            <div class="category">
                <div><a class="category-button" href="#">All Category</a></div>
                <div><a class="category-button" href="#">Flowchart</a></div>
                <div><a class="category-button" href="#">Web Pages</a></div>
                <!-- <div><a class="category-button" href="#">Login Page</a></div>
                <div><a class="category-button" href="#">Home Page</a></div>
                <div><a class="category-button" href="#">Others</a></div> -->
            </div>
            <div class="search-bar" id="search-bar">
                <span class="material-symbols-outlined search-icon"></span>
                <label for="search-photo"></label>
                <input type="search" id="search-photo" placeholder="Search Photo">
            </div>
        </div>
        <div class="photo-gallery" id="photo-gallery">
            <?php
                $sql ="SELECT * FROM `image` WHERE `Group_id`='".$_SESSION['group']."'";
                $img = mysqli_query($conn,$sql);

                while($obj = mysqli_fetch_assoc($img))
                {
            ?>
        <div class="image-container">
            <img src="diplay_images.php?id=<?php echo $obj['id']; ?>" alt="image<?php echo $obj['id']; ?>" data-title="<?php echo $obj['type']; ?>" data-description="<?php echo $obj['Collage_id']; ?>" />
        </div>
        <?php
            }
        ?>
        </div>
          
          <div id="popup" class="popup">
            <div class="popup-content">
              <div class="popup-header">
                <h2 id="popup-title"></h2>
                <button class="popup-close"><i class="fas fa-times"></i></button>
              </div>
              <img id="popup-image" alt="Popup Image" />
              <p id="popup-description"></p>
            </div>
          </div>
          
          <div id="add-photo" class="add_photo" style="display:none;">
            <div id="add-photo-content">
                <button class="popup-close" id="popup-close"><i class="fas fa-times"></i></button>
                <form action="javascript:void(0)" id="photo-add-form" method="POST" enctype= "multipart/form-data" >
                
                    <select name="type" id="type" class="type">
                        <option value="other">Other</option>
                        <option value="Flowchart">Flowchart</option>
                        <option value="Web_Pages">Web pages</option>
                    </select>

                    <input type="file" name="my_image" id="my_image" class="my_image">
                    <button type="submit" name="submit" id ="submit">Add</button>
                </form>
            </div>
          </div>
          <script>
            // Get references to the popup elements
            const popup = document.getElementById('popup');
            const popupTitle = document.getElementById('popup-title');
            const popupImage = document.getElementById('popup-image');
            const popupDescription = document.getElementById('popup-description');
        
            // Add click event listeners to the images
            const images = document.querySelectorAll('.photo-gallery img');
            images.forEach(image => {
              image.addEventListener('click', () => {
                // Set the popup content based on the clicked image's data attributes
                const title = image.getAttribute('data-title');
                const description = image.getAttribute('data-description');
                const imageUrl = image.getAttribute('src');
                popupTitle.textContent = title;
                popupImage.src = imageUrl;
                popupDescription.textContent = description;
        
                // Show the popup by adding the 'open' class
                popup.classList.add('open');
              });
            });
        
           // Close the popup when clicking outside the content area or on the close button
            popup.addEventListener('click', event => {
            if (event.target === popup || event.target.closest('.popup-close')) {
                // Hide the popup by removing the 'open' class
                popup.classList.remove('open');
            }
            });
          </script>
          
          <script>
            $(function () {
                $('#add-photo').on('click',function(event){
                    $('.add_photo').show();
                })

                $('#popup-close').on('click',function(event){
                    $('.add_photo').hide();
                })
                $('#photo-add-form').on('submit',function(event){
                    const fileInput = $("#my_image")[0];
                    const file = fileInput.files[0];
                    const type = $('#type').val();
                
                    if (file) {
                        const formData = new FormData();
                        formData.append('imageFile', file);
                        formData.append('type', type);
                        // Send the image data to the PHP file using AJAX
                        $.ajax({
                            url: 'Loading/image_upload.php',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                console.log(response);// Display the response message
                                // $("#photo-gallery").load();
                                alert(response);
                            },
                            error: function(xhr, status, error) {
                                console.error(error); // Handle errors here
                            }
                        });
                        $('.add_photo').hide();
                        $('#photo-add-form')[0].reset();
                    }
                
                });
            });
          </script>
          
    </main>
    <!-- <script>
      const sidebar = document.querySelector('nav');
      const toggleButton = document.querySelector('#toggle-sidebar');
      const headContainer = document.querySelector('.head-container');
      const content = document.querySelector('.photo-gallery');
      const searchContainer = document.querySelector('.search-bar');

      toggleButton.addEventListener('click', () => {
          sidebar.classList.toggle('open');
          toggleButton.classList.toggle('open');

          // Toggle the sidebar's position based on the open class
          if (sidebar.classList.contains('open')) {
              headContainer.style.marginLeft = "280px";
              content.style.marginLeft = "280px";
              searchContainer.style.width = "150px";
          } else {
              headContainer.style.marginLeft = "50px";
              content.style.marginLeft = "50px";
              searchContainer.style.width = "200px";
          }
      });
    </script> -->
</body>
</html>
