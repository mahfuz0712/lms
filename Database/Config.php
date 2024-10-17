<?php
// Database configuration
$db_host = 'localhost';      // Database host
$db_user = 'root';  // Database username
$db_pass = '';  // Database password
$db_name = 'lms';   // Database name

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
