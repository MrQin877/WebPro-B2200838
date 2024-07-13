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
    
    // 현재 시간 구하기
    $saved_time = date('Y-m-d H:i:s'); // 예: 2024-07-14 15:30:00

    // 새 리뷰 삽입 쿼리
    $sql_insert = "INSERT INTO user_review (review, star, program, saved_time) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssss", $review, $star, $program, $saved_time);

    // 쿼리 실행
    if ($stmt_insert->execute()) {
        echo "Review submitted successfully";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }

    // 최신 5개 리뷰만 유지하기 위해 가장 오래된 리뷰 삭제 쿼리
    $sql_delete_oldest = "DELETE FROM user_review WHERE reviewID NOT IN (
        SELECT reviewID FROM (
            SELECT reviewID FROM user_review WHERE program = ? ORDER BY saved_time DESC LIMIT 5
        ) AS to_keep
    ) AND program = ?";
    
    // 삭제 쿼리 준비
    $stmt_delete_oldest = $conn->prepare($sql_delete_oldest);
    $stmt_delete_oldest->bind_param("ss", $program, $program);

    // 쿼리 실행
    if ($stmt_delete_oldest->execute()) {
        echo "Oldest reviews deleted successfully";
    } else {
        echo "Error deleting oldest reviews: " . $conn->error;
    }

    // 문장 닫기
    $stmt_insert->close();
    $stmt_delete_oldest->close();
}

// 데이터베이스 연결 닫기
$conn->close();
?>
