<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

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
    $reset_token = $_POST['reset_token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($reset_token) || empty($new_password) || empty($confirm_password)) {
        echo "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        // 토큰과 만료 시간 확인
        $sql = "SELECT id, reset_token_expiry FROM user_registration WHERE reset_token = '$reset_token'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['id'];
            $reset_token_expiry = $row['reset_token_expiry'];

            if (strtotime($reset_token_expiry) > time()) {
                // 새로운 비밀번호 해시화
                $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                
                // 비밀번호 업데이트
                $sql = "UPDATE user_registration SET password = '$new_password_hashed', reset_token = NULL, reset_token_expiry = NULL WHERE id = '$user_id'";

                if ($conn->query($sql) === TRUE) {
                    echo "Password updated successfully.";
                } else {
                    echo "Error updating password: " . $conn->error;
                }
            } else {
                echo "Reset token has expired.";
            }
        } else {
            echo "Invalid reset token.";
        }
    }
}

$conn->close();
?>
