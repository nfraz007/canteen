<?php
require_once '../../include/config.php';

if(!PRODUCTION){
    if(isset($_REQUEST["username"]) && $_REQUEST["username"]!=""){
        if(isset($_REQUEST["password"]) && $_REQUEST["password"]!="" && strlen($_REQUEST["password"])>=6){
            $username=filter_var($_REQUEST["username"],FILTER_SANITIZE_STRING);
            $password=md5($_REQUEST["password"]);

            $query="select * from `canteen_user` where `username`='{$username}'";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result)==0){
                //user is not exist. insert into db
                $status=1;//user is inactive. when admin will activate this user, user can login
                $current_date=date("Y-m-d H:i:s");
                //send mail
                $query="INSERT INTO `canteen_user`(`username`,`password`,`status`,`registered_on`) VALUES ('{$username}', '{$password}', '{$status}', '{$current_date}')";
                if(mysqli_query($con,$query)){

                    $output='{"status":"success", "remark":"Your account is created. please login and enjoy MoneyBags"}';
                }else{
                    $output='{"status":"failure", "remark":"Something is wrong with query"}';
                }
            }else{
                //user exist
                $output='{"status":"failure", "remark":"Username is already exist"}';
            }
        }else{
            $output='{"status":"failure", "remark":"Invalid or Incomplete password recieved"}';
        }
    }else{
      $output='{"status":"failure", "remark":"Invalid or Incomplete username recieved"}';
    }
}else{
      $output='{"status":"failure", "remark":"This feature is disabled."}';
}

echo $output;
mysqli_close($con);
   
?>