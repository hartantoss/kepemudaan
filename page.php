<?php 
  include 'connect.php'; 
?>
<!DOCTYPE html>
<html>
  <head>
      <meta name="description" content="Disparpora Kota Serang – Pariwisata, Pemuda & Olahraga Terdepan di Banten" />
      <meta name="keywords" content="disparpora kota serang, dinas pariwisata kota serang, wisata serang banten, kegiatan pemuda serang, event olahraga serang, destinasi wisata banten, pemuda dan olahraga serang, agenda disparpora serang, info pariwisata kota serang, disparpora banten" />
      <meta name="author" content="Dandi Wibowo" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
      <meta charset="utf-8">
      <link rel="icon" href="<?php echo $URL;?>/images/logo.png" type="image/x-icon" />
      <title>DISPARPORA</title>

     <!--Import Google Icon Font-->
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
      
      <!-- Import Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

       <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!-- Import fa icon -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <!-- import Google Symbol Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

      
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
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

      
      <!-- Data Table -->
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-1.13.6/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.10.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.2.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.js"></script> -->
      <!-- Google Chart -->
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      
      <!-- Google Map -->
      <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
      
      <!-- Swall Alert -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <!-- Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>

  <body  class="row" style="margin:0px; padding:0px;  background:#fff;">
    <style>
      /* Modal */
      .drop-area {
          border: 2px dashed #90caf9;
          border-radius: 12px;
          padding: 40px 20px;
          text-align: center;
          cursor: pointer;
          transition: 0.3s ease;
      }

      .drop-area:hover {
          background-color: #f1f8ff;
          border-color: #42a5f5;
      }
    </style>
    <div id="responseAlertView" class="row" style="display:none; width:100% !important; height:100% !important; background:rgba(93, 97, 94,0.5); position:fixed; z-index:4; text-align:center; padding:auto;">
        <div class="row" style="width:40%; background:white; margin:15% auto; padding:30px; border-radius:15px;">
          <h6 id="responseAlertViewText">-</h6>
          <div class="col s10 push-s1 btn" onclick="closeAlert()">OK</div>
        </div>
    </div>
    <?php 
        
        include 'header.php'; 

        $pageLoad=$_GET['pg'];
            include "pages/$pageLoad.php";

        include 'footer.php';
    ?>

    

    
    
    <script>
        $(document).ready(function(){
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
            
        });

        function showAlert(message){
          Swal.fire({
            text: message,
            confirmButtonColor: "#3085d6",
          });
        }
        
        function closeAlert(){
          $("#responseAlertView").css("display","none");
        }

        function createBreadCrum(breadCrumpArray){
          var breadText="";
          
          for(a=0;a<(breadCrumpArray.length-1);a++){
            // console.log(breadCrumpArray[a])
            breadText+="<a style='color:#18181b' href='"+breadCrumpArray[a].url+"'>"+breadCrumpArray[a].text+"</a>/";
          }
          breadText+="<a style='color:#18181b' href='"+breadCrumpArray[a].url+"'><b>"+breadCrumpArray[a].text+"</b></a>";

          $("#breadCrumpView").html(breadText)
        }
    </script>

  </body>
</html>
   