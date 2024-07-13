<?php
session_start();

$response = array(
    "isLoggedIn" => isset($_SESSION['user_id']) // 사용자 세션에 user_id가 설정되어 있으면 로그인 상태로 간주
);

header('Content-Type: application/json');
echo json_encode($response);
?>
