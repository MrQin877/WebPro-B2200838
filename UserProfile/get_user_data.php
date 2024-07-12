<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$userData = [
    'username' => '',
    'email' => '',
    'birthday' => '',
    'phone' => '',
    'nickname' => '',
    'bio' => ''
];

$sql = "SELECT  COALESCE(ur.Username,'')As username,
                COALESCE(ur.Email, '') As email,
                COALESCE(ur.Birth, '') AS birthday,
                COALESCE(ur.PhoneNumber, '') As phone,
                COALESCE(uop.nickname, '') AS nickname, 
                COALESCE(uop.bio, '') AS bio
        FROM user_registration ur
        LEFT JOIN user_optional uop ON ur.UserID = uop.user_id
        WHERE ur.UserID = ?;";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $userData = array_merge($userData, $result->fetch_assoc());
}
$stmt->close();

header('Content-Type: application/json');
echo json_encode($userData);

$conn->close();
?>
