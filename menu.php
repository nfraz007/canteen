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

<!-- Add cart Modal Structure -->
<div id="cart_add" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="col l6 m6 s12">
				<h5>Add to cart</h5>
				<p>Please enter the quantity</p>
			</div>
			<div class="col l6 m6 s12">
				<input type="hidden" id="cart_add_menu_id" value="0">
				<div class="input-field">
				  <input id="cart_add_quantity" type="number" value="1" min="1" class="validate">
				  <label for="cart_add_quantity">Quantity</label>
				</div>
				<button class="waves-effect waves-light btn w3-teal" id="cart_add_btn">Add to Cart</button>
			</div>
		</div>
	</div>
</div>

<?php require_once 'footer.php';?>

<script>
$("document").ready(function(){
	set_page_name("Menu");
	set_tab("menu");
	print_data();
});

function print_data(){
	print_breakfast();
	print_lunch();
	print_dinner();
}

function print_breakfast(){
	$.post("userapi/menu/menu_list.php",
	{
		breakfast:1
	},function(data){
		var arr=JSON.parse(data);
		var out='<li class="collection-header"><h4>Breakfast</h4></li>';
	
		if(arr["status"]=="success"){
			for(i=0;i<arr["menu"].length;i++){
				out+='<a class="collection-item tooltipped cart_add" data-menu_id="'+arr["menu"][i]["menu_id"]+'" href="#cart_add" data-position="top" data-tooltip="Add to cart">'+arr["menu"][i]["name"]+'<span class="badge w3-text-teal"><i class="fa fa-inr"></i>'+arr["menu"][i]["amount"]+'</span></a>';
			}
		}else{
			out+='<li class="collection-item">'+arr["remark"]+'</li>';
		}
		$("#breakfast").html(out);
		$('.tooltipped').tooltip();
	});
}

function print_lunch(){
	$.post("userapi/menu/menu_list.php",
	{
		lunch:1
	},function(data){
		var arr=JSON.parse(data);
		var out='<li class="collection-header"><h4>Lunch</h4></li>';
	
		if(arr["status"]=="success"){
			for(i=0;i<arr["menu"].length;i++){
				out+='<a class="collection-item tooltipped cart_add" data-menu_id="'+arr["menu"][i]["menu_id"]+'" href="#cart_add" data-position="top" data-tooltip="Add to cart">'+arr["menu"][i]["name"]+'<span class="badge w3-text-teal"><i class="fa fa-inr"></i>'+arr["menu"][i]["amount"]+'</span></a>';
			}
		}else{
			out+='<li class="collection-item">'+arr["remark"]+'</li>';
		}
		$("#lunch").html(out);
		$('.tooltipped').tooltip();
	});
}

function print_dinner(){
	$.post("userapi/menu/menu_list.php",
	{
		dinner:1
	},function(data){
		var arr=JSON.parse(data);
		var out='<li class="collection-header"><h4>Dinner</h4></li>';
	
		if(arr["status"]=="success"){
			for(i=0;i<arr["menu"].length;i++){
				out+='<a class="collection-item tooltipped cart_add" data-menu_id="'+arr["menu"][i]["menu_id"]+'" href="#cart_add" data-position="top" data-tooltip="Add to cart">'+arr["menu"][i]["name"]+'<span class="badge w3-text-teal"><i class="fa fa-inr"></i>'+arr["menu"][i]["amount"]+'</span></a>';
			}
		}else{
			out+='<li class="collection-item">'+arr["remark"]+'</li>';
		}
		$("#dinner").html(out);
		$('.tooltipped').tooltip();
	});
}

$("body").on("click",".cart_add",function(){
	var menu_id=$(this).data("menu_id");
	$("#cart_add_menu_id").val(menu_id);
});

$("#cart_add_btn").click(function(){
	var menu_id=$("#cart_add_menu_id").val();
	var quantity=$("#cart_add_quantity").val();

	$.post("userapi/cart/cart_add.php",
	{
		menu_id:menu_id,
		quantity:quantity
	},function(data){
		// console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$('#cart_add').modal('close');
			Materialize.toast(arr["remark"], 4000, "w3-teal");
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	})
});

$('#cart_add_quantity').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#cart_add_btn').click();//Trigger search button click event
    }
});

</script>