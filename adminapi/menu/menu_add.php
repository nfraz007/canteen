<?php
require_once '../../include/config.php';

admincheck();

if(isset($_REQUEST["name"]) && $_REQUEST["name"]!=""){
	if(isset($_REQUEST["amount"]) && $_REQUEST["amount"]!=""){
        $name=filter_var($_REQUEST["name"],FILTER_SANITIZE_STRING);
        $amount=(int)filter_var($_REQUEST["amount"],FILTER_SANITIZE_STRING);
        $status=1;

        if($amount>0 && $amount<=100000){
            if(strlen($name)<=50){
                $query="insert into `canteen_menu` (`name`,`amount`,`status`) values ('{$name}', '{$amount}', '{$status}')";
                $result=mysqli_query($con,$query);
                if($result){
                    $output='{"status":"success", "remark":"Successfully added"}';
                }else{
                    $output='{"status":"failure", "remark":"Something is wrong"}';
                }
            }else{
                $output='{"status":"failure", "remark":"Name must be less than 50 characters"}';
            }
        }else{
            $output='{"status":"failure", "remark":"Amount must be in range 1 to 1,00,000"}';
        }
	}else{
	  $output='{"status":"failure", "remark":"Invalid or Incomplete remark recieved"}';
	}
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete amount recieved"}';
}

echo $output;

mysqli_close($con);
?>