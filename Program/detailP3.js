document.addEventListener('DOMContentLoaded', () => {
    // 프로그램 목록 배열
    const programs = [
        { title: 'Malay Language', description: 'Learn Malay language basics.', icon: '../images/icon3.jpg', page: 'Malpage.html' },
        { title: 'English Language', description: 'Master English language skills.', icon: '../images/icon4.jpg', page: 'Engpage.html' },
        { title: 'Mathematics', description: 'Explore various math concepts.', icon: '../images/icon2.jpg', page: 'Mathpage.html' },
        { title: 'History', description: 'Study historical events and figures.', icon: '../images/icon5.jpg', page: 'Hispage.html' },
        { title: 'Science', description: 'Learn about scientific principles.', icon: '../images/icon1.jpg', page: 'Sicpage.html' },
        { title: 'All Subjects', description: 'Learn about our every programs.', icon: '../images/icon6.jpg', page: 'Allpage.html' }
    ];

    // HTML 요소 참조
    const programList = document.getElementById('programList');
    const searchInput = document.getElementById('searchInput');
    const writeReviewBtn = document.getElementById('writeReviewBtn'); // 추가된 부분: Write a Review 버튼

    // Function to check if user is logged in (예시)
    const isLoggedIn = true; // 실제 로그인 상태 확인 로직으로 대체 필요

    // Function to toggle visibility of Write a Review 버튼 based on login status
    function toggleWriteReviewButton() {
        if (isLoggedIn) {
            writeReviewBtn.style.display = 'block';
        } else {
            writeReviewBtn.style.display = 'none';
        }
    }

    // 초기 프로그램 목록을 렌더링하는 함수
    function renderPrograms(programs) {
        // 프로그램 리스트를 비움
        programList.innerHTML = '';

        // 프로그램 배열을 순회하며 각 프로그램을 렌더링
        programs.forEach(program => {
            // 프로그램 요소를 생성
            const programElement = document.createElement('div');
            programElement.classList.add('program');

            // 클릭 시 해당 프로그램의 상세 페이지로 이동하도록 설정
            programElement.onclick = () => {
                showProgramDetails(program.page);
            };

            // 프로그램 요소의 내부 HTML 설정
            programElement.innerHTML = `
                <div class="program-content">
                    <img src="${program.icon}" alt="${program.title} Icon">
                    <div class="program-info">
                        <div class="program-title">${program.title}</div>
                        <div class="program-description">${program.description}</div>
                    </div>
                </div>
            `;

            // 프로그램 리스트에 프로그램 요소를 추가
            programList.appendChild(programElement);
        });

        // Write a Review 버튼 표시 여부 업데이트
        toggleWriteReviewButton();
    }

    // 프로그램의 상세 페이지로 이동하는 함수
    function showProgramDetails(page) {
        window.location.href = page;
    }

    // 프로그램 목록을 필터링하는 함수
    function filterPrograms() {
        const searchTerm = searchInput.value.toLowerCase();
        const filteredPrograms = programs.filter(program =>
            program.title.toLowerCase().includes(searchTerm) ||
            program.description.toLowerCase().includes(searchTerm)
        );
        renderPrograms(filteredPrograms);
    }

    // 검색 입력 필드에 입력 이벤트 리스너 추가
    searchInput.addEventListener('input', filterPrograms);

    // 초기 프로그램 목록을 렌더링
    renderPrograms(programs);
});

function toggleCommentInput(type) {
    var commentInput = document.getElementById("commentInput");
    var commentText = document.getElementById("commentText");
    var subjectSelector = document.getElementById("subjectSelector");

    if (commentInput.style.display === "none" || commentInput.style.display === "") {
        commentInput.style.display = "block";
        subjectSelector.style.display = "block";
        commentText.placeholder = "Write your " + type + "...(255 Characters limit)";
    } else {
        commentInput.style.display = "none";
        subjectSelector.style.display = "none";
        document.getElementById("writeReviewBtn").textContent = "Write a Review or feedback";
    }
}

function submitComment() {
    var commentText = document.getElementById("commentText").value;
    var rating = getSelectedRating();
    var subject = document.getElementById("subject").value;
    var userEmail = document.getElementById("userEmail").value;

    if (commentText.length < 20) {
        displayErrorMessage("Please enter at least 20 characters for your review.");
        return;
    }

    if (userEmail === "") {
        displayErrorMessage("Please enter your email.");
        return;
    }

    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(userEmail)) {
        displayErrorMessage("Please enter a valid email address.");
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "review.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var formData = "review=" + encodeURIComponent(commentText) + "&star=" + rating + "&program=" + subject + "&email=" + userEmail;
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                displaySubmittedReview(commentText, rating, subject, userEmail);
                clearFormInputs();
            } else {
                displayErrorMessage("Failed to submit review. Please try again later.");
            }
        }
    };
    xhr.send(formData);
}

function getSelectedRating() {
    var ratingElements = document.getElementsByName("rating");
    for (var i = 0; i < ratingElements.length; i++) {
        if (ratingElements[i].checked) {
            return ratingElements[i].value;
        }
    }
    return 0;
}

function displaySubmittedReview(commentText, rating, subject, userEmail) {
    var reviewsContainer = document.getElementById("reviews");

    var reviewElement = document.createElement("div");
    reviewElement.className = "review-item";
    reviewElement.innerHTML = `
        <div class="review-header">
            <div class="review-rating">${rating}★</div>
            <div class="review-info">${subject} - ${userEmail}</div>
        </div>
        <div class="review-comment">${commentText}</div>
    `;

    reviewsContainer.insertBefore(reviewElement, reviewsContainer.firstChild);
}

function clearFormInputs() {
    document.getElementById("commentText").value = "";
    document.getElementById("userEmail").value = "";
    var ratingElements = document.getElementsByName("rating");
    for (var i = 0; i < ratingElements.length; i++) {
        ratingElements[i].checked = false;
    }
}

function displayErrorMessage(message) {
    var errorMessageElement = document.getElementById("error-message");
    errorMessageElement.textContent = message;
}
