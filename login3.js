document.addEventListener("DOMContentLoaded", function() {
    const showRegisterLink = document.getElementById("showRegister");
    const showLoginLink = document.getElementById("showLogin");
    const loginFormContainer = document.getElementById("loginFormContainer");
    const registerFormContainer = document.getElementById("registerFormContainer");
    const registerForm = document.getElementById("registerForm");
    const loginForm = document.getElementById("loginForm");

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
        const user = {
            email: document.getElementById("register-email").value,
            password: document.getElementById("register-password").value,
            name: document.getElementById("register-name").value,
            birthday: document.getElementById("register-birthday").value,
            sex: document.getElementById("register-sex").value,
            phone: document.getElementById("register-phone").value
        };

        if (validateForm(user)) {
            localStorage.setItem('user', JSON.stringify(user));
            alert('Registration successful!');
            registerFormContainer.classList.remove("active");
            loginFormContainer.classList.add("active");
        }
    });

    loginForm.addEventListener("submit", function(e) {
        e.preventDefault();
        const email = document.getElementById("login-email").value;
        const password = document.getElementById("login-password").value;
        const user = JSON.parse(localStorage.getItem('user'));

        if (user && user.email === email && user.password === password) {
            alert('Successful login!');
            window.location.href = 'HomePage.html'; // Replace 'index.html' with your home page URL
        } else {
            alert('Invalid email or password');
        }
    });

    function validateForm(user) {
        const errorDiv = document.querySelector('.error');
        if (errorDiv) errorDiv.remove();

        if (!validatePassword(user.password)) {
            showError(registerForm, "Password must be at least 8 characters long and include symbols like @, #, $, !, %, &, *.");
            return false;
        }

        if (user.password !== document.getElementById("confirm-password").value) {
            showError(registerForm, "Passwords do not match.");
            return false;
        }

        if (!validateEmail(user.email)) {
            showError(registerForm, "Please enter a valid email address.");
            return false;
        }

        if (!validateDate(user.birthday)) {
            showError(registerForm, "Please enter a valid date of birth.");
            return false;
        }

        if (!user.sex) {
            showError(registerForm, "Please select your sex.");
            return false;
        }

        if (!validatePhoneNumber(user.phone)) {
            showError(registerForm, "Please enter a valid phone number.");
            return false;
        }

        return true;
    }

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
