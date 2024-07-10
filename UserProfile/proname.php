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

$courses_query = "SELECT pr.Program_Name, urpr.purchase_date FROM user_program urpr JOIN program pr ON pr.Program_id = urpr.program_id WHERE urpr.user_ID = ?";
$stmt = $conn->prepare($courses_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$courses_result = $stmt->get_result();
$purchased_courses = [];
while ($row = $courses_result->fetch_assoc()) { // Fetching courses
    $purchased_courses[] = $row['Program_Name'];
}

// Sending the JSON response
echo json_encode(["courses" => $purchased_courses]);

$stmt->close();
$conn->close();
?>
