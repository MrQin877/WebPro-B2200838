<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer 클래스 파일 직접 포함
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendWelcomeEmail($email, $username) {
    $mail = new PHPMailer(true);
    try {
        // 서버 설정
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP 서버 주소
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com'; // 실제 사용할 Gmail 주소
        $mail->Password = 'your-email-password'; // Gmail 비밀번호
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // 수신자 설정
        $mail->setFrom('your-email@gmail.com', 'Your Name'); // 실제 사용할 Gmail 주소와 발신자 이름
        $mail->addAddress($email, $username);

        // 이메일 내용 설정
        $mail->isHTML(true);
        $mail->Subject = 'Registration Successful';
        $mail->Body = '<p>Dear ' . $username . ',</p><p>Congratulations! You have successfully registered.</p><p>Best regards,<br>Your Company</p>';

        // 이메일 전송
        $mail->send();
        echo "Email has been sent.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
