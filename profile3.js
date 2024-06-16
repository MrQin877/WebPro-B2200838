document.addEventListener('DOMContentLoaded', () => {
    const user = JSON.parse(localStorage.getItem('user'));
    if (user) {
        document.getElementById('userName').textContent = user.name;
        document.getElementById('userBirthday').textContent = user.birthday;
        document.getElementById('userEmail').textContent = user.email;
        document.getElementById('userPhone').textContent = user.phone;
        document.getElementById('userSex').textContent = user.sex;
    } else {
        alert('No user data found. Please register or log in.');
        window.location.href = 'login1.html'; // Redirect to the login page if no user data
    }
});
document.addEventListener('DOMContentLoaded', () => {
    const user = JSON.parse(localStorage.getItem('user'));
    if (user) {
        document.getElementById('userName').textContent = user.name;
        document.getElementById('userBirthday').textContent = user.birthday;
        document.getElementById('userEmail').textContent = user.email;
        document.getElementById('userPhone').textContent = user.phone;
        document.getElementById('userSex').textContent = user.sex;
    } else {
        alert('No user data found. Please register or log in.');
        window.location.href = 'login1.html'; // Redirect to the login page if no user data
    }
});
