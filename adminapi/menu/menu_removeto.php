<?php
require_once '../../include/config.php';

admincheck();

if(isset($_REQUEST["menu_id"]) && $_REQUEST["menu_id"]!=""){
    if(isset($_REQUEST["type"]) && $_REQUEST["type"]!=""){
        $menu_id=numOnly($_REQUEST["menu_id"]);
        $type=filter_var($_REQUEST["type"],FILTER_SANITIZE_STRING);

        if($type=="breakfast" || $type=="lunch" || $type=="dinner"){
            $query="update `canteen_menu` set `{$type}`=0 where `menu_id`='{$menu_id}'";
            $result=mysqli_query($con,$query);
            if($result){
                $output='{"status":"success", "remark":"Successfully Removed"}';
            }else{
                $output='{"status":"failure", "remark":"Something is wrong"}';
            }
        }else{
            $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
        }
    }else{
      $output='{"status":"failure", "remark":"Invalid or Incomplete type recieved"}';
    }
}else{
    $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
}

echo $output;

mysqli_close($con);
?>