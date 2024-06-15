document.addEventListener("DOMContentLoaded", function() {
    const showRegisterLink = document.getElementById("showRegister");
    const showLoginLink = document.getElementById("showLogin");
    const loginFormContainer = document.getElementById("loginFormContainer");
    const registerFormContainer = document.getElementById("registerFormContainer");
    const registerForm = document.getElementById("registerForm");
    const registerPassword = document.getElementById("register-password");
    const confirmPassword = document.getElementById("confirm-password");
    const registerEmail = document.getElementById("register-email");
    const registerName = document.getElementById("register-name");
    const registerBirthday = document.getElementById("register-birthday");
    const registerSex = document.getElementById("register-sex");
    const registerPhone = document.getElementById("register-phone");

    showRegisterLink.addEventListener("click", function(e) {
        e.preventDefault();
        loginFormContainer.classList.remove("active");
        registerFormContainer.classList.add("active");
    });

    showLoginLink.addEventListener("click", function(e) {
        e.preventDefault();
        registerFormContainer.classList.remove("active");
        loginFormContainer.classList.add("active");
    });

    registerForm.addEventListener("submit", function(e) {
        e.preventDefault();
        const password = registerPassword.value;
        const confirmPasswordValue = confirmPassword.value;
        const email = registerEmail.value;
        const name = registerName.value;
        const birthday = registerBirthday.value;
        const sex = registerSex.value;
        const phone = registerPhone.value;
        const errorDiv = document.querySelector('.error');

        if (errorDiv) {
            errorDiv.remove();
        }

        if (!validatePassword(password)) {
            showError(registerForm, "Password must be at least 8 characters long and include symbols like @, #, $, !, %, &, *.");
            return;
        }

        if (password !== confirmPasswordValue) {
            showError(registerForm, "Passwords do not match.");
            return;
        }

        if (!validateEmail(email)) {
            showError(registerForm, "Please enter a valid email address.");
            return;
        }

        if (name.trim() === "") {
            showError(registerForm, "Name is required.");
            return;
        }

        if (!validateDate(birthday)) {
            showError(registerForm, "Please enter a valid date of birth.");
            return;
        }

        if (sex === "") {
            showError(registerForm, "Please select your sex.");
            return;
        }

        if (!validatePhoneNumber(phone)) {
            showError(registerForm, "Please enter a valid phone number.");
            return;
        }

        // Add your form submission logic here
        alert('Registration successful!');
    });

    function validatePassword(password) {
        const minLength = 8;
        const specialChars = /[@#$!%&*]/;
        return password.length >= minLength && specialChars.test(password);
    }

    function validateEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    function validateDate(date) {
        const timestamp = Date.parse(date);
        return !isNaN(timestamp);
    }

    function validatePhoneNumber(phone) {
        const phonePattern = /^\d{10,15}$/;
        return phonePattern.test(phone);
    }

    function showError(form, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error';
        errorDiv.textContent = message;
        form.appendChild(errorDiv);
    }

    loginFormContainer.classList.add("active");
});
