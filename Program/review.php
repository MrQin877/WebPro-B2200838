<?php
// review.php

// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root"; // 사용자 이름 (데이터베이스 접속 계정)
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
    // 세션 사용 예시: 로그인한 사용자의 ID 가져오기
    session_start();
    $userId = $_SESSION['UserID'];

    // 데이터 필터링 및 준비
    $reviewText = $_POST['review']; // 리뷰 텍스트
    $star = $_POST['star']; // 별점

    // SQL 쿼리 생성
    $sql = "INSERT INTO user_reviews (review, star, UserID) VALUES (?, ?, ?)";

    // SQL 문 준비
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // 매개변수를 바인딩하고 SQL 문 실행
    $stmt->bind_param("ssi", $reviewText, $star, $userId);
    if ($stmt->execute() === true) {
        $reviewID = $stmt->insert_id; // 새로 생성된 리뷰의 reviewID 가져오기
        echo "Review saved successfully. Review ID: " . $reviewID; // 성공 메시지 반환
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // 오류 메시지 반환
    }

    // 문 닫기
    $stmt->close();
}

// 데이터베이스 연결 닫기
$conn->close();
?>
