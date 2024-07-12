document.addEventListener("DOMContentLoaded", function() {
    fetch("proname.php")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                // Call updateDisplay with the courses from the server
                courseDisplay(data.courses);
            }
        })
        .catch(error => {
            console.error('Error fetching courses:', error);
        });
}); 

function courseDisplay(courses) {
    var coursesList = document.getElementById('coursesList');
    coursesList.innerHTML = '';
    courses.forEach(function(course) {
        var listItem = '<li class="list-group-item">' + course + '</li>';
        coursesList.innerHTML += listItem;
    });
}
