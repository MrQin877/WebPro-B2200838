document.addEventListener("DOMContentLoaded", function() {
    // Retrieve user data from localStorage
    const user = JSON.parse(localStorage.getItem('user'));

    // Populate the profile fields with user data
    if (user) {
        document.getElementById("profile-email").textContent = user.email;
        document.getElementById("profile-name").textContent = user.name;
        document.getElementById("profile-birthday").textContent = user.birthday;
        document.getElementById("profile-phone").textContent = user.phone;
    } else {
        alert("No user data found. Please log in.");
        window.location.href = 'login1.html';
    }

    // Handle edit profile button click
    document.getElementById("edit-profile").addEventListener("click", function() {
        alert("Edit profile functionality is not implemented yet.");
    });
});
