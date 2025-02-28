<?php
session_start();
include('include/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Sales</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"> -->
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="icon"type="image/png" href="assets/images/image_2025_02_10T06_42_49_708Z.png">
    <style>
        .table-wrapper {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }

        .table thead th {
            background-color: #f5f5f5;
            color: #777777;
            text-align: center;
        }

        .table tbody td {
            text-align: center;
        }

        canvas {
            margin: 20px 0;
        }/* Ensure the year picker has enough width */
        .ui-datepicker {
    min-width: 250px !important;  /* Set minimum width */
    width: auto !important; /* Allow it to adjust dynamically */
    padding: 12px;
}

/* Adjust for smaller screens (laptops, tablets) */
@media (max-width: 1024px) {
    .ui-datepicker {
        width: 25% !important; /* Adjusted width */
        left: 44% !important; /* Center align */
        transform: translateX(-50%); /* Perfect centering */
    }
}

/* Adjust for mobile screens */
@media (max-width: 480px) {
    .ui-datepicker {
        width: 70% !important; /* Wider width on mobile */
        left: 50% !important; /* Center align */
        transform: translateX(-50%); /* Ensure it's centered */
    }
}

    </style>
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
                                <h3>Monthly Sales Report</h3>
                            </div>
                            <div class="module-body table">
                                <div class="table-wrapper">
                                    <!-- Filter Form -->

                                    <form method="GET" action="">
                                        <input type="text" name="txtFromYear" id="txtYear" class="date-picker-year" placeholder="Select Year" />
                                        <button type="submit" class="btn btn-primary" style="margin-bottom: 11px;">Filter</button>
                                    </form>
                                    <?php
                                    // Set filter values
                                    // Query for sales data by month for the selected year
                                    // Get the year from the GET request (default to the current year if not provided)
                                    $filterYear = isset($_GET['txtFromYear']) ? intval($_GET['txtFromYear']) : date('Y');

                                    // Query for sales data by month for the selected year
                                    $query = "SELECT MONTH(orderDate) AS month, SUM(total_amount) AS total_sales FROM orders WHERE YEAR(orderDate) = '$filterYear' GROUP BY MONTH(orderDate) ORDER BY  MONTH(orderDate)";
                                    $result = $con->query($query);
                                    // Initialize arrays for chart and table data
                                    $monthLabels = [];
                                    $salesData = [];

                                    // Populate sales data for all months with zero initially
                                    for ($m = 1; $m <= 12; $m++) {
                                        $salesData[$m] = 0;
                                    }

                                    if ($result->num_rows > 0) {
                                        echo "<table class='table table-bordered table-striped table-hover datatable-1'>
                                           <thead>
                                        <tr>
                                       <th>Month</th>
                                        <th>Total Sales</th>
                                        </tr>
                                       </thead>
                                       <tbody>";
                                        while ($row = $result->fetch_assoc()) {
                                            $monthName = date("F", mktime(0, 0, 0, $row['month'], 10));
                                            $monthLabels[] = $monthName;
                                            $salesData[$row['month']] = $row['total_sales'];

                                     echo "<tr>
        <td>" . $monthName . "</td>
        <td>₹ " . number_format($row['total_sales'], 2) . "</td>
      </tr>";

                                        }
                                        echo "</tbody></table>";
                                    } else {
                                        echo "<p class='text-center text-danger'>No sales data found for the selected period.</p>";
                                    }

                                    ?>
                                    <!-- Chart Section -->
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div><!--/.content-->
                </div><!--/.span9-->
            </div><!--/.row-->
        </div><!--/.container-->
    </div><!--/.wrapper-->
    <?php include('include/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="scripts/datatables/jquery.dataTables.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $('.datatable-1').DataTable({
                paging: true,
                searching: true,
                info: true,
                responsive: true
            });
            $(document).ready(function() {
                $('.datatable-1').dataTable();
                $('.dataTables_paginate').addClass("btn-group datatable-pagination");
                $('.dataTables_paginate > a').wrapInner('<span />');
                $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
                $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
            });
        });
        $(function() {
    $(".date-picker-year").datepicker({
        changeYear: true,
        showButtonPanel: true,
        dateFormat: "yy",
        appendTo: "body",
        onClose: function(dateText, inst) {
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val(year);
        },
        beforeShow: function(input, inst) {
            setTimeout(function() {
                $(".ui-datepicker-calendar").hide();
                $(".ui-datepicker-month").hide();

                let inputOffset = $(input).offset();
                let inputHeight = $(input).outerHeight();
                let screenWidth = $(window).width();

                $("#ui-datepicker-div").css({
                    position: "absolute",
                    top: inputOffset.top + inputHeight + 5,
                    left: screenWidth > 768 ? inputOffset.left : "5%",
                    width: screenWidth > 768 ? "320px" : "90%",
                    maxWidth: "400px",
                    zIndex: 9999
                });
            }, 10);
        },
    });
    $(".date-picker-year").focus(function() {
        $(".ui-datepicker-calendar").hide();
        $(".ui-datepicker-month").hide();
    });
});

        const monthLabels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const salesData = <?php echo json_encode(array_values($salesData)); ?>;
    // Render the chart
    const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: monthLabels,
        datasets: [{
            label: 'Total Sales (₹)',
            data: salesData,
            fill: true, // Fill under the line
            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Line fill color
            borderColor: 'rgba(54, 162, 235, 1)', // Line color
            borderWidth: 2,
            tension: 0.4 // Smooth curve
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let value = context.raw || 0;
                        return `₹ ${value.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
                    }
                }
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Month'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Total Sales (₹)'
                }
            }
        }
    }
});
    </script>






































</body>

</html>