// Get references to the HTML elements
const registrationForm = document.getElementById("registrationForm");
const UsernameInput = document.getElementById("Username");
const EmailInput = document.getElementById("Email");
const PasswordInput = document.getElementById("Password");
const ConfirmPasswordInput = document.getElementById("ConfirmPassword");
const PhoneNumberInput = document.getElementById("PhoneNumber");
const BirthInput = document.getElementById("Birth");
const GenderInput = document.getElementById("Gender");
const FacebookIDInput = document.getElementById("FacebookID");
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
    const FacebookID = FacebookIDInput.value.trim();

    // Regular expression to check password criteria
    const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%&])[A-Za-z\d!@#$%&]{1,10}$/;

    // Check if all fields are filled
    if (!Username || !Email || !Password || !ConfirmPassword || !PhoneNumber || !Birth || !Gender || !FacebookID) {
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
        registrationForm.submit(); // Submit the form if all validations pass
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
