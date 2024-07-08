// Function to check login status
function checkLoginStatus() {
    fetch('logincheckstatus.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(sessionData => {
            console.log(sessionData);

            if (sessionData.is_logged_in) {
                // User is logged in
                document.getElementById('login').classList.add('hidden');
                document.getElementById('profile').classList.remove('hidden');
                document.getElementById('logout').classList.remove('hidden');
            } else {
                // User is not logged in
                document.getElementById('login').classList.remove('hidden');
                document.getElementById('profile').classList.add('hidden');
                document.getElementById('logout').classList.add('hidden');
            }
        })
        .catch(error => console.error('Error:', error));
}

// Call the function to check login status
checkLoginStatus();

