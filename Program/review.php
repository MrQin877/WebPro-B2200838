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

    $sql = "INSERT INTO user_review (review, star, program) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $review, $star, $program);

    if ($stmt->execute()) {
        echo "Review submitted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
