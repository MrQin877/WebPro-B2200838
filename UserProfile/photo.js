document.addEventListener("DOMContentLoaded", function() {
        fetch("photo_retrieve.php")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                // Call updateDisplay with the courses from the server
                ImageDisplay(data.image);
            }
        })
        .catch(error => {
            console.error('Error fetching login status:', error);
        });
    });

    function ImageDisplay(image) {
        alert(image)
        document.getElementById('profilePicture').src = image;
    }