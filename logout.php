<?php
session_start();

$_SERVER= array();

session_destroy();

header("Location: A-HomePage/HomePage.html");
exit();
?>