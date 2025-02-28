<?php
session_start();
include_once('include/config.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $contactno = $_POST['contactno'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $role_id = 1; // Assuming role ID is 1
    // Insert user data into the database
    $query = "INSERT INTO users (name, contactno, email, password, roleid) VALUES ('$fullname', '$contactno', '$email', '$password', '$role_id')";
    $result = mysqli_query($con, $query);
    if ($result) {
        echo "<div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;'>
        <div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
            <h3 style='margin:0 0 10px; color:#333;'>Success</h3>
            <p style='margin:0 0 20px; color:#555;'>The user has been added successfully</p>
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
            <h3 style='margin:0 0 10px; color:#333;'>Incorrect</h3>
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
        .form-container input[type="email"],
        .form-container input[type="password"]
        {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .form-container button {
            background-color: #248aaf;
            border-color: #20799a;
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
        @media (min-width: 1024px)  {
  .form-container {
    margin-right: 188px;
    margin-left: 327px;
 }            
        }
@media (min-width:768px) and (max-width:1023px) {
    .form-container {
    margin-right: 56px;
margin-left: 244px;
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
        <h3>ADD Users</h3>
                            <form method="POST" action="">
                                <!-- Full Name -->
                                    <label for="fullname" class="form-label">FullName</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name" required>
                                <!-- Contact No -->
                                    <label for="contactno" class="form-label">Contact No.</label>
                                    <input type="text" class="form-control" id="contactno" name="contactno" placeholder="Enter your contact number" required>
                                <!-- Email -->
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                <!-- Password -->
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                <!-- Submit Button -->
                                    <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
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
            });
        </script>
    </div>
</body>

</html>