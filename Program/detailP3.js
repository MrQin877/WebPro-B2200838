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

    // 프로그램 목록을 렌더링하는 함수
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
    }

    // 프로그램의 상세 페이지로 이동하는 함수
    function showProgramDetails(page) {
        window.location.href = page;
    }

    // 로그인 상태 확인 함수
    function checkLoginStatus() {
        // 여기에 실제 로그인 상태를 확인하는 로직을 추가하세요.
        // 예시로 항상 로그인이 되어 있다고 가정합니다.
        return true; // 로그인 되어 있는 상태
    }

    // 리뷰 작성 버튼 클릭 시 실행되는 함수
    function toggleCommentInput(type) {
        var commentInput = document.getElementById("commentInput");
        var commentText = document.getElementById("commentText");
        var subjectSelector = document.getElementById("subjectSelector");

        // 로그인 상태 확인
        var loggedIn = checkLoginStatus();

        if (!loggedIn) {
            alert("Please log in to write a review.");
            return;
        }

        if (commentInput.style.display === "none" || commentInput.style.display === "") {
            commentInput.style.display = "block";
            subjectSelector.style.display = "block";
            commentText.placeholder = "Write your " + type + "... (255 Characters limit)";
        } else {
            commentInput.style.display = "none";
            subjectSelector.style.display = "none";
            document.getElementById("writeReviewBtn").textContent = "Write a Review or feedback";
        }
    }

    // 검색 입력 필드에 입력 이벤트 리스너 추가
    searchInput.addEventListener('input', filterPrograms);

    // 초기 프로그램 목록을 렌더링
    renderPrograms(programs);
});
