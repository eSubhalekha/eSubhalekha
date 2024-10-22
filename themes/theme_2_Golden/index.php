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
  <head>

    <?php require("views/partials/themes/metatags.php"); ?>

    <title><?php echo $weddingData['weddingName'] ?> - eSubhalekha.com </title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lenis@1.0.45/dist/lenis.min.js"></script>

    <link rel="stylesheet" href='<?php themeAssets($themeID,"css/index.css");?>' />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css"
      integrity="sha512-X/RSQYxFb/tvuz6aNRTfKXDnQzmnzoawgEQ4X8nZNftzs8KFFH23p/BA6D2k0QCM4R0sY1DEy9MIY9b3fwi+bg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
      integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
      integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
      integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
      integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"
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
      }

      .owl-nav .owl-prev {
        display: hidden;
      }
      .owl-nav .owl-prev span,
      .owl-nav .owl-next span {
        display: hidden;
        border-radius: 100%;
        color: black;
      }

      .owl-nav .owl-next {
        display: hidden;
        background-color: black;
        right: 10px;
      }

      .owl-dots {
        display: hidden;
      }

      .owl-dots .owl-dot {
        display: hidden;
      }

      .owl-dots .owl-dot span {
        display: hidden;
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

  <body class="w-screen bg-[#050303]">

     <button id="rsvpButton" class="btn-style fixedRSVP text-xs mt-5 py-1"> RSVP </button>

    <div class="main">
    <nav class="w-full"></nav>

    <div class="w-full h-screen bg-[#050303] overflow-hidden relative">
      <img
        class="w-full h-full object-cover absolute top-0 left-0 z-10"
        src="<?php if (getImgURL('hero')) echo getImgURL('hero'); ?>"
        alt=""
      />
      <div
        class="w-full h-full bg-gradient-to-b from-[rgb(0,0,0,0)] via-[rgb(0,0,0,0.7)] to-[#050303] absolute top-0 left-0 z-10"
      ></div>
      <div
        class="w-full h-full absolute top-0 left-0 flex justify-center items-center bg-gradient-to-b from-[#FDF2DB] to-[#C58200] bg-clip-text text-transparent z-40"
      >
        <h1
          class="text-5xl lg:text-6xl flex flex-col sm:flex-row justify-center items-center sm:items-end sm:gap-3 font-light"
        >
          <span class="text-style text-5xl"> <?php echo removeLastWord($weddingData['brideName']); ?> </span>
          <span class="text-lg text-style text-5xl"> Weds </span>
          <span class="text-style text-5xl"> <?php echo removeLastWord($weddingData['groomName']); ?> </span>
        </h1>
      </div>
      <div
        class="w-full py-[50px] flex flex-col justify-center items-center z-30 absolute bottom-0 left-0"
      >
        <h1 class="text-style font-light text-xl">Countdown</h1>
        <div class="countdown-container flex justify-center items-center gap-5">
          <div
            class="Days flex flex-col justify-center items-center font-light"
          >
            <p class="text-style leading-tight text-4xl" id="days">20</p>
            <p class="text-style">Days</p>
          </div>
          <div
            class="Hours flex flex-col justify-center items-center font-light"
          >
            <p class="text-style leading-tight text-4xl" id="hours">02</p>
            <p class="text-style">Hours</p>
          </div>
          <div
            class="Mins flex flex-col justify-center items-center font-light"
          >
            <p class="text-style leading-tight text-4xl" id="minutes">03</p>
            <p class="text-style">Mins</p>
          </div>
          
        </div>
      </div>
    </div>
    <div
      class="w-full h-screen relative flex flex-center items-center justify-center overflow-hidden"
    >
      <div class="decor-1"></div>
      <div class="decor-2 w-full h-[30%] absolute top-0 overflow-hidden flex">
        <img class="w-full object-cover" src='<?php themeAssets($themeID,"img/decor.png");?>' alt="" />
        <img class="w-full object-cover" src='<?php themeAssets($themeID,"img/decor.png");?>' alt="" />
      </div>
      <div
        class="decor-2 w-full h-[30%] absolute bottom-0 overflow-hidden flex"
      >
        <img class="w-full object-cover" src='<?php themeAssets($themeID,"img/decor.png");?>' alt="" />
        <img class="w-full object-cover" src='<?php themeAssets($themeID,"img/decor.png");?>' alt="" />
      </div>
      <div
        class="absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center px-3"
      >
        <h2 class="text-style text-2xl sm:text-4xl text-center">
          <?= formatTimeStamp($muhurt['startTime']) ?>
        </h2>
        <p class="text-style text-xs text-center px-2">
          We seek your valuable presence on Our special day.
        </p>
        <button class="btn-style mt-5">
          <p class="text-style text-xs py-1">Save the date</p>
        </button>
      </div>
    </div>
    <div
      class="w-full h-auto sm:h-screen py-[100px] flex flex-col justify-center items-center px-3"
    >
      <h3 class="text-style text-3xl py-[50px] text-center">
        Meet the Bride and Groom
      </h3>
      <div
        class="bride-groom-container flex flex-col sm:flex-row gap-3 justify-center items-center"
      >
        <div class="groom-container max-w-xs">
          <div class="h-[500px] rounded-xl overflow-hidden relative">
            <div
              class="absolute left-0 top-0 w-[30%] flex flex-col overflow-hidden"
            >
              <img src='<?php themeAssets($themeID,"img/img-decor.png");?>' alt="" />
              <img class="rotate-180" src='<?php themeAssets($themeID,"img/img-decor.png");?>' alt="" />
            </div>
            <img
              class="w-full h-full object-cover"
              src="<?php if (getImgURL('bride')) echo getImgURL('bride'); ?>"
              alt=""
            />
          </div>
          <div class="text-container mt-3">
            <h5 class="text-style text-4xl font-light"><?php echo removeLastWord($weddingData['brideName']) ?></h5>
            <button class="btn-style flex justify-center items-center my-2">
              <p class="text-style">Bride</p>
            </button>
            <p class="text-style leading-tight font-light">
              <?= $weddingData['brideBio'] ?>
            </p>
          </div>
        </div>
        <div class="bride-container max-w-xs">
          <div class="h-[500px] rounded-xl overflow-hidden relative">
            <div
              class="absolute left-0 top-0 w-[30%] flex flex-col overflow-hidden"
            >
              <img src='<?php themeAssets($themeID,"img/img-decor.png");?>' alt="" />
              <img class="rotate-180" src='<?php themeAssets($themeID,"img/img-decor.png");?>' alt="" />
            </div>
            <img
              class="w-full h-full object-cover"
              src="<?php if (getImgURL('groom')) echo getImgURL('groom'); ?>"
              alt=""
            />
          </div>
          <div class="text-container mt-3">
            <h5 class="text-style text-4xl font-light"><?php echo removeLastWord($weddingData['groomName']) ?></h5>
            <button class="btn-style flex justify-center items-center my-2">
              <p class="text-style">Groom</p>
            </button>
            <p class="text-style leading-tight font-light">
              <?= $weddingData['groomBio'] ?>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full h-screen flex flex-col justify-center items-center">
      <h6 class="text-4xl text-style font-light">
        Gallery : Our golden moments.
      </h6>
      <div
        id="2"
        class="gallery-card-container w-full h-[500px] max-w-7xl mx-auto my-[100px] px-5 relative flex flex-row gap-2"
      >
        <button
          class="next-2 next w-[40px] h-[40px] flex justify-center items-center rounded-full bg-[#000000] border border-[#BA8928] absolute right-0 top-1/2 -translate-1/2 z-20"
        >
          <i class="bx bx-right-arrow-alt text-[#BA8928] text-2xl"></i>
        </button>
        <button
          class="prev-2 prev w-[40px] h-[40px] flex justify-center items-center rounded-full bg-[#000000] border border-[#BA8928] absolute left-0 top-1/2 -translate-1/2 z-20"
        >
          <i class="bx bx-left-arrow-alt text-[#BA8928] text-2xl"></i>
        </button>
        <div
          id="1"
          class="w-full h-full carousel-2 owl-carousel flex justify-center items-center relative"
        >

               <?php 
            if (!$preweddingGallery['error']){
                for ($i = 0; $i < count($preweddingGallery); $i++){
                        if (!$preweddingGallery['error']){
                         for ($i = 0; $i < count($preweddingGallery); $i++){
                          $headers = get_headers($preweddingGallery[$i]['imageURL'], 1);
                          if (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'image') !== false){
                  ?>

                   <div
            class="gallery-card max-w-[350px] h-full bg-[#2A200C] rounded-sm relative flex flex-col justify-center items-center overflow-hidden mx-auto"
          >
            <img
              class="w-full h-full object-cover scale-110"
              src="<?= $preweddingGallery[$i]['imageURL'] ?>"
              alt="image"
            />
          </div>
                                                                                                                                             
                    <?php 

                      } // image type ends
                      elseif (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'video') !== false) {
                    ?>

                      <div class="gallery-card max-w-[350px] h-full bg-[#2A200C] rounded-sm relative flex flex-col justify-center items-center overflow-hidden mx-auto">
                        <video controls style="object-fit: cover;  width:-webkit-fill-available;" class="w-full h-full object-cover scale-110">
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
    <div
      class="w-full h-screen bg-[#120D04] flex flex-col justify-center items-center"
    >
      <h6 class="text-4xl text-style">Events</h6>
      <div
        class="event-card-container w-full h-[540px] max-w-7xl mx-auto my-[100px] px-5 relative flex flex-row gap-2"
      >
        <button
          class="next-1 next w-[40px] h-[40px] flex justify-center items-center rounded-full bg-[#000000] border border-[#BA8928] absolute right-0 top-1/2 -translate-1/2 z-20"
        >
          <i class="bx bx-right-arrow-alt text-[#BA8928] text-2xl"></i>
        </button>
        <button
          class="prev-1 prev w-[40px] h-[40px] flex justify-center items-center rounded-full bg-[#000000] border border-[#BA8928] absolute left-0 top-1/2 -translate-1/2 z-20"
        >
          <i class="bx bx-left-arrow-alt text-[#BA8928] text-2xl"></i>
        </button>
        <div
          id="1"
          class="w-full h-full carousel-1 owl-carousel flex justify-center items-center relative"
        >
         <?php
                if ($timeline != null){
                            for ($i = 0; $i < count($timeline); $i++){
                                ?>
          <div class="py-5 h-full">
            <div
              class="even-card max-w-[350px] h-full bg-[#2A200C] rounded-2xl relative flex flex-col justify-center items-center mx-auto"
            >
              <div class="btn-style absolute top-0 -translate-y-1/2">
                <p class="text-style"><?php echo date('d/m/Y g:i A', strtotime($timeline[$i]['startTime'])) ?></p>
              </div>
              <div
                class="event-card-header h-[40%] flex flex-col justify-center items-center py-[30px]"
              >
                <p class="event-title text-style text-3xl"><?php echo (empty($timeline[$i]['event'])) ? $timeline[$i]['type'] : $timeline[$i]['event']; ?></p>
                <p class="event-timing text-style text-center">
                  <?php echo $timeline[$i]['venue'] ?> <?php echo $timeline[$i]['address'] ?>
                </p>
              </div>
              <div class="event-img w-full h-[60%] relative">
                <img
                  class="w-full h-full object-cover"
                  src="<?php echo getImgURL($timeline[$i]['type']) ?>"
                  alt="event"
                />
                <div class="decor">
                  <img src='<?php themeAssets($themeID,"img/event-decor.png");?>' alt="" />
                </div>
              </div>
            </div>
          </div>
          

            <?php }} ?>
        </div>
      </div>


    </div>

    <!-- Our story section -->
    <div class="w-full py-[30px]">
      <div
        class="w-full primary_font py-[30px] text-[#FFFFFF] lg:py-[60px] relative overflow-hidden font-light"
      >
        <div
          class="pb-[100px] sm:pb-[150px] lg:pb-[150px] flex flex-col justify-center items-center"
        >
          <div
            class="w-full flex justify-center items-center text-[30pt] sm:mb-[80px] text-style"
          >
            Our story
          </div>

          <div id="container" class="scale-[80%] sm:scale-100 mt-[50px]">
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
                stroke="#DCAF59"
                stroke-width="2"
              />
            </svg>

            <div class="path-div" data-index="0" data-percentage="1">
              <div
                class="h-[70px] w-[70px] rounded-full sm:h-[90px] sm:w-[90px] relative overflow-hidden px-1 py-1 bg-[#DCAF59]"
              >
                <div
                  class="w-full h-full bg-[#DCAF59] rounded-full overflow-hidden"
                >
                  <img
                    src="<?php if (getImgURL('couple')){ echo getImgURL('couple');}{ getImgURL('hero'); } ?>"
                    class="object-cover w-full h-full"
                    alt=""
                  />
                </div>
              </div>
              <div
                class="absolute flex flex-col gap-1 left-[100px] top-[50%] -translate-y-[50%] min-w-[280px] max-w-[340px] px-3 py-2 rounded-lg bg-[rgb(243,243,243,0.10)] border-[rgb(220,175,89,0.27)] border-[1px] backdrop-blur-[6px]"
              >
                <div class="w-full text-2xl text-center text-style">
                  How we met...
                </div>
                <p
                  class="w-full px-1 text-sm text-center font-light text-[#CEA146]"
                >
                   <?= $story['whenWeMet'] ?>, <?= $story['howWeMet'] ?>
                </p>
              </div>
            </div>
            <div class="path-div" data-index="1" data-percentage="40">
              <div
                class="h-[70px] w-[70px] rounded-full sm:h-[90px] sm:w-[90px] relative overflow-hidden px-1 py-1 bg-[#DCAF59]"
              >
                <div
                  class="w-full h-full bg-[#DCAF59] rounded-full overflow-hidden"
                >
                  <img
                    src="<?php if (getImgURL('couple')){ echo getImgURL('couple');}{ getImgURL('hero'); } ?>"
                    class="object-cover w-full h-full"
                    alt=""
                  />
                </div>
              </div>
              <div
                class="absolute flex flex-col gap-1 left-[100px] top-[50%] -translate-y-[50%] min-w-[280px] max-w-[340px] px-3 py-2 rounded-lg bg-[rgb(243,243,243,0.10)] border-[rgb(220,175,89,0.27)] border-[1px] backdrop-blur-[6px]"
              >
                <div class="w-full text-2xl text-center text-style">
                  little love....
                </div>
                <p
                  class="w-full px-1 text-sm text-center font-light text-[#CEA146]"
                >
                   <?= $story['memorableMoments'] ?>
                </p>
              </div>
            </div>
            <div class="path-div" data-index="2" data-percentage="80">
              <div
                class="h-[70px] w-[70px] rounded-full sm:h-[90px] sm:w-[90px] relative overflow-hidden px-1 py-1 bg-[#DCAF59]"
              >
                <div
                  class="w-full h-full bg-[#DCAF59] rounded-full overflow-hidden"
                >
                  <img
                    src="<?php if (getImgURL('couple')){ echo getImgURL('couple');}{ getImgURL('hero'); } ?>"
                    class="object-cover w-full h-full"
                    alt=""
                  />
                </div>
              </div>
              <div
                class="absolute flex flex-col gap-1 left-[100px] top-[50%] -translate-y-[50%] min-w-[280px] max-w-[340px] px-3 py-2 rounded-lg bg-[rgb(243,243,243,0.10)] border-[rgb(220,175,89,0.27)] border-[1px] backdrop-blur-[6px]"
              >
                <div class="w-full text-2xl text-center text-style">
                  We are engaged...
                </div>
                <p
                  class="w-full px-1 text-sm text-center font-light text-[#CEA146]"
                >
                   <?= $story['engagementYear'] ?>, <?= $story['engagement'] ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Our story ends here -->
    </div>
    <div
      class="are-you-attending-section w-full h-[400px] bg-[#171003] relative"
    >
      <div class="decor-2 w-full h-[10%] absolute top-0 overflow-hidden flex">
        <img class="w-full object-cover" src='<?php themeAssets($themeID,"img/decor.png");?>' alt="" />
        <img class="w-full object-cover" src='<?php themeAssets($themeID,"img/decor.png");?>' alt="" />
      </div>
      <div
        class="decor-2 w-full h-[10%] absolute bottom-0 overflow-hidden flex"
      >
        <img class="w-full object-cover" src='<?php themeAssets($themeID,"img/decor.png");?>' alt="" />
        <img class="w-full object-cover" src='<?php themeAssets($themeID,"img/decor.png");?>' alt="" />
      </div>


      <div
  class="content w-full h-full py-[50px] flex flex-col justify-center items-center"
>
  <h6 class="text-style text-xl sm:text-4xl font-light text-center">
    Are you attending the event?
  </h6>
  <button id="rsvpButton" class="btn-style text-xs mt-5 py-1">
    <p class="text-style">Yes, I'm attending.</p>
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
      class="w-full sm:h-screen font-light flex flex-col justify-center items-center"
    >
      <div
        class="accomadation w-full h-[45%] py-[50px] max-w-7xl mx-auto px-5 flex flex-col sm:flex-row justify-around items-center"
      >
        <div
          class="accomadation-content flex flex-col justify-center items-start"
        >
          <p class="text-style text-xl mb-5">Getting there!!</p>
          <h6 class="text-style text-4xl">Accomodation</h6>
          <p class="text-[#DDA63C] max-w-xl">
            <?= $weddingData['accommodation'] ?>
          </p>
        </div>
        <div class="max-w-2xl h-full overflow-hidden mt-5 sm:mt-0">
          <img src='<?php themeAssets($themeID,"img/event-img.png");?>' alt="" />
        </div>
      </div>
      <div
        class="accomadation w-full h-[45%] py-[50px] max-w-7xl mx-auto px-5 flex flex-col sm:flex-row justify-around items-center"
      >
        <div
          class="accomadation-content flex flex-col justify-center items-start"
        >
          <h6 class="text-style text-4xl">Travel</h6>
          <p class="text-[#DDA63C] max-w-xl">
            <?= $weddingData['travel'] ?>
          </p>
        </div>
        <div class="max-w-2xl h-full overflow-hidden mt-5 sm:mt-0">
          <img src='<?php themeAssets($themeID,"img/event-img.png");?>' alt="" />
        </div>
      </div>
    </div>
    <div class="w-full h-[300px] flex justify-center items-center font-light">
      <h6 class="text-style text-2xl sm:text-4xl">WE ARE SO EXICITED!!</h6>
    </div>
    <div class="flex justify-center items-center py-1">
      <p class="text-style text-xs">All rights reserved @esubhalekha.com</p>
    </div>
    <div class="w-full h-[180px] flex overflow-hidden">
      <img class="object-cover" src='<?php themeAssets($themeID,"img/decor.png");?>' alt="" />
      <img src='<?php themeAssets($themeID,"img/decor.png");?>' alt="" />
      <img src='<?php themeAssets($themeID,"img/decor.png");?>' alt="" />
    </div>
  </div>

  </body>
  <script>
    $(document).ready(function () {
      $(".carousel-1").owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        Autoplay: true,
        responsive: {
          0: {
            items: 1,
          },
          600: {
            items: 2,
          },
          800: {
            items: 3,
          },
        },
      });
      $(".carousel-2").owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        Autoplay: true,
        responsive: {
          0: {
            items: 1,
          },
          600: {
            items: 2,
          },
          800: {
            items: 3,
          },
        },
      });
      var owl_1 = $(".carousel-1");
      $(".prev-1").click(function () {
        owl_1.trigger("prev.owl");
      });

      $(".next-1").click(function () {
        owl_1.trigger("next.owl");
      });

      var owl_2 = $(".carousel-2");
      $(".prev-2").click(function () {
        owl_2.trigger("prev.owl");
      });

      $(".next-2").click(function () {
        owl_2.trigger("next.owl");
      });
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
  </script>
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
