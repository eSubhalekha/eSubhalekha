<?php

locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');
DB::connect();
$languages = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'weddings' AND COLUMN_NAME = 'lang'", 'COLUMN_TYPE DESC')->fetch()[0]);
DB::close();


sort($languages);
controller("Wedding");
$wedding = new Wedding();


controller("Gallery");
$gallery = new Gallery();

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

?>


<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
	<h1 class="h2">Create Wedding</h1>


		<form method="post" id="form" name="createWedding" class="form-wedding" enctype="multipart/form-data">

			<?php


			if (isset($_POST['btn-submit'])) {

				controller("AWSBucket");
				$awsObj=new AWSBucket();

				$_REQUEST['host'] = App::getUser()['userID'];
				$groomArray=array();
				$brideArray=array();

				$groomArray['weddingID']=$_REQUEST['weddingID'];
				$brideArray['weddingID']=$_REQUEST['weddingID'];

				// upload bride img to aws bucket
				if(isset($_FILES['bride']['name'])){
					$uploadedURL = $awsObj->uploadToAWS($_FILES,'bride');
					if($uploadedURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedURL['errorMsg'].'</div>';
					}
					else{					
						$brideArray['imageURL'] = $uploadedURL['url'];	
						$brideArray['imageName']='bride';
						$brideArray['type']='bride';
					}
					
				}

				 // upload groom img to aws bucket
				if(isset($_FILES['groom']['name'])){
					$uploadedURL = $awsObj->uploadToAWS($_FILES,'groom');
					if($uploadedURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedURL['errorMsg'].'</div>';
					}
					else{					
						$groomArray['imageURL'] = $uploadedURL['url'];	
						$groomArray['imageName']='groom';
						$groomArray['type']='groom';
					}
				}

				$createWedding = $wedding->create($_REQUEST);
				$addToGalleryBride = $gallery->update($brideArray);
				$addToGalleryGroom = $gallery->update($groomArray);



				if ($createWedding['error']) {
					?>
					<div class="alert alert-danger">
						<?php
						foreach ($createWedding['errorMsgs'] as $msg) {
							if (count($msg))
								echo $msg[0] . "<br>";
						}
						?>
					</div>
					<?php
				}else if ($addToGalleryBride['error']) {
					?>
					<div class="alert alert-danger">
						<?php
						foreach ($addToGalleryBride['errorMsgs'] as $msg) {
							if (count($msg))
								echo $msg[0] . "<br>";
						}
						?>
					</div>
					<?php
				}else if ($addToGalleryGroom['error']) {
					?>
					<div class="alert alert-danger">
						<?php
						foreach ($addToGalleryGroom['errorMsgs'] as $msg) {
							if (count($msg))
								echo $msg[0] . "<br>";
						}
						?>
					</div>
					<?php
				} else
					redirect("wedding/" . $_REQUEST['weddingID'] . "/" . $_REQUEST['lang'] . "/hosts");

			}

			?>
     <div class="row text-center">

     		<!-- groom pic -->
			    <div class="col-sm-6">
			      <label for="groom" class="form-label" style="position: relative;">

			      	Groom Photo<br>
			      	    <img id="groomImage" src="<?php assets('img/upload.png'); ?>" alt="Groom Image" class="rounded-circle" style="width: 150px; height: 150px;">

			      	    <span class="btn btn-sm btn-secondary capture"><i class="fas fa-camera"></i></span>

			      </label>

			    	<input type="file" class="form-control" id="groom" accept="image/*" name="groom" required  onchange="displayGroomImage(this)" hidden>
			    </div>
			
     	
     	<!--  bride pic -->
			    <div class="col-sm-6">
			      <label for="bride" class="form-label" style="position: relative;">

			      	Bride Photo<br>
			      	    <img id="brideImage" src="<?php assets('img/upload.png'); ?>" alt="Bride Image" class="rounded-circle" style="width: 150px; height: 150px;">

			      	    <span class="btn btn-sm btn-secondary capture"><i class="fas fa-camera"></i></span>

			      </label>
			      <input type="file" class="form-control" id="bride" accept="image/*" name="bride" required  onchange="displayBrideImage(this)" hidden>

			    </div>
  	
     </div>
		

			<div class="row">

				<!-- Groom Name -->
				<div class="mb-3 col-sm-6">
					<label for="groomName" class="form-label">Groom Name</label>
					<input type="text" class="form-control" id="groomName" name="groomName"
						placeholder="Enter Groom Name" value="<?= $_REQUEST['groomName'] ?? '' ?>">
				</div>

				<!-- Bride Name -->
				<div class="mb-3 col-sm-6">
					<label for="brideName" class="form-label">Bride Name</label>
					<input type="text" class="form-control" id="brideName" name="brideName"
						placeholder="Enter Bride Name" value="<?= $_REQUEST['brideName'] ?? '' ?>">
				</div>

				<!-- From (Bride/Groom) -->
				<div class="mb-3 col-sm-6">
					<label class="form-label" for="fromRole">From</label>

					<select class="form-select" id="fromRole" name="fromRole">
						<option value="bride" <?= ($_REQUEST['fromRole'] == 'bride') ? 'selected' : '' ?>>Bride</option>
						<option value="groom" <?= ($_REQUEST['fromRole'] == 'groom') ? 'selected' : '' ?>>Groom</option>

					</select>
				</div>

				<!-- Language -->
				<div class="mb-3 col-sm-6">
					<label for="lang" class="form-label">Language</label>
					<select class="form-select" id="lang" name="lang">
						<?php foreach ($languages as $lang) {
							?>
							<option value="<?= $lang ?>" <?php
							  if ($_REQUEST['lang'] == $lang)
								  echo 'selected';
							  elseif ($lang == 'en')
								  echo 'selected' ?>>
								<?= Locale::getDisplayLanguage($lang, "en") ?>
							</option>
							<?php
						} ?>
					</select>
				</div>
				<!-- Wedding Name -->
				<div class="mb-3 col-sm-6">
					<label for="weddingName" class="form-label">Wedding Name</label>
					<input type="text" class="form-control" id="weddingName" name="weddingName"
						placeholder="Thota vaari pelli sandhadi" value="<?= $_REQUEST['weddingName'] ?? '' ?>">
				</div>




				<!-- Wedding ID -->
				<div class="mb-3 col-sm-6">
					<label for="weddingID" class="form-label">Wedding ID</label>
					<input type="text" class="form-control" id="weddingID" name="weddingID"
						placeholder="KishoreWedsSwathi" value="<?= $_REQUEST['weddingID'] ?? '' ?>">
				</div>
			</div>

			<!-- Submit Button -->
			<button type="submit" name="btn-submit" id="submit-btn" class="btn btn-primary">Create Wedding</button>
		</form>

	</div>

	<script>
		let weddings = []
		<?php
		foreach ($weddings as $wedding) {
			echo "weddings.push('" . $wedding['weddingID'] . "')\n";
		}
		?>

		function generateWeddingID(groomName, brideName) {
			// Replace spaces and empty characters in groom and bride names
			groomName = groomName.replace(/\s/g, "");
			brideName = brideName.replace(/\s/g, "");

			let weddingID = groomName + "Weds" + brideName;

			if (weddings.includes(weddingID)) {
				weddingID = groomName + "-Weds-" + brideName;
			}

			return weddingID;
		}


		function updateWeddingID() {
			const groomName = document.querySelector('#groomName').value.trim();
			const brideName = document.querySelector('#brideName').value.trim();
			const weddingIDField = document.querySelector('#weddingID');

			if (groomName.length && brideName.length) {
				const newWeddingID = generateWeddingID(groomName, brideName);
				weddingIDField.value = newWeddingID;
			} else weddingIDField.value = "";
		}

		document.querySelector('#groomName').addEventListener('focusout', updateWeddingID);
		document.querySelector('#brideName').addEventListener('focusout', updateWeddingID);
		document.querySelector('#groomName').addEventListener('keyup', updateWeddingID);
		document.querySelector('#brideName').addEventListener('keyup', updateWeddingID);
  			
  			//display bride img
			function displayBrideImage(input) {
			  const file = input.files[0];

			  if (file) {
			    const reader = new FileReader();
			    
			    reader.onload = function (e) {
			      document.getElementById('brideImage').src = e.target.result;

			    };

			    reader.readAsDataURL(file);
			  }
			  
			}

			// display groom img
			function displayGroomImage(input) {

			  const file = input.files[0];

			  if (file) {
			    const reader = new FileReader();

			    reader.onload = function (e) {
			      document.getElementById('groomImage').src =e.target.result;

			    };

			    reader.readAsDataURL(file);
			  }

			}

  		
	</script>
</main>



<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>