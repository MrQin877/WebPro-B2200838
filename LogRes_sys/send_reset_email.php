<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php'; // Adjust the path if necessary

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    if (empty($email)) {
        echo "Email is required.";
    } else {
        // 사용자 확인
        $sql = "SELECT id FROM user_registration WHERE email = '$email'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['id'];

            // 리셋 토큰 생성 및 데이터베이스 저장
            $reset_token = bin2hex(random_bytes(16));
            $reset_token_expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

            $sql = "UPDATE user_registration SET reset_token = '$reset_token', reset_token_expiry = '$reset_token_expiry' WHERE id = '$user_id'";
            
            if ($conn->query($sql) === TRUE) {
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
                    $mail->setFrom('wnsgud030405@gmail.com', 'Jun');
                    $mail->addAddress($email);

                    // 이메일 내용 설정
                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset Request';
                    $mail->Body = "To reset your password, click the following link: <a href='http://yourwebsite.com/reset_password.php?token=$reset_token'>Reset Password</a>";

                    $mail->send();
                    echo "Password reset email sent.";
                } catch (Exception $e) {
                    echo "Error sending email: {$mail->ErrorInfo}";
                }
            } else {
                echo "Error updating reset token: " . $conn->error;
            }
        } else {
            echo "No user found with that email address.";
        }
    }
}

$conn->close();
?>
