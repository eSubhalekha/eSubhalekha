<?php

// errors(1);

locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

$galleryData = $gallery->getGallery($_REQUEST['id']);

$eventsGallery=array();
$preweddingGallery=array();

$eventsGallery=$gallery->getEventGallery($_REQUEST['id']);
$preweddingGallery=$gallery->getPreWedGallery($_REQUEST['id']);


  // delete img by url
    if(isset($_REQUEST['imgurl'])){

        controller("AWSBucket");
        $awsObj=new AWSBucket();

        $imgurl=$_REQUEST['imgurl'];
        $gallery=new Gallery();
        $getrow=$gallery->deleteByURL($_REQUEST['id'],$imgurl);
        
        if(!$getrow['error']){
            $awsObj=new AWSBucket();
            $awsObj->deleteFromAWS($imgurl);

            $_SESSION['alert_message'] = "Deleted Successfully";

            echo "<script> window.history.back(); window.location.reload(true); </script>";
        }
        else{

            $_SESSION['alert_message'] = "Failed to delete";

            echo "<script> window.history.back(); window.location.reload(true); </script>";

        }

    }

?>

<head>

    <style type="text/css">
        
    /* Full-screen overlay */
    #UpLoader {
        display: none; /* Initially hidden */
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.8); /* Black background with 80% opacity */
        z-index: 9999; /* Make sure the loader is above other elements */
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;

    }

    /* Ring Loader */
    .myLoader {
        border: 8px solid var(--color-secondary-1); /* Light border for the outer part */
        border-top: 8px solid var(--color-primary-1); /* White color for the spinning part */
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite; /* Infinite rotation animation */
    }

    /* Loader Animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }


    </style>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">


    <h1 class="h2">Gallery</h1>

    <?php 


       if (isset($_SESSION['alert_message'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['alert_message'] . "</div>";
            unset($_SESSION['alert_message']);
        }

     ?>

    <!-- Loader Element -->
    <div id="UpLoader" style="display: none;">
         <div class="myLoader"></div>
        <h2 style="color: #fff;">Uploading..</h2>
    </div>

        <!-- Placeholder for Bootstrap alerts -->
    <div id="alertPlaceholder"></div>

     <div>

          <div class="row">
        
        <!--  couple pic -->
                <form class="uploadForm col-sm-6" method="post" enctype="multipart/form-data">
                    <div class="col-sm-6">
                      <label class="form-label"> Couple Image </label>
                      <br>
                           
                      
                     <a href="<?php if(getImgURL('couple')){echo getImgURL('couple');}else{ echo assets('img/upload.png');} ?>" target="_blank">
                         <img id="coupleImage" 
                            src="<?php if(getImgURL('couple')){echo getImgURL('couple');}else{ echo assets('img/upload.png');} ?>" alt="Couple Image" class="img-fluid" style="width: 250px; height: 150px;">

                     </a>
                            <br>

                      <input type="file" class="form-control" id="couple" accept="image/*" name="couple" required>
                      <button type="submit" class="btn btn-sm btn-primary">Upload <i class="fas fa-camera"></i></button>

                    </div>

                </form>
        <!-- hero pic -->
        <form method="post" enctype="multipart/form-data" class="uploadForm col-sm-6">
                <div class="col-sm-6">
                  <label class="form-label">Hero Image/Video</label>
                  <br>


<?php 

if( getImgURL('hero')){
    $mediaURL = getImgURL('hero');

    $headers = get_headers($mediaURL, 1);

    // Check if Content-Type exists in the headers
    if (isset($headers['Content-Type'])) {
        $contentType = $headers['Content-Type'];

        // Check if it's an image
        if (strpos($contentType, 'image') !== false) {
            
?>
    <a href="<?php if(getImgURL('hero')){echo getImgURL('hero');}else{ echo assets('img/upload.png');} ?>" target="_blank">
        <img id="heroImage" src="<?php if(getImgURL('hero')){echo getImgURL('hero');}else{ echo assets('img/upload.png');} ?>" alt="Hero Image" class="img-fluid" style="width: 250px; height: 150px;">
    </a>
            <?php
        }
        // Check if it's a video
        elseif (strpos($contentType, 'video') !== false) {
       ?>

        <video width="250" height="150" controls>
            <source src="<?php if(getImgURL('hero')){echo getImgURL('hero');}else{ echo assets('img/upload.png');} ?>" type="video/mp4">
                          Your browser does not support the video tag.
        </video>

       <?php
        }
    }

}else{
    ?>
     <a href="<?php if(getImgURL('hero')){echo getImgURL('hero');}else{ echo assets('img/upload.png');} ?>" target="_blank">
        <img id="heroImage" src="<?php if(getImgURL('hero')){echo getImgURL('hero');}else{ echo assets('img/upload.png');} ?>" alt="Hero Image" class="img-fluid" style="width: 250px; height: 150px;">
    </a>
<?php  }  ?>
                        <br>
                       <!--  <label for="hero" class="form-label"><span class="btn btn-sm btn-primary">Upload <i class="fas fa-camera"></i></span>
                        </label> -->

                  
 <!-- onchange="this.form.submit()" -->
                    <input type="file" class="form-control" id="hero" accept="image/*,video/*" name="hero" required>
                    <button type="submit" class="btn btn-sm btn-primary">Upload <i class="fas fa-camera"></i></button>
                </div>
            </form>
            
     </div>


                <!--  gallery  -->
        <div class="d-flex align-items-center">
            <h5>Pre Wedding Gallery</h5>


        </div>
                        

        <div class="preweddingGallery">
            
            <form  method="post" enctype="multipart/form-data" class="uploadForm">

                <div class="row">

                    <div class="col-sm-5">
                        <input type="file" class="form-control" accept="image/*,video/*" name="galleryPic" required>
                    </div>

                    <div class="col-sm-3">
                        <!-- Submit Button -->
                        <button type="submit" name="btn-submit" class="btn btn-primary btn-sm">Add</button>
                    </div>

                </div>

            </form>

        </div>
 
        <!--  display pre wedding images -->
        <div>

            <div class="d-flex align-items-center gap-4 mt-3 flex-wrap">
        
             <div class="d-flex gap-2 align-items-center">
    <?php
    if (!$preweddingGallery['error']) {
        for ($i = 0; $i < count($preweddingGallery); $i++) {
            $headers = get_headers($preweddingGallery[$i]['imageURL'], 1);
            if (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'image') !== false) {
    ?>
                <!-- Image Thumbnail -->
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal" data-bs-slide-to="<?= $i ?>">
                        <img src="<?= $preweddingGallery[$i]['imageURL'] ?>" class="img-fluid" alt="image" style="width: 150px; height: 150px;">
                    </a>
                    <a href="?imgurl=<?= $preweddingGallery[$i]['imageURL'] ?>">
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                    </a>
                </div>
    <?php
            } elseif (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'video') !== false) {
    ?>
                <!-- Video Thumbnail -->
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal" data-bs-slide-to="<?= $i ?>">
                        <video width="150" height="150">
                            <source src="<?= $preweddingGallery[$i]['imageURL'] ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </a>
                    <a href="?imgurl=<?= $preweddingGallery[$i]['imageURL'] ?>">
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                    </a>
                </div>
    <?php
            }
        }
    }
    ?>
</div>

<!-- Modal -->
<?php if (!$preweddingGallery['error']) { ?>
<div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalLabel">Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Carousel -->
                <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php

                        for ($i = 0; $i < count($preweddingGallery); $i++) {
                            $headers = get_headers($preweddingGallery[$i]['imageURL'], 1);
                            $isActive = ($i == 0) ? 'active' : '';
                            if (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'image') !== false) {
                        ?>
                                <!-- Image Carousel Item -->
                                <div class="carousel-item <?= $isActive ?>">
                                    <img src="<?= $preweddingGallery[$i]['imageURL'] ?>" class="d-block w-100" alt="image">
                                </div>
                        <?php
                            } elseif (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'video') !== false) {
                        ?>
                                <!-- Video Carousel Item -->
                                <div class="carousel-item <?= $isActive ?>">
                                    <video class="d-block w-100" controls>
                                        <source src="<?= $preweddingGallery[$i]['imageURL'] ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <!-- Carousel Controls -->
                    <a class="carousel-control-prev" href="#galleryCarousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#galleryCarousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php   } ?>

        </div>    
                                        

                <?php 
                 if ($preweddingGallery['error']){
                    echo "<br>Pre Wedding Gallery is empty!";
                 }

                ?>
            
        </div>


     </div>
    

</main>
<!--Main End-->

<script type="text/javascript">
    
    $(document).ready(function(){
            // Add new form on button click
            $("#addEventImgBtn").click(function(){
                var newForm = $(".eventGallery form:first").clone();
                $(".eventGallery").append(newForm);
            });

            //pre wedding
            $("#addPreWedImgBtn").click(function(){
                var galleryform = $(".preweddingGallery form:first").clone();
                $(".preweddingGallery").append(galleryform);
            });

        });



</script>


<script>


// Get all forms with the class 'uploadForm'
const forms = document.querySelectorAll('.uploadForm');

// Loop through each form and attach the submit event listener
forms.forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault(); // Prevent normal form submission

        // Show the loader
        document.getElementById('UpLoader').style.display = 'flex';

        const formData = new FormData(this); // Collect the form data from the current form


        try {
            const response = await fetch('upload', {
                method: 'POST',
                body: formData
            });

            // Log the raw response text to see what uploader.php is returning
            const responseText = await response.text();
            console.log('Raw response:', responseText);  // Log the entire raw response
            
            // Try parsing the response as JSON
            const result = JSON.parse(responseText);  // Use JSON.parse() manually for better error handling

            if (result.error) {
                displayAlert('danger', 'Error: ' + result.errorMsg); // Show red alert for errors
            } else {
                displayAlert('success', 'File uploaded successfully'); // Show green alert for success

                // Refresh the page after a delay to allow the alert to be visible
                setTimeout(() => {
                    location.reload(); // Refresh the page
                }, 2000); // Adjust the delay time as needed
            }

        } catch (error) {
            console.error('Upload failed:', error);
            displayAlert('danger', 'Upload failed: ' + error.message); 
        } finally {
            // Hide the loader
            document.getElementById('UpLoader').style.display = 'none';
        }

    });
});


// Function to display Bootstrap alerts
function displayAlert(type, message) {
    const alertPlaceholder = document.getElementById('alertPlaceholder');
    const alertElement = document.createElement('div');
    
    alertElement.className = `alert alert-${type} alert-dismissible fade show`; // Bootstrap alert classes
    alertElement.role = 'alert';
    alertElement.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    alertPlaceholder.append(alertElement); // Append the alert to the placeholder

    // Automatically remove the alert after 5 seconds
    setTimeout(() => {
        alertElement.classList.remove('show');
        alertElement.classList.add('hide');
        alertElement.remove();
    }, 20000);
}



</script>

<?php require('views/partials/dashboard/scripts.php') ?>






