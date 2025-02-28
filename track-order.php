<?php
session_start();
include_once 'includes/config.php';
if (!isset($_GET['oid']) || empty($_GET['oid'])) {
    echo "<p class='text-danger text-center mt-3'>Invalid order request.</p>";
    exit;
}

$oid = intval($_GET['oid']);

// Fetch order tracking details
$ret = mysqli_query($con, "SELECT postingDate, status, remark FROM ordertrackhistory WHERE orderId='$oid'");

if (!$ret) {
    echo "<p class='text-danger text-center mt-3'>Error fetching order details.</p>";
    exit;
}

$num = mysqli_num_rows($ret);

echo "<div class='container p-3'>";

if ($num > 0) {
    
    while ($row = mysqli_fetch_assoc($ret)) {
        // Bootstrap Badge Color Based on Status
        $statusColor = match ($row['status']) {
            'Pending' => 'warning',
            'Shipped' => 'info',
            'Out for Delivery' => 'primary',
            'Delivered' => 'success',
            'Cancelled' => 'danger',
            default => 'secondary'
        };
        echo "<div class='card shadow-sm mb-3'>";
        echo "<div class='card-body'>";
        echo "<h6 class='card-title'><i class='bi bi-calendar-check'></i> <strong>Date:</strong> " . htmlentities($row['postingDate']) . "</h6>";
        echo "<p><strong>Status:</strong> <span class='badge bg-$statusColor'>" . htmlentities($row['status']) . "</span></p>";
        echo "<p><strong>Remark:</strong> " . htmlentities($row['remark']) . "</p>";
        echo "</div></div>";
    }
} else {
    echo "<p class='text-warning text-center'>No tracking updates available.</p>";
}
// Check if the order is delivered
$st = 'Delivered';
$rt = mysqli_query($con, "SELECT orderStatus FROM orders WHERE id='$oid'");

if ($rt && $orderData = mysqli_fetch_assoc($rt)) {
    if ($st === $orderData['orderStatus']) {
        echo "<p class='text-success text-center'><i class='bi bi-check-circle-fill'></i> <strong>Product Delivered successfully.</strong></p>";
    }
}

echo "</div>";
?>
