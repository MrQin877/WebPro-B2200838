<?php
$servername = "localhost";
$username = "root"; // 데이터베이스 사용자 이름
$password = ""; // 데이터베이스 비밀번호
$dbname = "user"; // 데이터베이스 이름

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// POST 데이터 가져오기
$review = $_POST['review'];
$star = $_POST['star'];
$program = $_POST['program'];
$email = $_POST['email'];

// SQL 쿼리 준비
$sql = "INSERT INTO user_review (review, star, program, email) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siss", $review, $star, $program, $email);

if ($stmt->execute()) {
    echo "Review submitted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// 연결 종료
$stmt->close();
$conn->close();
?>
