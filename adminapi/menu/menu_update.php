<?php
require_once '../../include/config.php';

admincheck();

if(isset($_REQUEST["menu_id"]) && $_REQUEST["menu_id"]!=""){
    if(isset($_REQUEST["name"]) && $_REQUEST["name"]!=""){
        if(isset($_REQUEST["amount"]) && $_REQUEST["amount"]!=""){
            if(isset($_REQUEST["status"]) && $_REQUEST["status"]!=""){
                $menu_id=numOnly($_REQUEST["menu_id"]);
                $name=filter_var($_REQUEST["name"],FILTER_SANITIZE_STRING);
                $amount=(int)filter_var($_REQUEST["amount"],FILTER_SANITIZE_STRING);
                $status=(int)numOnly($_REQUEST["status"]);

                if($amount>0 && $amount<=100000){
                    if(strlen($name)<=50){
                        if($status==0 || $status==1){
                            $query="update `canteen_menu` set `name`='{$name}', `amount`='{$amount}', `status`='{$status}' where `menu_id`='{$menu_id}'";
                            $result=mysqli_query($con,$query);
                            if($result){
                                $output='{"status":"success", "remark":"Successfully updated"}';
                            }else{
                                $output='{"status":"failure", "remark":"Something is wrong"}';
                            }
                        }else{
                            $output='{"status":"failure", "remark":"Invalid status recieved"}';
                        }
                    }else{
                        $output='{"status":"failure", "remark":"Name must be less than 50 characters"}';
                    }
                }else{
                    $output='{"status":"failure", "remark":"Amount must be in range 1 to 1,00,000"}';
                }
            }else{
                $output='{"status":"failure", "remark":"Invalid or Incomplete status recieved"}';
            }
        }else{
          $output='{"status":"failure", "remark":"Invalid or Incomplete description recieved"}';
        }
    }else{
      $output='{"status":"failure", "remark":"Invalid or Incomplete name recieved"}';
    }
}else{
    $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
}

echo $output;

mysqli_close($con);
?>