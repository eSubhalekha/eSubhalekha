<?php
locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

DB::connect();
$weddings = DB::select('weddings', '*', "lang = 'en'")->fetchAll();

$languages = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'weddings' AND COLUMN_NAME = 'lang'", 'COLUMN_TYPE DESC')->fetch()[0]);

DB::close();


sort($languages);
controller("Wedding");
$wedding = new Wedding();
?>

<head>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">

    <h1 class="h2">Create Wedding</h1>

     <div>
     	
     	<form id="form">
    	
    	<div class="row">
    		<!-- Wedding ID -->
		    <div class="mb-3 col-sm-6">
		      <label for="weddingID" class="form-label">Wedding ID</label>
		      <input type="text" class="form-control" id="weddingID" placeholder="Enter Wedding ID" required>
		      <strong id="weddingIDMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

		    <!-- Wedding Name -->
		    <div class="mb-3 col-sm-6">
		      <label for="weddingName" class="form-label">Wedding Name</label>
		      <input type="text" class="form-control" id="weddingName" placeholder="Enter Wedding Name" required minlength="20">
		      <strong id="weddingNameMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

    	</div>

   	<div class="row">
   		 <!-- From (Bride/Groom) -->
		    <div class="mb-3 col-sm-6">
		      <label class="form-label">From</label>
		      <div class="d-flex gap-2">
		      	<div class="form-check">
		        <input class="form-check-input" type="radio" name="fromRadio" id="brideRadio" value="bride" required checked>
		        <label class="form-check-label" for="brideRadio">
		          Bride
		        </label>
		      	</div>

		      <div class="form-check">
		        <input class="form-check-input" type="radio" name="fromRadio" id="groomRadio" value="groom" required>
		        <label class="form-check-label" for="groomRadio">
		          Groom
		        </label>
		      </div>

		      </div>

		      <strong id="fromRadioMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    
		    </div>

		    <!-- Language -->
		    <div class="mb-3 col-sm-6">
		      <label for="languageSelect" class="form-label">Language</label>
		      <select class="form-select" id="languageSelect" required>
			    <option value="en">English</option>
			    <option value="as">Assamese</option>
			    <option value="bn">Bengali</option>
			    <option value="gu">Gujarati</option>
			    <option value="hi">Hindi</option>
			    <option value="kn">Kannada</option>
			    <option value="ml">Malayalam</option>
			    <option value="mr">Marathi</option>
			    <option value="ne">Nepali</option>
			    <option value="or">Odia</option>
			    <option value="pa">Punjabi</option>
			    <option value="ta">Tamil</option>
			    <option value="te">Telugu</option>
			    <option value="ur">Urdu</option>
		      
		      </select>
		       <strong id="languageSelectMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

   	</div>

    <div class="row">
    	<!-- Bride Name -->
	    <div class="mb-3 col-sm-6">
	      <label for="brideName" class="form-label">Bride Name</label>
	      <input type="text" class="form-control" id="brideName" placeholder="Enter Bride Name" required maxlength="12">
	       <strong id="brideNameMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
	    </div>

	    <!-- Groom Name -->
	    <div class="mb-3 col-sm-6">
	      <label for="groomName" class="form-label">Groom Name</label>
	      <input type="text" class="form-control" id="groomName" placeholder="Enter Groom Name" required maxlength="12">
	       <strong id="groomNameMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
	    </div>

    </div>

    <!-- Submit Button -->
    <button type="button" id="submit-btn" class="btn btn-primary">Submit</button>
  </form>

     </div>
    

</main>
<script type="text/javascript" src="<?php assets("js/validation.js");?>"></script>

	<h1 class="h2">Create Wedding</h1>

	<div>

		<form method="post" name="createWedding" class="form-wedding">

			<?php

			$config['APP_TITLE'] = "Create Wedding | " . $config['APP_TITLE'];
			if (isset($_POST['btn-submit'])) {

				$_REQUEST['host'] = App::getUser()['userID'];
				$createWedding = $wedding->create($_REQUEST);

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
					redirect("wedding/" . $_REQUEST['weddingID'] . "/" . $_REQUEST['lang']."/basic-details");

			}

			?>
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
								<?= Locale::getDisplayLanguage($lang, "en")?>
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
			<button type="submit" name="btn-submit" class="btn btn-primary">Create Wedding</button>
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
	</script>
</main>


<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>