<!DOCTYPE html>
<html>
<head>
    <title>Kalender Kegiatan Kepemudaan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/calendar-custom.css">
    
</head>
<body>

<div class="container">
    <div class="card card-calendar z-depth-2" style="border-radius: 8px;">
        <div class="calendar-header">
            <i class="material-icons">event</i>
            <span>Kalender Kegiatan Kepemudaan</span>
        </div>
        <div class="card-content">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<div id="eventDetailModal" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h4 class="modal-title" id="eventDetailLabel">Detail Kegiatan</h4>
    <div class="divider" style="margin: 20px 0;"></div>
    <div class="detail-row">
        <div class="detail-label">Judul</div>
        <div class="detail-value" id="modalTitle" style="font-weight: bold;"></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Mulai</div>
        <div class="detail-value" id="modalStart"></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Selesai</div>
        <div class="detail-value" id="modalEnd"></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Kategori</div>
        <div class="detail-value"><span id="modalCat" class="chip"></span></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Deskripsi</div>
        <div class="detail-value" id="modalDesc"></div>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Tutup</a>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('eventDetailModal');
    const modalInstance = M.Modal.init(modalEl);

    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listMonth'
        },
        events: 'api/events.php',

        // =================================================== //
        // BARU: Tambahkan fungsi ini untuk membuat Tooltip    //
        // =================================================== //
        eventDidMount: function(info) {
            // Inisialisasi tooltip untuk setiap event
            M.Tooltip.init(info.el, {
                html: info.event.title, // Teks tooltip adalah judul lengkap dari event
                position: 'top',        // Posisi tooltip di atas
                margin: 0               // Jarak dari event
            });
        },
        // =================================================== //
        
        eventClick: function(info) {
            // Hancurkan instance tooltip agar tidak menempel saat modal dibuka
            const tooltipInstance = M.Tooltip.getInstance(info.el);
            if (tooltipInstance) {
                tooltipInstance.destroy();
            }

            // Logika untuk mengisi dan membuka modal (tidak berubah)
            document.getElementById('modalTitle').textContent = info.event.title;
            document.getElementById('modalStart').textContent = formatTanggalIndonesia(info.event.start);
            document.getElementById('modalEnd').textContent = info.event.end ? formatTanggalIndonesia(info.event.end) : '-';
            const categoryEl = document.getElementById('modalCat');
            categoryEl.textContent = info.event.extendedProps.category_name || 'Umum';
            document.getElementById('modalDesc').textContent = info.event.extendedProps.description || 'Tidak ada deskripsi.';
            modalInstance.open();
        }
    });
    calendar.render();
});

function formatTanggalIndonesia(dateObj) {
    if (!dateObj) return "-";
    let date = (typeof dateObj === "string") ? new Date(dateObj) : dateObj;
    const hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    const bulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
    let h = hari[date.getDay()]; let t = date.getDate(); let b = bulan[date.getMonth()]; let y = date.getFullYear();
    let jam = date.getHours().toString().padStart(2, '0') + ":" + date.getMinutes().toString().padStart(2, '0');
    return `${h}, ${t} ${b} ${y}, ${jam} WIB`;
}
</script>

</body>
</html>