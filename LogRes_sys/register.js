// Get references to the HTML elements
const registrationForm = document.getElementById("registrationForm");
const UsernameInput = document.getElementById("Username");
const EmailInput = document.getElementById("Email");
const PasswordInput = document.getElementById("Password");
const ConfirmPasswordInput = document.getElementById("ConfirmPassword");
const PhoneNumberInput = document.getElementById("PhoneNumber");
const BirthInput = document.getElementById("Birth");
const GenderInput = document.getElementById("Gender");
const message = document.getElementById("message");

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

    if (!Username || !Email || !Password || !ConfirmPassword || !PhoneNumber || !Birth || !Gender) {
        message.textContent = "Please fill out all fields.";
        message.style.color = "red";
        message.style.display = "block";
    } else if (Password !== ConfirmPassword) {
        message.textContent = "Passwords do not match. Please re-enter.";
        message.style.color = "red";
        message.style.display = "block";
    } else if (Password.length < 8) {
        message.textContent = "Password must be at least 8 characters.";
        message.style.color = "red";
        message.style.display = "block";
    } else {
        // If all validations pass, you can submit the form or proceed with further actions
        // For example, you might submit the form to a PHP script for processing
        registrationForm.submit();
    }
});
