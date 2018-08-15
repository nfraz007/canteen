<?php
require_once '../../include/config.php';

logincheck();

$obj=(object)$_REQUEST;
$obj->user_id=$_SESSION["user_id"];
$output=cartList($obj);

echo $output;

mysqli_close($con);
?>