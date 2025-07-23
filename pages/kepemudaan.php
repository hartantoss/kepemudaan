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

  /* Tooltip */
  .tooltip-icon {
    display: inline-block;
    margin-left: 8px;
    position: relative;
    font-family: 'Material Symbols Outlined';
    font-size: 20px;
    color: #9ca3af;
    cursor: pointer;
    vertical-align: middle;
  }

  .tooltip-icon::after {
    content: attr(data-tooltip);
    position: absolute;
    width: 240px;
    background: #1f2937;
    color: #fff;
    padding: 10px;
    border-radius: 8px;
    font-size: 0.875rem;
    top: 120%;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease-in-out;
    z-index: 10;
  }

  .tooltip-icon:hover::after {
    opacity: 1;
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

<!-- Section Title -->
<div class="container">
  <div class="section-title">Statistik Kepemudaan Kota Serang</div>
  <div class="row" id="charts-container"></div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
  const API_URL = '<?php echo $URL; ?>/API/loadGraph';

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
          //   type,
          //   data: chartData,
          //   options: {
          //     responsive: true,
          //     maintainAspectRatio: false,
          //     plugins: {
          //       legend: {
          //         display: type === 'pie',
          //         position: 'bottom'
          //       }
          //     },
          //     scales: type !== 'pie' ? {
          //       y: {
          //         beginAtZero: true,
          //         ticks: {
          //           stepSize: 1
          //         }
          //       }
          //     } : {}
          //   }
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

  document.addEventListener("DOMContentLoaded", fetchAndRenderCharts);
</script>
