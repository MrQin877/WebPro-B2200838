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
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['currentPasswordInput'];
    $new_password = $_POST['newPasswordInput'];
    $confirm_password = $_POST['repeatNewPasswordInput'];
    
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        echo "<script>alert('All fields are required.')</script>";
    } else {
        $sql = "SELECT password FROM user_registration WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($stored_password);
            $stmt->fetch();
            
            if (password_verify($current_password, $stored_password)) {
                if ($new_password === $confirm_password) {
                    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_sql = "UPDATE user_registration SET password = ? WHERE UserID = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("si", $new_password_hashed, $user_id);
                    
                    if ($update_stmt->execute()) {
                        echo "<script>alert('Password changed successfully.'); window.location.href='profile.html';</script>";
                    } else {
                        echo "Error updating password: " . $conn->error;
                    }
                    $update_stmt->close();
                } else {
                    echo "<script>alert('New passwords do not match.'); window.location.href='profile.html';</script>";
                }
            } else {
                echo "<script>alert('Current password is incorrect.'); window.location.href='profile.html';</script>";
            }
        } else {
            echo "<script>alert('User not found.'); window.location.href='profile.html';</script>";
        }
        
        $stmt->close();
    }
}

$conn->close();
?>
