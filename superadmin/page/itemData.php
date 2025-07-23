<style>
    /* Styling untuk user card dan status badge */
    .user-card {
        position: relative;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        padding: 20px 20px 20px 80px;
        margin-bottom: 20px;
        transition: box-shadow 0.3s ease;
    }

    .user-card:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .user-avatar {
        position: absolute;
        left: 20px;
        top: 20px;
        background-color: #e3f2fd;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-avatar i {
        color: #1976d2;
        font-size: 24px;
    }

    .status-badge {
        position: absolute;
        top: -10px;
        right: 20px;
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        color: white;
        text-transform: uppercase;
    }

    .status-waiting { background-color: #ffb300; }
    .status-approved { background-color: #43a047; }
    .status-rejected { background-color: #e53935; }
    .status-main { background-color: #1e88e5; }

    .action-icons {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        align-items: center;
    }

    .action-icons i {
        margin-left: 10px;
        cursor: pointer;
        transition: color 0.2s ease, transform 0.2s ease;
    }

    .action-icons i:hover {
        transform: scale(1.2);
    }

    .action-icons .edit { color: #1976d2; }
    .action-icons .approve { color: #388e3c; }
    .action-icons .reject { color: #d32f2f; }
    .action-icons .compare { color: #ad2fd3; }




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
<div id="uploadModals" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h5 class="center-align">Upload CSV File</h5>
    <i onclick="downloadTemplate()" class="blue-text" style="cursor:pointer;">Download Template</i>
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
    <button class="btn waves-effect waves-light" onclick="uploadData()">
      <i class="material-icons left">check</i>Upload
    </button>
    <button class="btn-flat modal-close">Batal</button>
  </div>
</div>

<div id="formModal" class="modal">
  <div class="modal-content">
    <h4>Formulir</h4>
    <div id="dynamicForm"></div>
  </div>
  <div class="modal-footer">
    <button class="modal-close btn grey white-text" style="border:none">Batal</button>
    <button class="btn blue white-text" style="border:none" onclick="submitForm()">Simpan</button>
    <button class="btn red white-text" style="border:none" onclick="deleteData()">Hapus</button>
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
    <div class="row" style="margin-top: 20px;">
        <div class="col s12">
            <a onclick="exportToExcel()" class="waves-effect waves-light btn green white-text" style="border:none">
                <i class="material-icons left">grid_on</i> Export Excel
            </a>
            <!-- <a onclick="exportToPDF()" class="waves-effect waves-light btn red white-text" style="border:none">
                <i class="material-icons left">picture_as_pdf</i> Export PDF
            </a> -->
        </div>
    </div>
    
    <!-- <div class="col s12" id="listData" style="padding:20px; font-family: 'Nunito', sans-serif !important; ">
       
        
    </div> -->
    <div class="row">
        <!-- <ul class="indicator-list" id="listData">
            
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
            
        </ul> -->
        <div class="col s12" id="listData">
            <!-- Card 1 - Waiting Approval -->
            <div class="user-card">
                <div class="progress" style="">
                    <div class="indeterminate"></div>
                </div>
            </div>
            <div class="user-card">
                <div class="progress" style="">
                    <div class="indeterminate"></div>
                </div>
            </div>
            <div class="user-card">
                <div class="progress" style="">
                    <div class="indeterminate"></div>
                </div>
            </div>
        </div>
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

<div class="fixed-action-btn" style="position:fixed; bottom:20px; right:20px;">
  <a class="btn-floating btn-large red">
    <i class="large material-icons">add</i>
  </a>
  <ul>
    <li><a class="btn-floating waves-effect waves-light red modal-trigger btn-large tooltipped" data-position="left" data-tooltip="Upload csv" href="#uploadModals"><i class="material-icons">upload</i></a></li>
    <li><a class="btn-floating blue darken-1 waves-effect waves-light blue  btn-large tooltipped" onclick="openData(0)" data-position="left" data-tooltip="Input Form"><i class="material-icons">edit</i></a></li>
  </ul>
</div>

<!-- <a href="#uploadModals" style="position:fixed; bottom:20px; right:20px;" class="btn-floating btn-large waves-effect waves-light red modal-trigger"><i class="material-icons">add</i></a> -->
<!-- Litepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    var idJenisData="<?php echo $_GET['idJenisData']; ?>";
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
    var tags="all";
    var kategori="all";
    var search="";
    var numPage=1;
    var loadUrl="";
    var endPointUrl="";
    var saveUploadUrl="";
    var jenisDataTitle="";
    var formType="";
    var selectedId=0;
    const fieldMap = {
        nama: 'Nama',
        nik: 'NIK',
        nama_organisasi: 'Nama Organisasi',
        nama_komunitas: 'Nama Komunitas',
        instagram: "Instagram",
    };

    const formMap = {
        nama: { label: 'Nama', type: 'text' },
        nik: { label: 'NIK', type: 'text' },
        tempat_lahir: { label: 'Tempat Lahir', type: 'text' },
        tanggal_lahir: { label: 'Tanggal Lahir', type: 'date' },
        alamat_ktp: { label: 'Alamat KTP', type: 'text' },
        alamat_domisili: { label: 'Alamat Domisili', type: 'text' },
        no_hp: { label: 'Nomor HP', type: 'text' },
        email: { label: 'Email', type: 'email' },
        instagram: { label: 'Instagram', type: 'text' },
        kecamatan: { label: 'Kecamatan', type: 'kecamatan'},
        jenis_kelamin:  { label:'Jenis Kelamin', type: 'jenis_kelamin'},

        // Pemuda Inovatif
        nama_karya: { label: 'Nama Karya', type: 'text' },
        bidang_karya: { label: 'Bidang Karya', type: 'text' },
        tahun_mulai_karya: { label: 'Tahun Mulai Karya', type: 'number' },
        
        // Pemuda Pelopor
        nama_kepeloporan: { label: 'Nama Kepeloporan', type: 'text' },
        bidang_kepeloporan: { label: 'Bidang Kepeloporan', type: 'bidang_kepeloporan' },
        tahun_mulai_pelopor: { label: 'Tahun Mulai Pelopor', type: 'number' },
        
        // Wirausaha Muda
        nama_usaha: { label: 'Nama Usaha', type: 'text' },
        nama_pemilik: { label: 'Nama Pemilik', type: 'text' },
        no_hp_pemilik: { label: 'Nomor HP Pemilik', type: 'text' },
        jenis_usaha: { label: 'Jenis Usaha', type: 'text' },
        nama_produk: { label: 'Nama Produk', type: 'text' },
        tahun_mulai_usaha: { label: 'Tahun Mulai Usaha', type: 'number' },
        nib: { label: 'NIB', type: 'text' },
        
        // Pemuda Berprestasi
        nama_prestasi: { label: 'Nama Prestasi', type: 'text' },
        peringkat: { label: 'Peringkat', type: 'text' },
        penyelenggara: { label: 'Penyelenggara', type: 'text' },
        tahun_prestasi: { label: 'Tahun Prestasi', type: 'number' },
        
        // Pemuda Berorganisasi
        nama_organisasi: { label: 'Nama Organisasi', type: 'text' },
        ketua_organisasi: { label: 'Ketua Organisasi', type: 'text' },
        no_hp_ketua: { label: 'Nomor HP Ketua', type: 'text' },
        kegiatan: { label: 'Kegiatan', type: 'textarea' },
        tahun_bergabung: { label: 'Tahun Bergabung', type: 'number' },

        // Duta Pemuda
        predikat: { label: 'Predikat', type: 'text' },
        prestasi_akademik: { label: 'Prestasi Akademik', type: 'textarea' },
        prestasi_non_akademik: { label: 'Prestasi Non-Akademik', type: 'textarea' },

        // Organisasi Kepemudaan
        jumlah_anggota: { label: 'Jumlah Anggota', type: 'number' },
        tanggal_berdiri: { label: 'Tanggal Berdiri', type: 'date' },
        alamat_sekretariat: { label: 'Alamat Sekretariat', type: 'text' },

        // Komunitas Kepemudaan
        nama_komunitas: { label: 'Nama Komunitas', type: 'text' },
        ketua_komunitas: { label: 'Ketua Komunitas', type: 'text' },

        // Umum
        portfolio_karya: { label: 'Portofolio Karya Inovatif', type: 'upload_file' },
        portfolio_kepeloporan: { label: 'Portofolio Kepeloporan', type: 'upload_file' },
        portfolio_usaha: { label: 'Portofolio Usaha', type: 'upload_file' },
        sertifikat_prestasi: { label: 'Sertifikat Prestasi/Penghargaan', type: 'upload_file' },
        deskripsi: { label: 'Deskripsi', type: 'textarea' }
    };

    const formTypes = {
        PemudaInovatif: {
            fields: [
                'nama', 'nik', 'tempat_lahir', 'tanggal_lahir', 'alamat_ktp',
                'alamat_domisili', 'kecamatan', 'jenis_kelamin', 'no_hp', 'email', 'instagram', 'nama_karya',
                'bidang_karya', 'tahun_mulai_karya', 'deskripsi', 'portfolio_karya'
            ]
        },
        PemudaPelopor: {
            fields: [
                'nama', 'nik', 'tempat_lahir', 'tanggal_lahir', 'alamat_ktp',
                'alamat_domisili', 'kecamatan', 'jenis_kelamin', 'no_hp', 'email', 'instagram', 'nama_kepeloporan',
                'bidang_kepeloporan', 'tahun_mulai_pelopor', 'deskripsi', 'portfolio_kepeloporan'
            ]
        },
        WirausahaMuda: {
            fields: [
                'nama_pemilik', 'nik', 'tempat_lahir', 'tanggal_lahir', 'alamat_ktp',
                'alamat_domisili', 'kecamatan', 'jenis_kelamin', 'no_hp', 'email', 'instagram', 'nama_usaha',
                'no_hp_pemilik', 'jenis_usaha',
                'nama_produk', 'tahun_mulai_usaha', 'deskripsi', 'nib','portfolio_usaha'
            ]
        },
        PemudaBerprestasi: {
            fields: [
                'nama', 'nik', 'tempat_lahir', 'tanggal_lahir', 'alamat_ktp',
                'alamat_domisili', 'kecamatan', 'jenis_kelamin', 'no_hp', 'email', 'instagram', 'nama_prestasi',
                'peringkat', 'penyelenggara', 'tahun_prestasi', 'sertifikat_prestasi'
            ]
        },
        PemudaBerorganisasi: {
            fields: [
                'nama', 'nik', 'tempat_lahir', 'tanggal_lahir', 'alamat_ktp',
                'alamat_domisili', 'kecamatan', 'jenis_kelamin', 'no_hp', 'email', 'instagram', 'nama_organisasi',
                'ketua_organisasi', 'no_hp_ketua', 'kegiatan', 'tahun_bergabung'
            ]
        },
        DutaPemuda: {
            fields: [
                'nama', 'nik', 'tempat_lahir', 'tanggal_lahir', 'alamat_ktp',
                'alamat_domisili', 'kecamatan', 'jenis_kelamin', 'no_hp', 'email', 'instagram', 'predikat',
                'prestasi_akademik', 'prestasi_non_akademik', 'sertifikat_prestasi'
            ]
        },
        OrganisasiKepemudaan: {
            fields: [
                'nama_organisasi', 'ketua_organisasi', 'jumlah_anggota', 'no_hp_ketua',
                'kegiatan', 'kecamatan', 'jenis_kelamin', 'tanggal_berdiri', 'alamat_sekretariat', 'email', 'instagram'
            ]
        },
        KomunitasKepemudaan: {
            fields: [
            'nama_komunitas', 'email', 'instagram', 
            'ketua_komunitas',  'kecamatan', 'jenis_kelamin', 'no_hp_ketua', 'jumlah_anggota', 'kegiatan', 'tanggal_berdiri', 'alamat_sekretariat',
            ]
        }
    };

    const csvMappings = {
        KomunitasKepemudaan: [
            "Alamat Sekretariat Organisasi",
            "e-Mail",
            "Kecamatan",
            "Jenis Kelamin",
            "Username Instagram",
            "Nama Organisasi",
            "Nama Ketua Organisasi",
            "Nomor Hp Ketua Komunitas",
            "Jumlah Anggota Komunitas",
            "Kegiatan dalam Komunitas",
            "Tanggal Bediri Komunitas"
        ],
        PemudaBerorganisasi: [
            "Nama",
            "Tempat Lahir",
            "Tanggal Lahir",
            "NIK",
            "Alamat sesuai KTP",
            "Alamat Domisili Kota Serang",
            "Kecamatan",
            "Jenis Kelamin",
            "Nomor Hp",
            "e-Mail",
            "Username Instagram",
            "Nama Organisasi",
            "Nama Ketua Organisasi",
            "Nomor Hp Ketua Organisasi",
            "Kegiatan dalam Organisasi",
            "Tahun Bergabung dengan Organisasi"
        ],
        OrganisasiKepemudaan: [
            "Nama Organisasi",
            "Nama Ketua Organisasi",
            "Kecamatan",
            "Jenis Kelamin",
            "Nomor Hp Ketua Organisasi",
            "Jumlah Anggota Organisasi",
            "Kegiatan dalam Organisasi",
            "Tanggal Bediri Organisasi",
            "Alamat Sekretariat Organisasi",
            "e-Mail",
            "Username Instagram"
        ],
        DutaPemuda: [
            "Nama",
            "Tempat Lahir",
            "Tanggal Lahir",
            "NIK",
            "Alamat sesuai KTP",
            "Alamat Domisili Kota Serang",
            "Kecamatan",
            "Jenis Kelamin",
            "Nomor Hp",
            "e-Mail",
            "Username Instagram",
            "Predikat Duta yang Diraih",
            "Prestasi Akademik",
            "Prestasi Non Akademik"
        ],
        PemudaBerprestasi: [
            "Nama",
            "Tempat Lahir",
            "Tanggal Lahir",
            "NIK",
            "Alamat sesuai KTP",
            "Alamat Domisili Kota Serang",
            "Kecamatan",
            "Jenis Kelamin",
            "Nomor Hp",
            "e-Mail",
            "Username Instagram",
            "Nama Prestasi",
            "Peringkat",
            "Penyelenggara",
            "Tahun Prestasi"
        ],
        WirausahaMuda: [
            "Nama Pemilik Usaha",
            "Tempat Lahir",
            "Tanggal Lahir",
            "NIK",
            "Alamat sesuai KTP",
            "Alamat Domisili Kota Serang",
            "Kecamatan",
            "Jenis Kelamin",
            "Nomor Hp",
            "e-Mail",
            "Username Instagram",
            "Nama Usaha",            
            "Nomor Hp Pemilik Usaha",
            "Jenis Usaha",
            "Nama Produk",
            "Tahun Mulai Usaha",
            "Deskripsi Singkat tentang Kondisi UsahaTerkini",
            "Nomor NIB (jika ada silakan diisi)"
        ],
        PemudaPelopor: [
            "Nama",
            "Tempat Lahir",
            "Tanggal Lahir",
            "NIK",
            "Alamat sesuai KTP",
            "Alamat Domisili Kota Serang",
            "Kecamatan",
            "Jenis Kelamin",
            "Nomor Hp",
            "e-Mail",
            "Username Instagram",
            "Nama Kepeloporan",
            "Bidang Kepeloporan",
            "Tahun Mulai dilaksanakan Kepeloporan",
            "Deskripsi Singkat tentang Kepeloporan Terkini"
        ],
        PemudaInovatif: [
            "Nama",
            "Tempat Lahir",
            "Tanggal Lahir",
            "NIK",
            "Alamat sesuai KTP",
            "Alamat Domisili Kota Serang",
            "Kecamatan",
            "Jenis Kelamin",
            "Nomor Hp",
            "e-Mail",
            "Username Instagram",
            "Nama Inovasi",
            "Bidang Inovasi",
            "Tahun Mulai dilaksanakan Inovasi",
            "Deskripsi Singkat tentang Karya Inovasi Terkini"
        ]
    };



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

    // =============== Generate Card ================
    function generateCardDynamic(item) {
      const statusInfo = getStatusLabel(item.status);

      let infoHTML = '';
      for (const key in fieldMap) {
        if (item[key]) {
          infoHTML += `<div class="user-info"><strong>${fieldMap[key]}:</strong> ${item[key]}</div>\n`;
        }
      }

      if(item.status=='2')
        mainData=item;

      return `
      <div class="user-card">
        <div class="user-avatar">
          <i class="material-icons">male</i>
        </div>
        <div class="status-badge ${statusInfo.class}">${statusInfo.label}</div>
        ${infoHTML}
        
        <div class="action-icons">
          <i class='right grey-text'>By ${item.uploaded_by}</i>
          <i class="material-symbols-outlined tooltipped edit" data-tooltip="Lihat" onclick="openData(${item.id})">visibility</i>
          
        </div>
      </div>`;
    }
    function getStatusLabel(status) {
      switch (status) {
        case "1":
          return { label: "Waiting Approval", class: "status-waiting" };
        case "2":
          return { label: "Main Data", class: "status-main" };
        case "0":
          return { label: "Rejected", class: "status-rejected" };
        default:
          return { label: "Unknown", class: "status-unknown" };
      }
    }
    function renderCards(dataArray) {
      const container = document.getElementById("listData");
      container.innerHTML = dataArray.map(generateCardDynamic).join('');
    }
    //==============================================


    // =============== Generate Form ===============
    function generateForm(type, data = {}) {
        const formConfig = formTypes[type];
        if (!formConfig) {
            console.error("Form type not recognized:", type);
            return;
        }
        console.log(data);
        const container = document.getElementById("dynamicForm");
        container.innerHTML = ''; // Bersihkan form sebelumnya

        formConfig.fields.forEach(field => {
            const config = formMap[field];
            if (!config) return; // skip field yang tidak ada di formMap
            
            const value = data[field] || '';
            let inputHTML = '';

            
            if (config.type === 'textarea') {
                inputHTML = `
                    <div class="input-field  col s12">
                        <textarea id="${field}" name="${field}" class="materialize-textarea">${value}</textarea>
                        <label for="${field}" class="active">${config.label}</label>
                    </div>
                `;
            } else if (config.type === 'date') {
                inputHTML = `
                    <div class="input-field  col s12">
                        <input type="date" id="${field}" name="${field}"  value="${value}">
                        <label for="${field}" class="active">${config.label}</label>
                    </div>
                `;
            }else if (config.type === 'hidden') {
                inputHTML = `
                    <div class="input-field  col s12">
                        <input type="hidden" id="${field}" name="${field}" class="datepicker" value="${value}">
                        <label for="${field}" class="active">${config.label}</label>
                    </div>
                `;
            }else if (config.type === 'kecamatan') {
                inputHTML = `
                    <div class="input-field col s12 m6">
                        <select name="kecamatan" id="kecamatan" value="${value}">
                            <option value="Cipocok Jaya">Cipocok Jaya</option>
                            <option value="Curug">Curug</option>
                            <option value="Kasemen">Kasemen</option>
                            <option value="Serang">Serang</option>
                            <option value="Taktakan">Taktakan</option>
                            <option value="Walantaka">Walantaka</option>
                        </select>
                        <label>${config.label}</label>
                    </div>
                `;
            }else if (config.type === 'jenis_kelamin') {
                inputHTML = `
                    <div class="input-field col s12 m6">
                        <select name="jenis_kelamin" id="jenis_kelamin" value="${value}">
                            <option value="Laki - Laki">Laki - Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <label>${config.label}</label>
                    </div>
                `;
            }else if (config.type === 'bidang_kepeloporan') {
            const selectedValue = value || '';
            inputHTML = `
                <div class="input-field col s12">
                <select name="bidang_kepeloporan" id="bidang_kepeloporan">
                    <option value="" disabled ${selectedValue === '' ? 'selected' : ''}>Pilih Bidang</option>
                    <option value="Inovasi Teknologi" ${selectedValue === 'Inovasi Teknologi' ? 'selected' : ''}>Inovasi Teknologi</option>
                    <option value="Seni Budaya" ${selectedValue === 'Seni Budaya' ? 'selected' : ''}>Seni Budaya</option>
                    <option value="Pangan" ${selectedValue === 'Pangan' ? 'selected' : ''}>Pangan</option>
                    <option value="Pendidikan" ${selectedValue === 'Pendidikan' ? 'selected' : ''}>Pendidikan</option>
                    <option value="Pengelolaan Lingkungan, SDA, dan Pariwisata" ${selectedValue === 'Pengelolaan Lingkungan, SDA, dan Pariwisata' ? 'selected' : ''}>Pengelolaan Lingkungan, SDA, dan Pariwisata</option>
                </select>
                <label>${config.label}</label>
                </div>
            `;
            }else if (config.type === 'upload_file') {
                var downloadLink="";
                var fileValue=data['upload_file'];
                if(fileValue!=""&&fileValue!=null)
                    downloadLink=`
                        <a href="<?php echo $URL;?>/imagesAPI/fileFormUpload/${fileValue}" target="blank_">Download berkas</a>
                    `;
                inputHTML = `
                    <div class="row">
                        <p>Upload File ${config.label} ${downloadLink}</p>
                        <div id="dropzoneForm" class="drop-area z-depth-1">
                            <i class="material-icons large grey-text text-lighten-1">cloud_upload</i>
                            <p class="grey-text">Drag & Drop file di sini atau klik untuk memilih</p>
                            <input type="file" id="pdfFile" accept=".pdf" hidden>
                        </div>

                        <div class="file-name center-align grey-text text-darken-1" id="fileNameDisplayForm">
                            Tidak ada file yang dipilih
                        </div>

                        <small class="grey-text center-align d-block" style="display:block; text-align:center; margin-top:10px;">
                            * Format file: <code>.pdf</code> | Max size: 1MB
                        </small>
                    </div>
                `;
            }else {
                inputHTML = `
                    <div class="input-field  col s12">
                        <input type="${config.type}" id="${field}" name="${field}" value="${value}">
                        <label for="${field}" class="active">${config.label}</label>
                    </div>
                `;
            }

            container.innerHTML += inputHTML;
        });

        // Inisialisasi Materialize Datepicker (hanya setelah semua input dirender)
        const elems = container.querySelectorAll('.datepicker');
        M.Datepicker.init(elems, {
            format: 'yyyy-mm-dd',
            autoClose: true,
            defaultDate: new Date(),
            setDefaultDate: false,
            showClearBtn: true,
            i18n: {
                cancel: 'Batal',
                clear: 'Bersihkan',
                done: 'OK'
            }
        });


         // input file
        const dropAreaForm = document.getElementById("dropzoneForm");
        const fileInputForm = document.getElementById("pdfFile");
        const fileNameDisplayForm = document.getElementById("fileNameDisplayForm");

        // Click to open file dialog
        dropAreaForm.addEventListener("click", () => fileInputForm.click());

        // File selected via dialog
        fileInputForm.addEventListener("change", handleFileForm);

        // Drag & drop
        dropAreaForm.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropAreaForm.classList.add("hover");
        });

        dropAreaForm.addEventListener("dragleave", () => {
            dropAreaForm.classList.remove("hover");
        });

        dropAreaForm.addEventListener("drop", (e) => {
            e.preventDefault();
            dropAreaForm.classList.remove("hover");
            fileInputForm.files = e.dataTransfer.files;
            handleFileForm();
        });

        function handleFileForm() {
            if (fileInputForm.files.length > 0) {
                fileNameDisplayForm.textContent = fileInputForm.files[0].name;
            } else {
                fileNameDisplayForm.textContent = "Tidak ada file yang dipilih";
            }
        }

        var dateElems = document.querySelectorAll('input[type="date"]');
        M.Datepicker.init(dateElems, {
            format: 'yyyy-mm-dd',
            yearRange: 100
        });
        
    }

    // =============================================

    function submitForm() {
        const config = formTypes[formType];
        if (!config) return;

        const formData = new FormData();

        // Loop field lain (selain file)
        config.fields.forEach(field => {
            const fieldType = formMap[field]?.type;
            if (fieldType === 'upload_file') return;

            const el = document.getElementById(field);
            if (el) {
                formData.append(field, el.value);
            }
        });

        // Ambil field upload_file dari config
        const uploadField = config.fields.find(f => formMap[f]?.type === 'upload_file');
        const fileInput = document.getElementById("pdfFile");

        if (uploadField && fileInput && fileInput.files.length > 0) {
            formData.append("upload_file", fileInput.files[0]); // gunakan nama tetap
            formData.append("upload_field_name", uploadField); // optional
        }

        // const fileInput = document.getElementById("pdfFile");
        // if (fileInput && fileInput.files.length > 0) {
        //     formData.append("upload_file", fileInput.files[0]);
        // }

        const token = localStorage.getItem("token");
        if(selectedId!=0)
            formData.append("id", selectedId);

        formData.append("token", token);
        
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Mohon tunggu.',
            allowOutsideClick: false,
            didOpen: () => {
            Swal.showLoading();
            }
        });

        $.ajax({
            url: `<?php echo $URL; ?>/API/save${saveUploadUrl}`, // <- Sesuaikan endpoint
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.'
                });
                $("#formModal").modal("close");
                showItem();
            },
            error: function (xhr, status, err) {
            console.error("Gagal submit", xhr, status, err);
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat menyimpan data.'
            });
            }
        });
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
                "type":"MAIN"
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                myResponAllData=JSON.parse(response);
                // console.log(myResponAllData)
                
                if(myResponAllData.response_status=="true"){
                    renderCards(myResponAllData.data);   
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
                var myPropertiesData = data;

                if (myPropertiesData.response_status === "true") {
                    let newItem = {
                        text: myPropertiesData.data[0].judul,
                        url: "<?php echo $URL; ?>/admin/itemData/" + idJenisData
                    };
                    jenisDataTitle=myPropertiesData.data[0].judul;
                    formType = myPropertiesData.data[0].judul.replace(/ /g, "");
                    breadCrump.push(newItem);
                    createBreadCrum(breadCrump);
                    var thisEP=parseSummaryString(myPropertiesData.data[0].url);
                    endPointUrl=thisEP.summary;
                    saveUploadUrl=thisEP.crud;
                    showItem();

                    // var linkJson = JSON.parse(myPropertiesData.data[0].json_url);
                    // console.log(linkJson.load);
                    // loadUrl = linkJson.load;
                    // showItem();
                } else {
                    alert(myPropertiesData.message);
                }
            },
            error: function (request, status, error) {
                console.log(request.responseText);
                console.log(status);
                console.log(error);
            }
        });
    }


    function openData(id){
        let selectedData=[];
        if(id!==0){
            var dataList=myResponAllData.data;
            selectedId=parseInt(id);
            selectedData = dataList.find(d => d.id == id);
            
        }
        generateForm(formType, selectedData); // formType harus diset global
        $('#formModal').modal('open');
        $('.datepicker').datepicker();
        $('.timepicker').timepicker();
        $('select').formSelect();
        $('.materialboxed').materialbox();
        M.updateTextFields();
    }

    function deleteData(){
        var token = localStorage.getItem('token');
        Swal.fire({
            title: "Apakah anda yakin mau menhapus data ini secara permanen?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                // alert("masuk");
            
                $.ajax({
                    url: '<?php echo $URL; ?>/API/delete'+saveUploadUrl,
                    method: 'POST',
                    data: {
                        "token":token,
                        "id":selectedId,
                    },
                    
                    success: function (data) {
                        var response= JSON.stringify(data);
                        var myResponse=JSON.parse(response);
                        
                        showAlert(myResponse.message);  
                        $("#formModal").modal("close");
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


    // =============Upload File=======================

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

    function uploadData() {
        const fileInput = document.getElementById('csvFile');
        const file = fileInput.files[0];
        entityKey=formType;
        if (!file) {
            swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Silakan pilih file terlebih dahulu!'
            });
            return;
        }

        validateCSVHeader(file, entityKey, () => {
            // Header valid, lanjut proses upload ke server
            const formData = new FormData();
            formData.append('file_csv', file);
            console.log(`<?php echo $URL; ?>/API/upload${saveUploadUrl}`);
            fetch(`<?php echo $URL; ?>/API/upload${saveUploadUrl}`, {
                method: 'POST',
                body: formData
            })
            .then(async res => {
                const text = await res.text(); // ambil dulu plain text-nya

                try {
                    const data = JSON.parse(text); // coba parse JSON-nya

                    if (!res.ok) {
                        throw new Error(data.message || `HTTP ${res.status}`);
                    }

                    swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        html: data.message || 'Upload berhasil!'
                    });
                    $("#uploadModals").modal("close");
                    showItem();
                } catch (err) {
                    // Kalau JSON.parse gagal atau res bukan OK
                    console.error("Invalid JSON or server error:", text);
                    swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: `Gagal memproses respons dari server.<br><pre>${text}</pre>`
                    });
                }
            })
            .catch(err => {
                console.error("Fetch failed:", err);
                swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `Upload gagal: ${err.message}`
                });
            });
        });
    }

    // Fungsi validasi CSV header dengan SweetAlert
    function validateCSVHeader(file, entityKey, onSuccess) {
        if (!csvMappings[entityKey]) {
            swal.fire({
            icon: 'error',
            title: 'Error',
            text: `Entity "${entityKey}" tidak ditemukan pada mapping.`,
            });
            return;
        }

        const expectedHeaders = csvMappings[entityKey];
        const reader = new FileReader();

        reader.onload = function(e) {
            const text = e.target.result;
            const firstLine = text.split(/\r\n|\n/)[0];
            // Sesuaikan delimiter jika bukan koma
            const actualHeaders = firstLine.split(';').map(h => h.trim());

            const missingHeaders = expectedHeaders.filter(h => !actualHeaders.includes(h));
            const extraHeaders = actualHeaders.filter(h => !expectedHeaders.includes(h));

            if (missingHeaders.length > 0) {
            swal.fire({
                icon: 'error',
                title: 'Kolom Tidak Lengkap',
                html: `Kolom berikut tidak ditemukan:<br><b>${missingHeaders.join(', ')}</b>`
            });
            } else {
            // Bisa juga beri warning kalau ada kolom tambahan
            if (extraHeaders.length > 0) {
                swal.fire({
                icon: 'warning',
                title: 'Kolom Tambahan Ditemukan',
                html: `Kolom ekstra ini akan diabaikan:<br><b>${extraHeaders.join(', ')}</b>`,
                confirmButtonText: 'Lanjutkan'
                }).then(() => onSuccess());
            } else {
                onSuccess();
            }
            }
        };

        reader.onerror = function() {
            swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Gagal membaca file CSV.',
            });
        };

        reader.readAsText(file);
    }
    // =========================================================


    // =============Upload File Form=======================

   

    // function uploadData() {
    //     const fileInputForm = document.getElementById('csvFile');
    //     const file = fileInputForm.files[0];
    //     entityKey=formType;
    //     if (!file) {
    //         swal.fire({
    //         icon: 'warning',
    //         title: 'Peringatan',
    //         text: 'Silakan pilih file terlebih dahulu!'
    //         });
    //         return;
    //     }

    //     validateCSVHeader(file, entityKey, () => {
    //         // Header valid, lanjut proses upload ke server
    //         const formData = new FormData();
    //         formData.append('file_csv', file);
    //         console.log(`<?php echo $URL; ?>/API/upload${saveUploadUrl}`);
    //         fetch(`<?php echo $URL; ?>/API/upload${saveUploadUrl}`, {
    //             method: 'POST',
    //             body: formData
    //         })
    //         .then(async res => {
    //             const text = await res.text(); // ambil dulu plain text-nya

    //             try {
    //                 const data = JSON.parse(text); // coba parse JSON-nya

    //                 if (!res.ok) {
    //                     throw new Error(data.message || `HTTP ${res.status}`);
    //                 }

    //                 swal.fire({
    //                     icon: 'success',
    //                     title: 'Sukses',
    //                     html: data.message || 'Upload berhasil!'
    //                 });
    //                 $("#uploadModals").modal("close");
    //                 showItem();
    //             } catch (err) {
    //                 // Kalau JSON.parse gagal atau res bukan OK
    //                 console.error("Invalid JSON or server error:", text);
    //                 swal.fire({
    //                     icon: 'error',
    //                     title: 'Gagal',
    //                     html: `Gagal memproses respons dari server.<br><pre>${text}</pre>`
    //                 });
    //             }
    //         })
    //         .catch(err => {
    //             console.error("Fetch failed:", err);
    //             swal.fire({
    //                 icon: 'error',
    //                 title: 'Error',
    //                 text: `Upload gagal: ${err.message}`
    //             });
    //         });
    //     });
    // }

    // // Fungsi validasi CSV header dengan SweetAlert
    // function validateCSVHeader(file, entityKey, onSuccess) {
    //     if (!csvMappings[entityKey]) {
    //         swal.fire({
    //         icon: 'error',
    //         title: 'Error',
    //         text: `Entity "${entityKey}" tidak ditemukan pada mapping.`,
    //         });
    //         return;
    //     }

    //     const expectedHeaders = csvMappings[entityKey];
    //     const reader = new FileReader();

    //     reader.onload = function(e) {
    //         const text = e.target.result;
    //         const firstLine = text.split(/\r\n|\n/)[0];
    //         // Sesuaikan delimiter jika bukan koma
    //         const actualHeaders = firstLine.split(';').map(h => h.trim());

    //         const missingHeaders = expectedHeaders.filter(h => !actualHeaders.includes(h));
    //         const extraHeaders = actualHeaders.filter(h => !expectedHeaders.includes(h));

    //         if (missingHeaders.length > 0) {
    //         swal.fire({
    //             icon: 'error',
    //             title: 'Kolom Tidak Lengkap',
    //             html: `Kolom berikut tidak ditemukan:<br><b>${missingHeaders.join(', ')}</b>`
    //         });
    //         } else {
    //         // Bisa juga beri warning kalau ada kolom tambahan
    //         if (extraHeaders.length > 0) {
    //             swal.fire({
    //             icon: 'warning',
    //             title: 'Kolom Tambahan Ditemukan',
    //             html: `Kolom ekstra ini akan diabaikan:<br><b>${extraHeaders.join(', ')}</b>`,
    //             confirmButtonText: 'Lanjutkan'
    //             }).then(() => onSuccess());
    //         } else {
    //             onSuccess();
    //         }
    //         }
    //     };

    //     reader.onerror = function() {
    //         swal.fire({
    //         icon: 'error',
    //         title: 'Error',
    //         text: 'Gagal membaca file CSV.',
    //         });
    //     };

    //     reader.readAsText(file);
    // }
    // =========================================================

    // EksportData
    function exportToExcel() {
        let formTypeKey=formType;
        let dataArray=myResponAllData.data;

        const wb = XLSX.utils.book_new();

        // Ambil fields sesuai tipe
        let fields = formTypes[formTypeKey]?.fields;
        

        if (!fields) {
            console.error("Tipe form tidak ditemukan:", formTypeKey);
            return;
        }


        // Exclude field bertipe 'upload_file'
        fields = fields.filter(f => formMap[f]?.type !== 'upload_file');

        // Header berdasarkan label formMap
        const header = fields.map(f => formMap[f]?.label || f);

        // Data rows, ambil sesuai fields
        const rows = dataArray.map((item, i) => {
            return fields.map(field => item[field] || "");
        });

        // Gabungkan header + data
        const aoa = [header, ...rows];

        // Buat sheet & buku kerja
        const ws = XLSX.utils.aoa_to_sheet(aoa);
        XLSX.utils.book_append_sheet(wb, ws, formTypeKey);

        // Save file
        XLSX.writeFile(wb, `${formTypeKey}_Data.xlsx`);
    }

    function exportToPDF() {
        const formTypeKey = formType;
        const dataArray = myResponAllData.data;
        const fields = formTypes[formTypeKey]?.fields;

        if (!fields) {
            console.error("Tipe form tidak ditemukan:", formTypeKey);
            return;
        }

        // Buat header dan rows
        const headerHtml = fields.map(f => `<th>${formMap[f]?.label || f}</th>`).join("");
        const rowsHtml = dataArray.map(item =>
            `<tr>${fields.map(f => `<td>${item[f] || ""}</td>`).join("")}</tr>`
        ).join("");

        // Tambahkan CSS tambahan
        const style = `
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 10px;
                }
                thead {
                    display: table-header-group;
                }
                tr, td, th {
                    border: 1px solid #000;
                    padding: 4px;
                    page-break-inside: avoid;
                }
                h3 {
                    text-align: center;
                    margin: 10px 0;
                }
            </style>
        `;

        // Buat kontainer HTML
        const container = document.createElement("div");
        container.style.visibility = "hidden";
        container.style.position = "fixed";
        container.style.top = "0";
        container.style.left = "0";
        container.style.width = "100%";
        container.style.zIndex = "-1";
        container.style.background = "#fff";

        container.innerHTML = `
            ${style}
            <h3>Data ${formTypeKey}</h3>
            <table>
                <thead><tr>${headerHtml}</tr></thead>
                <tbody>${rowsHtml}</tbody>
            </table>
        `;

        document.body.appendChild(container);

        // Jeda singkat agar render sempurna
        setTimeout(() => {
            html2pdf()
                .set({
                    filename: `${formTypeKey}_Data.pdf`,
                    margin: 0.3,
                    jsPDF: { format: 'a4', orientation: 'landscape', unit: 'in' },
                    html2canvas: { scale: 2, useCORS: true },
                    pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
                })
                .from(container)
                .save()
                .then(() => document.body.removeChild(container))
                .catch(err => {
                    console.error("Gagal export PDF:", err);
                    document.body.removeChild(container);
                });
        }, 200);
    }


    function downloadTemplate() {
      const fileUrl = `<?php echo $URL;?>/template/${formType}.csv`; // Ganti dengan path kamu

      const link = document.createElement('a');
      link.href = fileUrl;
      link.download = `${formType}.csv`; // Nama file saat diunduh
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
</script>