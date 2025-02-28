<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	date_default_timezone_set('Asia/Kolkata'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin| Pending Orders</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"> -->
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
		<link rel="icon"type="image/png" href="assets/images/image_2025_02_10T06_42_49_708Z.png">
	<script language="javascript" type="text/javascript">
			var popUpWin = 0;
			function popUpWindow(URLStr, left, top, width, height) {
				if (popUpWin) {
					if (!popUpWin.closed) popUpWin.close();
				}
				popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 600 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
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
									<h3>Delivered Orders </h3>
									<div style="float:right">
										<button type="button" class="btn btn-success" id="toggle-hidden-products">Hide Products</button>
									</div>
								</div>
								<div class="module-body table">
									<?php if (isset($_GET['del'])) { ?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?><?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
										</div>
									<?php } ?>
									<br />
									<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display table-responsive">
										<thead>
											<tr>
												<th>#</th>
												<th> Name</th>
												<th width="50">Email /Contact no</th>
												<th>Product </th>
												<th>Order Date</th>
												<th>Action</th>
												<th>Product Hide</th>
												
											</tr>
										</thead>
										<tbody>
											<?php
											$st = 'Delivered';
											$query = mysqli_query($con, "select users.name as username,users.email as useremail,users.contactno as usercontact,users.shippingAddress as shippingaddress,users.shippingCity as shippingcity,users.shippingState as shippingstate,users.shippingPincode as shippingpincode,products.productName as productname,products.shippingCharge as shippingcharge,orders.quantity as quantity,orders.orderDate as orderdate,products.productPrice as productprice,orders.id as id  from orders join users on  orders.userId=users.id join products on products.id=orders.productId where orders.orderStatus='$st'");
											$cnt = 1;	
											while ($row = mysqli_fetch_array($query)) {
											?>
												<tr class="product-row" id="row-<?php echo $row['id']; ?>">
    <td><?php echo htmlentities($cnt); ?></td>
    <td><?php echo htmlentities($row['username']); ?></td>
    <td><?php echo htmlentities($row['useremail']); ?>/<?php echo htmlentities($row['usercontact']); ?></td>
    <td><?php echo htmlentities($row['productname']); ?></td>
    <td><?php echo htmlentities($row['orderdate']); ?></td>
    <td>
        <a href="order-details.php?oid=<?php echo htmlentities($row['id']); ?>" title="Order Details" target="_blank" class="btn btn-info">Details</a>
    </td>
	<td>        <button type="button" class="btn btn-danger hide-product" data-row-id="<?php echo $row['id']; ?>">Hide</button>
	</td>
</tr>

											<?php $cnt = $cnt + 1;
											} ?>
										</tbody>
									</table>
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
		<script src="scripts/datatables/jquery.dataTables.js"></script>
		<script>
			$(document).ready(function() {
				$('.datatable-1').dataTable();
				$('.dataTables_paginate').addClass("btn-group datatable-pagination");
				$('.dataTables_paginate > a').wrapInner('<span />');
				$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
				$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
			});
			$(document).ready(function() {
        // Function to hide products from Local Storage
        function hideProductsFromLocalStorage() {
            let hiddenProducts = JSON.parse(localStorage.getItem('hiddenProducts')) || [];
            hiddenProducts.forEach(function(id) {
                $('#row-' + id).hide();
            });
            // Update button text if products are hidden
            if (hiddenProducts.length > 0) {
                $('#toggle-hidden-products').text('Show Products');
            }
        }

        // Call the function to hide products on page load
        hideProductsFromLocalStorage();

        // Event listener for the hide button in each row
        $('.hide-product').click(function() {
            var rowId = $(this).data('row-id');
            $('#row-' + rowId).hide();

            // Save to Local Storage
            let hiddenProducts = JSON.parse(localStorage.getItem('hiddenProducts')) || [];
            if (!hiddenProducts.includes(rowId)) {
                hiddenProducts.push(rowId);
                localStorage.setItem('hiddenProducts', JSON.stringify(hiddenProducts));
            }

            // Update toggle button text
            $('#toggle-hidden-products').text('Show Products');
        });

        // Toggle button to show/hide all hidden products
        $('#toggle-hidden-products').click(function() {
            let hiddenProducts = JSON.parse(localStorage.getItem('hiddenProducts')) || [];

            if (hiddenProducts.length > 0) {
                // If products are hidden, show them
                hiddenProducts.forEach(function(id) {
                    $('#row-' + id).show();
                });
                // Clear the hidden list
                localStorage.removeItem('hiddenProducts');
                $(this).text('Hide Products');
            } else {
                // If no products are hidden, hide them all
                $('.product-row').each(function() {
                    var rowId = $(this).attr('id').split('-')[1];
                    $(this).hide();
                    hiddenProducts.push(rowId);
                });
                localStorage.setItem('hiddenProducts', JSON.stringify(hiddenProducts));
                $(this).text('Show Products');
            }
        });
    });
</script>

		</script>
	</body>
<?php } ?>