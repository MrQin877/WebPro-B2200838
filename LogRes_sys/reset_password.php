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
    $resetPassword = $_POST['resetPassword']; // 사용자가 제출한 6자리 숫자 코드

    // Validate password complexity
    $passwordRegex = '/^(?=.*[A-Z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,10}$/';
    if (!preg_match($passwordRegex, $new_password)) {
        echo "Password must be 6 to 10 characters long, include at least one capital letter and one special character (!, @, #, $, %, &).";
        exit();
    }

    if (empty($new_password) || empty($confirm_password) || empty($resetPassword)) {
        echo "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        echo "New passwords do not match. Please try again.";
    } else {
        // Verify reset token from database
        $sql = "SELECT * FROM user_registration WHERE resetPassword = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing query: " . $conn->error;
        } else {
            $stmt->bind_param("i", $resetPassword); // int 타입으로 바인딩
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $userID = $row['UserID']; // 사용자 ID 또는 다른 식별자

                // Update password in user_registration table
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE user_registration SET password = ? WHERE UserID = ?";
                $update_stmt = $conn->prepare($update_sql);

                if ($update_stmt === false) {
                    echo "Error preparing update statement: " . $conn->error;
                } else {
                    $update_stmt->bind_param("si", $hashed_password, $userID);

                    if ($update_stmt->execute()) {
                        // Password successfully updated message
                        $_SESSION['reset_success'] = true;
                        echo "Password successfully updated. Redirecting...";
                        exit();
                    } else {
                        echo "Error updating password: " . $conn->error;
                    }
                }
            } else {
                echo "Invalid reset password.";
            }
        }
    }
}

$conn->close();
?>
