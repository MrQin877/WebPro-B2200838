<?php
session_start();
header('Content-Type: application/json');

$response = [];

if (isset($_SESSION['user_id'])) {
    $response['loggedIn'] = true;
    $response['user_id'] = $_SESSION['user_id'];
    $response['isAdmin'] = ($_SESSION['user_id'] == 0); // isAdmin 조건 수정
    $response['isLoggedIn'] = true; // 로그인 상태이므로 isLoggedIn을 true로 설정
} else {
    $response['loggedIn'] = false;
    $response['isAdmin'] = false;
    $response['isLoggedIn'] = false; // 로그인 상태가 아니므로 isLoggedIn을 false로 설정
}
// password:smartstudy1507@sport gmail: admin1507@smartstudysport.com
echo json_encode($response);
?>
