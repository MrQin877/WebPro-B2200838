<?php
session_start();
session_destroy(); // 모든 세션 데이터 제거
header('Location: index.php'); // 로그아웃 후 리디렉션
exit();
?>
