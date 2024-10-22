<?php

    //errors(1);

    $wedding = new Wedding();
    $weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);

    $story = json_decode($weddingData['story'], true);
    $timeline = json_decode($weddingData['timeline'], true);
    $hosts = json_decode($weddingData['hosts'], true);
    
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
<?php include("head.php") ?>
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

<body>
    <div id="app" class="main">
        <!-- main content here -->


    <!-- Floating Button using Bootstrap -->
    <div class="fixed-button">
        <button type="button" class="btn btn-primary text-dark" data-bs-toggle="modal" data-bs-target="#rsvpModal">
                            RSVP
                        </button>
    </div>



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

          <!-- Hero start -->
<!-- Hero start -->
<section class="container-fluid" id="heroSection">
    <div> 
      <!-- class="owl-carousel owl-theme"> -->
        <?php
        if (getImgURL('hero')) {
            $mediaURL = getImgURL('hero');
            $headers = get_headers($mediaURL, 1);

            if (isset($headers['Content-Type'])) {
                $contentType = $headers['Content-Type'];

                // If it's a video
                if (strpos($contentType, 'video') !== false) {
                    echo '
                    <div class="" style="">
                        <!-- Video as a background -->
                        <video autoplay loop muted style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                            <source src="' . $mediaURL . '" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>

                        <!-- Overlay content -->
                        <div class="text-center" style="position: relative; z-index: 1; display: flex; flex-direction: column;
                            justify-content: center; align-items: center; height: 100vh;">
                            <p class="text-secondary"><span class="lines">The Wedding Of</span></p>
                            <h1 class="text-primary">' . $weddingData['groomName'] . ' & ' . $weddingData['brideName'] . '</h1>
                            <div class="d-flex justify-content-center align-items-center text-secondary gap-3" id="countdown">
                                <div>
                                    <span class="days">03</span><br>
                                    <span class="timerText">Days</span>
                                </div>
                                <div>
                                    <span class="hours">05</span><br>
                                    <span class="timerText">Hrs</span>
                                </div>
                                <div>
                                    <span class="min">15</span><br>
                                    <span class="timerText">Mins</span>
                                </div>
                             =
                            </div>
                        </div>
                    </div>';
                }
              elseif (strpos($contentType, 'image') !== false) {
              ?>

               <!-- For image background -->
              <div class="" style="background-image: url('<?php if(getImgURL('hero')){ echo getImgURL('hero'); }else{ echo assets('img/hero.png'); } ?>'); background-size: cover; background-position: center; height: 100vh;  display: flex; justify-content: center;  align-items: center;">
                  <div class="text-center">
                      <p class="text-secondary"><span class="lines">The Wedding Of</span></p>
                      <h1 class="text-primary"><?= $weddingData['groomName'] ?> & <?= $weddingData['brideName'] ?></h1>
                      <div class="d-flex justify-content-center align-items-center text-secondary gap-3" id="countdown">
                          <div>
                              <span id="days"></span><br>
                              <span class="timerText">Days</span>
                          </div>
                          <div>
                              <span id="hours"></span><br>
                              <span class="timerText">Hrs</span>
                          </div>
                          <div>
                              <span id="minutes"></span><br>
                              <span class="timerText">Mins</span>
                          </div>
                          
                      </div>
                  </div>
              </div>
              <?php
            }
          }
        }
        ?>
    </div>
</section>

        <!-- Hero end -->

 <?php require('nav.php'); ?>

        <!-- about start -->
        <section class="container" id="aboutSection">

            <div class="container">
                <div class="row align-items-center justify-content-center text-center gap-2">
                    <!-- First Column - Image -->
                    <div class="col-lg-4 image-column" style="width: auto;">
                        <img src="<?php if(getImgURL('couple')){echo getImgURL('couple');}else{ echo assets('img/upload.png');} ?>" class="img-fluid coupleImg" alt="couple">
                        <div class="img-bg"></div>
                    </div>

                    <!-- Second Column - Text -->
                    <div class="col-lg-6 text-center">
                        <p class="small text-secondary text-center">Join us to celebrate <br>The wedding of</p>
                        <h3 class="text-primary text-center"><?= $weddingData['groomName'] ?> & <?= $weddingData['brideName'] ?></h3>

                        <!-- Row with three texts separated by vertical line -->
                        <div class="d-flex justify-content-center align-items-center gap-3 mt-2 text-secondary">
                            <div class=""><?= formatTimeStamp($muhurt['startTime']) ?></div>
                        
                        </div>

                        <!-- Small Paragraph -->
                        <p class="mt-2 w-50 mx-auto"> <?= $muhurt['venue'].", ".$muhurt['address'] ?> </p>
                    </div>
                </div>
            </div>


        </section>
        <!-- about ends -->

        <!-- bride groom start -->
        <section class="container" id="coupleSection">

            <h1 class="section-head">Bride & Groom</h1>

            <div class="container mt-5">
                <div class="row">
                    <!-- Column 1 -->
                    <div class="col-lg-6 mb-4">
                        <div class="text-center">
                            <img src="<?php if(getImgURL('bride')){echo getImgURL('bride');}else{ echo assets('img/upload.png');} ?>"
                            alt="Person 1" class="img-fluid brideImg">
                        </div>
                        <h3 class="mt-3 text-center"><?= $weddingData['brideName'] ?></h3>
                        <p class="text-center">
                          <b class="text-center d-block"><?= $weddingData['brideQualifications'] ?></b>
                          <?= $weddingData['brideBio'] ?>
                      </p>
                    </div>

                    <!-- Column 2 -->
                    <div class="col-lg-6 mb-4">
                        <div class="text-center">
                            <img src="<?php if(getImgURL('groom')){echo getImgURL('groom');}else{ echo assets('img/upload.png');} ?>" alt="Person 2" class="img-fluid groomImg">
                        </div>
                        <h3 class="mt-3 text-center"><?= $weddingData['groomName'] ?></h3>
                        <p class="text-center">
                          <b class="text-center d-block"><?= $weddingData['groomQualifications'] ?></b>

                          <?= $weddingData['groomBio'] ?></p>
                    </div>
                </div>
            </div>


        </section>
        <!--  bride groom ends -->


 <!-- Our story start -->
 <?php 
    if($story['display'] == 'true'){
 ?>
        <section class="container" id="ourStorySection">

            <h1 class="section-head">Our Story</h1>

            <div class="container mt-2">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="text-secondary"><?= $story['whenWeMet'] ?></div>
                                    <h6 class="text-capitalize text-primary">how we meet</h6>
                                    <p><?= $story['howWeMet'] ?></p>
                                    <div class="timeline-layout"></div>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="text-secondary"><?= $story['engagementYear'] ?></div>
                                    <h6 class="text-capitalize text-primary">Engagement</h6>
                                    <p><?= $story['engagement'] ?></p>
                                    <div class="timeline-layout"></div>
                                </div>
                            </div>

                              <div class="timeline-item">
                                <div class="timeline-content">
                                    <h6 class="text-capitalize text-primary">Memorable Moments</h6>
                                    <p><?= $story['memorableMoments'] ?></p>
                                    <div class="timeline-layout"></div>
                                </div>
                            </div>

                            <!-- Add more timeline items as needed -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
      <?php   } ?>
        <!--  our story ends -->


    <!-- Events start -->
    <section class="container mt-2" id="eventsSection">

      <h1 class="section-head">Events -</h1>

        <div id="eventsCarousel" class="owl-carousel owl-theme mt-5">
            <?php if ($timeline != null){
                            for ($i = 0; $i < count($timeline); $i++){
                              $datetimeObj1 = new DateTime($timeline[$i]['startTime']);
                              $datetimeObj2 = new DateTime($timeline[$i]['endTime']);
                              $from=$datetimeObj1->format("d-m-Y")." ".$datetimeObj1->format("H:i");
                              $to=$datetimeObj2->format("d-m-Y")." ".$datetimeObj2->format("H:i");
                                ?>
                            
        <div class="item">
          <div class="card pink-border ">
         <img src="<?php echo getImgURL($timeline[$i]['type']); ?>" class="eventImgDiv card-img-top" alt="Reception">
            <div class="card-body text-center">
              <h3 class="text-primary"><?= ucwords($timeline[$i]['type']); ?></h3>
          
              <p class="card-text "><?php echo $from."<br> To <br> ".$to; ?>   </p>
              <p class="card-text"><?= $timeline[$i]['venue'] ?><br> 
              <?= str_replace("<br>", "\r\n", $timeline[$i]['address']) ?></p>
              <a href="<?= $timeline[$i]['locationURL'] ?>" target="_blank"><button class="btn-sm btn-primary">Location</button></a>
              
            </div>
          </div>
        </div>
     <?php }} ?>


      </div>

    </section>
    <!-- Events ends -->

     <!-- Getting there start -->
    <section class="container mt-2" id="eventsSection">

      <h1 class="section-head">Getting There</h1>

      <div class="row align-items-center">
        
        <div class="col-sm-4 text-start">
            <h4 class="text-primary">Accomodation</h4>
            <p><?= $weddingData['accommodation'] ?></p>

        </div>

        <div class="col-sm-4 text-center">
          <img src="<?php themeAssets($themeID,'img/accomodation.png') ?>" class="img-fluid" width="100" height="100">
        </div>

        <div class="col-sm-4 text-end">
            <h4 class="text-primary">Travel</h4>
            <p><?= $weddingData['travel'] ?></p>

        </div>



      </div>

    </section>
    <!-- Getting there  ends -->

    <!-- gallery start -->
    <section class="container mt-2" id="gallerySection">

      <h1 class="section-head">Gallery</h1>


      <div id="galleryCarousel" class="owl-carousel owl-theme mt-5">

  <?php 
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
                        <video controls style="object-fit: cover; width:-webkit-fill-available; ">
                        <source src="<?= $preweddingGallery[$i]['imageURL'] ?>" type="video/mp4">
                              Your browser does not support the video tag.
                        </video>
                      </div>

                    <?php 
                      }// video type ends

                         } // for ends
                       } // if ends
                     
                    ?>

      </div>
    </section>
    <!-- gallery ends -->


 <p class="text-md text-center p-3">A Personalized Experience with ❤️ by <a class="link footer-link" href="https://eSubhalekha.com"
          target="_blank" rel="noopener noreferrer">eSubhalekha.com</a> </p>
          
    </div>

    <script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>

    <script>
    
    $(document).ready(function(){
      $('#eventsCarousel').owlCarousel({
        loop: true,
        margin: 25,
        nav: false,
        autoplay: 1000,
        responsive: {
          0: { items: 1 },
          600: { items: 2 },
          1000: { items: 3 }
        }
      });
      
      $('#galleryCarousel').owlCarousel({
        loop: false,
        margin: 15,
        nav: false,
        autoplay: false,
        responsive: {
          0: { items: 1 },
          600: { items: 2 },
          1000: { items: 4 }
        }
      });

    });

                function updateCountdown() {
              var weddingDate = new Date("<?= $muhurt['startTime'] ?>");
              var currentDate = new Date();
                var timeDifference = weddingDate - currentDate;
                timeDifference = Math.max(timeDifference, 0);

              var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
              var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

              document.getElementById("days").innerHTML = `<p class="text-2xl leading-tight">${days}</p><p class="text-xs">Days</p>`;
              document.getElementById("hours").innerHTML = hours;
              document.getElementById("minutes").innerHTML = minutes;


              if (days > 0) {
                document.getElementById("days").innerHTML = '' + days;
                document.getElementById("hours").innerHTML = '' + hours;
                document.getElementById("minutes").innerHTML = '' + minutes;
                // document.getElementById("days").parentElement.style.display = "flex";
              } else {

                document.getElementById("days").innerHTML = '<p class="text-2xl leading-tight">' + hours + '</p><p class="text-xs">Hours</p>';
                document.getElementById("hours").innerHTML = '<p class="text-2xl leading-tight">' + minutes + '</p><p class="text-xs">Minutes</p>';
                document.getElementById("minutes").innerHTML = '<p class="text-2xl leading-tight">' + seconds + '</p><p class="text-xs">Seconds</p>';
              }

            }

            setInterval(updateCountdown, 1000);


                $(document).ready(function() {
                    var lastScrollTop = 0;
                    var heroSectionHeight = $('#heroSection').height(); // Replace with the actual ID of your hero section

                    $(window).scroll(function(event) {
                        var st = $(this).scrollTop();

                        // Check if the user is not in the hero section
                        if (st > heroSectionHeight) {
                            // Show the navbar
                            $('.navbar').addClass('visible');
                        } else {
                            // Hide the navbar
                            $('.navbar').removeClass('visible');
                        }

                        lastScrollTop = st;
                    });
                });


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


