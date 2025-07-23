<!-- Modal Structure -->
<!-- <div id="timModals" class="modal">
    <div class="modal-content row">
        <div class="input-field col s12">
            <input placeholder="Judul" id="judulIdForm" type="text" class="validate">
            <label for="judulIdForm">Judul (Bahasa Indonesia)</label>
        </div>
        <div class="input-field col s12">
            <input placeholder="Title" id="judulEnForm" type="text" class="validate">
            <label for="judulEnForm">Judul (English)</label>
        </div>
        
        <div class="input-field col s12">
            
            <textarea id="deskripsiIdForm" class="materialize-textarea" data-length="2000"></textarea>
            <label for="deskripsiIdForm">Deskripsi (Bahasa Indonesia)</label>
            <i><b>Note : </b>Gunakan enter sebagai penanda batas akhir dari paragraf</i>
        </div>
        <div class="input-field col s12">
            <textarea id="deskripsiEnForm" class="materialize-textarea" data-length="2000"></textarea>
            <label for="deskripsiEnForm">Deskripsi (English)</label>
            <i><b>Note : </b>Gunakan enter sebagai penanda batas akhir dari paragraf</i>
        </div>
        <div class="input-field col s12 m6">
            <select id="visibilityForm">
                <option value="1" selected>Tampilkan</option>
                <option value="0">Sembunyikan</option>
            </select>
            <label>Visibility Konten</label>
        </div>
        <div class="input-field col s12 m6">
            <input placeholder="1,2,3" id="priorityForm" type="number" class="validate">
            <label for="priorityForm">Prioritas</label>
        </div>
        
        <div class="file-field input-field col s12">
            <p>Upload Gambar</p>     
            <div class="btn">
                <span>File</span>
                <input type="file" id="fotoForm">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
        </div>

        <div class="col s12">
            <div class="btn" onclick="saveData()">Simpan</div>
            <div class="btn-floating red right" onclick="deleteData()"><i class="material-icons">delete</i></div>
        </div>
    </div>
    
</div> -->
<style>
  
  .card-image .kategori-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: #2196f3;
    color: white;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
  }
  .card-title {
    font-size: 1.3rem;
    font-weight: bold;
  }
  .card-content p {
    color: #555;
  }

  @media only screen and (max-width: 600px) {
    #listArtikel .card-content {
      min-height: auto !important;
    }
  }
</style>
<div class="col s12" style="margin-bottom:20px;">
    <div class="col s12" id="breadCrumpView"></div>
</div>
<div class="row" style="margin:0px 0px 0px 0px;">
    <div class="col s12" style="">
        <div class="col s12" style="padding:5px;">
            <input oninput="searchUser()" id="searchUser" type="text" style="width:99%; background:white; padding:5px 10px; border-radius:7px;" placeholder="Masukkan Kata Kunci">
        </div>
    </div>
    <!-- <div class="col s12" id="listData" style="padding:20px; font-family: 'Nunito', sans-serif !important; ">
       
        
    </div> -->
    <div class="row" id="listData">
        
        
    </div>
</div>


<a id="addButton" onclick="openData(-1)" style="position:fixed; bottom:20px; right:20px;" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
<script>
    var tipe="<?php echo $_GET['tipe']; ?>";
    var breadCrump=[
        {
            "text":"Dasboard",
            "url":"<?php echo $URL; ?>/admin/homepage"
        },
        {
            "text":(tipe=="AKTIVITAS"?"Informasi Terkini":tipe.toLowerCase()),
            "url":"<?php echo $URL; ?>/admin/"+tipe.toLowerCase()
        }
    ];
    var myResponAllData=[];
    var idArtikel=-1;
    
    $(document).ready( function () {    
        showItem();
        createBreadCrum(breadCrump);
    } );

    // function saveData(){
    //     var token = localStorage.getItem('token');
    //     var idUser = localStorage.getItem("iduser");
        
        

    //     let formData = new FormData();
    //     formData.append('token', token);
        
    //     formData.append("judul_id", $("#judulIdForm").val());
    //     formData.append("judul_en", $("#judulEnForm").val());
    //     formData.append("deskripsi_id", $("#deskripsiIdForm").val());
    //     formData.append("deskripsi_en", $("#deskripsiEnForm").val());
    //     formData.append("visibility", $("#visibilityForm").val());
    //     formData.append("priority", $("#priorityForm").val());
    //     formData.append("tipe", tipe);
        


    //     if( document.getElementById("fotoForm").files.length != 0 ){
    //         formData.append("foto", $('#fotoForm').prop('files')[0]);
    //     }
        
        
    //     if(idArtikel!=0)
    //         formData.append('idArtikel', idArtikel);


    //     $("#preloaderView").css("display","block");
    //     $.ajax({
    //         url: '<?php echo $URL; ?>/API/saveArtikel',
    //         method: 'POST',
    //         processData: false,
    //         contentType: false,
    //         cache: false,
    //         data: formData,
            
    //         success: function (data) {
    //             var response= JSON.stringify(data);
    //             var myResponse=JSON.parse(response);
    //             showAlert(myResponse.message);
    //         },
    //         complete: function (data) {
    //             showItem();
    //             $("#preloaderView").css("display","none");
    //             $("#timModals").modal('close');
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {

    //             alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information, and tell the developer about the error!');
    //             console.log('jqXHR:');
    //             console.log(jqXHR);
    //             console.log('textStatus:');
    //             console.log(textStatus);
    //             console.log('errorThrown:');
    //             console.log(errorThrown);

    //         },
    //     });
    // }

    function showItem(){
        var token = localStorage.getItem('token');

        $.ajax({
            url: '<?php echo $URL; ?>/API/showArtikel',
            method: 'POST',
            data: {
                "token":token,
                "tipe":tipe,
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                myResponAllData=JSON.parse(response);
                console.log(data);
                
                if(myResponAllData.response_status=="true"){
                    $("#listData").html("");
                    console.log(myResponAllData.data);
                    var admninList="";
                    for(a=0; a<myResponAllData.data.length;a++){
                                               
                        admninList+=`
                            <div class="col s12 m6 l4">
                                <div class="card hoverable" style="margin: 10px 0;" onclick="openData(${a})">
                                    <div class="card-image" style="height: 200px; overflow: hidden;">
                                        <img src="<?php echo $URL;?>/${myResponAllData.data[a].foto}" 
                                            alt="${(myResponAllData.data[a].judul_id).substring(0,10)}" 
                                            style="height: 100%; width: 100%; object-fit: cover;">
                                        <span class="kategori-badge white-text blue darken-2" 
                                                style="position: absolute; top: 10px; left: 10px; padding: 5px 10px; border-radius: 5px; font-size: 12px;">
                                            ${myResponAllData.data[a].kategori}
                                        </span>
                                        </div>
                                        <div class="card-content" style="min-height: 160px;">
                                        <span class="card-title truncate" style="font-size: 1.2rem; font-weight: 600;">
                                            ${(myResponAllData.data[a].judul_id).substring(0, 60)}...
                                        </span>
                                        <p class="grey-text" style="font-size: 0.9rem;">${myResponAllData.data[a].created_date}</p>
                                        <p style="margin-top: 5px; font-size: 0.95rem;">
                                            ${(myResponAllData.data[a].deskripsi_id).substring(0, 80)}...
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                        `;
                        // }
                        
                    }
                    $("#listData").html(admninList);
                    $('.tooltipped').tooltip();
                }
                else{
                    alert(myResponAllData.message);
                }
                // console.log(JSON.stringify(myResponse.token));
                // alert(data);
            }
        });
    }

    function openData(x){
        <?php
            if($_GET['tipe']=="ACARA")
                echo "var detailUrl='$URL/admin/detailAcara';";
            if($_GET['tipe']=="BERITA")
                echo "var detailUrl='$URL/admin/detailBerita';";
            if($_GET['tipe']=="AKTIVITAS")
                echo "var detailUrl='$URL/admin/detailAktivitas';";
            if($_GET['tipe']=="DATA")
                echo "var detailUrl='$URL/admin/detailData';";
        ?>
        var idArtikel=0;
        if(x!=-1){
            idArtikel=myResponAllData.data[x].id;
        }
        window.open(detailUrl+"/"+idArtikel, '_blank');
    }

    function searchUser(){
        var searchItem= $("#searchUser").val().toLowerCase();
        $("#listData").html("");
        if(searchItem=="")
            showItem();
        else{
            var admninList="";
            for(a=0; a<myResponAllData.data.length;a++){
                var judul_id=myResponAllData.data[a].judul_id.toLowerCase();
                if(judul_id.match(searchItem)){
                    admninList+=`
                        <div class="col s12 m6 l4">
                            <div class="card hoverable" style="margin: 10px 0;" onclick="openData(${a})">
                                <div class="card-image" style="height: 200px; overflow: hidden;">
                                    <img src="<?php echo $URL;?>/${myResponAllData.data[a].foto}" 
                                        alt="${(myResponAllData.data[a].judul_id).substring(0,10)}" 
                                        style="height: 100%; width: 100%; object-fit: cover;">
                                    <span class="kategori-badge white-text blue darken-2" 
                                            style="position: absolute; top: 10px; left: 10px; padding: 5px 10px; border-radius: 5px; font-size: 12px;">
                                        ${myResponAllData.data[a].kategori}
                                    </span>
                                    </div>
                                    <div class="card-content" style="min-height: 160px;">
                                    <span class="card-title truncate" style="font-size: 1.2rem; font-weight: 600;">
                                        ${(myResponAllData.data[a].judul_id).substring(0, 60)}...
                                    </span>
                                    <p class="grey-text" style="font-size: 0.9rem;">${myResponAllData.data[a].created_date}</p>
                                    <p style="margin-top: 5px; font-size: 0.95rem;">
                                        ${(myResponAllData.data[a].deskripsi_id).substring(0, 80)}...
                                    </p>
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                
            }
                    
            $("#listData").html(admninList);
            $('.tooltipped').tooltip();
            
        }
    }

    function deleteData(){
        var token = localStorage.getItem('token');
        $("#timModals").modal('close'); 
        Swal.fire({
            title: "Are you really want to delete this data ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // alert("masuk");
            
                $.ajax({
                    url: '<?php echo $URL; ?>/API/deleteArtikel',
                    method: 'POST',
                    data: {
                        "token":token,
                        "idArtikel":idArtikel,
                    },
                    
                    success: function (data) {
                        var response= JSON.stringify(data);
                        var myResponse=JSON.parse(response);
                        
                        showAlert(myResponse.message);  
                        showItem();     
                    }
                });
                
            }
        });
    }
</script>