<?php
include('includes/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/htdocs/ecommerce-site/PHPMailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/ecommerce-site/PHPMailer/src/SMTP.php';
require 'C:/xampp/htdocs/ecommerce-site/PHPMailer/src/Exception.php';

if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	// Check if email and mobile are in the database
	$stmt = $con->prepare("SELECT * FROM users WHERE email = ? AND contactno = ?");
	$stmt->bind_param("ss", $email, $mobile);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		// Generate OTP
		$otp = rand(100000, 999999);
		// Save OTP to session
		session_start();
		$_SESSION['otp'] = $otp;
		$_SESSION['otp_expiry'] = time() + 60;// Set expiry time (current time + 60 seconds)

		$_SESSION['email'] = $email;
		$_SESSION['mobile'] = $mobile;

		// Send OTP to email via SMTP
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
			$mail->Subject = 'Email Verification OTP';
			$mail->Body    = "Your OTP for Email Verification is:<strong style=\"font-size: 130%\">$otp</strong> <br>If you didn't request this, you can ignore this email.<BR><BR><br>Thanks,<br>ELECTRONIC STORE"; 
			$mail->send();
			// Redirect to verify_otp.php
			echo "<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>
		<div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
			<h3 style='margin:0 0 10px; color:#333;'>OTP Sent</h3>
			<p style='margin:0 0 20px; color:#555;'>An OTP has been sent to your email. Please check your email and enter the OTP on the next page.</p>
			<button style='background:#28a745; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='redirectToOtpPage()'>OK</button>
		</div>
	</div>
	<script>
		function redirectToOtpPage() {
			window.location.href = 'verify_otp.php';
		}
	</script>";
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	} else {
		echo "<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>
        <div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
            <h3 style='margin:0 0 10px; color:#333;'>Incorrect</h3>
			<p style='margin:0 0 20px; color:#555;'>The email or mobile number you entered is incorrect. Please try again.</p>
            <button style='background:#dc3545; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='closeAlert()'>OK</button>
        </div>
    </div>
    <script>
        function closeAlert() {
            document.getElementById(\"custom-alert\").style.display = \"none\";
        }
    </script>";	}
	$stmt->close();
	$con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keywords" content="MediaCenter, Template, eCommerce">
	<meta name="robots" content="all">
	<title>ELECTRONIC STORE | Forgot Password</title>
	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/form.css">
</head>
<body class="cnt-home">
	<div class="container d-flex justify-content-center align-items-center">
		<div class="row align-items-center">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
					<li><a href="login.php" style="text-decoration: none;">Home</a></li>
					<li class='active'>Authentication</li>
				</ul>
			</div>
			<div class="col-md-6 d-none d-md-block">
				<img src="assets/images/sliders/Email capture-bro.png" alt="Forgot Password Illustration" class="side-image">
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-container">
					<h3 class="form-title">Forgot Password</h3>
					<form method="POST" action="forgot-password.php" class="register-form outer-top-xs" method="post">
						<div class="mb-3">
							<label class="info-title" for="email">Email Address<span>*</span></label>
							<input type="email" id="email" name="email" class="form-control" required><br>
						</div>
						<div class="mb-3">
							<label for="mobile" class="info-title" for="mobile" class="form-label">Mobile Number:</label>
							<input type="text" id="mobile" name="mobile" class="form-control" required><br>
						</div>
						<button type="submit" class="btn-upper btn btn-primary checkout-page-button" name="submit">Send OTP</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>