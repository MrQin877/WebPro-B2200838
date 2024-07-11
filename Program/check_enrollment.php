<?php
session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";  // Change this to your actual database password
$dbname = "user"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['user_id'], $data['program_id'])) {
    $user_id = $data['user_id'];
    $program_id = $data['program_id'];

    // Check if the user is enrolled in any of the programs within the all-subject package
    if ($program_id == 'all-subject-package') {
        $query = "SELECT COUNT(*) as count FROM user_program WHERE user_id = ? AND program_id IN ('1001', '1002', '1003', '1004', '1005')";
    } else {
        $query = "SELECT COUNT(*) as count FROM user_program WHERE user_id = ? AND program_id = ?";
    }

    $stmt = $conn->prepare($query);
    if ($program_id == 'all-subject-package') {
        $stmt->bind_param("i", $user_id);
    } else {
        $stmt->bind_param("ii", $user_id, $program_id);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    if ($row['count'] > 0) {
        echo json_encode(['enrolled' => true]);
    } else {
        echo json_encode(['enrolled' => false]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>
