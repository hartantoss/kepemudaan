<!-- Litepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

<style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9f9f9;
      color: #333;
      padding: 2rem;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 6px;
      text-align: center;
    }
    th {
      background-color: #f2f2f2;
    }
    .pagination {
      margin-top: 10px;
      text-align: center;
    }
    .pagination button {
      margin: 2px;
      padding: 4px 10px;
    }
    .controls {
      margin: 10px 0;
      text-align: right;
    }
    .summary {
      background-color: #f5f5f5;
      font-weight: 600;
      text-align: left;
      padding: 10px;
      border: 1px solid #ddd;
      width: 100%;
    }
</style>
<div class="col s12" style="margin-bottom:20px;">
    <div class="col s12" id="breadCrumpView"></div>
</div>
<div class="row" style="margin:0px 0px 0px 0px;">
    <!-- Container -->
    <div class="row valign-wrapper" style="margin-bottom: 0;">
        <!-- Jumlah data per halaman -->
        <div class="input-field col s12 m6">
            <label for="rowsPerPage" class="active" style="margin-bottom: 5px;">Tampilkan data per halaman</label>
            <select id="rowsPerPage" class="">
            <option value="5">5 data</option>
            <option value="10" selected>10 data</option>
            <option value="20">20 data</option>
            </select>
        </div>

        <!-- Rentang Tanggal -->
        <div class="input-field col s12 m6">
            <input type="text" id="tanggal_range" class="validate" readonly>
            <label for="tanggal_range">Rentang Tanggal</label>
        </div>

        <!-- Tombol Cari -->
        <!-- <div class="" style="">
            <button class="btn-floating waves-effect waves-light blue darken-2 white-text" id="btn_cari" style="width: 100%;">
            <i class="material-icons left">search</i>
            </button>
        </div> -->
    </div>


    <div class="col s12" style="margin-top: 20px;">
        <!-- <button onclick="exportAllToPDF()" class="btn waves-effect waves-light red darken-2 white-text" style="margin: 5px; border:none;">
            <i class="material-icons left">picture_as_pdf</i> Export PDF
        </button> -->
        
        <button onclick="exportAllToExcel()" class="btn waves-effect waves-light green darken-2 white-text" style="margin: 5px; border:none;">
            <i class="material-icons left">grid_on</i> Export Excel
        </button>
    </div>
    <!-- Table -->
    <div class="responsive-table" >
        
        <div class="col s12" style="overflow-x:auto;">
            <table id="dataTable" style="width:100%">
                <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Tanggal Survey</th>
                    <th rowspan="2">Nama</th>
                    <th rowspan="2">Usia</th>
                    <th rowspan="2">Jenis Kelamin</th>
                    <th rowspan="2">No. Telpon</th>
                    <th colspan="11">Unsur Pelayanan</th>
                    <!-- <th rowspan="2">Kekurangan Pelayanan</th>
                    <th rowspan="2">Kelebihan Pelayanan</th> -->
                    <th rowspan="2">Saran/Masukan Pelayanan</th>
                    
                </tr>
                <tr>
                    <th>U1</th><th>U2</th><th>U3</th><th>U4</th><th>U5</th><th>U6</th><th>U7</th><th>U8</th><th>U9</th><th>U10</th><th>U11</th>
                </tr>
                </thead>
                <tbody id="tableBody">
                <!-- Baris data akan diisi oleh JavaScript -->
                </tbody>
            </table>
        </div>
        

        <div class="pagination" id="paginationControls"></div>
    </div>

    <div style="overflow-x: auto;">
        <table id="summaryTable" border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: center;">
            <thead style="background-color: #f2f2f2;">
                <tr>
                    <th></th>
                    <th>U1</th>
                    <th>U2</th>
                    <th>U3</th>
                    <th>U4</th>
                    <th>U5</th>
                    <th>U6</th>
                    <th>U7</th>
                    <th>U8</th>
                    <th>U9</th>
                </tr>
            </thead>
            <tbody>
                <tr id="totalUnsur">
                    <td>Nilai/Unsur</td>
                    <td>300</td><td>210</td><td>193</td><td>227</td><td>210</td><td>224</td><td>224</td><td>196</td><td>196</td><td>196</td><td>196</td>
                </tr>
                <tr id="nrrUnsur">
                    <td>NRR/Unsur</td>
                    <td>30,05</td><td>26,30</td><td>24,18</td><td>28,42</td><td>26,30</td><td>28,06</td><td>28,06</td><td>24,54</td><td>24,54</td><td>24,54</td><td>24,54</td>
                </tr>
                <tr id="nrrUnsur25">
                    <td>NRR/Unsur × 25</td>
                    <td>751,19</td><td>657,45</td><td>604,44</td><td>710,46</td><td>657,45</td><td>701,49</td><td>701,49</td><td>613,41</td><td>613,41</td><td>613,41</td><td>613,41</td>
                </tr>
                <tr id="mutuUnsur">
                    <td>Mutu Layanan/Unsur</td>
                    <td>A</td><td>A</td><td>A</td><td>A</td><td>A</td><td>A</td><td>A</td><td>A</td><td>A</td><td>A</td><td>A</td>
                </tr>
                <tr id="predikatUnsur">
                    <td>Predikat Layanan/Unsur</td>
                    <td>Sangat Baik</td><td>Sangat Baik</td><td>Sangat Baik</td><td>Sangat Baik</td><td>Sangat Baik</td><td>Sangat Baik</td><td>Sangat Baik</td><td>Sangat Baik</td><td>Sangat Baik</td><td>Sangat Baik</td><td>Sangat Baik</td>
                </tr>
                <tr id="nrrTertimbang">
                    <td>NRR Tertimbang/Unsur</td>
                    <td>3,31</td><td>2,89</td><td>2,66</td><td>3,13</td><td>2,89</td><td>3,09</td><td>3,09</td><td>2,70</td><td>2,70</td><td>2,70</td><td>2,70</td>
                </tr>
                <tr id="jmlNrrTertimbang">
                    <td>Jumlah NRR Tertimbang</td>
                    <td colspan="1">26,45</td>
                </tr>
                <tr id="nilaiIKM">
                    <td>Nilai IKM</td>
                    <td colspan="1">661,19</td>
                </tr>
                <tr id="mutuLayanan">
                    <td>Mutu Layanan</td>
                    <td colspan="1">A</td>
                </tr>
                <tr id="preidikatLayanan">
                    <td>Predikat Layanan</td>
                    <td colspan="1">Sangat Baik</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
<!-- Litepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>


<!-- <a id="addButton" onclick="openData(-1)" style="position:fixed; bottom:20px; right:20px;" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a> -->
<script>

    var breadCrump=[
        {
            "text":"Dasboard",
            "url":"<?php echo $URL; ?>/admin/homepage"
        },
        {
            "text":"Survei",
            "url":"<?php echo $URL; ?>/admin/survei"
        }
    ];
    var myResponAllData=[];
    var idTim=-1;
    let dataSurvei = [];
    let currentPage = 1;
    let rowsPerPage = 10;
    const tableBody = document.getElementById("tableBody");
    const paginationControls = document.getElementById("paginationControls");
    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    let picker;
    let summarySheet = [];

    $(document).ready( function () {    
        createBreadCrum(breadCrump);

        
        // for (let i = 1; i <= 20; i++) {
        //     dataSurvei.push({
        //         nama: `Responden ${i}`,
        //         usia: 20 + (i % 10),
        //         jk: i % 2 === 0 ? "Perempuan" : "Laki-Laki",
        //         telp: "0812345678" + String(i).padStart(2, "0"),
        //         unsur: Array(9).fill().map(() => Math.floor(Math.random() * 2) + 3),
        //         kurang: "Contoh kekurangan",
        //         lebih: "Contoh kelebihan",
        //         saran: "Contoh saran"
        //     });
        // }

        
        picker = new Litepicker({
            element: document.getElementById('tanggal_range'),
            singleMode: false, // Ini penting: agar bisa pilih rentang tanggal
            format: 'DD-MM-YYYY',
            lang: 'id'
        });

        var elems = document.querySelectorAll('select');
        M.FormSelect.init(elems);
        
        showItem();
        
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

        Swal.fire({
            title: 'Memuat Data...',
            text: 'Harap tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        picker = new Litepicker({
            element: document.getElementById('tanggal_range'),
            singleMode: false, // Ini penting: agar bisa pilih rentang tanggal
            format: 'DD-MM-YYYY',
            lang: 'id',
            setup: (picker) => {
                picker.on('selected', () => {
                    showItem();
                });
            }
        });

        let startDate = picker.getStartDate();
        let endDate = picker.getEndDate();

        if (startDate && endDate) {
            startDate = startDate.format('YYYY-MM-DD');
            endDate = endDate.format('YYYY-MM-DD');
        }
        
        console.log("Tanggal Mulai:", startDate);
        console.log("Tanggal Akhir:", endDate);
            

        $.ajax({
            url: '<?php echo $URL; ?>/API/showSurvei',
            method: 'POST',
            data: {
                "token":token,
                "start_date":startDate,
                "end_date":endDate,
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                myResponAllData=JSON.parse(response);
                // console.log(data);
                
                if(myResponAllData.response_status=="true"){
                    console.log(myResponAllData);
                    let respDataSurvei=myResponAllData.data;
                    dataSurvei = respDataSurvei.map(item => ({
                        nama: item.nama,
                        usia: item.usia,
                        jk: item.jenis_kelamin,
                        telp: item.telp,
                        unsur: [item.u1, item.u2, item.u3, item.u4, item.u5, item.u6, item.u7, item.u8, item.u9],
                        u10: item.u10,
                        u11: item.u11,
                        // kurang: item.kekurangan,
                        // lebih: item.kelebihan,
                        saran: item.saran,
                        created_date: item.created_date
                    }));
                    
                    // Inisialisasi array penampung total nilai unsur
                    let totalUnsur = Array(9).fill(0);
                    // Jumlah responden
                    const jumlahResponden = dataSurvei.length;
                    // Proses penjumlahan nilai setiap unsur
                    dataSurvei.forEach(item => {
                        item.unsur.forEach((nilai, index) => {
                            totalUnsur[index] += parseInt(nilai); // pastikan angka
                        });
                    });

                    // Hitung Summary
                    let nrrUnsur = totalUnsur.map(total => (total / jumlahResponden));
                    let nrrUnsur25 = nrrUnsur.map(nrr => (nrr * 25));
                    let mutuUnsur = nrrUnsur25.map(nrr25 => (nrr25 < 64.99 ? 'D' : (nrr25 < 76.6 ? 'C' : (nrr25 < 83.3 ? 'B' : 'A'))));
                    let predikatUnsur = nrrUnsur25.map(nrr25 => (nrr25 < 64.99 ? 'Tidak Baik' : (nrr25 < 76.6 ? 'Kurang Baik' : (nrr25 < 83.3 ? 'Baik' : 'Sangat Baik'))));
                    let nrrTertimbang = nrrUnsur.map(nrr => (nrr * 0.11));
                    let jmlNrrTertimbang = 0;
                    nrrTertimbang.map(nrr => (jmlNrrTertimbang+=nrr));
                    let nilaiIKM = jmlNrrTertimbang*25;
                    let mutuLayanan = (nilaiIKM < 64.99 ? 'D' : (nilaiIKM < 76.6 ? 'C' : (nilaiIKM < 83.3 ? 'B' : 'A')));
                    let preidikatLayanan = (nilaiIKM < 64.99 ? 'Tidak Baik' : (nilaiIKM < 76.6 ? 'Kurang Baik' : (nilaiIKM < 83.3 ? 'Baik' : 'Sangat Baik')));
                    
                    // compose Html
                    var trText="<td>Nilai/Unsur</td>";
                    totalUnsur.map(item => (trText+=`<td>${item}</td>`));
                    $("#totalUnsur").html(trText);
                    
                    var trText="<td>NRR/Unsur</td>";
                    nrrUnsur.map(item => (trText+=`<td>${item.toFixed(2)}</td>`));
                    $("#nrrUnsur").html(trText);

                    var trText="<td>NRR/Unsur × 25</td>";
                    nrrUnsur25.map(item => (trText+=`<td>${item.toFixed(2)}</td>`));
                    $("#nrrUnsur25").html(trText);

                    var trText="<td>Mutu Layanan/Unsur</td>";
                    mutuUnsur.map(item => (trText+=`<td>${item}</td>`));
                    $("#mutuUnsur").html(trText);

                    var trText="<td>Predikat Layanan/Unsur</td>";
                    predikatUnsur.map(item => (trText+=`<td>${item}</td>`));
                    $("#predikatUnsur").html(trText);

                    var trText="<td>NRR Tertimbang/Unsur</td>";
                    nrrTertimbang.map(item => (trText+=`<td>${item.toFixed(2)}</td>`));
                    $("#nrrTertimbang").html(trText);

                    var trText="<td>Jumlah NRR Tertimbang</td>";
                    trText+=`<td colspan="1">${jmlNrrTertimbang.toFixed(2)}</td>`;
                    $("#jmlNrrTertimbang").html(trText);

                    var trText="<td>Nilai IKM</td>";
                    trText+=`<td colspan="1">${nilaiIKM.toFixed(2)}</td>`;
                    $("#nilaiIKM").html(trText);

                    var trText="<td>Mutu Layanan</td>";
                    trText+=`<td colspan="1">${mutuLayanan}</td>`;
                    $("#mutuLayanan").html(trText);

                    var trText="<td>Predikat Layanan</td>";
                    trText+=`<td colspan="1">${preidikatLayanan}</td>`;
                    $("#preidikatLayanan").html(trText);

                    // compose summary sheet
                    summarySheet = [
                        ["NO", "UNSUR", "NILAI RATA-RATA", "NILAI INDEKS", "KINERJA UNIT PELAYANAN"],
                        ["U1", "Persyaratan", nrrUnsur[0].toFixed(2), nrrUnsur25[0].toFixed(2), predikatUnsur[0]],
                        ["U2", "Sistem, Mekanisme dan Prosedur", nrrUnsur[1].toFixed(2), nrrUnsur25[1].toFixed(2), predikatUnsur[1]],
                        ["U3", "Waktu", nrrUnsur[2].toFixed(2), nrrUnsur25[2].toFixed(2), predikatUnsur[2]],
                        ["U4", "Tarif/Biaya", nrrUnsur[3].toFixed(2), nrrUnsur25[3].toFixed(2), predikatUnsur[3]],
                        ["U5", "Produk Spesifikasi Jenis Pelayanan", nrrUnsur[4].toFixed(2), nrrUnsur25[4].toFixed(2), predikatUnsur[4]],
                        ["U6", "Kompetensi Pelaksana", nrrUnsur[5].toFixed(2), nrrUnsur25[5].toFixed(2), predikatUnsur[5]],
                        ["U7", "Perilaku Pelaksana", nrrUnsur[6].toFixed(2), nrrUnsur25[6].toFixed(2), predikatUnsur[6]],
                        ["U8", "Penanganan Pengaduan Saran dan Masukan", nrrUnsur[7].toFixed(2), nrrUnsur25[7].toFixed(2), predikatUnsur[7]],
                        ["U9", "Sarana dan Prasarana", nrrUnsur[8].toFixed(2), nrrUnsur25[8].toFixed(2), predikatUnsur[8]],
                        // ["U10", "Transparansi Layanan", nrrUnsur[9].toFixed(2), nrrUnsur25[9].toFixed(2), predikatUnsur[9]],
                        // ["U11", "Integritas Petugas", nrrUnsur[10].toFixed(2), nrrUnsur25[10].toFixed(2), predikatUnsur[10]],
                        ["Indeks Kepuasan Masyarakat", "", jmlNrrTertimbang.toFixed(2), nilaiIKM.toFixed(2), preidikatLayanan],
                    ];
                   
                    console.log(dataSurvei);
                    displayTable(currentPage);
                    setupPagination();
                    Swal.close();
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal mengambil data dari server. '+myResponAllData.message,
                        footer: error
                    });
                    // alert(myResponAllData.message);
                }
            },
            error: function (request, status, error) {
                console.log(request.responseText);
                console.log(status);
                console.log(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal mengambil data dari server. '+request.responseText,
                    footer: error
                });
            }
        });
    }

   
    function displayTable(page) {
      tableBody.innerHTML = "";
      const start = (page - 1) * rowsPerPage;
      const end = start + rowsPerPage;
      const paginatedItems = dataSurvei.slice(start, end);

      paginatedItems.forEach((d, i) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td>${start + i + 1}</td>
          <td>${d.created_date}</td>
          <td>${d.nama}</td>
          <td>${d.usia}</td>
          <td>${d.jk}</td>
          <td>${d.telp}</td>
          ${d.unsur.map(u => `<td>${u}</td>`).join('')}
          <td>${d.u10}</td>
          <td>${d.u11}</td>
          <td>${d.saran}</td>
        `;
        tableBody.appendChild(tr);
      });
    }

    function setupPagination() {
      paginationControls.innerHTML = "";
      const pageCount = Math.ceil(dataSurvei.length / rowsPerPage);

      for (let i = 1; i <= pageCount; i++) {
        const btn = document.createElement("button");
        btn.innerText = i;
        if (i === currentPage) btn.disabled = true;
        btn.addEventListener("click", () => {
          currentPage = i;
          displayTable(currentPage);
          setupPagination();
        });
        paginationControls.appendChild(btn);
      }
    }

    rowsPerPageSelect.addEventListener("change", () => {
      rowsPerPage = parseInt(rowsPerPageSelect.value);
      currentPage = 1;
      displayTable(currentPage);
      setupPagination();
    });

    

    document.addEventListener("DOMContentLoaded", function () {
        const inputRange = document.getElementById("tanggal_range");

        const today = new Date();
        const pastDate = new Date();
        pastDate.setDate(today.getDate() - 30);

        function formatDate(date) {
        const d = new Date(date);
        const day = ("0" + d.getDate()).slice(-2);
        const month = ("0" + (d.getMonth() + 1)).slice(-2);
        const year = d.getFullYear();
        return `${day}/${month}/${year}`;
        }

        const rangeText = `${formatDate(pastDate)} - ${formatDate(today)}`;
        inputRange.value = rangeText;
        M.updateTextFields();
    });

    // document.getElementById("btn_cari").addEventListener("click", function () {
    //     showItem();
    // });


    // Export dataSurvei
    /*function exportAllToExcel() {
        const wb = XLSX.utils.book_new();
        const dataSheet = [];

        // Header
        dataSheet.push([
            "No", "Nama", "Usia", "Jenis Kelamin", "No. Telpon",
            "U1", "U2", "U3", "U4", "U5", "U6", "U7", "U8", "U9",
            "Kekurangan", "Kelebihan", "Saran"
        ]);

        // Data baris
        dataSurvei.forEach((item, i) => {
            dataSheet.push([
                i + 1, item.nama, item.usia, item.jk, item.telp,
                ...item.unsur,
                item.kurang, item.lebih, item.saran
            ]);
        });

        // Buat sheet pertama (data survei)
        const dataWS = XLSX.utils.aoa_to_sheet(dataSheet);
        XLSX.utils.book_append_sheet(wb, dataWS, "Data IKM");

        // Ambil isi dari #summaryTable (harus berupa elemen <table>)
        const summaryTableEl = document.getElementById("summaryTable");
        if (summaryTableEl) {
            const summaryWS = XLSX.utils.table_to_sheet(summaryTableEl, { raw: true });
            XLSX.utils.book_append_sheet(wb, summaryWS, "Ringkasan IKM");
        } else {
            console.warn("Elemen #summaryTable tidak ditemukan.");
        }

        // Simpan file Excel
        XLSX.writeFile(wb, "IKM_Data.xlsx");
    }*/


    function exportAllToExcel() {
        const wb = XLSX.utils.book_new();
        const combinedData = [];

        // Header data survei
        combinedData.push([
            "No","Tanggal Survey", "Nama", "Usia", "Jenis Kelamin", "No. Telpon",
            "U1", "U2", "U3", "U4", "U5", "U6", "U7", "U8", "U9","U10", "U11",
            "Saran"
        ]);

        // Data survei
        dataSurvei.forEach((item, i) => {
            const unsurInt = item.unsur.slice(0, 9).map(u => ({
                v: parseInt(u),
                t: 'n' // Tipe number
            }));
            const unsurRest = item.unsur.slice(9);

            combinedData.push([
                { v: i + 1, t: 'n' },                         // No
                { v: item.created_date, t: 's' },             // Tanggal Survey
                { v: item.nama, t: 's' },                     // Nama
                { v: parseInt(item.usia), t: 'n' },           // Usia
                { v: item.jk, t: 's' },                       // Jenis Kelamin
                { v: item.telp, t: 's' },                     // No Telpon sebagai text supaya tidak hilang angka 0
                ...unsurInt,                                  // U1–U9 sebagai angka
                ...unsurRest.map(u => ({ v: u, t: 's' })),    // U10, U11 sebagai teks
                { v: item.saran, t: 's' }                     // Saran
            ]);
        });

        // Tambahkan baris kosong sebagai pemisah
        combinedData.push([]);
        combinedData.push(["Ringkasan IKM"]);

        // Ambil isi tabel summary dari DOM
        const summaryTable = document.getElementById("summaryTable");
        if (summaryTable) {
            const tempSheet = XLSX.utils.table_to_sheet(summaryTable, { raw: true });

            // Ubah sheet ke dalam array-of-array (AOA)
            const range = XLSX.utils.decode_range(tempSheet["!ref"]);
            for (let rowNum = range.s.r; rowNum <= range.e.r; rowNum++) {
                const row = [];
                for (let colNum = range.s.c; colNum <= range.e.c; colNum++) {
                    const cellAddress = XLSX.utils.encode_cell({ r: rowNum, c: colNum });
                    const cell = tempSheet[cellAddress];
                    row.push(cell ? cell.v : "");
                }
                combinedData.push(row);
            }
        } else {
            combinedData.push(["Tabel Ringkasan tidak ditemukan."]);
        }

        // Ubah ke sheet
        const ws = XLSX.utils.aoa_to_sheet(combinedData);
        XLSX.utils.book_append_sheet(wb, ws, "Data Survei");



        // === Sheet 2: Ringkasan IKM ===
        // const summarySheet = [
        //     ["NO", "UNSUR", "NILAI RATA-RATA", "NILAI INDEKS", "KINERJA UNIT PELAYANAN", "", "", "INDEKS KEPUASAN MASYARAKAT (IKM)"],
        //     ["U1", "Persyaratan", 3.50, 87.50, "Baik", "", "", "DINAS PARIWISATA, PEMUDA, DAN OLAHRAGA"],
        //     ["U2", "Sistem, Mekanisme dan Prosedur", 3.50, 87.50, "Baik", "", "", "KOTA SERANG"],
        //     ["U3", "Waktu", 3.23, 80.83, "Baik"],
        //     ["U4", "Tarif/Biaya", 3.77, 94.17, "Sangat Baik"],
        //     ["U5", "Produk Spesifikasi Jenis Pelayanan", 3.50, 87.50, "Baik", "", "", "NILAI IKM", "RESPONDEN"],
        //     ["U6", "Kompetensi Pelaksana", 3.73, 93.33, "Sangat Baik", "", "", "JUMLAH", ":", 30, "ORANG"],
        //     ["U7", "Perilaku Pelaksana", 3.73, 93.33, "Sangat Baik", "", "", 86.63, "JENIS KELAMIN"],
        //     ["U8", "Penanganan Pengaduan Saran dan Masukan", 3.27, 81.67, "Baik", "", "", "1. LAKI-LAKI", ":", 20, "ORANG"],
        //     ["U9", "Sarana dan Prasarana", 3.27, 81.67, "Baik", "", "", "2. PEREMPUAN", ":", 10, "ORANG"],
        //     ["Indeks Kepuasan Masyarakat", "", 3.47, 86.63, "Baik", "", "", "Baik"],
        //     ["", "", "", "", "", "", "", "Periode Survei", ":", "01 Januari 2025", "31 Maret 2025"]
        // ];

        const ws2 = XLSX.utils.aoa_to_sheet(summarySheet);
        XLSX.utils.book_append_sheet(wb, ws2, "Hasil");


        
        // Simpan
        XLSX.writeFile(wb, "IKM_Data.xlsx");
    }

    function exportAllToPDF() {
        // Cek kalau html2pdf belum tersedia
        if (typeof html2pdf === "undefined") {
            alert("Library html2pdf belum dimuat!");
            return;
        }

        const container = document.createElement("div");
        container.style.visibility = "hidden";
        container.style.position = "fixed";
        container.style.top = "0";
        container.style.left = "0";
        container.style.width = "100%";
        container.style.zIndex = "-1";
        container.style.background = "#fff";

        const summaryHTML = document.getElementById('summaryTable')?.outerHTML || "<p>Summary tidak ditemukan</p>";

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
                h3, h4 {
                    text-align: center;
                    margin: 10px 0;
                }
            </style>
        `;

        let html = `
            ${style}
            <h3>Data IKM</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th><th>Tanggal Survey</th><th>Nama</th><th>Usia</th><th>Jenis Kelamin</th><th>No. Telpon</th>
                        <th>U1</th><th>U2</th><th>U3</th><th>U4</th><th>U5</th><th>U6</th><th>U7</th><th>U8</th><th>U9</th><th>U10</th><th>U11</th>
                        <th>Kekurangan</th><th>Kelebihan</th><th>Saran</th>
                    </tr>
                </thead>
                <tbody>
        `;

        dataSurvei.forEach((item, i) => {
            html += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${item.created_date}</td>
                    <td>${item.nama}</td>
                    <td>${item.usia}</td>
                    <td>${item.jk}</td>
                    <td>${item.telp}</td>
                    ${item.unsur.map(u => `<td>${u}</td>`).join('')}
                    <td>${item.u10}</td>
                    <td>${item.u11}</td>
                    <td>${item.kurang}</td>
                    <td>${item.lebih}</td>
                    <td>${item.saran}</td>
                </tr>
            `;
        });

        html += `
                </tbody>
            </table>
            <br><br>
            <h4>Ringkasan IKM</h4>
            ${summaryHTML}
        `;

        container.innerHTML = html;
        document.body.appendChild(container); // diperlukan agar render benar

        // Tunggu sedikit agar konten benar-benar dimount di DOM
        setTimeout(() => {
            html2pdf()
                .set({
                    filename: 'IKM_Data.pdf',
                    margin: 0.3,
                    jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' },
                    html2canvas: { scale: 2, useCORS: true },
                    pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
                })
                .from(container)
                .save()
                .then(() => {
                    document.body.removeChild(container); // Hapus setelah selesai
                })
                .catch(err => {
                    console.error("Gagal membuat PDF:", err);
                    document.body.removeChild(container);
                });
        }, 200); // jeda 200ms agar DOM siap
    }



</script>