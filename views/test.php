<?php

errors(0);

// Include the Wedding controller
controller('Wedding');


// Test data for creating a wedding
$weddingData = [
    'weddingID' => 'SamarthWedsShreya',
    'weddingName' => 'Destination Vivaha Rajasthan',
    'fromRole' => 'groom',
    'brideName' => 'Shreya', 
    'groomName' => 'Samarth', 
    'host' => 'vaibhavidixit511@gmail.com',
];


// Create an instance of the Wedding controller
$weddingController = new Wedding();

// // Test the create function
// $result = $weddingController->create($weddingData);

// // Display the result
// echo json_encode($result);


// // Test the update function
$resultOfUpdate = $weddingController->update('SamarthWedsShreya',$weddingData);

// // Display the result
echo json_encode($resultOfUpdate);

// Test the delete function

// $resultOfDelete = $weddingController->delete('RehanWedsHarshada','en');


// Test the delete function
// $resultOfDelete = $weddingController->create($weddingData);

// Display the result
// echo json_encode($resultOfDelete);





