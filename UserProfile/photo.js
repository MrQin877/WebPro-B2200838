document.addEventListener("DOMContentLoaded", function() {
    fetch("photo_retrieve.php")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
                DoNotReceive();
            } else {
                // Call updateDisplay with the image from the server
                ImageDisplay(data.image);
            }
        })
        .catch(error => {
            console.error('Error fetching profile picture:', error);
            DoNotReceive();
        });
});

function ImageDisplay(image) {
    document.getElementById('profilePicture').src = image;
}

function DoNotReceive() {
    document.getElementById('profilePicture').src = '../images/photo-icon.png';
}
