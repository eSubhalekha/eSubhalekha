<?php

errors(1);

// controller('Theme');

// Instantiate the ThemeController class
// $themeController = new ThemeController();

// Call the getThemes method
// $themes = $themeController->render('fairytale_theme', $_REQUEST['type']);

controller('BrevoSMS');

// API: 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


// Usage
$brevoSms = new BrevoSMS();
$sender = 'Vaibhavi';
$recipient = '+919284552192';
$message = 'Hello OTP: 34563!';
$webUrl = 'https://esubhalekha.com/';
$brevoSms->sendTransactionalSms($sender, $recipient, $message);


