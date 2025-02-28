<?php
session_start();
error_reporting(0);
include('includes/config.php');
// Code user Registration
if (isset($_POST['submit'])) {
    $name = $_POST['fullname'];
    $email = $_POST['emailid'];
    $contactno = $_POST['contactno'];
    $password = md5($_POST['password']);
    $query = mysqli_query($con, "insert into users(name,email,contactno,password) values('$name','$email','$contactno','$password')");
    if ($query) {
        echo "<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>
        <div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
            <h3 style='margin:0 0 10px; color:#333;'>Success</h3>
            <p style='margin:0 0 20px; color:#555;'>You are successfully registered</p>
            <button style='background:#28a745; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='closeAlert()'>OK</button>
        </div>
    </div>
    <script>
        function closeAlert() {
            document.getElementById(\"custom-alert\").style.display = \"none\";
            window.location.href = 'login.php';
        }
         setTimeout(function() {
            window.location.href = 'login.php';
         }, 2000);
    </script>";
    } else {
        echo "<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>
        <div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
            <h3 style='margin:0 0 10px; color:#dc3545;'>Incorrect</h3>
            <p style='margin:0 0 20px; color:#555;'>Registration failed. Something went wrong.</p>
            <button style='background:#dc3545; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='closeAlert()'>OK</button>
        </div>
    </div>
    <script>
        function closeAlert() {
            document.getElementById(\"custom-alert\").style.display = \"none\";
        }
    </script>";
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
    <title>ELECTRONIC STORE | Signi-in | Signup</title>
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/form.css">
    <!-- Demo Purpose Only. Should be removed in production : END -->
    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/form.css">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <!-- Favicon -->
	<link rel="shortcut icon" href="assets/images/image_2025_02_10T06_42_49_708Z.png">
</head>
<script>
    function userAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check_availability.php",
            data: 'email=' + $("#email").val(),
            type: "POST",
            success: function(data) {
                $("#user-availability-status1").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
</script>
</head>
<body class="cnt-home">
    <!-- ============================================== HEADER ============================================== -->
    <header class="header-style-1">

        <!-- ============================================== TOP MENU ============================================== -->
        <?php
        // include('includes/top-header.php'); 
        ?>
        <!-- ============================================== TOP MENU : END ============================================== -->
        <?php
        // include('includes/main-header.php');
        ?>
        <!-- ============================================== NAVBAR ============================================== -->
        <?php
        // include('includes/menu-bar.php'); 
        ?>
        <!-- ============================================= NAVBAR : END ============================================== -->
    </header>
    <!-- ============================================== HEADER : END ============================================== -->
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
                <img src="assets/images/sliders/Account-bro.png" alt="Forgot Password Illustration" class="side-image">
            </div>
            <!-- Form Container -->
            <div class="col-md-6 col-sm-12">
                <div class="form-container">
                    <h3 class="form-title">Create a new account</h3>
                    <h4 class="">Create your own Shopping account</h4>
                    <form class="register-form outer-top-xs" role="form" method="post" name="register" onSubmit="return valid();">
                        <div class="form-group">
                            <label class="info-title" for="fullname">Full Name <span>*</span></label>
                            <input type="text" class="form-control unicase-form-control text-input" id="fullname" name="fullname" required="required">
                        </div>
                        <div class="form-group">
                            <label class="info-title" for="exampleInputEmail2">Email Address <span>*</span></label>
                            <input type="email" class="form-control unicase-form-control text-input" id="email" onBlur="userAvailability()" name="emailid" required>
                            <!-- <small>Your email is safe with us.</small> -->
                            <span id="user-availability-status1" style="font-size:12px;"></span>
                        </div>
                        <div class="form-group">
                            <label class="info-title" for="contactno">Contact No. <span>*</span></label>
                            <input type="bigint" class="form-control unicase-form-control text-input" id="contactno" name="contactno" maxlength="10" required>
                            <!-- <small>Your Contact No is safe with us.</small> -->
                        </div>
                        <div class="form-group">
                            <label class="info-title" for="password">Password. <span>*</span></label>
                            <input type="password" class="form-control unicase-form-control text-input" id="password" name="password" required>
                            <!-- <small>Your Password is safe with us.</small> -->
                        </div>

                        <div class="form-group">
                            <label class="info-title" for="confirmpassword">Confirm Password. <span>*</span></label>
                            <input type="password" class="form-control unicase-form-control text-input" id="confirmpassword" name="confirmpassword" required>
                            <!-- <small>Enter Confirm your Password</small> -->
                        </div>
                        <p>Already have an account? <a href="login.php" style="text-decoration: none;">Sign in here</a></p>
                        <button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button" id="submit">Sign Up</button>
                    </form>
                    
                </div>
                <!-- create a new account -->
            </div><!-- /.row -->
        </div>
    </div>
    </div>
    <?php
    // include('includes/footer.php'); 
    ?>
    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/echo.min.js"></script>
    <script src="assets/js/jquery.easing-1.3.min.js"></script>
    <script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="assets/js/lightbox.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="switchstylesheet/switchstylesheet.js"></script>
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
    <script type="text/javascript">
        function valid() {
            if (document.register.password.value != document.register.confirmpassword.value) {
                // Create custom alert message
                const alertDiv = document.createElement("div");
                alertDiv.id = "custom-alert";
                alertDiv.style.cssText =
                    "display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;";
                alertDiv.innerHTML = `
                <div style="background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;">
                    <h3 style="margin:0 0 10px; color:#dc3545;">Incorrect</h3>
                    <p style="margin:0 0 20px; color:#555;">Password and Confirm Password do not match!</p>
                    <button style="background:#dc3545; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;" onclick="closeAlert()">OK</button>
                </div> `;
                document.body.appendChild(alertDiv);
                // Focus on Confirm Password field
                document.register.confirmpassword.focus();
                return false;
            }
            return true;
        }

        function closeAlert() {
            document.getElementById("custom-alert").remove();
        }
    </script>
</body>

</html>