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

    @media only screen and (max-width: 600px) {
        #listArtikel .card-content {
            min-height: auto !important;
        }
    }
</style>

<!-- Modal Structure -->
<div id="ippModals" class="modal" style="border-radius: 12px;">
  <div class="modal-content" style="padding: 32px 24px;">
    <h5 style="font-weight: 600; margin-bottom: 24px;">📋 Detail Indikator IPP</h5>

    <div class="col s12" style="margin-bottom: 20px;">
      <label style="font-size: 13px; color: #757575;">Domain</label>
      <div id="domainForm" style="font-size: 16px; font-weight: 500; color: #212121;">-</div>
    </div>

    <div class="col s12" style="margin-bottom: 20px;">
      <label style="font-size: 13px; color: #757575;">Indikator</label>
      <div id="indikatorForm" style="font-size: 16px; font-weight: 500; color: #212121;">-</div>
    </div>

    <div class="col s12" style="margin-bottom: 20px;">
      <label style="font-size: 13px; color: #757575;">Definisi</label>
      <div id="definisiForm" style="font-size: 15px; line-height: 1.6; color: #424242; text-align: justify;">-</div>
    </div>

    <div class="col s12 m6" style="margin-bottom: 20px;">
        <label style="font-size: 13px; color: #757575;">Nilai Minimum</label>
        <div id="minValForm" style="font-size: 15px; line-height: 1.6; color: #424242; text-align: justify;">-</div>
    </div>

    <div class="col s12 m6" style="margin-bottom: 30px;">
        <label style="font-size: 13px; color: #757575;">Nilai Maximum</label>
        <div id="maxValForm" style="font-size: 15px; line-height: 1.6; color: #424242; text-align: justify;">-</div>
    </div>

    <div class="col s12 m6" style="margin-bottom: 20px;">
      <label style="font-size: 13px; color: #757575;">Tahun</label>
      <div id="tahunForm" style="font-size: 16px; font-weight: 500; color: #212121;">-</div>
    </div>

    <div class="col s12 m6" style="margin-bottom: 30px;">
      <label for="dataForm" style="font-size: 13px; color: #757575;">Data</label>
      <input type="number" id="dataForm" placeholder="Masukkan nilai data" style="padding: 8px 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 15px; width: 80%;">
    </div>

    <div class="right-align">
      <button class="btn blue darken-1 white-text" onclick="saveIPP()" style="border-radius: 8px; margin-right: 10px;">
        <i class="material-icons left white-text">save</i> Simpan
      </button>
    </div>
  </div>
</div>

<!-- Modal Upload CSV -->
<div id="uploadModals" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h5 class="center-align">Upload File</h5>
        <div class="col s12">
            <div class="input-field inline col s12" style="margin-right: 10px;">
                <input type="text" id="namaInputForm">
                <label for="namaInputForm">Nama File</label>
            </div>
        </div>
        <div class="col s12">
            <div class="input-field col s12 m6">
                <select id="jenisInputForm">
                    <option value="" disabled selected>Pilih Jenis Dokumen</option>
                    <option value="IPP">IPP</option>
                    <option value="RAD">RAD</option>
                </select>
                <label>Jenis Dokumen</label>
            </div>
            <div class="col s12 m6">
                <div class="input-field inline col s12" style="margin-right: 10px;">
                    <input type="number" id="tahunDokumenInputForm" min="2000" max="2100" value="2025">
                    <label for="tahunDokumenInputForm">Tahun</label>
                </div>
            </div>
            <input type="hidden" id="idDokumenInputForm">
        </div>
        
        <div class="col s12">            
            <!-- Dropzone Area -->
            <div id="dropzone" class="drop-area z-depth-1">
                <i class="material-icons large grey-text text-lighten-1">cloud_upload</i>
                <p class="grey-text">Drag & Drop file di sini atau klik untuk memilih</p>
                <input type="file" id="pdfFile" accept=".pdf" hidden>
            </div>

            <div class="file-name center-align grey-text text-darken-1" id="fileNameDisplay">
                Tidak ada file yang dipilih
            </div>
            <small class="grey-text center-align d-block" style="display:block; text-align:center; margin-top:10px;">
                * Format file: <code>.pdf</code> | Max size: 2MB
            </small>
            <div style="text-align:center">
                <a href="#" class="" id="downloadFileUpload" target="blank_">Download File</a>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn waves-effect waves-light" onclick="uploadDocIPP()">
            <i class="material-icons left">check</i>Upload
        </button>
        <button class="btn-flat modal-close">Batal</button>
    </div>
</div>




<div class="col s12" style="margin-bottom:20px;">
    <div class="col s12" id="breadCrumpView"></div>
</div>
<div class="row" style="margin:0px 0px 0px 0px;">
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content row">
                    <div class="input-field col s12">
                        <textarea id="deskripsiIPPForm" class="materialize-textarea" rows="3" placeholder="Masukkan deskripsi IPP di sini..."></textarea>
                        <label for="deskripsiIPPForm">Deskripsi IPP</label>
                    </div>
                    <input type="hidden" id="idDeskripsiForm">
                    <div class="col s12">
                        <div class="btn col s12 m10 l8 push-m1 push-l2" onclick="saveKontennDeskripsi()">Simpan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    <!-- Kartu IPP -->
        <div class="col s12 m12 l6 xl4">
            <div class="card center-align col s12" style="padding:10px !important;">
                <div class="card-content"  >
                    <div class="row"><span class="card-title left">Dokumen</span><i class="material-icons right" onclick="openUploadModal(-1,-1)">add</i></div>
                    <div class="row">
                        <ul class="collapsible" id="listDokumenIPP">
                            <li>
                                <div class="collapsible-header">2025</div>
                                <div class="collapsible-body">
                                    <ul class="collection with-header">
                                        <li class="collection-item row"><span class="left">File IPP</span><i class="material-icons right">edit</i></li>
                                        <li class="collection-item row"><span class="left">File RAD</span><i class="material-icons right">edit</i></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="collapsible-header">2024</div>
                                <div class="collapsible-body">
                                    <ul class="collection with-header">
                                        <li class="collection-item row"><span class="left">File IPP</span><i class="material-icons right">edit</i></li>
                                        <li class="collection-item row"><span class="left">File RAD</span><i class="material-icons right">edit</i></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="collapsible-header">2023</div>
                                <div class="collapsible-body">
                                    <ul class="collection with-header">
                                        <li class="collection-item row"><span class="left">File IPP</span><i class="material-icons right">edit</i></li>
                                        <li class="collection-item row"><span class="left">File RAD</span><i class="material-icons right">edit</i></li>
                                    </ul>
                                </div>
                            </li>
                            
                        </ul>

                    </div>
                </div>
            </div>

        </div>

        <!-- Tabel Data Indikator IPP -->
        <div class="col s12 m12 l6 xl8">
            <div class="card">
                <div class="card-content">
                    <div class="row valign-wrapper" style="margin-bottom: 10px;">
                        <div class="col s6">
                            <span class="card-title">DATA INDIKATOR IPP</span>
                        </div>
                        <div class="col s6 right-align">
                            <div class="input-field inline" style="margin-right: 10px;">
                                <input type="number" onChange="showIPP()" id="tahunInputForm" min="2000" max="2100" value="2025">
                                <label for="tahunInputForm">Tahun</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <table class="striped responsive-table">
                                <thead>
                                    <tr>
                                        <th>Domain</th>
                                        <th>Indikator</th>
                                        <th>Data</th>
                                        <th>Tahun</th>
                                    </tr>
                                </thead>
                                <tbody id="listIPPTahunan">
                                    <tr>
                                        <td>Pendidikan</td>
                                        <td>Rata-rata lama sekolah</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>APK Sekolah Menengah</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>APK Perguruan Tinggi</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td>Kesehatan dan Kesejahteraan</td>
                                        <td>Angka kesakitan pemuda</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Persentase korban kejahatan</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Persentase pemuda yang merokok</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Persentase remaja perempuan yang sedang hamil</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td>Lapangan dan Kesempatan Kerja</td>
                                        <td>Persentase pemuda wirausaha kerah putih</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Tingkat pengangguran terbuka</td>
                                        <td>0</td>
                                    </tr>
                                    <!-- Tambahkan baris lainnya di sini jika perlu -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    var tipe="-";
    var choosenIdIPP=0;
    var breadCrump=[
        {
            "text":"Dasboard",
            "url":"<?php echo $URL; ?>/admin/homepage"
        },
        {
            "text":'IPP',
            "url":"<?php echo $URL; ?>/admin/ipp"
        }
    ];
    var myResponAllData=[];
    var myRespAllDocData=[];
    var idArtikel=-1;
    
    $(document).ready( function () {    
        showIPP();
        showDeskripsi();
        createBreadCrum(breadCrump);
        loadDocumentIPP();
    } );

    

    function showIPP() {
        var tahun = $("#tahunInputForm").val();

        Swal.fire({
            title: 'Memuat data...',
            html: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '<?php echo $URL; ?>/API/loadIPP',
            method: 'POST',
            data: {
                "tahun": tahun
            },
            success: function (data) {
                Swal.close(); // tutup loading

                var response = JSON.stringify(data);
                var myResponAllData = JSON.parse(response);

                if (myResponAllData.response_status == "true") {
                    $("#listIPPTahunan").html("");
                    var admninList = "";

                    for (let a = 0; a < myResponAllData.data.length; a++) {
                        admninList += `
                            <tr onClick='openDetilIPP(${JSON.stringify(myResponAllData.data[a])})'>
                                <td>${myResponAllData.data[a].domain}</td>
                                <td>${myResponAllData.data[a].indikator}</td>
                                <td>${myResponAllData.data[a].data}</td>
                                <td>${myResponAllData.data[a].tahun}</td>                                
                            </tr>
                        `;
                    }

                    $("#listIPPTahunan").html(admninList);
                    $('.tooltipped').tooltip();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal',
                        text: myResponAllData.message || 'Data tidak ditemukan',
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan',
                    text: 'Tidak dapat memuat data. Cek koneksi atau hubungi admin.',
                    footer: `<small>${textStatus}: ${errorThrown}</small>`
                });
                console.error('Error:', jqXHR, textStatus, errorThrown);
            }
        });
    }

    function openDetilIPP(x) {
        

        // Isi data ke form atau tampilkan
        $("#domainForm").html(x.domain);
        $("#indikatorForm").html(x.indikator);
        $("#definisiForm").html(x.definisi);
        $("#tahunForm").html(x.tahun);
        $("#minValForm").html(x.min_value);
        $("#maxValForm").html(x.max_value);
        $("#dataForm").val(x.data);

        // Jika kamu punya field tahun atau data, bisa tambahkan juga
        console.log("Tahun:", x.tahun);
        console.log("Data:", x.data);
        choosenIdIPP=x.id;
        $("#ippModals").modal("open");
        M.updateTextFields();
    }

    function saveIPP() {
        // Ambil data dari form
        const domain = $("#domainForm").html();
        const indikator = $("#indikatorForm").html();
        const definisi = $("#definisiForm").html();
        const tahun = $("#tahunForm").html();
        const minVal = $("#minValForm").html();
        const maxVal = $("#maxValForm").html();
        const dataValue = $("#dataForm").val();
        const token = localStorage.getItem('token');

        let formData = new FormData();
        formData.append('token', token);
        formData.append("domain", domain);
        formData.append("indikator", indikator);
        formData.append("definisi", definisi);
        formData.append("tahun", tahun);
        formData.append("data", dataValue);
        formData.append("min_value", minVal);
        formData.append("max_value", maxVal);

        // Show loading Swal
        Swal.fire({
            title: 'Menyimpan...',
            html: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '<?php echo $URL; ?>/API/saveIPP',
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,

            success: function (data) {
                Swal.close(); // Tutup loading
                const response = JSON.stringify(data);
                const myResponse = JSON.parse(response);

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: myResponse.message,
                    confirmButtonColor: '#3085d6'
                });
            },

            complete: function () {
                showIPP(); // refresh list
                $("#ippModals").modal("close");
            },

            error: function (jqXHR, textStatus, errorThrown) {
                Swal.close(); // Tutup loading

                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    html: `
                        <strong>Status:</strong> ${textStatus}<br>
                        <strong>Error:</strong> ${errorThrown}<br>
                        Cek console untuk info lebih lanjut.`,
                    confirmButtonColor: '#d33'
                });

                console.error('jqXHR:', jqXHR);
                console.error('textStatus:', textStatus);
                console.error('errorThrown:', errorThrown);
            }
        });
    }


    function openUploadModal(a, b) {
        if (a == -1 && b == -1) {
            // Reset semua input
            $("#idDokumenInputForm").val("0");
            $("#namaInputForm").val("");
            $("#jenisInputForm").val("");
            $("#tahunDokumenInputForm").val("2025");
            $("#pdfFile").val(null); // reset file input
            $("#fileNameDisplay").text("Tidak ada file yang dipilih"); // reset nama file
            $("#downloadFileUpload").css("display","none"); // reset nama file
        } else {
            const choosenData = myRespAllDocData.data[a].dataList[b];
            $("#idDokumenInputForm").val(choosenData.id);
            $("#namaInputForm").val(choosenData.nama);
            $("#jenisInputForm").val(choosenData.jenis);
            $("#tahunDokumenInputForm").val(choosenData.tahun);
            // Jangan set file input di sini
            $("#fileNameDisplay").text("File sudah terupload (edit manual jika ingin ubah)"); // opsional
            $("#downloadFileUpload").css("display","block"); // reset nama file
            $('#downloadFileUpload').attr('href', '<?php echo $URL;?>/'+choosenData.pathFile);
        }

        // Refresh tampilan Materialize
        $('select').formSelect();
        M.updateTextFields();
        $("#uploadModals").modal("open");
    }


    // Deskripsi
    function showDeskripsi(){
        var token = localStorage.getItem('token');

        $.ajax({
            url: '<?php echo $URL; ?>/API/showKonten',
            method: 'POST',
            data: {
                "token":token,
                "tipeKonten":'IPP DESKRIPSI',
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                var myResponDeskripsiData=JSON.parse(response);
                // console.log(data);
                
                if(myResponDeskripsiData.response_status=="true"){
                    $("#deskripsiIPPForm").val(myResponDeskripsiData.data[0].deskripsi_id);
                    $("#idDeskripsiForm").val(myResponDeskripsiData.data[0].id);
                    M.textareaAutoResize($('#deskripsiIPPForm'));
                }
                else{
                    alert(myResponAllData.message);
                }
                // console.log(JSON.stringify(myResponse.token));
                // alert(data);
            }
        });
    }
    function saveKontennDeskripsi() {
        var token = localStorage.getItem('token');

        let formData = new FormData();
        formData.append('token', token);
        formData.append("deskripsi_id", $("#deskripsiIPPForm").val());
        formData.append("idKonten", $("#idDeskripsiForm").val());
        formData.append("tipe_konten", 'IPP DESKRIPSI');

        $.ajax({
            url: '<?php echo $URL; ?>/API/saveKonten',
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,

            success: function (data) {
                var response = JSON.stringify(data);
                var myResponse = JSON.parse(response);

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: myResponse.message,
                    confirmButtonColor: '#3085d6'
                });
            },

            complete: function () {
                showDeskripsi();
                $("#preloaderView").css("display", "none");
            },

            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    html: `
                        <strong>Status:</strong> ${textStatus}<br>
                        <strong>Error:</strong> ${errorThrown}<br>
                        Cek console untuk info lebih lanjut.`,
                    confirmButtonColor: '#d33'
                });

                console.log('jqXHR:', jqXHR);
                console.log('textStatus:', textStatus);
                console.log('errorThrown:', errorThrown);
            },
        });
    }



    // =============Upload File=======================

    // input file
    const dropArea = document.getElementById("dropzone");
    const fileInput = document.getElementById("pdfFile");
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


    function uploadDocIPP() {
        const token = localStorage.getItem('token');
        const idInputForm = document.getElementById('idDokumenInputForm');
        const namaInputForm = document.getElementById('namaInputForm');
        const jenisInputForm = document.getElementById('jenisInputForm');
        const tahunDokumenInputForm = document.getElementById('tahunDokumenInputForm');
        const fileInput = document.getElementById('pdfFile');
        const file = fileInput.files[0];

        const formData = new FormData();
        formData.append('token', token);
        formData.append('nama', namaInputForm.value);
        formData.append('tahun', tahunDokumenInputForm.value);
        formData.append('jenis', jenisInputForm.value);
        if (idInputForm !== "0")
            formData.append('idDokumenIPP', idInputForm.value);

        // Hanya tambahkan file kalau memang ada
        if (file) {
            formData.append('pathFile', file);
        }

        const apiUrl = "<?php echo $URL; ?>/API/saveDokumenIPP";
        // Tampilkan loading sebelum upload
        Swal.fire({
            title: 'Mengunggah dokumen...',
            html: 'Mohon tunggu beberapa saat.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: apiUrl,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,

            success: function (data) {
                Swal.close();
                const myResponse = typeof data === "string" ? JSON.parse(data) : data;

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: myResponse.message,
                    confirmButtonColor: '#3085d6'
                });
            },

            complete: function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    confirmButtonColor: '#3085d6'
                });
                loadDocumentIPP();
                $("#uploadModals").modal("close");
            },

            error: function (jqXHR, textStatus, errorThrown) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    html: `
                        <strong>Status:</strong> ${textStatus}<br>
                        <strong>Error:</strong> ${errorThrown}<br>
                        Cek console untuk info lebih lanjut.`,
                    confirmButtonColor: '#d33'
                });

                console.error('jqXHR:', jqXHR);
                console.error('textStatus:', textStatus);
                console.error('errorThrown:', errorThrown);
            }
        });
    }

    function loadDocumentIPP() {
        
        $.ajax({
            url: '<?php echo $URL; ?>/API/loadDokumenIPP',
            method: 'POST',
            data: {
                "token": ""
            },
            success: function (data) {
                Swal.close(); // tutup loading

                var response = JSON.stringify(data);
                myRespAllDocData = JSON.parse(response);

                if (myRespAllDocData.response_status == "true") {
                    // console.log(myRespAllDocData);

                    $("#listDokumenIPP").html("");
                    var admninList = "";
                    for (let a = 0; a < myRespAllDocData.data.length; a++) {
                        admninList += `
                            <li>
                                <div class="collapsible-header">${myRespAllDocData.data[a].tahun}</div>
                                <div class="collapsible-body">
                                    <ul class="collection with-header">`;
                        var thisData=myRespAllDocData.data[a].dataList;
                        for (let b = 0; b < thisData.length; b++){
                            admninList += `
                            <li class="collection-item row">
                                <span class="left">${(thisData[b].nama).substring(0, 15)} [${thisData[b].jenis}]</span>
                                <i class="material-icons right" style="cursor:pointer" onClick="openUploadModal(${a},${b})">edit</i>
                                <i class="material-icons red-text right" style="cursor:pointer" onClick="deleteDocumentIPP(${thisData[b].id})">delete</i>
                            </li>`;
                        }
                        admninList += ` </ul>
                                </div>
                            </li>
                        `;
                    }

                    $("#listDokumenIPP").html(admninList);
                    $('.tooltipped').tooltip();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal',
                        text: myRespAllDocData.message || 'Data tidak ditemukan',
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan',
                    text: 'Tidak dapat memuat data. Cek koneksi atau hubungi admin.',
                    footer: `<small>${textStatus}: ${errorThrown}</small>`
                });
                console.error('Error:', jqXHR, textStatus, errorThrown);
            }
        });
    }

    function deleteDocumentIPP(x) {
        const token = localStorage.getItem('token');

        Swal.fire({
            title: "Yakin ingin menghapus data ini?",
            text: "Data yang dihapus tidak bisa dikembalikan.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#aaa",
            confirmButtonText: "Ya, hapus",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {

                // Tampilkan loading
                Swal.fire({
                    title: 'Menghapus data...',
                    html: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '<?php echo $URL; ?>/API/deleteDokumenIPP',
                    method: 'POST',
                    data: {
                        token: token,
                        idDokumenIPP: x,
                    },

                    success: function (data) {
                        Swal.close(); // Tutup loading
                        const response = JSON.stringify(data);
                        const myResponse = JSON.parse(response);

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: myResponse.message,
                            confirmButtonColor: '#3085d6'
                        });

                        loadDocumentIPP(); // Refresh data
                        $("#uploadModals").modal("close");
                    },

                    error: function (jqXHR, textStatus, errorThrown) {
                        Swal.close(); // Tutup loading

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menghapus',
                            html: `
                                <strong>Status:</strong> ${textStatus}<br>
                                <strong>Error:</strong> ${errorThrown}<br>
                                Silakan cek koneksi atau hubungi admin.`,
                            confirmButtonColor: '#d33'
                        });

                        console.error('jqXHR:', jqXHR);
                        console.error('textStatus:', textStatus);
                        console.error('errorThrown:', errorThrown);
                    }
                });
            }
        });
    }

    // =============Upload File=======================
</script>