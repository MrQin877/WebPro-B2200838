<?php
session_start(); // 세션 시작
require_once 'db_connect.php'; // 데이터베이스 연결 설정 파일

// POST 데이터에서 값 가져오기
$review = $_POST['review'];
$star = $_POST['star'];
$program = $_POST['program'];
$email = $_POST['email'];

// 현재 로그인된 사용자의 이메일 가져오기
if (isset($_SESSION['email'])) {
    $loggedInUserEmail = $_SESSION['email'];

    // 현재 로그인된 이메일과 입력된 이메일이 일치하는지 확인
    $stmt = $conn->prepare("SELECT email FROM user_registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userEmail);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && $userEmail == $loggedInUserEmail) {
        // 일치하는 경우, 리뷰 데이터를 저장
        $stmt = $conn->prepare("INSERT INTO saved_review (review, star, program, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $review, $star, $program, $email);
        $stmt->execute();
        $stmt->close();

        echo "Review saved successfully!";
    } else {
        echo "Error: Current logged-in email does not match the provided email.";
    }
} else {
    echo "Error: No user logged in.";
}

$conn->close(); // 데이터베이스 연결 종료
?>
