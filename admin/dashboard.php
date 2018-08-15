<?php require_once 'header.php';?>

<div class="container">
	<div class="row">
		<div class="col s12 w3-center">
			<h5>Today's Menu</h5>
		</div>
	</div>
	<div class="row">
		<div class="col l4 m4 s12">
			<ul class="collection with-header" id="breakfast"></ul>
		</div>
		<div class="col l4 m4 s12">
			<ul class="collection with-header" id="lunch"></ul>
		</div>
		<div class="col l4 m4 s12">
			<ul class="collection with-header" id="dinner"></ul>
		</div>
	</div>
</div>

<?php require_once 'footer.php';?>

<script>
$("document").ready(function(){
	set_page_name("Dashboard");
	set_tab("dashboard");
	print_data();
});

function print_data(){
	print_breakfast();
	print_lunch();
	print_dinner();
}

function print_breakfast(){
	$.post("../adminapi/menu/menu_list.php",
	{
		breakfast:1
	},function(data){
		var arr=JSON.parse(data);
		var out='<li class="collection-header"><h4>Breakfast</h4></li>';
	
		if(arr["status"]=="success"){
			for(i=0;i<arr["menu"].length;i++){
				out+='<a class="collection-item tooltipped '+get_color(arr["menu"][i]["status"])+'" id="breakfast_btn" data-menu_id="'+arr["menu"][i]["menu_id"]+'" href="#" data-position="top" data-tooltip="Remove from Breadkfast">'+arr["menu"][i]["name"]+'<span class="badge w3-text-teal"><i class="fa fa-inr"></i>'+arr["menu"][i]["amount"]+'</span></a>';
			}
		}else{
			out+='<li class="collection-item">'+arr["remark"]+'</li>';
		}
		$("#breakfast").html(out);
		$('.tooltipped').tooltip();
	});
}

$("body").on("click","#breakfast_btn",function(){
	var menu_id=$(this).data("menu_id");
	swal({
	  title: "Are you sure ?",
	  text: "You want to remove this from breakfast",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Yes, remove it!",
	  closeOnConfirm: true
	},
	function(){
	  $.post("../adminapi/menu/menu_removeto.php",
	  {
	  	menu_id:menu_id,
	  	type:"breakfast"
	  },function(data){
	  	// console.log(data);
	  	var arr=JSON.parse(data);
	  	if(arr["status"]=="success"){
	  		print_breakfast();
			Materialize.toast(arr["remark"], 4000, "w3-teal");
	  	}else{
	  		Materialize.toast(arr["remark"], 4000, "w3-pink");
	  	}
	  });
	});
});

function print_lunch(){
	$.post("../adminapi/menu/menu_list.php",
	{
		lunch:1
	},function(data){
		var arr=JSON.parse(data);
		var out='<li class="collection-header"><h4>Lunch</h4></li>';
	
		if(arr["status"]=="success"){
			for(i=0;i<arr["menu"].length;i++){
				out+='<a class="collection-item tooltipped '+get_color(arr["menu"][i]["status"])+'" id="lunch_btn" data-menu_id="'+arr["menu"][i]["menu_id"]+'" href="#" data-position="top" data-tooltip="Remove from Lunch">'+arr["menu"][i]["name"]+'<span class="badge w3-text-teal"><i class="fa fa-inr"></i>'+arr["menu"][i]["amount"]+'</span></a>';
			}
		}else{
			out+='<li class="collection-item">'+arr["remark"]+'</li>';
		}
		$("#lunch").html(out);
		$('.tooltipped').tooltip();
	});
}

$("body").on("click","#lunch_btn",function(){
	var menu_id=$(this).data("menu_id");
	swal({
	  title: "Are you sure ?",
	  text: "You want to remove this from lunch",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Yes, remove it!",
	  closeOnConfirm: true
	},
	function(){
	  $.post("../adminapi/menu/menu_removeto.php",
	  {
	  	menu_id:menu_id,
	  	type:"lunch"
	  },function(data){
	  	// console.log(data);
	  	var arr=JSON.parse(data);
	  	if(arr["status"]=="success"){
	  		print_lunch();
			Materialize.toast(arr["remark"], 4000, "w3-teal");
	  	}else{
	  		Materialize.toast(arr["remark"], 4000, "w3-pink");
	  	}
	  });
	});
});

function print_dinner(){
	$.post("../adminapi/menu/menu_list.php",
	{
		dinner:1
	},function(data){
		var arr=JSON.parse(data);
		var out='<li class="collection-header"><h4>Dinner</h4></li>';
	
		if(arr["status"]=="success"){
			for(i=0;i<arr["menu"].length;i++){
				out+='<a class="collection-item tooltipped '+get_color(arr["menu"][i]["status"])+'" id="dinner_btn" data-menu_id="'+arr["menu"][i]["menu_id"]+'" href="#" data-position="top" data-tooltip="Remove from Dinner">'+arr["menu"][i]["name"]+'<span class="badge w3-text-teal"><i class="fa fa-inr"></i>'+arr["menu"][i]["amount"]+'</span></a>';
			}
		}else{
			out+='<li class="collection-item">'+arr["remark"]+'</li>';
		}
		$("#dinner").html(out);
		$('.tooltipped').tooltip();
	});
}

$("body").on("click","#dinner_btn",function(){
	var menu_id=$(this).data("menu_id");
	swal({
	  title: "Are you sure ?",
	  text: "You want to remove this from dinner",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Yes, remove it!",
	  closeOnConfirm: true
	},
	function(){
	  $.post("../adminapi/menu/menu_removeto.php",
	  {
	  	menu_id:menu_id,
	  	type:"dinner"
	  },function(data){
	  	var arr=JSON.parse(data);
	  	if(arr["status"]=="success"){
	  		print_dinner();
			Materialize.toast(arr["remark"], 4000, "w3-teal");
	  	}else{
	  		Materialize.toast(arr["remark"], 4000, "w3-pink");
	  	}
	  });
	});
});
</script>