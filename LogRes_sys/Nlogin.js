function redirectToResetPage(event) {
    event.preventDefault();
    const email = document.querySelector('#passwordRecoveryForm input[type="email"]').value;    
    window.location.href = `reset.html?email=${encodeURIComponent(email)}`;
}

function showSuccessMessage(type) {
    const successMessage = document.getElementById('successMessage');
    console.log("Success message function called with type:", type); // 디버깅용 로그 추가
    if (type === 'login') {
        successMessage.textContent = 'Successfully logged in!';
        setTimeout(() => {
            window.location.href = '../A-HomePage/HomePage.html'; 
        }, 2000); 
    } else if (type === 'register') {
        successMessage.textContent = 'You have registered!';
        setTimeout(() => {
            window.location.href = 'Nlogin.html'; 
        }, 2000); 
    } else if (type === 'password-reset') {
        successMessage.textContent = 'Password reset successful!';
        setTimeout(() => {
            window.location.href = 'Nlogin.html'; 
        }, 2000); 
    }
    successMessage.style.display = 'block';
}

// This function can be used to display success messages
function handleServerResponse(response) {
    console.log("Server response:", response); // 디버깅용 로그 추가
    if (response.status === 'success') {
        showSuccessMessage(response.type);
    } else {
        showErrorMessage(response.message);
    }
}

// 폼 제출을 가로채고 비동기로 서버와 통신하여 결과를 처리하는 함수
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // 기본 제출 방지

    const formData = new FormData(this); // 폼 데이터를 가져옴

    fetch('process_login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // 서버로부터 받은 결과를 처리
        console.log("Fetch response data:", data); // 디버깅용 로그 추가
        if (data.success) {
            handleServerResponse({ status: 'success', type: 'login' });
        } else {
            showErrorMessage(data.message); // 오류 메시지 표시
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred. Please try again later.");
    });
});
