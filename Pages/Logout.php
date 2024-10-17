<?php
session_start(); // Start the session

// Destroy all session data
session_unset();  // Unset all session variables
session_destroy();  // Destroy the session

// Redirect to the login page or homepage
header("Location: login.php");  // Replace 'login.php' with the appropriate page
exit();
?>
