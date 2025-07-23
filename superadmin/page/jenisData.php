<!-- Modal Structure -->
<div id="timModals" class="modal">
    <div class="modal-content row">
        <h4>Tim</h4>
        <div class="input-field col s12">
            <input placeholder="Nama Lengkap" id="namaForm" type="text" class="validate">
            <label for="namaForm">Nama Lengkap</label>
        </div>
        <div class="input-field col s12">
            <input placeholder="Jabatan" id="jabatanForm" type="text" class="validate">
            <label for="jabatanForm">Jabatan</label>
        </div>
        <div class="input-field col s12">
            <input placeholder="https://..." id="linkedinForm" type="text" class="validate">
            <label for="linkedinForm">Linkedin</label>
        </div>
        <div class="input-field col s12">
            <input placeholder="https://..." id="emailForm" type="text" class="validate">
            <label for="emailForm">Email</label>
        </div>
        <div class="input-field col s12">
            <input placeholder="1,2,3,4" id="priorityForm" type="number" class="validate">
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

        <div class="progress" id="preloaderView" style="display:none">
            <div class="indeterminate"></div>
        </div>

        <div class="col s12">
            <div class="btn" onclick="saveData()">Simpan</div>
        </div>
    </div>
    
</div>

<style>
    .section-title {
      text-align: center;
      font-weight: 600;
      font-size: 28px;
      margin: 40px 0 30px;
      color: #1f2937;
    }

    .feature-card {
      background-color: #ffffff;
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
      display: flex;
      gap: 20px;
      align-items: flex-start;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .feature-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
    }

    .icon-circle {
      background-color: #e0f2fe;
      color: #0284c7;
      border-radius: 50%;
      padding: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 52px;
      width: 52px;
    }

    .icon-circle i {
      font-size: 24px;
    }

    .feature-text h6 {
      margin: 0 0 6px;
      font-weight: 600;
      font-size: 18px;
      color: #111827;
    }

    .feature-text p {
      margin: 0;
      color: #6b7280;
      font-size: 14px;
      line-height: 1.6;
    }

    .row {
      margin-bottom: 32px;
    }

    @media (max-width: 600px) {
      .feature-card {
        flex-direction: column;
        align-items: flex-start;
      }

      .icon-circle {
        margin-bottom: 12px;
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
    <div class="col s12" style="padding:20px; font-family: 'Nunito', sans-serif !important; ">
        <div class="row" id="listData">
            

        </div>
    </div>
        
</div>


<!-- <a id="addButton" onclick="openData(-1)" style="position:fixed; bottom:20px; right:20px;" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a> -->
<script>

    var breadCrump=[
        {
            "text":"Dasboard",
            "url":"<?php echo $URL; ?>/admin/homepage"
        },
        {
            "text":"Jenis Data",
            "url":"<?php echo $URL; ?>/admin/jenisData"
        }
    ];
    var myResponAllData=[];
    var idTim=-1;
    $(document).ready( function () {    
        showItem();
        createBreadCrum(breadCrump);
    } );

    function saveData(){
        var token = localStorage.getItem('token');
        var idUser = localStorage.getItem("iduser");
        
        

        let formData = new FormData();
        formData.append('token', token);
        
        formData.append("nama", $("#namaForm").val());
        formData.append("jabatan", $("#jabatanForm").val());
        formData.append("linkedin", $("#linkedinForm").val());
        formData.append("email", $("#emailForm").val());
        formData.append("priority", $("#priorityForm").val());
        


        if( document.getElementById("fotoForm").files.length != 0 ){
            formData.append("foto", $('#fotoForm').prop('files')[0]);
        }
        
        
        if(idTim!=0)
            formData.append('idTim', idTim);


        $("#preloaderView").css("display","block");
        $.ajax({
            url: '<?php echo $URL; ?>/API/saveTim',
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            
            success: function (data) {
                var response= JSON.stringify(data);
                var myResponse=JSON.parse(response);
                showAlert(myResponse.message);
            },
            complete: function (data) {
                showItem();
                $("#preloaderView").css("display","none");
                $("#timModals").modal('close');
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

    function showItem(){
        var token = localStorage.getItem('token');

        $.ajax({
            url: '<?php echo $URL; ?>/API/showJenisData',
            method: 'POST',
            data: {
                "token":token,
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
                        if (a % 2 === 0) {
                            admninList += '<div class="row">';  // Menambahkan div row sebelum dua item
                        }
                        admninList+=`
                            <div class="col s12 m6">
                                <div class="feature-card" onclick="openData(${a})">
                                    <div class="icon-circle" style="${myResponAllData.data[a].css}">
                                        <i class="material-symbols-outlined">${myResponAllData.data[a].icon}</i>
                                    </div>
                                    <div class="feature-text">
                                        <h6>${myResponAllData.data[a].judul}</h6>
                                        <p>${myResponAllData.data[a].deskripsi}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        // Jika item kedua (atau kelipatan 2), tutup div row
                        if (a % 2 !== 0 || a === myResponAllData.data.length - 1) {
                            admninList += '</div>';  // Menutup div row
                        }
                        
                    }
                    $("#listData").html(admninList);
                    $('.tooltipped').tooltip();
                }
                else{
                    alert(myResponAllData.message);
                }
                // console.log(JSON.stringify(myResponse.token));
                // alert(data);
            },
            error: function (request, status, error) {
                console.log(request.responseText);
                console.log(status);
                console.log(error);
            }
        });
    }

   

    function openData(x){
        // var linkHrefArray=JSON.parse(myResponAllData.data[x].json_url);
        // console.log(linkHrefArray.href)
        window.location="<?php echo $URL; ?>/admin/itemData/"+myResponAllData.data[x].id;
    }


    function searchUser(){
        var searchItem= $("#searchUser").val().toLowerCase();
        $("#listData").html("");
        if(searchItem=="")
            showItem();
        else{
            var admninList="";
            let rowOpened = false; 
            for(a=0; a<myResponAllData.data.length;a++){
                var judul=myResponAllData.data[a].judul.toLowerCase();
                if(judul.match(searchItem)){

                    // Jika row belum dibuka, buka row
                    if (!rowOpened) {
                        admninList += '<div class="row">';  // Menambahkan div row sebelum dua item
                        rowOpened = true;
                    }
                    
                    admninList+=`
                        <div class="col s12 m6">
                            <div class="feature-card" onclick="openData(${a})">
                                <div class="icon-circle" style="${myResponAllData.data[a].css}">
                                    <i class="material-symbols-outlined">${myResponAllData.data[a].icon}</i>
                                </div>
                                <div class="feature-text">
                                    <h6>${myResponAllData.data[a].judul}</h6>
                                    <p>${myResponAllData.data[a].deskripsi}</p>
                                </div>
                            </div>
                        </div>
                    `;

                    // Jika sudah 2 item, tutup row
                    if ((a + 1) % 2 === 0 || a === myResponAllData.data.length - 1) {
                        admninList += '</div>';  // Menutup div row
                        rowOpened = false;  // Reset flag row
                    }
                }
                
                
            }
                    
            $("#listData").html(admninList);
            $('.tooltipped').tooltip();
            
        }
    }

    function deleteData(x){
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
                    url: '<?php echo $URL; ?>/API/deleteTim',
                    method: 'POST',
                    data: {
                        "token":token,
                        "idTim":x,
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