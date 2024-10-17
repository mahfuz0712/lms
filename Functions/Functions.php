<?php
include "../Database/Config.php";
include "../Mailer/Emailer.php";



function CheckUserExists($Email, $PhoneNumber, $conn) {

  // Query to check if the email exists
  $email_check_query = "SELECT * FROM users   WHERE Email = '$Email'";
  $result_email = $conn->query($email_check_query);

  $email_check_query2 = "SELECT * FROM admins   WHERE Email = '$Email'";
  $result_email2 = $conn->query($email_check_query2);
  // Query to check if the phone number exists
  $phone_check_query = "SELECT * FROM users  WHERE PhoneNumber = '$PhoneNumber'";
  $result_phone = $conn->query($phone_check_query);
  $phone_check_query2 = "SELECT * FROM admins  WHERE PhoneNumber = '$PhoneNumber'";
  $result_phone2 = $conn->query($phone_check_query2);
  // Check if email exists
  if ($result_email->num_rows > 0 && $result_email2->num_rows > 0) {
      return true;
  } else {
      return false;
  }
  // Check if phone number exists
  if ($result_phone->num_rows > 0 && $result_phone2->num_rows > 0) {
      return true;
  } else {
      return false;
  }
};



function CheckPasswordAndConfirmPassword($ChoosePassword, $ConfirmPassword) {
    if ($ChoosePassword === $ConfirmPassword) {
      return  true;
    } else {
      return false;
    }
};

function generateUserId() {
  return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT); // Generate a 6-digit number
}



function RegisterUser($UserID, $UserType, $Name, $Email, $PhoneNumber, $ConfirmPassword, $conn) {
  if ($UserType === "admin") {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO admins (AdminID, Name, Email, PhoneNumber, Password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $UserID, $Name, $Email, $PhoneNumber, $ConfirmPassword); // 'sssss' means all string types

    // Execute the statement
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

    // Close the statement and connection
    $stmt->close();

    
  } else {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (UserID, Name, Email, PhoneNumber, Password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $UserID, $Name, $Email, $PhoneNumber, $ConfirmPassword); // 'sssss' means all string types

    // Execute the statement
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

    // Close the statement and connection
    $stmt->close();

  }



}

?>