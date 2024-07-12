document.addEventListener("DOMContentLoaded", function() {
    fetch("teach_retri.php")
        .then(response => response.json())
        .then(data => {
            console.log(data); // Check the response data
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                updateAdminTeach(data.teachers);
            }
        })
        .catch(error => {
            console.error('Error fetching teachers:', error);
        });
});

function updateAdminTeach(teachers) {
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
        name.style.fontSize = 'medium';
        name.textContent = teacher.Teachname;

        var graduateLabel = document.createElement('p');
        graduateLabel.classList.add('Jack-normal-word');
        graduateLabel.style.textDecoration = 'underline';
        graduateLabel.style.fontSize = 'medium';
        graduateLabel.textContent = 'Graduate';

        var education = document.createElement('p');
        education.classList.add('Jack-normal-word');
        education.style.fontSize = 'medium';
        education.innerHTML = teacher.TeachEdu + '<br>' + teacher.TeachUNI;

        var sloganLabel = document.createElement('p');
        sloganLabel.classList.add('Jack-normal-word');
        sloganLabel.style.textDecoration = 'underline';
        sloganLabel.style.fontSize = 'medium';
        sloganLabel.textContent = 'Slogan';

        var slogan = document.createElement('p');
        slogan.classList.add('Jack-normal-word');
        slogan.style.fontSize = 'medium';
        slogan.textContent = '"'+teacher.Slogan +'"';

        var editButton = document.createElement('button');
        editButton.textContent = 'Edit';
        editButton.onclick = function() {
            editTeacher(teacher);
        };

        var deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.onclick = function() {
            deleteTeacher(teacher.TeachID);
        };

        // Append elements to teacherSlide
        teacherSlide.appendChild(image);
        teacherSlide.appendChild(name);
        teacherSlide.appendChild(graduateLabel);
        teacherSlide.appendChild(education);
        teacherSlide.appendChild(sloganLabel);
        teacherSlide.appendChild(slogan);
        teacherSlide.appendChild(editButton);
        teacherSlide.appendChild(deleteButton);

        // Append teacherSlide to teachersList
        teachersList.appendChild(teacherSlide);
    });
}

function editTeacher(teacher) {
    console.log(teacher); // Log the teacher object to inspect its properties
    document.getElementById('teacher_id').value = teacher.TeachID || '';
    document.getElementById('TeachName').value = teacher.Teachname || '';
    document.getElementById('TeachEdu').value = teacher.TeachEdu || '';
    document.getElementById('TeachUNI').value = teacher.TeachUNI || '';
    document.getElementById('Slogan').value = teacher.Slogan || '';
}

function deleteTeacher(teachID) {
    fetch('teach_del.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ TeachID: teachID }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Refresh the teacher list or remove the deleted teacher from the DOM
            alert('Teacher deleted successfully');
            location.reload(); // or you can call the fetch function again to refresh the list
        } else {
            console.error('Error deleting teacher:', data.error);
        }
    })
    .catch(error => {
        console.error('Error deleting teacher:', error);
    });
}
