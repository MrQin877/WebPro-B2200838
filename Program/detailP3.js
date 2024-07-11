// detailP3.js

// 리뷰 제출 함수
function submitComment() {
    var commentText = document.getElementById("commentText").value;
    var rating = getSelectedRating(); // 선택된 별점 가져오기

    // 데이터 유효성 검사
    if (rating === null) {
        alert("Please select a rating.");
        return;
    }
    if (commentText.trim() === "") {
        alert("Please enter a comment.");
        return;
    }

    // AJAX를 사용하여 서버로 데이터 전송
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "review.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log(xhr.responseText); // 서버에서 반환된 메시지를 콘솔에 출력
                alert("Your review has been submitted."); // 성공 메시지 표시
                document.getElementById("commentText").value = ""; // 입력 필드 초기화
                clearRating(); // 별점 초기화
                toggleCommentInput('review'); // 리뷰 입력 창 숨기기
                loadReviews(); // 리뷰 목록 다시 로드
            } else {
                console.error(xhr.statusText); // 오류 메시지 출력
                alert("Error submitting review. Please try again."); // 오류 메시지 표시
            }
        }
    };
    var params = "review=" + encodeURIComponent(commentText) + "&star=" + encodeURIComponent(rating);
    xhr.send(params);
}

// 선택된 별점 가져오기
function getSelectedRating() {
    var stars = document.getElementsByName("rating");
    for (var i = 0; i < stars.length; i++) {
        if (stars[i].checked) {
            return stars[i].value;
        }
    }
    return null; // 별점이 선택되지 않은 경우
}

// 별점 초기화
function clearRating() {
    var stars = document.getElementsByName("rating");
    for (var i = 0; i < stars.length; i++) {
        stars[i].checked = false;
    }
}

// 페이지 로드 시 실행할 초기화 작업
document.addEventListener('DOMContentLoaded', function() {
    // 리뷰 로드 함수 호출 등 추가 초기화 작업 수행
});
