<?php

// errors(1);

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
<title><?php echo $weddingData['weddingName'] ?> - eSubhalekha.com </title>
<?php include("head.php"); ?>

<head>

  <link rel="stylesheet" href="<?php echo route("themes/".$themeID."/assets/index.css") ?>" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

  <!-- cdn of owlcarousel -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
  <script src="https://unpkg.com/lenis@1.0.45/dist/lenis.min.js"></script>

  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    @font-face {
      font-family: 'KyivTypeSans';
      src: url('<?php echo route("themes/".$themeID."/assets/fonts/kyiv-type-sans/KyivTypeSans-VarGX.ttf") ?>') format('truetype');
      font-weight: normal;
      font-style: normal;
    }

    * {
      font-family: 'KyivTypeSans';
      user-select: none !important;
    }

    img {
      pointer-events: none !important;
    }

    .footer-link:hover {
      color: #FFF;
      opacity: 80%;
    }

    .footer-link:focus,
    .footer-link:active {
      color: #FFF;
      opacity: 70%;
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

    #audioButton {
      cursor: pointer;
    }
        .fixedRSVP {
      position: fixed;
      bottom: 20px;
      left: 20px; 
      z-index: 1000; 
    }
    .modal{
      z-index: 99999;
    }


  </style>
</head>

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

<body class="w-screen relative bg-[#F7F2EA] h-auto overflow-x-hidden text-[#FFFFFF]">

  <button class="fixedRSVP px-3 h-[30px] bg-[#FFFFFF] text-[#FF006E] text-sm rounded-l-full rounded-r-full mt-3 active:bg-[#f2f2f2] duration-300 ease-in-out outline-none focus:outline-none hover:scale-105" data-bs-toggle="modal" data-bs-target="#rsvpModal">
            RSVP
          </button>


  <div class="main">

    <nav class="w-full py-2 bg-[#DA2E78] sticky top-0 z-40">
      <ul class="aos w-full flex justify-center items-center">
        <li><?= formatTimeStamp($muhurt['startTime']); ?></li>
      </ul>
    </nav>
    <div class="w-full h-full">
      <div class="w-full hero relative flex justify-center items-center overflow-hidden">
        <div class="absolute top-[400px] left-0 w-[160px] lg:w-[250px] overflow-hidden">
          <img class="aos w-full" src="<?php echo route("themes/".$themeID."/assets/images/decor_left.png") ?>" alt="" />
        </div>
        <div class="absolute top-[100px] right-0 w-[160px] lg:w-[250px] overflow-hidden">
          <img class="aos w-full" src="<?php echo route("themes/".$themeID."/assets/images/decor_right.png") ?>" alt="" />
        </div>
        <div class="w-[70%] max-w-[300px] lg:max-w-xl relative flex flex-col gap-[80px] mb-[100px]">
          <div id="decor-image"
            class="absolute top-[50%] right-[50%] lg:right-[55%] translate-x-[50%] -translate-y-[50%] w-[250px] lg:w-[450px] overflow-hidden">
            <img class="w-full" src="<?php echo route("themes/".$themeID."/assets/images/decor_middle.png") ?>" alt="" />
          </div>
          <div id="bride-name" class="aos w-full text-left text-5xl sm:text-6xl lg:text-7xl text-[#DA2E78]">
            <p><?php echo removeLastWord($weddingData['brideName']) ?></p>
          </div>
          <div id="groom-name" class="aos w-full text-right text-5xl sm:text-6xl lg:text-7xl text-[#DA2E78]">
            <p>& <?php echo removeLastWord($weddingData['groomName']) ?></p>
          </div>

        </div>


        <div class="aos w-full absolute bottom-[50px] left-0 flex flex-col justify-center items-center">

          <div class="scroll-down mb-3">
            <div class="arrow"></div>
            <div class="arrow"></div>
            <div class="arrow"></div>
          </div>
          <script>
            document.querySelector('.scroll-down').addEventListener('click', function () {
              const sectionOffsetTop = document.querySelector('#details').offsetTop;
              const scrollOffset = sectionOffsetTop - 100; // Adjust the number of pixels as needed
              window.scrollTo({
                top: scrollOffset,
                behavior: 'smooth'
              });
            });
          </script>
          <div class="w-full flex justify-center items-center gap-2" id="countdownContainer">
            <!-- Days, Hours, Minutes Display -->
            <div
              class="w-[60px] h-[60px] flex flex-col justify-center items-center rounded-xl text-[#DA2E78] bg-[#FFFFFF] border-[1px] border-[#FFFFFF] backdrop-blur-sm text-center"
              id="days">

            </div>
            <div
              class="w-[65px] h-[65px] flex flex-col justify-center items-center rounded-xl text-[#FBF9F5] bg-[#DA2E78] border-[1px] border-[#FFFFFF]" id="hours">
            </div>
            <div
              class="w-[60px] h-[60px] flex flex-col justify-center items-center rounded-xl text-[#DA2E78] bg-[#FFFFFF] border-[1px] border-[#FFFFFF] backdrop-blur-sm text-center" id="minutes">
            </div>
          </div>

          <script>
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
                document.getElementById("days").innerHTML = '<p class="text-2xl leading-tight">' + days + '</p><p class="text-xs">Days</p>';
                document.getElementById("hours").innerHTML = '<p class="text-2xl leading-tight">' + hours + '</p><p class="text-xs">Hours</p>';
                document.getElementById("minutes").innerHTML = '<p class="text-2xl leading-tight">' + minutes + '</p><p class="text-xs">Minutes</p>';
                document.getElementById("days").parentElement.style.display = "flex";
              } else {

                document.getElementById("days").innerHTML = '<p class="text-2xl leading-tight">' + hours + '</p><p class="text-xs">Hours</p>';
                document.getElementById("hours").innerHTML = '<p class="text-2xl leading-tight">' + minutes + '</p><p class="text-xs">Minutes</p>';
                document.getElementById("minutes").innerHTML = '<p class="text-2xl leading-tight">' + seconds + '</p><p class="text-xs">Seconds</p>';
              }

            }

            setInterval(updateCountdown, 1000);
          </script>

        </div>


        <div class="d-none w-full px-3 flex justify-center items-center gap-5 py-3">
          <p class="text-xs text-[#392632]">Bride&Groom</p>
          <p class="text-xs text-[#392632]">Events</p>
          <p class="text-xs text-[#392632]">Our story</p>
          <p class="text-xs text-[#392632]">Gallery</p>
        </div>
      </div>
      <div class="w-full relative">
        <div class="absolute -top-[18px] right-[50%] translate-x-[50%] z-40 row w-[180px]">

          <a href="<?= $muhurt['locationURL'] ?>" target="_blank">
          <button
            class="pe-2 flex items-center justify-evenly rounded-l-full rounded-r-full border-[3px] text-[#DA2E78] border-[#DA2E78] bg-[#FFFFFF] active:scale-90 duration-300 ease-in-out focus:outline-none active:outline-none col-12">
            <span class="material-icons me-2 my-1">location_on</span> Get Directions
          </button>
        </a>

          <?php if (!empty($weddingData['youtube'])) { ?>
            <button
              class="pe-2 my-3 flex items-center justify-evenly rounded-l-full rounded-r-full border-[3px] text-[#DA2E78] border-[#FFF] bg-[#FFF] active:scale-90 duration-300 ease-in-out focus:outline-none active:outline-none col-12"
              data-bs-toggle="modal" data-bs-target="#youtubeModal">
              <span class="material-icons me-2">smart_display</span> Watch Live
            </button>

          <?php } ?>
        </div>
      </div>


      <!-- YouTube Modal -->
      <div class="modal fade" id="youtubeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true" aria-labelledby="youtubeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-black" id="youtubeModalLabel">YouTube Live</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <iframe width="100%" height="400" class="embed-respon</div>sive-item"
                src="<?php echo $weddingData['youtube'] ?>" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen;"
                allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>

      <div class="d-none w-full relative">
        <div class="absolute -top-[18px] right-[50%] translate-x-[50%] z-40">
          <button
            class="h-[36px] w-[150px] flex items-center justify-center rounded-l-full rounded-r-full border-[3px] text-[#DA2E78] border-[#DA2E78] bg-[#FFFFFF] active:scale-90 duration-300 ease-in-out focus:outline-none active:outline-none"
            onclick="window.location.href = '<?php echo route($_REQUEST['id'] . "/" . $_REQUEST['lang'] . "/ar"); ?>'">
            <span class="material-icons me-2">view_in_ar</span> View in AR
          </button>

        </div>
      </div>
      <div class="w-full h-[500px] sm:h-[600px] relative flex justify-center items-start bg-[#DA2E78] overflow-hidden">
        <div class="w-full text-[#FFFFFF] flex flex-col justify-center items-center pt-[150px]">
          <p class="text-[#FFFFFF] text-5xl sm:text-6xl"><?= formatTimeStamp($muhurt['startTime']) ?></p>

          <p class="mt-3">we are getting married.</p>
        </div>
        <div
          class="w-[800px] sm:w-[1200px] lg:w-full h-[400px] absolute -bottom-[80px] sm:bottom-0 lg:-bottom-[60px] right-0">
          <img class="w-full translate-y-[10%] lg:-translate-y-[20%]"
            src="<?php echo route("themes/".$themeID."/assets/images/vector1.png") ?>" alt="" />
        </div>
      </div>
    </div>
    <div id="details" class="w-full pb-[50px] bg-[#FFFFFF]">
      <div class="w-full text-[#FF86BA] flex justify-center items-center">
        <p class="aos text-4xl text-center"><?php echo $weddingData['weddingName']; ?></p>
      </div>
      <div class="w-full flex flex-col sm:flex-row lg:flex-row justify-center items-center">
        <!-- about bride component -->
        <div class="flex flex-col justify-center items-start mt-5 px-4 lg:py-5">
          <div class="aos w-full flex justify-center items-start">
            <div
              class="w-[200px] h-[200px] bg-black rounded-full shadow-xl overflow-hidden border-[2px] border-[#FFFFFF]">

              <img class="w-full h-full object-cover brideImage" src="<?php if (getImgURL('bride'))
                echo getImgURL('bride'); ?>">

            </div>
          </div>
          <div class="max-w-[270px] flex flex-col justify-start items-center mt-3">
            <p class="aos text-md text-[#DA2E78] text-left text-xl w-full">
              <?php echo $weddingData['brideName'] ?>
            </p>
            <p class="aos text-xs text-[#6B6B6B] text-left">
              <?php echo $hosts['brideTagline']; ?> <b>Sri
                <?php echo $hosts['brideFather']['name']; ?></b> and
              <b>Srimathi
                <?php echo $hosts['brideMother']['name']; ?></b>
            </p>
          </div>
        </div>
        <div class="flex flex-col justify-center items-start mt-5 px-4 lg:py-5">
          <div class="aos w-full flex justify-center items-end">
            <div
              class="w-[200px] h-[200px] bg-black rounded-full shadow-xl overflow-hidden border-[2px] border-[#FFFFFF]">

              <img class="w-full h-full object-cover groomImage" src="<?php if (getImgURL('groom'))
                echo getImgURL('groom'); ?>">
            </div>
          </div>
          <div class="max-w-[270px] flex flex-col justify-start items-center mt-3">
            <p class="aos text-md text-[#DA2E78] text-left text-xl w-full">
              <?php echo $weddingData['groomName'] ?>
            </p>
            <p class="aos text-xs text-[#6B6B6B] text-left">
              <?php echo $hosts['groomTagline']; ?> <b>Sri
                <?php echo $hosts['groomFather']['name']; ?></b> and
              <b>Srimathi
                <?php echo $hosts['groomMother']['name']; ?></b>
            </p>
          </div>
        </div>
        <!-- about groom component -->
      </div>
    </div>
    <div class="w-full flex flex-col bg-[#0A0A0A]">
      <div class="w-full py-2 flex justify-center items-center bg-[#832E52]">
        <p class="text-xl">Gallery</p>
      </div>
      <div class="w-full flex flex-col justify-center lg:items-center">
        <div class="flex justify-center items-center lg:max-w-7xl py-7 px-3">
          <p class="text-[#FFFFFF] sm:max-w-xl lg:max-w-3xl text-center text-3xl sm:text-4xl lg:text-5xl">
            Moments Forever: Our Wedding Journey
          </p>
        </div>
        <div class="lg:max-w-7xl relative py-5 overflow-hidden">
          <!-- <div class="absolute top-[30px] right-[50%] translate-x-[50%] z-20">
              <button
                class="rounded-r-full bg-[#D9D9D9] border-[1px] text-[#000000] border-[#A0A0A0] px-4 h-[30px] rounded-l-full active:bg-[#c9c9c9] duration-300 ease-in-out outline-none focus:outline-none"
              >
                Explore
              </button>
            </div> -->
          <div
            class="absolute top-[50%] -translate-y-[50%] left-[10px] z-20 bg-[rgb(0,0,0,0.6)] backdrop-blur-sm border-[rgb(250,250,250,0.3)] border-[1px] prev w-[40px] h-[40px] rounded-full flex justify-center items-center hover:cursor-pointer">
            <i class="bx bx-left-arrow-alt text-2xl"></i>
          </div>
          <div
            class="absolute top-[50%] -translate-y-[50%] right-[10px] z-20 bg-[rgb(0,0,0,0.6)] backdrop-blur-sm border-[rgb(250,250,250,0.3)] border-[1px] next w-[40px] h-[40px] rounded-full flex justify-center items-center hover:cursor-pointer">
            <i class="bx bx-right-arrow-alt text-2xl"></i>
          </div>
          <div
            class="owl-carousel w-full max-w-[1000px] h-[450px] lg:h-[650px] flex justify-center items-center overflow-hidden">


          <?php 
            if (!$preweddingGallery['error']){
                for ($i = 0; $i < count($preweddingGallery); $i++){
                        if (!$preweddingGallery['error']){
                         for ($i = 0; $i < count($preweddingGallery); $i++){
                          $headers = get_headers($preweddingGallery[$i]['imageURL'], 1);
                          if (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'image') !== false){
                  ?>


                <div class="w-full h-full">
                  <img src="<?= $preweddingGallery[$i]['imageURL'] ?>" class="w-full gallery-images"
                    style="border-radius: 40px; height: 600px; width: 400px; object-fit: cover;">
                </div>

                                                                                                                                             
                    <?php 

                      } // image type ends
                      elseif (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'video') !== false) {
                    ?>
                      <div class="w-full h-full">
                        <video controls style="object-fit: cover;  width:-webkit-fill-available;" class="w-full gallery-images">
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
        </div>
      </div>
    </div>
    <div class="w-full bg-[#FF006E]">
      <div class="max-w-6xl mx-auto py-[180px] relative overflow-hidden">
        <p class="absolute text-7xl top-0 left-0 rotate-[20deg] blur-[3px]">
          <?php echo removeLastWord($weddingData['brideName']); ?>
        </p>
        <p class="absolute text-7xl lg:text-[60pt] bottom-0 right-0 -rotate-[25deg] blur-[3px]">
          <?php echo removeLastWord($weddingData['groomName']); ?>
        </p>
        <p class="absolute hidden lg:block scale-[80%] text-7xl bottom-[20%] left-0 -rotate-[10deg] blur-[6px]">
          <?php echo removeLastWord($weddingData['brideName']); ?>
        </p>
        <p class="absolute hidden lg:block scale-[80%] text-7xl top-[20%] right-0 -rotate-[10deg] blur-[6px]">
          <?php echo removeLastWord($weddingData['groomName']); ?>
        </p>

        <div class="flex flex-col justify-center items-center bg-[#FF006E]">
          <p class="text-3xl">Are you attending??</p>
          <button
            class="px-3 h-[30px] bg-[#FFFFFF] text-[#FF006E] text-sm rounded-l-full rounded-r-full mt-3 active:bg-[#f2f2f2] duration-300 ease-in-out outline-none focus:outline-none hover:scale-105"
            data-bs-toggle="modal" data-bs-target="#rsvpModal">
            I am attending
          </button>
        </div>
        <!-- RSVP Modal -->
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
                    <button id="submitBtn" type="submit"
                      class="h-[36px] w-[150px] rounded-l-full rounded-r-full border-[3px] text-[#FFF] border-[#DA2E78] bg-[#DA2E78] active:scale-90 duration-300 ease-in-out focus:outline-none active:outline-none" name="submitRSVP">Submit</button>
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

      </div>
    </div>

    <div class="w-full py-[30px] d-none bg-[#2F0014]">
      <!-- Our story section -->
      <div
        class="w-full primary_font h-[800px] sm:h-[1000px] py-[30px] text-[#FFFFFF] lg:py-[60px] relative overflow-hidden">
        <div class="sm:pb-[50px] lg:pb-[100px] flex flex-col justify-center items-center">
          <div class="w-full flex justify-center items-center text-[#FFFFFF] text-[30pt] sm:pb-[80px]">
            Our story
          </div>

          <div id="container" class="scale-[80%] sm:scale-100">
            <svg width="351" height="646" viewBox="0 0 351 646" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path id="svg-path" d="M1 0.5V845.5" stroke="#FAEFE1" stroke-width="2" />
            </svg>

            <div class="path-div" data-index="0" data-percentage="1">
              <div
                class="h-[70px] w-[70px] rounded-full sm:h-[90px] sm:w-[90px] relative overflow-hidden px-1 py-1 bg-[#FAEFE1]">
                <div class="w-full h-full bg-[#FAEFE1] rounded-full overflow-hidden">
                  <img src="./assets/images/BrideAndGroom.png" class="object-cover w-full" alt="" />
                </div>
              </div>
              <div
                class="absolute flex flex-col gap-1 left-[100px] top-[50%] -translate-y-[50%] min-w-[280px] max-w-[340px] px-3 py-2 rounded-lg bg-[rgb(243,243,243,0.27)] border-[rgb(243,243,243,0.27)] border-[1px] backdrop-blur-[6px]">
                <div class="w-full text-2xl text-center">How we met...</div>
                <p class="w-full px-1 text-sm text-center font-light">
                  <?= $story['whenWeMet'] ?>, <?= $story['howWeMet'] ?>
                </p>
              </div>
            </div>
            <div class="path-div" data-index="1" data-percentage="40">
              <div
                class="h-[70px] w-[70px] rounded-full sm:h-[90px] sm:w-[90px] relative overflow-hidden px-1 py-1 bg-[#FAEFE1]">
                <div class="w-full h-full bg-[#FAEFE1] rounded-full overflow-hidden">
                  <img src="./assets/images/BrideAndGroom.png" class="object-cover w-full" alt="" />
                </div>
              </div>
              <div
                class="absolute flex flex-col gap-1 left-[100px] top-[50%] -translate-y-[50%] min-w-[280px] max-w-[340px] px-3 py-2 rounded-lg bg-[rgb(243,243,243,0.27)] border-[rgb(243,243,243,0.27)] border-[1px] backdrop-blur-[6px]">
                <div class="w-full text-2xl text-center">little love....</div>
                <p class="w-full px-1 text-sm text-center font-light">
                  <?= $story['memorableMoments'] ?>
                </p>
              </div>
            </div>
            <div class="path-div" data-index="2" data-percentage="80">
              <div
                class="h-[70px] w-[70px] rounded-full sm:h-[90px] sm:w-[90px] relative overflow-hidden px-1 py-1 bg-[#FAEFE1]">
                <div class="w-full h-full bg-[#FAEFE1] rounded-full overflow-hidden">
                  <img src="./assets/images/BrideAndGroom.png" class="object-cover w-full" alt="" />
                </div>
              </div>
              <div
                class="absolute flex flex-col gap-1 left-[100px] top-[50%] -translate-y-[50%] min-w-[280px] max-w-[340px] px-3 py-2 rounded-lg bg-[rgb(243,243,243,0.27)] border-[rgb(243,243,243,0.27)] border-[1px] backdrop-blur-[6px]">
                <div class="w-full text-2xl text-center">
                  We are engaged...
                </div>
                <p class="w-full px-1 text-sm text-center font-light">
                  <?= $story['engagementYear'] ?>, <?= $story['engagement'] ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Our story ends here -->
    </div>
    <div class="w-full py-[30px]  bg-black flex flex-col">
      <div class="w-full h-auto pb-3 lg:pb-0 px-3 flex flex-col lg:flex-row sm:max-w-xl lg:max-w-4xl mx-auto">
        <div class="w-full flex-col">
          <p class="text-7xl">Events.</p>
          <div class="flex flex-wrap mt-2 gap-y-1 gap-x-2">

            <?php foreach ($timeline as $event) {
              ?>

              <div
                class="px-3 py-1 border rounded-l-full rounded-r-full text-xs active:scale-90 duration-300 ease-in-out focus:outline-none active:outline-none">
                <?php echo (empty($event['event'])) ? $event['type'] : $event['event']; ?>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
        <div class="w-full flex-row hidden lg:flex">
          <i class="bx bx-right-arrow-alt text-[150pt] leading-tight rotate-45 -translate-y-[25%] text-[#AAAAAA]"></i>
          <p class="max-w-[200px] text-xs text-[#DCDCDC] font-light">
            <span class="text-[#DA2E78] font-bold">Did you know?</span> <span>The Saptapadi involves seven
              vows for a
              happy married life.</span>

          </p>
        </div>
      </div>
      <div class="w-full flex justify-center items-center">
        <div class="w-full max-w-4xl flex flex-col lg:flex-row justify-center items-center gap-[50px] lg:gap-3 px-3">

          <div class="owl-carousel">
            <?php foreach ($timeline as $event) { ?>
              <!-- event component starts -->
              <div
                class="w-full lg:max-w-[400px] h-[480px] bg-[#FFC1C1] flex flex-col justify-start items-center relative rounded-[24px] px-[4px]">
                <button
                  class="absolute right-[50%] translate-x-[50%] bottom-28 translate-y-[50%] px-4 py-1 my-3 bg-[#FF006E] rounded-l-full rounded-r-full hover:scale-105 duration-300 ease-in-out shadow-sm hover:shadow-xl">
                  <?php echo date('F j', strtotime($event['startTime'])) ?>
                </button>
                <div
                  class="w-full h-[350px] bg-white mt-[4px] border border-[rgb(255,255,255,.1)] rounded-[20px] overflow-hidden">
                  <img class="w-full h-full object-cover" src="<?php echo getImgURL($event['type']) ?>" alt="" />
                </div>
                <div class="w-full flex flex-col justify-between items-stretch py-auto px-[12px] mt-2">
                  <h1 class="text-3xl text-[#FF006E]"><?php echo (empty($event['event'])) ? ucfirst($event['type']) : $event['event']; ?></h1>
                  <h2 class="text-sm font-light text-[#A20000] pl-1">

                    <?php echo date('g:i A', strtotime($event['startTime'])) . " - " . date('g:i A', strtotime($event['endTime'])); ?>
                    <h3
                      class="px-2 py-1 mr-auto border border-white rounded-l-full rounded-r-full text-[#A20000] bg-[rgb(255,255,255,.6)] text-xs mt-1">
                      <?php echo $event['venue'] ?>
                    </h3>
                  </h2>
                </div>
              </div>
              <!-- event component ends -->
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="w-full bg-black">
        <div class="w-full flex flex-col bg-black max-w-6xl mx-auto">
          <div class="w-full"><h1>Events</h1></div>
          <div class="w-full flex flex-col">
            <div class=""></div>
          </div>
        </div>
      </div> -->
    <div class="w-full d-none flex flex-col justify-center items-center py-[50px] lg:py-[100px] bg-black px-3">
      <p class="w-full text-center text-4xl lg:text-5xl">Accomadation</p>
      <p class="w-full max-w-3xl text-center font-light text-xs lg:text-sm mt-3">
        <?= $weddingData['accommodation'] ?>
      </p>
    </div>
    <div class="w-full d-none flex flex-col justify-center items-center py-[50px] lg:py-[100px] bg-black px-3">
      <p class="w-full text-center text-4xl lg:text-5xl">Travel</p>
      <p class="w-full max-w-3xl text-center font-light text-xs lg:text-sm mt-3">
        <?= $weddingData['travel'] ?>
      </p>
    </div>
    <div class="w-full flex flex-col bg-black">
      <div class="max-w-6xl mx-auto py-[50px] lg:py-[100px]">
        <div class="w-full flex flex-col sm:flex-row gap-3">
          <div class="w-full flex flex-col">
            <p class="text-5xl">Venue</p>
            <div class="h-[300px] w-[310px] sm:w-[400px] lg:w-[550px] mt-2 relative overflow-hidden">
              <i
                class="bx bx-right-arrow-alt absolute -right-[20px] text-[100pt] leading-tight -rotate-45 -translate-y-[25%] text-[#FFFFFF]"></i>
              <img class="w-full h-full object-cover"
                src="<?php echo route("themes/".$themeID."/assets/images/venue.jpg"); ?>" alt="" />
            </div>
          </div>
          <p class="w-full max-w-[300px] mt-2 sm:pt-[50px] text-left font-light text-s">
            <strong class="text-[#DA2E78] font-bold">SPS Function Hall, Dondapudi</strong> is the perfect
            venue for our
            wedding, combining charm, elegance, and modern amenities. We’re excited to celebrate our special
            day here,
            creating unforgettable memories with our loved ones.

            <a href="<?= $muhurt['locationURL'] ?>" target="_blank">
            <button
              class="pe-2 my-3 flex items-center justify-center rounded-l-full rounded-r-full border-[3px] text-[#FFF] border-[#DA2E78] bg-[#DA2E78] active:scale-90 duration-300 ease-in-out focus:outline-none active:outline-none">
              <span class="material-icons me-2">location_on</span> Get Directions
            </button>
          </a>



          </p>
        </div>
      </div>
    </div>
    <div class="w-full flex justify-center items-center py-[60px] sm:py-[100px]">
      <div class="flex flex-col justify-center items-center">
        <p class="text-[#000000] text-4xl sm:text-5xl lg:text-7xl">
          We are excited!!
        </p>
        <p class="text-[#777777] max-w-[320px] lg:max-w-[400px] leading-tight text-center text-xs mt-3">
          We can't wait to celebrate this special day with you. Your presence will make our wedding even more
          memorable
          and meaningful.
        </p>
        <button
          class="bg-[#000000] px-4 py-2 rounded-r-full rounded-l-full mt-2 active:scale-90 duration-300 ease-in-out focus:outline-none active:outline-none"
          onclick="window.scrollTo({ top: 0, behavior: 'smooth' })">
          <p class="text-xs">Back to Top</p>
        </button>
      </div>
    </div>



    <audio id="player" src="<?php echo $weddingData['music'] ?>" autoplay loop></audio>

    <div id="audioButton"
      class="fixed bottom-4 right-4 bg-[#fff] z-20 border-[#DA006E] border-1 text-white px-2 rounded hover:bg-[#FF86BA] focus:bg-[#FF86BA] active:bg-[#DA006E]">
      <i class="bi bi-volume-up-fill text-[#DA2E78] hover:text-[#FFF] focus:text-[#FFF] active:text-[#FFF] fs-2"></i>
    </div>
  </div>

  <script>
    var player = document.querySelector("#player");
    var audioIcon = document.querySelector("#audioIcon");
    var audioButton = document.getElementById('audioButton');

    player.muted = false;
    audioButton.addEventListener('click', function () {
      if (player.muted) {
        player.muted = false;
        audioButton.innerHTML = '<i class="bi bi-volume-mute-fill text-[#DA2E78] hover:text-[#FFF] focus:text-[#FFF] active:text-[#FFF] fs-2"></i>';
      } else {
        player.muted = true;
        audioButton.innerHTML = '<i class="bi bi-volume-up-fill text-[#DA2E78] hover:text-[#FFF] focus:text-[#FFF] active:text-[#FFF] fs-2"></i>';
      }
    })


    // Function to play audio
    function playAudio() {
      player.play().catch(function (error) {
        console.log('Playback prevented:', error);
      });
      document.removeEventListener('click', playAudio); // Remove listener after the first interaction
    }

    // Autoplay workaround - play audio on first user interaction
    document.addEventListener('click', playAudio);
  </script>




  <footer class="w-full bg-[#86363b] py-2">
    <div class="max-w-6xl mx-auto text-center text-[#FFFFFF]">
      <p class="text-md">A Personalized Experience with ❤️ by <a class="link footer-link" href="https://eSubhalekha.com"
          target="_blank" rel="noopener noreferrer">eSubhalekha.com</a> </p>
    </div>
    </div>
    </div>
  </footer>


  </div>


</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
  $(".owl-carousel").owlCarousel({
    loop: true,
    margin: 10,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
        nav: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 8000,
        autoplayHoverPause: true,
      },
      600: {
        items: 2,
        nav: false,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 8000,
        autoplayHoverPause: true,
      },
      1000: {
        items: 2,
        nav: true,
        loop: false,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 8000,
        autoplayHoverPause: true,
      },
    },
  });


  var owl = $(".owl-carousel");
  $(".prev").click(function () {
    owl.trigger("prev.owl");
  });
  // Go to the previous item
  $(".next").click(function () {
    owl.trigger("next.owl");
  });


</script>
<script>
  function getPathPosition(path, percentage) {
    const length = path.getTotalLength();
    return path.getPointAtLength(length * percentage);
  }

  function placeDivs() {
    const path = document.getElementById("svg-path");
    const divs = document.querySelectorAll(".path-div");

    divs.forEach((div) => {
      const percentage = div.dataset.percentage / 100;
      const {
        x,
        y
      } = getPathPosition(path, percentage);

      div.style.left = `${x}px`;
      div.style.top = `${y}px`;
    });
  }

  window.onload = placeDivs()
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
          setTimeout(() => {
            entry.target.classList.add("in-view");
          }, index * 200); // Adjust the multiplier for delay between each element
        } else {
          entry.target.classList.remove("in-view"); // Remove the class when out of view
        }
      });
    });

    const elementsToAnimate = document.querySelectorAll('.aos');
    elementsToAnimate.forEach(function (element) {
      observer.observe(element);
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

</html>