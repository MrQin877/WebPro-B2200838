<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Nlogin.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['program_id'])) {
    $program_id = $_POST['program_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    $packageExists = in_array('all-subject-package', array_column($_SESSION['cart'], 'id'));
    
    $otherProgramsExist = count(array_filter($_SESSION['cart'], function($item) {
        return $item['id'] !== 'all-subject-package';
    })) > 0;

    if ($program_id === 'all-subject-package' && $otherProgramsExist) {
        echo "You cannot add the All Subjects Package when other specific programs are in the cart.";
        exit();
    }

    if ($program_id !== 'all-subject-package' && $packageExists) {
        echo "You cannot add specific programs when the All Subjects Package is in the cart.";
        exit();
    }

    $_SESSION['cart'][] = ['id' => $program_id];
    echo "Item added to cart.";
}
?>
