<?php
session_start();
$_SESSION['alogin']="";
$_SESSION['success_message']="You have successfully logout";
?>
<script language="javascript">
document.location = "/ecommerce-site/login.php";
</script>
