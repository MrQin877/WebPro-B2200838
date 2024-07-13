<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "You must be logged in to access this information."]);
    exit();
}

$courses_query = "SELECT id, fullname, email, phoneno, question, program FROM contact_form";
$form_result = $conn->query($courses_query);
$contactform = [];

if ($form_result->num_rows > 0) {
    while ($row = $form_result->fetch_assoc()) {
        $contactform[] = $row;
    }
}

// Sending the JSON response
echo json_encode(["contactform" => $contactform]);

$conn->close();
?>
