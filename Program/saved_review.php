<?php
// Simulated database storage (replace with actual database connection and query)
$reviews = [];

// Check if POST data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs (for demo purpose, actual validation and sanitization should be stricter)
    $comment = htmlspecialchars($_POST["comment"]);
    $rating = intval($_POST["rating"]);
    $email = htmlspecialchars($_POST["email"]);

    // Validate email (for demo purpose, actual validation should be stricter)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email format.";
        exit;
    }

    // Save review (for demo purpose, replace with actual database query)
    $reviews[] = [
        "comment" => $comment,
        "rating" => $rating,
        "email" => $email
    ];

    // Return success response (for demo purpose)
    http_response_code(200);
    echo "Review submitted successfully.";
    exit;
}

// Return reviews as JSON response (for demo purpose)
header("Content-Type: application/json");
echo json_encode($reviews);
?>
