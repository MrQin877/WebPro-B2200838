<?php
// logincheckstatus.php
session_start();

$is_logged_in = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];

// Send JSON response
header('Content-Type: application/json');
echo json_encode(array('is_logged_in' => $is_logged_in));
?>
