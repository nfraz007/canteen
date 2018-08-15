<?php
require_once '../../include/config.php';

admincheck();

if(isset($_REQUEST["order_id"]) && $_REQUEST["order_id"]!=""){
    $order_id=numOnly($_REQUEST["order_id"]);
    $status=1;

    if(orderExist($order_id)){
        $query="update `canteen_order` set `status`='{$status}' where `order_id`='{$order_id}'";
        $result=mysqli_query($con,$query);
        if($result){
            $output='{"status":"success", "remark":"Successfully Accept this order"}';
        }else{
            $output='{"status":"failure", "remark":"Something is wrong"}';
        }
    }else{
        $output='{"status":"failure", "remark":"Sorry, This order does not exist"}';
    }
}else{
    $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
}

echo $output;

mysqli_close($con);
?>