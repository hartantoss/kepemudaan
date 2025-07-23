<style>
    .dashboard-card {
        padding: 10px !important;
    }

    .card-title {
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .chart-legend span {
        font-weight: 500;
        margin: 0 5px;
        font-size: 0.9rem;
    }

    .progress-circle text {
        font-weight: bold;
        fill: #333;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .card-content {
        padding: 20px;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }

    .circle-wrapper {
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }

    .input-field.inline input {
        margin-bottom: 0;
    }

    .table-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .striped th, .striped td {
        font-size: 0.9rem;
    }

    @media (max-width: 600px) {
        .card-title {
        font-size: 1rem;
        }
    }
</style>
<div class="row" style="padding-top:30px">
    <div class="col s12 m10 push-m1">
        <!-- Deskripsi -->
        <div class="col s12" id="deskripsiView" style="text-align:justify"></div>

        <!-- Grafik Capaian & IPP -->
        <div class="col s12 m12">
            <div class="row">
                <div class="col s12 m6 dashboard-card">
                    <div class="card">
                    <div class="card-content" style="height: 320px;">
                        <span class="card-title">CAPAIAN DOMAIN <span class="tahunPrevView">2024</span> - <span class="tahunNowView">2025</span></span>
                        <div style="position: relative; height: 220px;">
                            <canvas id="chartCapaian"></canvas>
                        </div>
                        <div class="center-align chart-legend">
                            <span style="color:#3f3d56;" class="tahunPrevView">● 2024</span>
                            <span style="color:#6c40ff;" class="tahunNowView">● 2025</span>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col s12 m6 dashboard-card">
                    <div class="card">
                    <div class="card-content" style="height: 320px;">
                        <span class="card-title" id="chartIPPTitle">CAPAIAN IPP TAHUN</span>
                        <div style="position: relative; height: 220px;">
                            <canvas id="chartIPP"></canvas>
                        </div>
                        <div class="center-align chart-legend">
                            <span style="color:#6c40ff;">◯ IPP</span>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Circle & Tabel -->
        <div class="col s12 m12">
            <div class="row">
                <div class="col s12 m6 l4 dashboard-card">
                    <div class="card center-align">
                        <div class="card-content">
                            <span class="card-title">IPP<br><small>Tahun <span class="tahunNowView">2025</span></small></span>
                            <div class="circle-wrapper">
                                <svg width="120" height="120">
                                    <circle cx="60" cy="60" r="50" stroke="#eee" stroke-width="10" fill="none" />
                                    <circle id="progressCircle" cx="60" cy="60" r="50" stroke="#7e57c2" stroke-width="10"
                                            fill="none" stroke-linecap="round"
                                            transform="rotate(-90 60 60)"
                                            stroke-dasharray="314" stroke-dashoffset="314" />
                                    <text id="circleValue" x="60" y="68" font-size="22" text-anchor="middle">0</text>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="card center-align">
                        <div class="card-content"  >
                            <div class="row"><span class="card-title left">Dokumen</span><i class="material-icons right" onclick="openUploadModal(-1,-1)">add</i></div>
                            <div class="row">
                                <ul class="collapsible" id="listDokumenIPP">
                                    Belum ada dokumen
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col s12 m6 l8 dashboard-card">
                    <div class="card">
                        <div class="card-content">
                            <div class="table-title">
                                <span class="card-title">DATA INDIKATOR IPP</span>
                                <div class="input-field inline">
                                    <input type="number" onChange="showIPP()" id="tahunInputForm" min="2000" max="2100" value="2025">
                                    <label for="tahunInputForm">Tahun</label>
                                </div>
                            </div>
                            <div class="table-wrapper">
                                <table class="striped">
                                    <thead>
                                    <tr>
                                        <th>Domain</th>
                                        <th>Indikator</th>
                                        <th>Data</th>
                                        <th>Tahun</th>
                                    </tr>
                                    </thead>
                                    <tbody id="listIPPTahunan"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready( function () {    
        showDeskripsi();
        // updateIPPChart(96.33);
        // showGraph();
        showIPP();
        loadDocumentIPP();
        
    } );
    function updateIPPChart(nilai) {
        const circle = document.getElementById("progressCircle");
        const text = document.getElementById("circleValue");

        const max = 100; // max nilai
        const radius = 50;
        const circumference = 2 * Math.PI * radius;
        const percent = Math.min(Math.max(nilai, 0), 100); // clamp 0–100
        const offset = circumference - (percent / 100) * circumference;

        circle.style.strokeDashoffset = offset;
        text.textContent = nilai.toFixed(2);
    }

    // Deskripsi
    function showDeskripsi(){
        

        $.ajax({
            url: '<?php echo $URL; ?>/API/showKonten',
            method: 'POST',
            data: {
                "token":"",
                "tipeKonten":'IPP DESKRIPSI',
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                var myResponDeskripsiData=JSON.parse(response);
                // console.log(data);
                
                if(myResponDeskripsiData.response_status=="true"){
                    $("#deskripsiView").html(formatIndentedParagraphs(myResponDeskripsiData.data[0].deskripsi_id));
                }
                else{
                    alert(myResponAllData.message);
                }
                // console.log(JSON.stringify(myResponse.token));
                // alert(data);
            }
        });
    }

    function formatIndentedParagraphs(text) {
        return text
            .split(/\r?\n/)
            .filter(line => line.trim() !== '') // hilangkan baris kosong
            .map(line => {
                const isIndented = /^\s+/.test(line); // cek jika diawali spasi/tab
                const indentStyle = isIndented ? ' style="text-indent: 2em;"' : '';
                return `<p${indentStyle}>${line.trim()}</p>`;
            })
            .join('');
    }

    function showIPP() {
        var tahun = $("#tahunInputForm").val();
        $(".tahunNowView").html(tahun);
        $(".tahunPrevView").html(tahun-1);
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
                            <tr>
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
                loadGraphData();
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

    // -------- Graph
    function showGraph(data) {
        const ctx = document.getElementById('chartCapaian').getContext('2d');

        // Hapus chart sebelumnya jika ada
        if (window.myChartCapaian) {
            window.myChartCapaian.destroy();
        }

        const tahunList = Object.keys(data).sort(); // contoh: ['2024', '2025']
        const domainLabels = Object.keys(data[tahunList[0]].indeks_per_domain); // contoh: ['Inklusivitas...', 'Kesehatan', ...]

        const colorPalette = ["#3f3d56", "#6c40ff", "#f39c12", "#27ae60", "#e74c3c"];

        const datasets = tahunList.map((tahun, index) => {
            return {
                label: tahun,
                data: domainLabels.map(domain => data[tahun].indeks_per_domain[domain] || 0),
                backgroundColor: colorPalette[index % colorPalette.length],
                borderRadius: 8,
                barThickness: 15
            };
        });

        // Buat chart baru
        window.myChartCapaian = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: domainLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true }
                },
                scales: {
                    x: {
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: 100,
                        ticks: { stepSize: 10 },
                        grid: { color: "#eee" }
                    }
                }
            }
        });
    }
    function showGraphHist(data) {
        const ctx = document.getElementById('chartIPP').getContext('2d');

        // Hapus chart lama jika ada
        if (window.myChartHistIPP) {
            window.myChartHistIPP.destroy();
        }

        // Urutkan tahun (key) dari kecil ke besar
        const years = Object.keys(data).sort();
        const values = years.map(year => data[year]);

        // Ubah judul chart secara dinamis
        const titleElement = document.getElementById("chartIPPTitle");
        if (titleElement && years.length > 0) {
            titleElement.textContent = `CAPAIAN IPP TAHUN ${years[0]} - ${years[years.length - 1]}`;
        }

        // Buat chart baru
        window.myChartHistIPP = new Chart(ctx, {
            type: 'line',
            data: {
                labels: years,
                datasets: [{
                    label: 'IPP',
                    data: values,
                    borderColor: '#6c40ff',
                    backgroundColor: 'rgba(108, 64, 255, 0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: '#6c40ff',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: "#888" }
                    },
                    y: {
                        beginAtZero: false,
                        suggestedMin: Math.min(...values) - 5,
                        suggestedMax: Math.max(...values) + 5,
                        ticks: {
                            stepSize: 10,
                            color: "#aaa"
                        },
                        grid: { color: "#f0f0f0" }
                    }
                }
            }
        });
    }
    function loadGraphData() {
        var tahun = $("#tahunInputForm").val();
        var url='<?php echo $URL; ?>/API/loadGraphIPP';

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                "tahun": tahun // isi jika dibutuhkan token login
            },
            success: function (data) {
                Swal.close();

                var response = JSON.stringify(data);
                var myRespGraphData = JSON.parse(response);
                if (myRespGraphData.response_status == "true") {
                    showGraph(myRespGraphData.data);
                    updateIPPChart(myRespGraphData.data[tahun].nilai_ipp);
                    showGraphHist(myRespGraphData.data_hist);
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal',
                        text: myRespGraphData.message || 'Data tidak ditemukan',
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
    // -------- Graph

    function loadDocumentIPP() {
        $.ajax({
            url: '<?php echo $URL; ?>/API/loadDokumenIPP',
            method: 'POST',
            data: {
                "token": "" // isi jika dibutuhkan token login
            },
            success: function (data) {
                Swal.close();

                var response = JSON.stringify(data);
                var myRespAllDocData = JSON.parse(response);

                if (myRespAllDocData.response_status == "true") {
                    $("#listDokumenIPP").html("");
                    var admninList = "";

                    for (let a = 0; a < myRespAllDocData.data.length; a++) {
                        admninList += `
                            <li>
                                <div class="collapsible-header">${myRespAllDocData.data[a].tahun}</div>
                                <div class="collapsible-body">
                                    <ul class="collection with-header">`;

                        var thisData = myRespAllDocData.data[a].dataList;

                        for (let b = 0; b < thisData.length; b++) {
                            let filePath = thisData[b].pathFile || "";
                            let fileName = thisData[b].nama || "Dokumen";
                            let jenis = thisData[b].jenis || "-";

                            admninList += `
                                <li class="collection-item row">
                                    <span class="left" style="cursor:pointer; color:#3f51b5;" onclick="downloadFile('${filePath}')">
                                        📄 ${fileName.substring(0, 30)} [${jenis}]
                                    </span>
                                </li>`;
                        }

                        admninList += `
                                    </ul>
                                </div>
                            </li>`;
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

    function downloadFile(path) {
        if (!path) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Mengunduh',
                text: 'Path file tidak tersedia atau kosong.'
            });
            return;
        }

        // Ganti ini dengan URL lengkap ke file jika hanya menerima relative path
        const fullPath = '<?php echo $URL; ?>/' + path;

        const link = document.createElement('a');
        link.href = fullPath;
        link.download = path.split('/').pop(); // Nama file dari path
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>