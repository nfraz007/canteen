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
	<div class="w3-padding-24"></div>
</div>

<?php require_once 'footer.php' ?>

<script>
$("document").ready(function(){
	set_page_name("User");
	set_tab("user");
	pagination();
});

function pagination(){
	var out="";
	var search=$("#search").val();
	var status=parseInt($('input:radio[name=radio_filter]:checked').val());
	var limit=$("#limit").val();
	$.post("../adminapi/user/user_list.php",
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
	$.post("../adminapi/user/user_list.php",
	{
		search:search,
		status:status,
		page:page,
		limit:limit
	},function(data){
		// console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			for(i=0;i<arr["user"].length;i++){
				out+='<div class="col l6 m12 s12">';
					out+='<div class="card w3-hover-shadow">';
						out+='<div class="card-content row w3-padding-small">';
				  			out+='<div class="col s8">';
				  				out+='<a class="'+get_color(arr["user"][i]["status"])+'" href="user_detail?id='+arr["user"][i]["user_id"]+'"><h5>'+arr["user"][i]["username"]+'</h5></a>';
				  			out+='</div>';
				  			out+='<div class="col s4 w3-right-align">';
				  				out+='<h5><i class="fa fa-inr"></i> '+arr["user"][i]["amount"]+'</h5>';
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

</script>