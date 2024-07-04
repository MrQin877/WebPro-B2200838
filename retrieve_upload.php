<?php
$servername = "localhost";
$username = "root";
$password = "";  
$dbname = "user"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//fetch content from the database
$sql= "SELECT id, file_name, file_path, upload_time FROM up_load";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Uploaded Files </title>
    </head>
    <body>
        <h1> Uploaded Files</h1>


        <?php
        if($result->num_rows>0)
        {
            //output data in each row
            while($row = $result->fetch_assoc()){
                $filePath=$row["file_path"];
                $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                //Display image if the file is in image
                if(in_array($fileExtension,['jpg','jpeg','png','gif'])){
                    echo "File ID: ". $row["id"]. " - Name: " . $row["file_name"]." - Uploaded on: ". $row["upload_time"]. "<br>"; 
                    echo "<img src='$filePath' alt= '". $row["file_name"]."' style='max-width:10px, max-height:10px;'<br><br>";
                }
                    else{
                        //Display nor non-image files
                        echo "File ID: ". $row["id"]. " - Name: " . $row["file_name"]." - Uploaded on: ". $row["uploade_time"]. "- <a href ='".$filePath. "'>Download</a><br>"; 
                    }
            }
        }
        else{
            echo "No files found.";
        }
        ?>

    </body>
</html>