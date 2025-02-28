<?php
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME', 'shopping');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>

<?php 
define('DB_server','localhost');
define('DB_user', 'root');
define('DB_pass', '');
define('db_name','shopping');
$con = mysqli_connect(DB_server,DB_user,DB_pass,db_name);
if(mysqli_connect_errno())
{ 
    echo "failed to connect to mysql;" .mysqli_connect_error();
}
 ?>