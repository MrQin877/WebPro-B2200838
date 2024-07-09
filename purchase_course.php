<?php
// 세션 시작
session_start();

// 데이터베이스 연결 (데이터베이스 자격 증명으로 업데이트)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("connection fail: " . $conn->connect_error);
}

// 사용자가 로그인했는지 확인
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to see profile.";
    exit();
}

// 세션에서 사용자 ID 가져오기
$user_id = $_SESSION['user_id'];

// 사용자 개인 정보 가져오기
$user_query = "SELECT username, email, first_name, last_name, other_personal_info FROM users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user_info = $user_result->fetch_assoc();

// 사용자가 구매한 코스 가져오기
$courses_query = "SELECT course_name, purchase_date FROM purchased_courses WHERE user_id = ?";
$stmt = $conn->prepare($courses_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$courses_result = $stmt->get_result();
$purchased_courses = [];
while ($row = $courses_result->fetch_assoc()) {
    $purchased_courses[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
</head>
<body>
    <h1>User Profile</h1>
    <h2>Personal Info</h2>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user_info['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user_info['email']); ?></p>
    <p><strong>Other Info:</strong> <?php echo htmlspecialchars($user_info['other_personal_info']); ?></p>
    
    <h2>Purchared_Courses</h2>
    <?php if (count($purchased_courses) > 0): ?>
        <ul>
            <?php foreach ($purchased_courses as $course): ?>
                <li>
                    <strong>Course Name:</strong> <?php echo htmlspecialchars($course['course_name']); ?>
                    <br>
                    <strong>Purchased Date:</strong> <?php echo htmlspecialchars($course['purchase_date']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>There is no course you purchased.</p>
    <?php endif; ?>
</body>
</html>
