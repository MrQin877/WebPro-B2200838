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

if (isset($data['user_id'], $data['cart'], $data['payment_id'], $data['amount'])) {
    $user_id = $data['user_id'];
    $cart = $data['cart'];
    $payment_id = $data['payment_id'];
    $amount = $data['amount'];

    // Prepare the statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO user_program (user_id, program_id, payment_id, amount) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        file_put_contents('log.txt', 'Failed to prepare statement: ' . $conn->error . "\n", FILE_APPEND);
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement: ' . $conn->error]);
        exit;
    }

    // Iterate over the cart items and insert each one
    foreach ($cart as $item) {
        $program_id = $item['id']; // Ensure your cart items have an 'id' property that corresponds to Program_id
        $stmt->bind_param("iisd", $user_id, $program_id, $payment_id, $amount);
        if (!$stmt->execute()) {
            file_put_contents('log.txt', 'Failed to execute statement: ' . $stmt->error . "\n", FILE_APPEND);
            echo json_encode(['status' => 'error', 'message' => 'Failed to execute statement: ' . $stmt->error]);
            $stmt->close();
            $conn->close();
            exit;
        }
    }
    $stmt->close();

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}

$conn->close();
?>
