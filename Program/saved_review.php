<?php
// Database connection parameters
$servername = "localhost";
$username = "your_username"; // Replace with your MySQL username
$password = "your_password"; // Replace with your MySQL password
$dbname = "your_database"; // Replace with your MySQL database name
$charset = "utf8mb4";

// Start session (if not already started)
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize_input($data) {
    global $conn;
    return htmlspecialchars(mysqli_real_escape_string($conn, trim($data)));
}

// Function to verify if the logged-in email matches
function is_logged_in_user($email) {
    // Check if session variable is set
    if (isset($_SESSION['logged_in_email'])) {
        // Get logged-in user's email from session
        $logged_in_email = $_SESSION['logged_in_email'];
        // Compare with the email passed from JavaScript
        return ($logged_in_email === $email);
    }
    return false; // Return false if session variable not set
}

// Handling POST request from JavaScript
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve POST data
    $review = sanitize_input($_POST['review']);
    $star = sanitize_input($_POST['star']);
    $program = sanitize_input($_POST['program']);
    $email = sanitize_input($_POST['email']); // Assuming email is passed from JavaScript

    // Verify if the logged-in user's email matches
    if (is_logged_in_user($email)) {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO user_review (review, star, program, email) VALUES (?, ?, ?, ?)");
        
        // Bind parameters and execute
        $stmt->bind_param("siss", $review, $star, $program, $email);
        if ($stmt->execute()) {
            echo "Review saved successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close statement
        $stmt->close();
    } else {
        echo "Error: Logged-in user email does not match!";
    }
}

// Close connection
$conn->close();
?>
