<head>

    <?php require("views/partials/themes/metatags.php"); ?>

    <!-- Bootstrap core CSS -->
    <link href="<?php assets("bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet">
    <script src="<?php assets("bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>

    <!-- Jquery -->
    <script src="<?php assets("jquery/jquery.min.js"); ?>"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <!-- Custom styles for this template -->
    <!-- <link rel="stylesheet" href="<?php //themeAssets($themeID,"css/common.css");?>"> -->
    <link rel="stylesheet" href="<?php themeAssets($themeID,"css/app.css"); ?>">

    <!-- owl carousel css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.theme.default.min.css">

    <title>
        <?php echo $config['APP_TITLE']; ?>
    </title>
</head>