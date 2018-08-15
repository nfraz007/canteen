<?php
require_once '../../include/config.php';

logincheck();

$obj=(object)$_REQUEST;
$obj->status="1";
$output=menuList($obj);

echo $output;

mysqli_close($con);
?>