function redirectToResetPage(event) {
    event.preventDefault();
    // Get the email entered by the user
    const email = document.querySelector('#passwordRecoveryForm input[type="email"]').value;
    // Optional: Perform email validation if needed

    // Redirect to the password reset page
    window.location.href = `reset.html?email=${encodeURIComponent(email)}`;
}

function showSuccessMessage(event, type) {
    event.preventDefault();
    const successMessage = document.getElementById('successMessage');
    if (type === 'login') {
        successMessage.textContent = 'Successfully login!';
        setTimeout(() => {
            window.location.href = 'Nlogin.html'; // Redirect to login page after 2 seconds
        }, 2000); // Adjust delay as needed (2 seconds in this example)
    } else if (type === 'register') {
        successMessage.textContent = 'You have registered!';
        setTimeout(() => {
            window.location.href = 'Nlogin.html'; // Redirect to login page after 2 seconds
        }, 2000); // Adjust delay as needed (2 seconds in this example)
    } else if (type === 'password-reset') {
        successMessage.textContent = 'Password reset successful!';
        setTimeout(() => {
            window.location.href = 'Nlogin.html'; // Redirect to login page after 2 seconds
        }, 2000); // Adjust delay as needed (2 seconds in this example)
    }
    successMessage.style.display = 'block';
}
function redirectToHomePage() {
    window.location.href = 'HomePage.html';
}

function showSuccessMessage(event, type) {
    event.preventDefault();
    const successMessage = document.getElementById('successMessage');
    if (type === 'login') {
        successMessage.textContent = 'Successfully login!';
        setTimeout(() => {
            redirectToHomePage(); // Redirect to home page after 2 seconds
        }, 2000); // Adjust delay as needed (2 seconds in this example)
    } else if (type === 'register') {
        successMessage.textContent = 'You have registered!';
        setTimeout(() => {
            redirectToHomePage(); // Redirect to home page after 2 seconds
        }, 2000); // Adjust delay as needed (2 seconds in this example)
    } else if (type === 'password-reset') {
        successMessage.textContent = 'Password reset successful!';
        setTimeout(() => {
            redirectToHomePage(); // Redirect to home page after 2 seconds
        }, 2000); // Adjust delay as needed (2 seconds in this example)
    }
    successMessage.style.display = 'block';
}
