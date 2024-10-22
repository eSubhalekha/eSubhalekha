<?php 

// errors(1);

include("config.php");


    $wedding = new Wedding();
    $weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);

    $story = json_decode($weddingData['story'], true);
    $timeline = json_decode($weddingData['timeline'], true);

      $muhurt = null;
    
    foreach ($timeline as $event) {
      if ($event['type'] === 'muhurt') {
        $muhurt = $event;
        break; // Exit loop once found
      }
    }
        function addOrdinalSuffix($day) {
        if (!in_array(($day % 100), array(11, 12, 13))) {
            switch ($day % 10) {
                case 1: return $day . 'st';
                case 2: return $day . 'nd';
                case 3: return $day . 'rd';
            }
        }
        return $day . 'th';
    }
    
    function formatTimestamp($timestamp) {
    // Create a DateTime object from the timestamp
    $dateTime = new DateTime($timestamp);

    // Get the month in full text format (e.g., "August")
    $month = $dateTime->format('F');

    // Get the day of the month
    $day = $dateTime->format('j');

    // Function to add ordinal suffix to the day


    // Combine the month and day with the suffix
    //return $month . ' ' . addOrdinalSuffix($day);
    return $month . ' ' . $day;
}

    $gallery = new Gallery();
    $eventsGallery=$gallery->getEventGallery($_REQUEST['id']);
    $preweddingGallery=$gallery->getPreWedGallery($_REQUEST['id']);



?>
<!DOCTYPE html>
<html lang="en">
<?php include("head.php"); ?>
<style>
    
      #app {
    
        max-height: 100vh !important;
    }

        .loading_container {
      width: 100vw;
      height: 100vh;
      background-color: transparent;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    .bg_container {
      width: 100vw;
      height: 100vh;
      background-color: #86363B;
      transform-origin: center;
      transform: scaleX(0);
      animation: bg_div_animation 900ms ease-in-out forwards;
      position: absolute;
      top: 0;
      right: 0;

    }

    .logo {
      width: 320px;
      display: flex;
      justify-content: center;
      align-items: center;

      transform-origin: center;
      transform: translate(50%, 50%);
      animation: logo_animation 2s forwards;

    }

    .logo img {
      width: 100%;
      height: 100%;

    }

        .d-none{
      display: none;
    }

    .spinner-border {
      display: inline-block;
      width: 2rem;
      height: 2rem;
      vertical-align: -.125em;
      border: .25em solid #fff;
      border-right-color: transparent;
      border-radius: 50%;
      -webkit-animation: .75s linear infinite spinner-border;
      animation: .75s linear infinite spinner-border;
    }

    .text-white {
        --bs-text-opacity: 1;
        color: rgba(var(--bs-white-rgb), var(--bs-text-opacity)) !important;
    }

     @keyframes spinner-border {
      100% {
        transform: rotate(360deg);
      }
    }


    @keyframes bg_div_animation {
      0% {
        transform: scaleX(0.1);
      }

      100% {
        transform: scaleX(1);
      }
    }

    @keyframes logo_animation {
      0% {
        transform: scale(0.2);
        opacity: 0%;
      }

      40% {
        transform: scale(0.2);
        opacity: 0%;
      }

      100% {
        transform: scale(1);
        opacity: 100%;
      }
    }

    .fixedRSVP {
      position: fixed;
      bottom: 20px;
      right: 20px; 
      z-index: 1000; 
    }
    .modal{
      z-index: 99999;
    }

</style>
<!-- loading component starts here  -->
<div class="loading_container">
  <div class="bg_container">
  </div>
  <div class="logo">
    <img src="<?php assets("img/eSubhalekhaIcon.png") ?>" alt="">
  </div>
  <div class="spinner-border text-white" role="status">
    <span class="visually-hidden"></span>
  </div>
</div>
<!-- loading component ends here  -->

  <body data-spy="scroll" data-target="#navbar" data-offset="50">

    <button id="rsvpButton" class="btn btn-sm text-light fixedRSVP" data-bs-toggle="modal" data-bs-target="#rsvpModal"> RSVP </button>

    <!-- Modal -->
     <div class="modal fade text-black" id="rsvpModal" tabindex="-1" aria-labelledby="rsvpModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="rsvpModalLabel">RSVP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <?php 

                  if(isset($_REQUEST['submitRSVP'])){

                      controller("Guest");
                      $guestObj = new Guest();

                      $_REQUEST['weddingID'] = $_REQUEST['id'];
                      $_REQUEST['lang'] = $_REQUEST['lang'];
                    
                      $addGuest = $guestObj->create($_REQUEST);

                  }

              ?>
              <form id="rsvpForm" method="POST">
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="nameInput" class="form-label">Name*</label>
                    <input type="text" class="form-control" id="nameInput" name="name" required>
                  </div>
                  <div class="mb-3">
                    <label for="phoneInput" class="form-label">Phone (WhatsApp)*</label>
                    <input type="text" class="form-control" id="phoneInput" name="phone" required>
                  </div>
                  <div class="mb-3">
                    <label for="additionalGuests" class="form-label">Number of people attending*</label>
                    <input  type="number" class="form-control" id="additionalGuests" name="additionalGuests"  required />
                  </div>
                  <div class="mb-3">
                    <label for="guestMessage" class="form-label">Message</label>
                    <textarea class="form-control" id="guestMessage" name="guestMessage" rows="3"></textarea>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" id="submitBtn" class="btn-sm btn-primary" name="submitRSVP">Submit</button>
                      
                  </div>
                </div>
              </form>
              <script>
                document.getElementById("submitBtn").addEventListener("click", function () {
                  var name = document.getElementById("nameInput").value;
                  var phone = document.getElementById("phoneInput").value;
                  var additionalGuests = document.getElementById("additionalGuests").value;
                  var message = document.getElementById("guestMessage").value;
                  var url = "https://api.whatsapp.com/send?phone=+919989352171&text=" +
                    encodeURIComponent('Name: ' + name + '\nPhone: ' + phone +
                      '\nAdditional Guests: ' + additionalGuests + '\nMessage: ' + message);
                  window.open(url, "_blank");
                  document.getElementById("rsvpForm").submit();
                });
              </script>

            </div>
          </div>
        </div>
    <!-- Modal ends -->


    <div class="main">
    <!-- Hero start -->
    <section id="hero">
      
      <div class="hero-section img-hero">

          <?php
        if (getImgURL('hero')) {
            $mediaURL = getImgURL('hero');
            $headers = get_headers($mediaURL, 1);

            if (isset($headers['Content-Type'])) {
                $contentType = $headers['Content-Type'];

                // If it's a video
                if (strpos($contentType, 'video') !== false) {
                ?>
                    <div class="" style="">
                    <div class="dark-overlay"></div>
                        <!-- Video as a background -->
                        <video autoplay loop muted style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                            <source src="<?=  $mediaURL ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>

                        <!-- Overlay content -->
                    <div class="">
                      
                        <p class="brand-text lead">The Wedding Of</p>
                         <div class="hero-text">
                          <p><?= $weddingData['groomName'] ?> <span class="and">&</span> <?= $weddingData['brideName'] ?></p>  
                    </div>

                  </div>


                    </div>
            <?php
                }
              elseif (strpos($contentType, 'image') !== false) {
              ?>

               <!-- For image background -->
                       <div class="" style="background-image: url('<?php if(getImgURL('hero')){ echo getImgURL('hero'); }else{ echo assets('img/hero.png'); } ?>'); background-size: cover; background-position: center; height: 100vh;  display: flex; justify-content: center;  align-items: center;">

                        <div class="dark-overlay"></div>

              <div class="">
                <p class="brand-text lead">The Wedding Of</p>
                 <div class="hero-text">
                  <p><?= $weddingData['groomName'] ?> <span class="and">&</span> <?= $weddingData['brideName'] ?></p>  
                </div>
            
              </div>
            </div>

             <div> 
              <?php
            }
          }
        }
        ?>

      </div>

      

    </section>
    <!-- Hero ends -->


    <!-- Navigation start -->
    <section class="mb-4  sticky-top"  id="nav" style="background-color: #d9d9d9;">
      <ul class="nav justify-content-center lead">
        <li class="nav-item">
          <a class="nav-link" href="#ourstory">Our story</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#eventsSection">Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#gallerySection">Gallery</a>
        </li>
      </ul>
    </section>
    <!-- Navigation ends -->


    <section id="ourstory" class="mt-5 pt-5">
      <br />
      <div class="container custom-container">
        <div class="row">
          <div class="col-md-5 col-12 justify-content-center">
            <div class="img-container mx-auto">
              <img
               src="<?php if(getImgURL('groom')){echo getImgURL('groom');}else{ echo assets('img/upload.png');} ?>"
                class="img-fluid img-about"
                alt="Image"
              />
            </div>
            <div class="row mt-5 align-items-center">
              <h1 class="text-center primary-color luxurious-script"><?= $weddingData['groomName'] ?></h1>
              <p class="text-center ledger">
                <?= $weddingData['groomQualifications'] ?>: <?= $weddingData['groomBio'] ?>
              </p>
            </div>
          </div>
          <div
            class="col-md-2 text-center d-flex justify-content-center align-items-center my-5"
          >
            <div
              style="
                width: 60px;
                height: 60px;
                background-color: #d4af37;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                margin-top: 10px;
              "
            >
              <span style="font-size: 2rem; color: white"> &#x2665;</span>
            </div>
          </div>


          <div class="col-md-5 col-12 justify-content-center">
            <div class="img-container mx-auto">
              <img
                src="<?php if(getImgURL('bride')){echo getImgURL('bride');}else{ echo assets('img/upload.png');} ?>"
                class="img-fluid img-about"
                alt="Image"
              />
            </div>
            <div class="row my-5">
              <h1 class="text-center primary-color luxurious-script"><?= $weddingData['brideName'] ?></h1>
              <p class="text-center ledger">
                <?= $weddingData['brideQualifications'] ?>: <?= $weddingData['brideBio'] ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!--Events start -->
    <div class="bg-gray pb-5 pt-3">
      <section class="container mt-2" id="eventsSection">
    
        <p class="text-center lead invited mb-0"><span class="text-dark line blockquote-footer"></span> You are invited <span class="text-dark ms-2 line blockquote-footer"></p>
        <h1 class="section-head text-center display-5 mt-0 mb-5"> <?= formatTimeStamp($muhurt['startTime']) ?> </h1>
        <h1 class="section-head text-center luxurious-script display-5 mt-5">Events</h1>
  
    
        <div id="eventsCarousel" class="owl-carousel owl-theme mt-4">
     <?php 

     if ($timeline != null){
                            for ($i = 0; $i < count($timeline); $i++){
                              $datetimeObj1 = new DateTime($timeline[$i]['startTime']);
                              $datetimeObj2 = new DateTime($timeline[$i]['endTime']);
                              $from=$datetimeObj1->format("d-m-Y")." ".$datetimeObj1->format("H:i");
                              $to=$datetimeObj2->format("d-m-Y")." ".$datetimeObj2->format("H:i");
                                ?>
          <div class="item">
            <div class="card pink-border ">
              <img src="<?php echo getImgURL($timeline[$i]['type']); ?>"
                class="card-img-top eventImgDiv" alt="Reception">
              <div class="card-body text-center pb-1">
                <h4 class="text-dark mb-3"><?= ucwords($timeline[$i]['type']); ?></h4>
                <p class="card-text mb-0"><?php echo $from."<br> To <br> ".$to; ?>  
                </p>
                <p class="card-text mb-4"><?= $timeline[$i]['venue'] ?><br> 
              <?= str_replace("<br>", "\r\n", $timeline[$i]['address']) ?>
                </p>
                
               <a href="<?= $timeline[$i]['locationURL'] ?>" target="_blank"> <button class="btn btn-sm text-light">VIEW ON MAP</button></a>
              </div>
            </div>
          </div>
             <?php }} ?>

    
        </div>
    
      </section>
    </div>
    <!--Events Ends -->


    <!-- gallery start -->
  <section class="container custom-container my-2 pb-5" id="gallerySection">

    <h1 class="section-head text-center luxurious-script display-5 my-5">Gallery</h1>

    <div id="galleryCarousel" class="owl-carousel owl-theme mt-5">


          <?php 
            if (!$preweddingGallery['error']){
                for ($i = 0; $i < count($preweddingGallery); $i++){
                        if (!$preweddingGallery['error']){
                         for ($i = 0; $i < count($preweddingGallery); $i++){
                          $headers = get_headers($preweddingGallery[$i]['imageURL'], 1);
                          if (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'image') !== false){
                  ?>

                   <div class="item ">
                    <img src="<?= $preweddingGallery[$i]['imageURL'] ?>" class="galleyImg" style="border-radius: 40px;">
                  </div>
                                                                                                                                             
                    <?php 

                      } // image type ends
                      elseif (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'video') !== false) {
                    ?>

                      <div class="item">
                        <video controls style="object-fit: cover;  width:-webkit-fill-available;">
                        <source src="<?= $preweddingGallery[$i]['imageURL'] ?>" type="video/mp4">
                              Your browser does not support the video tag.
                        </video>
                      </div>

                    <?php 
                      }// video type ends

                         } // for ends
                       } // if ends
                     }
                  }
          ?>

    </div>
  </section>
  <!-- gallery ends -->

     <!-- Travel Start -->
     <h1 class="luxurious-script text-center my-5">Travel</h1>
     <section id="travel" class="mb-5">
      
      <div class="travel-section">
        <img
          src="<?php themeAssets($themeID,'img/bg-travel.png') ?>"
          alt="Hero Image" class="hero-image">
        <div class=""></div>
        
        <div class="travel-text">
          <p style="color:black"><?= $weddingData['travel'] ?></p>
          <p style="color:black" class="border-top"><?= $weddingData['accommodation'] ?></p>
        </div>
      </div>
  </section>
  <footer>
      <p class="text-md text-center p-3">A Personalized Experience with ❤️ by <a class="link footer-link" href="https://eSubhalekha.com"
          target="_blank" rel="noopener noreferrer">eSubhalekha.com</a> </p>
  </footer>
</div>

    <!-- Travel Ends -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>




    $('#eventsCarousel').owlCarousel({
      loop: false,
      margin: 25,
      nav: false,
      autoplay: false,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 3
        }
      }
    })
    $('#galleryCarousel').owlCarousel({
      loop: false,
      margin: 15,
      nav: false,
      autoplay: false,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 3
        }
      }
    })
    </script>


    <script>
  loader = document.querySelector(".loading_container")
  body = document.querySelector(".main")
  body.classList.add('d-none')

  window.addEventListener("load", function () {
    setTimeout(function () {
      loader.classList.add('d-none')
      body.classList.remove('d-none')
    }, 3000);
  });
</script>

  </body>
</html>
