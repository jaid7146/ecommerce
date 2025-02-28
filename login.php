<?php
session_start();
error_reporting(0);
include('includes/config.php');
// Handle login request
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    // First, try to login as a regular user
    $query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'");
    $num = mysqli_fetch_array($query);
    // If user credentials are valid
    if ($num > 0) {
        $_SESSION['login'] = $_POST['email'];
        $_SESSION['id'] = $num['id'];
        $_SESSION['username'] = $num['name'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 1;
        $log = mysqli_query($con, "INSERT INTO userlog(userEmail, userip, status) VALUES('" . $_SESSION['login'] . "', '$uip', '$status')");

        $_SESSION['successmsg'] = "Login successful! Welcome, <strong>" . $_SESSION['username'] . "</strong>.";
        header("location:index.php");
        exit();
    } else {
        // If user credentials are not valid, check if it's an admin login
        $ret = mysqli_query($con, "SELECT * FROM admin WHERE username='$email' AND password='$password'");
        $num = mysqli_fetch_array($ret);
        // If admin credentials are valid
        if ($num > 0) {
            $_SESSION['alogin'] = $_POST['email'];
            $_SESSION['admin_id'] = $num['admin_id'];
            header("location:admin/change-password.php");
            exit();
        } else {
            // If both user and admin credentials are invalid
            $_SESSION['errmsg'] = "Invalid email or password.";
            header("location:login.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title>ELECTRONIC STORE |Signup</title>
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/form.css">
    <!-- Customizable CSS -->
</head>
<body class="cnt-home">
    <!-- ============================================= HEADER : END  ============================================== -->
    <div class="container d-flex justify-content-center align-items-center">
        <div class="row align-items-center">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="index.php" style="text-decoration: none;">Home</a></li>
                    <li class='active'>Authentication</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
            <!-- Side Image -->
            <div class="col-md-6 d-none d-md-block">
                <img src="assets/images/sliders/Mobile login-bro.png" alt="Forgot Password Illustration" class="side-image">
            </div>
            <!-- Form Container -->
            <div class="col-md-6 col-sm-12">
                <div class="form-container">
                    <h3 class="form-title">Sign In</h3>
                    <h4 class="">Hello, Welcome to your account.</h4>
                    <form class="register-form outer-top-xs" method="post">
                        <?php
                        // Check for success message
                        if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != "") { ?>
                            <div id="custom-alert" style="display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
                                <div style="background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;">
                                    <h3 style="margin:0 0 10px; color:#28a745;">Success</h3>
                                    <p style="margin:0 0 20px; color:#555;"><?php echo htmlentities($_SESSION['success_message']); ?></p>
                                    <button style="background:#28a745; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;" onclick="closeAlert()">OK</button>
                                </div>
                            </div>
                            <script>
                                function closeAlert() {
                                    document.getElementById("custom-alert").style.display = "none";
                                }
                                // Automatically redirect to login page after 3 seconds
                                setTimeout(function() {
                                    document.getElementById("custom-alert").style.display = "none";
                                }, 3000);
                            </script>
                            <?php $_SESSION['success_message'] = ""; ?>
                        <?php } ?>
                        <?php
                        // Check for error message
                        if (isset($_SESSION['errmsg']) && $_SESSION['errmsg'] != "") { ?>
                            <div id="custom-alert" style="display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;">
                                <div style="background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;">
                                    <h3 style="margin:0 0 10px; color:#dc3545;">Error</h3>
                                    <p style="margin:0 0 20px; color:#555;"><?php echo htmlentities($_SESSION['errmsg']); ?></p>
                                    <button style="background:#dc3545; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;" onclick="closeAlert()">OK</button>
                                </div>
                            </div>
                            <script>
                                function closeAlert() {
                                    document.getElementById("custom-alert").style.display = "none";
                                }
                            </script>
                            <?php $_SESSION['errmsg'] = ""; ?>
                        <?php } ?>
                        <div class="mb-3">
                            <label class="info-title" for="exampleInputEmail1">Email Address/Username<span>*</span></label>
                            <input type="text" name="email" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                            <label class="info-title" for="exampleInputPassword1">Password <span>*</span></label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="radio outer-xs">
                            <a href="forgot-password.php" class="forgot-password pull-right" style="text-decoration: none;">Forgot your Password?</a>
                            <p>Not registered? <a href="register.php" style="text-decoration: none;">Create an account</a></p>
                        </div>
                        <button type="submit" class="btn-upper btn btn-primary checkout-page-button" name="login">Login</button>
                    </form>
                </div>
                <!-- Sign-in -->
                <!-- create a new account -->
            </div><!-- /.row -->
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".changecolor").switchstylesheet({
                seperator: "color"
            });
            $('.show-theme-options').click(function() {
                $(this).parent().toggleClass('open');
                return false;
            });
        });
        $(window).bind("load", function() {
            $('.show-theme-options').delay(2000).trigger('click');
        });
    </script>
</body>
</html>