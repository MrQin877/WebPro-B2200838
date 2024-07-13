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

// Variables to store error messages and form data
$errorMessage = "";
$Username = "";
$Email = "";
$Password = "";
$PhoneNumber = "";
$Birth = "";
$Gender = "";
$resetPassword = "";

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
        echo "All fields are required.";
    } else {
        // Validate password (example pattern: 10 characters or less, one capital letter, one special character)
        if (!preg_match('/^(?=.*[A-Z])(?=.*[!@#$%&])[A-Za-z\d!@#$%&]{1,10}$/', $Password)) {
            echo "Password must be 10 characters or less, include at least one capital letter and one special character (!, @, #, $, %, &).";
        } elseif (!preg_match('/^\d+$/', $PhoneNumber)) {
            echo "Please enter a valid phone number with numbers only.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

            // Check if Email already exists in the database
            $stmt = $conn->prepare("SELECT UserID FROM user_registration WHERE Email = ?");
            $stmt->bind_param("s", $Email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo "Email already exists.";
            } else {
                // Check if resetPassword already exists in the database
                $stmt = $conn->prepare("SELECT resetPassword FROM user_registration WHERE resetPassword = ?");
                $stmt->bind_param("s", $resetPassword);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    echo "Reset password already exists.";
                } else {
                    // Insert new user into database
                    $stmt = $conn->prepare("INSERT INTO user_registration (Username, Email, Password, PhoneNumber, Birth, Gender, resetPassword) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssss", $Username, $Email, $hashedPassword, $PhoneNumber, $Birth, $Gender, $resetPassword);

                    if ($stmt->execute()) {
                        echo "Registration successful.";
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                }
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>