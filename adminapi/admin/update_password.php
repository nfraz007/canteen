<?php
require_once '../../include/config.php';

admincheck();

if(!PRODUCTION){
    if(isset($_REQUEST["old_password"]) && $_REQUEST["old_password"]!="" && strlen($_REQUEST["old_password"])>=6){
    	if(isset($_REQUEST["new_password"]) && $_REQUEST["new_password"]!="" && strlen($_REQUEST["new_password"])>=6){
    		$admin_id=numOnly($_SESSION["admin_id"]);

    		$old_password=md5($_REQUEST["old_password"]);
            $new_password=md5($_REQUEST["new_password"]);

            $query="select * from `canteen_admin` where `password`='{$old_password}' and `admin_id`=".$admin_id;
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result)==1){
                $query="update `canteen_admin` set `password`='{$new_password}' where `admin_id`=".$admin_id;
                $result=mysqli_query($con,$query);
                if($result){
                    $output='{"status":"success", "remark":"Successfully updated"}';
                }else{
                    $output='{"status":"failure", "remark":"Something is wrong"}';
                }
            }else{
                $output='{"status":"failure", "remark":"Your old password is wrong"}';
            }
    	}else{
    	  $output='{"status":"failure", "remark":"Invalid or Incomplete New Password recieved"}';
    	}
    }else{
      $output='{"status":"failure", "remark":"Invalid or Incomplete Old Password recieved"}';
    }
}else{
      $output='{"status":"failure", "remark":"This feature is disabled."}';
}

echo $output;
mysqli_close($con);
?>