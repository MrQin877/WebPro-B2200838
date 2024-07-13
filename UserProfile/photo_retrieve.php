<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set header for JSON response
header('Content-Type: application/json');

// Retrieve user's current profile picture
$user_id = $_SESSION['user_id'];
$getImageSql = "SELECT file_path FROM up_load WHERE UserID = ? ORDER BY upload_time DESC LIMIT 1";
$stmt = $conn->prepare($getImageSql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$currentImage = $result->fetch_assoc()['file_path'] ?? '../images/default-profile.png'; // Default profile picture if none found

echo json_encode(["image" => $currentImage]);

$stmt->close();
$conn->close();
?>

