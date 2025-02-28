<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	date_default_timezone_set('Asia/Kolkata'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());
	if (isset($_POST['submit'])) {
		$category = $_POST['category'];
		$description = $_POST['description'];
		$categoryImage = $_FILES['categoryImage']['name'];
		$tempName = $_FILES['categoryImage']['tmp_name'];
		$folder = "uploads/category/" . $categoryImage;
	
		if (!is_dir('uploads/category')) {
			mkdir('uploads/category', 0777, true);
		}
		// Move the uploaded file to the desired folder
		if (move_uploaded_file($tempName, $folder)) {
			$sql = mysqli_query($con, "INSERT INTO category(categoryName, categoryDescription, categoryImage) VALUES('$category', '$description', '$categoryImage')");
			$_SESSION['msg'] = "Category Created !!";
		} else {
			$_SESSION['msg'] = "Failed to upload image!";
		}
	}
	if (isset($_GET['del'])) {
		$id = intval($_GET['id']); // Sanitize the id

		// Fetch the image file name
		$query = mysqli_query($con, "SELECT categoryImage FROM category WHERE id = '$id'");
		$row = mysqli_fetch_array($query);

		if ($row) {
			$imagePath = "uploads/category/" . $row['categoryImage'];
			
			// Delete the image file if it exists
			if (file_exists($imagePath)) {
				unlink($imagePath);
			}

			// Delete the category from the database
			mysqli_query($con, "DELETE FROM category WHERE id = '$id'");
			$_SESSION['delmsg'] = "Category and image deleted !!";
		} else {
			$_SESSION['delmsg'] = "Category not found !!";
		}

		// Redirect to avoid repeated deletion on refresh
		header('location:category.php');
		exit();
	}
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin| Category</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
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
									<h3>Category</h3>
								</div>
								<div class="module-body">

									<?php if (isset($_POST['submit'])) { ?>
										<div class="alert alert-success">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Well done!</strong><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?>
										</div>
										<script type="text/javascript">
											setTimeout(function() {
												document.querySelector('.alert').style.display = 'none';
											}, 3000); // Hide the alert after 3 seconds
										</script>
									<?php } ?>
									<?php if (isset($_GET['del'])) { ?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?><?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
										</div>
										<script type="text/javascript">
											setTimeout(function() {
												document.querySelector('.alert').style.display = 'none';
											}, 3000); // Hide the alert after 3 seconds
										</script>
									<?php } ?>

									<br />
									<form class="form-horizontal row-fluid" name="Category" method="post" enctype="multipart/form-data">
    <div class="control-group">
        <label class="control-label" for="basicinput">Category Name</label>
        <div class="controls">
            <input type="text" placeholder="Enter category Name" name="category" class="span8 tip" required>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="basicinput">Description</label>
        <div class="controls">
            <textarea class="span8" name="description" rows="3"></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="basicinput">Category Image</label>
        <div class="controls">
            <input type="file" name="categoryImage" class="span8 tip" accept="image/*" required>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" name="submit" class="btn btn-primary">Create</button>
        </div>
    </div>
</form>

								</div>
							</div>
							<div class="module">
								<div class="module-head">
									<h3>Manage Categories</h3>
								</div>
								<div class="module-body table">
									<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Image</th>
												<th>Category</th>
												<th>Description</th>
												<th>Creation date</th>
												<th>Last Updated</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php $query = mysqli_query($con, "select * from category");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
											?>
												<tr>
													<td><?php echo htmlentities($cnt); ?></td>
													<td><img src="uploads/category/<?php echo htmlentities($row['categoryImage']); ?>" width="100" height="100"></td>
													<td><?php echo htmlentities($row['categoryName']); ?></td>
													<td><?php echo htmlentities($row['categoryDescription']); ?></td>
													<td> <?php echo htmlentities($row['creationDate']); ?></td>
													<td><?php echo htmlentities($row['updationDate']); ?></td>
													<td>
														<a href="edit-category.php?id=<?php echo $row['id'] ?>"><i class="icon-edit"></i></a>
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
				<p>Are you sure you want to delete this Category?</p>
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
				$('.delete-btn').on('click', function() {
					var id = $(this).data('id');
					$('#confirmDelete').attr('href', 'category.php?id=' + id + '&del=delete');
				});
			});
		</script>
	</body>
<?php } ?>