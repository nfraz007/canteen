<?php require_once 'include/config.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Canteen</title>

  <!-- CSS  -->
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css"> -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

  <style>
	  	.pagination ul li{
	    padding-top:3px;
	    padding-right:10px;
	    padding-left:10px;
	}
  </style>
</head>
<body>
  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="index" class="brand-logo w3-hover-text-teal">Canteen<span class="w3-small" id="page_name"></span></a>
      <ul class="right hide-on-med-and-down">
      	<?php
      		if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!=""){
      			echo '<li><a href="menu.php" class="menu w3-hover-teal">Menu</a></li>';
      			echo '<li><a href="#cart" class="cart w3-hover-teal">Cart</a></li>';
      			echo '<li><a href="order.php" class="order w3-hover-teal">Order</a></li>';
      			echo '<li><a class="settings dropdown-button w3-hover-teal" data-activates="profile_dropdown" data-beloworigin="true">'.$_SESSION["username"].' ( <i class="fa fa-inr"></i> '.getUserAmount($_SESSION["user_id"]).' )</a></li>';
      			echo '<ul id="profile_dropdown" class="dropdown-content">';
    				echo '<li><a href="settings.php" class="w3-text-teal">Settings</a></li>';
    				echo '<li><a class="logout_btn w3-text-teal">Logout</a></li>';
    			echo '</ul>';
      		}else{
      			echo '<li><a href="admin" class="w3-hover-teal">Admin Panel</a></li>';
      			echo '<li><a href="#login" class="w3-hover-teal">Login / Register</a></li>';
      		}
      	?>
      </ul>

      <ul id="nav-mobile" class="side-nav">
      	<?php
      		if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!=""){
      			echo '<li><a class="w3-teal">'.$_SESSION["username"].' ( &#8377; '.getUserAmount($_SESSION["user_id"]).' )</a></li>';
      			echo '<li><a href="menu.php" class="menu w3-hover-teal">Menu</a></li>';
      			echo '<li><a href="#cart" class="cart w3-hover-teal">Cart</a></li>';
      			echo '<li><a href="order.php" class="order w3-hover-teal">Order</a></li>';
      			echo '<li><a href="settings.php" class="settings w3-hover-teal">Settings</a></li>';
				echo '<li><a class="logout_btn w3-hover-teal">Logout</a></li>';
      		}else{
      			echo '<li><a href="admin" class="w3-hover-teal">Admin Panel</a></li>';
      			echo '<li><a href="#login" class="w3-hover-teal">Login / Register</a></li>';
      		}
      	?>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse w3-text-teal"><i class="fa fa-bars"></i></a>
    </div>
  </nav>

<!-- Login Modal Structure -->
<div id="login" class="modal">
	<div class="modal-content row">
		<div class="col l6 m6 s12">
			<div class="row w3-center w3-text-teal">
				<h5>Login</h5>
			</div>
			<div class="row">
				<div class="input-field">
				  <input id="login_username" type="text" class="validate" value="user">
				  <label for="login_username">Username</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field">
				  <input id="login_password" type="password" class="validate" value="123456">
				  <label for="login_password">Password</label>
				</div>
			</div>
			<div class="row w3-center">
				<button class="waves-effect waves-light btn w3-teal" id="login_btn">Login</button>
			</div>
		</div>
		<div class="col l6 m6 s12">
			<div class="row w3-center w3-text-teal">
				<h5>Register</h5>
			</div>
			<div class="row">
				<div class="input-field">
				  <input id="register_username" type="text" class="validate">
				  <label for="register_username">Username</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field">
				  <input id="register_password" type="password" class="validate">
				  <label for="register_password">Password</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field">
				  <input id="register_c_password" type="password" class="validate">
				  <label for="register_c_password">Confirm Password</label>
				</div>
			</div>
			<div class="row w3-center">
				<button class="waves-effect waves-light btn w3-teal" id="register_btn">Register</button>
			</div>
		</div>
	</div>
</div>

<!-- Cart Modal Structure -->
<div id="cart" class="modal">
	<div class="modal-content">
		<div id="cart_list"></div>
	</div>
</div>
