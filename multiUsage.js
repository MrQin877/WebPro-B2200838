document.addEventListener("DOMContentLoaded", function() {
    // Load the headers
    fetch("../headers.html")
        .then(response => response.text())
        .then(data => {
            document.querySelector("headers").innerHTML = data;
            // After loading the header, check the login status
            return fetch('../sessioncheck.php');
        })
        .then(response => response.json())
        .then(data => {
            // Call updateDisplay with the loggedIn value from the server
            updateDisplay(data.isAdmin, data.loggedIn);
        })
        .catch(error => {
            console.error('Error fetching login status:', error);
        });
    
    // Load the footers
    fetch("../footers.html")
        .then(response => response.text())
        .then(data => {
            document.querySelector("footers").innerHTML = data;
        });
}); 

// Function to update the display based on login status
function updateDisplay(isAdmin, loggedIn) {
    var loginElement = document.getElementById('login');
    var profileElement = document.getElementById('profile');
    var adminElement = document.getElementById('admin');
    var logoutElement = document.getElementById('logout');

    if (loggedIn && isAdmin) {
        loginElement.classList.add('hidden');
        profileElement.classList.add('hidden');
        adminElement.classList.remove('hidden');
        logoutElement.classList.remove('hidden');
    } else if (loggedIn) {
        loginElement.classList.add('hidden');
        profileElement.classList.remove('hidden');
        adminElement.classList.add('hidden');
        logoutElement.classList.remove('hidden');
    } else {
        loginElement.classList.remove('hidden');
        profileElement.classList.add('hidden');
        adminElement.classList.add('hidden');
        logoutElement.classList.add('hidden');
    }
}

