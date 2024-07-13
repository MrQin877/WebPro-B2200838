<?php
session_start();
header('Content-Type: application/json');

$response = [];

if (isset($_SESSION['user_id'])) {
    $response['loggedIn'] = true;
} else {
    $response['loggedIn'] = false;
}

echo json_encode($response);
?>
