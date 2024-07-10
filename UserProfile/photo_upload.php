<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2024";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["submit"])) {
    $targetDirectory = "uploads/"; // Directory where uploaded files will be stored
    $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "File already exists.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        session_start();
        $user_id = $_SESSION['user_id'];
        
        $checksql = "SELECT file_name, file_path FROM up_load WHERE UserID = ?";
        $stmt = $conn->prepare($checksql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            
            // Save file information to the database
            $fileName = basename($_FILES["fileToUpload"]["name"]);
            $filePath = $targetFile;
            
            $update_query = "UPDATE up_load SET file_name='$fileName', file_path='$filePath' WHERE UserID='$user_id'";
            
            if ($conn->query($update_query) === TRUE) {
                echo "File information updated in the database.";
            } else {
                echo "Error: " . $update_query . "<br>" . $conn->error;
            }
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                
                // Save file information to the database
                $fileName = basename($_FILES["fileToUpload"]["name"]);
                $filePath = $targetFile;
                
                $sql = "INSERT INTO up_load (UserID, file_name, file_path) VALUES ('$user_id', '$fileName', '$filePath')";
                
                if ($conn->query($sql) === TRUE) {
                    echo "File information saved to the database.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>
