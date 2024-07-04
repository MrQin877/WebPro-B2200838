<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";
 
if (isset($_POST["submit"])) {
    $targetDirectory = "up_load/"; // Directory where uploaded files will be stored
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
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
 
            // Save file information to the database
            $conn = new mysqli($servername, $username, $password, $dbname);
 
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
 
            $fileName = basename($_FILES["fileToUpload"]["name"]);
            $filePath = $targetFile;
 
            $sql = "INSERT INTO up_load (file_name, file_path) VALUES ('$fileName', '$filePath')";
 
            if ($conn->query($sql) === TRUE) {
                echo "File information saved to database.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
 
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
 