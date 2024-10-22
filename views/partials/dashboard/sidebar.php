<?php
// errors(1);

$currentEMail = App::getUser()['email'];

require('views/partials/dashboard/tracks.php');

?>

 <style>
        .whatsapp-btn {
            position: fixed;
            bottom: 30px;
            right: 20px;
            z-index: 99999;
            background-color: #25D366;
            color: white;
            border-radius: 50%;
            padding: 10px 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }
        .whatsapp-btn:hover {
            background-color: #20bf54;
            color: white;
        }
        li .progress{
              height: auto !important;
              font-size: inherit !important;
              background-color: transparent !important;
        }
</style>

<!-- WhatsApp Floating Button -->
<div>
  <a href="https://wa.me/+919121325466" target="_blank" class="whatsapp-btn">
    <i class="bi bi-whatsapp"></i> 
  </a>
</div>

<div class="ms-3 col-md-9 ms-sm-auto col-lg-10 px-md-4 text-center mt-2" >

      <a class="btn btn-sm btn-primary-outline fs-3 ms-auto d-lg-none collapsed" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu" style="text-decoration: none;">
        <i class="bi bi-list"></i> Menu
      </a>

</div>


<aside id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-primary text-secondary sidebar collapse overflow-auto">
  <div class="position-sticky pt-3">
    <div class="dropdown mt-3 fs-5">
      <strong class="ms-3 me-5">
        <i class="bi bi-person-circle"></i> Hi <?= explode(' ', App::getUser()['name'])[0] ?>!
      </strong>
      <a href="#" class="dropdown-toggle text-decoration-none text-secondary bi bi-three-dots-vertical dropdownHide fs-5 pe-3 float-end"
         id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false"></a>
      <ul class="dropdown-menu text-small shadow" id="Menu"
          style="z-index: 1000000 !important; transform: translate3d(110px, 30px, 10px) !important;"
          aria-labelledby="dropdownUser2">
        <li><a href="<?php echo route('user/profile'); ?>" class="dropdown-item"><i class="bi bi-person-fill"></i> Profile</a></li>
        <li><a class="dropdown-item text-danger fw-bold mt-3" id="logout" href="<?php echo route('logout'); ?>"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
      </ul>
    </div>

    <hr>
    <ul class="nav flex-column">
      <li class="nav-item my-2">
        <a class="nav-link dashboard" aria-current="page" href="<?php echo route('dashboard'); ?>">
          <i class="bi bi-house-door"></i> Dashboard
        </a>
      </li>

      <?php if (isset($_REQUEST['id']) && isset($_REQUEST['lang'])): ?>
        <li class="nav-item my-2">
          <strong class="ms-3 text-secondary-3"><?= $_REQUEST['id'] ?></strong>
          <?php
          // Define menu items
          $menuItems = [
            'Progress ('.$completed.'/'.sizeof($tracks).')' => ['icon' => 'bi bi-sort-up-alt', 'route' => 'wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/progress'],
            'Basic Details' => ['icon' => 'bi bi-clipboard-data', 'route' => 'wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/basic-details'],
            'Theme' => ['icon' => 'bi bi-file-image-fill', 'route' => 'wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/theme'],
            'Hosts' => ['icon' => 'bi bi-people-fill', 'route' => 'wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/hosts'],
            'Events' => ['icon' => 'bi bi-clock', 'route' => 'wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/timeline'],
            'Additional Details' => ['icon' => 'bi bi-pie-chart', 'route' => 'wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/additional-details'],
            'Guests' => ['icon' => 'bi bi-people-fill', 'route' => 'wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/guests'],
            'Gallery' => ['icon' => 'bi bi-image', 'route' => 'wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/gallery'],
            'Our Story' => ['icon' => 'bi bi-file-earmark-post', 'route' => 'wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/our-story'],
          ];

          foreach ($menuItems as $title => $details):
          ?>
            <a class="nav-link <?= strtolower(str_replace(' ', '-', $title)); ?>" aria-current="page"
               href="<?php echo route($details['route']) . queryString(); ?>">
              <i class="<?= $details['icon']; ?>"></i> <?= $title; ?>
            </a>
          <?php endforeach; ?>

          <?php if ($completed == sizeof($tracks)): ?>
            <a class="nav-link preview" target="_blank" aria-current="page" href="<?php echo route($_REQUEST['id'] . '/' . $_REQUEST['lang']); ?>">
              <i class="bi bi-eye"></i> Preview 
            </a>
          <?php else: ?>
            <a class="nav-link preview" aria-current="page" href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang']); ?>">
              <i class="bi bi-eye"></i> Preview 
            </a>
          <?php endif; ?>

          <a class="nav-link checkout" aria-current="page" href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/checkout') . queryString(); ?>">
            <i class="bi bi-currency-rupee"></i>Payment
          </a>

        </li>
      <?php endif; ?>
    </ul>
  </div>
</aside>

<!-- Off-canvas Sidebar (for small screens) -->
<div class="offcanvas offcanvas-start bg-primary text-white" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
  <div class="offcanvas-header text-white">
    <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
    <a type="button" class="btn-close text-reset text-white" data-bs-dismiss="offcanvas" aria-label="Close"></a>
  </div>

  <div class="offcanvas-body">
       <div class="dropdown mt-3 fs-5">
      <strong class="ms-3 me-5">
        <i class="bi bi-person-circle"></i> Hi <?= explode(' ', App::getUser()['name'])[0] ?>!
      </strong>
      <a href="#" class="dropdown-toggle text-decoration-none text-secondary bi bi-three-dots-vertical dropdownHide fs-5 pe-3 float-end"
         id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false"></a>
      <ul class="dropdown-menu text-small shadow" id="Menu"
          style="z-index: 1000000 !important; transform: translate3d(110px, 30px, 10px) !important;"
          aria-labelledby="dropdownUser2">
        <li><a href="<?php echo route('user/profile'); ?>" class="dropdown-item"><i class="bi bi-person-fill"></i> Profile</a></li>
        <li><a class="dropdown-item text-danger fw-bold mt-3" id="logout" href="<?php echo route('logout'); ?>"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
      </ul>
    </div>

    <hr>

    <ul class="nav flex-column">
      <li class="nav-item my-2 d-flex align-items-center">
        <a class="nav-link dashboard text-white" href="<?php echo route('dashboard'); ?>">
          <i class="bi bi-house-door"></i> <span class="menu-text ms-2">Dashboard</span>
        </a>

      </li>
      </ul>


      <?php if (isset($_REQUEST['id']) && isset($_REQUEST['lang'])){ ?>
        <li class="nav-item my-2">
          <strong class="ms-3 text-secondary-3"><?= $_REQUEST['id'] ?></strong>

          <?php foreach ($menuItems as $title => $details){ ?>
            <a class="nav-link <?= strtolower(str_replace(' ', '-', $title)); ?> text-white" aria-current="page"
               href="<?php echo route($details['route']) . queryString(); ?>">
              <i class="<?= $details['icon']; ?>"></i>
              <span class="menu-text ms-2"><?= $title; ?></span>
            </a>
          <?php } ?>

          <?php if ($completed == sizeof($tracks)){ ?>
            <a class="nav-link preview text-white" target="_blank" aria-current="page" href="<?php echo route($_REQUEST['id'] . '/' . $_REQUEST['lang']); ?>">
              <i class="bi bi-eye"></i> <span class="menu-text ms-2">Preview</span>
            </a>
          <?php }else{ ?>
            <a class="nav-link preview text-white" aria-current="page" href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang']); ?>">
              <i class="bi bi-eye"></i> <span class="menu-text ms-2">Preview</span>
            </a>
          <?php } ?>

          <a class="nav-link checkout text-white" aria-current="page" href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/checkout') . queryString(); ?>">
            <i class="bi bi-currency-rupee"></i> <span class="menu-text ms-2">Payment</span>
          </a>
        </li>
      <?php } ?>
    </ul>
  </div>
</div>


<!-- Custom CSS for Menu Hover -->
<style>
  

  .offcanvas-body .nav-link {
    display: flex;
    align-items: center;
    padding: 10px;
    padding: 10px 15px;
    margin: 0;
  }

  .offcanvas-body .nav-link i {
    font-size: 1.5rem;
  }

  .offcanvas {
    width: 250px;
    overflow-x: hidden; 
    overflow-y: auto; 
    max-height: 100vh; 
}



/*@media (max-width: 576px) {
    .offcanvas {
        width: 100%; 
    }
}
*/
</style>


<script type="text/javascript">
  var url = window.location.pathname
  console.log(url)
  switch (url) {
    case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . "/dashboard" : "/dashboard" ?>":
      document.querySelector(".dashboard").classList.toggle("active");
      document.querySelector(".offcanvas-body .dashboard").classList.toggle("active");
      break
      <?php
      if (isset($_REQUEST['id']) && isset($_REQUEST['lang'])):
        ?>

      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/basic-details' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/basic-details'; ?>":
        document.querySelector(".basic-details").classList.toggle("active");
        document.querySelector(".offcanvas-body .basic-details").classList.toggle("active");
        break

      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/progress' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/progress'; ?>":
        document.querySelector(".progress").classList.toggle("active");
         document.querySelector(".offcanvas-body .progress").classList.toggle("active")
        break

      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/our-story' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/our-story'; ?>":
        document.querySelector(".our-story").classList.toggle("active");
         document.querySelector(".offcanvas-body .our-story").classList.toggle("active")
        break
        
      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/hosts' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/hosts'; ?>":
        document.querySelector(".hosts").classList.toggle("active");
         document.querySelector(".offcanvas-body .hosts").classList.toggle("active")
        break

        case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/timeline' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/timeline'; ?>":
        document.querySelector(".events").classList.toggle("active");
         document.querySelector(".offcanvas-body .events").classList.toggle("active")
        break

        case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/guests' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/guests'; ?>":
        document.querySelector(".guests").classList.toggle("active");
         document.querySelector(".offcanvas-body .guests").classList.toggle("active")
        break

        
      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/additional-details' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/additional-details'; ?>":
        document.querySelector(".additional-details").classList.toggle("active");
         document.querySelector(".offcanvas-body .additional-details").classList.toggle("active")
        break

      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/gallery' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/gallery'; ?>":
        document.querySelector(".gallery").classList.toggle("active");
         document.querySelector(".offcanvas-body .gallery").classList.toggle("active")
        break

       case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/theme' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/theme'; ?>":
        document.querySelector(".theme").classList.toggle("active");
         document.querySelector(".offcanvas-body .theme").classList.toggle("active")
        break

        case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id']. '/' . $_REQUEST['lang'] . '/checkout' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/checkout'; ?>":
        document.querySelector(".payment").classList.toggle("active");
         document.querySelector(".offcanvas-body .payment").classList.toggle("active")
        break



        <?php
      endif;
      ?>
  }
</script>