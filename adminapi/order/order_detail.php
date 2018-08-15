<?php
require_once '../../include/config.php';

admincheck();

$obj=(object)$_REQUEST;
$output=orderDetail($obj);

echo $output;

mysqli_close($con);
?>