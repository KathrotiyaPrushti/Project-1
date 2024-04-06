<?php
session_start();
require 'dbconnect.php';
// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header("Location: ../../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Include the Tailwind CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    /* Add custom styles for transform animation */
    .image-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 1rem;
    }

    .image-card {
      overflow: hidden;
      position: relative;
      border-radius: 0.5rem;
      box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .image-card img {
      transition: transform 0.3s ease;
    }

    .image-card:hover {
      transform: scale(1.1);
    }

    .modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.modal-close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    color: #fff;
    cursor: pointer;
    z-index: 999;
}

.modal-image {
    max-width: 90%;
    max-height: 90%;
    border-radius: 5px;
}

  </style>
</head>
<body>
<?php include_once "sidebar.php"?>
<div id="layoutSidenav_content">

<!-- Add jQuery library if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<main>
    <div class="container-fluid px-4">
        <div class="container mx-auto px-5 py-2 lg:px-32 lg:pt-12">
            <div class="flex items-center justify-center py-4 md:py-8 flex-wrap">
                <button type="button" class="btn btn-outline-primary btn-lg mr-3 mb-3 category-btn" data-category="all">All categories</button>
                <button type="button" class="btn btn-outline-dark btn-lg mr-3 mb-3 category-btn" data-category="flowchart">Flowchart</button>
                <button type="button" class="btn btn-outline-dark btn-lg mr-3 mb-3 category-btn" data-category="signup">Sign Up Page</button>
                <button type="button" class="btn btn-outline-dark btn-lg mr-3 mb-3 category-btn" data-category="login">Login Page</button>
                <button type="button" class="btn btn-outline-dark btn-lg mr-3 mb-3 category-btn" data-category="homescr">Home Page</button>
                <button type="button" class="btn btn-outline-dark btn-lg mr-3 mb-3 category-btn" data-category="others">Others</button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <?php
                // Check if the rows array is not empty
                $sql ="SELECT * FROM `image` WHERE `Group_id`='".$_GET['groupId']."'";
                $img = mysqli_query($connection,$sql);
                $rows = mysqli_num_rows($img);
                if (!empty($rows)) {
                    // Loop through the rows and generate image cards dynamically
                    while($obj = mysqli_fetch_assoc($img))
                    {
                ?>
                    <div class="relative overflow-hidden rounded-lg shadow-lg image-card category-<?php echo $obj['type'] ?>">
                        <!-- <p>Bhavay</p> -->
                        <img class="h-auto w-full image-card-img" src="diplay_images.php?id=<?php echo $obj['id']; ?>" alt="image<?php echo $obj['id']; ?>" data-title="<?php echo $obj['type']; ?>" data-description="<?php echo $obj['Collage_id']; ?>" />
                    </div>
                <?php
                    }
                ?>
                <?php
                }else {
                    echo '<p>No images found.</p>';
                    }
                ?>
            </div>
        </div>
    </div>
</main>


<script>
    // Add event listener to category buttons
    var categoryButtons = document.getElementsByClassName('category-btn');
    var defaultCategoryButton = categoryButtons[0]; // Select the first category button as the default

    // Add active class to the default category button
    defaultCategoryButton.classList.add('active');

    // Set the default category
    var defaultCategory = defaultCategoryButton.getAttribute('data-category');

    // Show all images by default
    var imageCards = document.getElementsByClassName('image-card');
    for (var j = 0; j < imageCards.length; j++) {
        imageCards[j].style.display = 'block';
    }

    // Update the displayed images when a category button is clicked
    for (var i = 0; i < categoryButtons.length; i++) {
        categoryButtons[i].addEventListener('click', function() {
            // Remove active class from all buttons
            for (var j = 0; j < categoryButtons.length; j++) {
                categoryButtons[j].classList.remove('active');
            }

            // Add active class to the clicked button
            this.classList.add('active');

            var category = this.getAttribute('data-category');

            // Show all images if 'All categories' button is clicked
            if (category === 'all') {
                for (var j = 0; j < imageCards.length; j++) {
                    imageCards[j].style.display = 'block';
                }
            } else {
                // Hide images of other categories
                for (var j = 0; j < imageCards.length; j++) {
                    if (!imageCards[j].classList.contains('category-' + category)) {
                        imageCards[j].style.display = 'none';
                    }
                }

                // Show images of the selected category
                var selectedImages = document.getElementsByClassName('category-' + category);
                for (var k = 0; k < selectedImages.length; k++) {
                    selectedImages[k].style.display = 'block';
                }
            }
        });
    }

    // Add event listener to images for quick look
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('image-card-img')) {
            var imageUrl = event.target.getAttribute('src');
            var modalHtml = '<div class="modal">' +
                '<img src="' + imageUrl + '" class="modal-image">' +
                '</div>';

            // Append modal HTML to the body
            document.body.insertAdjacentHTML('beforeend', modalHtml);

            // Make the modal full screen
            var modal = document.getElementsByClassName('modal')[0];
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            modal.style.zIndex = '9999';
            modal.style.display = 'flex';
            modal.style.justifyContent = 'center';
            modal.style.alignItems = 'center';

            // Center the modal image
            var modalImage = document.getElementsByClassName('modal-image')[0];
            modalImage.style.maxWidth = '100%';
            modalImage.style.maxHeight = '100%';

            // Add event listener to close the modal when clicked outside the image
            modal.addEventListener('click', function(event) {
                if (!event.target.classList.contains('modal-image') && !event.target.classList.contains('modal-close')) {
                    modal.parentNode.removeChild(modal);
                }
            });
        }
    });
</script>
