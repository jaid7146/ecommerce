
<div class="header-nav animate-dropdown">
    <div class="container">
        <div class="yamm navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="nav-bg-class">
                <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
	                <div class="nav-outer">
		                <ul class="nav navbar-nav">
			                <li class="<?php echo (!isset($_GET['cid'])) ? 'active' : ''; ?>">
				                <a href="index.php">Home</a>
			                </li>
			            <?php 
			                $sql = mysqli_query($con, "SELECT id, categoryName FROM category LIMIT 5");
			                $currentCid = isset($_GET['cid']) ? $_GET['cid'] : ''; // Get current category ID from URL
			                while ($row = mysqli_fetch_array($sql)) {
			                ?>
			                <li class="dropdown yamm <?php echo ($currentCid == $row['id']) ? 'active' : ''; ?>">
				                <a href="category.php?cid=<?php echo $row['id']; ?>"> <?php echo $row['categoryName']; ?></a>
			                </li>
			                <?php } ?>
		                </ul><!-- /.navbar-nav -->  
		                <div class="clearfix"></div>				
	                </div>
                </div>
            </div>
        </div>
    </div>
</div>
