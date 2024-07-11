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

$user_id = $_SESSION['user_id'];
$optionalData = json_decode($_POST['optionalData'], true);
$nickname = $optionalData['nickname'];
$bio = $optionalData['bio'];

$sql = "SELECT user_id FROM user_optional WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update existing record
    $sql = "UPDATE user_optional SET nickname = ?, bio = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nickname, $bio, $user_id);
} else {
    // Insert new record
    $sql = "INSERT INTO user_optional (user_id, nickname, bio) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $nickname, $bio);
}

if ($stmt->execute()) {
    echo "<script>alert('Changes save sucessfully'); window.location.href = 'profile.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
