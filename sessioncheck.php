<?php
session_start();
header('Content-Type: application/json');

$response = [];

if (isset($_SESSION['user_id'])) {
    $response['loggedIn'] = true;
    $response['user_id'] = $_SESSION['user_id'];
    $response['isAdmin'] = $_SESSION['user_id'] == 0;
} else {
    $response['loggedIn'] = false;
    $response['isAdmin'] = false;
}

echo json_encode($response);
?>

