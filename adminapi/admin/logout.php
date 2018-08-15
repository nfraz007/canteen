<?php
session_start();
unset($_SESSION['admin_id']);
unset($_SESSION['admin_username']);
session_destroy();

$output='{"status":"success", "remark":"Successfully Logout"}';
echo $output;
?>