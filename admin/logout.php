<?php
session_start();
session_unset();
session_destroy();
session_start(); // Start new session to hold success message
$_SESSION['success'] = "You have been successfully logged out.";
header("Location: login.php");
exit();
?>
