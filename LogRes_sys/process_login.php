<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";  // Change this to your actual database password
$dbname = "user"; // Change this to your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email = $_POST['email'];
    $Password = $_POST['password'];

    if (empty($Email) || empty($Password)) {
        echo "<script>
                alert('Email and Password are required fields.');
                window.location.href = 'login.html';
              </script>";
    } else {
        $stmt = $conn->prepare("SELECT UserID, password FROM user_registration WHERE Email = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($UserID, $hashedPassword);
            $stmt->fetch();

            if (password_verify($Password, $hashedPassword)) {
                $_SESSION['user_id'] = $UserID;
                echo "<script>
                        alert('Login successful.');
                        window.location.href = '../A-HomePage/HomePage.html';
                      </script>";
            } else {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const errorMessage = document.getElementById('errorMessage');
                            errorMessage.textContent = 'Invalid email or password.';
                            errorMessage.style.display = 'block';
                            setTimeout(() => {
                                window.location.href = 'login.html';
                            }, 2000);
                        });
                      </script>";
            }
        } else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const errorMessage = document.getElementById('errorMessage');
                        errorMessage.textContent = 'No account found with that email.';
                        errorMessage.style.display = 'block';
                        setTimeout(() => {
                            window.location.href = 'login.html';
                        }, 2000);
                    });
                  </script>";
        }

        $stmt->close();
    }
}

$conn->close();
?>
