document.addEventListener("DOMContentLoaded", function() {
    fetch("ContactForm.php")
        .then(response => response.json())
        .then(data => {
            console.log(data); // Check the response data
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                updateAdminTeach(data.contactform);
            }
        })
        .catch(error => {
            console.error('Error fetching forms:', error);
        });
});

function updateAdminTeach(contactform) {
    var formsList = document.getElementById('ContactForm');
    formsList.innerHTML = ''; // Clear existing content if needed

    contactform.forEach(function(form) {
        // Create elements
        var FormBox = document.createElement('div');
        FormBox.classList.add('teacher-slide');

        // Append elements to FormBox
        FormBox.appendChild(image);

        // Append FormBox to teachersList
        formsList.appendChild(FormBox);
    });
}