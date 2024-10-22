<head>
     
     <?php require("views/partials/themes/metatags.php"); ?>

    <!-- Stylesheets -->
    <link rel="canonical" href="<?php echo url(); ?>" />
    <link rel="icon" href="<?php echo route($config['APP_ICON']); ?>" />

    <!-- Bootstrap -->
    <link href="<?php assets("bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <!-- Owl CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

    <!-- Tailwind -->
    <link rel="stylesheet" href="<?php themeAssets($themeID, "tailwind.min.js")?>" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php themeAssets($themeID,"index.css"); ?>" />

    <!-- Boxicons -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- JavaScript -->
    <script src="<?php assets("bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
    <script src="<?php assets("jquery/jquery.min.js"); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
