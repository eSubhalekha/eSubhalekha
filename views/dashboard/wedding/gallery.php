<?php

locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

controller("Gallery");
controller("AWSBucket");

$gallery = new Gallery();
$galleryData = $gallery->getGallery($_REQUEST['id']);

$eventsGallery=array();
$preweddingGallery=array();

$eventsGallery=$gallery->getEventGallery($_REQUEST['id']);
$preweddingGallery=$gallery->getPreWedGallery($_REQUEST['id'],'gallery');

$awsObj=new AWSBucket();

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

			if (isset($_POST['btn-submit'])) {
                
				// upload img to aws bucket
				if(!empty($_FILES['bride']['name'])){
					$uploadedURL = $awsObj->uploadToAWS($_FILES,'bride');

					if($uploadedURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedURL['errorMsg'].'</div>';
					}
					else{					
						$_REQUEST['imageURL'] = $uploadedURL['url'];	
						$_REQUEST['imageName']='bride';
						$_REQUEST['type']='bride';
					}
					
				}
				elseif (!empty($_FILES['groom']['name'])) {
					$uploadedURL = $awsObj->uploadToAWS($_FILES,'groom');
					$awsObj->deleteFromAWS(getImgURL('groom'));
					if($uploadedURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedURL['errorMsg'].'</div>';
					}
					else{					
						$_REQUEST['imageURL'] = $uploadedURL['url'];	
						$_REQUEST['imageName']='groom';
						$_REQUEST['type']='groom';
					}
				}
				elseif (!empty($_FILES['both']['name'])) {
					$uploadedURL = $awsObj->uploadToAWS($_FILES,'both');
					$awsObj->deleteFromAWS(getImgURL('both'));
					if($uploadedURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedURL['errorMsg'].'</div>';
					}
					else{					
						$_REQUEST['imageURL'] = $uploadedURL['url'];	
						$_REQUEST['imageName']='both';
						$_REQUEST['type']='both';
					}
				}
				elseif (!empty($_FILES['hero']['name'])) {
					$uploadedURL = $awsObj->uploadToAWS($_FILES,'hero');
					$awsObj->deleteFromAWS(getImgURL('hero'));
					if($uploadedURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedURL['errorMsg'].'</div>';
					}
					else{					
						$_REQUEST['imageURL'] = $uploadedURL['url'];	
						$_REQUEST['imageName']='hero';
						$_REQUEST['type']='hero';
					}
				}
				elseif (!empty($_FILES['eventPic']['name']) && !empty($_REQUEST['imageName']) ) {
					$uploadedURL = $awsObj->uploadToAWS($_FILES,'eventPic');
					if($uploadedURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedURL['errorMsg'].'</div>';
					}
					else{					
						$_REQUEST['imageURL'] = $uploadedURL['url'];
						$_REQUEST['type']='event';
					}
				}
				elseif (!empty($_FILES['galleryPic']['name']) ) {
                  
					$uploadedURL = $awsObj->uploadToAWS($_FILES,'galleryPic');
					if($uploadedURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedURL['errorMsg'].'</div>';
					}
					else{
					    $_REQUEST['imageName'] = $_FILES['galleryPic']['name'].time();					
						$_REQUEST['imageURL'] = $uploadedURL['url'];
						$_REQUEST['type']='gallery';
					}
				}
                
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

			?>
		<div class="row">
			<!--  bride pic -->
     	<form  method="post" enctype="multipart/form-data" class="col-sm-6">
	    	<div class="row">
			    <div class="col-sm-3">
			      <label for="bride" class="form-label">Bride Photo</label>
			    </div>

			    <div class="col-sm-5">
			    	<input type="file" class="form-control" id="bride" accept="image/*" name="bride" required>

			    <strong id="brideMsg" class="text-danger errorMsg my-2 fw-bolder"><?php
			 	if(getImgURL('bride')):
					?>
					<a class="ms-3" href="<?php echo getImgURL('bride'); ?>" target="_blank" >View File <i class="bi bi-box-arrow-up-right"></i> </a>
					<?php endif; ?>
				</strong>

			    </div>

			    <div class="col-sm-2">
			    	<!-- Submit Button -->
	    			<button type="submit" id="submit-btn" name="btn-submit" class="btn btn-primary btn-sm">Upload</button>
			    </div>

			</div>

  		</form>
  		<!-- groom form -->
     	<form  method="post" enctype="multipart/form-data" class="col-sm-6">
	    	<div class="row">
			    <div class="col-sm-3">
			      <label for="groom" class="form-label">Groom Photo</label>
			    </div>

			    <div class="col-sm-5">
			    	<input type="file" class="form-control" id="groom" accept="image/*" name="groom" required>

			    <strong id="groomMsg" class="text-danger errorMsg my-2 fw-bolder"><?php
			 	if(getImgURL('groom')):
					?>
					<a class="ms-3" href="<?php echo getImgURL('groom'); ?>" target="_blank" >View File <i class="bi bi-box-arrow-up-right"></i> </a>
					<?php endif;?>
				</strong>

			    </div>


			    <div class="col-sm-2">
			    	<!-- Submit Button -->
	    			<button type="submit" id="submit-btn" name="btn-submit" class="btn btn-primary btn-sm">Upload</button>
			    </div>

			</div>

  		</form>

		</div>

  		<div class="row">
  			
  					<!--  both pic -->
     	<form  method="post" enctype="multipart/form-data" class="col-sm-6">
	    	<div class="row">
			    <div class="col-sm-3">
			      <label for="both" class="form-label">Couple Photo</label>
			    </div>

			    <div class="col-sm-5">
			    	<input type="file" class="form-control" id="both" accept="image/*" name="both" required>

			    <strong id="bothMsg" class="text-danger errorMsg my-2 fw-bolder"><?php
			 	if(getImgURL('both')):
					?>
					<a class="ms-3" href="<?php echo getImgURL('both'); ?>" target="_blank" >View File <i class="bi bi-box-arrow-up-right"></i> </a>
					<?php endif; ?>
				</strong>

			    </div>

			    <div class="col-sm-2">
			    	<!-- Submit Button -->
	    			<button type="submit" id="submit-btn" name="btn-submit" class="btn btn-primary btn-sm">Upload</button>
			    </div>

			</div>

  		</form>

  		<!-- hero form -->
     	<form  method="post" enctype="multipart/form-data" class="col-sm-6">
	    	<div class="row">
			    <div class="col-sm-3">
			      <label for="hero" class="form-label">Hero Photo</label>
			    </div>

			    <div class="col-sm-5">
			    	<input type="file" class="form-control" id="hero" accept="image/*" name="hero" required>

			    <strong id="musicTrackMsg" class="text-danger errorMsg my-2 fw-bolder"><?php
			 	if(getImgURL('hero')):
					?>
					<a class="ms-3" href="<?php echo getImgURL('hero'); ?>" target="_blank" >View File <i class="bi bi-box-arrow-up-right"></i> </a>
					<?php endif;?>
				</strong>

			    </div>


			    <div class="col-sm-2">
			    	<!-- Submit Button -->
	    			<button type="submit" id="submit-btn" name="btn-submit" class="btn btn-primary btn-sm">Upload</button>
			    </div>

			</div>

  		</form>

  		</div>


  		<!--  events  -->
  		<h5>Events Gallery</h5>

  		<button type="button" class="btn btn-primary mb-3 float-start" id="addEventImgBtn"><i
                        class="bi bi-plus-circle"></i>Add</button>
                        <br>

  		<div class="eventGallery">
  			
  			<form  method="post" enctype="multipart/form-data">

		    	<div class="row">
				    <div class="col-sm-3">
				      <input type="text" class="form-control"  name="imageName" placeholder="Event Name" required>
				    </div>

				    <div class="col-sm-5">
				    	<input type="file" class="form-control" accept="image/*" name="eventPic" required>
				    </div>

				    <div class="col-sm-3">
				    	<!-- Submit Button -->
		    			<button type="submit" name="btn-submit" class="btn btn-primary btn-sm">Upload</button>
				    </div>

				</div>

  			</form>

  		</div>

  		  		<!--  gallery  -->
  		<h5>Pre Wedding Gallery</h5>

  		<button type="button" class="btn btn-primary mb-3 float-start" id="addPreWedImgBtn"><i
                        class="bi bi-plus-circle"></i>Add</button>
                        <br>

  		<div class="preweddingGallery">
  			
  			<form  method="post" enctype="multipart/form-data">

		    	<div class="row">

				    <div class="col-sm-5">
				    	<input type="file" class="form-control" accept="image/*" name="galleryPic" required>
				    </div>

				    <div class="col-sm-3">
				    	<!-- Submit Button -->
		    			<button type="submit" name="btn-submit" class="btn btn-primary btn-sm">Upload</button>
				    </div>

				</div>

  			</form>

  		</div>

  		<!--  display event images -->
  		<div>
  			<b> Event Gallery </b>
  			    <?php
                        if (!$eventsGallery['error']):
                                ?>
                                <table class="table table-responsive table-sm">
                                	<thead>
                                		<tr>
                                			<th>Event Name</th>
	                                		<th>Image</th>
	                                		<th>Action</th>
                                		</tr>
                                	</thead>
                                	<tbody>
                                		<?php for ($i = 0; $i < count($eventsGallery); $i++):?>
                                			<tr>
                                				<td><?= $eventsGallery[$i]['imageName'] ?> </td>
                                				<td><a target="_blank" href="<?= $eventsGallery[$i]['imageURL'] ?>"><?= $eventsGallery[$i]['imageURL'] ?></a> </td>

                                				<td>
                                					<a href="?imgurl=<?= $eventsGallery[$i]['imageURL'] ?>">
                                						<button class="btn btn-danger btn-sm" ><i class="bi bi-trash-fill"></i></button>
                                					</a>
                                                </td>

                                			</tr>
                                			<?php endfor; ?>
                                		

                                	</tbody>
                                	
                                </table>

                <?php endif;
                if ($eventsGallery['error']){
                 	echo "<br>Event Gallery is empty!";
                 }

                ?>
  			
  		</div>

		<!--  display pre wedding images -->
  		<div>
  			<b> Pre Wedding Gallery </b>
  			    <?php
                        if (!$preweddingGallery['error']):
                                ?>
                                <table class="table table-responsive table-sm">
                                	<thead>
                                		<tr>
	                                		<th>Image</th>
	                                		<th>Action</th>
                                		</tr>
                                	</thead>
                                	<tbody>
                                		<?php for ($i = 0; $i < count($preweddingGallery); $i++):?>
                                			<tr>
                                				<td><a target="_blank" href="<?= $preweddingGallery[$i]['imageURL'] ?>"><?= $preweddingGallery[$i]['imageURL'] ?></a> </td>

                                				<td>
                                					<a href="?imgurl=<?= $preweddingGallery[$i]['imageURL'] ?>">
                                						<button class="btn btn-danger btn-sm" ><i class="bi bi-trash-fill"></i></button>
                                					</a>
                                                </td>
                                			</tr>
                                			<?php endfor; ?>
                                		

                                	</tbody>
                                	
                                </table>

                <?php endif;
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






