<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user"; // 데이터베이스 이름으로 변경하세요

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$program = $_GET['program'];
$stmt = $conn->prepare("SELECT review, star, email FROM user_review WHERE program = ?");
$stmt->bind_param("s", $program);
$stmt->execute();
$result = $stmt->get_result();

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode(['reviews' => $reviews]);
?>
