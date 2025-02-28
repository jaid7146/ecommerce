<?php
session_start();
include("includes/config.php");
// Assuming the user's email is stored in the session as 'login'
$userEmail = isset($_SESSION['login']) ? $_SESSION['login'] : null;
if ($userEmail) {
    // Extract username for display purposes before destroying the session
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
    // Get the current date and time in Asia/Kolkata timezone
    date_default_timezone_set('Asia/Kolkata');
    $ldate = date('d-m-Y h:i:s A', time());

    // Update the logout time and status in the userlog table
    $updateQuery = "UPDATE userlog 
                    SET logout = '$ldate', status = 0 
                    WHERE userEmail = '$userEmail' 
                    ORDER BY id DESC LIMIT 1";
    mysqli_query($con, $updateQuery);
    session_unset();
    session_destroy();
    echo "
    <div id='custom-alert' style='display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.5); z-index:1000;' >
        <div style='background:#fff; padding:20px; border-radius:8px; text-align:center; width:300px;'>
            <h3 style='margin:0 0 10px; color:#333;'>Success</h3>
            <p style='margin:0 0 20px; color:#555;'>You have successfully logged out, $username</p>
            <button style='background:#28a745; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;' onclick='closeAlert()'>OK</button>
        </div>
    </div>
    <script>
        function closeAlert() {
            document.getElementById(\"custom-alert\").style.display = \"none\";
            window.location.href = 'index.php';
        }
    </script>";
} else {
    // If session is invalid or user is not logged in
    header("Location: index.php");  // Redirect to homepage
    exit();
}
?>
