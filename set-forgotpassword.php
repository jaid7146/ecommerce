<?php
session_start();
error_reporting(0);
include('includes/config.php');
// Include PHPMailer files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:/xampp/htdocs/ecommerce-site/PHPMailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/ecommerce-site/PHPMailer/src/SMTP.php';
require 'C:/xampp/htdocs/ecommerce-site/PHPMailer/src/Exception.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['mobile'])) {
    header('Location: forgot-password.php'); // Redirect if session data is missing
    exit();
}
$email = $_SESSION['email'];
$mobile = $_SESSION['mobile'];

if (isset($_POST['reset'])) {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        $hashedPassword = md5($newPassword); // Hash password using MD5

        // Update password in the database
        $stmt = $con->prepare("UPDATE users SET password = ? WHERE email = ? AND contactno = ?");
        $stmt->bind_param("sss", $hashedPassword, $email, $mobile);
        
        if ($stmt->execute()) {
            unset($_SESSION['email']);
            unset($_SESSION['mobile']);
            // Send confirmation email using PHPMailer
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'jaid.sstech@gmail.com';  
                $mail->Password = 'iovk umvg zakd nkxx';  
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('jaid.sstech@gmail.com', 'ELECTRONIC STORE');
                $mail->addAddress($email);  

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Successful';
                $mail->Body = '<h2>Password Reset Successful</h2><p>Your password has been updated successfully. You can now log in with your new password.</p>';
                $mail->AltBody = 'Your password has been reset successfully. You can now log in with your new password.';

                $mail->send();
                echo "<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>
                <div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
                    <h3 style='margin:0 0 10px; color:#333;'>Success</h3>
                    <p style='margin:0 0 20px; color:#555;'>Your password has been successfully changed</p>
                    <button style='background:#28a745; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='redirectToOtpPage()'>OK</button>
                </div>
            </div>
            <script>
                function redirectToOtpPage() {
                    window.location.href = 'login.php';
                }
            </script>";
            } catch (Exception $e) {
                $_SESSION['forgotmsg'] = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                header("Location: forgot-password.php");
                exit();
            }
        } else {
            $error = "Something went wrong. Please try again.";
        }
        $stmt->close();
    } else {
        $error = "Passwords do not match!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/form.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function checkPasswordStrength() {
            const password = document.getElementById("new_password").value;
            const strengthBar = document.getElementById("passwordStrength");
            const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;

            if (strongRegex.test(password)) {
                strengthBar.innerHTML = '<span class="text-success">Strong Password</span>';
            } else if (password.length >= 6) {
                strengthBar.innerHTML = '<span class="text-warning">Moderate Password</span>';
            } else {
                strengthBar.innerHTML = '<span class="text-danger">Weak Password</span>';
            }
        }
        function matchPasswords() {
            const password = document.getElementById("new_password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            const matchMessage = document.getElementById("passwordMatch");

            if (password === confirmPassword && password !== "") {
                matchMessage.innerHTML = '<span class="text-success">Passwords match</span>';
            } else {
                matchMessage.innerHTML = '<span class="text-danger">Passwords do not match</span>';
            }
        }
    </script>
</head>
<body class="cnt-home">
	<div class="container d-flex justify-content-center align-items-center">
		<div class="row align-items-center">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
                <li><a href="forgot-password.php" style="text-decoration: none;">Home</a></li>
                <li class='active'>Authentication</li>
				</ul>
			</div>
			<div class="col-md-6 d-none d-md-block">
				<img src="assets/images/sliders/Forgot password-bro.png" alt="Forgot Password Illustration" class="side-image">
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-container">
					<h3 class="form-title">Forgot Password</h3>
                <?php if (isset($error)) { echo "<p class='alert alert-danger'>$error</p>"; } ?>
                
                <form method="post" class="register-form outer-top-xs">
                    <div class="mb-3">
                        <label class="info-title">Email:</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($email); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="info-title">Mobile:</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($mobile); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="info-title">New Password:</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required onkeyup="checkPasswordStrength(); matchPasswords();">
                        <div id="passwordStrength" class="password-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="info-title">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required onkeyup="matchPasswords();">
                        <div id="passwordMatch" class="password-feedback"></div>
                    </div>

                    <button type="submit" name="reset"  class="btn-upper btn btn-primary checkout-page-button">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
