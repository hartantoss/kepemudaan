
<style>
    .indicator-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .indicator-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        margin-bottom: 10px;
        border-radius: 10px;
        background-color: #fafafa;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        cursor: pointer;
    }

    .indicator-item:hover {
        background-color: #e3f2fd;
        box-shadow: 0 4px 12px rgba(33, 150, 243, 0.2);
        transform: translateY(-2px);
    }

    .indicator-left {
        display: flex;
        align-items: center;
    }

    .indicator-left i.material-icons {
        font-size: 28px;
        color: #2196f3;
        margin-right: 16px;
    }

    .indicator-title {
        font-size: 16px;
        font-weight: 500;
        color: #333;
    }

    .indicator-badge {
        background-color: #2196f3;
        color: white;
        font-size: 13px;
        font-weight: bold;
        padding: 5px 14px;
        border-radius: 20px;
        min-width: 28px;
        text-align: center;
    }


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

    .modal-content h5 {
        font-weight: 600;
        margin-bottom: 30px;
    }

    .modal-footer {
        padding: 10px 20px;
    }

    .file-name {
        margin-top: 10px;
        font-size: 14px;
    }

    /* Warna latar belakang bar (abu-abu keputihan) */
    .progress {
    background-color: #e0e0e0 !important; /* atau ganti ke warna keputihan lainnya */
    }

    /* Warna indeterminate loader (putih) */
    .progress .indeterminate {
    background-color: #ffffff !important;
    }
</style>

<!-- Modal Upload CSV -->
<div id="timModals" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h5 class="center-align">Upload CSV File</h5>

    <!-- Dropzone Area -->
    <div id="dropzone" class="drop-area z-depth-1">
      <i class="material-icons large grey-text text-lighten-1">cloud_upload</i>
      <p class="grey-text">Drag & Drop file di sini atau klik untuk memilih</p>
      <input type="file" id="csvFile" accept=".csv" hidden>
    </div>

    <div class="file-name center-align grey-text text-darken-1" id="fileNameDisplay">
      Tidak ada file yang dipilih
    </div>

    <small class="grey-text center-align d-block" style="display:block; text-align:center; margin-top:10px;">
      * Format file: <code>.csv</code> | Max size: 2MB
    </small>
  </div>

  <div class="modal-footer">
    <button class="btn waves-effect waves-light" onclick="saveData()">
      <i class="material-icons left">check</i>Upload
    </button>
    <button class="btn-flat modal-close">Batal</button>
  </div>
</div>




<div class="col s12" style="margin-bottom:20px;">
    <div class="col s12" id="breadCrumpView"></div>
</div>
<div class="row" style="margin:0px 0px 0px 0px;">
    <div class="col s12" style="">
        <div class="col s12" style="padding:5px;">
            <input oninput="searchText()" id="searchTextForm" type="text" style="width:99%; background:white; padding:5px 10px; border-radius:7px;" placeholder="Masukkan Kata Kunci">
        </div>
    </div>
    
    <!-- <div class="col s12" id="listData" style="padding:20px; font-family: 'Nunito', sans-serif !important; ">
       
        
    </div> -->
    <div class="row">
        <ul class="indicator-list" id="listData">
            
            <li class="indicator-item" style="min-height: 64px; padding: 8px;">
                <div class="indicator-left" style="display: flex; align-items: center; width: 100%;">
                    <i class="material-icons">male</i>
                    <div class="indicator-title" style="flex: 1; margin-left: 12px;">
                    <div class="progress" style="margin: 4px 0;">
                        <div class="indeterminate"></div>
                    </div>
                    <span class="indicator-text" style="display:none;">Data dimuat</span>
                    </div>
                </div>
                <span class="indicator-badge">0</span>
            </li>
            <li class="indicator-item" style="min-height: 64px; padding: 8px;">
                <div class="indicator-left" style="display: flex; align-items: center; width: 100%;">
                    <i class="material-icons">male</i>
                    <div class="indicator-title" style="flex: 1; margin-left: 12px;">
                    <div class="progress" style="margin: 4px 0;">
                        <div class="indeterminate"></div>
                    </div>
                    <span class="indicator-text" style="display:none;">Data dimuat</span>
                    </div>
                </div>
                <span class="indicator-badge">0</span>
            </li>
            <li class="indicator-item" style="min-height: 64px; padding: 8px;">
                <div class="indicator-left" style="display: flex; align-items: center; width: 100%;">
                    <i class="material-icons">male</i>
                    <div class="indicator-title" style="flex: 1; margin-left: 12px;">
                    <div class="progress" style="margin: 4px 0;">
                        <div class="indeterminate"></div>
                    </div>
                    <span class="indicator-text" style="display:none;">Data dimuat</span>
                    </div>
                </div>
                <span class="indicator-badge">0</span>
            </li>
            <!-- <li class="indicator-item" onclick="openData(4)">
                <div class="indicator-left">
                    <i class="material-icons">male</i>
                    <span class="indicator-title">Dedi Irawan</span>
                </div>
                <span class="indicator-badge">14</span>
            </li>
            <li class="indicator-item" onclick="openData(5)">
                <div class="indicator-left">
                    <i class="material-icons">male</i>
                    <span class="indicator-title">Eko Prasetyo</span>
                </div>
                <span class="indicator-badge">6</span>
            </li>
            <li class="indicator-item" onclick="openData(6)">
                <div class="indicator-left">
                    <i class="material-icons">male</i>
                    <span class="indicator-title">Fahri Ramadhan</span>
                </div>
                <span class="indicator-badge">11</span>
            </li>
            <li class="indicator-item" onclick="openData(7)">
                <div class="indicator-left">
                    <i class="material-icons">male</i>
                    <span class="indicator-title">Gilang Mahesa</span>
                </div>
                <span class="indicator-badge">5</span>
            </li>
            <li class="indicator-item" onclick="openData(8)">
                <div class="indicator-left">
                    <i class="material-icons">male</i>
                    <span class="indicator-title">Hendra Gunawan</span>
                </div>
                <span class="indicator-badge">10</span>
            </li>
            <li class="indicator-item" onclick="openData(9)">
                <div class="indicator-left">
                    <i class="material-icons">male</i>
                    <span class="indicator-title">Iqbal Hidayat</span>
                </div>
                <span class="indicator-badge">8</span>
            </li>
            <li class="indicator-item" onclick="openData(10)">
                <div class="indicator-left">
                    <i class="material-icons">male</i>
                    <span class="indicator-title">Joko Rahardjo</span>
                </div>
                <span class="indicator-badge">13</span>
            </li> -->
        </ul>
    </div>

    <div class="row">
        <ul class="pagination" id="listPagination">
            <li class="disabled"><a href="#">&laquo; Prev</a></li>
            <li class="active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">Next &raquo;</a></li>
        </ul>
    </div>

</div>


<!-- <a id="addButton" href="#timModals"style="position:fixed; bottom:20px; right:20px;" class="btn-floating btn-large waves-effect waves-light red modal-trigger"><i class="material-icons">add</i></a> -->
<script>
    var idJenisData="<?php echo $_GET['idJenisData']; ?>";
    var breadCrump=[
        {
            "text":"Dasboard",
            "url":"<?php echo $URL; ?>/admin/homepage"
        },
        {
            "text":"Jenis Data Approval",
            "url":"<?php echo $URL; ?>/admin/jenisDataApproval"
        }
    ];
    var myResponAllData=[];
    var idArtikel=-1;
    var tags="all";
    var kategori="all";
    var search="";
    var numPage=1;
    var loadUrl="";
    var endPointUrl="";
    var jenisDataTitle="";
    
    $(document).ready( function () {    
        showProperties();
        // showItem();
        
    } );

    function parseSummaryString(str) {
        const result = {};
        str.split(";").filter(Boolean).forEach(pair => {
            const [key, val] = pair.split(":");
            result[key] = val;
        });
        return result;
    }

    

    function showItem(){
        var token = localStorage.getItem('token');

        $.ajax({
            url: '<?php echo $URL; ?>/API/'+endPointUrl,
            method: 'POST',
            data: {
                "token":token,
                "numPage":numPage,
                "search":search,
                "type":"SUMMARY"
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                myResponAllData=JSON.parse(response);
                console.log(myResponAllData)
                
                if(myResponAllData.response_status=="true"){
                    $("#listData").html("");
                    // console.log(myResponAllData.data);
                    var admninList="";
                    for(a=0; a<myResponAllData.data.length;a++){

                        var titleCard="";
                        if(jenisDataTitle=="Organisasi Kepemudaan")
                            titleCard=myResponAllData.data[a].nama_organisasi;
                        else if(jenisDataTitle=="Komunitas Kepemudaan")
                            titleCard=myResponAllData.data[a].nama_komunitas;
                        else titleCard=myResponAllData.data[a].nik
                                               
                        admninList+=`
                            <li class="indicator-item" onclick="openData('${titleCard}')">
                                <div class="indicator-left">
                                    <i class="material-icons">male</i>
                                    <span class="indicator-title">${titleCard}</span>
                                </div>
                                <span class="indicator-badge">${myResponAllData.data[a].jumlah}</span>
                            </li>
                        `;
                        // }
                        
                    }

                    var listPage="";
                    for(a=0; (a<myResponAllData.list_page.length);a++){
                        
                        if(myResponAllData.list_page[a]==myResponAllData.page_now)
                        listPage+=`
                                <li class="active" onclick="setNumRow(${myResponAllData.list_page[a]})"><a href="#"  >${myResponAllData.list_page[a]}</a></li>
                            `;
                        else
                        listPage+=`
                                <li onclick="setNumRow(${myResponAllData.list_page[a]})"><a href="#" ">${myResponAllData.list_page[a]}</a></li>
                            `;
                        
                    }
                    $("#listData").html(admninList);
                    $("#listPagination").html(listPage);
                    $('.tooltipped').tooltip();
                }
                else{
                    alert(myResponAllData.message);
                }
                // console.log(JSON.stringify(myResponse.token));
                // alert(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
    function showProperties() {
        var token = localStorage.getItem('token');
        // console.log("masuk");

        $.ajax({
            url: '<?php echo $URL; ?>/API/showJenisData',
            method: 'POST',
            data: {
                "token": token,
                "idJenisData": idJenisData
            },
            dataType: 'json', // pastikan jQuery otomatis parsing JSON
            success: function (data) {
                console.log(data); // gunakan "data", bukan "response"

                // Tidak perlu stringify dan parse ulang
                var myResponAllData = data;

                if (myResponAllData.response_status === "true") {
                    let newItem = {
                        text: myResponAllData.data[0].judul,
                        url: "<?php echo $URL; ?>/admin/itemDataApproval/" + idJenisData
                    };
                    jenisDataTitle=myResponAllData.data[0].judul;
                    breadCrump.push(newItem);
                    createBreadCrum(breadCrump);
                    var thisEP=parseSummaryString(myResponAllData.data[0].url);
                    endPointUrl=thisEP.summary;
                    showItem();

                    // var linkJson = JSON.parse(myResponAllData.data[0].json_url);
                    // console.log(linkJson.load);
                    // loadUrl = linkJson.load;
                    // showItem();
                } else {
                    alert(myResponAllData.message);
                }
            },
            error: function (request, status, error) {
                console.log(request.responseText);
                console.log(status);
                console.log(error);
            }
        });
    }


    function openData(x){
        
        // var idArtikel=0;
        // if(x!=-1){
        //     idArtikel=myResponAllData.data[x].id;
        // }
        window.location="<?php echo $URL;?>/admin/detailItemApproval/"+idJenisData+"/"+x;
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
    function searchText(){
        search=$("#searchTextForm").val();
        showItem();
    }

    function setNumRow(x){
        numPage=x;
        showItem();
    }



    // input file
    const dropArea = document.getElementById("dropzone");
    const fileInput = document.getElementById("csvFile");
    const fileNameDisplay = document.getElementById("fileNameDisplay");

    // Click to open file dialog
    dropArea.addEventListener("click", () => fileInput.click());

    // File selected via dialog
    fileInput.addEventListener("change", handleFile);

    // Drag & drop
    dropArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropArea.classList.add("hover");
    });

    dropArea.addEventListener("dragleave", () => {
        dropArea.classList.remove("hover");
    });

    dropArea.addEventListener("drop", (e) => {
        e.preventDefault();
        dropArea.classList.remove("hover");
        fileInput.files = e.dataTransfer.files;
        handleFile();
    });

    function handleFile() {
        if (fileInput.files.length > 0) {
        fileNameDisplay.textContent = fileInput.files[0].name;
        } else {
        fileNameDisplay.textContent = "Tidak ada file yang dipilih";
        }
    }

    function saveData() {
        if (fileInput.files.length === 0) {
        M.toast({ html: 'Silakan pilih file terlebih dahulu!', classes: 'red darken-1' });
        return;
        }
        // Lanjutkan proses upload di sini...
        M.toast({ html: 'File siap diupload!', classes: 'green' });
    }
</script>