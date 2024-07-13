<?php
session_start();
header('Content-Type: application/json');

$response = [];

// Function to check if user is logged in
function check_login() {
    return isset($_SESSION['user_id']);
}

// Initialize response variables
if (check_login()) {
    $response['loggedIn'] = true;
    $response['user_id'] = $_SESSION['user_id'];
    $response['isAdmin'] = ($_SESSION['user_id'] == 0); // Assuming admin user ID is 0
} else {
    $response['loggedIn'] = false;
    $response['isAdmin'] = false;
}
// password:smartstudy1507@sport gmail: admin1507@smartstudysport.com

echo json_encode($response);
?>

