<?php
// review.php

// 데이터베이스 연결 설정
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

// 세션 시작 (로그인 세션 관리를 위해 필요할 수 있음)
session_start();

// POST 데이터 가져오기
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 사용자 ID 가져오기 (세션 사용 예시)
    if (isset($_SESSION['UserID'])) {
        $userId = $_SESSION['UserID'];
    } else {
        die("User ID not found in session.");
    }

    // 리뷰 텍스트 및 별점 가져오기
    $reviewText = $_POST['commentText'];
    $star = $_POST['rating'];
    $program = $_POST['subject'];

    // SQL 쿼리 생성
    $sql = "INSERT INTO user_review (review, star, UserID, program) VALUES (?, ?, ?, ?)";

    // SQL 문 준비
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // 매개변수 바인딩 및 실행
    $stmt->bind_param("siss", $reviewText, $star, $userId, $program);
    if ($stmt->execute() === true) {
        echo "Review saved successfully."; // 성공 메시지 반환
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // 오류 메시지 반환
    }

    // 문 닫기
    $stmt->close();
}

// 데이터베이스 연결 닫기
$conn->close();
?>
