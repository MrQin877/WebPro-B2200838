<?php
//process_resgitration.php

$servername ="localhost";
$username = "root";
$password ="";
$dbname = "user";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $Username =$_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Birth = $_POST['Birth'];
    $Gender = $_POST['Gender'];

    if (empty($Username) ||empty ($Email) || empty($Password)||  empty($PhoneNumber) ||empty($Birth)|| empty($Gender)){
        echo "First Name, Email, and Password are required fields.";
    } else {
    // Prepare sql statement to check if email already exists
    $stmt = $conn->prepare("SELECT UserID, Email FROM user_registration WHERE Email = ?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email already exists
<<<<<<< Updated upstream
        echo "<script>alert('The Email is already registered.'); window.location.href = 'register.html';</script>";
=======
        echo "The Email is already registered.";
>>>>>>> Stashed changes
    } else {
        // Hash the password
        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

        // Prepare an insert statement
        $stmt = $conn->prepare("INSERT INTO user_registration (Username, Email, Password, PhoneNumber, Birth, Gender) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $Username, $Email, $hashedPassword, $PhoneNumber, $Birth, $Gender);

        if ($stmt->execute()) {
<<<<<<< Updated upstream
            echo "<script>alert('Registration successful.'); window.location.href = 'Nlogin.html';</script>";
=======
            echo "<script>alert('Register successful.');</script>";
            header("Location: Nlogin.html");

>>>>>>> Stashed changes
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}
}

$conn->close();
?>