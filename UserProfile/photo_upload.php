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

// Check if the form was submitted with a file upload
if (isset($_POST["action"]) && $_POST["action"] === "uploadPhoto" && isset($_FILES["fileToUpload"])) {
    $targetDirectory = "uploads/"; // Directory where uploaded files will be stored
    $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (max size of 800KB)
    if ($_FILES["fileToUpload"]["size"] > 800000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // File upload is valid, proceed with database operations

        $user_id = $_SESSION['user_id'];

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            // Update user's profile picture in the database
            $fileName = basename($_FILES["fileToUpload"]["name"]);
            $filePath = $targetFile;

            // Check if there's already a record for this user in the database
            $checkSql = "SELECT * FROM user_profile WHERE user_id = ?";
            $stmt = $conn->prepare($checkSql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Update existing record
                $updateSql = "UPDATE user_profile SET profile_picture=? WHERE user_id=?";
                $stmt = $conn->prepare($updateSql);
                $stmt->bind_param("si", $filePath, $user_id);
            } else {
                // Insert new record
                $insertSql = "INSERT INTO user_profile (user_id, profile_picture) VALUES (?, ?)";
                $stmt = $conn->prepare($insertSql);
                $stmt->bind_param("is", $user_id, $filePath);
            }

            if ($stmt->execute()) {
                echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded and profile picture updated.";
            } else {
                echo "Error updating profile picture: " . $stmt->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    echo "No file uploaded or action is invalid.";
}

$conn->close();
?>
