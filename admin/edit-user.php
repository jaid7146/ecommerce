<?php
ob_start();
session_start();
include('include/config.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE Id = $id";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $email = $row['email'];
        $contactno = $row['contactno'];
        $_SESSION['edit_msg'] = "User Update successfully!";
    } else {
        echo "No user found.";
        exit;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];

    $update = "UPDATE users SET name = '$name', email = '$email', contactno = '$contactno'  WHERE Id = $id";
    if (mysqli_query($con, $update)) {
        echo "<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>
            <div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
                <h3 style='margin:0 0 10px; color:#333;'>Success</h3>
                <p style='margin:0 0 20px; color:#555;'>The user has been updated successfully.</p>
                <button style='background:#28a745; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='closeAlert()'>OK</button>
            </div>
        </div>
        <script>
            function closeAlert() {
                document.getElementById(\"custom-alert\").style.display = \"none\";
                window.location.href = 'manage-users.php';
            }
        </script>";
    } else {
        echo "<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>
            <div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
                <h3 style='margin:0 0 10px; color:#333;'>Error</h3>
                <p style='margin:0 0 20px; color:#555;'>Something went wrong.</p>
                <button style='background:#dc3545; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='closeAlert()'>OK</button>
            </div>
        </div>
        <script>
            function closeAlert() {
                document.getElementById(\"custom-alert\").style.display = \"none\";
            }
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Users</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
    <link rel="icon"type="image/png" href="assets/images/image_2025_02_10T06_42_49_708Z.png">

   <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin:  auto;
        }
        .form-container h3 {
            margin-bottom: 20px;
            color: #343a40;
        }
        .form-container label {
            color: #495057;
        }
        .form-container input[type="text"],
        .form-container input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .form-container button {
            background-color: #248aaf;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #1b6985;
            border-color: #155167;
        }
        @media (max-width:1024px) {
            .form-container {
        margin-right: 100px;
            }
}
@media (min-width: 600px) and (max-width: 1023px) {
    .form-container {
        margin-left: 234px;
        max-width: 400px;
    }
    }

    </style>
</head>
<body>
    <?php include('include/header.php'); ?>
    <div class="jd" style="padding: 30px">
    <?php include('include/sidebar.php'); ?>
    </div>
    <div class="form-container">
        <h3>Edit User</h3>
        <form method="post">
            <label>First Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            <br>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <br>
            <label>Contact No:</label>
            <input type="text" name="contactno" value="<?php echo htmlspecialchars($contactno); ?>" required>
            <br>
            <button type="submit">Update User</button>
        </form>
    </div>
    <?php
    mysqli_close($con);
    ob_end_flush();
    ?>
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
</html>