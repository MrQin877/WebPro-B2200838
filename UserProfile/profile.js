$(document).ready(function () {

    function fetchUserData() {
        const userId = 'replace_with_actual_user_id';
        $.ajax({
            url: `/api/userinfo?userId=${userId}`,
            type: 'GET',
            success: function (data) {
                $('#usernameInput').val(data.username);
                $('#nameInput').val(data.name);
                $('#emailInput').val(data.email);
                $('#bioTextarea').val(data.bio);
                $('#birthdayInput').val(data.birthday);
                $('#phoneInput').val(data.phone);

                    var coursesList = $('#coursesList');
                    coursesList.empty();
                    data.courses.forEach(function (course) {
                        var listItem = '<li class="list-group-item">' + course + '</li>';
                        coursesList.append(listItem);
                }); 

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

    fetchUserData();
});

