document.addEventListener("DOMContentLoaded", function() {
    fetch("teach_get.php")
        .then(response => response.json())
        .then(data => {
            console.log(data); // Check the response data
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                updateTeach(data.teachers);
            }
        })
        .catch(error => {
            console.error('Error fetching teachers:', error);
        });
});

function updateTeach(teachers) {
    var teachersList = document.getElementById('slides');
    teachersList.innerHTML = ''; // Clear existing content if needed

    teachers.forEach(function(teacher) {
        // Create elements
        var teacherSlide = document.createElement('div');
        teacherSlide.classList.add('teacher-slide');

        var image = document.createElement('img');
        image.src = teacher.file_path;
        image.alt = teacher.Teachname;

        var name = document.createElement('h2');
        name.classList.add('Jack-normal-word');
        name.textContent = teacher.Teachname;

        var graduateLabel = document.createElement('p');
        graduateLabel.classList.add('Jack-normal-word');
        graduateLabel.style.textDecoration = 'underline';
        graduateLabel.textContent = 'Graduate';

        var education = document.createElement('p');
        education.classList.add('Jack-normal-word');
        education.innerHTML = teacher.TeachEdu + '<br>'+ teacher.TeachUNI;

        var sloganLabel = document.createElement('p');
        sloganLabel.classList.add('Jack-normal-word');
        sloganLabel.style.textDecoration = 'underline';
        sloganLabel.textContent = 'Slogan';

        var slogan = document.createElement('p');
        slogan.classList.add('Jack-normal-word');
        slogan.textContent ='"'+ teacher.Slogan +'"';

        // Append elements to teacherSlide
        teacherSlide.appendChild(image);
        teacherSlide.appendChild(name);
        teacherSlide.appendChild(graduateLabel);
        teacherSlide.appendChild(education);
        teacherSlide.appendChild(sloganLabel);
        teacherSlide.appendChild(slogan);

        // Append teacherSlide to teachersList
        teachersList.appendChild(teacherSlide);
    });
}

