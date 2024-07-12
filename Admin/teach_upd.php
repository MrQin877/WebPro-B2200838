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

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to access this information.');window.history.back();</script>";
    exit();
}

// Function to check if any required fields are empty
function checkEmpty($fields) {
    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            return true; // Empty field found
        }
    }
    return false; // All fields are filled
}

// Define required fields for validation
$requiredFields = ['TeachName', 'TeachEdu', 'TeachUNI', 'Slogan'];

// Check if any required fields are empty
if (checkEmpty($requiredFields)) {
    echo "<script>alert('All fields are required. Please fill in all fields.');window.history.back();</script>";
    // Redirect or output any necessary HTML to return to the form page
    exit();
}

// Assuming you receive data from a form submission
$teachID = isset($_POST['teacher_id']) ? $_POST['teacher_id'] : null;
$teachName = $_POST['TeachName'];
$teachEdu = $_POST['TeachEdu'];
$teachUNI = $_POST['TeachUNI'];
$slogan = $_POST['Slogan'];
$file_path = ''; // Initialize file path

// Handle file upload if a new file is provided
if (!empty($_FILES['fileInput']['name'])) {
    $file_path = '../Aboutus/uploads/' . basename($_FILES['fileInput']['name']);
    if (move_uploaded_file($_FILES['fileInput']['tmp_name'], $file_path)) {
        // File uploaded successfully
    } else {
        echo "<script>alert('Error uploading file.');window.history.back()</script>";
        exit();
    }
}

// Check if TeachID exists to determine update or insert
if ($teachID) {
    // TeachID exists, perform update
    $stmt = $conn->prepare("UPDATE teacher_profile SET teachname=?, TeachEdu=?, TeachUNI=?, Slogan=?, file_path=? WHERE TeachID=?");
    $stmt->bind_param("sssssi", $teachName, $teachEdu, $teachUNI, $slogan, $file_path, $teachID);
} else {
    // TeachID doesn't exist, perform insert
    $stmt = $conn->prepare("INSERT INTO teacher_profile (teachname, TeachEdu, TeachUNI, Slogan, file_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $teachName, $teachEdu, $teachUNI, $slogan, $file_path);
}

// Execute the statement
if ($stmt->execute()) {
    echo "<script>alert('Teacher profile saved successfully.');window.location.href='admin.html'</script>";
} else {
    echo "<script>alert('Error saving teacher profile');window.history.back()</script>";
}

$stmt->close();
$conn->close();
?>
