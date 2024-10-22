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
<head>
      
    <?php require("views/partials/themes/metatags.php"); ?>

    <title><?php echo $weddingData['weddingName'] ?> - eSubhalekha.com </title>


      <script src="https://kit.fontawesome.com/ff56cc0d89.js" crossorigin="anonymous"></script>
      <script src="https://cdn.tailwindcss.com"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
      <title>Template-1</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <style>
        .bg-customRed {
            background-color: #4169E1; 
        }
        .bg-customPink {
            background-color: #EEEDFF; 
        }
        .bg-Pink2 {
            background-color: #EEEDFF; 
        }
        .bg-lightPink {
            background-color: #C0A975;
        }
        .text-customRed {
            color: #4169E1; 
        }
        .text-customPink {
            color: #EEEDFF; 
        }
        .text-Pink2 {
            color: #EEEDFF; 
        }
        .text-lightPink {
            color: #C0A975; 
        }

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
        color:#fff;
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
</head>


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

<body class="relative bg-white">

   <div id="rsvpButton" class="fixedRSVP text-customRed bg-white font-bellefair text-[24px] px-10 rounded-full my-8 py-1 text-center">RSVP</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


  <div class="main">

    <div class="justify-between block min-h-screen px-4 py-8 bg-customRed xl:flex lg:px-28 lg:py-0">
        <div class ="relative flex justify-center my-auto -top-4"> 
            <img src="<?php if (getImgURL('hero')) echo getImgURL('hero'); ?>" alt="hero image" class="h-[380px] lg:h-[540px] w-[340px] lg:w-[420px]" />
        </div>
        <div class="relative -left-0 my-14 lg:my-auto lg:-left-24">
            <h2 class="max-w-full lg:max-w-[652px] text-[32px] mx-auto xl:text-[50px] text-white text-center font-imprima">
                We are Inviting you to our Wedding
            </h2>
            <div class="flex my-10 lg:my-10 mx-auto justify-between font-imprima text-white max-w-[300px] lg:max-w-[480px]">
                <div class="block">
                    <h1 class="text-[40px] xl:text-[75px] text-center" id="days">61</h1>
                    <p class="text-[16px] text-center xl:text-[30px] font-bold text-customPink font-rubik">Days</p>
                </div>
                <div class="block">
                    <h1 class="text-[40px] xl:text-[75px] text-center" id="hours">15</h1>
                    <p class="text-[16px] text-center xl:text-[30px] font-bold text-customPink font-rubik">Hours</p>
                </div>
                <div class="block">
                    <h1 class="text-[40px] xl:text-[75px] text-center" id="minutes">12</h1>
                    <p class="text-[16px] text-center xl:text-[30px] font-rubik font-bold text-customPink">Minutes</p>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center -mt-6">
      <a href="<?= $muhurt['locationURL'] ?>" target="_blank">
        <div class="flex justify-center text-[20px] lg:text-[24px] px-8 lg:px-10 py-2 rounded-full bg-customPink text-center text-customRed">
          Get Directions
        </div>
      </a>
    </div>
    <div class="min-h-screen">
        <div>
          <h2 class="text-customRed text-[32px] lg:text-[60px] tracking-normal lg:tracking-wide text-center font-bellefair mt-7 lg:mt-20">Gudivada Vari Pelli Sandadi</h2>
        </div>
        <div class="flex justify-center ">
          <img src='<?php themeAssets($themeID,"img/border.png");?>' alt="border" class=" w-[200px] lg:w-[350px] h-[7px] lg:h-[8px]" />
        </div>
        <div class="justify-center block gap-32 my-20 lg:flex lg:my-28">
          <div class=" my-5 bg-Pink2 w-[320px] mx-auto lg:mx-0 lg:w-[400px] h-[310px] lg:h-[360px] flex justify-center">
            <div class="">
              <img src="<?php if (getImgURL('groom')) echo getImgURL('groom'); ?>" alt="groom" class=" relative mx-auto -top-14 w-[125px] h-[110px] lg:w-[175px] lg:h-[150px]"/>
              <h3 class=" text-center text-customRed font-inder text-[28px] lg:text-[32px] relative -top-10"> <?php echo removeLastWord($weddingData['groomName']); ?> </h3>
              <p class=" relative max-w-[300px] lg:max-w-[350px] text-customRed font-imprima -top-6 lg:-top-0 text-[16px] text-center"> <?= $weddingData['groomBio'] ?> </p>
            </div>
          </div>
          <div class="my-20 lg:my-5 bg-Pink2 w-[320px] mx-auto lg:mx-0 lg:w-[400px] h-[310px] lg:h-[360px] flex justify-center">
            <div class="">
              <img src="<?php if (getImgURL('bride')) echo getImgURL('bride'); ?>" alt="bride" class=" relative mx-auto -top-14 w-[125px] h-[110px] lg:w-[175px] lg:h-[150px]"/>

              <h3 class=" text-center text-customRed font-inder text-[28px] lg:text-[32px] relative -top-10"> <?php echo removeLastWord($weddingData['brideName']); ?> </h3>
              <p class="relative max-w-[300px] lg:max-w-[350px] text-customRed font-imprima -top-6 lg:-top-0 text-[16px] text-center"> <?= $weddingData['brideBio'] ?> </p>
            </div>
          </div>
        </div>
      </div>
      <div class="min-h-screen px-16 lg:px-20 mt-8 lg:mt-0">
        <div>
          <h2 class="text-customRed text-[32px] lg:text-[60px] tracking-normal lg:tracking-wide text-center font-bellefair mt-0 lg:mt-20">Gallery</h2>
        </div>
        <div class="flex justify-center mb-14">
          <img src='<?php themeAssets($themeID,"img/border.png");?>' alt="border" class="w-[120px] lg:w-[200px] lg:h-auto h-[7px]" />
        </div>

        <div class="relative">
            <div class="flex justify-center  owl-carousel owl-theme mx-auto">

          <?php 
            if (!$preweddingGallery['error']){
                for ($i = 0; $i < count($preweddingGallery); $i++){
                        if (!$preweddingGallery['error']){
                         for ($i = 0; $i < count($preweddingGallery); $i++){
                          $headers = get_headers($preweddingGallery[$i]['imageURL'], 1);
                          if (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'image') !== false){
                  ?>

                  <div class="flex justify-center mx-0 lg:mx-4">
                    <img src="<?= $preweddingGallery[$i]['imageURL'] ?>" alt="image" class="w-[400px] h-[480px] lg:w-[280px] lg:h-[500px] item" />
                </div>
                                                                                                                                             
                    <?php 

                      } // image type ends
                      elseif (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'video') !== false) {
                    ?>
                      <div class="flex justify-center mx-0 lg:mx-4">
                        <video controls style="object-fit: cover;  width:-webkit-fill-available;" class="item">
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


            <button class="absolute right-full owl-carousel__prev lg:mr-0 mr-1 lg:right-full top-[50%] transform -translate-y-1/2 p-5 w-12 h-12 bg-customPink text-white rounded-full">
                <i class="fa-solid fa-chevron-left relative -top-2"></i>
            </button>
            <button class="absolute left-full owl-carousel__next lg:ml-0 ml-1 lg:left-full top-[50%] transform -translate-y-1/2 p-5 w-12 h-12 bg-customPink text-white rounded-full">
                <i class="fa-solid fa-chevron-right relative -top-2"></i>
            </button>
        </div>
      </div>
      <div class="relative flex items-center justify-center h-96 bg-customRed -top-40 lg:-top-0">
        <div class="">
          <h3 class=" text-white my-4 font-inder text-[28px]">Are You Attending?</h3>
          <div id="rsvpButton" class="bg-white flex my-4 justify-center text-customRed text-[24px] font-inder py-0.5 rounded-3xl">I am attending</div>
        </div>
      </div>

      <!-- RSVP Modal -->
<div class="modal fixed inset-0 flex items-center justify-center hidden" id="rsvpModal" style="z-index: 999999;">
  <div class="modal-backdrop fixed inset-0 bg-black opacity-50"></div> <!-- Modal Background -->
  <div class="modal-dialog relative bg-white rounded-lg shadow-lg z-10 max-w-lg w-full p-6">
    <div class="modal-content text-gray-800">
      <div class="modal-header flex justify-between items-center mb-4">
        <h5 class="modal-title text-2xl font-semibold">RSVP</h5>
        <button id="closeModal" type="button" class="text-2xl font-bold text-gray-500 hover:text-gray-700">&times;</button>
      </div>
      
      <?php 
        if (isset($_REQUEST['submitRSVP'])) {
          controller("Guest");
          $guestObj = new Guest();
          $_REQUEST['weddingID'] = $_REQUEST['id'];
          $_REQUEST['lang'] = $_REQUEST['lang'];
          $addGuest = $guestObj->create($_REQUEST);
        }
      ?>
      
      <form id="rsvpForm" method="POST">
        <div class="modal-body space-y-4">
          <div class="mb-3">
            <label for="nameInput" class="form-label block text-sm font-medium text-gray-700">Name*</label>
            <input type="text" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="nameInput" name="name" required>
          </div>
          <div class="mb-3">
            <label for="phoneInput" class="form-label block text-sm font-medium text-gray-700">Phone (WhatsApp)*</label>
            <input type="text" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="phoneInput" name="phone" required>
          </div>
          <div class="mb-3">
            <label for="additionalGuests" class="form-label block text-sm font-medium text-gray-700">Number of people attending*</label>
            <input type="number" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="additionalGuests" name="additionalGuests" required />
          </div>
          <div class="mb-3">
            <label for="guestMessage" class="form-label block text-sm font-medium text-gray-700">Message</label>
            <textarea class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="guestMessage" name="guestMessage" rows="3"></textarea>
          </div>
        </div>
        
        <div class="modal-footer flex justify-end mt-6">
          <button id="submitBtn" type="submit" class="text-customRed bg-white font-bellefair text-[24px] px-10 rounded-full my-8 py-1 text-center" name="submitRSVP">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- JavaScript to handle modal functionality -->
<script>
  // Get modal elements
  const rsvpModal = document.getElementById('rsvpModal');
  const rsvpButton = document.getElementById('rsvpButton');
  const closeModal = document.getElementById('closeModal');
  const modalBackdrop = document.querySelector('.modal-backdrop');

  // Show modal function
  function showModal() {
    rsvpModal.classList.remove('hidden');
  }

  // Hide modal function
  function hideModal() {
    rsvpModal.classList.add('hidden');
  }

  // Add event listeners
  rsvpButton.addEventListener('click', showModal);
  closeModal.addEventListener('click', hideModal);
  modalBackdrop.addEventListener('click', hideModal);

  // WhatsApp link and form submission logic
  document.getElementById("submitBtn").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default form submission
    var name = document.getElementById("nameInput").value;
    var phone = document.getElementById("phoneInput").value;
    var additionalGuests = document.getElementById("additionalGuests").value;
    var message = document.getElementById("guestMessage").value;

    // Open WhatsApp link
    var url = "https://api.whatsapp.com/send?phone=+919989352171&text=" +
      encodeURIComponent('Name: ' + name + '\nPhone: ' + phone +
        '\nAdditional Guests: ' + additionalGuests + '\nMessage: ' + message);
    window.open(url, "_blank");

    // Submit form after WhatsApp link is opened
    document.getElementById("rsvpForm").submit();
  });
</script>







      <div class="min-h-screen px-0 lg:px-20 relative">
        <div>
          <h2 class="text-customRed text-[32px] lg:text-[60px] tracking-normal lg:tracking-wide text-center font-bellefair mt-0 lg:mt-20">Events</h2>
        </div>
        <div class="flex justify-center mb-14">
          <img src='<?php themeAssets($themeID,"img/border.png");?>' alt="border" class="w-[120px] lg:w-[200px] lg:h-[7px] h-[4px]" />
        </div>
        <div class="relative">
            <div class=" flex justify-center mx-auto owl-carousel owl-theme max-w-[300px] lg:max-w-full">

              <?php
                if ($timeline != null){
                            for ($i = 0; $i < count($timeline); $i++){
                                ?>

                <div class="flex justify-center mx-0 lg:mx-4">
                    <div class="block bg-lightPink rounded-3xl lg:w-[280px] w-[250px] item">
                        <img src="<?php echo getImgURL($timeline[$i]['type']) ?>" alt="event1" class="h-[350px] w-full lg:w-[300px]" />
                        <div class="w-full text-customRed">
                        <h3 class="mt-8 text-[28px] text-center font-inder"><?php echo (empty($timeline[$i]['event'])) ? $timeline[$i]['type'] : $timeline[$i]['event']; ?></h3>
                        <p class="mt-2 text-[16px] font-imprima text-center"><?php echo date('g:i A', strtotime($timeline[$i]['startTime'])) . " - " . date('g:i A', strtotime($timeline[$i]['endTime'])); ?></p>
                        <p class="font-imprima text-[16px] text-center"><?php echo $timeline[$i]['venue'] ?></p>
                        <p class="mt-2 text-[16px] text-center mb-10"> <?php echo $timeline[$i]['address'] ?> </p>
                        </div>
                    </div>
                </div>

            <?php }} ?>

            </div>
            <button class="absolute -left-0 owl-carousel__prev lg:mr-0 mr-0 lg:right-full top-[50%] transform -translate-y-1/2 p-5 w-12 h-12 bg-customPink text-white rounded-full">
                <i class="fa-solid fa-chevron-left relative -top-2"></i>
            </button>
            <button class="absolute -right-0 owl-carousel__next lg:ml-0 ml-0 lg:left-full top-[50%] transform -translate-y-1/2 p-5 w-12 h-12 bg-customPink text-white rounded-full">
                <i class="fa-solid fa-chevron-right relative -top-2"></i>
            </button>
        </div>
      </div>
      <div class="min-h-screen ">
        <div>
            <h2 class="text-customRed text-[32px] lg:text-[60px] tracking-normal lg:tracking-wide text-center font-bellefair mt-0 lg:mt-20">Our Story</h2>
        </div>
        <div class="flex justify-center mb-14">
            <img src='<?php themeAssets($themeID,"img/border.png");?>' alt="border" class="w-[120px] lg:w-[200px] lg:h-[7px] h-[4px]" />
        </div>
        <div class="flex items-center justify-center ">
            <div>
                <div class="relative flex items-center justify-center mb-10">
                    <img src='<?php themeAssets($themeID,"img/b.png");?>' alt="left" class="z-10 w-20 h-20 my-auto" />
                    <div class="ml-8 lg:ml-20 bg-lightPink min-h-40 lg:min-h-44 w-[260px] lg:w-[420px] px-4 rounded-2xl">
                        <h4 class="text-center font-bellefair text-[24px] mt-2">How we met</h4>
                        <p class="text-center font-bellefair text-[16px] mt-2 lg;mt-6">
                            <?= $story['whenWeMet'] ?>, <?= $story['howWeMet'] ?>
                        </p>
                    </div>
                    <div class="absolute left-[36px] top-20 h-full w-[1px] bg-customRed z-0"></div>
                </div>
                <div class="relative flex items-center justify-center mt-10">
                    <img src='<?php themeAssets($themeID,"img/b.png");?>' alt="left" class="z-10 w-20 h-20 my-auto" />
                    <div class="ml-8 lg:ml-20 bg-lightPink min-h-40 lg:min-h-44 w-[260px] lg:w-[420px] px-4 rounded-2xl">
                        <h4 class="text-center font-bellefair text-[24px] mt-2">Engaged</h4>
                        <p class="text-center font-bellefair text-[16px] mt-2 lg;mt-6">
                            <?= $story['engagementYear'] ?>, <?= $story['engagement'] ?>
                        </p>
                    </div>
                    <div class="absolute left-[36px] top-20 h-full w-[1px] bg-customRed z-0"></div>
                </div> 
                <div class="relative flex items-center justify-center mt-10">
                    <img src='<?php themeAssets($themeID,"img/b.png");?>' alt="left" class="z-10 w-20 h-20 my-auto" />
                    <div class="ml-8 lg:ml-20 bg-lightPink min-h-40 lg:min-h-44 w-[260px] lg:w-[420px] px-4 rounded-2xl">
                        <h4 class="text-center font-bellefair text-[24px] mt-2">Memories</h4>
                        <p class="text-center font-bellefair text-[16px] mt-2 lg;mt-6">
                            <?= $story['memorableMoments'] ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="relative top-0 block max-w-full min-h-screen gap-20 px-10 py-10 lg:top-16 lg:px-20 lg:py-0 xl:flex bg-customRed">
        <img src='<?php themeAssets($themeID,"img/venue.png");?>' alt="venue" class="my-auto rounded-xl" />
        <div class="my-24 lg:my-24">
          <h1 class=" text-[40px] lg:text-[120px] tracking-widest font-bellefair text-white">Venue.</h1>
          <p class=" max-w-full lg:max-w-[450px] my-6 text-[16px] lg:text-[26px] font-inder text-white"> <?= $weddingData['travel'] ?> <br> <?= $weddingData['accommodation'] ?> </p>
          <button class=" text-customRed bg-white font-bellefair text-[24px] px-10 rounded-full my-8 py-1 text-center">Locate</button>
        </div>
    </div>
    <div class="flex items-center justify-center min-h-screen ">
        <div>
          <h1 class=" text-[40px] lg:text-[50px] font-bellefair text-center text-customRed">We are excited</h1>
          <p class=" text-[16px] lg:text-[30px] font-bellefair text-customRed text-center my-6 max-w-[300px] lg:max-w-[700px]">s simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
          <div class="flex justify-center mt-10 lg:mt-14">
            <button class=" text-[24px] font-bellefair text-center px-8 rounded-full py-2 lg:py-0.5 bg-customRed text-white">Back to top</button>
          </div>
        </div>
    </div>
    <div class="flex justify-center min-h-16 bg-customRed">
        <p class=" text-white font-bellefair text-[15px] lg:text-[24px] my-auto">A personalised experience with ❤️ by eSubhalekha.com</p>
    </div>

  </div>
    <script type="text/javascript">
        const owl =$('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            dots: false,
            autoplay: true,
            autoplayTimeout: 2000,
            nav:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:3
                }
            }
        });
        $('.owl-carousel__next').click(() => owl.trigger('next.owl.carousel'))
  
  $('.owl-carousel__prev').click(() => owl.trigger('prev.owl.carousel'));

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
