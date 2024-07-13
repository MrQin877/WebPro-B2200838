<?php
// check_duplicate.php

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

// Check if email or resetPassword already exists
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email = $_POST['Email'];
    $resetPassword = $_POST['resetPassword'];

    // Prepare SQL statement to check if email or resetPassword already exists
    $stmt = $conn->prepare("SELECT UserID FROM user_registration WHERE Email = ? OR resetPassword = ?");
    $stmt->bind_param("ss", $Email, $resetPassword);
    $stmt->execute();
    $stmt->store_result();

    // Return JSON response
    header('Content-Type: application/json');
    if ($stmt->num_rows > 0) {
        echo json_encode(array("exists" => true));
    } else {
        echo json_encode(array("exists" => false));
    }
}

$conn->close();
?>
