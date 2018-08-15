
  <!--  Scripts-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <script src="../assets/js/materialize.js"></script>
  <script src="../assets/js/init.js"></script>
  <script src="../assets/amcharts/amcharts.js" type="text/javascript"></script>
  <script src="../assets/amcharts/pie.js" type="text/javascript"></script>
  <script src="../assets/amcharts/plugins/dataloader/dataloader.min.js" type="text/javascript"></script>
  <script src="../assets/pagination/pagination.js" type="text/javascript"></script>

  </body>
</html>

<script>
$(document).ready(function(){
    $('.modal').modal();
    $('select').material_select();

    //**************************************************login modal function*************************************
    $('#login_btn').click(function(){
        $.post("../adminapi/admin/login.php",
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

    //*******************************************************logout section**********************************
    $(".logout_btn").click(function(){
      $.post("../adminapi/admin/logout.php","",
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