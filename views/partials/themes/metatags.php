
 <!-- Meta Tags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?php echo $weddingData['brideName'];?> Weds <?php echo $weddingData['groomName'];?> - Join us in celebrating the wedding of <?php echo $weddingData['brideName'];?> and <?php echo $weddingData['groomName'];?> on <?= formatTimeStamp($muhurt['startTime']); ?>. Get all the details, RSVP, and share your best wishes online.">
    <meta name="keywords" content="wedding, eSubhalekha, online Subhalekha, evite, online invitation, <?php echo $weddingData['weddingName'];?>, <?php echo $weddingData['weddingID'];?>, <?php echo $weddingData['brideName'];?>, <?php echo $weddingData['groomName'];?>, wedding details, wedding RSVP, wedding event, eSubhalekha">
    <meta name="author" content="eSubhalekha.com">
    <meta name="robots" content="index, follow">
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="theme-color" content="<?php echo $config['APP_THEME_COLOR']; ?>" />

       <!-- Open Graph Tags -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $weddingData['weddingName'] . " - " . $config['APP_NAME']; ?>" />
    <meta property="og:url" content="<?php echo url(); ?>" />
    <meta property="og:description" content="<?php echo $weddingData['brideName']; ?> Weds <?php echo $weddingData['groomName']; ?> - Join us in celebrating the wedding of <?php echo $weddingData['brideName']; ?> and <?php echo $weddingData['groomName']; ?> on <?php echo $weddingData['weddingDate']; ?>. Get all the details, RSVP, and share your best wishes online." />
    <meta property="og:image" itemprop="image" content="<?= home() ?>themes/image.png.php?brideName=<?php echo urlencode($weddingData['brideName']); ?>&groomName=<?php echo urlencode($weddingData['groomName']); ?>&weddingDate=<?php echo formatTimeStamp($muhurt['startTime']);?>&theme=<?= $themeID ?>" />
    <meta property="og:image:secure_url" itemprop="image" content="<?= home() ?>themes/image.png.php?brideName=<?php echo urlencode($weddingData['brideName']); ?>&groomName=<?php echo urlencode($weddingData['groomName']); ?>&weddingDate=<?php echo formatTimeStamp($muhurt['startTime']);?>&theme=<?= $themeID ?>" />
    <meta property="og:site_name" content="<?php echo $config['APP_NAME']; ?>" />
    
    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo $config['APP_NAME']; ?>" />
    <meta name="twitter:description" content="<?php echo $weddingData['brideName']; ?> Weds <?php echo $weddingData['groomName']; ?> - Join us in celebrating the wedding of <?php echo $weddingData['brideName']; ?> and <?php echo $weddingData['groomName']; ?> on <?php echo $weddingData['weddingDate']; ?>. Get all the details, RSVP, and share your best wishes online." />
    <meta name="twitter:image" content="<?= home() ?>themes/image.png.php?brideName=<?php echo urlencode($weddingData['brideName']); ?>&groomName=<?php echo urlencode($weddingData['groomName']); ?>&weddingDate=<?php echo formatTimeStamp($muhurt['startTime']);?>&theme=<?= $themeID ?>" />
