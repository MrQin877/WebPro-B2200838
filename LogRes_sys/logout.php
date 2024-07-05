<?php
session_start();
 
//unset the session value
$_SERVER= array();
 
//destroy the session
session_destroy();
 
//redirect to login/home page
header("Location:login.html");
exit();
 
?>
 
 