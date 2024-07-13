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
    $Email = $_POST['email'];
    $Password = $_POST['password'];

    // Validate input
    if (empty($Email) || empty($Password)) {
        echo "<script>alert('Email and Password are required fields.'); window.location.href = 'Nlogin.html';</script>";
        exit;
    }

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
            header("Location: ../A-HomePage/HomePage.html");
            exit;
        } else {
            header("Location: Nlogin.html?error=invalid");
            exit;
        }
    } else {
        header("Location: Nlogin.html?error=noaccount");
        exit;
    }

    $stmt->close();
}

$conn->close();
?>
