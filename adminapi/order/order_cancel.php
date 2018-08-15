<?php
require_once '../../include/config.php';

admincheck();

if(isset($_REQUEST["order_id"]) && $_REQUEST["order_id"]!=""){
    $order_id=numOnly($_REQUEST["order_id"]);

    $query="select * from `canteen_order` where order_id='{$order_id}'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        $user_id=$row["user_id"];
        $amount=(int)$row["amount"];
        $status=-1;

        $query="update `canteen_order` set `status`='{$status}' where `order_id`='{$order_id}'";
        $result=mysqli_query($con,$query);
        if($result){
            $query="update `canteen_user` set `amount`=amount+{$amount} where `user_id`='{$user_id}'";
            $result=mysqli_query($con,$query);
            if($result){
                $output='{"status":"success", "remark":"Successfully Cancelled this order"}';
            }else{
                $output='{"status":"failure", "remark":"Something is wrong"}';
            }
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