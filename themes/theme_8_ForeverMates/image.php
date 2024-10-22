<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start output buffering to avoid premature output
ob_start();

// Set the content type to be an image
header('Content-Type: image/png');

// Image dimensions
$imageWidth = 1200;
$imageHeight = 630;

$backgroundUrl = "https://static.vecteezy.com/system/resources/previews/006/845/898/non_2x/watercolor-floral-background-with-brush-and-floral-frame-for-horizontal-banner-backdrop-wedding-invitation-thank-you-card-wallpaper-free-photo.jpg"; // URL to a floral background

// Fetch the background image data from the URL
$backgroundImageData = file_get_contents($backgroundUrl);

if (!$backgroundImageData) {
    die("Error: Could not load the background image.");
}

// Create a GD image resource from the background image data
$backgroundImage = imagecreatefromstring($backgroundImageData);

if (!$backgroundImage) {
    die("Error: Could not create the background image.");
}

// Create a blank true color image with the specified dimensions
$image = imagecreatetruecolor($imageWidth, $imageHeight);

// Copy the background image onto the blank image
imagecopyresampled($image, $backgroundImage, 0, 0, 0, 0, $imageWidth, $imageHeight, imagesx($backgroundImage), imagesy($backgroundImage));

// Free up memory for the background image
imagedestroy($backgroundImage);

// Define text and border colors
$textColor = imagecolorallocate($image, 102, 51, 0); 
$borderColor = imagecolorallocate($image, 101, 167, 106); 

// Draw a decorative border 
$borderWidth = 10;
imagesetthickness($image, $borderWidth);
imagerectangle($image, $borderWidth / 2, $borderWidth / 2, $imageWidth - $borderWidth / 2, $imageHeight - $borderWidth / 2, $borderColor);

$fontPath = "assets/fonts/Garamond.ttf"; // Regular font for names
$cursiveFontPath = "assets/fonts/Graphene.ttf"; // Cursive font for the "We are getting married" text

// Check if the font files exist
if (!file_exists($fontPath) || !file_exists($cursiveFontPath)) {
    die("Error: Font file(s) not found.");
}

// Names of the couple
$brideName = "Sara";
$groomName = "Rehan";
$andSymbol = "&"; // Decorative "&" symbol

// Wedding date
$weddingDate = "April 23, 2024";

// Add text for the bride's name
$fontSizeNames = 60;
$bboxBride = imagettfbbox($fontSizeNames, 0, $fontPath, $brideName);
$brideTextWidth = $bboxBride[2] - $bboxBride[0];
$brideX = ($imageWidth / 2) - ($brideTextWidth / 2);
$brideY = 230; // Adjust this value for vertical positioning

imagettftext($image, $fontSizeNames, 0, $brideX, $brideY, $textColor, $fontPath, $brideName);

// Add the decorative "&" symbol
$fontSizeAnd = 50; // Slightly smaller size for the "&"
$bboxAnd = imagettfbbox($fontSizeAnd, 0, $fontPath, $andSymbol);
$andTextWidth = $bboxAnd[2] - $bboxAnd[0];
$andX = ($imageWidth / 2) - ($andTextWidth / 2);
$andY = $brideY + 70; // Adjust this to control spacing between bride and "&"

imagettftext($image, $fontSizeAnd, 0, $andX, $andY, $textColor, $fontPath, $andSymbol);

// Add text for the groom's name
$bboxGroom = imagettfbbox($fontSizeNames, 0, $fontPath, $groomName);
$groomTextWidth = $bboxGroom[2] - $bboxGroom[0];
$groomX = ($imageWidth / 2) - ($groomTextWidth / 2);
$groomY = $andY + 70; // Adjust for vertical spacing between "&" and the groom's name

imagettftext($image, $fontSizeNames, 0, $groomX, $groomY, $textColor, $fontPath, $groomName);

// Add "We are getting married" in cursive
$cursiveText = "We are getting married";
$fontSizeCursive = 20;
$bboxCursive = imagettfbbox($fontSizeCursive, 0, $cursiveFontPath, $cursiveText);
$cursiveTextWidth = $bboxCursive[2] - $bboxCursive[0];
$cursiveX = ($imageWidth / 2) - ($cursiveTextWidth / 2);
$cursiveY = $groomY + 45; // Reduced space between groom's name and cursive text

imagettftext($image, $fontSizeCursive, 0, $cursiveX, $cursiveY, $textColor, $cursiveFontPath, $cursiveText);

// Add text for the wedding date
$fontSizeDate = 25;
$bboxDate = imagettfbbox($fontSizeDate, 0, $fontPath, $weddingDate);
$dateTextWidth = $bboxDate[2] - $bboxDate[0];
$dateX = ($imageWidth / 2) - ($dateTextWidth / 2);
$dateY = $cursiveY + 45; // Reduced space between cursive text and wedding date

imagettftext($image, $fontSizeDate, 0, $dateX, $dateY, $textColor, $fontPath, $weddingDate);

// Output the image as PNG
imagepng($image);

// Free up memory
imagedestroy($image);

// Clear output buffer
ob_end_flush();
?>
