function redirectToResetPage(event) {
    event.preventDefault();
    
    const email = document.querySelector('#passwordRecoveryForm input[type="email"]').value;
    

    
    window.location.href = `reset.html?email=${encodeURIComponent(email)}`;
}

function showSuccessMessage(event, type) {
    event.preventDefault();
    const successMessage = document.getElementById('successMessage');
    if (type === 'login') {
        successMessage.textContent = 'Successfully login!';
        setTimeout(() => {
            window.location.href = 'Nlogin.html'; 
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
function redirectToHomePage() {
    window.location.href = 'HomePage.html';
}
