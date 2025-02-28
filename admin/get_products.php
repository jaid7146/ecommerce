<?php
include("include/config.php");
if (!empty($_POST["subcat_id"])) {
    $subcat_id = mysqli_real_escape_string($con, $_POST["subcat_id"]);
    $query = mysqli_query($con, "SELECT * FROM products WHERE subCategory='$subcat_id'");
    echo "<option value=''>Select Product</option>";
    while ($row = mysqli_fetch_array($query)) {
        echo "<option value='" . $row['id'] . "'>" . $row['productName'] . "</option>";
    }
}
?>
