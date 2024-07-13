<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user"; // 데이터베이스 이름으로 변경하세요

// Check if program parameter is provided
if (!isset($_GET['program'])) {
    echo json_encode(['error' => 'Program parameter is missing']);
    exit;
}

$program = $_GET['program'];

// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement
$stmt = $conn->prepare("SELECT review, star, email FROM saved_review WHERE program = ?");
$stmt->bind_param("s", $program);
$stmt->execute();
$result = $stmt->get_result();

// Fetch reviews into an array
$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

// Close statement and connection
$stmt->close();
$conn->close();

// Output reviews as JSON
header('Content-Type: application/json');
echo json_encode(['reviews' => $reviews]);
?>
