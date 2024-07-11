<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer autoload 파일 불러오기
require 'vendor/autoload.php';

// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";
$charset = 'utf8mb4';

// PDO 설정
$dsn = "mysql:host=$servername;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // 데이터베이스에 연결
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// PHPMailer 인스턴스 생성
$mail = new PHPMailer(true);

try {
    // SMTP 설정
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com';  // SMTP 서버 주소
    $mail->SMTPAuth = true;
    $mail->Username = 'your_smtp_username';  // SMTP 계정 아이디
    $mail->Password = 'your_smtp_password';  // SMTP 계정 비밀번호
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS 보안 사용
    $mail->Port = 587;  // SMTP 포트

    // 발신자 정보 설정
    $mail->setFrom('sender@example.com', 'Sender Name');

    // user 테이블에서 이메일 가져오기
    $stmt = $pdo->query('SELECT email FROM user');
    $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($emails as $email) {
        // 이메일 수신자 설정
        $mail->addAddress($email);

        // 이메일 제목 및 본문 설정
        $mail->Subject = 'Your Custom Subject Here';
        $mail->Body    = 'This is a custom message body. You can change this content as needed.';

        // 이메일 보내기
        $mail->send();

        // 수신자 이메일 초기화
        $mail->clearAddresses();

        echo 'Email sent successfully to ' . $email . '<br>';
    }
} catch (Exception $e) {
    echo "Email sending failed. Error: {$mail->ErrorInfo}";
}
?>
