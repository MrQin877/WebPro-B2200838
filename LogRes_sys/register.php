<?php
// register.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 실패 시 오류 메시지 출력 후 종료
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

// POST 메서드로 요청이 온 경우에만 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword']; // 비밀번호 확인 필드 추가
    $PhoneNumber = $_POST['PhoneNumber'];
    $Birth = $_POST['Birth'];
    $Gender = $_POST['Gender'];

    // 비밀번호와 비밀번호 확인 필드 비교
    if ($Password !== $ConfirmPassword) {
        echo "<script>alert('비밀번호가 일치하지 않습니다. 다시 입력해주세요.'); window.location.href = 'register.html';</script>";
        exit; // 처리 중지
    }

    // 필수 입력 필드 확인
    if (empty($Username) || empty($Email) || empty($Password) || empty($PhoneNumber) || empty($Birth) || empty($Gender)) {
        echo "모든 필드를 입력해주세요.";
    } else {
        // 이메일 중복 확인을 위한 SQL 문 준비
        $stmt = $conn->prepare("SELECT UserID FROM user_registration WHERE Email = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $stmt->store_result();

        // 이미 등록된 이메일인 경우
        if ($stmt->num_rows > 0) {
            echo "<script>alert('이미 등록된 이메일입니다. 다른 이메일을 사용해주세요.'); window.location.href = 'register.html';</script>";
        } else {
            // 비밀번호 해싱
            $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

            // 회원 등록을 위한 SQL 문 준비
            $stmt = $conn->prepare("INSERT INTO user_registration (Username, Email, Password, PhoneNumber, Birth, Gender) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $Username, $Email, $hashedPassword, $PhoneNumber, $Birth, $Gender);

            // 실행 여부에 따라 메시지 출력
            if ($stmt->execute()) {
                echo "<script>alert('회원 가입이 완료되었습니다.'); window.location.href = 'Nlogin.html';</script>";
            } else {
                echo "오류: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}

// 데이터베이스 연결 종료
$conn->close();
?>
