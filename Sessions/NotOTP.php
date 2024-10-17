<?php
session_start();
if(!isset($_SESSION['OTP'])) {
    header("Location: ../Pages/Login.php");
}
?>