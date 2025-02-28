<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
	header('location:login.php');
} else {
	// Code for Product deletion from wishlist
	$wid = intval($_GET['del']);
	if (isset($_GET['del'])) {
		$query = mysqli_query($con, "delete from wishlist where id='$wid'");
	}
	if (isset($_GET['action']) && $_GET['action'] == "add") {
		$id = intval($_GET['id']);
		$query = mysqli_query($con, "delete from wishlist where productId='$id'");
		if (isset($_SESSION['cart'][$id])) {
			$_SESSION['cart'][$id]['quantity']++;
		} else {
			$sql_p = "SELECT * FROM products WHERE id={$id}";
			$query_p = mysqli_query($con, $sql_p);
			if (mysqli_num_rows($query_p) != 0) {
				$row_p = mysqli_fetch_array($query_p);
				$_SESSION['cart'][$row_p['id']] = array("quantity" => 1, "price" => $row_p['productPrice']);
				header('location:my-wishlist.php');
			} else {
				$message = "Product ID is invalid";
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
		<title>My Wishlist</title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<!-- Customizable CSS -->
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/red.css">
		<link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="assets/images/">
	</head>

	<body class="cnt-home">
		<header class="header-style-1">
			<?php include('includes/top-header.php'); ?>
			<?php include('includes/main-header.php'); ?>
			<?php include('includes/menu-bar.php'); ?>
		</header>
		<div class="breadcrumb">
			<div class="container">
				<div class="breadcrumb-inner">
					<ul class="list-inline list-unstyled">
						<li><a href="my-account.php">Home</a></li>
						<li class='active'>Wishlist</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="body-content outer-top-bd">
			<div class="container">
				<div class="row d-flex">
					<div class="col-md-8 col-sm-8 col-xs-12">
						<div class="my-wishlist-page inner-bottom-sm">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 my-wishlist">
									<div class="table-responsive">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th colspan="4">My Wishlist</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$ret = mysqli_query($con, "select products.productName as pname,products.productName as proid,products.productImage1 as pimage,products.productPrice as pprice,wishlist.productId as pid,wishlist.id as wid from wishlist join products on products.id=wishlist.productId where wishlist.userId='" . $_SESSION['id'] . "'");
												$num = mysqli_num_rows($ret);
												if ($num > 0) {
													while ($row = mysqli_fetch_array($ret)) {
												?>
														<tr>
															<td class="col-md-2"><img src="admin/productimages/<?php echo htmlentities($row['pid']); ?>/<?php echo htmlentities($row['pimage']); ?>" alt="<?php echo htmlentities($row['pname']); ?>" width="100" height="100"></td>
															<td class="col-md-6">
																<div class="product-name"><a href="product-details.php?pid=<?php echo htmlentities($pd = $row['pid']); ?>"><?php echo htmlentities($row['pname']); ?></a></div>
																<?php $rt = mysqli_query($con, "select * from productreviews where productId='$pd'");
																$num = mysqli_num_rows($rt); {
																?>
																	<div class="rating">
																		<i class="fa fa-star rate"></i>
																		<i class="fa fa-star rate"></i>
																		<i class="fa fa-star rate"></i>
																		<i class="fa fa-star rate"></i>
																		<i class="fa fa-star non-rate"></i>
																		<span class="review">( <?php echo htmlentities($num); ?> Reviews )</span>
																	</div>
																<?php } ?>
																<div class="price">Rs.
																	<?php echo htmlentities($row['pprice']); ?>.00
																	<span class="price-before-discount">Rs.
																		<?php echo htmlentities($rw['productPriceBeforeDiscount']); ?></span>
																</div>
															</td>
															<td class="col-md-2">
																<a href="my-wishlist.php?page=product&action=add&id=<?php echo $row['pid']; ?>" class="btn-upper btn btn-primary">Add to cart</a>
															</td>
															<td class="col-md-2 close-btn">
																<a href="my-wishlist.php?del=<?php echo htmlentities($row['wid']); ?>" onClick="return showCustomConfirm(this.href);" class="btn btn-danger btn-sm close-btn-link">
																	<i class="fa fa-times"></i>
																</a>
															</td>
															<div id="customConfirm" class="custom-confirm">
																<div class="custom-confirm-content">
																	<p>Are you sure you want to remove this item from your wishlist?</p>
																	<div class="custom-confirm-buttons">
																		<button id="confirmYes" class="btn btn-danger">Yes</button>
																		<button id="confirmNo" class="btn btn-secondary">No</button>
																	</div>
																</div>
															</div>
														</tr>
													<?php }
												} else { ?>
													<tr>
														<td style="font-size: 18px; font-weight:bold; text-align: center;">Your Wishlist is Empty</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php include('includes/myaccount-sidebar.php'); ?>
				</div>
			</div>
		</div>
		</div>
		<?php include('includes/footer.php'); ?>
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

			function showCustomConfirm(href) {
				const confirmBox = document.getElementById("customConfirm");
				confirmBox.style.display = "flex";
				document.getElementById("confirmYes").onclick = function() {
					confirmBox.style.display = "none";
					window.location.href = href;
				};
				document.getElementById("confirmNo").onclick = function() {
					confirmBox.style.display = "none";
				};
				return false;
			}
		</script>
	</body>

	</html>
<?php } ?>