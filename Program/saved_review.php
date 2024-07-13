<?php
session_start(); // 세션 시작

// 데이터베이스 연결 설정
$servername = "localhost"; // 또는 데이터베이스 서버 주소
$username = "root"; // 데이터베이스 사용자 이름
$password = ""; // 데이터베이스 비밀번호
$dbname = "user"; // 데이터베이스 이름

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 현재 로그인된 사용자의 이메일 가져오기
if (!isset($_SESSION['email'])) {
    echo "Error: No user logged in.";
    header("Location: login.php"); // 로그인 페이지로 리디렉션
    exit();
}

$loggedInUserEmail = $_SESSION['email'];

// POST 데이터에서 값 가져오기
$review = $_POST['review'];
$star = $_POST['star'];
$program = $_POST['program'];
$email = $_POST['email'];
$userID = $_POST['userID']; // 새로 추가된 UserID 필드

// 현재 로그인된 이메일과 입력된 이메일이 일치하는지 확인
$stmt = $conn->prepare("SELECT email FROM user_registration WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($userEmail);
$stmt->fetch();

if ($stmt->num_rows > 0 && $userEmail == $loggedInUserEmail) {
    // 일치하는 경우, 리뷰 데이터를 저장
    $stmt = $conn->prepare("INSERT INTO user_review (review, star, program, email, userID) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $review, $star, $program, $email, $userID);
    $stmt->execute();
    $stmt->close();

    echo "Review saved successfully!";
} else {
    echo "Error: Current logged-in email does not match the provided email.";
}

$conn->close(); // 데이터베이스 연결 종료
?>
