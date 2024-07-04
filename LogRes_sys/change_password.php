<?php
session_start(); // 세션 시작

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
    
    // 입력값 확인
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        echo "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        echo "New passwords do not match.";
    } else {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT password FROM users WHERE id = '$user_id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($current_password, $row['password'])) {
                $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password = '$new_password_hashed' WHERE id = '$user_id'";
                
                if ($conn->query($sql) === TRUE) {
                    echo "Password updated successfully.";
                } else {
                    echo "Error updating password: " . $conn->error;
                }
            } else {
                echo "Current password is incorrect.";
            }
        } else {
            echo "User not found.";
        }
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
        
        <button type="submit">Change Password</button>
    </form>
</body>
</html>
