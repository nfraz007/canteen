<?php

function  upload_file($myfile,$dir,$max_file_size=102400)
{
    $error=0;
    $obj=new stdClass();
    $file_name=rinse(time().$_FILES[$myfile]['name']);
    $file_name=str_replace(" ", "", $file_name);
    $file_add=$_FILES[$myfile]['tmp_name'];
    
    $file_size = $_FILES[$myfile]['size'];
    if ($_FILES[$myfile]['error'] !== UPLOAD_ERR_OK) 
    {
       $error=1;
       $message="File not uploaded properly.";
    }
    elseif (($file_size > $max_file_size))
    {      
        $message = 'File too large. File must be within '.($max_file_size/1024).' KB.'; 
        $error=1;
     }

     $info = getimagesize($_FILES[$myfile]['tmp_name']);
    if ($info === FALSE) 
    {
       $error=1;
       $message="Unable to determine image type of uploaded file";
    }

    if (($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) 
    {
       $error=1;
       $message="Only JPEG or PNG image allowed";
    }
    
    if($error==0)
    {
        if(move_uploaded_file($file_add,$dir."/".$file_name))
        {
            $message="file uploaded succesfuly";
        }
        else
        {
            $message = $_FILES[$myfile]['error'];
            $error=1;
                // $message=$dir;
        }
    }
    $obj->error=$error;
    $obj->message=$message;
    $obj->file_name=$file_name;

    return $obj;
  
}

function  upload_file_modified($myfile,$dir,$max_file_size=102400,$i)
{
    
    $error=0;
    $obj=new stdClass();
    $file_name=rinse(time().$_FILES[$myfile]['name'][$i]);
    $file_name=str_replace(" ", "", $file_name);
    $file_add=$_FILES[$myfile]['tmp_name'][$i];
    
    $file_size = $_FILES[$myfile]['size'][$i];
    if ($_FILES[$myfile]['error'][$i] !== UPLOAD_ERR_OK) 
    {
       $error=1;
       $message="File not uploaded properly.";
    }
    elseif (($file_size > $max_file_size))
    {      
        $message = 'File too large. File must be within '.($max_file_size/1024).' KB.'; 
        $error=1;
     }

    $info = getimagesize($_FILES[$myfile]['tmp_name'][$i]);
    $mime   = $info['mime'];
  
    if ($info === FALSE) 
    {
       $error=1;
       $message="Unable to determine image type of uploaded file";
    }
    
    if (($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) 
    {
       $error=1;
       $message="Only JPEG or PNG image allowed";
    }
    
    if($error==0)
    {
        if(move_uploaded_file($file_add,$dir."/".$file_name))
        {
            $message="file uploaded succesfuly";
        }
        else
        {
            $message = $_FILES[$myfile]['error'];
            $error=1;
                // $message=$dir;
        }
    }
    $obj->error=$error;
    $obj->message=$message;
    $obj->file_name=$file_name;

    return $obj;
  
}


function deleteImage($path)
{
    global $hostname;
    $new_path=str_replace($hostname, "", $path);
    if(strlen($new_path)!=0)
    {
        return unlink("../../".$new_path);
        // return "inside";
    }
    return "0";
}
        
function redirect_to( $location = NULL ) {
    if ($location != NULL) {
      header("Location: {$location}");
      exit;
    }
}

function clean($input)
 {
  return preg_replace('/[^A-Za-z0-9 ]/', '', $input); // Removes special chars.
 }
function rinse($input)
{
    return preg_replace('/[^A-Za-z0-9\-,@.\ ]/', '', $input); // Removes special chars.
}

 function numOnly($input)
 {
  return preg_replace('/[^0-9]/', '', $input); // Removes special chars.
 }

function securityToken(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring.=$characters[rand(0, strlen($characters))];
        }
        return $randstring;
}

function logincheck()
{
    global $con;

    if(isset($_SESSION["user_id"]))
    {
        $output='{"status":"success"}';
    }
    elseif(isset($_REQUEST["user_id"]) && isset($_REQUEST["security_token"]))
    {    
        $query="select `security_token` from `wryton_user` where `id`='".$_REQUEST["user_id"]."'";
        $result=mysqli_query($con,$query);
        $row=mysqli_fetch_array($result);
        if($row["security_token"]==$_REQUEST["security_token"]){
            $output='{"status":"success"}';
        }
        else
            $output='{"status":"failure","remark":"Incorrect Security token. User id entered is '.$_REQUEST["user_id"].' and security token entere is '.$_REQUEST["security_token"].'"}';
    }
    else
    {
        $output='{"status":"failure","remark":"You are not login, Please login"}';
    }

    $obj=json_decode($output,true);

    if($obj['status']!="success")
        die($output);
}

function admincheck()
{
    if(isset($_SESSION["admin_id"])){
        $output='{"status":"success"}';
    }else{
        $output='{"status":"failure","remark":"You are not login, Please login"}';
    }

    $obj=json_decode($output,true);

    if($obj['status']!="success")
        die($output);
}

function userLoginCheck()
{
    $data=logincheck();
    $arr=json_decode($data);
    if($arr->status!="success"){
        header("Location: index.php");
        die();
    }
}

function getIPAddress()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    }else{
        $ip = $remote;
    }
    return $ip;
}

function pagination($query,$limit){
    global $con;
    $limit=(int)$limit;
    $row_count=mysqli_num_rows(mysqli_query($con,$query));
    return ceil($row_count/$limit);
}

function menuList($obj){
    global $con;

    $menu=array();

    $query="select * from `canteen_menu` where ";

    if(isset($obj->menu_id) && $obj->menu_id!=""){
        $query.= "`menu_id` = ".$obj->menu_id." and ";
    }

    if(isset($obj->status) && $obj->status!=""){
        if($obj->status=="0")
            $query.= "`status` = 0 and ";
        elseif($obj->status=="1")
            $query.= "`status` = 1 and ";
        else $query.="";
    }
     
    if(isset($obj->search)  && $obj->search!=""){
        $search = clean($obj->search);
        $query.="( `name` like '%".$search."%' ) and ";
    }

    if(isset($obj->breakfast) && $obj->breakfast!=""){
        $query.= "`breakfast` = ".$obj->breakfast." and ";
    }

    if(isset($obj->lunch) && $obj->lunch!=""){
        $query.= "`lunch` = ".$obj->lunch." and ";
    }

    if(isset($obj->dinner) && $obj->dinner!=""){
        $query.= "`dinner` = ".$obj->dinner." and ";
    }

    $query.="1 order by `name` asc ";

    if(isset($obj->limit) && $obj->limit!=0){
        $limit=$obj->limit;
    }else{
        $limit=10;
    }

    if(isset($obj->page) && $obj->page!=0){
        $page=$obj->page;
    }else{
        $page=1;
    }

    $pagination=pagination($query,$limit);

    $query.=" limit {$limit} offset ".(($page-1)*$limit);
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))
        {
            $menu[] = $row;
        }
        $output='{"status":"success", "pagination":"'.$pagination.'", "menu":';
        $output.=json_encode($menu);
        $output.="}";
    }else{
         $output='{"status":"failure","remark":"No menu history found"}';
    }
    return $output;
}

function orderList($obj){
    global $con,$DATETIME_FORMAT;

    $order=array();

    $query="select * from `canteen_order` where ";

    if(isset($obj->order_id) && $obj->order_id!=""){
        $query.= "`order_id` = ".$obj->order_id." and ";
    }

    if(isset($obj->user_id) && $obj->user_id!=""){
        $query.= "`user_id` = ".$obj->user_id." and ";
    }

    if(isset($obj->status) && $obj->status!=""){
        if($obj->status=="0")
            $query.= "`status` = 0 and ";
        elseif($obj->status=="1")
            $query.= "`status` = 1 and ";
        elseif($obj->status=="-1")
            $query.= "`status` = -1 and ";
        else $query.="";
    }
     
    if(isset($obj->search)  && $obj->search!=""){
        $search = clean($obj->search);
        $query.="( `amount` like '%".$search."%' ) and ";
    }

    $query.="1 order by `datetime` desc ";

    if(isset($obj->limit) && $obj->limit!=0){
        $limit=$obj->limit;
    }else{
        $limit=10;
    }

    if(isset($obj->page) && $obj->page!=0){
        $page=$obj->page;
    }else{
        $page=1;
    }

    $pagination=pagination($query,$limit);

    $query.=" limit {$limit} offset ".(($page-1)*$limit);
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))
        {
            $row["datetime"]=date($DATETIME_FORMAT,strtotime($row["datetime"]));
            $row["status_msg"]=orderStatus($row["status"]);
            $order[] = $row;
        }
        $output='{"status":"success", "pagination":"'.$pagination.'", "order":';
        $output.=json_encode($order);
        $output.="}";
    }else{
         $output='{"status":"failure","remark":"No order history found"}';
    }
    return $output;
}

function orderDetail($obj){
    global $con,$DATETIME_FORMAT;

    $order=array();

    $query="select c.*,m.name,m.amount,o.datetime,o.amount as total_amount,o.status,u.username from `canteen_cart` c left join `canteen_menu` m on c.menu_id=m.menu_id left join `canteen_order` o on c.order_id=o.order_id left join `canteen_user` u on c.user_id=u.user_id where ";

    if(isset($obj->user_id) && $obj->user_id!=""){
        $query.= "c.`user_id` = ".$obj->user_id." and ";
    }

    if(isset($obj->order_id) && $obj->order_id!=""){
        $query.= "c.`order_id` = ".$obj->order_id." and ";
    }

    // $query.="m.status=1 and ";
    $query.="1 order by m.name asc ";

    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))
        {
            $row["datetime"]=date($DATETIME_FORMAT,strtotime($row["datetime"]));
            $row["status_msg"]=orderStatus($row["status"]);
            $order[] = $row;
        }
        $output='{"status":"success", "order":';
        $output.=json_encode($order);
        $output.="}";
    }else{
         $output='{"status":"failure","remark":"No Order history found"}';
    }
    return $output;
}

function orderStatus($value){
    if($value=="0") return "New Order";
    elseif($value=="1") return "Completed";
    elseif($value=="-1") return "Cancelled";
    else return "Error";
}

function cartList($obj){
    global $con;

    $cart=array();

    $query="select c.*,m.name,m.amount from `canteen_cart` c left join `canteen_menu` m on c.menu_id=m.menu_id where ";

    if(isset($obj->user_id) && $obj->user_id!=""){
        $query.= "c.`user_id` = ".$obj->user_id." and ";
    }

    $query.="c.order_id=0 and m.status=1 and ";
    $query.="1 order by m.name asc ";

    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))
        {
            $cart[] = $row;
        }
        $output='{"status":"success", "cart":';
        $output.=json_encode($cart);
        $output.="}";
    }else{
         $output='{"status":"failure","remark":"No item in cart"}';
    }
    return $output;
}

function orderCondition($user_id){
    global $con;

    $obj=(object)$_REQUEST;
    $obj->user_id=$user_id;
    $cart=json_decode(cartList($obj));

    $sum=0;
    if($cart->status=="success"){
        for($i=0;$i<sizeof($cart->cart);$i++){
            $amount=(int)$cart->cart[$i]->amount;
            $quantity=(int)$cart->cart[$i]->quantity;
            $sum+=$amount*$quantity;
        }

        $obj=(object)$_REQUEST;
        $obj->user_id=$user_id;
        $obj->status="1";
        $user=json_decode(userList($obj));

        if($user->status=="success"){
            $amount=(int)$user->user[0]->amount;
            if($amount>=$sum){
                $query="update `canteen_user` set `amount`=amount-{$sum} where `user_id`='{$user_id}'";
                $result=mysqli_query($con,$query);
                if($result){
                    return $sum;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function userList($obj){
    global $con;

    $user=array();

    $query="select * from `canteen_user` where ";

    if(isset($obj->user_id) && $obj->user_id!=""){
        $query.= "`user_id` = ".$obj->user_id." and ";
    }

    if(isset($obj->status) && $obj->status!=""){
        if($obj->status=="0")
            $query.= "`status` = 0 and ";
        elseif($obj->status=="1")
            $query.= "`status` = 1 and ";
        else $query.="";
    }
     
    if(isset($obj->search)  && $obj->search!=""){
        $search = clean($obj->search);
        $query.="( `username` like '%".$search."%' or `amount` like '%".$search."%' ) and ";
    }

    $query.="1 order by `username` asc ";

    if(isset($obj->limit) && $obj->limit!=0){
        $limit=$obj->limit;
    }else{
        $limit=10;
    }

    if(isset($obj->page) && $obj->page!=0){
        $page=$obj->page;
    }else{
        $page=1;
    }

    $pagination=pagination($query,$limit);

    $query.=" limit {$limit} offset ".(($page-1)*$limit);
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))
        {
            $row["password"]="";
            $user[] = $row;
        }
        $output='{"status":"success", "pagination":"'.$pagination.'", "user":';
        $output.=json_encode($user);
        $output.="}";
    }else{
         $output='{"status":"failure","remark":"No user found"}';
    }
    return $output;
}

function userExist($user_id){
    global $con;

    $query="select * from `canteen_user` where `status`=1 and `user_id`='{$user_id}'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1) return true;
    else return false;
}

function menuExist($menu_id){
    global $con;

    $query="select * from `canteen_menu` where `status`=1 and `menu_id`='{$menu_id}'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1) return true;
    else return false;
}

function orderExist($order_id){
    global $con;

    $query="select * from `canteen_order` where `order_id`='{$order_id}'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1) return true;
    else return false;
}

function getUserAmount($user_id){
    global $con;

    $query="select * from `canteen_user` where `user_id`='{$user_id}'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        return (int)$row["amount"];
    }
    else return false;
}

function crypto($action, $string) {
    //for encrypt e, for decrypt d
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'askjhSVSanckanSVSja353aRG5aSGSSasdSaSGSGSGsS3Sf5adS';
    $secret_iv = '3S5S53sgsgssdJgs5gs3gHs6sg5shfg3fJfdJhdh3Hdfgfh2hds';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' || $action=="e" ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' || $action=="d" ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

?>