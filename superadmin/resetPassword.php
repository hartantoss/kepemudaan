<?php
  include '../connect.php';
?>
<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Baloo+Bhai|Lato&display=swap" rel="stylesheet">
      <!-- Compiled and minified CSS -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
      <link rel="stylesheet" href="<?php echo $URL; ?>/superadmin/css/superadmin.css">

      <meta name="description" content="Simonev Apps Reset Password" />
      <meta name="keywords" content="Simonev, SimonevApps" />
      <meta name="author" content="Dandi Wibowo" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
      <meta charset="utf-8">
      <link rel="icon" href="<?php echo $URL; ?>/images/logo.png" type="image/x-icon" />
      <title>Simonev Apps</title>
    </head>

    <body class="row bg" style="margin:0px; padding:0px; ">

      <style>
        body, html {
          height: 100%;
        }

        .bg {
          /* The image used */
          background:linear-gradient(45deg,#2562cc, #06368a);

          /* Full height */
          height: 100%;

          /* Center and scale the image nicely */
          background-position: center;
          background-repeat: no-repeat;
          background-size: cover;
        }
      </style>
      <div class="row col xl4 l4 m6 s12 push-xl4 push-l4 push-m3" style="text-align:center; color:white; padding-top:200px;">
        <div class="col s12" id="formSc" style=" box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.2), 0 3px 20px 0 rgba(0, 0, 0, 0.19) !important; padding: 20px; background:white; border-radius:10px;">
          <h5 class="black-text">Reset Password</h5>
          <input type="text" id="newPass" placeholder="Insert New Password">
          <input type="text" id="newPassConf" placeholder="Confirm New Password">
          <div onclick="verif()" class="btn col s10 push-s1">Reset</div>
          <div class="progress" id="loadingSc" style="display: none;">
            <div class="determinate" style="width: 70%"></div>
          </div>
        </div>
        <div id="successSc" style="display: none;" >
          <h4>Reset Password Success</h4>
          <p>Please login to your account</p>
        </div>
        <div id="failedSc"  style="display: none;">
          <h4 id="failedText"></h4>
          <p>Please check your url and make sure it's correct</p>
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
              
          });



          function verif(){
              var token = "<?php echo $_GET['token']; ?>";
              var password = $("#newPass").val();
              var confPassword = $("#newPassConf").val();

              $("#loadingSc").css("display","block");
              $("#successSc").css("display","none");
              $("#failedSc").css("display","none");
              
              $.ajax({
                  url: '<?php echo $URL; ?>/API/resetUser',
                  method: 'POST',
                  data: {
                    "token":token,
                    "password":password,
                    "confPassword":confPassword,
                  },
                  
                  success: function (data) {
                    var response= JSON.stringify(data);
                    var myResponse=JSON.parse(response);

                    // console.log(myResponse.message);
                    if(myResponse.message=="Reset Password Success"){
                      $("#formSc").css("display","none");
                      $("#loadingSc").css("display","none");
                      $("#successSc").css("display","block");
                      $("#failedSc").css("display","none");
                    }
                    else{
                      $("#formSc").css("display","none");
                      $("#loadingSc").css("display","none");
                      $("#successSc").css("display","none");
                      $("#failedSc").css("display","block");
                      $("#failedText").html(myResponse.message);
                    }
                    
                    // console.log(JSON.stringify(myResponse.token));
                    // alert(data);
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                      $("#formSc").css("display","none");
                      $("#loadingSc").css("display","none");
                      $("#successSc").css("display","none");
                      $("#failedSc").css("display","block");
                      
                      console.log('jqXHR:');
                      console.log(jqXHR);
                      console.log('textStatus:');
                      console.log(textStatus);
                      console.log('errorThrown:');
                      console.log(errorThrown);
                  },
              });
          }
      </script>

    </body>
  </html>
        