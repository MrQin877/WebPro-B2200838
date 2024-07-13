<?php
session_start();

// Check if user is logged in
function check_login() {
    return isset($_SESSION['user_id']);
}

// Check login status and return JSON response
$response = array(
    'loggedIn' => check_login()
);

header('Content-Type: application/json');
echo json_encode($response);
?>
