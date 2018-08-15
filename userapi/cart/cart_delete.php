<?php
require_once '../../include/config.php';

logincheck();

if(isset($_REQUEST["cart_id"]) && $_REQUEST["cart_id"]!=""){
    $user_id=$_SESSION["user_id"];
    $cart_id=(int)filter_var($_REQUEST["cart_id"],FILTER_SANITIZE_STRING);

    $query="delete from `canteen_cart` where `cart_id`='{$cart_id}' and `user_id`='{$user_id}'";
    $result=mysqli_query($con,$query);
    if($result){
        $output='{"status":"success", "remark":"Successfully removed from cart"}';
    }else{
        $output='{"status":"failure", "remark":"Something is wrong"}';
    }
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
}

echo $output;

mysqli_close($con);
?>