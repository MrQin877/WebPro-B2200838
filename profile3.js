document.addEventListener("DOMContentLoaded", function() {
    // Dummy data for demonstration; this should come from your database
    const userProfile = {
        email: "user@example.com",
        name: "John Doe",
        birthday: "1990-01-01",
        sex: "Male",
        phone: "1234567890"
    };

    // Populate the profile fields with user data
    document.getElementById("profile-email").textContent = userProfile.email;
    document.getElementById("profile-name").textContent = userProfile.name;
    document.getElementById("profile-birthday").textContent = userProfile.birthday;
    document.getElementById("profile-sex").textContent = userProfile.sex;
    document.getElementById("profile-phone").textContent = userProfile.phone;

    // Handle edit profile button click
    document.getElementById("edit-profile").addEventListener("click", function() {
        alert("Edit profile functionality is not implemented yet.");
    });
});
