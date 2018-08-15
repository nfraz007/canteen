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
			      		<p class="col l3 m3 s6">
					      <input name="radio_filter" class="radio_filter" type="radio" value="" id="all" checked />
					      <label for="all">All</label>
					    </p>
					    <p class="col l3 m3 s6">
					      <input name="radio_filter" class="radio_filter" type="radio" value="0" id="new_order" />
					      <label for="new_order">New Order</label>
					    </p>
					    <p class="col l3 m3 s6">
					      <input name="radio_filter" class="radio_filter" type="radio" value="1" id="completed" />
					      <label for="completed">Completed</label>
					    </p>
					    <p class="col l3 m3 s6">
					      <input name="radio_filter" class="radio_filter" type="radio" value="-1" id="cancelled" />
					      <label for="cancelled">Cancelled</label>
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
	<div class="w3-padding-24"></div>
</div>

<!-- order detail Modal Structure -->
<div id="order_detail" class="modal">
	<div class="modal-content">
		<div id="order_detail_list"></div>
	</div>
</div>

<?php require_once 'footer.php' ?>

<script>
$("document").ready(function(){
	set_page_name("Order");
	set_tab("order");
	pagination();
});

function pagination(){
	var out="";
	var search=$("#search").val();
	var status=parseInt($('input:radio[name=radio_filter]:checked').val());
	var limit=$("#limit").val();
	$.post("../adminapi/order/order_list.php",
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
	$.post("../adminapi/order/order_list.php",
	{
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
			pagination();
			$('#order_detail').modal('close');
			Materialize.toast(arr["remark"], 4000, "w3-teal");
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
});

</script>