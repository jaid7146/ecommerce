<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	date_default_timezone_set('Asia/Kolkata'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());
	if (isset($_GET['del'])) {
		mysqli_query($con, "delete from users where id = '" . $_GET['id'] . "'");
		$_SESSION['delmsg'] = "User delete !!";
	}
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin| Manage Users</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"> -->
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link rel="shortcut icon" href="admin/assets/images/image_2025_02_10T06_42_49_708Z.png">

		<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	 
	</head>
	<style>
	</style>
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
									<h3>Manage Users</h3>
								</div>
								<a href="add-user.php" class="btn btn-success" style="float:right;margin-top:-31px;background-color:#248aaf; border-color:#20799a">Add User</a>
								<div class=" module-body table">
									<?php if (isset($_SESSION['delmsg']) && $_SESSION['delmsg'] != "") { ?>
										<div class="alert alert-success" id="deleteAlert">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Success!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?>
											<?php $_SESSION['delmsg'] = ""; ?>
										</div>
									<?php } ?>
									<script>
										setTimeout(function() {
											$('#deleteAlert').fadeOut('slow');
										}, 3000);
									</script>	

									<br />
									<div class="table-responsive">
										<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
											<thead>
											<tr>
												<th>#</th>
												<th> Name</th>
												<th>Email </th>
												<th>Contact no</th>
												<th>Action</th>
												<!-- <th>Shippping Address/City/State/Pincode </th>
												<th>Billing Address/City/State/Pincode </th> -->
												<!-- <th>Reg. Date </th> -->
											</tr>
										</thead>
										<tbody>
											<?php
											$query = mysqli_query($con, "select * from users");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
											?>
												<tr>
													<td><?php echo htmlentities($cnt); ?></td>
													<td><?php echo htmlentities($row['name']); ?></td>
													<td><?php echo htmlentities($row['email']); ?></td>
													<td><?php echo htmlentities($row['contactno']); ?></td>
													<td><a href="edit-user.php?id=<?php echo $row['id']; ?>" class="icon-edit"></a>
													 <a href="#" class="delete-btn"  class="" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#deleteConfirmModal">
															<i class="icon-remove-sign"></i>
														</a></td>
													<?php
													// echo htmlentities($row['shippingAddress']) . ", ";
													// echo htmlentities($row['shippingCity']) . ", ";
													// echo htmlentities($row['shippingState']) . " - ";
													// echo htmlentities($row['shippingPincode']);
													?></td>
													<?php
													// echo htmlentities($row['billingAddress']) . ", ";
													// echo htmlentities($row['billingCity']) . ", ";
													// echo htmlentities($row['billingState']) . " - ";
													// echo htmlentities($row['billingPincode']);
													?></td>

												</tr>
											<?php $cnt = $cnt + 1;
									} ?>

										</table>
									</div>
									</table>
								</div>
							</div>
						</div><!--/.content-->
					</div><!--/.span9-->
				</div>
			</div><!--/.container-->
		</div><!--/.wrapper-->
		<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this User ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>
		<?php include('include/footer.php'); ?>
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
				let deleteId;
                $(document).on('click', '.delete-btn', function() {
                    deleteId = $(this).data('id');
                });
                $('#confirmDelete').on('click', function() {
                    window.location.href = "manage-users.php?id=" + deleteId + "&del=delete";
				});
			});
		</script>
	</body>
<?php } ?>