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
    } else if (type === 'login-fail') {
        successMessage.textContent = 'Login failed! Please try again.';
        setTimeout(() => {
            window.location.href = 'Nlogin.html';
        }, 2000);
    }
    successMessage.style.display = 'block';
}

function showErrorMessage(event, type) {
    event.preventDefault();
    const errorMessage = document.getElementById('errorMessage');
    if (type === 'login-fail') {
        errorMessage.textContent = 'Login failed! Please try again.';
        setTimeout(() => {
            window.location.href = 'Nlogin.html';
        }, 2000);
    }
    errorMessage.style.display = 'block';
}

function redirectToHomePage() {
    window.location.href = '../HomePage.html';
}

// Example usage for login form submission handling
document.getElementById('loginForm').addEventListener('submit', function(event) {
    // Simulating a login failure
    showErrorMessage(event, 'login-fail');
});
