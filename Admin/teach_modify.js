function editTeacher(teachID) {
    // Retrieve the teacher data by teachID
    var teacher = teachers.find(t => t.TeachID === teachID);

    // Populate the form with the teacher's data
    document.getElementById('teachID').value = teacher.TeachID;
    document.getElementById('teacherName').value = teacher.TeacherName;
    document.getElementById('teachEdu').value = teacher.TeachEdu;
    document.getElementById('teachUNI').value = teacher.TeachUNI;
    document.getElementById('slogan').value = teacher.Slogan;

}

function deleteTeacher(teachID) {
    // Confirm the deletion
    if (confirm('Are you sure you want to delete this teacher?')) {
        fetch('delete_teacher.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ teachID: teachID })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Teacher deleted successfully');
                // Optionally, refresh the teacher list
                updateAdminTeach(data.teachers);
            } else {
                console.error('Error:', data.error);
            }
        })
        .catch(error => {
            console.error('Error deleting teacher:', error);
        });
    }
}
