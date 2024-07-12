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

$data = json_decode(file_get_contents('php://input'), true);
$teachID = $data['TeachID'];

$query = "DELETE FROM teacher_profile WHERE TeachID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $teachID);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['error'] = "Error deleting teacher: " . $conn->error;
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
