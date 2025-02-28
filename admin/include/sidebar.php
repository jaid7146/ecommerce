<style>
	.sidebar ul li.active a {
    background-color:#248aaf !important; /* Highlight active menu item */
    color: white !important;
    font-weight: bold;
}
	</style>
<?php 
$currentPage = basename($_SERVER['PHP_SELF']); 
?>
<div class="span3">
    <div class="sidebar">
        <ul class="widget widget-menu unstyled">
            <li>
                <a class="collapsed" data-toggle="collapse" href="#togglePages">
                    <i class="menu-icon icon-cog"></i>
                    <i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
                    Order Management
                </a>
                <ul id="togglePages" class="collapse unstyled">
                    <li class="<?php echo ($currentPage == 'todays-orders.php') ? 'active' : ''; ?>">
                        <a href="todays-orders.php">
                            <i class="icon-tasks"></i> Today's Orders
                            <?php
                            $f1 = "00:00:00";
                            $from = date('Y-m-d') . " " . $f1;
                            $t1 = "23:59:59";
                            $to = date('Y-m-d') . " " . $t1;
                            $result = mysqli_query($con, "SELECT * FROM Orders where orderDate Between '$from' and '$to'");
                            $num_rows1 = mysqli_num_rows($result);
                            ?>
                            <b class="label orange pull-right"><?php echo htmlentities($num_rows1); ?></b>
                        </a>
                    </li>
                    <li class="<?php echo ($currentPage == 'pending-orders.php') ? 'active' : ''; ?>">
                        <a href="pending-orders.php">
                            <i class="icon-tasks"></i> Pending Orders
                            <?php
                            $status = 'Delivered';
                            $ret = mysqli_query($con, "SELECT * FROM Orders where orderStatus!='$status' || orderStatus is null ");
                            $num = mysqli_num_rows($ret);
                            ?>
                            <b class="label orange pull-right"><?php echo htmlentities($num); ?></b>
                        </a>
                    </li>
                    <li class="<?php echo ($currentPage == 'delivered-orders.php') ? 'active' : ''; ?>">
                        <a href="delivered-orders.php">
                            <i class="icon-inbox"></i> Delivered Orders
                            <?php
                            $status = 'Delivered';
                            $rt = mysqli_query($con, "SELECT * FROM Orders where orderStatus='$status'");
                            $num1 = mysqli_num_rows($rt);
                            ?>
                            <b class="label green pull-right"><?php echo htmlentities($num1); ?></b>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo ($currentPage == 'manage-users.php') ? 'active' : ''; ?>">
                <a href="manage-users.php">
                    <i class="menu-icon icon-group"></i> Manage Users
                </a>
            </li>
        </ul>

        <ul class="widget widget-menu unstyled">
            <li class="<?php echo ($currentPage == 'category.php') ? 'active' : ''; ?>">
                <a href="category.php"><i class="menu-icon icon-tasks"></i> Create Category </a>
            </li>
            <li class="<?php echo ($currentPage == 'subcategory.php') ? 'active' : ''; ?>">
                <a href="subcategory.php"><i class="menu-icon icon-tasks"></i> Sub Category </a>
            </li>
            <li class="<?php echo ($currentPage == 'insert-product.php') ? 'active' : ''; ?>">
                <a href="insert-product.php"><i class="menu-icon icon-paste"></i> Insert Product </a>
            </li>
            <li class="<?php echo ($currentPage == 'manage-products.php') ? 'active' : ''; ?>">
                <a href="manage-products.php"><i class="menu-icon icon-table"></i> Manage Products </a>
            </li>
        </ul>

        <ul class="widget widget-menu unstyled">
            <li class="<?php echo ($currentPage == 'sale.php') ? 'active' : ''; ?>">
                <a href="sale.php"><i class="menu-icon icon-tasks"></i> Total Sale Report</a>
            </li>
            <li class="<?php echo ($currentPage == 'sale-report.php') ? 'active' : ''; ?>">
                <a href="sale-report.php"><i class="menu-icon icon-tasks"></i> Category Report</a>
            </li>
        </ul>

        <ul class="widget widget-menu unstyled">
            <li class="<?php echo ($currentPage == 'user-logs.php') ? 'active' : ''; ?>">
                <a href="user-logs.php"><i class="menu-icon icon-tasks"></i> User Login Log </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="menu-icon icon-signout"></i> Logout
                </a>
            </li>
        </ul>
    </div><!--/.sidebar-->
</div><!--/.span3-->
