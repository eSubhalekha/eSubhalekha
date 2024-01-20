<?php
$currentEMail = App::getUser()['email'];
DB::connect();

DB::close();
?>


<aside id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-primary text-secondary sidebar collapse overflow-auto">
  <div class="position-sticky pt-3">

    <div class="dropdown mt-3 fs-5">
      <strong class="ms-3 me-5">
        <i class="bi bi-person-circle"></i> Hi
        <?= explode(' ', App::getUser()['name'])[0] ?>!
      </strong>
      <a href="#"
        class="dropdown-toggle text-decoration-none text-secondary bi bi-three-dots-vertical dropdownHide fs-5 pe-3 float-end"
        id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false"></a>
      <ul class="dropdown-menu text-small shadow" id="Menu"
        style="z-index: 1000000 !important; transform: translate3d(110px, 30px, 10px) !important;"
        aria-labelledby="dropdownUser2">
        <li><a href="<?php echo route('admin/user/password'); ?>" class="dropdown-item">
            <i class="bi bi-key-fill"></i> Change Password</a></li>
        <li><a class="dropdown-item text-danger fw-bold mt-3" id="logout" href="<?php echo route('logout'); ?>"><i
              class="bi bi-box-arrow-left"></i> Logout</a></li>
      </ul>
    </div>

    <hr>
    <ul class="nav flex-column">

      <li class="nav-item my-2">
        <a class="nav-link dashboard" aria-current="page" href="<?php echo route('dashboard'); ?>">
          <i class="bi bi-house-door"></i>
          Dashboard
        </a>
      </li>

      <?php
      if (isset($_REQUEST['id']) && isset($_REQUEST['lang'])):
        ?>
        <li class="nav-item my-2">
          <strong class="ms-3 text-secondary-3">
            <?= $_REQUEST['id'] ?>
          </strong>
          <a class="nav-link basic-details" aria-current="page"
            href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/basic-details') . queryString(); ?>">
            <i class="bi bi-clipboard-data"></i>
            Basic Details
          </a>

           <a class="nav-link hosts" aria-current="page"
            href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/hosts') . queryString(); ?>">
            <i class="bi bi-people-fill"></i>
            Hosts
          </a>

          <a class="nav-link timeline" aria-current="page"
            href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/timeline') . queryString(); ?>">
            <i class="bi bi-clock"></i>
            Events
          </a>

          <a class="nav-link additional-details" aria-current="page"
            href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/additional-details') . queryString(); ?>">
            <i class="bi bi-pie-chart"></i>
            Additional Details
          </a>

          <a class="nav-link gallery" aria-current="page"
            href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/gallery') . queryString(); ?>">
            <i class="bi bi-image"></i>
             Gallery
          </a>

          <a class="nav-link our-story" aria-current="page"
            href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/our-story') . queryString(); ?>">
            <i class="bi bi-file-earmark-post"></i>
            Our Story
          </a>

          <a class="nav-link whatsapp" aria-current="page"
            href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/whatsapp') . queryString(); ?>">
            <i class="bi bi-whatsapp"></i>
            Whatsapp Setup
          </a>


          <a class="nav-link preview" target="_blank" aria-current="page"
            href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/preview') . queryString(); ?>">
            <i class="bi bi-eye"></i>
            Preview 
          </a>


          <a class="nav-link checkout" aria-current="page"
            href="<?php echo route('wedding/' . $_REQUEST['id'] .   '/checkout') . queryString(); ?>">
            <i class="bi bi-currency-rupee"></i>
            Payment
          </a>
        </li>
        <?php
      elseif (isset($_REQUEST['id'])):
        ?>
<li class="nav-item my-2">
          <strong class="ms-3 text-secondary-3">
            <?= $_REQUEST['id'] ?>
          </strong>
<a class="nav-link checkout" aria-current="page"
            href="<?php echo route('wedding/' . $_REQUEST['id'] .   '/checkout') . queryString(); ?>">
            <i class="bi bi-currency-rupee"></i>
            Payment
          </a>
</li>
        <?php
      endif;
      ?>

    </ul>
  </div>
</aside>


<script type="text/javascript">
  var url = window.location.pathname
  console.log(url)
  switch (url) {
    case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . "/dashboard" : "/dashboard" ?>":
      document.querySelector(".dashboard").classList.toggle("active")
      break
      <?php
      if (isset($_REQUEST['id']) && isset($_REQUEST['lang'])):
        ?>

      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/basic-details' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/basic-details'; ?>":
        document.querySelector(".basic-details").classList.toggle("active")
        break

      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/our-story' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/our-story'; ?>":
        document.querySelector(".our-story").classList.toggle("active")
        break
        
      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/hosts' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/hosts'; ?>":
        document.querySelector(".hosts").classList.toggle("active")
        break

        case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/timeline' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/timeline'; ?>":
        document.querySelector(".timeline").classList.toggle("active")
        break

        
      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/additional-details' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/additional-details'; ?>":
        document.querySelector(".additional-details").classList.toggle("active")
        break

      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/gallery' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/gallery'; ?>":
        document.querySelector(".gallery").classList.toggle("active")
        break
        
      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/whatsapp' : '/wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/whatsapp'; ?>":
        document.querySelector(".whatsapp").classList.toggle("active")
        break

        case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/checkout' : '/wedding/' . $_REQUEST['id'] .  '/checkout'; ?>":
        document.querySelector(".checkout").classList.toggle("active")
        break

        <?php
      elseif (isset($_REQUEST['id'])):
        ?>

case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . '/wedding/' . $_REQUEST['id'] . '/checkout' : '/wedding/' . $_REQUEST['id'] .  '/checkout'; ?>":
        document.querySelector(".checkout").classList.toggle("active")
        break


        <?php
      endif;
      ?>
  }
</script>