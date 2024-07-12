function redirectToResetPage(event) {
    event.preventDefault();
    const email = document.querySelector('#passwordRecoveryForm input[type="email"]').value;    
    window.location.href = `reset.html?email=${encodeURIComponent(email)}`;
}

function showSuccessMessage(type) {
    const successMessage = document.getElementById('successMessage');
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
    if (response.status === 'success') {
        showSuccessMessage(response.type);
    } else {
        showErrorMessage(response.type);
    }
}

