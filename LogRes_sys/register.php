<?php
// PHPMailer 클래스 사용
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer 클래스 파일 직접 포함
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 오류 시 오류 메시지 출력 후 종료
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 요청 메서드가 POST인 경우만 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword']; // Confirm Password 필드 추가
    $PhoneNumber = $_POST['PhoneNumber'];
    $Birth = $_POST['Birth'];
    $Gender = $_POST['Gender'];

    // 비밀번호와 확인 비밀번호가 일치하는지 확인
    if ($Password !== $ConfirmPassword) {
        echo "<script>alert('Passwords do not match. Please re-enter.'); window.location.href = 'register.html';</script>";
        exit; // 이후 실행 중지
    }

    // 필수 필드가 비어 있는지 확인
    if (empty($Username) || empty($Email) || empty($Password) || empty($PhoneNumber) || empty($Birth) || empty($Gender)) {
        echo "Please fill out all fields.";
    } else {
        // 이메일이 이미 존재하는지 확인하는 SQL 문 준비
        $stmt = $conn->prepare("SELECT UserID FROM user_registration WHERE Email = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $stmt->store_result();

        // 이메일이 이미 존재하는 경우
        if ($stmt->num_rows > 0) {
            echo "<script>alert('The Email is already registered. Please use a different email.'); window.location.href = 'register.html';</script>";
        } else {
            // 비밀번호 해싱
            $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

            // 삽입 문 준비
            $stmt = $conn->prepare("INSERT INTO user_registration (Username, Email, Password, PhoneNumber, Birth, Gender) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $Username, $Email, $hashedPassword, $PhoneNumber, $Birth, $Gender);

            // 삽입이 성공한 경우
            if ($stmt->execute()) {
                // PHPMailer 객체 생성 및 초기 설정
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
                    $mail->addAddress($Email, $Username); // 이미 코드에서 설정된 값 그대로 사용

                    // 이메일 내용 설정
                    $mail->isHTML(true);
                    $mail->Subject = 'Registration Successful';
                    $mail->Body = '<p>Dear ' . $Username . ',</p><p>Congratulations! You have successfully registered.</p><p>Best regards,<br>Your Company</p>';

                    // 이메일 전송
                    $mail->send();
                    echo "<script>alert('Registration successful! A congratulatory email has been sent to your registered email.'); window.location.href = 'Nlogin.html';</script>";
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

// 데이터베이스 연결 종료
$conn->close();
?>
