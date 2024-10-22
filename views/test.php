<?php

errors(1);

// print_r($themeDetails);

// controller('Theme');

// Instantiate the ThemeController class
// $themeController = new ThemeController();

// Call the getThemes method
// $themes = $themeController->render('fairytale_theme', $_REQUEST['type']);



   // Path to mPDF autoload file
   // require_once __DIR__ . '/../controllers/vendor/autoload.php';

   // // Check if mPDF class is loaded
   // if (!class_exists('Mpdf\Mpdf')) {
   //     die('mPDF class not found. Check if mPDF is installed.');
   // }

   // use Mpdf\Mpdf;
   
   // // Create a new mPDF instance
   // $mpdf = new Mpdf();

   // Your PDF generation logic here

// require_once(__DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php');


// // create new PDF document
// $pdf = new TCPDF();


// // add a page
// $pdf->AddPage();

// // set font
// $pdf->SetFont('helvetica', '', 12);

// // add some text
// $html = '<h1>Welcome to TCPDF!</h1>';
// $pdf->writeHTML($html, true, false, true, false, '');

// // output the PDF (force download)
// $pdf->Output('sample.pdf', 'D');



// Your JSON data
$json = '{
  "": {
    "path": "views/index.php"
  },
  "pricing": {
    "path": "views/pricing.php"
  },
  "features": {
    "path": "views/features.php"
  },
  "partners": {
    "path": "views/partners.php"
  },
  "contact": {
    "path": "views/contact.php"
  },
  "support": {
    "path": "views/support.php"
  },
  "feedback": {
    "path": "views/feedback.php"
  },
  "about": {
    "path": "views/about.php"
  },
  "faq": {
    "path": "views/faq.php"
  },
  "privacy": {
    "path": "views/privacy.php"
  },
  "terms": {
    "path": "views/terms.php"
  },
  "themes": {
    "path": "views/dashboard/themes.php"
  },
  "themes/{category}": {
    "path": "views/themes/category.php"
  },
  "themes/{category}/{id}": {
    "path": "views/themes/theme.php"
  },
  "templates/Royal-Bramhin": {
    "path": "views/templates/Royal-Bramhin/index.php"
  },
  "login": {
    "path" : "views/auth/login.php"
  },
  "login/{role}": {
    "path" : "views/auth/login.php"
  },
  "register": {
    "path": "views/auth/register.php"
  },
  "register/{role}": {
    "path": "views/auth/register.php"
  },
  "verify": {
    "path": "views/auth/verify.php"
  },
  "dashboard": {
    "path": "views/dashboard/index.php"
  },
  "wedding/new": {
    "path": "views/dashboard/wedding/new.php"
  },
  "wedding/{id}/theme": {
    "path": "views/dashboard/wedding/theme.php"
  },
  "wedding/{id}/{lang}/upload": {
    "path": "views/dashboard/wedding/uploader.php"
  },
  "wedding/{id}/{lang}/payment": {
    "path": "views/dashboard/wedding/paymentProcess.php"
  },
  "wedding/{id}/{lang}/checkout": {
    "path": "views/dashboard/wedding/checkout.php"
  },
  "wedding/{id}/billing": {
    "path": "views/dashboard/wedding/billing.php"
  },
  "wedding/{id}/{lang}": {
    "path": "views/dashboard/wedding/index.php"
  },
  "wedding/{id}/{lang}/progress": {
    "path": "views/dashboard/wedding/progress.php"
  },
  "wedding/{id}/{lang}/basic-details": {
    "path": "views/dashboard/wedding/basic-details.php"
  },
  "wedding/{id}/{lang}/our-story": {
    "path": "views/dashboard/wedding/ourstory.php"
  },
  "wedding/{id}/{lang}/edit": {
    "path": "views/dashboard/wedding/edit.php"
  },
  "wedding/{id}/{lang}/delete": {
    "path": "views/dashboard/wedding/delete.php"
  },
  "wedding/{id}/{lang}/timeline": {
    "path": "views/dashboard/wedding/timeline.php"
  },
  "wedding/{id}/{lang}/hosts": {
    "path": "views/dashboard/wedding/hosts.php"
  },
  "wedding/{id}/{lang}/whatsapp": {
    "path": "views/dashboard/wedding/whatsapp.php"
  },
  "wedding/{id}/{lang}/messages": {
    "path": "views/dashboard/wedding/messages.php"
  },
  "wedding/{id}/{lang}/messages/{messageID}/{messageType}": {
    "path": "views/dashboard/wedding/messagesent.php"
  },
  "wedding/{id}/{lang}/messages/{messageID}": {
    "path": "views/dashboard/wedding/message.php"
  },
  "wedding/{id}/{lang}/additional-details": {
    "path": "views/dashboard/wedding/additional-details.php"
  },
  "wedding/{id}/{lang}/gallery": {
    "path": "views/dashboard/wedding/gallery.php"
  },
  "wedding/{id}/{lang}/theme": {
    "path": "views/dashboard/wedding/theme.php"
  },
  "wedding/{id}/{lang}/preview": {
    "path": "views/dashboard/wedding/preview.php"
  },
  "user/profile": {
    "path": "views/account/profile.php"
  },
  "partner/profile": {
    "path": "views/account/partnerProfile.php"
  },
  "partner/dashboard": {
    "path": "views/dashboard/partnerDash.php"
  },
  "receipt/{id}/{lang}": {
    "path": "views/dashboard/wedding/receipt.php"
  },
  "{id}/{lang}": {
    "path": "views/wedding.php"
  },
  "{id}/{lang}/{type}": {
    "path": "views/wedding.php"
  },
  "wedding/{id}/{lang}/guests": {
    "path": "views/dashboard/wedding/guests/index.php"
  },
  "wedding/{id}/{lang}/guests/add": {
    "path": "views/dashboard/wedding/guests/add.php"
  },
  "wedding/{id}/{lang}/guests/{guestID}": {
    "path": "views/dashboard/wedding/guests/guest.php"
  },
  "wedding/{id}/{lang}/guests/{guestID}/delete": {
    "path": "views/dashboard/wedding/guests/delete.php"
  },
  "wedding/{id}/{lang}/guests/groups": {
    "path": "views/dashboard/wedding/guests/groups/index.php"
  },
  "wedding/{id}/{lang}/guests/groups/{group}": {
    "path": "views/dashboard/wedding/guests/groups/group.php"
  },
  "wedding/{id}/analytics": {
    "path": "views/dashboard/wedding/analytics.php"
  },
  "account": {
    "path": "views/account/index.php"
  },
  "account/payments": {
    "path": "views/account/payments.php"
  },
  "account/delete": {
    "path": "views/account/delete.php"
  },
  "migrate": {
    "path": "views/migrate.php"
  },
  "logout": {
    "path": "views/auth/logout.php"
  },
  "test": {
    "path": "views/test.php"
  }
}
';

// Decode JSON to associative array
$data = json_decode($json, true);

print_r($data);

// HTML table start
echo "<table border='1'>";
echo "<tr><th>Route</th><th>Path</th></tr>";

// Iterate over the data and display in table rows
foreach ($data as $route => $info) {
    echo "<td>" . $info['path'] . "</td></tr>";
}

// HTML table end
echo "</table>";

?>
