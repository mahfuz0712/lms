<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['LoggedIN']) && $_SESSION['LoggedIN'] === true) {
    // check if  the user is an admin or a simple uer
    if ($_SESSION['User'] === true) {
        header("Location: UserDashboard.php");
    }
} else {
    // The user is not logged in
    header("Location: ./Login.php");
}
?>
