<?php require_once 'header.php'; ?>

<div class="container">
	<div class="w3-padding-24"></div>
	<div class="row">
		<div class="col l6 m6 s12">
		<h5>Password Settings</h5>
		</div>
		<div class="col l6 m6 s12">
			<div class="input-field">
			  <input id="old_password" type="password" class="validate">
			  <label for="old_password">Old Password</label>
			</div>
			<div class="input-field">
			  <input id="new_password" type="password" class="validate">
			  <label for="new_password">New Password</label>
			</div>
			<div class="input-field">
			  <input id="new_c_password" type="password" class="validate">
			  <label for="new_c_password">Confirm New Password</label>
			</div>
			<div class="w3-center">
				<button class="waves-effect waves-light btn w3-teal" id="password_btn">Update</button>
			</div>
		</div>
	</div>
	<div class="w3-padding-24"></div>
</div>

<?php require_once 'footer.php'; ?>

<script>

$("document").ready(function(){
	set_page_name("Settings");
	set_tab("settings");
});

$("#password_btn").click(function(){
	var old_password = $("#old_password").val();
	var new_password = $("#new_password").val();
	var new_c_password = $("#new_c_password").val();

	if(new_password==new_c_password){
		$.post("userapi/user/update_password.php",
			{
				old_password:old_password,
				new_password:new_password
			},function(data){
				//console.log(data);
				var arr=JSON.parse(data);
				if(arr["status"]=="success"){
					$("#old_password").val("");
					$("#new_password").val("");
					$("#new_c_password").val("");
					Materialize.updateTextFields();
					Materialize.toast(arr["remark"], 4000, "w3-teal");
				}else{
					Materialize.toast(arr["remark"], 4000, "w3-pink");
				}
			});
	}else{
		Materialize.toast("Confirm new password is not same", 4000, "w3-pink");
	}
});

</script>