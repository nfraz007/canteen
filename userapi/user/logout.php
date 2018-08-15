<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['username']);
session_destroy();

$output='{"status":"success", "remark":"Successfully Logout"}';
echo $output;
?>