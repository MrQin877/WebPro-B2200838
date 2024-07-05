<?php
// process_login.php

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
        echo "Email and Password are required fields.";
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
                //echo "Login successful.";
                 echo "<script>alert('Login successful.');</script>";
                // Here you can start a session and store user information
                session_start();
                $_SESSION['user_id'] = $UserID;
                // Redirect to a protected page or dashboard
                //header("Location: index.php");
                //exit();
            } else {
                //echo "Invalid email or password.";
                echo "<script>alert('Invalid email or password.'); window.location.href = 'login.html';</script>";
            }
        } else {
            echo "No account found with that email.";
        }

        $stmt->close();
    }
}

$conn->close();
?>