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
    .gender-stat {
        display: inline-block;
        text-align: center;
        margin: 10px;
    }

    .gender-icon-wrapper {
        position: relative;
        width: 40px;
        height: 40px;
        margin: 0 auto;
    }

    .icon-grey,
    .icon-colored {
        position: absolute;
        top: 0;
        left: 0;
        font-size: 40px;
    }

    .icon-grey {
        color: silver;
    }

    .icon-colored {
        z-index: 2;
        font-weight: bold;
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        -webkit-text-fill-color: transparent;
    }



    #male-colored {
    color: blue;
    }

    #female-colored {
    color: deeppink;
    }


    .icon-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 60px;
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
    <div class="col s12 m12 l12 xl6" style="margin-top:-20px;">
        <div class="col s12" style="background:white; border-radius:7px; padding:10px;">
            <!-- Tingkat Kepuasan Masyarakat Card -->
            <div class="card z-depth-3" style="border-radius: 15px; margin-top: 20px;">
                <div class="card-content center-align">
                    <!-- Judul -->
                    <h5 class="blue-text text-darken-2" style="font-weight: 600;">Tingkat Kepuasan Masyarakat</h5>

                    <!-- Nilai, Mutu, Predikat -->
                    <div class="row" style="margin-top: 25px; margin-bottom: 15px;">
                        <div class="col s12 m4">
                            <h4 class="blue-text text-darken-1" id="ikm-value" style="margin: 0;">-</h4>
                            <p class="grey-text text-darken-1" style="margin: 0;">Nilai IKM</p>
                        </div>
                        <div class="col s12 m4">
                            <h4 class="green-text text-darken-2" id="ikm-mutu" style="margin: 0;">-</h4>
                            <p class="grey-text text-darken-1" style="margin: 0;">Mutu</p>
                        </div>
                        <div class="col s12 m4">
                            <h4 id="ikm-emoji" style="margin: 0;">😊</h4>
                            <p class="grey-text text-darken-1" id="ikm-predikat" style="margin: 0;">-</p>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="card-panel blue lighten-5 z-depth-0" style="border-radius: 10px; padding: 15px; margin-bottom: 20px;">
                        <span class="blue-text text-darken-3" id="ikm-desc">
                            Pelayanan publik berada pada kategori <strong>-</strong> pada tahun ini. <br>
                            Terima kasih atas partisipasi masyarakat.
                        </span>
                    </div>

                    <!-- Statistik Responden -->
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col s12 m4 center-align">
                            <h6>Total Responden</h6>
                            <h5 id="total-responden">0</h5>
                        </div>
                        <div class="col s6 m4 center-align">
                            <div class="gender-icon-wrapper" style="position: relative; height: 40px;">
                                <i class="material-icons icon-grey" style="font-size: 40px; position: absolute; left: 50%; transform: translateX(-50%);">male</i>
                                <i class="material-icons icon-colored" id="male-colored" style="font-size: 40px; position: absolute; left: 50%; transform: translateX(-50%); z-index: 1;">male</i>
                            </div>
                            <p style="margin: 5px 0 0;">Laki-laki</p>
                            <p id="male-count" style="margin: 0;">0 (0%)</p>
                        </div>
                        <div class="col s6 m4 center-align">
                            <div class="gender-icon-wrapper" style="position: relative; height: 40px;">
                                <i class="material-icons icon-grey" style="font-size: 40px; position: absolute; left: 50%; transform: translateX(-50%);">female</i>
                                <i class="material-icons icon-colored" id="female-colored" style="font-size: 40px; position: absolute; left: 50%; transform: translateX(-50%); z-index: 1;">female</i>
                            </div>
                            <p style="margin: 5px 0 0;">Perempuan</p>
                            <p id="female-count" style="margin: 0;">0 (0%)</p>
                        </div>
                    </div>

                    <!-- Periode Survei -->
                    <div class="row" style="margin-bottom: 0;">
                        <div class="col s12 center-align">
                            <p class="grey-text text-darken-1" id="periode-survei" style="font-style: italic;">
                                Periode Survei: <strong id="startDateView">memuat</strong> - <strong id="endDateView">memuat</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <div class="col s12 m12 l12 xl6">
        <div class="col s12 m12 l6" style="padding:10px;">
            <div class="col s12 green lighten-2" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">psychology_alt</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="pemudaInovatifView">203</b> <span class="right">Pemuda Inovatif</span>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l6" style="padding:10px;">
            <div class="col s12 orange darken-3" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">emoji_flags</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="PemudaPeloporView">50</b> <span class="right">Pemuda Pelopor</span>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l6" style="padding:10px;">
            <div class="col s12 deep-purple darken-2" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">storefront</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="WirausahaMudaView">20</b> <span class="right">Wirausaha Muda</span>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l6" style="padding:10px;">
            <div class="col s12 pink darken-1" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">military_tech</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="PemudaBerprestasiView">20</b> <span class="right">Pemuda Berprestasi</span>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l6" style="padding:10px;">
            <div class="col s12 blue darken-2" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">groups</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="PemudaBerorganisasiView">20</b> <span class="right">Pemuda Berorganisasi</span>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l6" style="padding:10px;">
            <div class="col s12 amber accent-3" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">gavel</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="DutaPemudaView">20</b> <span class="right">Duta Pemuda</span>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l6" style="padding:10px;">
            <div class="col s12 lime darken-1" style="padding:4%; border-radius:10px;">
                <div class="col s12">
                    <i class="material-symbols-outlined white" style="padding:7px; border-radius: 50px;">apartment</i>
                </div>
                <div class="col s12 white-text">
                    <b style="font-size:20px" id="OrganisasiKepemudaanView">20</b> <span class="right">Organisasi Kepemudaan</span>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l6" style="padding:10px;">
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
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
  function getChartExplanation(title) {
    const titleLower = title.toLowerCase();
    if (titleLower.includes('jenis kelamin')) {
      return 'Menampilkan distribusi peserta berdasarkan jenis kelamin: Laki-laki dan Perempuan.';
    } else if (titleLower.includes('kecamatan')) {
      return 'Menampilkan jumlah peserta dari masing-masing kecamatan di Kota Serang.';
    } else if (titleLower.includes('kepeloporan')) {
      return 'Menampilkan bidang kepeloporan yang diminati oleh peserta, seperti teknologi, seni, dan lingkungan.';
    } else if (titleLower.includes('usia')) {
      return 'Menunjukkan distribusi peserta berdasarkan rentang usia tertentu.';
    } else if (titleLower.includes('pendidikan')) {
      return 'Distribusi peserta berdasarkan tingkat pendidikan terakhir yang telah ditempuh.';
    } else {
      return 'Statistik visualisasi dari data peserta terkait topik ini.';
    }
  }
  function createChartContainer(index, title, colClass) {
    const canvasId = `chart${index}`;
    const explanation = getChartExplanation(title); // <-- tambahan
    return `
      <div class="${colClass}">
        <div class="chart-card">
          <div class="chart-title">
            ${title}
            <span class="material-symbols-outlined right tooltipped" data-position="bottom" data-tooltip="${explanation}">info</span>
          </div>
          <div class="canvas-container">
            <canvas id="${canvasId}"></canvas>
          </div>
        </div>
      </div>
    `;
  }

  function getCompletedData(type, apiLabels = [], apiValues = []) {
    const predefined = {
      'jenis_kelamin': ['Laki - Laki', 'Perempuan'],
      'kecamatan': ['Cipocok Jaya', 'Curug', 'Kasemen', 'Serang', 'Taktakan', 'Walantaka'],
      'bidang_kepeloporan': [
        'Inovasi Teknologi',
        'Seni Budaya',
        'Pangan',
        'Pendidikan',
        'Pengelolaan Lingkungan, SDA, dan Pariwisata'
      ]
    };

    if (!predefined[type]) {
      return { labels: apiLabels, values: apiValues };
    }

    const labelSet = predefined[type];
    const valueMap = {};

    apiLabels.forEach((label, i) => {
      valueMap[label] = parseFloat(apiValues[i]) || 0;
    });

    const finalLabels = labelSet;
    const finalValues = labelSet.map(label => valueMap[label] ?? 0);

    return {
      labels: finalLabels,
      values: finalValues
    };
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
	$('.tooltipped').tooltip();
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
          // const labels = (cfg.labels || []).map(l => l ?? '-');
          // const values = (cfg.values || []).map(v => parseFloat(v) || 0);
          let slug = cfg.slug;

          if (!slug) {
            const titleLower = cfg.title.toLowerCase();
            if (titleLower.includes('jenis kelamin')) slug = 'jenis_kelamin';
            else if (titleLower.includes('kecamatan')) slug = 'kecamatan';
            else if (titleLower.includes('kepeloporan')) slug = 'bidang_kepeloporan';
          }
          const { labels, values } = getCompletedData(slug || cfg.type, cfg.labels, cfg.values);
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

            // new Chart(ctx, {
            //     type,
            //     data: chartData,
            //     options: {
            //     responsive: true,
            //     maintainAspectRatio: false,
            //     plugins: {
            //         legend: {
            //         display: type === 'pie',
            //         position: 'bottom'
            //         }
            //     },
            //     scales: type !== 'pie' ? {
            //         y: {
            //         beginAtZero: true,
            //         ticks: {
            //             stepSize: 1
            //         }
            //         }
            //     } : {}
            //     }
            // });

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
                    },
                    datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: Math.round,
                    color: '#111',
                    font: {
                        weight: 'bold'
                    }
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
                },
                plugins: [ChartDataLabels]
            });

            
            }, 0);

            chartIndex++;
        });
        }
    }

    function showTingkatKepuasan() {
        var token = localStorage.getItem('token');

        Swal.fire({
            title: 'Memuat Data...',
            text: 'Harap tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        let tmpStartDate = moment().startOf('year');
        let tmpEndDate = moment();

        // if (tmpStartDate && tmpEndDate) {
            let startDate = tmpStartDate.format('YYYY-MM-DD');
            let endDate = tmpEndDate.format('YYYY-MM-DD');

            $("#startDateView").html(tmpStartDate.format('DD-MMM-YYYY'));
            $("#endDateView").html(tmpEndDate.format('DD-MMM-YYYY'));
        // }

        $.ajax({
            url: '<?php echo $URL; ?>/API/showSurvei',
            method: 'POST',
            data: {
                "token": token,
                "start_date": startDate,
                "end_date": endDate,
            },
            success: function (data) {
                var response = JSON.stringify(data);
                myResponAllData = JSON.parse(response);

                if (myResponAllData.response_status == "true") {
                    let respDataSurvei = myResponAllData.data;
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

                    // Update statistik responden (Laki-laki/Perempuan)
                    updateRespondenStatistik(dataSurvei);

                    let totalUnsur = Array(9).fill(0);
                    const jumlahResponden = dataSurvei.length;

                    dataSurvei.forEach(item => {
                        item.unsur.forEach((nilai, index) => {
                            totalUnsur[index] += parseInt(nilai);
                        });
                    });

                    let nrrUnsur = totalUnsur.map(total => (total / jumlahResponden));
                    let nrrUnsur25 = nrrUnsur.map(nrr => (nrr * 25));
                    let nrrTertimbang = nrrUnsur.map(nrr => (nrr * 0.11));

                    let jmlNrrTertimbang = 0;
                    nrrTertimbang.forEach(nrr => jmlNrrTertimbang += nrr);

                    let nilaiIKM = jmlNrrTertimbang * 25;
                    let mutu = (nilaiIKM < 64.99 ? 'D' : (nilaiIKM < 76.6 ? 'C' : (nilaiIKM < 83.3 ? 'B' : 'A')));
                    let predikat = (nilaiIKM < 64.99 ? 'Tidak Baik' : (nilaiIKM < 76.6 ? 'Kurang Baik' : (nilaiIKM < 83.3 ? 'Baik' : 'Sangat Baik')));
                    let emoji = (nilaiIKM < 64.99 ? '😞' : (nilaiIKM < 76.6 ? '😐' : (nilaiIKM < 83.3 ? '🙂' : '😊')));

                    document.getElementById('ikm-value').textContent = nilaiIKM.toFixed(1);
                    document.getElementById('ikm-mutu').textContent = mutu;
                    document.getElementById('ikm-predikat').textContent = predikat;
                    document.getElementById('ikm-emoji').textContent = emoji;
                    document.getElementById('ikm-desc').innerHTML = `Pelayanan publik berada pada kategori <strong>${predikat}</strong> Pada Tahun ini.<br/>Terima kasih atas partisipasi masyarakat.`;

                    Swal.close();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal mengambil data dari server. ' + myResponAllData.message,
                        footer: error
                    });
                }
            },
            error: function (request, status, error) {
                console.log(request.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal mengambil data dari server. ' + request.responseText,
                    footer: error
                });
            }
        });
    }


    function updateRespondenStatistik(data) {
        const total = data.length;
        const laki = data.filter(d => d.jk && d.jk.toLowerCase().includes('laki')).length;
        const perempuan = data.filter(d => d.jk && d.jk.toLowerCase().includes('perempuan')).length;

        const persentaseLaki = total ? (laki / total * 100).toFixed(1) : 0;
        const persentasePerempuan = total ? (perempuan / total * 100).toFixed(1) : 0;

        // Update teks
        document.getElementById("total-responden").textContent = total;
        document.getElementById("male-count").textContent = `${laki} (${persentaseLaki}%)`;
        document.getElementById("female-count").textContent = `${perempuan} (${persentasePerempuan}%)`;

        // Update gradient icon laki-laki
        const maleIcon = document.getElementById("male-colored");
        if (maleIcon) {
            maleIcon.style.background = `linear-gradient(to bottom, #3c7ef0 0%, #3c7ef0 ${persentaseLaki}%, silver ${persentaseLaki}%, silver 100%)`;
            maleIcon.style.webkitBackgroundClip = 'text';
            maleIcon.style.webkitTextFillColor = 'transparent';
        }

        // Update gradient icon perempuan
        const femaleIcon = document.getElementById("female-colored");
        if (femaleIcon) {
            femaleIcon.style.background = `linear-gradient(to bottom, #eb3486 0%, #eb3486 ${persentasePerempuan}%, silver ${persentasePerempuan}%, silver 100%)`;
            femaleIcon.style.webkitBackgroundClip = 'text';
            femaleIcon.style.webkitTextFillColor = 'transparent';
        }
    }




    
    document.addEventListener("DOMContentLoaded", fetchAndRenderCharts);
</script>