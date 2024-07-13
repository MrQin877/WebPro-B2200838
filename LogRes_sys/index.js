// 사용자가 로그인 상태인지 여부를 확인하는 함수
function isLoggedIn() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "check_session.php", false); // 비동기 방식으로 서버의 로그인 체크 스크립트를 호출합니다.
    xhr.send();

    if (xhr.status === 200) {
        // 서버에서 로그인 상태를 확인하는 스크립트(check_session.php)에서 true 또는 false를 반환하도록 설정합니다.
        var response = JSON.parse(xhr.responseText);
        return response.loggedIn === true; // 'true' 또는 'false' 값을 반환하도록 서버 스크립트를 구성합니다.
    } else {
        // 서버와의 통신에서 오류가 발생한 경우 로그인 상태를 확인할 수 없음
        return false;
    }
}

// 페이지 로드 시 실행되는 함수
document.addEventListener("DOMContentLoaded", function() {
    var writeReviewBtn = document.getElementById("writeReviewBtn");

    // 페이지 로드 시 사용자가 로그인한 상태라면 버튼을 보이게 합니다.
    if (isLoggedIn()) {
        writeReviewBtn.style.display = "block";
    } else {
        writeReviewBtn.style.display = "none";
    }
});
