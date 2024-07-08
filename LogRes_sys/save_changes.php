<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $notifications = $_POST['notifications'];

    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "user";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $update_user_query = "UPDATE user_registration SET Username = ?, Name = ?, Email = ?, Bio = ?, Birthday = ?, Phone = ? WHERE UserID = ?";
    $stmt = $conn->prepare($update_user_query);
    $stmt->bind_param("ssssssi", $username, $name, $email, $bio, $birthday, $phone, $user_id);
    $stmt->execute();

    $update_notifications_query = "UPDATE notifications SET enabled = ? WHERE user_id = ?";
    $stmt = $conn->prepare($update_notifications_query);
    $stmt->bind_param("ii", $notifications, $user_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    echo json_encode(["success" => true]);
}
?>
