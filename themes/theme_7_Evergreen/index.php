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

    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Italiana&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href='<?php themeAssets($themeID,"css/index.css");?>' />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
    />

    <!-- cdn of owlcarousel -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"
    />
    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
    <script src="https://unpkg.com/lenis@1.0.45/dist/lenis.min.js"></script>

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
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


      .owl-nav .owl-prev,
      .owl-nav .owl-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        z-index: 10;
      }

      .owl-nav .owl-prev {
        left: 10px;
      }

      .owl-nav .owl-next {
        right: 10px;
      }

      .owl-dots {
        text-align: center;
        padding-top: 10px;
      }

      .owl-dots .owl-dot {
        display: inline-block;
        margin: 0 5px;
      }

      .owl-dots .owl-dot span {
        display: block;
        width: 12px;
        height: 12px;
        background-color: #c6d9b6;
        border-radius: 50%;
      }

      .owl-dots .owl-dot.active span {
        background-color: #39492f;
      }
    </style>
    <style>
        #container {
          position: relative;
          width: 351px;
          height: 618px;
        }
  
        .path-div {
          position: absolute;
          transform: translate(-50%, -50%);
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

  <body class="relative flex flex-col w-screen h-screen bg-[#FAEFE1]">

    <button id="rsvpButton" 
            class="fixedRSVP text-xs py-1 w-[150px] rounded-l-full rounded-r-full bg-[#39492F] text-[#C6D9B6] hover:bg-[#4B633C]"
          > RSVP </button>

    <div class="main">
    <nav
      class="w-full h-[60px] flex justify-between px-3 items-center absolute top-0 right-0"
    >
      <ul class="flex gap-10 secondary_font">
        <!-- <li><i class="bx bx-menu text-[#39492F] text-2xl sm:hidden"></i></li> -->
        <li><p class="text-xs sm:block">Groom</p></li>
        <li><p class="text-xs sm:block">Bride</p></li>
        <li><p class="text-xs sm:block">location</p></li>
      </ul>
      <button
        class="px-4 py-2 bg-[#39492F] text-[#FAEFE1] text-xs secondary_font font-light z-40"
      >
        save date
      </button>
    </nav>
    <div class="absolute right-0 top-0 w-[120px]">
      <img src='<?php themeAssets($themeID,"img/herodecor1.png");?>'alt="" />
    </div>
    <div class="absolute left-0 top-[350px] z-20 w-[150px]">
      <img src='<?php themeAssets($themeID,"img/herodecor2.png");?>'alt="" />
    </div>
    <div class="flex flex-col">
      <div
        class="w-[300px] lg:w-[600px] xl:w-[800px] overflow-hidden absolute top-[350px] translate-y-[50%] right-0"
      >
        <img class="w-full" src="<?php if (getImgURL('hero')) echo getImgURL('hero'); ?>" alt="" />
      </div>
      <div class="w-full flex flex-col sm:grid sm:grid-cols-2">
        <div
          class="relative sm:col-span-1 w-full h-[600px] lg:h-[800px] xl:h-[1000px] flex justify-center items-center"
        >
          <div
            class="relative w-full flex flex-col justify-center items-center primary_font text-[35pt] lg:text-[40pt] px-7 pb-[100px]"
          >
            <p class="text-[#39492F] leading-[35pt] lg:leading-[40pt]"><?php echo removeLastWord($weddingData['groomName']); ?></p>
            <p class="text-[#39492F] leading-[35pt] lg:leading-[40pt]">
              <span class="text-[#92AA7B] leading-[35pt]">&</span> <?php echo removeLastWord($weddingData['brideName']); ?>
            </p>
            <div
              class="w-full flex justify-center items-center text-[#39492F] text-xs mt-[50px]"
            >
              <p class="text-center max-w-[300px]">
                It is a long established fact that a reader will be distracted
                by the readable content of a page when looking at its layout.
                The point of using Lorem Ipsum is that it
              </p>
            </div>
          </div>
        </div>
        <!-- date of the wedding -->
        <div
          class="w-full sm:col-span-1 h-[220px] flex flex-col justify-center items-center mt-5"
        >
          <div class="flex flex-col text-[#39492F]">
            <div class="primary_font text-5xl">
              <p> <?= formatTimeStamp($muhurt['startTime']) ?> </p>
            </div>
            <div class="primary_font text-xs max-w-[200px] text-center">
              <p>
                It is a long established fact that a reader will be distracted
                by the readable content
              </p>
            </div>
            <!-- countdown of the wedding  -->
            <div class="secondary_font flex gap-3 mt-4">
              <div class="flex justify-center items-center">
                <p class="text-xl pr-1" id="days">24</p>
                <p class="text-sm">days</p>
              </div>
              <div class="flex justify-center items-center">
                <p class="text-xl pr-1" id="hours">18</p>
                <p class="text-sm">hours</p>
              </div>
              <div class="flex justify-center items-center">
                <p class="text-xl pr-1" id="minutes">24</p>
                <p class="text-sm">mins</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        class="max-w-6xl mx-auto flex flex-col primary_font sm:grid sm:grid-cols-2 sm:mb-7"
      >
        <div
          class="w-full bg-[#C6D9B6] text-[#39492F] rounded-t-[30px] col-span-2"
        >
          <p class="text-4xl text-center py-[30px]">Meet the Bride and Groom</p>
        </div>
        <div class="w-full flex flex-col col-span-1">
          <div class="w-full h-[200px] sm:h-[750px]">
            <img
              class="h-full w-full object-cover saturate-50"
              src="<?php if (getImgURL('couple')) echo getImgURL('couple'); ?>"
              alt=""
            />
          </div>
        </div>
        <div class="w-full flex flex-col text-[#39492F] px-3 my-7 gap-[20px]">
          <!-- Bride card -->
          <div class="w-full flex flex-col">
            <div class="flex items-end gap-1">
              <div class="px-2 bg-[#C6D9B6] rounded-l-full rounded-r-full mb-2">
                <p class="text-sm">Bride</p>
              </div>
              <p class="text-4xl leading-tight"><?php echo removeLastWord($weddingData['brideName']) ?></p>
            </div>
            <div
              class="w-full h-[150px] overflow-hidden mt-2 rounded-[20px] saturate-50"
            >
              <img
                class="w-full object-fit"
                src="<?php if (getImgURL('bride')) echo getImgURL('bride'); ?>"
                alt=""
              />
            </div>
            <div class="flex justify-start items-start">
              <p class="text-left leading-tight text-sm max-w-[300px] mt-4">
                <?= $weddingData['brideBio'] ?>
              </p>
            </div>
          </div>
          <!-- groom card -->

          <div class="w-full flex flex-col">
            <div class="flex items-end justify-start gap-1">
              <div class="px-2 bg-[#C6D9B6] rounded-l-full rounded-r-full mb-2">
                <p class="text-sm">Groom</p>
              </div>
              <p class="text-4xl leading-tight"><?php echo removeLastWord($weddingData['groomName']) ?></p>
            </div>
            <div
              class="w-full h-[150px] overflow-hidden mt-2 rounded-[20px] saturate-50"
            >
              <img
                class="w-full object-fit"
                src="<?php if (getImgURL('groom')) echo getImgURL('groom'); ?>"
                alt=""
              />
            </div>
            <div class="flex justify-start items-start">
              <p class="text-left leading-tight text-sm max-w-[300px] mt-4">
                <?= $weddingData['groomBio'] ?>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Our story section -->
      <div
        class="w-full bg-[#C6D9B6] primary_font h-[800px] sm:h-[1000px] py-[30px] lg:py-[60px] relative overflow-hidden"
      >
        <div
          class="sm:pb-[50px] lg:pb-[100px] flex flex-col justify-center items-center"
        >
          <div
            class="w-full flex justify-center items-center text-[#39492F] text-[30pt] sm:pb-[80px]"
          >
            Our story
          </div>

          <div id="container" class="scale-[80%] sm:scale-100">
            <svg
              width="351"
              height="646"
              viewBox="0 0 351 646"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                id="svg-path"
                d="M1 0.5V845.5"
                stroke="#FAEFE1"
                stroke-width="2"
              />
            </svg>

            <div class="path-div" data-index="0" data-percentage="1">
              <div
                class="h-[70px] w-[70px] rounded-full sm:h-[90px] sm:w-[90px] relative overflow-hidden px-1 py-1 bg-[#FAEFE1]"
              >
                <div
                  class="w-full h-full bg-[#FAEFE1] rounded-full overflow-hidden"
                >
                  <img
                    src="<?php if (getImgURL('couple')) echo getImgURL('couple'); ?>"
                    class="object-cover w-full"
                    alt=""
                  />
                </div>
              </div>
              <div
                class="absolute flex flex-col gap-1 left-[100px] top-[50%] -translate-y-[50%] min-w-[280px] max-w-[340px] px-3 py-2 rounded-lg bg-[rgb(243,243,243,0.27)] border-[rgb(243,243,243,0.27)] border-[1px] text-[#39492F] backdrop-blur-[6px]"
              >
                <div class="w-full text-2xl text-center">How we met...</div>
                <p class="w-full px-1 text-sm text-center font-light">
                   <?= $story['whenWeMet'] ?>, <?= $story['howWeMet'] ?>
                </p>
              </div>
            </div>
            <div class="path-div" data-index="1" data-percentage="40">
              <div
                class="h-[70px] w-[70px] rounded-full sm:h-[90px] sm:w-[90px] relative overflow-hidden px-1 py-1 bg-[#FAEFE1]"
              >
                <div
                  class="w-full h-full bg-[#FAEFE1] rounded-full overflow-hidden"
                >
                  <img
                    src="<?php if (getImgURL('couple')) echo getImgURL('couple'); ?>"
                    class="object-cover w-full"
                    alt=""
                  />
                </div>
              </div>
              <div
                class="absolute flex flex-col gap-1 left-[100px] top-[50%] -translate-y-[50%] min-w-[280px] max-w-[340px] px-3 py-2 rounded-lg bg-[rgb(243,243,243,0.27)] border-[rgb(243,243,243,0.27)] border-[1px] text-[#39492F] backdrop-blur-[6px]"
              >
                <div class="w-full text-2xl text-center">little love....</div>
                <p class="w-full px-1 text-sm text-center font-light">
                   <?= $story['memorableMoments'] ?>
                </p>
              </div>
            </div>
            <div class="path-div" data-index="2" data-percentage="80">
              <div
                class="h-[70px] w-[70px] rounded-full sm:h-[90px] sm:w-[90px] relative overflow-hidden px-1 py-1 bg-[#FAEFE1]"
              >
                <div
                  class="w-full h-full bg-[#FAEFE1] rounded-full overflow-hidden"
                >
                  <img
                    src="<?php if (getImgURL('couple')) echo getImgURL('couple'); ?>"
                    class="object-cover w-full"
                    alt=""
                  />
                </div>
              </div>
              <div
                class="absolute flex flex-col gap-1 left-[100px] top-[50%] -translate-y-[50%] min-w-[280px] max-w-[340px] px-3 py-2 rounded-lg bg-[rgb(243,243,243,0.27)] border-[rgb(243,243,243,0.27)] border-[1px] text-[#39492F] backdrop-blur-[6px]"
              >
                <div class="w-full text-2xl text-center">We are engaged...</div>
                <p class="w-full px-1 text-sm text-center font-light">
                   <?= $story['engagementYear'] ?>, <?= $story['engagement'] ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Our story ends here -->
      <div class="w-full flex-col primary_font text-[#39492F] my-[40px]">
        <div class="w-full text-5xl flex justify-center items-center">
          <p>events</p>
        </div>
        <div class="w-full flex justify-center px-3">
          <div
            class="owl-carousel max-w-6xl mt-5 flex justify-center items-center"
          >

            <!--  event card starts -->
                <?php
                if ($timeline != null){
                            for ($i = 0; $i < count($timeline); $i++){
                                ?>

            <div class="w-full h-full flex flex-col relative">
              <div
                class="w-full flex justify-start items-start py-2 bg-[#C6D9B6]"
              >
                <p class="text-4xl pl-3 text-[#39492F]"><?php echo (empty($timeline[$i]['event'])) ? $timeline[$i]['type'] : $timeline[$i]['event']; ?></p>

                <p class="text-4xl pl-3 text-[#39492F]"> <?php echo date('d/m/Y g:i A', strtotime($timeline[$i]['startTime'])) ?> 
                  <br>
                  <?php echo $timeline[$i]['venue'] ?> <?php echo $timeline[$i]['address'] ?>
                </p>

              </div>
              <div class="w-full h-[300px] overflow-hidden">
                <img
                  class="h-full w-full object-cover"
                  src="<?php echo getImgURL($timeline[$i]['type']) ?>"
                  alt="event"
                />
              </div>
            </div>

            <?php }} ?>
            <!-- event card ends -->

           
          </div>
        </div>
      </div>
      <div
        class="max-w-6xl mx-auto flex flex-col secondary_font text-[#39492F] px-3 gap-5 py-10"
      >
        <div class="w-full flex justify-start items-center">
          <p class="text-left text-lg">Getting there!</p>
        </div>
        <div class="flex flex-col justify-start items-start gap-10">
          <div class="w-full flex flex-col justify-start items-start">
            <p class="text-3xl">Travel</p>
            <p class="text-xs leading-tight">
              <?= $weddingData['travel'] ?>
            </p>
          </div>
          <div class="w-full flex flex-col justify-start items-start">
            <p class="text-3xl">Accomadation</p>
            <p class="text-xs leading-tight">
              <?= $weddingData['accommodation'] ?>
            </p>
          </div>
        </div>
      </div>
      <div
        class="w-full h-[200px] primary_font bg-[#C6D9B6] flex justify-center items-center relative"
      >
        <div class="w-[100px] absolute right-0 -top-[100px] z-20">
          <img src='<?php themeAssets($themeID,"img/lastdecor.png");?>' alt="" />
        </div>
        <div class="w-[100px] absolute left-0 -bottom-[100px] z-20">
          <img src='<?php themeAssets($themeID,"img/lastdecor2.png");?>' alt="" />
        </div>
        <div class="flex flex-col justify-center items-center gap-3">
          <p class="text-4xl">Are you attending??</p>
          <button id="rsvpButton" 
            class="text-xs py-1 w-[150px] rounded-l-full rounded-r-full bg-[#39492F] text-[#C6D9B6] hover:bg-[#4B633C]"
          >
            i am attending
          </button>

        </div>


<!-- RSVP Modal -->
<div class="modal fixed inset-0 flex items-center justify-center hidden" id="rsvpModal">
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
          <button id="submitBtn" type="submit" class="h-[36px] w-[150px] rounded-l-full rounded-r-full border-[3px] text-white btn-style text-xs focus:ring focus:ring-[#DA2E78] active:scale-90 transition duration-300 ease-in-out" name="submitRSVP">Submit</button>
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




      </div>
      <div
        class="w-full h-[300px] relative flex flex-col justify-start items-center"
      >
        <div class="w-full h-[300px] absolute">
          <img
            class="w-full h-full object-cover"
            src="./assets/images/gallery.png"
            alt=""
          />
        </div>
        <div class="w-full flex flex-col z-20 mt-[50px]">
          <p class="text-center leading-tight text-2xl font-light">Gallery</p>
          <a class="text-center leading-tight text-xs text-[#F5F5F5] hover:text-[#F5F5F4]" href=""
            >see more</a
          >
        </div>
      </div>
    </div>
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
          autoplayTimeout: 4000,
          autoplayHoverPause: true,
        },
        600: {
          items: 2,
          nav: false,
          margin: 10,
          autoplay: true,
          autoplayTimeout: 4000,
          autoplayHoverPause: true,
        },
        1000: {
          items: 2,
          nav: true,
          loop: false,
          margin: 10,
          autoplay: true,
          autoplayTimeout: 4000,
          autoplayHoverPause: true,
        },
      },
    });
    var owl = $(".owl-carousel");
    owl.on("mousewheel", ".owl-stage", function (e) {
      if (e.deltaY > 0) {
        owl.trigger("next.owl");
      } else {
        owl.trigger("prev.owl");
      }
      e.preventDefault();
    });
    $(".owl-carousel").owlCarousel({
      // you can use jQuery selector
      navText: [$(".am-next"), $(".am-prev")],
    });
  </script>
  <!-- jquery cdn -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const lenis = new Lenis();

      lenis.on("scroll", (e) => {
        console.log(e);
      });

      function raf(time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
      }

      requestAnimationFrame(raf);
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
        const { x, y } = getPathPosition(path, percentage);

        div.style.left = `${x}px`;
        div.style.top = `${y}px`;
      });
    }

    window.onload = placeDivs;


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

</html>
