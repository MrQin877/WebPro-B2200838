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

$query = "SELECT * FROM teacher_profile";
$result = $conn->query($query);
$teachers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }
}

echo json_encode(["teachers" => $teachers]);

$conn->close();
?>