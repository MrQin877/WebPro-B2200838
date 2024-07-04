<?php
$servername = "localhost"; // 데이터베이스 서버 이름
$username = "root"; // 데이터베이스 사용자 이름
$password = ""; // 데이터베이스 비밀번호
$dbname = "user"; // 데이터베이스 이름

// 서버 요청이 POST 방식인지 확인
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST 요청에 'action' 필드가 있는지 확인
    if (isset($_POST['action'])) {
        // 'action' 필드 값에 따라 다른 함수를 호출
        switch ($_POST['action']) {
            case 'redirectToResetPage':
                redirectToResetPage(); // 비밀번호 재설정 페이지로 리디렉션
                break;
            case 'showSuccessMessage':
                showSuccessMessage(); // 성공 메시지를 표시하고 페이지 리디렉션
                break;
            case 'redirectToHomePage':
                redirectToHomePage(); // 홈페이지로 리디렉션
                break;
        }
    }
}

// 비밀번호 재설정 페이지로 리디렉션하는 함수
function redirectToResetPage() {
    // POST 요청에 'email' 필드가 있는지 확인
    if (isset($_POST['email'])) {
        $email = urlencode($_POST['email']); // 이메일 값을 URL 인코딩
        header("Location: reset.html?email=$email"); // reset.html 페이지로 리디렉션
        exit(); // 스크립트 실행 종료
    } else {
        echo "Email is required."; // 이메일 필드가 없는 경우 에러 메시지 출력
    }
}

// 성공 메시지를 표시하고 페이지를 리디렉션하는 함수
function showSuccessMessage() {
    // POST 요청에 'type' 필드가 있는지 확인
    if (isset($_POST['type'])) {
        $type = $_POST['type']; // 'type' 필드 값 가져오기
        // 'type' 값에 따라 다른 메시지 설정
        switch ($type) {
            case 'login':
                $message = 'Successfully login!'; // 로그인 성공 메시지
                break;
            case 'register':
                $message = 'You have registered!'; // 회원가입 성공 메시지
                break;
            case 'password-reset':
                $message = 'Password reset successful!'; // 비밀번호 재설정 성공 메시지
                break;
            default:
                $message = 'Unknown action.'; // 알 수 없는 액션에 대한 메시지
        }
        // 성공 메시지를 포함한 HTML 출력
        echo "<div id='successMessage' style='display: block;'>$message</div>";
        // 2초 후에 Nlogin.html 페이지로 리디렉션
        header("refresh:2; url=Nlogin.html");
        exit(); // 스크립트 실행 종료
    } else {
        echo "Action type is required."; // 'type' 필드가 없는 경우 에러 메시지 출력
    }
}

// 홈페이지로 리디렉션하는 함수
function redirectToHomePage() {
    header("Location: ../HomePage.html"); // ../HomePage.html 페이지로 리디렉션
    exit(); // 스크립트 실행 종료
}
?>
