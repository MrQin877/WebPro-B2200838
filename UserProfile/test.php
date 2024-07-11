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

$user_id = $_SESSION['user_id'];

// Initialize an array to store user data
$userData = [
    'username' => '',
    'email' => '',
    'birthday' => '',
    'phone' => '',
    'nickname' => '',
    'bio' => '',
    'photo' => ''
];

// Get data from user_registration
$sql = "SELECT username, email, birthday, phone FROM user_registration WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $userData = array_merge($userData, $result->fetch_assoc());
}
$stmt->close();

// Get data from user_optional
$sql = "SELECT nickname, bio FROM user_optional WHERE user_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $userData = array_merge($userData, $result->fetch_assoc());
}
$stmt->close();

// Get photo from up_load
$sql = "SELECT file_path FROM up_load WHERE UserID = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $photoData = $result->fetch_assoc();
    $userData['photo'] = $photoData['file_path'];
}
$stmt->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode($userData);

$conn->close();
?>