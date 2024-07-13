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

    // 이메일 세션 확인
    if (isset($_SESSION['recovery_email'])) {
        $email = $_SESSION['recovery_email'];

        // 입력값 확인
        if (empty($reset_token) || empty($new_password) || empty($confirm_password)) {
            echo "All fields are required.";
        } else {
            // 이메일과 암호숫자를 데이터베이스에서 확인
            $sql = "SELECT * FROM user_registration WHERE email = ? AND reset_token = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $reset_token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                // 이메일과 암호숫자가 일치하는 경우
                $row = $result->fetch_assoc();
                $user_id = $row['id'];

                // 비밀번호 일치 여부 확인
                if ($new_password !== $confirm_password) {
                    echo "New passwords do not match.";
                } else {
                    // 비밀번호 업데이트
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_sql = "UPDATE user_registration SET password = ?, reset_token = NULL WHERE id = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("si", $hashed_password, $user_id);

                    if ($update_stmt->execute()) {
                        echo "Password updated successfully.";
                        // 세션 변수 초기화
                        unset($_SESSION['recovery_email']);
                    } else {
                        echo "Error updating password: " . $update_stmt->error;
                    }
                }
            } else {
                echo "Invalid reset token.";
            }

            $stmt->close();
            $update_stmt->close();
        }
    } else {
        echo "Session error: No recovery email found.";
    }
}

$conn->close();
?>
