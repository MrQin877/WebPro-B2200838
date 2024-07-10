document.addEventListener("DOMContentLoaded", function() {
    // Load the headers
    fetch("proname.php")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                // Call updateDisplay with the courses from the server
                updateDisplay(data.courses);
            }
        })
        .catch(error => {
            console.error('Error fetching login status:', error);
        });
}); 

function updateDisplay(courses) {
    var coursesList = $('#coursesList');
    coursesList.empty();
    courses.forEach(function (course) {
        var listItem = '<li class="list-group-item">' + course + '</li>';
        coursesList.append(listItem);
    });
}
