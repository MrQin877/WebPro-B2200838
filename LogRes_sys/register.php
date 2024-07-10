<?php
// process_registration.php

// PHPMailer 클래스 사용
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer 라이브러리 포함
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// 데이터베이스 연결 정보
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 오류 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// POST 요청 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Birth = $_POST['Birth'];
    $Gender = $_POST['Gender'];

    // 필수 필드 확인
    if (empty($Username) || empty($Email) || empty($Password) || empty($PhoneNumber) || empty($Birth) || empty($Gender)) {
        echo "First Name, Email, and Password are required fields.";
    } else {
        // 이메일 중복 확인을 위한 SQL 문 준비
        $stmt = $conn->prepare("SELECT UserID, Email FROM user_registration WHERE Email = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // 이메일이 이미 존재하는 경우
            echo "<script>alert('The Email is already registered.'); window.location.href = 'register.html';</script>";
        } else {
            // 비밀번호 해싱
            $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

            // 사용자 정보를 데이터베이스에 삽입하기 위한 SQL 문 준비
            $stmt = $conn->prepare("INSERT INTO user_registration (Username, Email, Password, PhoneNumber, Birth, Gender) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $Username, $Email, $hashedPassword, $PhoneNumber, $Birth, $Gender);

            if ($stmt->execute()) {
                // 회원가입 축하 이메일 발송
                $mail = new PHPMailer(true);
                try {
                    // 서버 설정
                    $mail->isSMTP();
                    $mail->Host = 'smtp.example.com'; // SMTP 서버 설정
                    $mail->SMTPAuth = true;
                    $mail->Username = 'your-email@example.com'; // SMTP 사용자명
                    $mail->Password = 'your-email-password'; // SMTP 비밀번호
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // 수신자 설정
                    $mail->setFrom('your-email@example.com', 'Your Name');
                    $mail->addAddress($Email, $Username);

                    // 이메일 내용 설정
                    $mail->isHTML(true);
                    $mail->Subject = 'Registration Successful';
                    $mail->Body    = '<p>Dear ' . $Username . ',</p><p>Congratulations! Your registration was successful.</p><p>Best regards,<br>Your Company</p>';

                    $mail->send();
                    echo "<script>alert('Registration successful. A confirmation email has been sent.'); window.location.href = 'Nlogin.html';</script>";
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>
