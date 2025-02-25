document.addEventListener("DOMContentLoaded", function() {
    const saveChangesForm = document.getElementById('saveChangesForm');
    const optionalDataInput = document.getElementById('optionalData');
    // Fetch user data on page load
    fetchUserData();

    saveChangesForm.addEventListener('submit', function(event) {
        const action = event.submitter.value;

        if (action === 'saveOptional') {
            // Gather optional data
            const nickname = document.getElementById('nicknameInput').value;
            const bio = document.getElementById('bioInput').value;

            // Store optional data in hidden input
            optionalDataInput.value = JSON.stringify({ nickname, bio });
            saveChangesForm.action = 'save_optional.php';
        }
    });

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('profilePicture').src = e.target.result;
        };
        
        reader.readAsDataURL(file);
    });

});


function fetchUserData() {
    fetch('get_user_data.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                document.getElementById('username').value = data.username || '';
                document.getElementById('emailInput').value = data.email || '';
                document.getElementById('birthdayInput').value = data.birthday || '';
                document.getElementById('phoneNumberInput').value = '+60'+ data.phone || '';
                document.getElementById('nicknameInput').value = data.nickname || '';
                document.getElementById('bioInput').value = data.bio || '';

            }
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
        });
}
