<?php
// errors(1);

locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');


?>

<head>

<style>
   

  </style>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">

<h1 class="h2">Choose Theme</h1>

<?php
  
    if (isset($_POST['select'])) {

      if($isPaymentDone){
        echo '<div class="alert alert-danger alert-dismissible fade show"> Unable to change Theme! Payment already done. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
      }else{

          $_REQUEST['template']=$_REQUEST['themeName'];

          $updateWedding = $wedding->update($_REQUEST['id'], $_REQUEST['lang'], $_REQUEST);

          if ($updateWedding['error']) {
            ?>
            <div class="alert alert-danger">
              <?php
              foreach ($updateWedding['errorMsgs'] as $msg) {
                if (count($msg))
                  echo $msg[0] . "<br>";
              }
              ?>
            </div>
            <?php
          }else{
            redirect("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang'] . "/theme");

          } 

      }

    }


// Fetch folder names dynamically
$themeFolders = array_filter(glob('themes/*'), 'is_dir');
sort($themeFolders);

usort($themeFolders, function($a, $b) {
    // Extract the number after "theme_"
    preg_match('/theme_(\d+)/', $a, $aMatch);
    preg_match('/theme_(\d+)/', $b, $bMatch);
    
    // Compare the extracted numbers
    return (int)$aMatch[1] - (int)$bMatch[1];
});



?>
  
<div class="container mt-5">
 
<!-- Theme Preview -->
<div class="theme-container">
  <!-- Theme Cards -->
  <div class="row">

    <?php 
        foreach ($themeFolders as $folder) {
            // Extract only the folder name
            $themeDetails = [];
            $themeName = ucwords(explode("_", basename($folder))[2]);
            $themeDetails = json_decode(file_get_contents('themes/'.basename($folder).'/manifest.json'), true);
        if($themeDetails['active']){
    ?>
    <!-- Card for Each Theme -->
    <div class="col-lg-4 col-md-6 col-sm-3 mb-4 ">
      <div class="card theme-card text-center position-relative" style="overflow: hidden;">
        <!-- Badge for Discount or Trending -->
        <?php if ($themeDetails['isPremium']) { ?>
          <span class="badge bg-danger position-absolute top-0 end-0 m-2">Premium</span>
        <?php } ?>
        
        <!-- Theme Image with Fixed Height and Responsiveness -->
        <img src="<?php themeAssets(basename($folder),$themeDetails['displayImages'][0]); ?>" class="card-img-top theme-image" alt="Theme Preview">

        <!-- Card Body -->
        <div class="card-body">
          <!-- Theme Name -->
          <h5 class="card-title"><?php echo $themeDetails['themeName']; ?></h5>
          <!-- Theme Price -->
          <dt class="card-text text-muted">Price: <?php echo strtoinr($themeDetails['themePrice'], 2); ?></dt>
        
          <!-- Preview and Select Buttons -->
          <div class="d-flex justify-content-center">
            <!-- Live Preview Button -->
            <a target="_blank" href="<?php echo route("KaaviaWedsRohan/en?theme=".$themeDetails['themeID']); ?>" class="btn btn-sm btn-primary preview-btn text-light"> Preview </a>
            <!-- Select Button -->
            <form method="post" class="p-0 m-0">
              <input type="hidden" name="themeName" value="<?php echo basename($folder); ?>">

              <?php 

                  if($weddingData['template'] == basename($folder) ){
              ?>

                <button class="btn btn-sm select-btn btn-success" type="submit" name="select" >Selected</button>

              <?php

                  }else{
              ?>
                <button class="btn btn-sm select-btn btn-success" type="submit" name="select" >Select</button>

              <?php

                  }

               ?>
              
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php
        }
        }
    ?>
    
  </div>
</div>

<style>
  .theme-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
  }

  /* Ensure the card is responsive */
  @media (max-width: 768px) {
    .theme-image {
      height: 200px; 
    }
  }
</style>



</main>

<!--Main End-->

<script type="text/javascript">


</script>

<?php require('views/partials/dashboard/scripts.php') ?>