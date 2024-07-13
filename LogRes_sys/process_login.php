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

// Check if this is a POST request for login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email = $_POST['email'];
    $Password = $_POST['password'];

    // Validate input
    if (empty($Email) || empty($Password)) {
        echo "<script>alert('Email and Password are required fields.'); window.location.href = 'Nlogin.html';</script>";
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
                echo "<script>window.location.href = '../A-HomePage/HomePage.html';</script>";
            } else {
                echo "<script>window.location.href = 'Nlogin.html?error=invalid';</script>";
            }
        } else {
            echo "<script>window.location.href = 'Nlogin.html?error=noaccount';</script>";
        }

        $stmt->close();
    }
}

// Check if this is a GET request to check login status
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'check_login') {
    $response = array(
        "isLoggedIn" => isset($_SESSION['user_id']) // 사용자 세션에 user_id가 설정되어 있으면 로그인 상태로 간주
    );

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$conn->close();
?>
