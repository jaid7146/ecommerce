<?php
session_start();
include('include/config.php');
// Check if the admin is logged in
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
	exit();
} else 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>sales Report </title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"> -->
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
	<script type="text/javascript">
		bkLib.onDomLoaded(nicEditors.allTextAreas);
	</script>

	<script>
		function getSubcat(val) {
			$.ajax({
				type: "POST",
				url: "get_subcat.php",
				data: 'cat_id=' + val,
				success: function(data) {
					$("#subcategory").html(data);
				}
			});
		}
        function getProducts(val) {
    $.ajax({
        type: "POST",
        url: "get_products.php", // Ensure this file exists and correctly fetches products
        data: { subcat_id: val },
        success: function(data) {
            $("#product").html(data);
        }
    });
}
		function selectCountry(val) {
			$("#search-box").val(val);
			$("#suggesstion-box").hide();
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
								<h3>sales Report </h3>
							</div>
							<div class="module-body">
                            <form class="form-horizontal row-fluid" name="salesReport" method="post">
    <div class="control-group">
        <label class="control-label" for="basicinput">Category</label>
        <div class="controls">
            <select name="category" id="category" class="span8 tip" onChange="getSubcat(this.value);" required>
                <option value="">Select Category</option>
                <?php
                $query = mysqli_query($con, "SELECT * FROM category");
                while ($row = mysqli_fetch_array($query)) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['categoryName']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="basicinput">Sub Category</label>
        <div class="controls">
            <select name="subcategory" id="subcategory" class="span8 tip" onChange="getProducts(this.value);" required>
                <option value="">Select Subcategory</option>
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="basicinput">Product</label>
        <div class="controls">
            <select name="product" id="product" class="span8 tip" required>
                <option value="">Select Product</option>
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="startdate">Start Date</label>
        <div class="controls">
            <input type="date" name="startdate" id="startdate" class="span8" required>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="enddate">End Date</label>
        <div class="controls">
            <input type="date" name="enddate" id="enddate" class="span8" required>
        </div>
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>
<?php
if (isset($_POST['submit'])) {
    // Fetch data based on selected dates and category
    $startdate = mysqli_real_escape_string($con, $_POST['startdate']);
    $enddate = mysqli_real_escape_string($con, $_POST['enddate']);
    $category = mysqli_real_escape_string($con, $_POST['category']);

    // Query to fetch products sold day by day, and filter by category
    $query = "SELECT 
    p.productName, 
    p.productPrice, 
    p.productImage1, 
    p.id, 
    SUM(o.quantity) AS totalQuantity, 
    COUNT(o.id) AS totalOrders, 
    (p.productPrice * SUM(o.quantity)) AS totalPrice
FROM orders o
JOIN products p ON o.productId = p.id
WHERE o.orderDate BETWEEN '$startdate' AND '$enddate' 
AND p.category = '$category'
GROUP BY p.id
ORDER BY totalOrders DESC";  // Sort by total orders for better readability

    $result = mysqli_query($con, $query);
    // Check if results exist
    if (mysqli_num_rows($result) > 0) {
        $totalSales = 0;  // Variable to accumulate total sales

        echo "<table class='table table-striped datatable-1 table table-bordered table-striped	 display'>
        <thead>
            <tr>
            <th> Product Image</th>
                <th>Product Name</th>
                <th>Total Orders</th>
                <th>Product Price</th>
                <th>Total Quantity Sold</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>";
        $totalSales = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $totalSales += $row['totalPrice'];
        
            echo "<tr>
              <td><img src='productimages/" . $row['id'] . "/" . $row['productImage1'] . "' width='100'></td>
                    <td>" . $row['productName'] . "</td>
                    <td>" . $row['totalOrders'] . "</td>
                    <td>" . number_format($row['productPrice'], 2) . "</td>
                    <td>" . $row['totalQuantity'] . "</td>
                    <td>" . number_format($row['totalPrice'], 2) . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
        
        // Show total sales
        echo "<div class='alert alert-success'>
                <strong>Total Sales: </strong> ₹" . number_format($totalSales, 2) . "
              </div>";              
    } else {
        echo "<div class='alert alert-info'>No sales data found for the selected date range.</div>";
    }
}
?>
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
	</script>
</body>
<?php
?>  