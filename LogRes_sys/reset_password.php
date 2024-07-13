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
    $reset_token = $_POST['reset_token'];

    if (empty($new_password) || empty($confirm_password) || empty($reset_token)) {
        echo "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        echo "New passwords do not match.";
    } else {
        // Verify reset token from database
        $sql = "SELECT * FROM password_reset WHERE reset_token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $resetToken);
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
                // Password updated successfully, remove reset token from password_reset table
                $delete_sql = "DELETE FROM password_reset WHERE reset_token = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("s", $reset_token);
                $delete_stmt->execute();

                echo "Password updated successfully.";
            } else {
                echo "Error updating password: " . $conn->error;
            }
        } else {
            echo "Invalid reset token.";
        }
    }
}

$conn->close();
?>
