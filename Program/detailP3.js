document.addEventListener('DOMContentLoaded', () => {
    const programs = [
        { title: 'Malay Language', description: 'Learn Malay language basics.', icon: '../images/icon3.jpg', page: 'Malpage.html' },
        { title: 'English Language', description: 'Master English language skills.', icon: '../images/icon4.jpg', page: 'Engpage.html' },
        { title: 'Mathematics', description: 'Explore various math concepts.', icon: '../images/icon2.jpg', page: 'Mathpage.html' },
        { title: 'History', description: 'Study historical events and figures.', icon: '../images/icon5.jpg', page: 'Hispage.html' },
        { title: 'Science', description: 'Learn about scientific principles.', icon: '../images/icon1.jpg', page: 'Sicpage.html' },
        { title: 'All Subjects', description: 'Learn about our every programs.', icon: '../images/icon6.jpg', page: 'Allpage.html' }
    ];

    const programList = document.getElementById('programList');
    const searchInput = document.getElementById('searchInput');
    const writeReviewBtn = document.getElementById('writeReviewBtn');
    const isLoggedIn = true; // 로그인 상태 확인 로직으로 대체 필요

    let currentProgram = null; // 현재 선택된 프로그램을 저장할 변수

    function toggleWriteReviewButton() {
        if (isLoggedIn) {
            writeReviewBtn.style.display = 'block';
        } else {
            writeReviewBtn.style.display = 'none';
        }
    }

    function renderPrograms(programs) {
        programList.innerHTML = '';
        programs.forEach(program => {
            const programElement = document.createElement('div');
            programElement.classList.add('program');
            programElement.onclick = () => {
                currentProgram = program.title; // 클릭한 프로그램의 이름을 저장
                showProgramDetails(program.page);
            };
            programElement.innerHTML = `
                <div class="program-content">
                    <img src="${program.icon}" alt="${program.title} Icon">
                    <div class="program-info">
                        <div class="program-title">${program.title}</div>
                        <div class="program-description">${program.description}</div>
                    </div>
                </div>
            `;
            programList.appendChild(programElement);
        });
        toggleWriteReviewButton();
    }

    function showProgramDetails(page) {
        window.location.href = page;
    }

    function filterPrograms() {
        const searchText = searchInput.value.toLowerCase();
        const filteredPrograms = programs.filter(program =>
            program.title.toLowerCase().includes(searchText)
        );
        renderPrograms(filteredPrograms);
    }

    function toggleCommentInput(type) {
        const commentInput = document.getElementById("commentInput");
        const commentText = document.getElementById("commentText");
        const subjectSelector = document.getElementById("subjectSelector");

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
        const commentText = document.getElementById("commentText").value;
        const rating = getSelectedRating();

        if (commentText.length < 20) {
            displayErrorMessage("Please enter at least 20 characters for your review.");
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "review.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        const formData = "review=" + encodeURIComponent(commentText) + "&star=" + rating + "&program=" + encodeURIComponent(currentProgram);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    displaySubmittedReview(commentText, rating);
                    clearFormInputs();
                } else {
                    displayErrorMessage("Failed to submit review. Please try again later.");
                }
            }
        };
        xhr.send(formData);
    }

    function getSelectedRating() {
        const stars = document.getElementsByName("rating");
        for (let i = 0; i < stars.length; i++) {
            if (stars[i].checked) {
                return stars[i].value;
            }
        }
        return null;
    }

    function displaySubmittedReview(comment, rating) {
        const reviewElement = document.createElement("div");
        reviewElement.classList.add("review-item");
        reviewElement.innerHTML = `
            <div class="review-header">
                <span class="review-rating">${rating} ★</span>
            </div>
            <p class="review-comment">${comment}</p>
        `;

        const reviewsSection = document.getElementById("reviews");
        reviewsSection.insertBefore(reviewElement, reviewsSection.firstChild);

        const reviewItems = reviewsSection.getElementsByClassName("review-item");
        if (reviewItems.length > 15) {
            reviewsSection.removeChild(reviewsSection.lastChild);
        }
    }

    function clearFormInputs() {
        document.getElementById("commentText").value = "";
        document.getElementById("commentInput").style.display = "none";
        document.getElementById("subjectSelector").style.display = "none";
        document.getElementById("writeReviewBtn").textContent = "Write a Review or feedback";
    }

    function displayErrorMessage(message) {
        const errorMessageElement = document.getElementById("error-message");
        errorMessageElement.textContent = message;
    }

    searchInput.addEventListener('input', filterPrograms);
    renderPrograms(programs);
});
