<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phnum = $_POST['phnum'];
    $question = $_POST['question'];
    $program = $_POST['program'];

    // Check if any field is empty
    if (empty($name) || empty($email) || empty($phnum) || empty($question) || empty($program)) {
        echo "<script>alert('All fields are required.'); window.location.href = 'ContactUS.html';</script>";
    } else {
        $sql = "INSERT INTO contact_form (fullname, email, phoneno, question, program) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $email, $phnum, $question, $program);

        if ($stmt->execute()) {
            echo "<script>alert('Changes saved successfully'); window.location.href = 'ContactUS.html';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

