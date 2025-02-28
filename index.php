<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_GET['action']) && $_GET['action'] == "add") {
	$id = intval($_GET['id']);
	if (isset($_SESSION['cart'][$id])) {
		$_SESSION['cart'][$id]['quantity']++;
	} else {
		$sql_p = "SELECT * FROM products WHERE id={$id}";
		$query_p = mysqli_query($con, $sql_p);
		if (mysqli_num_rows($query_p) != 0) {
			$row_p = mysqli_fetch_array($query_p);
			$_SESSION['cart'][$row_p['id']] = array("quantity" => 1, "price" => $row_p['productPrice']);
		} else {
			$message = "Product ID is invalid";
		}
	}
	// Trigger the custom alert box
	echo "<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>
		<div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
			<h3 style='margin:0 0 10px; color:#333;'>Success</h3>
			<p style='margin:0 0 20px; color:#555;'>Product has been added to the cart</p>
			<button style='background:#28a745; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='closeAlert()'>OK</button>
		</div>
	</div>
	<script>
		function closeAlert() {
			document.getElementById(\"custom-alert\").style.display = \"none\";
			window.location.href = 'my-cart.php';
		}
	</script>";
}
if (isset($_SESSION['successmsg'])) {
	echo "
		<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>
			<div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
				<h3 style='margin:0 0 10px; color:#333;'>Welcome</h3>
				<p style='margin:0 0 20px; color:#555;'>" . $_SESSION['successmsg'] . "</p>
				<button style='background:#28a745; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='closeAlert()'>OK</button>
			</div>
		</div>
		<script>
			function closeAlert() {
				document.getElementById(\"custom-alert\").style.display = \"none\";
			}
		</script>";
	unset($_SESSION['successmsg']);
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
	<title>electonic store home page</title>
	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- Customizable CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/red.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/owl.transitions.css">
	<link rel="stylesheet" href="assets/css/owl.theme.css">
	<link href="assets/css/lightbox.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/rateit.css">
	<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/images/image_2025_02_10T06_42_49_708Z.png">
</head>
<body class="cnt-home">
	<!-- ============================================== HEADER ============================================== -->
	<header class="header-style-1">
		<?php include('includes/top-header.php'); ?>
		<?php include('includes/main-header.php'); ?>
		<?php include('includes/menu-bar.php'); ?>
	</header>
	<!-- ============================================== HEADER : END ============================================== -->
	<div class="body-content outer-top-xs" id="top-banner-and-menu">
		<div class="container">
			<div class="furniture-container homepage-container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-3 sidebar">
						<!-- ================================== TOP NAVIGATION ================================== -->
						<?php
						include('includes/side-menu.php');
						?>
						<!-- ================================== TOP NAVIGATION : END ================================== -->
					</div><!-- /.sidemenu-holder -->
					<div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
						<!-- ========================================== SECTION – HERO ========================================= -->
						<div id="hero" class="homepage-slider3">
							<div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
								<div class="full-width-slider">
									<div class="item" style="background-image: url(assets/images/sliders/HP_Rotating_Vivo_17Dec2024_eqldkg.webp);">
										<!-- /.container-fluid -->
									</div><!-- /.item -->
								</div><!-- /.full-width-slider -->
								<div class="full-width-slider">
									<div class="item full-width-slider" style="background-image: url(assets/images/sliders/laptop.webp);">
									</div><!-- /.item -->
								</div><!-- /.full-width-slider -->
							</div><!-- /.owl-carousel -->
						</div>
						<!-- ========================================= SECTION – HERO : END ========================================= -->
						<!-- ============================================== INFO BOXES ============================================== -->
						<div class="info-boxes wow fadeInUp">
							<div class="info-boxes-inner">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-lg-4">
										<div class="info-box">
											<div class="row">
												<div class="col-xs-2">
													<i class="icon fa fa-dollar"></i>
												</div>
												<div class="col-xs-10">
													<h4 class="info-box-heading green">money back</h4>
												</div>
											</div>
											<h6 class="text">30 Days Money Back Guarantee</h6>
										</div>
									</div><!-- .col -->
									<div class="col-md-4 col-sm-4 col-lg-4">
										<div class="info-box">
											<div class="row">
												<div class="col-xs-2">
													<i class="icon fa fa-truck"></i>
												</div>
												<div class="col-xs-10">
													<h4 class="info-box-heading orange">free shipping</h4>
												</div>
											</div>
											<h6 class="text">free ship-on oder over Rs. 600.00</h6>
										</div>
									</div><!-- .col -->
									<div class="col-md-4 col-sm-4 col-lg-4">
										<div class="info-box">
											<div class="row">
												<div class="col-xs-2">
													<i class="icon fa fa-gift"></i>
												</div>
												<div class="col-xs-10">
													<h4 class="info-box-heading red">Special Sale</h4>
												</div>
											</div>
											<h6 class="text">All items-sale up to 20% off </h6>
										</div>
									</div><!-- .col -->
								</div><!-- /.row -->
							</div><!-- /.info-boxes-inner -->
						</div><!-- /.info-boxes -->
						<!-- ============================================== INFO BOXES : END ============================================== -->
					</div><!-- /.homebanner-holder -->
				</div><!-- /.row -->
				<!-- ============================================== SCROLL TABS ============================================== -->
				<div id="product-tabs-slider" class="scroll-tabs inner-bottom-vs  wow fadeInUp">
					<div class="more-info-tab clearfix">
						<h3 class="new-product-title pull-left">Featured Products</h3>
						<ul class="nav nav-tabs nav-tab-line pull-right" id="new-products-1">
							<li class="active"><a href="#all" data-toggle="tab"></a></li>
						</ul>
					</div>
					<div class="tab-content outer-top-xs">
						<div class="tab-pane in active" id="all">
							<div class="product-slider">
								<div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">
									<?php
									$ret = mysqli_query($con, "SELECT * from products");
									while ($row = mysqli_fetch_array($ret)) {
									?>
										<div class="item item-carousel">
											<div class="products">
												<div class="product">
													<div class="product-image">
														<div class="image">
															<a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>">
																<img src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" width="180" height="200" alt=""></a>
														</div><!-- /.image -->
													</div><!-- /.product-image -->
													<div class="product-info text-left">
														<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['productName']); ?></a></h3>
														<div class="rating rateit-small"></div>
														<div class="description"></div>

														<div class="product-price">
															<span class="price">
																Rs.<?php echo htmlentities($row['productPrice']); ?> </span>
															<span class="price-before-discount">Rs.<?php echo htmlentities($row['productPriceBeforeDiscount']); ?> </span>

														</div><!-- /.product-price -->
													</div><!-- /.product-info -->
													<?php if ($row['productAvailability'] == 'In Stock') { ?>
														<div class="action"><a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" class="lnk btn btn-primary">Add to Cart</a></div>
													<?php } else { ?>
														<div class="action" style="color:red">Out of Stock</div>
													<?php } ?>
												</div><!-- /.product -->

											</div><!-- /.products -->
										</div><!-- /.item -->
									<?php } ?>

								</div><!-- /.home-owl-carousel -->
							</div><!-- /.product-slider -->
						</div>
					</div>
				</div>
				<!-- ============================================== TABS ============================================== -->
				<div class="sections prod-slider-small outer-top-small">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<section class="section" style="margin-bottom: 20px; border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
								<h3 class="section-title" style="margin-bottom: 15px;">Smart Phones</h3>
								<div class="owl-carousel homepage-owl-carousel custom-carousel outer-top-xs owl-theme" data-item="2">
									<?php
									$ret = mysqli_query($con, "SELECT * from products where category=1 and subCategory=1");
									while ($row = mysqli_fetch_array($ret)) {
									?>
										<div class="item item-carousel">
											<div class="products">
												<div class="product">
													<div class="product-image">
														<div class="image">
															<a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><img src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" width="180" height="250"></a>
														</div><!-- /.image -->
													</div><!-- /.product-image -->
													<div class="product-info text-left">
														<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['productName']); ?></a></h3>
														<div class="rating rateit-small"></div>
														<div class="description"></div>
														<div class="product-price">
															<span class="price">
																Rs. <?php echo htmlentities($row['productPrice']); ?> </span>
															<span class="price-before-discount">Rs.<?php echo htmlentities($row['productPriceBeforeDiscount']); ?></span>
														</div>
													</div>
													<?php if ($row['productAvailability'] == 'In Stock') { ?>
														<div class="action"><a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" class="lnk btn btn-primary">Add to Cart</a></div>
													<?php } else { ?>
														<div class="action" style="color:red">Out of Stock</div>
													<?php } ?>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</section>
						</div>
						<div class="col-md-6 col-sm-12 hidden-xs">
							<section class="section" style="margin-bottom: 20px; border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
								<h3 class="section-title" style="margin-bottom: 15px;">LAPTOP</h3>
								<div class="owl-carousel homepage-owl-carousel custom-carousel outer-top-xs owl-theme" data-item="2">
									<?php
									$ret = mysqli_query($con, "SELECT * from products where category=3 and subCategory=10");
									while ($row = mysqli_fetch_array($ret)) {
									?>
										<div class="item item-carousel">
											<div class="products">
												<div class="product">
													<div class="product-image">
														<div class="image">
															<a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><img src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" width="180" height="250"></a>
														</div><!-- /.image -->
													</div><!-- /.product-image -->
													<div class="product-info text-left">
														<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['productName']); ?></a></h3>
														<div class="rating rateit-small"></div>
														<div class="description"></div>
														<div class="product-price">
															<span class="price">
																Rs. <?php echo htmlentities($row['productPrice']); ?> </span>
															<span class="price-before-discount">Rs.<?php echo htmlentities($row['productPriceBeforeDiscount']); ?></span>
														</div>
													</div>
													<?php if ($row['productAvailability'] == 'In Stock') { ?>
														<div class="action"><a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" class="lnk btn btn-primary">Add to Cart</a></div>
													<?php } else { ?>
														<div class="action" style="color:red">Out of Stock</div>
													<?php } ?>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</section>
						</div>
					</div>
				</div>

				<!-- ============================================== TABS : END ============================================== -->

				<?php // include('includes/brands-slider.php'); 
				?>
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
		<!-- For demo purposes – can be removed on production -->
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
</body>

</html>
<?php
