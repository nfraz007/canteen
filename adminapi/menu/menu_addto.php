<?php
require_once '../../include/config.php';

admincheck();

if(isset($_REQUEST["menu_id"]) && $_REQUEST["menu_id"]!=""){
    if(isset($_REQUEST["breakfast"]) && $_REQUEST["breakfast"]!=""){
        if(isset($_REQUEST["lunch"]) && $_REQUEST["lunch"]!=""){
            if(isset($_REQUEST["dinner"]) && $_REQUEST["dinner"]!=""){
                $menu_id=numOnly($_REQUEST["menu_id"]);
                $breakfast=(int)numOnly($_REQUEST["breakfast"]);
                $lunch=(int)numOnly($_REQUEST["lunch"]);
                $dinner=(int)numOnly($_REQUEST["dinner"]);

                if($breakfast==1) $breakfast=1;
                else $breakfast=0;

                if($lunch==1) $lunch=1;
                else $lunch=0;

                if($lunch==1) $lunch=1;
                else $lunch=0;

                $query="update `canteen_menu` set `breakfast`='{$breakfast}', `lunch`='{$lunch}', `dinner`='{$dinner}' where `menu_id`='{$menu_id}'";
                $result=mysqli_query($con,$query);
                if($result){
                    $output='{"status":"success", "remark":"Successfully Added"}';
                }else{
                    $output='{"status":"failure", "remark":"Something is wrong"}';
                }
            }else{
                $output='{"status":"failure", "remark":"Invalid or Incomplete dinner recieved"}';
            }
        }else{
          $output='{"status":"failure", "remark":"Invalid or Incomplete lunch recieved"}';
        }
    }else{
      $output='{"status":"failure", "remark":"Invalid or Incomplete breakfast recieved"}';
    }
}else{
    $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
}

echo $output;

mysqli_close($con);
?>