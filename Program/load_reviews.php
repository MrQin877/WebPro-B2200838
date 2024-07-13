<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user"; // 데이터베이스 이름으로 변경하세요

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 프로그램 이름 가져오기 (반드시 존재해야 함)
$program = isset($_GET['program']) ? $_GET['program'] : '';

// Prepared statement 준비
$stmt = $conn->prepare("SELECT review, star, program FROM user_review WHERE program = ?");
$stmt->bind_param("s", $program); // s는 문자열을 나타내며, 여기서는 프로그램 이름이어야 합니다.

// 쿼리 실행
$stmt->execute();

// 결과 가져오기
$result = $stmt->get_result();

// 결과 배열 초기화
$reviews = [];

// 결과를 배열로 변환
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

// 연결 및 statement 닫기
$stmt->close();
$conn->close();

// JSON 형식으로 결과 반환
header('Content-Type: application/json');
echo json_encode(['reviews' => $reviews]);
?>
