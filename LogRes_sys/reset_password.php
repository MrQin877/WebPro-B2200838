<?php
session_start(); // 세션 시작

$servername = "localhost"; // 데이터베이스 서버 이름
$username = "root"; // 데이터베이스 사용자 이름
$password = ""; // 데이터베이스 비밀번호
$dbname = "user"; // 데이터베이스 이름

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 세션에서 이메일 가져오기
if (!isset($_SESSION['reset_email'])) {
    echo "Session error: No recovery email found.";
    exit();
}

// 새로운 비밀번호와 컨펌 비밀번호 가져오기
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// 입력값 확인
if (empty($new_password) || empty($confirm_password)) {
    echo "All fields are required.";
} elseif ($new_password !== $confirm_password) {
    echo "New passwords do not match.";
} else {
    // 이메일과 매치되는 회원의 비밀번호 업데이트
    $email = $_SESSION['reset_email'];
    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE user_registration SET password = '$new_password_hashed' WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        echo "Password updated successfully.";
    } else {
        echo "Error updating password: " . $conn->error;
    }
}

$conn->close();
?>
