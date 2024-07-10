// Get references to the HTML elements
const registrationForm = document.getElementById("registrationForm");
const UserameInput = document.getElementById("Username");
const EmailInput = document.getElementById("Email");
const PasswordInput = document.getElementById("Password");
const PhoneNumberInput = document.getElementById("PhoneNumber");
const BirthInput = document.getElementById("Birth");
const GenderInput = document.getElementById("Gender");

//const togglePassword = document.getElementById("togglePassword");
const message = document.getElementById("message");


// Function to toggle password visibility
/*function togglePasswordVisibility() {
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        togglePassword.textContent = "Hide Password";
    } else {
        passwordInput.type = "password";
        togglePassword.textContent = "Show Password";
    }
}
*/
// // Add click event listener to toggle password visibility
// togglePassword.addEventListener("click", function() {
//     togglePasswordVisibility();
// });

// Add submit event listener to the form
registrationForm.addEventListener("submit", function(e) {
    e.preventDefault(); // Prevent the form from submitting by default

    // Validate form input
    const Username = UsenameInput.value.trim();
    const Email = EmailInput.value.trim();
    const Password = PasswordInput.value.trim();
    const ConfirmPassword = ConfirmPasswordInput.value.trim();
    const PhoneNumber = PhoneNumberInput.value.trim();
    const Birth = BirthInput.value.trim();
    const Gender = GenderInput.value.trim();


    if (!firstName || !lastName || !email || !password) {
    //if (password===NULL) {
        message.textContent = "Please fill out all fields.";
        message.style.color = "red";
        message.style.display = "block";
    } else if (password.length < 8) {
        message.textContent = "Password must be at least 8 characters.";
        message.style.color = "red";
        message.style.display = "block";
    } else {
        registrationForm.submit();//save this for php later
        //message.textContent = "Registration successful!";
        //message.style.color = "green";
        //message.style.display = "block";
    }
});

// Add a mouseover event listener to the email input
emailInput.addEventListener("mouseover", function() {
    emailInput.style.backgroundColor = "red"; // Change the text color to red
});

// Add a mouseout event listener to reset the color when the mouse leaves the input
emailInput.addEventListener("mouseout", function() {
    emailInput.style.backgroundColor = ""; // Reset to the default color
});