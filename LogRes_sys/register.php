<?php
// register.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Birth = $_POST['Birth'];
    $Gender = $_POST['Gender'];

    if (empty($Username) || empty($Email) || empty($Password) || empty($ConfirmPassword) || empty($PhoneNumber) || empty($Birth) || empty($Gender)) {
        echo "All fields are required.";
    } elseif ($Password !== $ConfirmPassword) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.location.href = 'register.html';</script>";
    } else {
        // Prepare SQL statement to check if email already exists
        $stmt = $conn->prepare("SELECT UserID, Email FROM user_registration WHERE Email = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Email already exists
            echo "<script>alert('The Email is already registered. Please use a different email.'); window.location.href = 'register.html';</script>";
        } else {
            // Hash the password
            $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

            // Prepare an insert statement
            $stmt = $conn->prepare("INSERT INTO user_registration (Username, Email, Password, PhoneNumber, Birth, Gender) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $Username, $Email, $hashedPassword, $PhoneNumber, $Birth, $Gender);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful.'); window.location.href = 'Nlogin.html';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>
