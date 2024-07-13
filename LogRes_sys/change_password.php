<?php
session_start(); // 세션 시작

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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

// 로그인 상태 확인
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// 비밀번호 변경 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $verification_code = $_POST['verification_code'];
    
    // 입력값 확인
    if (empty($current_password) || empty($new_password) || empty($confirm_password) || empty($verification_code)) {
        echo "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        echo "New passwords do not match.";
    } else {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT password, email FROM user_registration WHERE id = '$user_id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($current_password, $row['password'])) {
                if ($_SESSION['verification_code'] == $verification_code) {
                    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                    $sql = "UPDATE user_registration SET password = '$new_password_hashed' WHERE id = '$user_id'";
                    
                    if ($conn->query($sql) === TRUE) {
                        echo "Password updated successfully.";
                        unset($_SESSION['verification_code']); // 인증 코드 제거
                    } else {
                        echo "Error updating password: " . $conn->error;
                    }
                } else {
                    echo "Verification code is incorrect.";
                }
            } else {
                echo "Current password is incorrect.";
            }
        } else {
            echo "User not found.";
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['send_verification_code'])) {
    // 인증 코드 생성 및 이메일 발송
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT email FROM user_registration WHERE id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        $verification_code = rand(100000, 999999); // 6자리 랜덤 코드 생성
        $_SESSION['verification_code'] = $verification_code;

        // PHPMailer를 사용하여 이메일 발송
        $mail = new PHPMailer(true);
        try {
            // 서버 설정
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; // SMTP 서버
            $mail->SMTPAuth = true;
            $mail->Username = 'wnsgud030405@gmail.com'; // SMTP 사용자 이메일
            $mail->Password = ''; // SMTP 사용자 비밀번호
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // 수신자 설정
            $mail->setFrom('wnsgud030405@gmail.com', 'JUNHYEONG');
            $mail->addAddress($email);

            // 이메일 내용 설정
            $mail->isHTML(true);
            $mail->Subject = 'Verification Code';
            $mail->Body = "Your verification code is: $verification_code";

            $mail->send();
            echo "Verification code sent to your email.";
        } catch (Exception $e) {
            echo "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        echo "User email not found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
    <h2>Change Password</h2>
    <form method="POST" action="change_password.php">
        <label for="current_password">Current Password:</label>
        <input type="password" id="current_password" name="current_password" required><br>
        
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required><br>
        
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        
        <label for="verification_code">Verification Code:</label>
        <input type="text" id="verification_code" name="verification_code" required><br>
        
        <button type="submit">Change Password</button>
    </form>
    <form method="GET" action="change_password.php">
        <input type="hidden" name="send_verification_code" value="1">
        <button type="submit">Send Verification Code</button>
    </form>
</body>
</html>
