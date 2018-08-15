<?php
require_once '../../include/config.php';

admincheck();

if(!PRODUCTION){
    if(isset($_REQUEST["user_id"]) && $_REQUEST["user_id"]!=""){
        if(isset($_REQUEST["amount"]) && $_REQUEST["amount"]!=""){
            $user_id=numOnly($_REQUEST["user_id"]);
            $amount=(int)filter_var($_REQUEST["amount"],FILTER_SANITIZE_STRING);

            if(userExist($user_id)){
                if($amount>0 && $amount<=100000){
                    $query="update `canteen_user` set `amount`=`amount`+{$amount} where `user_id`='{$user_id}'";
                    $result=mysqli_query($con,$query);
                    if($result){
                        $output='{"status":"success", "remark":"Successfully updated"}';
                    }else{
                        $output='{"status":"failure", "remark":"Something is wrong"}';
                    }
                }else{
                    $output='{"status":"failure", "remark":"Amount must be in range 1 to 1,00,000"}';
                }
            }else{
                $output='{"status":"failure", "remark":"Sorry, This user is not exist"}';
            }
        }else{
          $output='{"status":"failure", "remark":"Invalid or Incomplete amount recieved"}';
        }
    }else{
        $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
    }
}else{
      $output='{"status":"failure", "remark":"This feature is disabled."}';
}

echo $output;

mysqli_close($con);
?>