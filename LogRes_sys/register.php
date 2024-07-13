<?php
// register.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variables to store error messages
$errorMessage = "";

// Process registration form if submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Birth = $_POST['Birth'];
    $Gender = $_POST['Gender'];
    $resetPassword = $_POST['resetPassword']; // Changed resetToken to resetPassword

    // Check if any required field is empty
    if (empty($Username) || empty($Email) || empty($Password) || empty($PhoneNumber) || empty($Birth) || empty($Gender) || empty($resetPassword)) {
        $errorMessage = "All fields are required.";
    } else {
        // Validate password (example pattern: 10 characters or less, one capital letter, one special character)
        if (!preg_match('/^(?=.*[A-Z])(?=.*[!@#$%&])[A-Za-z\d!@#$%&]{1,10}$/', $Password)) {
            $errorMessage = "Password must be 10 characters or less, include at least one capital letter and one special character (!, @, #, $, %, &).";
        } elseif (!preg_match('/^\d+$/', $PhoneNumber)) {
            $errorMessage = "Please enter a valid phone number with numbers only.";
        } else {
            // Check if Email already exists in the database
            $stmt = $conn->prepare("SELECT UserID FROM user_registration WHERE Email = ?");
            $stmt->bind_param("s", $Email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Email already exists
                $errorMessage = "The Email is already registered. Please try again with a different Email.";
            } else {
                // Check if resetPassword already exists in the database
                $stmt = $conn->prepare("SELECT resetPassword FROM user_registration WHERE resetPassword = ?");
                $stmt->bind_param("s", $resetPassword);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    // resetPassword already exists
                    $errorMessage = "The resetPassword is already registered. Please try again with a different resetPassword.";
                } else {
                    // Hash the password
                    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

                    // Insert new user into database
                    $stmt = $conn->prepare("INSERT INTO user_registration (Username, Email, Password, PhoneNumber, Birth, Gender, resetPassword) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssss", $Username, $Email, $hashedPassword, $PhoneNumber, $Birth, $Gender, $resetPassword);

                    if ($stmt->execute()) {
                        echo "Registration successful.";
                    } else {
                        $errorMessage = "Error: " . $stmt->error;
                    }
                }
            }
        }

        $stmt->close();
    }
}

$conn->close();

// Return error message if exists
if (!empty($errorMessage)) {
    echo $errorMessage;
    // Redirect to registration page after displaying error message
    header("Location: registration_page.php");
    exit();
}
?>
