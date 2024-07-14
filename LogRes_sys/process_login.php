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

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email = $_POST['email'];
    $Password = $_POST['password'];

    // Validate input
    if (empty($Email) || empty($Password)) {
        echo json_encode(['success' => false, 'message' => 'Email and Password are required fields.']);
        exit();
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
                echo json_encode(['success' => true, 'message' => 'Login successful. Redirecting...']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No account found with that email.']);
        }

        $stmt->close();
    }
}

$conn->close();
?>
