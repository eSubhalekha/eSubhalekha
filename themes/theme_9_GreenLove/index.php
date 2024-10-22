<?php 
// errors(1);
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


</style>

<!-- loading component starts here  -->
<div class="loading_container">
  <div class="bg_container">
  </div>
  <div class="logo">
    <img src="<?php assets("img/eSubhalekhaIcon.png") ?>" alt="">
  </div>
  <div class="spinner-border text-white" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>
<!-- loading component ends here  -->

<body>

<div class="main">
    <div id="app" class="">
        <!-- main content here -->


    <!-- Floating Button using Bootstrap -->
    <div class="fixed-button">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rsvpModal">
                            R<br>S<br>V<br>P
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
        <section class="container-fluid" id="heroSection">
               
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
                    <div class="">
                      <p>We are inviting you for the Wedding of ::::: </span></p>
                      <h1 class="text-hero text-center"><div class="bride">'. $weddingData['groomName'] .'</div> <div class="and">&</div> <div class="groom">'. $weddingData['brideName'] .'</div> </h1>
                  
                    </div>

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
                           <div>
                              <span class="sec">57</span><br>
                              <span class="timerText">Sec</span>
                          </div>
                          
                      </div>

                  </div>


                    </div>';
                }
              elseif (strpos($contentType, 'image') !== false) {
              ?>

               <!-- For image background -->
                       <div class="" style="background-image: url('<?php if(getImgURL('hero')){ echo getImgURL('hero'); }else{ echo assets('img/hero.png'); } ?>'); background-size: cover; background-position: center; height: 100vh;  display: flex; justify-content: center;  align-items: center;">
              <div class="">
                <p class="text-secondary">We are inviting you for the Wedding of</span></p>
                <h1 class="text-hero text-center"><div class="bride"><?= $weddingData['groomName'] ?></div> <div class="and">&</div> <div class="groom"><?= $weddingData['brideName'] ?></div> </h1>
            
              </div>

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
                     <div>
                        <span class="sec">57</span><br>
                        <span class="timerText">Sec</span>
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
        <!-- Hero end -->

 <?php require('nav.php'); ?>

        <!-- about start -->
        <section class="container-fluid text-primary" id="aboutSection">
                <div class="text-center" style="padding-bottom: 65px;">
                  <h1 class="text-primary-3">Save the Date</h1>
                  <h3> <?= formatTimeStamp($muhurt['startTime']) ?> </h3>
                </div>

        </section>
        <!-- about ends -->

        <!-- bride groom start -->
        <section class="container mt-4" id="coupleSection">

            <h1 class="section-head text-primary">Bride & Groom</h1>

            <div class="container mt-6 brideGroomCont">
                <div class="row align-items-center">
                    <!-- Column 1 -->
                    <div class="col-sm-5 bg-primary" style="border-radius: 0 0 25% 0;">
                        <div class="text-center b_img_div">
                            <img src="<?php if(getImgURL('bride')){echo getImgURL('bride');}else{ echo assets('img/upload.png');} ?>"
                            alt="Person 1" class="img-fluid brideImg">
                        </div>
                        <div class="text-center">
                          <h3 class="text-secondary"><?= $weddingData['brideName'] ?> <small class="text-center fs-6">( <?= $weddingData['brideQualifications'] ?> )</small></sub>
                        </h3>
                        <p class="text-left">
                          
                          <?= $weddingData['brideBio'] ?>
                        </p>
                        
                    </div>
                    </div>

                  <div class="text-center col-sm-2"><img src="<?php themeAssets($themeID,'img/heart.png') ?>" class="img-fluid" width="200"></div>

                    <!-- Column 2 -->
                    <div class="col-sm-5 mb-4 bg-primary" style="border-radius: 0 0 0 25%;margin-top: 20%;">

                      <div class="text-center g_img_div">
                            <img src="<?php if(getImgURL('groom')){echo getImgURL('groom');}else{ echo assets('img/upload.png');} ?>" alt="Person 2" class="img-fluid groomImg">
                        </div>

                        <div class="text-center">
                          <h3 class=" text-secondary"><?= $weddingData['groomName'] ?> <small class="text-center fs-6">( <?= $weddingData['groomQualifications'] ?> )</small></sub>
                            </h3>
                            <p class="text-right">
                              
                              <?= $weddingData['groomBio'] ?>
                          </p>
                        </div>

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

  <div class="container py-5">
    <div class="main-timeline-2">
      
      <div class="timeline-2 left-2">
        <div class="card">
          <img src="https://images.pexels.com/photos/2959192/pexels-photo-2959192.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top"
            alt="Responsive image">
          <div class="card-body p-4">
            <h4 class="fw-bold mb-4">How We Meet</h4>
            <p class="text-muted mb-4"><i class="far fa-clock" aria-hidden="true"></i> <?= $story['whenWeMet'] ?></p>
            <p class="mb-0"><?= $story['howWeMet'] ?></p>
          </div>
        </div>
      </div>

      <div class="timeline-2 right-2">
        <div class="card">
          <img src="https://images.pexels.com/photos/3156648/pexels-photo-3156648.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top"
            alt="Responsive image">
          <div class="card-body p-4">
            <h4 class="fw-bold mb-4">Engagement</h4>
            <p class="text-muted mb-4"><i class="far fa-clock" aria-hidden="true"></i> <?= $story['engagementYear'] ?></p>
            <p class="mb-0"><?= $story['engagement'] ?></p>
          </div>
        </div>
      </div>

      <div class="timeline-2 left-2">
        <div class="card">
          <img src="https://images.pexels.com/photos/5086401/pexels-photo-5086401.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top"
            alt="Responsive image">
          <div class="card-body p-4">
            <h4 class="fw-bold mb-4">Memorable Moments</h4>
            <p class="mb-0"><?= $story['memorableMoments'] ?></p>
          </div>
        </div>
      </div>
  
    </div>
  </div>

        </section>
    <?php } ?>
        <!--  our story ends -->


    <!-- Events start -->
    <section class="container mt-2" id="eventsSection">

      <h1 class="section-head">Events</h1>


      <div id="eventsCarousel" class="owl-carousel owl-theme mt-5">
 <?php if ($timeline != null){
                            for ($i = 0; $i < count($timeline); $i++){
                            	$datetimeObj1 = new DateTime($timeline[$i]['startTime']);
                            	$datetimeObj2 = new DateTime($timeline[$i]['endTime']);
                            	$from=$datetimeObj1->format("d-m-Y")." ".$datetimeObj1->format("H:i");
                            	$to=$datetimeObj2->format("d-m-Y")." ".$datetimeObj2->format("H:i");
                                ?>
                            
        <div class="item ">
          <div class="card bg-primary">
         <img src="<?php echo getImgURL($timeline[$i]['type']); ?>" class="eventImgDiv card-img-top" alt="Reception">
            <div class="card-body text-center">
              <h3 class="text-secondary"><?= $timeline[$i]['type'] ?></h3>
          
              <p class="card-text "><?php echo $from."<br> To <br> ".$to; ?>   </p>
              <div class="card-text d-flex align-items-center justify-content-center gap-2">

              <div> <?= $timeline[$i]['venue'] ?><br> 
              <?= str_replace("<br>", "\r\n", $timeline[$i]['address']) ?>
              </div>

              <div> <a href="<?= $timeline[$i]['locationURL'] ?>" target="_blank">
                <button class="btn-sm btn-secondary"><i class="bi bi-pin-map-fill"></i></button>
              </a> </div>

            </div>

              
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
        
        <div class="col-sm-12 text-start row align-items-center wavy-bottom">
            <h4 class="text-primary">Accomodation</h4>
            <p class=""><?= $weddingData['accommodation'] ?></p>

        </div>
    
    <div class="text-center"><img src="<?php themeAssets($themeID,'img/car.gif') ?>" class="img-fluid" width="200"></div>

        <div class="col-sm-12 text-end row align-items-center">
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


<p class="text-md text-center p-3">A Personalized Experience with ❤️ by <a class="link footer-link" href="https://eSubhalekha.com"
          target="_blank" rel="noopener noreferrer">eSubhalekha.com</a> </p>
          
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>

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

    <script>
      document.addEventListener('DOMContentLoaded', function(){
        // Activate Owl Carousel
        $('#heroCarousel').owlCarousel({
          loop: true,
          margin: 10,
          nav: false,
          dots: false,
          items: 1,
          autoplay: true,
          autoplayTimeout: 3000, // Set your preferred autoplay timeout
          autoplayHoverPause: true
        });
      });

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
          items: 4
        }
      }
    })

    </script>

    <script>
                
        // Set the end time for the countdown (year, month (0-indexed), day, hour, minute, second)
        var endTime = new Date("2024-02-10T12:00:00Z").getTime();

        // Update the countdown every second
        var x = setInterval(function() {
          // Get the current time
          var now = new Date().getTime();

          // Calculate the time difference
          var timeDifference = endTime - now;

          // If the countdown is over, display a message and stop the countdown
          if (timeDifference < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerHTML = "EXPIRED";
            return;
          }

          // Calculate days, hours, minutes, and seconds
          var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
          var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

          // Add leading zeros if necessary
          if (days < 10) days = "0" + days;
          if (hours < 10) hours = "0" + hours;
          if (minutes < 10) minutes = "0" + minutes;
          if (seconds < 10) seconds = "0" + seconds;

          // Display the countdown on all matching elements
          let daysSelected = document.querySelectorAll(".days");
          for (var i = 0; i < daysSelected.length; i++) {
            daysSelected[i].innerHTML = days;
          }

          let hoursSelected = document.querySelectorAll(".hours");
          for (var i = 0; i < hoursSelected.length; i++) {
            hoursSelected[i].innerHTML = hours;
          }

          let minSelected = document.querySelectorAll(".min");
          for (var i = 0; i < minSelected.length; i++) {
            minSelected[i].innerHTML = minutes;
          }

          let secSelected = document.querySelectorAll(".sec");
          for (var i = 0; i < secSelected.length; i++) {
            secSelected[i].innerHTML = seconds;
          }

        }, 1000);



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



</body>

</html>


