<?php
require_once '../../include/config.php';

if(isset($_REQUEST["username"]) && $_REQUEST["username"]!=""){
  if(isset($_REQUEST["password"]) && $_REQUEST["password"]!="" && strlen($_REQUEST["password"])>=6){
    $username = filter_var($_REQUEST["username"], FILTER_SANITIZE_STRING);
    $password=md5($_REQUEST["password"]);

    $query="select * from `canteen_admin` where `username`='{$username}' and `password`='{$password}'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1){
      //return a valid user
      $row=mysqli_fetch_assoc($result);
      $admin_id=$row["admin_id"];
      $username=$row["username"];
      $status=$row["status"];

      if($status==1){
        $output = '{"status":"success","remark":"you are successfully login","admin_id":"'.$admin_id.'","username":"'.$username.'"}';
        $_SESSION["admin_id"]=$admin_id;
        $_SESSION["admin_username"]=$username;
      }else{
        $output='{"status":"failure", "remark":"Sorry you are blocked by Canteen"}';
      }
    }else{
      $output='{"status":"failure", "remark":"Invalid username or password recieved"}';
    }
  }else{
    $output='{"status":"failure", "remark":"Invalid or Incomplete password recieved"}';
  }
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete username recieved"}';
}

echo $output;
mysqli_close($con);
?>