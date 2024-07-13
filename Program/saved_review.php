<?php
// Example PHP script to handle review submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs (sanitize inputs as needed)
    $review = $_POST["review"];
    $star = $_POST["star"];
    $program = $_POST["program"];
    $email = $_POST["email"];

    // Example: Save review to database (replace with your database connection and query)
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "your_database";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO user_review (review, star, program, email) VALUES (:review, :star, :program, :email)");
        $stmt->bindParam(':review', $review);
        $stmt->bindParam(':star', $star);
        $stmt->bindParam(':program', $program);
        $stmt->bindParam(':email', $email);

        // Execute the statement
        $stmt->execute();

        // Return success message or data if needed
        $response = [
            "status" => "success",
            "message" => "Review submitted successfully."
        ];
        echo json_encode($response);
    } catch(PDOException $e) {
        // Handle database errors
        $response = [
            "status" => "error",
            "message" => "Failed to submit review: " . $e->getMessage()
        ];
        echo json_encode($response);
    }
} else {
    // Handle invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
}
?>
