<?php
locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');


controller("Wedding");
$wedding = new Wedding();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);

?>

<head>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">

<h1 class="h2">Whatsapp Setup</h1>

	 <div>
     	
     	<form  method="post" enctype="multipart/form-data">

     		<?php

			if (isset($_POST['btn-submit'])) {
                
				$_REQUEST['host'] = App::getUser()['userID'];
               	

				$createWedding = $wedding->update($_REQUEST['id'],$_REQUEST['lang'],$_REQUEST);

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
				} else
					redirect("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang']."/whatsapp");

			}

			?>
    	
    	<div class="row">
		    <div class="mb-3 col-sm-6">
		      <label for="phone" class="form-label">Phone (Whatsapp only)</label>
		      
		      <input type="text" class="form-control" id="phone"  name="phone" value="<?= $_REQUEST['phone'] ?? $weddingData['phone'] ?>" placeholder="Enter phone number">

		      <strong id="phoneMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

		    <div class="mb-3 col-sm-6">
		      <label for="whatsappAPIKey" class="form-label">API Key</label>
		      
		      <input type="text" class="form-control" id="whatsappAPIKey" placeholder="Enter Whatsapp API Key" name="whatsappAPIKey" value="<?= $_REQUEST['whatsappAPIKey'] ?? $weddingData['whatsappAPIKey'] ?>" >

		      <strong id="whatsappAPIKeyMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

    	</div>

		<div class="row">
		    <div class="mb-3 col-sm-12">
		      <label for="invitation" class="form-label">Invitation Messgae (Template)</label>
		        <textarea class="form-control" id="invitation" rows="3" name="invitation"><?=$_REQUEST['invitation'] ?? $weddingData['invitation'] ?></textarea>
		      <strong id="invitationMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>


    	</div>

    <!-- Submit Button -->
    <button type="submit" id="submit-btn" name="btn-submit" class="btn btn-primary">Save & Next</button>
  </form>

     </div>
    

</main>

<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>