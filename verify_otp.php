<?php
session_start();
include('includes/config.php');
$email = $_SESSION['email'];

if (!isset($_SESSION['otp']) || !isset($_SESSION['email'])) {
    header('Location: forgot-password.php');
    exit();
}

if (isset($_POST['verify'])) {
    $enteredOtp = $_POST['otp'];

    if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiry']) && time() <= $_SESSION['otp_expiry']) {
        if ($enteredOtp == $_SESSION['otp']) {
            unset($_SESSION['otp']); // Remove OTP after verification
            unset($_SESSION['otp_expiry']);
            echo "<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>
                    <div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
                        <h3 style='margin:0 0 10px; color:#28a745;'>Success</h3>
                        <p style='margin:0 0 20px; color:#555;'>The OTP you entered is valid.</p>
                        <button style='background:#28a745; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='redirectToSetPasswordPage()'>OK</button>
                    </div>
                </div>
                <script>
                    function redirectToSetPasswordPage() {
                        window.location.href = 'set-forgotpassword.php';
                    }
                </script>";
        } else {
            echo "<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>
                    <div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
                        <h3 style='margin:0 0 10px; color:#dc3545;'>Incorrect</h3>
                        <p style='margin:0 0 20px; color:#555;'>The OTP you entered is invalid. Please try again.</p>
                        <button style='background:#28a745; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='redirectToOtpPage()'>OK</button>
                    </div>
                </div>
                <script>
                    function redirectToOtpPage() {
                        window.location.href = 'verify_otp.php';
                    }
                </script>";
        }
    } else {
        echo "<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>
                <div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
                    <h3 style='margin:0 0 10px; color:#dc3545;'>Expired</h3>
                    <p style='margin:0 0 20px; color:#555;'>The OTP has expired. Please request a new one.</p>
                    <button style='background:#28a745; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='redirectToOtpPage()'>OK</button>
                </div>
            </div>
            <script>
                function redirectToOtpPage() {
                    window.location.href = 'verify_otp.php';
                }
            </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/form.css">
    <title>Verify OTP</title>
</head>

<body class="cnt-home">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="row align-items-center">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="forgot-password.php" style="text-decoration: none;">Home</a></li>
                    <li class='active'>Authentication</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
            <!-- Side Image -->
            <div class="col-md-6 d-none d-md-block">
                <img src="assets/images/sliders/Enter OTP-bro.png" alt="Forgot Password Illustration" class="side-image">
            </div>
            <!-- Form Container -->
            <div class="col-md-6 col-sm-12">
                <div class="form-container">
                    <h3 class="form-title">Verify OTP</h3>
                    <h4 class="">Please enter the OTP sent to your email</h4>
                    <form class="register-form outer-top-xs" method="post">
                        <?php if (isset($error)) {
                            echo "<p style='color: red;'>$error</p>";
                        } ?>
                        <div class="mb-3">
                            <label class="info-title">Email:</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($email); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="otp" class="info-title">Enter OTP:</label>
                            <input type="text" name="otp" class="form-control" required>
                        </div>
                        <button type="submit" class="btn-upper btn btn-primary checkout-page-button" name="verify">Verify OTP</button>
                    </form>
                    <div>OTP expires in <span id="time">01:00</span> minutes.</div>
                    
                    <div id="resend-otp" style="display: none;">
                        <form method="post" action="resend_otp.php">
                            <button type="submit" class="btn btn-secondary" onclick="resetOTP()">Resend OTP</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
   function startTimer(duration, display) {
    // Check if there's an OTP expiry time stored
    var expiryTime = localStorage.getItem('otpExpiryTime');
    var resendBtn = document.getElementById('resend-otp');

    if (!expiryTime) {
        // If no expiry time, set it to 1 minute from now and store it
        expiryTime = Math.floor(Date.now() / 1000) + duration;
        localStorage.setItem('otpExpiryTime', expiryTime);
    }
    // Function to update the timer
    function updateTimer() {
        var currentTime = Math.floor(Date.now() / 1000);
        var timeLeft = expiryTime - currentTime;
        // If OTP expired
        if (timeLeft <= 0) {
            clearInterval(interval);
            localStorage.setItem('otpExpired', 'true'); // Mark OTP as expired
            display.style.display = 'none';
            resendBtn.style.display = 'block'; // Show resend button
            return;
        }

        // Display remaining time in minutes and seconds format
        var minutes = Math.floor(timeLeft / 60);
        var seconds = timeLeft % 60;
        display.textContent = (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
    }

    // If OTP is expired, hide the timer and show resend button
    if (localStorage.getItem('otpExpired') === 'true') {
        display.style.display = 'none';
        resendBtn.style.display = 'block';
    } else {
        // Otherwise, start the timer
        updateTimer();
        var interval = setInterval(updateTimer, 1000);
    }
}
function resetOTP() {
    localStorage.removeItem('otpExpiryTime');
    localStorage.removeItem('otpExpired');

    // Reset the timer and start again
    var oneMinute = 60;
    var display = document.querySelector('#time');
    startTimer(oneMinute, display);

    // Hide resend OTP button after clicking
    document.getElementById('resend-otp').style.display = 'none';
}
// When the page loads, start the timer
window.onload = function() {
    var oneMinute = 60;
    var display = document.querySelector('#time');
    startTimer(oneMinute, display);
};
</script>
</html>