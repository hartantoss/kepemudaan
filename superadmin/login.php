<?php
  include '../connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhai|Lato&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">    

    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="superadmin/css/superadmin.css">
    <link rel="icon" href="<?php echo $URL;?>/images/logo.png" type="image/x-icon">
    <title>DISPARPORA - Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(to right, #e6f2f7, #e6e7e8);
            font-family: 'Nunito', sans-serif;
        }
        .login-container {
            background: white;
            padding: 5px 30px 30px 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container img {
            width: 70%;
            margin-bottom: 10px;
        }
        .login-container input {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 12px;
        }
        .btn-login {
            background: #00bfa5;
            color: white;
            margin-top: 20px;
            border-radius: 8px;
            font-weight: bold;
        }
        .btn-login:hover {
            background: #008c7a;
        }
        .text-link {
            margin-top: 15px;
            display: block;
            color: #00bfa5;
            cursor: pointer;
        }
        .text-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="<?php echo $URL;?>/images/logo.png" alt="Logo">
        <h5>Selamat Datang</h5>
        <div class="input-field">
            <input type="text" id="email" placeholder="Email">
        </div>
        <div class="input-field">
            <input type="password" id="pass" placeholder="Password">
            <span class="material-icons" onclick="changePassType()" style="cursor:pointer; position:absolute; right:15px; top:50%; transform:translateY(-50%);">visibility</span>
        </div>
        <button class="btn blue btn-login col s12" onclick="login()">Login</button>
        <div id="failedLoginView" class="red lighten-3" style="padding:10px; display:none;"></div>
        <a href="<?php echo $URL;?>" class="text-link">Kembali ke beranda</a>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- <script>
        var passStat = 0;
        function changePassType() {
            var passField = document.getElementById("pass");
            passField.type = (passField.type === "password") ? "text" : "password";
        }
        function login() {
            var email = $("#email").val();
            var pass = $("#pass").val();
            $(".loadingBar").show();
            $.ajax({
                url: '<?php echo $URL; ?>/API/adminLogin',
                method: 'POST',
                data: {"username": email, "password": pass},
                success: function (data) {
                    var myResponse = JSON.parse(JSON.stringify(data));
                    if (myResponse.message == "Account Found") {
                        localStorage.setItem("token", myResponse.token);
                        localStorage.setItem("username", myResponse.data.username);
                        window.location = "<?php echo $URL; ?>/admin/homepage";
                    } else {
                        $("#failedLoginView").text(myResponse.message).show();
                    }
                    $(".loadingBar").hide();
                }
            });
        }
    </script> -->

    <script>
        $(document).ready(function(){
            $('.tooltipped').tooltip();
            $(".sidenav").sidenav();
            $(".tooltipped").tooltip();
            $(".collapsible").collapsible();
            $(".modal").modal();
            $('.dropdown-trigger').dropdown();
            localStorage.removeItem("kode");
            $("#lupaPassSection").css("display","none");


            // if(localStorage.getItem("privilege")=="SUPERADMIN")
            //   window.location="<?php echo $URL; ?>/admin/setting";
            // else if(localStorage.getItem("privilege")=="PEKERJA")
            //   window.location="<?php echo $URL; ?>/admin/profil";
            // else if(localStorage.getItem("privilege")=="PERUSAHAAN")
            //   window.location="<?php echo $URL; ?>/admin/profilPerusahaan";

        });

        var passStat=0;
        var myKey="";
        var myToken="";
        window.onkeypress = function(event) {
            // console.log(event.keyCode)
            if (event.keyCode == 13) {
                login();
            }
        };
        function changePassType(){

            if(passStat == 1){
                $("#pass").attr("type","password");
                $("#showPass").html("visibility");
                passStat=0;

            }

            else{
                $("#pass").attr("type","text");
                $("#showPass").html("visibility_off");
                passStat=1;
            }
        }


        function login(){
            var email = $("#email").val();
            var pass = $("#pass").val();
            $(".loadingBar").css("display","block");
            $.ajax({
                url: '<?php echo $URL; ?>/API/adminLogin',
                method: 'POST',
                data: {
                  // "username":enTh(email),
                  // "password":enTh(pass),
                  "username":email,
                  "password":pass,
                },
                
                success: function (data) {
                  var response= JSON.stringify(data);
                  var myResponse=JSON.parse(response);

                  // console.log(myResponse);
                  if(myResponse.message=="Account Found"){
                    if(parseInt(myResponse.data.status)==1){
                      localStorage.setItem("token", myResponse.token);
                      localStorage.setItem("iduser", myResponse.data.id);
                      localStorage.setItem("nama", myResponse.data.nama);
                      localStorage.setItem("username", myResponse.data.username);
                      localStorage.setItem("privilege", myResponse.data.jenis);
                      localStorage.setItem("avatar", myResponse.data.avatar);
                      localStorage.setItem("statusAccount", parseInt(myResponse.data.status));
                      $("#failedLoginView").css("display","none");
                      $(".loadingBar").css("display","none");
                      window.location="<?php echo $URL; ?>/admin/homepage";
                    }
                    else{
                      localStorage.setItem("username", myResponse.data.username);
                      window.location="<?php echo $URL; ?>/verifikasi";
                    }
                  }
                  else{
                    $("#failedLoginView").html(myResponse.message);
                    $("#failedLoginView").css("display","block");
                    $(".loadingBar").css("display","none");
                  }
                  // console.log(JSON.stringify(myResponse.token));
                  // alert(data);
                }
            });
        }

        function gotoVerification(){
          localStorage.setItem("username", $("#email").val());
          window.location="<?php echo $URL; ?>/verifikasi";
        }

        function openLogin(){
          $("#lupaPassSection").css("display","none");
          $("#loginSection").css("display","block");
        }
        function openLupaPass(){
          $("#lupaPassSection").css("display","block");
          $("#loginSection").css("display","none");
        }

        function sendKode(){

          var email = $("#emailSendCode").val();
          $(".loadingBar").css("display","block");
          $.ajax({
              url: '<?php echo $URL; ?>/API/sendKey',
              method: 'POST',
              data: {
                // "username":enTh(email),
                // "password":enTh(pass),
                "email":email,
              },
              
              success: function (data) {
                var response= JSON.stringify(data);
                var myResponse=JSON.parse(response);

                // console.log(myResponse.data);
                if(myResponse.response_status=="true"){
                  myKey=myResponse.data.kode;
                  myToken=myResponse.data.token;
                  $("#resetPassSection").css("display","block");
                  $("#sendCodeSection").css("display","none");
                  showAlert(myResponse.message);
                }
                else{
                  $("#failedSendKeyView").html(myResponse.message);
                }
                // console.log(JSON.stringify(myResponse.token));
                // alert(data);
                $(".loadingBar").css("display","none");
              }
          });
          
        }


        function resetPass(){

          var email = $("#emailSendCode").val();
          var key = $("#keyReset").val();
          var password = $("#passwordReset").val();
          var cpassword = $("#cpasswordReset").val();
          $(".loadingBar").css("display","block");

          if(key==myKey&&password==cpassword){
            // console.log("sesuai");
            $.ajax({
                url: '<?php echo $URL; ?>/API/lupaPassword',
                method: 'POST',
                data: {
                  "token":myToken,
                  "email":email,
                  "password":password,
                },
                
                success: function (data) {
                  var response= JSON.stringify(data);
                  var myResponse=JSON.parse(response);

                  // console.log(myResponse);
                  $("#resetPassStatusView").html(myResponse.message);
                  showAlert(myResponse.message);
                  // console.log(JSON.stringify(myResponse.token));
                  // alert(data);
                }
            });
          }
          else{
            $("#resetPassStatusView").html("Maaf Key yang anda inputkan salah atau password tidak sesuai");
            showAlert("Maaf Key yang anda inputkan salah atau password tidak sesuai");
          }
          $(".loadingBar").css("display","none");
        }


        function showAlert(message){
          M.toast({html: `<div class="white" style="border-top:solid 2px #346eeb; margin:-20px -30px -20px -30px; padding:10px 20px 10px 20px; color:black; box-shadow: 5px 5px 5px #aaaaaa; ">${message}</div>`});
        }
    </script>
</body>
</html>
