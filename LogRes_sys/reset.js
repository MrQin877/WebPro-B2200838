// Function to handle form submission
document.getElementById("resetPasswordForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    // Get form inputs
    const resetCode = this.elements.resetPassword.value;
    const newPassword = this.elements.new_password.value;
    const confirmPassword = this.elements.confirm_password.value;

    // Validate password complexity
    const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,10}$/;
    if (!passwordRegex.test(newPassword)) {
        alert("Password must be 6 to 10 characters long, include at least one capital letter and one special character (!, @, #, $, %, &).");
        return;
    }

    // Validate password match
    if (newPassword !== confirmPassword) {
        alert("Passwords do not match. Please try again.");
        return;
    }

    // Prepare form data to send to server
    const formData = new FormData();
    formData.append('resetPassword', resetCode);
    formData.append('new_password', newPassword);
    formData.append('confirm_password', confirmPassword);

    // Send data to server using fetch API
    fetch('reset_password.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Handle server response
        if (data.startsWith("Password successfully updated.")) {
            showSuccessMessage(); // Display success message
            setTimeout(() => {
                window.location.href = 'Nlogin.html'; // Redirect to login page after 2 seconds
            }, 2000); // Adjust delay as needed
        } else {
            alert(data); // Display any error message from the server
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred. Please try again later.");
    });
});

// Function to show success message
function showSuccessMessage() {
    const successMessage = document.getElementById('successMessage');
    successMessage.textContent = 'Password reset successful!';
    successMessage.style.display = 'block';
}
