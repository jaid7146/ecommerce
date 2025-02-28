<?php
session_start();
include('includes/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:/xampp/htdocs/ecommerce-site/PHPMailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/ecommerce-site/PHPMailer/src/SMTP.php';
require 'C:/xampp/htdocs/ecommerce-site/PHPMailer/src/Exception.php';
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $otp = rand(100000, 999999);
    $_SESSION['otp_expiry'] = time() + 60; // OTP expires in 60 seconds
    // Send OTP via email using PHPMailer
    $mail = new PHPMailer(true);
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jaid.sstech@gmail.com';
        $mail->Password   = 'iovk umvg zakd nkxx';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        //Recipients
        $mail->setFrom('jaid.sstech@gmail.com', 'ELECTRONIC STORE');
        $mail->addAddress($email);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = ' Resend Email Verification OTP';
        $mail->Body    = "Your OTP for Email Verification is:<strong style=\"font-size: 130%\">$otp</strong> <br>If you didn't request this, you can ignore this email.<BR><BR><br>Thanks,<br>ELECTRONIC STORE"; 

        $mail->send();
        // Store new OTP in session
        $_SESSION['otp'] = $otp;
        $_SESSION['successmsg'] = "OTP has been resent to your email address.";
        header("Location: verify_otp.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['errmsg'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location: otp_verification.php");
        exit();
    }
} else {
    $_SESSION['errmsg'] = "No email address found. Please register again.";
    header("Location: register.php");
    exit();
}
?>