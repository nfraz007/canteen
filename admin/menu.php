<?php require_once 'header.php' ?>

<div class="container">
	<div class="w3-padding-8"></div>
	<div class="row">
		<div class="col s12">
			<ul class="collapsible" data-collapsible="accordion">
			    <li>
			      <div class="collapsible-header w3-center">Filter</div>
			      <div class="collapsible-body row">
			      	<div class="col l6 m6 s12">
			      		<nav>
						    <div class="nav-wrapper w3-teal">
						      <form>
						        <div class="input-field">
						          <input type="search" id="search" placeholder="Search" required>
						          <label class="label-icon" for="search"><i class="fa fa-search"></i></label>
						          <i class="fa fa-close"></i>
						        </div>
						      </form>
						    </div>
						</nav>
			      	</div>
			      	<div class="col l6 m6 s12">
			      		<div class="input-field">
							<select id="limit">
							  <option value="" disabled selected>Choose your option</option>
							  <option value="20" selected>20</option>
							  <option value="50">50</option>
							  <option value="100">100</option>
							</select>
							<label>Limit</label>
						</div>
			      	</div>
			      	<div class="col l12 m12 s12">
			      		<p class="col l4 m4 s12">
					      <input name="radio_filter" class="radio_filter" type="radio" value="" id="all" checked />
					      <label for="all">All</label>
					    </p>
					    <p class="col l4 m4 s12">
					      <input name="radio_filter" class="radio_filter" type="radio" value="1" id="active" />
					      <label for="active">Active</label>
					    </p>
					    <p class="col l4 m4 s12">
					      <input name="radio_filter" class="radio_filter" type="radio" value="0" id="inactive" />
					      <label for="inactive">Inactive</label>
					    </p>
			      	</div>
			      </div>
			    </li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div id="content">
			<div class="progress">
			  	<div class="indeterminate"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="pagination" id="pagination"></div>
	</div>
	<div class="row">
		<div class="fixed-action-btn">
		    <a class="btn-floating btn-large w3-teal tooltipped" href="#menu_add" data-position="left" data-tooltip="Add Menu"><i class="large fa fa-plus"></i></a>
	  	</div>
	</div>
	<div class="w3-padding-24"></div>
</div>

<!-- Add menu Modal Structure -->
<div id="menu_add" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="input-field col s12">
			  <input id="menu_add_name" type="text" class="validate" data-length="50">
			  <label for="menu_add_name">Name</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
			  <input id="menu_add_amount" type="number" min="0" class="validate">
			  <label for="menu_add_amount">Amount</label>
			</div>
		</div>
		<div class="row w3-center">
			<button class="waves-effect waves-light btn w3-teal" id="menu_add_btn">Add Menu</button>
		</div>
	</div>
</div>

<!-- Edit menu Modal Structure -->
<div id="menu_edit" class="modal">
	<div class="modal-content">
		<input type="hidden" id="menu_edit_menu_id">
		<div class="row">
			<div class="input-field col s12">
			  <input id="menu_edit_name" type="text" class="validate" data-length="20">
			  <label for="menu_edit_name">Name</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
			  <input id="menu_edit_amount" type="number" min="0" class="validate">
			  <label for="menu_edit_amount">Amount</label>
			</div>
		</div>
		<div class="row">
			<p class="col s6">
		      <input name="menu_edit_status" class="menu_edit_status" type="radio" value="1" id="menu_edit_active" checked />
		      <label for="menu_edit_active">Active</label>
		    </p>
		    <p class="col s6">
		      <input name="menu_edit_status" class="menu_edit_status" type="radio" value="0" id="menu_edit_inactive" />
		      <label for="menu_edit_inactive">Inactive</label>
		    </p>
		</div>
		<div class="row w3-center">
			<button class="waves-effect waves-light btn w3-teal" id="menu_update_btn">Update menu</button>
		</div>
	</div>
</div>

<!-- Addto menu Modal Structure -->
<div id="menu_addto" class="modal">
	<div class="modal-content row">
		<div class="col l6 m6 s12">
			<h5>Add this menu</h5>
		</div>
		<input type="hidden" id="menu_addto_menu_id">
		<div class="col l6 m6 s12">
			<div class="row">
				<p>
			      <input type="checkbox" id="breakfast" value="1"/>
			      <label for="breakfast">Breakfast</label>
			    </p>
			</div>
			<div class="row">
				<p>
			      <input type="checkbox" id="lunch" value="1"/>
			      <label for="lunch">Lunch</label>
			    </p>
			</div>
			<div class="row">
				<p>
			      <input type="checkbox" id="dinner" value="1"/>
			      <label for="dinner">Dinner</label>
			    </p>
			</div>
			<div class="row w3-center">
				<button class="waves-effect waves-light btn w3-teal" id="menu_addto_btn">Add</button>
			</div>
		</div>
	</div>
</div>

<?php require_once 'footer.php' ?>

<script>
$("document").ready(function(){
	set_page_name("Menu");
	set_tab("menu");
	pagination();
});

function pagination(){
	var out="";
	var search=$("#search").val();
	var status=parseInt($('input:radio[name=radio_filter]:checked').val());
	var limit=$("#limit").val();
	$.post("../adminapi/menu/menu_list.php",
	{
		search:search,
		status:status,
		page:1,
		limit:limit
	},function(data){
		// console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$(".pagination").html("");
			$('.pagination').materializePagination({
			    lastPage: parseInt(arr["pagination"]),
			    onClickCallback: function(page){
			        print_data(page);
			    }
			});
		}else{
			out='<h4 class="w3-text-red w3-center">'+arr["remark"]+'</h4>';
			$(".pagination").html("");
		}
		$("#content").html(out);
	});
}

function print_data(page=1){
	var out="";
	var search=$("#search").val();
	var status=parseInt($('input:radio[name=radio_filter]:checked').val());
	var limit=$("#limit").val();
	$.post("../adminapi/menu/menu_list.php",
	{
		search:search,
		status:status,
		page:page,
		limit:limit
	},function(data){
		// console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			for(i=0;i<arr["menu"].length;i++){
				out+='<div class="col l6 m12 s12">';
					out+='<div class="card w3-hover-shadow w3-display-container">';
						out+='<div class="card-content row w3-padding-small">';
				  			out+='<div class="col s8">';
				  				out+='<a class="'+get_color(arr["menu"][i]["status"])+'"><h5>'+arr["menu"][i]["name"]+'</h5></a>';
				  			out+='</div>';
				  			out+='<div class="col s4 w3-right-align">';
				  				out+='<h5><i class="fa fa-inr"></i> '+arr["menu"][i]["amount"]+'</h5>';
				  			out+='</div>';
				  			out+='<div class="w3-display-middle w3-display-hover">';
				              	out+='<a id="menu_edit_btn" data-menu_id="'+arr["menu"][i]["menu_id"]+'" href="#menu_edit" class="waves-effect waves-light btn-floating w3-black w3-hover-teal tooltipped" data-position="top" data-tooltip="Edit"><i class="fa fa-pencil w3-medium"></i></a>&nbsp;';
				              	out+='<a id="menu_addto_list_btn" data-menu_id="'+arr["menu"][i]["menu_id"]+'" href="#menu_addto" class="waves-effect waves-light btn-floating w3-black w3-hover-teal tooltipped" data-position="top" data-tooltip="Add to Breadkfast/lunch/dinner"><i class="fa fa-plus w3-medium"></i></a>&nbsp;';
				  			out+='</div>';
			  			out+='</div>';
			    	out+='</div>';
				out+='</div>';
			}
		}else{
			out='<h4 class="w3-text-red w3-center">'+arr["remark"]+'</h4>';
		}
		$("#content").html(out);
		$('.modal').modal();
		$('.tooltipped').tooltip();
	});
}

$("#search").keyup(function(){
	pagination();
});

$(".radio_filter").change(function(){
	pagination();
});

$("#limit").change(function(){
	pagination();
});

//*********************************************add menu function*************************************
$("#menu_add_btn").click(function(){
	var name=$("#menu_add_name").val();
	var amount=$("#menu_add_amount").val();

	$.post("../adminapi/menu/menu_add.php",
	{
		name:name,
		amount:amount
	},function(data){
		// console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#menu_add_name").val("");
			$("#menu_add_amount").val("");
			Materialize.updateTextFields();
			pagination();
			$('#menu_add').modal('close');
			Materialize.toast(arr["remark"], 4000, "w3-teal");
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
});

$('#menu_add_name').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#menu_add_btn').click();//Trigger search button click event
    }
});

$('#menu_add_amount').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#menu_add_btn').click();//Trigger search button click event
    }
});

//*********************************************************menu edit get data function*****************************
$("body").on("click","#menu_edit_btn",function(){
	var menu_id=$(this).data("menu_id");
	$("#menu_edit_menu_id").val(menu_id);
	$.post("../adminapi/menu/menu_list.php",
	{
		menu_id:menu_id
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#menu_edit_name").val(arr["menu"][0]["name"]);
			$("#menu_edit_amount").val(arr["menu"][0]["amount"]);
			$("input:radio[name=menu_edit_status][value="+arr["menu"][0]["status"]+"]").prop('checked', true);
			Materialize.updateTextFields();
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
});

//***********************************************************menu update function*****************************
$("body").on("click","#menu_update_btn",function(){
	var menu_id=$("#menu_edit_menu_id").val();
	var name=$("#menu_edit_name").val();
	var amount=$("#menu_edit_amount").val();
	var status=$('input:radio[name=menu_edit_status]:checked').val();

	$.post("../adminapi/menu/menu_update.php",
	{
		menu_id:menu_id,
		name:name,
		amount:amount,
		status:status
	},function(data){
		// console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#menu_edit_menu_id").val("");
			$("#menu_edit_name").val("");
			$("#menu_edit_amount").val("");
			pagination();
			$('#menu_edit').modal('close');
			Materialize.toast(arr["remark"], 4000, "w3-teal");
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
});

$('#menu_edit_name').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#menu_update_btn').click();//Trigger search button click event
    }
});

$('#menu_edit_amount').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#menu_update_btn').click();//Trigger search button click event
    }
});

//**********************************************menu addto buttton function************************************

$("body").on("click","#menu_addto_list_btn",function(){
	var menu_id=$(this).data("menu_id");
	$("#menu_addto_menu_id").val(menu_id);
});

$("#menu_addto_btn").click(function(){
	var menu_id=$("#menu_addto_menu_id").val();
	var breakfast=$("#breakfast:checked").val();
	var lunch=$("#lunch:checked").val();
	var dinner=$("#dinner:checked").val();

	if(breakfast=="1") breakfast=1;
	else breakfast=0;

	if(lunch=="1") lunch=1;
	else lunch=0;

	if(dinner=="1") dinner=1;
	else dinner=0;

	$.post("../adminapi/menu/menu_addto.php",
	{
		menu_id:menu_id,
		breakfast:breakfast,
		lunch:lunch,
		dinner:dinner
	},function(data){
		// console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			Materialize.toast(arr["remark"], 4000, "w3-teal");
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	})
	$('#menu_addto').modal('close');
});

</script>