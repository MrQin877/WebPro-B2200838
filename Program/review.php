<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user"; // 데이터베이스 이름으로 변경하세요

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// POST 요청이 있는 경우 데이터베이스에 리뷰를 저장
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $review = $_POST['review'];
    $star = $_POST['star'];
    $program = $_POST['program'];
    $saved_time = @$_saved_time['saved_time'];
    
    // SQL 쿼리
    $sql = "INSERT INTO user_review (review, star, program, saved_time) VALUES (?, ?, ?, ?)";

    // 준비된 문장을 생성하고 매개변수를 바인딩
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $review, $star, $program); // 매개변수 타입에 주의하세요: s는 문자열, i는 정수입니다.

    // 쿼리 실행
    if ($stmt->execute()) {
        echo "Review submitted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // 문장 닫기
    $stmt->close();
}

// 데이터베이스 연결 닫기
$conn->close();
?>
