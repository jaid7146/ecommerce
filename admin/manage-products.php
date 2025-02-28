<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	date_default_timezone_set('Asia/Kolkata'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());
	if (isset($_GET['del'])) {
		mysqli_query($con, "delete from products where id = '" . $_GET['id'] . "'");
		$_SESSION['delmsg'] = "Product deleted !!";
	}
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin| Manage Products</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"> -->
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
		<link rel="icon"type="image/png" href="assets/images/image_2025_02_10T06_42_49_708Z.png">
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
									<h3>Manage Products</h3>
								</div>
								<div class="module-body table">
									<?php if (isset($_GET['del'])) { ?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?><?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
										</div>
									<?php } ?>

									<br />


									<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Product Image</th>
												<th>Product Name</th>
												<th>Category </th>
												<th>Subcategory</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody>

										<?php 
$query = mysqli_query($con, "SELECT products.id, products.productImage1, products.productName, category.categoryName, subcategory.subcategory 
                             FROM products 
                             JOIN category ON category.id = products.category 
                             JOIN subcategory ON subcategory.id = products.subCategory");

											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
											?>
												<tr>
													<td><?php echo htmlentities($cnt); ?></td>
													<td><img src="productimages/<?php echo htmlentities($row['id'] . "/" . $row['productImage1']); ?>" width="100"></td>

													<td><?php echo htmlentities($row['productName']); ?></td>
													<td><?php echo htmlentities($row['categoryName']); ?></td>
													<td> <?php echo htmlentities($row['subcategory']); ?></td>
													<td>
														<a href="edit-products.php?id=<?php echo $row['id'] ?>"><i class="icon-edit"></i></a>
														<a href="#deleteModal" data-toggle="modal" data-id="<?php echo $row['id'] ?>" class="delete-btn"><i class="icon-remove-sign"></i></a>
													</td>


												</tr>
											<?php $cnt = $cnt + 1;
											} ?>
									</table>
								</div>
							</div>
						</div><!--/.content-->
					</div><!--/.span9-->
				</div>
			</div><!--/.container-->
		</div><!--/.wrapper-->
		<?php include('include/footer.php'); ?>
		<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="deleteModalLabel">Confirm Delete</h3>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete this product?</p>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
				<a href="#" class="btn btn-danger" id="confirmDelete">Delete</a>
			</div>
		</div>
		<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
		<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
		<script src="scripts/datatables/jquery.dataTables.js"></script>
		<script>
			$(document).ready(function() {
				$('.datatable-1').dataTable();
				$('.dataTables_paginate').addClass("btn-group datatable-pagination");
				$('.dataTables_paginate > a').wrapInner('<span />');
				$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
				$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
				// Handle delete button click
				$('.delete-btn').on('click', function() {
					var id = $(this).data('id');
					$('#confirmDelete').attr('href', 'manage-products.php?id=' + id + '&del=delete');
				});
			});
		</script>
	</body>
<?php } ?>
