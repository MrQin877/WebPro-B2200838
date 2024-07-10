<?php
// register.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Show error message and exit if connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process only if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword']; // Add Confirm Password field
    $PhoneNumber = $_POST['PhoneNumber'];
    $Birth = $_POST['Birth'];
    $Gender = $_POST['Gender'];

    // Check if Password and Confirm Password match
    if ($Password !== $ConfirmPassword) {
        echo "<script>alert('Passwords do not match. Please re-enter.'); window.location.href = 'register.html';</script>";
        exit; // Stop further execution
    }

    // Check for empty required fields
    if (empty($Username) || empty($Email) || empty($Password) || empty($PhoneNumber) || empty($Birth) || empty($Gender)) {
        echo "Please fill out all fields.";
    } else {
        // Prepare SQL statement to check if email already exists
        $stmt = $conn->prepare("SELECT UserID FROM user_registration WHERE Email = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $stmt->store_result();

        // If email already exists
        if ($stmt->num_rows > 0) {
            echo "<script>alert('The Email is already registered. Please use a different email.'); window.location.href = 'register.html';</script>";
        } else {
            // Hash the password
            $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

            // Prepare an insert statement
            $stmt = $conn->prepare("INSERT INTO user_registration (Username, Email, Password, PhoneNumber, Birth, Gender) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $Username, $Email, $hashedPassword, $PhoneNumber, $Birth, $Gender);

            // If insertion is successful
            if ($stmt->execute()) {
                // Send congratulatory email on successful registration
                $to = $Email;
                $subject = 'Registration Successful';
                $message = "Congratulations! You have successfully registered.";
                $headers = 'From: your-email@example.com' . "\r\n" .
                    'Reply-To: your-email@example.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                // Send email using PHP mail function
                if (mail($to, $subject, $message, $headers)) {
                    echo "<script>alert('Registration successful! A congratulatory email has been sent to your registered email.'); window.location.href = 'Nlogin.html';</script>";
                } else {
                    echo "<script>alert('Registration successful! However, we were unable to send a congratulatory email. Please try again later.'); window.location.href = 'Nlogin.html';</script>";
                }
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}

// Close database connection
$conn->close();
?>
