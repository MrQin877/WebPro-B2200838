<?php
// 데이터베이스 연결 설정
$servername = "localhost"; // MySQL 서버 주소
$username = "root"; // 데이터베이스 사용자 이름
$password = ""; // 데이터베이스 사용자 비밀번호
$dbname = "user"; // 데이터베이스 이름

try {
    // PDO 객체 생성 및 데이터베이스 연결
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // 에러 모드 설정
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POST 데이터 받아오기
    $review = $_POST['review']; // 리뷰 내용
    $star = $_POST['star']; // 별점
    $program = $_POST['program']; // 프로그램 이름

    // SQL 쿼리 준비
    $sql = "INSERT INTO user_review (review, star, program) VALUES (:review, :star, :program)";
    $stmt = $conn->prepare($sql);

    // 바인딩 처리
    $stmt->bindParam(':review', $review, PDO::PARAM_STR);
    $stmt->bindParam(':star', $star, PDO::PARAM_INT);
    $stmt->bindParam(':program', $program, PDO::PARAM_STR);

    // 쿼리 실행
    $stmt->execute();

    // 성공적으로 리뷰가 저장되었음을 클라이언트에게 알림 (HTTP 상태 코드 200)
    http_response_code(200);
    echo "Review submitted successfully.";
} catch (PDOException $e) {
    // 데이터베이스 오류가 발생했을 경우 클라이언트에게 알림 (HTTP 상태 코드 500)
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}

// 데이터베이스 연결 해제
$conn = null;
?>
