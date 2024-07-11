document.addEventListener("DOMContentLoaded", function() {
    // Get DOM elements
    var profilePicture = document.getElementById('profilePicture');
    var fileInput = document.getElementById('fileInput');
    var resetButton = document.getElementById('resetButton');
    
    // Set initial profile picture or load from database if available
    // Example: You can fetch the profile picture URL from the server and set it here if available
    
    // Event listener for file input change
    fileInput.addEventListener('change', function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        
        reader.onload = function(e) {
            profilePicture.src = e.target.result;
        };
        
        reader.readAsDataURL(file);
    });
    
    // Event listener for reset button
    resetButton.addEventListener('click', function() {
        // Reset profile picture to default
        profilePicture.src = '../images/photo-icon.jpg'; // Set your default image path here
        // Optionally, you can also clear the file input if needed
        fileInput.value = '';
    });
});
