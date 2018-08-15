<?php
require_once '../../include/config.php';

logincheck();

$user_id=$_SESSION["user_id"];
$datetime=date("Y-m-d H:i:s");
$status=0;

if($amount=orderCondition($user_id)){
	$query="insert into `canteen_order` (`user_id`, `amount`, `datetime`, `status`) values ('{$user_id}', '{$amount}', '{$datetime}', '{$status}')";
	$result=mysqli_query($con,$query);
	if($result){
		$order_id=mysqli_insert_id($con);

		$query="update `canteen_cart` set `order_id`='{$order_id}' where `order_id`=0 and `user_id`='{$user_id}'";
		$result=mysqli_query($con,$query);
		if($result){
			$output='{"status":"success", "remark":"Order Successfully Placed"}';
		}else{
			$output='{"status":"failure", "remark":"Something is wrong"}';
		}
	}else{
		$output='{"status":"failure", "remark":"Something is wrong"}';
	}
}else{
	$output='{"status":"failure", "remark":"Sorry, This order cannot be placed"}';
}

echo $output;

mysqli_close($con);
?>