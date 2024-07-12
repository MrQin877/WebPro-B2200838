<?php
// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root"; // 데이터베이스 사용자 이름
$password = ""; // 데이터베이스 비밀번호
$dbname = "user"; // 데이터베이스 이름

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

// 세션 시작 (로그인 세션 관리를 위해 필요할 수 있음)
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    $reviewText = $_POST['review'];
    $star = $_POST['star'];
    $program = $_POST['program'];

    // 입력 값 유효성 검사
    if (empty($reviewText) || empty($star) || empty($program)) {
        die("Please provide review text, star rating, and program.");
    }

    // SQL 쿼리 생성
    $sql = "INSERT INTO user_review (review, star, UserID, program) VALUES (?,?,?,?)";

    // SQL 문 준비
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: ". $conn->error);
    }

    // 매개변수 바인딩 및 실행
    $stmt->bind_param("siss", $reviewText, $star, $_SESSION['UserID'], $program);
    if ($stmt->execute() === true) {
        echo "Review saved successfully."; // 성공 메시지 반환
    } else {
        echo "Error: ". $stmt->error; // 오류 메시지 반환
    }

    // 문 닫기
    $stmt->close();
}

// 데이터베이스 연결 닫기
$conn->close();
?>