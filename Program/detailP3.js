document.addEventListener('DOMContentLoaded', () => {
    // 유저 로그인 상태 확인 (예제)
    const isLoggedIn = true; // 실제 로그인 체크로 대체

    // 로그인 상태에 따라 리뷰 섹션의 가시성을 토글하는 함수
    function toggleReviewSectionVisibility() {
        const writeReviewBtn = document.getElementById('writeReviewBtn');
        const commentInput = document.getElementById('commentInput');
        const subjectSelector = document.getElementById('subjectSelector');

        if (isLoggedIn) {
            writeReviewBtn.style.display = 'block';
            commentInput.style.display = 'none';
            subjectSelector.style.display = 'none';
        } else {
            writeReviewBtn.style.display = 'none';
            commentInput.style.display = 'none';
            subjectSelector.style.display = 'none';
        }
    }

    // 초기 호출을 통해 로그인 상태에 따른 가시성 토글
    toggleReviewSectionVisibility();

    // writeReviewBtn 클릭 이벤트 리스너
    writeReviewBtn.addEventListener('click', () => {
        if (isLoggedIn) {
            toggleCommentInput('review');
        } else {
            alert('리뷰를 작성하려면 로그인하세요.'); // 로그인 프롬프트 로직으로 대체
        }
    });

    // 댓글 입력란 가시성을 토글하는 함수
    function toggleCommentInput(type) {
        var commentInput = document.getElementById("commentInput");
        var commentText = document.getElementById("commentText");
        var subjectSelector = document.getElementById("subjectSelector");

        if (commentInput.style.display === "none" || commentInput.style.display === "") {
            commentInput.style.display = "block";
            subjectSelector.style.display = "block";
            commentText.placeholder = `${type}을(를) 작성하세요... (255자 제한)`;
        } else {
            commentInput.style.display = "none";
            subjectSelector.style.display = "none";
            document.getElementById("writeReviewBtn").textContent = "리뷰 또는 피드백 작성";
        }
    }

    // 리뷰 제출 함수 (이미 포함된 코드)
    function submitComment() {
        var commentText = document.getElementById("commentText").value;
        var rating = getSelectedRating(); // 선택된 평점을 가져오는 함수 구현 필요
        var subject = document.getElementById("subject").value; // 선택된 주제 가져오기
        var userEmail = document.getElementById("userEmail").value;

        // 입력값 유효성 검사 (이미 포함된 코드)
        if (commentText.length < 20) {
            displayErrorMessage("리뷰를 최소 20자 이상 입력하세요.");
            return;
        }

        if (userEmail === "") {
            displayErrorMessage("이메일을 입력하세요.");
            return;
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(userEmail)) {
            displayErrorMessage("유효한 이메일 주소를 입력하세요.");
            return;
        }

        // AJAX 요청 예제 (이미 포함된 코드)
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "review.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        var formData = `review=${encodeURIComponent(commentText)}&star=${rating}&program=${subject}&email=${userEmail}`;
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // 성공적인 제출
                    displaySubmittedReview(commentText, rating, subject, userEmail);
                    clearFormInputs();
                } else {
                    // 오류 처리
                    displayErrorMessage("리뷰 제출에 실패했습니다. 나중에 다시 시도하세요.");
                }
            }
        };
        xhr.send(formData);
    }

    // 선택된 평점을 가져오는 함수 (이미 포함된 코드)
    function getSelectedRating() {
        var stars = document.getElementsByName("rating");

        for (var i = 0; i < stars.length; i++) {
            if (stars[i].checked) {
                return stars[i].value;
            }
        }
        return null; // 선택된 평점이 없음
    }

    // 제출된 리뷰를 표시하는 함수 (이미 포함된 코드)
    function displaySubmittedReview(comment, rating, subject, userEmail) {
        var userEmailDisplay = userEmail.substr(0, 4) + '*'.repeat(userEmail.length - 4); // 처음 4자만 표시하고 나머지는 숨김

        // 새로운 리뷰 요소 생성
        var reviewElement = document.createElement("div");
        reviewElement.classList.add("review-item");
        reviewElement.innerHTML = `
            <div class="review-header">
                <span class="review-rating">${rating} ★</span>
                <span class="review-info">${subject} | ${userEmailDisplay}</span>
            </div>
            <p class="review-comment">${comment}</p>
        `;

        // 리뷰 섹션의 시작 부분에 새 리뷰 삽입
        var reviewsSection = document.getElementById("reviews");
        reviewsSection.insertBefore(reviewElement, reviewsSection.firstChild);

        // 표시되는 리뷰의 수를 15개로 제한 (이미 포함된 코드)
        var reviewItems = reviewsSection.getElementsByClassName("review-item");
        if (reviewItems.length > 15) {
            reviewsSection.removeChild(reviewsSection.lastChild);
        }
    }

    // 폼 입력값을 초기화하는 함수 (이미 포함된 코드)
    function clearFormInputs() {
        document.getElementById("commentText").value = "";
        document.getElementById("userEmail").value = "";
        document.getElementById("commentInput").style.display = "none";
        document.getElementById("subjectSelector").style.display = "none";
        document.getElementById("writeReviewBtn").textContent = "리뷰 또는 피드백 작성";
    }

    // 오류 메시지를 표시하는 함수 (이미 포함된 코드)
    function displayErrorMessage(message) {
        var errorMessageElement = document.getElementById("error-message");
        errorMessageElement.textContent = message;
    }
});
