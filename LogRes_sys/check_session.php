<?php
session_start();
header('Content-Type: application/json');

$response = [];

if (isset($_SESSION['user_id'])) {
    $response['loggedIn'] = true;
    $response['user_id'] = $_SESSION['user_id'];
} else {
    $response['loggedIn'] = false;
}

echo json_encode($response);
?>
