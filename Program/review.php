<?php
// save_review.php

// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root"; // 사용자 이름
$password = ""; // 비밀번호
$dbname = "user"; // 데이터베이스 이름

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// POST 데이터 가져오기
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['UserID']; // 세션에서 사용자 ID 가져오기 (세션 사용 예시)
    $star = $_POST['star']; // 별점 가져오기
    $reviewText = $_POST['review']; // 리뷰 텍스트 가져오기

    // SQL 쿼리 생성
    $sql = "INSERT INTO user_review (review, star, UserID) VALUES (?, ?, ?)";
    
    // SQL 문 준비
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // 매개변수를 바인딩하고 SQL 문 실행
    $stmt->bind_param("sss", $reviewText, $star, $UserID);
    if ($stmt->execute() === true) {
        echo "Review saved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // 문 닫기
    $stmt->close();
}

// 데이터베이스 연결 닫기
$conn->close();
?>
