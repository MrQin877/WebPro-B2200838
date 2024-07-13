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
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $resetPassword = $_POST['resetPassword'];

    if (empty($new_password) || empty($confirm_password) || empty($resetPassword)) {
        echo "모든 필드를 입력해주세요.";
    } elseif ($new_password !== $confirm_password) {
        echo "새로운 비밀번호가 일치하지 않습니다.";
    } else {
        // Verify reset password from database
        $sql = "SELECT * FROM password_reset WHERE reset_password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $resetPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];

            // Update password in user_registration table
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE user_registration SET password = ? WHERE email = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $hashed_password, $email);

            if ($update_stmt->execute()) {
                // Password updated successfully, remove reset password from password_reset table
                $delete_sql = "DELETE FROM password_reset WHERE reset_password = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("s", $resetPassword);
                $delete_stmt->execute();

                echo "비밀번호가 성공적으로 변경되었습니다.";
            } else {
                echo "비밀번호 변경 중 오류가 발생하였습니다.";
            }
        } else {
            echo "유효하지 않은 암호입니다.";
        }
    }
}

$conn->close();
?>
