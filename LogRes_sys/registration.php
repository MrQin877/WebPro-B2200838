<?php
// process_registration.php

$servername = "localhost";
$username = "root";
$password = "";  // 데이터베이스 비밀번호로 변경하세요
$dbname = "user"; // 데이터베이스 이름으로 변경하세요

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 회원가입 테이블이 존재하지 않으면 생성
$sql = "CREATE TABLE IF NOT EXISTS user_registration (
    UserID INT(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(100) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Password VARCHAR(100) NOT NULL,
    PhoneNumber INT(100) NOT NULL,
    Birth DATE NOT NULL,
    Gender VARCHAR(10) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'user_registration' created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phoneNumber = $_POST['phoneNumber'];
    $birth = $_POST['birthdate'];
    $gender = $_POST['gender'];

    // 입력값 유효성 검사
    if (empty($username) || empty($email) || empty($password)) {
        echo "Username, Email, and Password are required fields.";
    } else {
        // 비밀번호를 저장하기 전에 해시화
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // 삽입문 준비
        $stmt = $conn->prepare("INSERT INTO user_registration (Username, Email, Password, PhoneNumber, Birth, Gender) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $username, $email, $hashedPassword, $phoneNumber, $birth, $gender);

        if ($stmt->execute()) {
            echo "Registration successful.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
$conn->close();
?>
