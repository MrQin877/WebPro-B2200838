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

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to upload a profile picture.");
}

$user_id = $_SESSION['user_id'];

// Retrieve the current profile picture
$getImageSql = "SELECT file_path FROM up_load WHERE UserID = ? ORDER BY upload_time DESC LIMIT 1";
$stmt = $conn->prepare($getImageSql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$currentImage = $result->fetch_assoc()['file_path'] ?? "../images/photo-icon.png"; // Default profile picture

if (isset($_POST["action"]) && $_POST["action"] === "uploadPhoto" && isset($_FILES["fileToUpload"])) {
    $targetDirectory = "../UserProfile/uploads/";
    $uniqueFileName = $user_id . '_' . time() . '.' . pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);
    $targetFile = $targetDirectory . $uniqueFileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "<script>alert('Sorry, file already exists.')</script>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 800000) {
        echo "<script>alert('Sorry, your file is too large.')</script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.')</script>";
    } else {
        // If file is valid, upload it
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            $fileName = basename($_FILES["fileToUpload"]["name"]);
            $filePath = $targetFile;

            // Update existing record or insert a new one
            $sql = "SELECT file_name, file_path FROM up_load WHERE UserID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Update existing record
                $sql = "UPDATE up_load SET file_name=?, file_path=?, upload_time=NOW() WHERE UserID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $fileName, $filePath, $user_id);
            } else {
                // Insert new record
                $sql = "INSERT INTO up_load (UserID, file_name, file_path, upload_time) VALUES (?, ?, ?, NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $user_id, $fileName, $filePath);
            }

            if ($stmt->execute()) {
                // Delete old profile picture only if it is not the default picture
                if ($currentImage !== "../images/photo-icon.png" && file_exists($currentImage)) {
                    unlink($currentImage);
                }

                $_SESSION['profile_image'] = $filePath; // Store the path in the session
                echo "<script>alert('The file " . htmlspecialchars($fileName) . " has been uploaded and saved.'); window.location.href='profile.html';</script>";
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
