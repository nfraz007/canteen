<?php
require_once '../../include/config.php';

admincheck();

$obj=(object)$_REQUEST;
$output=menuList($obj);

echo $output;

mysqli_close($con);
?>