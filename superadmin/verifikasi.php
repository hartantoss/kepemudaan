<?php
  include '../connect.php';
?>
<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
      
      <!-- Import Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
      
      <!-- Data Tables -->
      <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-1.13.6/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fh-3.4.0/kt-2.10.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.2.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.css" rel="stylesheet">
      
      <!-- Materializecss -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
      
      <!-- Custom Css -->
      <link rel="stylesheet" href="<?php echo $URL; ?>/superadmin/css/superadmin.css">

      <!-- Jquery -->
      <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
      <!-- MaterializeCSS -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

      <!-- Data Table -->
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-1.13.6/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.10.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.2.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.js"></script> -->
      <!-- Google Chart -->
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <!-- Google Map -->
      <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
      
      
      <meta name="description" content="Portal Tenaga Kerjaan Kabupaten Situbondo" />
      <meta name="keywords" content="Kabupaten Situbondo" />
      <meta name="author" content="Dandi Wibowo" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
      <meta charset="utf-8">
      <link rel="icon" href="<?php echo $URL;?>/images/logo.png" type="image/x-icon" />
      <title>Portal Tenaga Kerjaan Kabupaten Situbondo</title>

      <!-- Mobile Specific Meta-->
      <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body class="row" style="margin:0px; padding:0px; padding-top:10%; background:white; height: 100%;">

        <!--=========================== Modal Add ==============================-->
            <!-- Modal Structure -->
            <div id="modAccountActive" class="modal">
                <div class="modal-content">
                    <div class="col s12" style="text-align:center; padding:20px; margin:0px;">
                        <p>Akun anda telah aktif, silahkan login terlebih dahulu</p>
                        <a href="<?php echo $URL;?>/login">Kembali ke halaman login</a>
                    </div>
                </div>
            </div>

        <!-- ========================================================================= -->

        <div class="col s12" style="padding:3%; ">
            <div class="col s12 m10 l8 push-m1 push-l2" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); padding:30px;">
                <div class="col s12" style="border-bottom:1px silver solid; padding:20px; color:#808080;">
                    Beranda
                </div>
                <div class="col s12" style=" padding:20px; 0px 10px 0px; color:#808080;">
                    Selamat datang dihalaman beranda!
                </div>
                <div class="col s12 red" style="padding:15px 0px 15px 0px; color:white; text-align:center; border-radius:5px;">
                    Aktifkan akun anda
                </div>
                <div class="col s12 red-text">
                    *Anda tidak dapat menggunakan fitur sebelum mengaktifkan akun anda.
                </div>
                <div class="col s12">
                    <div class="col s12 m10 l8 push-m1 push-l2" style="padding:10px;">
                        <div class="col s7" style="padding:0px 10px 0px 10px;">
                            <input type="text" id="kodeVerifikasiForm" placeholder="Masukkan Kode">
                        </div>
                        <div class="col s5 btn" onclick="activateMyAccount()">Aktifkan</div>
                    </div>
                </div>
                <div class="progress" id="loadingBar" style="display:none;">
                    <div class="indeterminate"></div>
                </div>
                <div class="col s12 red lighten-3" id="failedActivationView" style="padding:10px; display:none;">
                    
                </div>
                <div class="col s12  blue lighten-4" id="successActivationView" style="padding:10px;  display:none;">
                    
                </div>
                <div class="col s12" style=" color:#808080;" id="resendCodeView" >
                    Anda tidak menerima kode aktivasi? <b class="blue-text" onclick="resendCode()">kirim ulang.</b>
                </div>
            </div>
        </div>
       
        <script>
            var myResponAllData=[];
            // showItem();
            $(document).ready( function () {
                $('.tooltipped').tooltip();
                $(".sidenav").sidenav();
                $(".tooltipped").tooltip();
                $(".collapsible").collapsible();
                $(".modal").modal();
                $('.dropdown-trigger').dropdown();
                $('.datepicker').datepicker();
                $('.timepicker').timepicker();
                $('select').formSelect();
                $('.materialboxed').materialbox();
                $('.tabs').tabs();
                $('.fixed-action-btn').floatingActionButton();
                console.log(localStorage.getItem("username"));
                if(localStorage.getItem("username")===null||localStorage.getItem("username")==="Welcome")
                    window.location="<?php echo $URL; ?>/login";
            } );


            function activateMyAccount(){
                var kode=$("#kodeVerifikasiForm").val();
                if(kode===localStorage.getItem("kode")){
                    $("#loadingBar").css("display","block");
                    let formData = new FormData();
                    formData.append('username', localStorage.getItem("username"));

                    $.ajax({
                        url: '<?php echo $URL; ?>/API/aktivasiAkun',
                        method: 'POST',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        
                        success: function (data) {
                            var response= JSON.stringify(data);
                            var myResponse=JSON.parse(response);
                            showAlert(myResponse.message);

                            // showItem();
                            $("#loadingBar").css("display","none");
                            
                            var successMessage='Akun anda telah aktif, silahkan login terlebih dahulu <a href="<?php echo $URL;?>/login">Kembali ke halaman login</a>';
                            
                            
                            if(myResponse.response_status=="true"){
                                $("#modAccountActive").modal("open");
                                $("#failedActivationView").css("display", "none");
                                $("#successActivationView").css("display", "block");
                                $("#successActivationView").html(successMessage);
                                $("#resendCodeView").css("display", "none");
                            }
                            else{
                                $("#failedActivationView").css("display", "block");
                                $("#successActivationView").css("display", "none");
                                $("#failedActivationView").html(myResponse.message);
                                $("#resendCodeView").css("display", "block");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {

                            alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information, and tell the developer about the error!');
                            console.log('jqXHR:');
                            console.log(jqXHR);
                            console.log('textStatus:');
                            console.log(textStatus);
                            console.log('errorThrown:');
                            console.log(errorThrown);

                        },
                    });
                }
                else{
                    var failedMessage="Mohon maaf kode verifikasi anda salah, silahkan periksa kembali";
                    $("#failedActivationView").html(failedMessage);
                    $("#failedActivationView").css("display", "block");
                    $("#successActivationView").css("display", "none");
                }
                
            }

            function resendCode(){
            
                $("#loadingBar").css("display","block");
                let formData = new FormData();
                formData.append('username', localStorage.getItem("username"));

                $.ajax({
                    url: '<?php echo $URL; ?>/API/resendCode',
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    
                    success: function (data) {
                        var response= JSON.stringify(data);
                        var myResponse=JSON.parse(response);
                        showAlert(myResponse.message);

                        // showItem();
                        $("#loadingBar").css("display","none");
                        
                        if(myResponse.response_status=="true"){
                            $("#failedActivationView").css("display", "none");
                            $("#successActivationView").css("display", "block");
                            $("#successActivationView").html(myResponse.message);
                            localStorage.setItem("kode", myResponse.data.kode);
                            // console.log(localStorage.getItem("kode"));
                        }
                        else{
                            $("#failedActivationView").css("display", "block");
                            $("#successActivationView").css("display", "none");
                            $("#failedActivationView").html(myResponse.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                        alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information, and tell the developer about the error!');
                        console.log('jqXHR:');
                        console.log(jqXHR);
                        console.log('textStatus:');
                        console.log(textStatus);
                        console.log('errorThrown:');
                        console.log(errorThrown);

                    },
                });
                
                
            }
            function showAlert(message){
                M.toast({html: `<div class="white" style="border-top:solid 2px #346eeb; margin:-20px -30px -20px -30px; padding:10px 20px 10px 20px; color:black; box-shadow: 5px 5px 5px #aaaaaa; ">${message}</div>`});
            }
        
        </script>

    </body>
</html>
        