<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: Nlogin.html");
    exit();
}

// Assuming you have an array of program IDs being added to the cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['program_id'])) {
    $program_id = $_POST['program_id'];

    // Add to cart logic (this can be saved in session or database)
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    $_SESSION['cart'][] = $program_id;

    echo "Item added to cart.";
}
?>


