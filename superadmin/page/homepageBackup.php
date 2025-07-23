<style>
  body {
    background-color: #f9fafb;
    font-family: 'Roboto', sans-serif;
  }

  .section-title {
    text-align: center;
    font-size: 2.5rem;
    font-weight: 600;
    margin: 40px 0 30px;
    color: #1f2937;
  }

  .chart-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
    margin: 15px 0;
    transition: transform 0.2s;
  }

  .chart-card:hover {
    transform: translateY(-4px);
  }

  .chart-title {
    font-weight: 600;
    font-size: 1.25rem;
    margin-bottom: 20px;
    color: #374151;
    text-align: center;
  }

  .canvas-container {
    position: relative;
    height: 280px;
  }

  /* Loading screen */
  #loading-screen {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 300px;
    font-size: 1.2rem;
    color: #6b7280;
  }

  .spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3b82f6;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 0.8s linear infinite;
    margin-right: 10px;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>

<!-- Loading Screen -->
<div id="loading" style="position: fixed; top:0; left:0; width:100%; height:100%; background:white; display:flex; align-items:center; justify-content:center; z-index:9999;">
  <div style="text-align:center;">
    <div class="preloader-wrapper big active">
      <div class="spinner-layer spinner-blue">
        <div class="circle-clipper left"><div class="circle"></div></div>
        <div class="gap-patch"><div class="circle"></div></div>
        <div class="circle-clipper right"><div class="circle"></div></div>
      </div>
    </div>
    <p>Memuat data statistik...</p>
  </div>
</div>
<div class="col s12" style="margin-bottom:20px;">
    <div class="col s12" id="breadCrumpView"></div>
</div>
<div class="col s12"  style="margin-bottom:50px;">
    <div class="col s12 m12 l6">
        <div class="col s12" style="background:white; border-radius:7px; padding:10px;">
            <!-- Tingkat Kepuasan Masyarakat Card -->
            <div class="card z-depth-3" style="border-radius: 15px; margin-top: 20px;">
                <div class="card-content center-align">
                    <h5 class="blue-text text-darken-2" style="font-weight: 600;">Tingkat Kepuasan Masyarakat</h5>

                    <div class="row" style="margin-top: 20px;">
                    <!-- Nilai IKM -->
                    <div class="col s4">
                        <h4 class="blue-text text-darken-1" style="margin: 0;" id="ikm-value">-</h4>
                        <p class="grey-text text-darken-1" style="margin: 0;">Nilai IKM</p>
                    </div>

                    <!-- Mutu Layanan -->
                    <div class="col s4">
                        <h4 class="green-text text-darken-2" style="margin: 0;" id="ikm-mutu">-</h4>
                        <p class="grey-text text-darken-1" style="margin: 0;">Mutu</p>
                    </div>

                    <!-- Predikat -->
                    <div class="col s4">
                        <h4 style="margin: 0;" id="ikm-emoji">😊</h4>
                        <p class="grey-text text-darken-1" style="margin: 0;" id="ikm-predikat">-</p>
                    </div>
                    </div>

                    <div class="card-panel blue lighten-5 z-depth-0" style="border-radius: 8px;">
                    <span class="blue-text text-darken-3" id="ikm-desc">
                        Pelayanan publik berada pada kategori <strong>-</strong> Pada tahun ini. Terima kasih atas partisipasi masyarakat.
                    </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col s12 m12 l6">
        <div class="col s12 m6" style="padding:10px;">
            <div class="col s12 green lighten-2" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">psychology_alt</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="pemudaInovatifView">203</b> <span class="right">Pemuda Inovatif</span>
                </div>
            </div>
        </div>
        <div class="col s12 m6" style="padding:10px;">
            <div class="col s12 orange darken-3" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">emoji_flags</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="PemudaPeloporView">50</b> <span class="right">Pemuda Pelopor</span>
                </div>
            </div>
        </div>
        <div class="col s12 m6" style="padding:10px;">
            <div class="col s12 deep-purple darken-2" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">storefront</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="WirausahaMudaView">20</b> <span class="right">Wirausaha Muda</span>
                </div>
            </div>
        </div>
        <div class="col s12 m6" style="padding:10px;">
            <div class="col s12 pink darken-1" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">military_tech</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="PemudaBerprestasiView">20</b> <span class="right">Pemuda Berprestasi</span>
                </div>
            </div>
        </div>
        <div class="col s12 m6" style="padding:10px;">
            <div class="col s12 blue darken-2" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">groups</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="PemudaBerorganisasiView">20</b> <span class="right">Pemuda Berorganisasi</span>
                </div>
            </div>
        </div>
        <div class="col s12 m6" style="padding:10px;">
            <div class="col s12 amber accent-3" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">gavel</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="DutaPemudaView">20</b> <span class="right">Duta Pemuda</span>
                </div>
            </div>
        </div>
        <div class="col s12 m6" style="padding:10px;">
            <div class="col s12 lime darken-1" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">apartment</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="OrganisasiKepemudaanView">20</b> <span class="right">Organisasi Kepemudaan</span>
                </div>
            </div>
        </div>
        <div class="col s12 m6" style="padding:10px;">
            <div class="col s12 deep-orange lighten-1" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">diversity_3</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="KomunitasKepemudaanView">20</b> <span class="right">Komunitas Kepemudaan</span>
                </div>
            </div>
        </div>
    </div>
    
</div>
<!-- Section Title -->
<div class="container">
  <div class="section-title">Statistik Kepemudaan Kota Serang</div>
  <div class="row" id="charts-container"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

<script>
    var myResponAllData=[];
    const API_URL = '<?php echo $URL; ?>/API/loadGraph';
    var breadCrump=[
        {
            "text":"Dasboard",
            "url":"<?php echo $URL; ?>/admin/homepage"
        },
        {
            "text":"Homepage",
            "url":"<?php echo $URL; ?>/admin/homepage"
        }
    ];

    $(document).ready( function () {
        showTingkatKepuasan();
        createBreadCrum(breadCrump);
    } );

    function getRandomColor() {
        const colors = ['#3B82F6', '#F59E0B', '#10B981', '#EF4444', '#6366F1', '#EC4899', '#06B6D4', '#A855F7'];
        return colors[Math.floor(Math.random() * colors.length)];
    }

    function createChartContainer(index, title, colClass) {
        const canvasId = `chart${index}`;
        return `
        <div class="${colClass}">
            <div class="chart-card">
            <div class="chart-title">${title}</div>
            <div class="canvas-container">
                <canvas id="${canvasId}"></canvas>
            </div>
            </div>
        </div>
        `;
    }

    async function fetchAndRenderCharts() {
        const container = document.getElementById("charts-container");
        const loader = document.getElementById("loading");
        loader.style.display = 'block';

        try {
        const response = await fetch(API_URL);
        const result = await response.json();

        if (!result || !result.data || !Array.isArray(result.data)) {
            container.innerHTML = `<p>Data tidak tersedia.</p>`;
            loader.style.display = 'none';
            return;
        }

        renderGroupedCharts(result.data);
        $("#pemudaInovatifView").html(result.data[0].values[0]);
        $("#PemudaPeloporView").html(result.data[0].values[1]);
        $("#WirausahaMudaView").html(result.data[0].values[2]);
        $("#PemudaBerprestasiView").html(result.data[0].values[3]);
        $("#PemudaBerorganisasiView").html(result.data[0].values[4]);
        $("#DutaPemudaView").html(result.data[0].values[5]);
        $("#OrganisasiKepemudaanView").html(result.data[0].values[6]);
        $("#KomunitasKepemudaanView").html(result.data[0].values[7]);

        } catch (error) {
            console.error("Error loading chart data:", error);
            document.getElementById("charts-container").innerHTML = `<p>Gagal memuat data.</p>`;
        } finally {
            loader.style.display = 'none';
        }
    }

    function renderGroupedCharts(data) {
        const container = document.getElementById("charts-container");
        container.innerHTML = '';

        // Group by category (last part after ' - ')
        const grouped = {};
        data.forEach(cfg => {
        const split = cfg.title.split(" - ");
        const category = split[1] || "Umum";
        if (!grouped[category]) grouped[category] = [];
            grouped[category].push(cfg);
        });

        let chartIndex = 0;

        for (const category in grouped) {
        const sectionId = `group-${category.replace(/\s+/g, '-')}`;
        container.insertAdjacentHTML("beforeend", `
            <div class="section">
            <h5 style="margin-top: 40px;">${category}</h5>
            <div class="row" id="${sectionId}"></div>
            </div>
        `);

        const groupContainer = document.getElementById(sectionId);
        grouped[category].forEach(cfg => {
            const canvasId = `chart${chartIndex}`;
            const chartHtml = createChartContainer(chartIndex, cfg.title, cfg.colClass || 'col s12 m6');
            groupContainer.insertAdjacentHTML("beforeend", chartHtml);

            // Delay chart rendering to ensure canvas exists
            setTimeout(() => {
            const ctx = document.getElementById(canvasId)?.getContext("2d");
            if (!ctx) return;

            const type = cfg.type;
            const labels = (cfg.labels || []).map(l => l ?? '-');
            const values = (cfg.values || []).map(v => parseFloat(v) || 0);
            const color = getRandomColor();
            const bgColor = type === 'pie' ? labels.map(() => getRandomColor()) : color;

            const chartData = type === 'pie' ? {
                labels,
                datasets: [{
                label: cfg.title,
                data: values,
                backgroundColor: bgColor,
                borderColor: '#fff',
                borderWidth: 1
                }]
            } : {
                labels,
                datasets: [{
                label: 'Jumlah',
                data: values,
                backgroundColor: bgColor,
                borderColor: color,
                fill: type !== 'line',
                tension: 0.4,
                borderWidth: 2,
                borderRadius: 8
                }]
            };

            new Chart(ctx, {
                type,
                data: chartData,
                options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                    display: type === 'pie',
                    position: 'bottom'
                    }
                },
                scales: type !== 'pie' ? {
                    y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                    }
                } : {}
                }
            });
            }, 0);

            chartIndex++;
        });
        }
    }

    function showTingkatKepuasan(){
        var token = localStorage.getItem('token');

        Swal.fire({
            title: 'Memuat Data...',
            text: 'Harap tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        
        let startDate = moment().startOf('year');  // 1 Januari tahun ini
        let endDate = moment();                    // Hari ini

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
                        kurang: item.kekurangan,
                        lebih: item.kelebihan,
                        saran: item.saran
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
                    let emoji = (nilaiIKM < 64.99 ? '😞' : (nilaiIKM < 76.6 ? '😐' : (nilaiIKM < 83.3 ? '🙂' : '😊')));
                   
                   
                    const ikm = nilaiIKM; // Contoh nilai
                    let mutu = mutuLayanan, predikat = preidikatLayanan;

    
                    // Masukkan ke elemen
                    document.getElementById('ikm-value').textContent = ikm.toFixed(1);
                    document.getElementById('ikm-mutu').textContent = mutu;
                    document.getElementById('ikm-predikat').textContent = predikat;
                    document.getElementById('ikm-emoji').textContent = emoji;
                    document.getElementById('ikm-desc').innerHTML = `Pelayanan publik berada pada kategori <strong>${predikat}</strong> Pada Tahun ini. <br/> Terima kasih atas partisipasi masyarakat.`;
            
                    // console.log(dataSurvei);
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

    
    document.addEventListener("DOMContentLoaded", fetchAndRenderCharts);
</script>