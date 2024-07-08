<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $password = $_POST['password'];

    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "user";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $password_query = "SELECT Password FROM user_registration WHERE UserID = ?";
    $stmt = $conn->prepare($password_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['Password'])) {
        $delete_user_query = "DELETE FROM user_registration WHERE UserID = ?";
        $stmt = $conn->prepare($delete_user_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $delete_courses_query = "DELETE FROM purchased_courses WHERE user_id = ?";
        $stmt = $conn->prepare($delete_courses_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        session_unset();
        session_destroy();
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Invalid password."]);
    }

    $stmt->close();
    $conn->close();
}
?>
