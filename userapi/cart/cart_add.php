<?php
require_once '../../include/config.php';

logincheck();

if(isset($_REQUEST["menu_id"]) && $_REQUEST["menu_id"]!=""){
	if(isset($_REQUEST["quantity"]) && $_REQUEST["quantity"]!=""){
        $user_id=$_SESSION["user_id"];
        $menu_id=(int)filter_var($_REQUEST["menu_id"],FILTER_SANITIZE_STRING);
        $quantity=(int)filter_var($_REQUEST["quantity"],FILTER_SANITIZE_STRING);
        $order_id=0;

        if(menuExist($menu_id)){
            if($quantity>0 && $quantity<=100){
                $query="insert into `canteen_cart` (`order_id`,`user_id`,`menu_id`,`quantity`) values ('{$order_id}', '{$user_id}', '{$menu_id}', '{$quantity}')";
                $result=mysqli_query($con,$query);
                if($result){
                    $output='{"status":"success", "remark":"Successfully added to cart"}';
                }else{
                    $output='{"status":"failure", "remark":"Something is wrong"}';
                }
            }else{
                $output='{"status":"failure", "remark":"Quantity must be in range 1 to 100"}';
            }
        }else{
            $output='{"status":"failure", "remark":"Sorry, This menu does not exist"}';
        }
	}else{
	  $output='{"status":"failure", "remark":"Invalid or Incomplete quantity recieved"}';
	}
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
}

echo $output;

mysqli_close($con);
?>