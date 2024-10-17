<?php
include "../Database/Config.php";
include "../Sessions/NotOTP.php";
include "../Functions/Functions.php";
// Initialize the variables
$Developer = "Mohammad Mahfuz Rahman";
$valid_otp =  $_SESSION['OTP'];
$UserID = $_SESSION['UserID'];
$Name = $_SESSION['Name'];
$Email = $_SESSION['Email'];
$PhoneNumber = $_SESSION['PhoneNumber'];
$UserType = $_SESSION['UserType'];
$ConfirmPassword = $_SESSION['ConfirmPassword'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['OTPEntered'])) {
    // Sanitize the OTP input
    $entered_otp = $_POST['otp'];
    // Validate the OTP
    if ($entered_otp == $valid_otp) {

        $UserRegistered = RegisterUser($UserID, $UserType, $Name, $Email, $PhoneNumber, $ConfirmPassword, $conn);
        if ($UserRegistered) {
            // Redirect to the login page
            header("Location: ./Login.php");
        }

    } else {
        echo "<script>alert('Invalid OTP')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .otp-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .otp-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .otp-input {
            padding: 10px;
            width: 100%;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .otp-submit {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .otp-submit:hover {
            background-color: #218838;
        }

        .message {
            margin-top: 15px;
            font-size: 14px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>

<div class="otp-container">
    <h2>Enter OTP</h2>
    
    <!-- OTP Form -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="text" name="otp" class="otp-input" placeholder="Enter OTP" required>
        <input type="submit" name="OTPEntered" class="otp-submit" />
    </form>
    <p>This System Was Developed by <?php echo $Developer?></p>

 
    
</div>

</body>
</html>
