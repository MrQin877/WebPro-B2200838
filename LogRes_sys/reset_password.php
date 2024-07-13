<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reset_token = $_POST['reset_token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // 입력값 확인
    if (empty($reset_token) || empty($new_password) || empty($confirm_password)) {
        echo "All fields are required.";
    } else {
        // 인증 코드 검증
        if (!isset($_SESSION['reset_token']) || $_SESSION['reset_token'] !== $reset_token) {
            echo "Invalid or expired reset token.";
        } else {
            $user_id = $_SESSION['user_id'];
            $sql = "UPDATE user_registration SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            
            // 비밀번호 해싱
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            $stmt->bind_param("si", $hashed_password, $user_id);
            
            if ($stmt->execute()) {
                echo "Password updated successfully.";
                // 비밀번호 업데이트 후 세션 삭제
                unset($_SESSION['reset_token']);
                unset($_SESSION['user_id']);
            } else {
                echo "Error updating password: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>
