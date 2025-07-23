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
      <!-- Compiled and minified CSS -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
      <link rel="stylesheet" href="superadmin/css/superadmin.css">

      <meta name="description" content="Pemetaan Ekonomi Kreatif Kota Batu" />
      <meta name="keywords" content="Kabupaten Nganjuk" />
      <meta name="author" content="Dandi Wibowo" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
      <meta charset="utf-8">
      <link rel="icon" href="<?php echo $URL;?>/images/logo.png" type="image/x-icon" />
      <title>Dinas Tenaga Kerja Kabupaten Situbondo</title>
    </head>

    <body class="row" style="margin:0px; padding:0px; background-image: linear-gradient(to right, #e6f2f7, #e6e7e8); height: 100vh;">
      <div class="col s10 m6 l4 push-s1 push-m3 push-l4" style="background:white; margin-top: 5%; padding:2%; font-family: 'Nunito', sans-serif;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
        <!-- Header  -->
        <div class="col s12" style="padding-bottom:20px; border-bottom: 3px solid <?php echo $BASE_BG_COLOR;?>;">
          <div class="col s3">
            <img src="<?php echo $URL;?>/images/logo.png" style="width:90%;" alt="">
          </div>
          <div class="col s9">
            <div class="col s12" style="font-size:25px; font-weight:bold">Selamat Datang</div>
            <div class="col s12" style="font-size:17px; font-weight:bold">Dinas Kertenagakerjaan</div>
            <div class="col s12 grey-text lighten-1-text"><i class="left material-icons">pin_drop</i>Kabupaten Situbondo</div>
          </div>
        </div>

         <!-- Body Form -->
        <div class="col s12" style="margin-top:30px;">
          <div class="col s12 my-text-input">
            <span>Email:</span> 
            <input type="text" id="email" placeholder="Email" style="color:#00bfa5;" onchange="isPasswordGood()">
          </div>

          <div class="col s12 my-text-input">
            <span>Buat Password:</span> 
            <input oninput="isPasswordSame()" id="pass" class="col s10" type="password" placeholder="Password" style="color:#00bfa5;">
            <a id="showPass" onclick="changePassType(0)" href="#" class="material-icons col s1">visibility</a>
          </div>
          <div class="col s12 my-text-input">
            <span>Konfirmasi Password:</span> 
            <input oninput="isPasswordSame()" id="cPass" class="col s10" type="password" placeholder="Password" style="color:#00bfa5;">
            <a id="showCPass" onclick="changePassType(1)" href="#" class="material-icons col s1">visibility</a>
          </div>
          
          <div class="input-field col s12" style="padding:0px; margin:0px; color:#00bfa5;">
            <select id="jenis" onchange="isPasswordGood()">
              <option value="" disabled selected>Pilih Akun</option>
              <option value="PERUSAHAAN">Perusahaan</option>
              <option value="PEKERJA">Pencari Kerja/Pekerja</option>
            </select>
          </div>
          <div class="progress" id="loadingBar" style="display:none;">
            <div class="indeterminate"></div>
          </div>
          <div class="col s12" id="noteView" style="border:1px solid silver; border-radius:10px;">
              <p><b>Akun dan Password harus memenuhi ketentuan berikut : </b></p>
              <ul>
                <li id="emailCheck" class="red-text">Menuliskan email</li>
                <li id="angkaCheck" class="red-text">Mengandung angka</li>
                <li id="spcialCheck" class="red-text">Mengandung spesial karakter</li>
                <li id="more8Check" class="red-text">Lebih dari 8 karakter</li>
                <li id="typeCheck" class="red-text">Pilih tipe akun</li>
              </ul>
          </div>
          <div class="btn col s12 disabled" id="registButton"  style="margin-top:30px;"  onclick="registrasi()">Registrasi</div>
          <div class="col s12 " style="text-align:center; padding :20px;">
            <a href="<?php echo $URL;?>/login">Kembali ke Halaman Login</a>
          </div>
        </div>
      </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	  <script>
        $(document).ready(function(){
            $('.tooltipped').tooltip();
            $(".sidenav").sidenav();
            $(".tooltipped").tooltip();
            $(".collapsible").collapsible();
            $(".modal").modal();
            $('.dropdown-trigger').dropdown();
            $('select').formSelect();
            $("#registButton").css("display","none");
        });

        var passStat=0;
        var cPassStat=0;
        
        // window.onkeypress = function(event) {
        //     // console.log(event.keyCode)
        //     if (event.keyCode == 13) {
        //         login();
        //     }
        // };
        function changePassType(x){
          if(x==0){
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
          else if(x==1){
            if(cPassStat == 1){
                $("#cPass").attr("type","password");
                $("#showCPass").html("visibility");
                passStat=0;

            }

            else{
                $("#cPass").attr("type","text");
                $("#showCPass").html("visibility_off");
                cPassStat=1;
            }
          }
        }

        function isPasswordSame(){
          pass = $("#pass").val();
          cPass = $("#cPass").val();
          if(pass==cPass){
            $("#registButton").removeClass("disabled");
            $("#registButton").css("disabled");
          }
          isPasswordGood();
        }

        function registrasi(){
            var email = $("#email").val();
            var pass = $("#pass").val();
            var jenis = $("#jenis").val();
            $("#loadingBar").css("display","block");
            $.ajax({
                url: '<?php echo $URL; ?>/API/registrasi',
                method: 'POST',
                data: {
                  "username":email,
                  "password":pass,
                  "jenis":jenis,
                },
                
                success: function (data) {
                  var response= JSON.stringify(data);
                  var myResponse=JSON.parse(response);

                  // console.log(myResponse);
                  if(myResponse.response_status=="true"){
                    localStorage.setItem("token", myResponse.token);
                    localStorage.setItem("iduser", -1);
                    localStorage.setItem("kodeVerifikasi", myResponse.data);
                    localStorage.setItem("nama", myResponse.data.nama);
                    localStorage.setItem("username", myResponse.data.username);
                    localStorage.setItem("privilege", myResponse.data.jenis);
                    localStorage.setItem("avatar", myResponse.data.avatar);
                    localStorage.setItem("kode", myResponse.data.kode);
                    localStorage.setItem("statusAccount", parseInt(myResponse.data.status))

                    // console.log(myResponse);
                    $("#loadingBar").css("display","none");
                    window.location.href = "<?php echo $URL;?>/verifikasi";
                  }
                  else{
                    
                    alert(myResponse.message);
                    $("#loadingBar").css("display","none");
                  }
                  // console.log(JSON.stringify(myResponse.token));
                  // alert(data);
                }
            });
        }

        // function registrasi(){
        //   window.location.href = "<?php echo $URL;?>/verifikasi"
        // }

        function containsLetter(str) {
            // RegExp untuk memeriksa apakah string mengandung setidaknya satu huruf
            const letterRegex = /[a-zA-Z]/;
            return letterRegex.test(str);
        }
        function containsNumber(str) {
            // RegExp untuk memeriksa apakah string mengandung setidaknya satu angka
            const numberRegex = /\d/;
            return numberRegex.test(str);
        }
        function containsSpecialCharacter(str) {
            // RegExp untuk memeriksa apakah string mengandung setidaknya satu karakter spesial
            const specialCharacterRegex = /[!@#$%^&*(),.?":{}|<>]/;
            return specialCharacterRegex.test(str);
        }

        function isPasswordGood(){
            var myPass=$("#pass").val();
            var myJenis=$("#jenis").val();
            var myEmail=$("#email").val();
            var isContainNumber=false;
            var isContainSpecial=false;
            var isMoreThan8=false;
            var jenisType=false;
            var emailFilled=false;

            $("#noteView").css("display","block");
            if(containsNumber(myPass)){
                $("#angkaCheck").removeClass("red-text");
                $("#angkaCheck").addClass("green-text");
                isContainNumber=true;
            }
            else{
                $("#angkaCheck").removeClass("green-text");
                $("#angkaCheck").addClass("red-text");
                isContainNumber=false;
            }
            if(containsSpecialCharacter(myPass)){
                $("#spcialCheck").removeClass("red-text");
                $("#spcialCheck").addClass("green-text");
                isContainSpecial=true;
            }
            else{
                $("#spcialCheck").removeClass("green-text");
                $("#spcialCheck").addClass("red-text");
                isContainSpecial=false;
            }
            if(myPass.length>8){
                $("#more8Check").removeClass("red-text");
                $("#more8Check").addClass("green-text");
                isMoreThan8=true;
            }
            else{
                $("#more8Check").removeClass("green-text");
                $("#more8Check").addClass("red-text");
                isMoreThan8=false;
            }
            if(myJenis=="PEKERJA"||myJenis=="PERUSAHAAN"){
                $("#typeCheck").removeClass("red-text");
                $("#typeCheck").addClass("green-text");
                jenisType=true;
            }
            else{
                $("#typeCheck").removeClass("green-text");
                $("#typeCheck").addClass("red-text");
                jenisType=false;
            }
            if(myEmail!=""){
                $("#emailCheck").removeClass("red-text");
                $("#emailCheck").addClass("green-text");
                emailFilled=true;
            }
            else{
                $("#emailCheck").removeClass("green-text");
                $("#emailCheck").addClass("red-text");
                emailFilled=false;
            }


            if(isContainNumber&&isContainSpecial&&isMoreThan8&&jenisType&&emailFilled){
                $("#registButton").css("display","block")
            }
            else{
                $("#registButton").css("display","none")
            }
        }
    </script>

    </body>
  </html>
        