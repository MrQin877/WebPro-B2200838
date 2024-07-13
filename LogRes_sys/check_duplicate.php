<?php
// 데이터베이스 연결 정보
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// 클라이언트로부터의 JSON 데이터 파싱
$input = json_decode(file_get_contents('php://input'), true);

if ($input && isset($input['Email'])) {
    $email = $input['Email'];

    try {
        // 데이터베이스 연결
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 이메일 중복 확인 쿼리
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM user_registration WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // 결과 반환
        if ($result['count'] > 0) {
            echo json_encode(array('error' => 'Email already exists.'));
        } else {
            echo json_encode(array('success' => 'Email available.'));
        }
    } catch (PDOException $e) {
        echo json_encode(array('error' => 'Database error: ' . $e->getMessage()));
    }

    // 데이터베이스 연결 종료
    $conn = null;
} else {
    echo json_encode(array('error' => 'Invalid input.'));
}
?>
