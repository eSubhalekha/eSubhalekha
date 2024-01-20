<?php

locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

controller("Gallery");

$gallery = new Gallery();
$galleryData = $gallery->getGallery($_REQUEST['id']);

$eventsGallery=array();
$preweddingGallery=array();

$eventsGallery=$gallery->getEventGallery($_REQUEST['id']);
$preweddingGallery=$gallery->getPreWedGallery($_REQUEST['id'],'gallery');


function getImgURL($name){
	$gallery = new Gallery();
	$row=$gallery->getGalleryImg($_REQUEST['id'],$name);
	
	if($row['imageURL']){
		return $row['imageURL'];
	}
	else{
		return false;
	}
	
}

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

        	echo "<script>alert('Deleted Successfully'); window.history.back(); </script>";
        }
        else{
        	echo "<script>alert('Failed to delete');window.history.back();  </script>";
        }

    }

?>

<head>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1 class="h2">Gallery</h1>

     <div>
     	<?php

				if (!empty($_FILES['couple']['name'])) {

					echo '<script> document.getElementById("loader-div").style.display = "block"; </script>';

					controller("AWSBucket");
					$awsObj=new AWSBucket();

					$uploadedURL = $awsObj->uploadToAWS($_FILES,'couple');
					$awsObj->deleteFromAWS(getImgURL('couple'));
					if($uploadedURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedURL['errorMsg'].'</div>';
					}
					else{					
						$_REQUEST['imageURL'] = $uploadedURL['url'];	
						$_REQUEST['imageName']='couple';
						$_REQUEST['type']='couple';

						 $_REQUEST['weddingID']=$_REQUEST['id'];
						$addToGallery = $gallery->update($_REQUEST);

						if ($addToGallery['error']) {
							?>
							<div class="alert alert-danger">
								<?php
								foreach ($addToGallery['errorMsgs'] as $msg) {
									echo '<script> document.getElementById("loader-div").style.display = "none"; </script>';
									if (count($msg))
										echo $msg[0] . "<br>";
								}
								?>
							</div>
							<?php
						} else{
							echo '<script> document.getElementById("loader-div").style.display = "none"; </script>';
							redirect("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang']."/gallery");
						}
					}
				}

				if (!empty($_FILES['hero']['name'])) {
					controller("AWSBucket");
					$awsObj=new AWSBucket();

					$uploadedURL = $awsObj->uploadToAWS($_FILES,'hero');
					$awsObj->deleteFromAWS(getImgURL('hero'));
					if($uploadedURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedURL['errorMsg'].'</div>';
					}
					else{					
						$_REQUEST['imageURL'] = $uploadedURL['url'];	
						$_REQUEST['imageName']='hero';
						$_REQUEST['type']='hero';

						$_REQUEST['weddingID']=$_REQUEST['id'];
						$addToGallery = $gallery->update($_REQUEST);

						if ($addToGallery['error']) {
							?>
							<div class="alert alert-danger">
								<?php
								foreach ($addToGallery['errorMsgs'] as $msg) {
									if (count($msg))
										echo $msg[0] . "<br>";
								}
								?>
							</div>
							<?php
						} else
							redirect("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang']."/gallery");
					}
				}


				if(isset($_POST['btn-submit'])){

					controller("AWSBucket");
					$awsObj=new AWSBucket();

					if (!empty($_FILES['galleryPic']['name']) ) {
                  
					$uploadedURL = $awsObj->uploadToAWS($_FILES,'galleryPic');
					if($uploadedURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedURL['errorMsg'].'</div>';
					}
					else{
					    $_REQUEST['imageName'] = $_FILES['galleryPic']['name'].time();					
						$_REQUEST['imageURL'] = $uploadedURL['url'];
						$_REQUEST['type']='gallery';
						 $_REQUEST['weddingID']=$_REQUEST['id'];
						$addToGallery = $gallery->update($_REQUEST);

						if ($addToGallery['error']) {
							?>
							<div class="alert alert-danger">
								<?php
								foreach ($addToGallery['errorMsgs'] as $msg) {
									if (count($msg))
										echo $msg[0] . "<br>";
								}
								?>
							</div>
							<?php
						} else
							redirect("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang']."/gallery");
						}
					}

				}
               

			

			?>

  		  <div class="row">
     	
     	<!--  couple pic -->
			    <form method="post" enctype="multipart/form-data" class="col-sm-6">
			    	<div class="col-sm-6">
				      <label class="form-label"> Couple Image </label>
				      	   
				      
				     <a href="<?php if(getImgURL('couple')){echo getImgURL('couple');}else{ echo assets('img/upload.png');} ?>" target="_blank">
				     	 <img id="coupleImage" 
				      	    src="<?php if(getImgURL('couple')){echo getImgURL('couple');}else{ echo assets('img/upload.png');} ?>" alt="Couple Image" class="img-fluid" style="width: 250px; height: 150px;">

				     </a>
				      	    <br>
				      	   <label for="couple" class="form-label"> <span class="btn btn-sm btn-primary"> Upload <i class="fas fa-camera"></i></span>
				      	    </label>

				      <input type="file" class="form-control" id="couple" accept="image/*" name="couple" required  onchange="this.form.submit()" hidden>

				    </div>

			    </form>
  		<!-- hero pic -->
  		<form method="post" enctype="multipart/form-data" class="col-sm-6">
			    <div class="col-sm-6">
			      <label class="form-label">Hero Image</label>
			      	    <a href="<?php if(getImgURL('hero')){echo getImgURL('hero');}else{ echo assets('img/upload.png');} ?>" target="_blank">
			      	    	<img id="heroImage" src="<?php if(getImgURL('hero')){echo getImgURL('hero');}else{ echo assets('img/upload.png');} ?>" alt="Hero Image" class="img-fluid" style="width: 250px; height: 150px;">

			      	    </a>

						<br>
			      	    <label for="hero" class="form-label"><span class="btn btn-sm btn-primary">Upload <i class="fas fa-camera"></i></span>
			      	    </label>

			      

			    	<input type="file" class="form-control" id="hero" accept="image/*" name="hero" required  onchange="this.form.submit()" hidden>
			    </div>
			</form>
			
     </div>


  		  		<!--  gallery  -->
  		<div class="d-flex align-items-center">
  			<h5>Pre Wedding Gallery</h5>


  		</div>
                        

  		<div class="preweddingGallery">
  			
  			<form  method="post" enctype="multipart/form-data">

		    	<div class="row">

				    <div class="col-sm-5">
				    	<input type="file" class="form-control" accept="image/*" name="galleryPic" required>
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

  			<div class="d-flex align-items-center gap-4 mt-3">
  			    <?php
                        if (!$preweddingGallery['error']){
                     		 for ($i = 0; $i < count($preweddingGallery); $i++){?>
                                
							 <div class="d-flex flex-column gap-2 align-items-center">
							 	<a href="<?= $preweddingGallery[$i]['imageURL'] ?>" target="_blank">
							 		<img src="<?= $preweddingGallery[$i]['imageURL'] ?>" class="img-fluid" alt="image" style="width: 150px; height: 150px;">
							 	</a>
							                            			
							    <a href="?imgurl=<?= $preweddingGallery[$i]['imageURL'] ?>">
							        <button class="btn btn-danger btn-sm" ><i class="bi bi-trash-fill"></i></button>
							    </a>                                             

							 </div>                               		                                	
                    <?php 
                         }
                       }
                    ?>
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

<?php require('views/partials/dashboard/scripts.php') ?>






