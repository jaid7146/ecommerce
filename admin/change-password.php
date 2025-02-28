<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	date_default_timezone_set('Asia/Kolkata'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());
	if (isset($_POST['submit'])) {
		$sql = mysqli_query($con, "SELECT password FROM admin WHERE password='" . md5($_POST['password']) . "' AND username='" . $_SESSION['alogin'] . "'");
		$num = mysqli_fetch_array($sql);
		if ($num) {
			mysqli_query($con, "UPDATE admin SET password='" . md5($_POST['newpassword']) . "', updationDate='$currentTime' WHERE username='" . $_SESSION['alogin'] . "'");
			$_SESSION['msg'] = "Password Changed Successfully !!";
		} else {
			$_SESSION['msg'] = "Old Password not match !!";
		}
	}
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin| Change Password</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"> -->
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
		<link rel="icon"type="image/png" href="assets/images/image_2025_02_10T06_42_49_708Z.png">

		<script type="text/javascript">
			function valid() {
				if (document.chngpwd.password.value == "") {
					showCustomAlert("Error", "Current Password Field is Empty !!");
					document.chngpwd.password.focus();
					return false;
				} else if (document.chngpwd.newpassword.value == "") {
					showCustomAlert("Error", "New Password Field is Empty !!");
					document.chngpwd.newpassword.focus();
					return false;
				} else if (document.chngpwd.confirmpassword.value == "") {
					showCustomAlert("Error", "Confirm Password Field is Empty !!");
					document.chngpwd.confirmpassword.focus();
					return false;
				} else if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
					showCustomAlert("Error", "Password and Confirm Password Field do not match  !!");
					document.chngpwd.confirmpassword.focus();
					return false;
				}
				return true;
			}
			function showCustomAlert(title, message) {
				var alertHtml = "<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>" +
					"<div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>" +
					"<h3 style='margin:0 0 10px; color:#333;'>" + title + "</h3>" +
					"<p style='margin:0 0 20px; color:#555;'>" + message + "</p>" +
					"<button style='background:#dc3545; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='closeAlert()'>OK</button>" +
					"</div></div>";
				document.body.insertAdjacentHTML('beforeend', alertHtml);
			}

			function closeAlert() {
				document.getElementById("custom-alert").style.display = "none";
			}
		</script>
	</head>

	<body>
		<?php include('include/header.php'); ?>

		<div class="wrapper">
			<div class="container">
				<div class="row">
					<?php include('include/sidebar.php'); ?>
					<div class="span9">
						<div class="content">

							<div class="module">
								<div class="module-head">
									<h3>Admin Change Password</h3>
								</div>
								<div class="module-body">
									<?php if (isset($_POST['submit'])) { ?>
										<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?>
										</div>
										<script type="text/javascript">
											setTimeout(function() {
												document.querySelector('.alert').style.display = 'none';
											}, 3000); // Hide the alert after 3 seconds
										</script>
									<?php } ?>
									<br />
									<form class="form-horizontal row-fluid" name="chngpwd" method="post" onSubmit="return valid();">
										<div class="control-group">
											<label class="control-label" for="basicinput">Current Password</label>
											<div class="controls">
												<input type="password" placeholder="Enter your current Password" name="password" class="span8 tip" required>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">New Password</label>
											<div class="controls">
												<input type="password" placeholder="Enter your new current Password" name="newpassword" class="span8 tip" required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Current Password</label>
											<div class="controls">
												<input type="password" placeholder="Enter your new Password again" name="confirmpassword" class="span8 tip" required>
											</div>
										</div>
										<div class="control-group">
											<div class="controls">
												<button type="submit" name="submit" class="btn" style="background-color: #248aaf; border-color: #20799a; color: white;">Submit</button>
											</div>
										</div>
									</form>
								</div>
							</div>



						</div><!--/.content-->
					</div><!--/.span9-->
				</div>
			</div><!--/.container-->
		</div><!--/.wrapper-->

		<?php include('include/footer.php'); ?>

		<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
		<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
	</body>
<?php } ?>