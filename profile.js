$(document).ready(function () {
    // Function to fetch user data from the server
    function fetchUserData() {
        // Assuming you have the user's ID from a session or other means
        const userId = 'replace_with_actual_user_id';
        $.ajax({
            url: `/api/userinfo?userId=${userId}`,  // Replace with your actual API endpoint
            type: 'GET',
            success: function (data) {
                // Populate the fields in the profile form with fetched data
                $('#usernameInput').val(data.username);
                $('#nameInput').val(data.name);
                $('#emailInput').val(data.email);
                $('#bioTextarea').val(data.bio);
                $('#birthdayInput').val(data.birthday);
                $('#phoneInput').val(data.phone);

                // Populate courses list dynamically
                var coursesList = $('#coursesList');
                coursesList.empty();  // Clear existing list items
                data.courses.forEach(function (course) {
                    var listItem = '<li class="list-group-item">' + course + '</li>';
                    coursesList.append(listItem);
                });

                // Optional: Handle email confirmation message display
                if (!data.emailConfirmed) {
                    $('#emailConfirmationMessage').show();
                } else {
                    $('#emailConfirmationMessage').hide();
                }
            },
            error: function () {
                console.error('Failed to fetch user data.');
            }
        });
    }

    // Call fetchUserData() on page load
    fetchUserData();
});
