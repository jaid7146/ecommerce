
<form method="POST">
    <label>Select Product:</label>
    <select name="productId">
        <option value="">All Products</option>
        <?php
        $result = mysqli_query($conn, "SELECT DISTINCT productId FROM orders");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['productId'] . "'>" . $row['product_name'] . "</option>";
        }
        ?>
    </select>

    <label>Select Month:</label>
    <select name="month">
        <option value="">All Months</option>
        <?php for ($m = 1; $m <= 12; $m++) {
            echo "<option value='" . $m . "'>" . date("F", mktime(0, 0, 0, $m, 1)) . "</option>";
        } ?>
    </select>
    <label>Select Year:</label>
    <select name="year">
        <option value="">All Years</option>
        <?php
        $years = mysqli_query($conn, "SELECT DISTINCT YEAR(orderDate) as year FROM orders");
        while ($row = mysqli_fetch_assoc($years)) {
            echo "<option value='" . $row['year'] . "'>" . $row['year'] . "</option>";
        }
        ?>
    </select>
    <label>Start Date:</label>
    <input type="date" name="start_date">
    <label>End Date:</label>
    <input type="date" name="end_date">
    <button type="submit" name="filter">Generate Report</button>
</form>
<?php
if (isset($_POST['filter'])) {
    $product_id = $_POST['productId'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // SQL query with JOIN to fetch product name
    $query = "SELECT p.productName, SUM(o.quantity) as total_qty, SUM(o.total_amount) as total_sales 
              FROM orders o
              JOIN products p ON o.productId = p.productId
              WHERE 1"; // '1' means always true, helps in dynamic conditions

    if (!empty($product_id)) {
        $query .= " AND o.productId = '$product_id'";
    }
    if (!empty($month)) {
        $query .= " AND MONTH(o.orderDate) = '$month'";
    }
    if (!empty($year)) {
        $query .= " AND YEAR(o.orderDate) = '$year'";
    }
    if (!empty($start_date) && !empty($end_date)) {
        $query .= " AND o.orderDate BETWEEN '$start_date' AND '$end_date'";
    }

    $query .= " GROUP BY p.productName";

    $result = mysqli_query($conn, $query);

    echo "<table border='1'>
            <tr>
                <th>Product Name</th>
                <th>Total Quantity Sold</th>
                <th>Total Sales (₹)</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['productName'] . "</td>
                <td>" . $row['total_qty'] . "</td>
                <td>" . number_format($row['total_sales'], 2) . "</td>
              </tr>";
    }
    echo "</table>";
}
?>
