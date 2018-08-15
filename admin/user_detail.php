<?php require_once 'header.php';
if(!isset($_REQUEST["id"]) || $_REQUEST["id"]=="") 
	header("Location: user.php");
?>

<div class="container">
	<div class="w3-padding-8"></div>
	<div class="row">
		<div class="col s12">
			<div id="detail"></div>
		</div>
	</div>
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
		    <a class="btn-floating btn-large w3-teal tooltipped" href="#amount_add" data-position="left" data-tooltip="Add Money"><i class="large fa fa-plus"></i></a>
	  	</div>
	</div>
	<div class="w3-padding-24"></div>
</div>

<!-- Add amount Modal Structure -->
<div id="amount_add" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="col l6 m6 s12">
				<h5>Add money to this user</h5>
			</div>
			<div class="col l6 m6 s12">
				<div class="input-field">
				  <input id="amount_add_amount" type="number" value="0" min="0" class="validate">
				  <label for="amount_add_amount">Amount</label>
				</div>
				<button class="waves-effect waves-light btn w3-teal" id="amount_add_btn">Add Money</button>
			</div>
		</div>
	</div>
</div>

<!-- order detail Modal Structure -->
<div id="order_detail" class="modal">
	<div class="modal-content">
		<div id="order_detail_list"></div>
	</div>
</div>

<?php require_once 'footer.php' ?>

<script>
var user_id=<?=$_REQUEST["id"];?>;

$("document").ready(function(){
	set_page_name("User");
	set_tab("user");
	user();
	pagination();
});

function user(){
	var out="";
	$.post("../adminapi/user/user_list.php",
	{
		user_id:user_id
	},function(data){
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			//out+='<h5>'+arr["user"][0]["username"]+'<span class="badge w3-text-teal w3-large"><i class="fa fa-inr"></i>'+arr["user"][0]["amount"]+'</span></h5>';
			out+='<h5>'+arr["user"][0]["username"]+'&nbsp;<button class="btn-flat w3-teal"><i class="fa fa-inr"></i> '+arr["user"][0]["amount"]+'</button></h5>';
		}else{
			out+='<h5>'+arr["remark"]+'</h5>';
		}
		$("#detail").html(out);
	})
}

function pagination(){
	var out="";
	var search=$("#search").val();
	var status=parseInt($('input:radio[name=radio_filter]:checked').val());
	var limit=$("#limit").val();
	$.post("../adminapi/order/order_list.php",
	{
		user_id:user_id,
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
	$.post("../adminapi/order/order_list.php",
	{
		user_id:user_id,
		search:search,
		status:status,
		page:page,
		limit:limit
	},function(data){
		// console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			for(i=0;i<arr["order"].length;i++){
				out+='<div class="col l6 m12 s12">';
					out+='<a href="#order_detail" data-order_id="'+arr["order"][i]["order_id"]+'" id="order_detail_btn">';
						out+='<div class="card w3-hover-shadow w3-text-black">';
							out+='<div class="card-content row w3-padding-small">';
					  			out+='<div class="col s8">';
					  				out+='<h5 class="'+get_order_color(arr["order"][i]["status"])+'">#'+arr["order"][i]["order_id"]+' '+arr["order"][i]["status_msg"]+'</h5>';
					  				out+='<p class="w3-small">'+arr["order"][i]["datetime"]+'</p>';
					  			out+='</div>';
					  			out+='<div class="col s4 w3-right-align">';
					  				out+='<h5><i class="fa fa-inr"></i> '+arr["order"][i]["amount"]+'</h5>';
					  			out+='</div>';
				  			out+='</div>';
				    	out+='</div>';
				    out+='</a>';
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

//*********************************************add amount function*************************************
$("#amount_add_btn").click(function(){
	var amount=$("#amount_add_amount").val();

	$.post("../adminapi/user/user_amount_add.php",
	{
		user_id:user_id,
		amount:amount
	},function(data){
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#amount_add_amount").val("");
			Materialize.updateTextFields();
			user();
			$('#amount_add').modal('close');
			Materialize.toast(arr["remark"], 4000, "w3-teal");
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
});

$('#amount_add_amount').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#amount_add_btn').click();//Trigger search button click event
    }
});

//********************************************order detail function***************************
$("body").on("click","#order_detail_btn",function(){
	var order_id=$(this).data("order_id");
	$.post("../adminapi/order/order_detail.php",
	{
		order_id:order_id
	},function(data){
		// console.log(data);
		var out="", total, sum=0;;
	    var arr=JSON.parse(data);
	    if(arr["status"]=="success"){
	      out+='<h5>#'+arr["order"][0]["order_id"]+' '+arr["order"][0]["username"]+'<span class="badge '+get_order_color(arr["order"][0]["status"])+'">'+arr["order"][0]["status_msg"]+'</span></h5>';
	      out+='<table class="bordered responsive-table">';
	        out+='<thead>';
	          out+='<tr>';
	            out+='<th>Item</th>';
	            out+='<th>Price</th>';
	            out+='<th>Quantity</th>';
	            out+='<th>Total</th>';
	          out+='</tr>';
	        out+='</thead>';
	        out+='<tbody>';

	        for(i=0;i<arr["order"].length;i++){
	          out+='<tr>';
	          out+='<td>'+arr["order"][i]["name"]+'</td>';
	          out+='<td><i class="fa fa-inr"></i> '+arr["order"][i]["amount"]+'</td>';
	          out+='<td>'+arr["order"][i]["quantity"]+'</td>';
	          total=parseInt(arr["order"][i]["amount"])*parseInt(arr["order"][i]["quantity"]);
	          sum+=total;
	          out+='<td><i class="fa fa-inr"></i> '+total+'</td>';
	          out+='</tr>';
	        }
	        out+='<td></td>';
	        out+='<td></td>';
	        out+='<td>Total</td>';
	        out+='<td><i class="fa fa-inr"></i> '+sum+'</td>';

	        out+='</tbody>';
	      out+='</table>';

	      if(arr["order"][0]["status"]=="0"){
	      	out+='<div class="row">';
		        out+='<a href="#!" class="waves-effect waves-light btn w3-teal right" id="order_accept_btn" data-order_id="'+arr["order"][0]["order_id"]+'">Accept Order</a>&nbsp;';
		        out+='<a href="#!" class="waves-effect waves-light btn w3-pink right" id="order_cancel_btn" data-order_id="'+arr["order"][0]["order_id"]+'">Cancel Order</a>';
		    out+='</div>';
	      }
	      out+='<p class="w3-text-teal right">'+arr["order"][0]["datetime"]+'</p>';
	    }else{
	      out+='<h5 class="w3-center">'+arr["remark"]+'</h5>';
	    }
	    $("#order_detail_list").html(out);
	});
});

$("body").on("click","#order_accept_btn",function(){
	var order_id=$(this).data("order_id");
	$.post("../adminapi/order/order_accept.php",
	{
		order_id:order_id
	},function(data){
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			pagination();
			$('#order_detail').modal('close');
			Materialize.toast(arr["remark"], 4000, "w3-teal");
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
});

$("body").on("click","#order_cancel_btn",function(){
	var order_id=$(this).data("order_id");
	$.post("../adminapi/order/order_cancel.php",
	{
		order_id:order_id
	},function(data){
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			user();
			pagination();
			$('#order_detail').modal('close');
			Materialize.toast(arr["remark"], 4000, "w3-teal");
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
});

</script>