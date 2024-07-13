// Get references to the HTML elements
const registrationForm = document.getElementById("registrationForm");
const UsernameInput = document.getElementById("Username");
const EmailInput = document.getElementById("Email");
const PasswordInput = document.getElementById("Password");
const ConfirmPasswordInput = document.getElementById("ConfirmPassword");
const PhoneNumberInput = document.getElementById("PhoneNumber");
const BirthInput = document.getElementById("Birth");
const GenderInput = document.getElementById("Gender");
const ResetPasswordInput = document.getElementById("resetPassword");
const message = document.getElementById("successMessage");

// Add submit event listener to the form
registrationForm.addEventListener("submit", function(e) {
    e.preventDefault(); // Prevent the form from submitting by default

    // Validate form input
    const Username = UsernameInput.value.trim();
    const Email = EmailInput.value.trim();
    const Password = PasswordInput.value.trim();
    const ConfirmPassword = ConfirmPasswordInput.value.trim();
    const PhoneNumber = PhoneNumberInput.value.trim();
    const Birth = BirthInput.value.trim();
    const Gender = GenderInput.value.trim();
    const ResetPassword = ResetPasswordInput.value.trim();

    // Regular expression to check password criteria
    const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%&])[A-Za-z\d!@#$%&]{1,10}$/;

    // Check if all fields are filled
    if (!Username || !Email || !Password || !ConfirmPassword || !PhoneNumber || !Birth || !Gender || !ResetPassword) {
        message.textContent = "Please fill out all fields.";
        message.style.color = "red";
        message.style.display = "block";
    } else if (!passwordRegex.test(Password)) {
        message.textContent = "Password must be 10 characters or less, include at least one capital letter and one special character (!, @, #, $, %, &).";
        message.style.color = "red";
        message.style.display = "block";
    } else if (Password !== ConfirmPassword) {
        message.textContent = "Passwords do not match.";
        message.style.color = "red";
        message.style.display = "block";
    } else if (!/^\d+$/.test(PhoneNumber)) {
        message.textContent = "Please enter a valid phone number with numbers only.";
        message.style.color = "red";
        message.style.display = "block";
    } else {
        // Check duplicate Email and ResetPassword via fetch API
        fetch('check_duplicate.php', {
            method: 'POST',
            body: JSON.stringify({ Email: Email, ResetPassword: ResetPassword }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                message.textContent = data.error;
                message.style.color = "red";
                message.style.display = "block";
            } else {
                // If no duplicates, submit the form
                fetch('register.php', {
                    method: 'POST',
                    body: new FormData(registrationForm)
                })
                .then(response => response.text())
                .then(data => {
                    if (data === 'Email already exists.') {
                        message.textContent = "The Email is already registered. Please try again with a different Email.";
                        message.style.color = "red";
                        message.style.display = "block";
                    } else if (data === 'Reset password already exists.') {
                        message.textContent = "The resetPassword is already registered. Please try again with a different resetPassword.";
                        message.style.color = "red";
                        message.style.display = "block";
                    } else if (data === 'Registration successful.') {
                        message.textContent = "Registration successful.";
                        message.style.color = "green";
                        message.style.display = "block";
                        // Optionally, redirect to another page after successful registration
                        setTimeout(() => {
                            window.location.href = 'Nlogin.html';
                        }, 2000); // Redirect after 2 seconds (adjust as needed)
                    } else {
                        message.textContent = "An error occurred. Please try again later.";
                        message.style.color = "red";
                        message.style.display = "block";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    message.textContent = "An error occurred. Please try again later.";
                    message.style.color = "red";
                    message.style.display = "block";
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            message.textContent = "An error occurred. Please try again later.";
            message.style.color = "red";
            message.style.display = "block";
        });
    }
});

// Optional: Add a mouseover event listener to the email input for visual feedback
EmailInput.addEventListener("mouseover", function() {
    EmailInput.style.backgroundColor = "lightblue"; // Change the background color on mouseover
});

// Add a mouseout event listener to reset the color when the mouse leaves the input
EmailInput.addEventListener("mouseout", function() {
    EmailInput.style.backgroundColor = ""; // Reset to the default color
});
