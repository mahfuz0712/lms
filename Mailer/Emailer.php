<?php
include('smtp/PHPMailerAutoload.php');

function SendEmail($to, $subject, $msg){
    $mail = new PHPMailer(); 
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls';  // Use 'tls' for port 587
    $mail->Host = "smtp-relay.brevo.com";
    $mail->Port = 587;  // Port 587 for TLS
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    
    $mail->Username = "7d1761001@smtp-brevo.com";  // Correct SMTP username
    $mail->Password = 'MwbTPARrEWQO4gtx';  // Correct SMTP password
    
    $mail->SetFrom("mahfuzrahman0712@gmail.com", "Mohammad Mahfuz Rahman");
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->AddAddress($to);
    
    // Optional: Configure SSL options
    $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    ));
    
    // Send email
    if (!$mail->Send()) {
        return false;  // Return false if sending failed
    } else {
        return true;  // Return true if sending succeeded
    }
}
?>
