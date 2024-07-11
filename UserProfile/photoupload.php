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

// Retrieve user's current profile picture
$user_id = $_SESSION['user_id'];
$getImageSql = "SELECT file_path FROM up_load WHERE UserID = ? ORDER BY upload_time DESC LIMIT 1";
$stmt = $conn->prepare($getImageSql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$currentImage = $result->fetch_assoc()['file_path'] ?? "../images/photo-icon.png"; // Default profile picture

if (isset($_POST["action"]) && $_POST["action"] === "uploadPhoto" && isset($_FILES["fileToUpload"])) {
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 800000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            $fileName = basename($_FILES["fileToUpload"]["name"]);
            $filePath = $targetFile;

            // Delete old profile picture from the server
            if ($currentImage !== "../images/photo-icon.png") {
                unlink($currentImage);
            }

            // Insert new profile picture information into the database
            $insertSql = "INSERT INTO up_load (UserID, file_name, file_path, upload_time) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("iss", $user_id, $fileName, $filePath);

            if ($stmt->execute()) {
                $_SESSION['profile_image'] = $filePath; // Store the path in the session
                echo "The file " . htmlspecialchars($fileName) . " has been uploaded and saved.";
                header('Location: profile.html'); // Redirect to the profile page to display the new image
                exit();
            } else {
                echo "Error saving file information: " . $stmt->error;
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
