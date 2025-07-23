
    <div class="modal-content row">

        <div class="input-field col s12">
            <img src="" alt="gambar artikel" id="imagesArtikelView" style="width:100%;">
        </div>
        <!-- <div class="col s12">
            <ul class="tabs">
                <li class="tab col s6"><a href="#idTab">Bahasa Indonesia</a></li>
                <li class="tab col s6"><a class="active" href="#enTab">Bahasa Inggris</a></li>
            </ul>
        </div> -->
        <!-- <div id="idTab" class="col s12" style="padding:10px;"> -->
            <div class="input-field col s12">
                <input placeholder="Judul" id="judulIdForm" type="text" class="validate">
                <label for="judulIdForm">Judul</label>
            </div>
            <div class="input-field col s12">
            
                <textarea id="deskripsiIdForm" class="materialize-textarea" data-length="2000" style="height:300px;"></textarea>
                <label for="deskripsiIdForm">Deskripsi</label>
                <i><b>Note : </b>Gunakan enter sebagai penanda batas akhir dari paragraf</i>
            </div>
        <!-- </div> -->
        <div id="enTab" class="col s12" style="padding:10px; display:none">
            <div class="input-field col s12">
                <input placeholder="Title" id="judulEnForm" type="text" class="validate">
                <label for="judulEnForm">Judul (English)</label>
            </div>
            <div class="input-field col s12">
                <textarea id="deskripsiEnForm" class="materialize-textarea" data-length="2000" style="height:300px;"></textarea>
                <label for="deskripsiEnForm">Deskripsi (English)</label>
                <i><b>Note : </b>Gunakan enter sebagai penanda batas akhir dari paragraf</i>
            </div>
        </div>
        
        <div class="input-field col s12 m6" style="padding:20px;">
            <select id="visibilityForm">
                <option value="1" selected>Tampilkan</option>
                <option value="0">Sembunyikan</option>
            </select>
            <label>Visibility Konten</label>
        </div>
        <div class="input-field col s12 m6" style="padding:20px;">
            <input placeholder="1,2,3" id="priorityForm" type="number" class="validate">
            <label for="priorityForm">Prioritas</label>
        </div>
        <div class="input-field col s12 m6" style="padding:20px;">
            <input placeholder="Tags Artikel" id="tagsForm" type="text" class="validate">
            <label for="tagsForm">Tags</label>
        </div>
        <div class="input-field col s12 m6" style="padding:20px;">
            <input placeholder="Kategori Artikel" id="kategoriForm" type="text" class="validate">
            <label for="kategoriForm">Kategori</label>
        </div>
        
        <div class="file-field input-field col s12" style="padding:20px;">
            <p>Upload Gambar (600 x 400)</p>     
            <div class="btn">
                <span>File</span>
                <input type="file" id="fotoForm">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
        </div>

        <div class="col s12" style="padding:20px;">
            <div class="btn" onclick="saveData()">Simpan</div>
            <div class="btn red-text" onclick="deleteData()">delete</div>
            <!-- <div class="btn-floating red right" onclick="deleteData()"><i class="material-icons">delete</i></div> -->
        </div>
    </div>
    
<script>
    var tipe="<?php echo $_GET['tipe']; ?>";
    var idArtikel="<?php echo isset($_GET['idArtikel']) ? $_GET['idArtikel'] : "0"; ?>";
    var breadCrump=[
        {
            "text":"Dasboard",
            "url":"<?php echo $URL; ?>/admin/homepage"
        },
        {
            "text":tipe.toLowerCase(),
            "url":"<?php echo $URL; ?>/admin/"+tipe.toLowerCase()
        }
    ];
    var myResponAllData=[];
    var myResponTag=[];
    var myResponKategori=[];
    
    $(document).ready( function () {    
        showItem();
        showTag();
        showKategori();
    } );

    function saveData(){
        var token = localStorage.getItem('token');
        var idUser = localStorage.getItem("iduser");
        
        

        let formData = new FormData();
        formData.append('token', token);
        
        formData.append("judul_id", $("#judulIdForm").val());
        formData.append("judul_en", $("#judulEnForm").val());
        formData.append("deskripsi_id", $("#deskripsiIdForm").val());
        formData.append("deskripsi_en", $("#deskripsiEnForm").val());
        formData.append("kategori", $("#kategoriForm").val());
        formData.append("tag", $("#tagsForm").val());
        formData.append("visibility", $("#visibilityForm").val());
        formData.append("priority", $("#priorityForm").val());
        formData.append("tipe", tipe);
        


        if( document.getElementById("fotoForm").files.length != 0 ){
            formData.append("foto", $('#fotoForm').prop('files')[0]);
        }
        
        
        if(idArtikel!=0)
            formData.append('idArtikel', idArtikel);


        $("#preloaderView").css("display","block");
        $.ajax({
            url: '<?php echo $URL; ?>/API/saveArtikel',
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            
            success: function (data) {
                var response= JSON.stringify(data);
                var myResponse=JSON.parse(response);
                showAlert(myResponse.message);
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
                window.location.href = detailUrl+"/"+myResponse.data.id; 
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
            url: '<?php echo $URL; ?>/API/showArtikel',
            method: 'POST',
            data: {
                "token":token,
                "tipe":tipe,
                "idArtikel":idArtikel
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                myResponAllData=JSON.parse(response);

                
                if(myResponAllData.response_status=="true"){
                    $("#listData").html("");
                    // console.log(myResponAllData.data);
                    if(myResponAllData.data.length>0){
                        $("#imagesArtikelView").attr("src","<?php echo $URL; ?>/"+myResponAllData.data[0].foto);
                        $("#judulIdForm").val(myResponAllData.data[0].judul_id);
                        $("#judulEnForm").val(myResponAllData.data[0].judul_en);
                        $("#deskripsiIdForm").val(myResponAllData.data[0].deskripsi_id);
                        $("#deskripsiEnForm").val(myResponAllData.data[0].deskripsi_en);
                        $("#kategoriForm").val(myResponAllData.data[0].kategori);
                        $("#tagsForm").val(myResponAllData.data[0].tag);
                        $("#visibilityForm").val(myResponAllData.data[0].visibility);
                        $("#priorityForm").val(myResponAllData.data[0].priority);
                        $('.tooltipped').tooltip();
                    }
                    else{
                        $("#judulIdForm").val("");
                        $("#judulEnForm").val("");
                        $("#deskripsiIdForm").val("");
                        $("#deskripsiEnForm").val("");
                        $("#kategoriForm").val("");
                        $("#tagsForm").val("");
                        $("#visibilityForm").val("1");
                        $("#priorityForm").val("99");
                        $("#imagesArtikelView").css("display","none");
                    }
                    M.textareaAutoResize($('#deskripsiIdForm'));
                    M.textareaAutoResize($('#deskripsiEnForm'));
                    M.updateTextFields();
                }
                else{
                    alert(myResponAllData.message);
                }
                // console.log(JSON.stringify(myResponse.token));
                // alert(data);
            }
        });
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
                        <?php 
                            if($_GET['tipe']=="ACARA")
                                echo "var detailUrl='$URL/admin/acara';";
                            if($_GET['tipe']=="BERITA")
                                echo "var detailUrl='$URL/admin/berita';";
                            if($_GET['tipe']=="AKTIVITAS")
                                echo "var detailUrl='$URL/admin/aktivitas';";
                            if($_GET['tipe']=="DATA")
                                echo "var detailUrl='$URL/admin/data';";
                        ?>
                        
                        window.open(detailUrl+"/","_self") 
                    }
                });
                
            }
        });
    }

    function showTag() {
        var token = localStorage.getItem('token');

        $.ajax({
            url: '<?php echo $URL; ?>/API/showTag',
            method: 'POST',
            data: {
                "token": token,
                "tipe": tipe
            },
            success: function (data) {
                // console.log("Response API (Tag):", data); // Debugging

                if (data.response_status === "true") {
                    let myResponTag = data.data;
                    let formattedTag = {};

                    // Loop untuk mengubah format array menjadi objek yang diterima autocomplete
                    myResponTag.forEach(item => {
                        let key = Object.keys(item)[0]; // Ambil key pertama dari objek
                        if (key && key.trim() !== "") { // Hindari key kosong
                            formattedTag[key] = null;
                        }
                    });

                    // console.log("Formatted Tag:", formattedTag); // Debugging

                    // Inisialisasi autocomplete
                    $('#tagsForm').autocomplete({
                        data: formattedTag
                    });
                } else {
                    alert(data.message);
                }
            }
        });
    }


    function showKategori() {
        var token = localStorage.getItem('token');

        $.ajax({
            url: '<?php echo $URL; ?>/API/showKategori',
            method: 'POST',
            data: {
                "token": token,
                "tipe": tipe
            },
            success: function (data) {
                // console.log("Response API:", data); // Debugging

                if (data.response_status === "true") {
                    let myResponKategori = data.data;
                    let formattedKategori = {};

                    // Loop untuk mengubah format array menjadi objek yang diterima autocomplete
                    myResponKategori.forEach(item => {
                        let key = Object.keys(item)[0]; // Ambil key pertama dari objek
                        if (key && key.trim() !== "") { // Hindari key kosong
                            formattedKategori[key] = null;
                        }
                    });

                    // console.log("Formatted Kategori:", formattedKategori); // Debugging

                    // Inisialisasi autocomplete
                    $('#kategoriForm').autocomplete({
                        data: formattedKategori
                    });
                } else {
                    alert(data.message);
                }
            }
        });
    }

</script>