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

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "You must be logged in to access this information."]);
    exit();
}

$user_id = $_SESSION['user_id'];

$user_query = "SELECT Username AS username, Email AS email, PhoneNumber AS phone, Birth AS birthday, Gender AS gender FROM user_registration WHERE UserID = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user_info = $user_result->fetch_assoc();


$response = [
    "username" => $user_info['username'],
    "email" => $user_info['email'],
    "phone" => $user_info['phone'],
    "birthday" => $user_info['birthday'],
    "gender" => $user_info['gender'],
];

echo json_encode($response);

$stmt->close();
$conn->close();
?>
