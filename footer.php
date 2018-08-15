
  <!--  Scripts-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <script src="assets/js/materialize.js"></script>
  <script src="assets/js/init.js"></script>
  <script src="assets/amcharts/amcharts.js" type="text/javascript"></script>
  <script src="assets/amcharts/pie.js" type="text/javascript"></script>
  <script src="assets/amcharts/plugins/dataloader/dataloader.min.js" type="text/javascript"></script>
  <script src="assets/pagination/pagination.js" type="text/javascript"></script>

  </body>
</html>

<script>
$(document).ready(function(){
    $('.modal').modal();
    $('select').material_select();

    //**************************************************login modal function*************************************
    $('#login_btn').click(function(){
        $.post("userapi/user/login.php",
        {
          username:$("#login_username").val(),
          password:$("#login_password").val()
        },function(data){
          console.log(data);
          var arr=JSON.parse(data);
          if(arr["status"]=="success"){
            $("#login_username").val("");
            $("#login_password").val("");
            Materialize.toast(arr["remark"], 4000, "w3-teal");
            location.reload();
          }else{
            Materialize.toast(arr["remark"], 4000, "w3-pink");
          }
        });
    });
    $('#login_username').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#login_btn').click();//Trigger search button click event
        }
    });
    $('#login_password').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#login_btn').click();//Trigger search button click event
        }
    });

    //**************************************************register modal function*************************************
    $('#register_btn').click(function(){
      var register_username=$("#register_username").val();
      var register_password=$("#register_password").val();
      var register_c_password=$("#register_c_password").val();

      if(register_password==register_c_password){
        $.post("userapi/user/register.php",
        {
          username:$("#register_username").val(),
          password:$("#register_password").val()
        },function(data){
          console.log(data);
          var arr=JSON.parse(data);
          if(arr["status"]=="success"){
            $("#register_username").val("");
            $("#register_password").val("");
            $("#register_c_password").val("");
            Materialize.toast(arr["remark"], 4000, "w3-teal");
            location.reload();
          }else{
            Materialize.toast(arr["remark"], 4000, "w3-pink");
          }
        });
      }else{
        Materialize.toast("Password & Confirm Password is not same", 4000, "w3-pink");
      }
    });
    $('#register_username').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#register_btn').click();//Trigger search button click event
        }
    });
    $('#register_password').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#register_btn').click();//Trigger search button click event
        }
    });
    $('#register_c_password').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#register_btn').click();//Trigger search button click event
        }
    });

    //*******************************************************logout section**********************************
    $(".logout_btn").click(function(){
      $.post("userapi/user/logout.php","",
        function(data){
          var arr=JSON.parse(data);
          if(arr["status"]=="success"){
            Materialize.toast(arr["remark"], 4000, "w3-teal");
            location.replace("index.php");
          }else{
            Materialize.toast(arr["remark"], 4000, "w3-pink");
          }
      })
    });
});

//*************************************cart function***************************
$(".cart").click(function(){
  $.post("userapi/cart/cart_list.php",
  {

  },function(data){
    // console.log(data);
    var out="", total, sum=0;;
    var arr=JSON.parse(data);
    if(arr["status"]=="success"){
      out+='<h5>My Cart ( '+arr["cart"].length+' )</h5>';
      out+='<table class="bordered responsive-table">';
        out+='<thead>';
          out+='<tr>';
            out+='<th></th>';
            out+='<th>Item</th>';
            out+='<th>Price</th>';
            out+='<th>Quantity</th>';
            out+='<th>Total</th>';
          out+='</tr>';
        out+='</thead>';
        out+='<tbody>';

        for(i=0;i<arr["cart"].length;i++){
          out+='<tr>';
          out+='<td><a class="tooltipped w3-text-teal cart_remove" data-cart_id="'+arr["cart"][i]["cart_id"]+'" href="#" data-position="top" data-tooltip="Remove from cart"><i class="fa fa-close"></i></a></td>';
          out+='<td>'+arr["cart"][i]["name"]+'</td>';
          out+='<td><i class="fa fa-inr"></i> '+arr["cart"][i]["amount"]+'</td>';
          out+='<td>'+arr["cart"][i]["quantity"]+'</td>';
          total=parseInt(arr["cart"][i]["amount"])*parseInt(arr["cart"][i]["quantity"]);
          sum+=total;
          out+='<td><i class="fa fa-inr"></i> '+total+'</td>';
          out+='</tr>';
        }
        out+='<td></td>';
        out+='<td></td>';
        out+='<td></td>';
        out+='<td>Total</td>';
        out+='<td><i class="fa fa-inr"></i> '+sum+'</td>';

        out+='</tbody>';
      out+='</table>';

      out+='<div class="row">';
        out+='<a href="#!" class="waves-effect waves-light btn w3-teal right" id="order">Place Order</a>';
      out+='</div>';
    }else{
      out+='<h5 class="w3-center">'+arr["remark"]+'</h5>';
    }
    $("#cart_list").html(out);
    $('.tooltipped').tooltip();
  });
});

$("body").on("click",".cart_remove",function(){
  var cart_id=$(this).data("cart_id");
  $.post("userapi/cart/cart_delete.php",
  {
    cart_id:cart_id
  },function(data){
    // console.log(data);
    var arr=JSON.parse(data);
    if(arr["status"]=="success"){
      $(".cart").click();
      Materialize.toast(arr["remark"], 4000, "w3-teal");
    }else{
      Materialize.toast(arr["remark"], 4000, "w3-pink");
    }
  });
});

$("body").on("click","#order",function(){
  $.post("userapi/order/order_place.php",
  {

  },function(data){
    // console.log(data);
    var arr=JSON.parse(data);
    if(arr["status"]=="success"){
      Materialize.toast(arr["remark"], 4000, "w3-teal");
      window.location="order.php";
    }else{
      Materialize.toast(arr["remark"], 4000, "w3-pink");
    }
  });
});

//*************************************************************function for set page title************************
function set_page_name(name){
  $("#page_name").html(' / '+name);
}

function get_color(status){
  if(status=="0") return "w3-text-pink";
  else if(status=="1") return "w3-text-teal";
  else return "w3-text-black";
}

function get_order_color(status){
  if(status=="-1") return "w3-text-pink";
  else if(status=="1") return "w3-text-teal";
  else if(status=="0") return "w3-text-black";
  else return "w3-text-black";
}

function set_tab(name){
  $("."+name).addClass("w3-teal");
}

</script>