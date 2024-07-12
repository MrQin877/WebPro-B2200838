<?php
// /login/process_login.php

session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = "";  // Change this to your actual database password
$dbname = "user"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email = $_POST['email'];
    $Password = $_POST['password'];

    // Validate input
    if (empty($Email) || empty($Password)) {
        echo "<script>alert('Email and Password are required fields.'); window.location.href = 'Nlogin.html';</script>";
    } else {
        // Prepare a select statement
        $stmt = $conn->prepare("SELECT UserID, password FROM user_registration WHERE Email = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Bind result variables
            $stmt->bind_result($UserID, $hashedPassword);
            $stmt->fetch();

            // Verify password
            if (password_verify($Password, $hashedPassword)) {
                $_SESSION['user_id'] = $UserID;
                echo "<script>alert('Login successful.'); window.location.href = '../A-HomePage/HomePage.html';</script>";
            } else {
                echo "<script>alert('Invalid email or password.'); window.location.href = 'Nlogin.html';</script>";
            }
        } else {
            echo "<script>alert('No account found with that email.'); window.location.href = 'Nlogin.html';</script>";
        }

        $stmt->close();
    }
}

$conn->close();
?>
