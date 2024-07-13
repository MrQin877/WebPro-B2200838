<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])) {
    $token = $_GET['token'];

    $sql = "SELECT id, reset_token_expiry FROM user_registration WHERE reset_token = '$token'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        $expiry = $row['reset_token_expiry'];

        if (new DateTime() > new DateTime($expiry)) {
            echo "Reset token has expired.";
        } else {
            $_SESSION['reset_user_id'] = $user_id;
            $_SESSION['reset_token'] = $token;
            header("Location: set_new_password.html");
            exit();
        }
    } else {
        echo "Invalid reset token.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['reset_user_id']) && isset($_SESSION['reset_token'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($new_password) || empty($confirm_password)) {
            echo "All fields are required.";
        } elseif ($new_password !== $confirm_password) {
            echo "Passwords do not match.";
        } else {
            $user_id = $_SESSION['reset_user_id'];
            $token = $_SESSION['reset_token'];

            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE user_registration SET password = '$new_password_hashed', reset_token = NULL, reset_token_expiry = NULL WHERE id = '$user_id' AND reset_token = '$token'";

            if ($conn->query($sql) === TRUE) {
                echo "Password reset successfully.";
                unset($_SESSION['reset_user_id']);
                unset($_SESSION['reset_token']);
            } else {
                echo "Error updating password: " . $conn->error;
            }
        }
    } else {
        echo "Invalid session.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password</title>
</head>
<body>
    <h2>Set New Password</h2>
    <form method="POST" action="reset_password.php">
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required><br>
        
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
