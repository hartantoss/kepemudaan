<style>
  /* Gaya untuk banner hero (tidak diubah) */
  .banner-hero { position: relative; background: url('<?php echo $URL; ?>/images/welcoming/banner_opening.jpg') center center/cover no-repeat; height: 100vh; display: flex; align-items: center; justify-content: center; padding: 0; }
  .overlay { width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.55); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 25px; text-align: center; }
  .logo { max-width: 110px; }
  .title { font-weight: 600; font-size: 2.1rem; margin: 0; }
  .subtitle { font-weight: 400; font-size: 1.3rem; margin: 0; }
  .button-group { display: flex; gap: 30px; flex-wrap: wrap; justify-content: center; margin-top: 20px; }
  .btn-icon { background: white; border-radius: 12px; padding: 14px 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25); text-decoration: none; color: #333; display: flex; flex-direction: column; align-items: center; transition: transform 0.25s ease, box-shadow 0.25s ease; width: 120px; }
  .btn-icon:hover { transform: translateY(-6px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.35); }
  .btn-icon .icon { width: 38px; height: 38px; margin-bottom: 10px; }
  .btn-icon span { font-weight: 600; font-size: 1rem; text-align: center; }

  /* Gaya untuk footer (tidak diubah) */
  footer.page-footer { padding-top: 20px; background-color: #0d47a1; }
  footer img { height: 45px; margin-bottom: 10px; }

  /* Gaya untuk seksi kalender */
  .calendar-section { padding: 80px 0; background-color: #f5f7fa; }
  .calendar-title { text-align: center; font-size: 2.5rem; font-weight: 600; margin-bottom: 40px; color: #1e3a8a; }
  .card-calendar .card-content { padding: 20px; }
  .calendar-header { padding: 16px 24px; background-color: #1e3a8a; color: white; font-size: 1.5rem; border-radius: 8px 8px 0 0; display: flex; align-items: center; }
  .calendar-header .material-icons { margin-right: 12px; }
  .modal .modal-content { padding: 24px; }
  .modal .modal-footer { background-color: #f9f9f9; }
  .modal-title { font-size: 1.8rem; font-weight: 500; }
  .detail-row { display: flex; margin-bottom: 12px; font-size: 1.1rem; }
  .detail-label { width: 120px; font-weight: 600; color: #555; }
  .detail-value { flex: 1; }
  .detail-value .chip { font-weight: 500; }
  
  @media screen and (max-width: 600px) {
    .title { font-size: 1.6rem; }
    .subtitle { font-size: 1rem; }
    .btn-icon { width: 100px; padding: 12px 14px; }
    .btn-icon .icon { width: 32px; height: 32px; }
    .calendar-title { font-size: 1.8rem; }
    .calendar-section { padding: 40px 0; }
  }
</style>

<link rel="stylesheet" href="<?php echo $URL; ?>/fullcalendarmuda/assets/css/calendar-custom.css">

<div class="banner-hero">
  <div class="overlay center-align">
    <img src="<?php echo $URL; ?>/images/logo.png" alt="Logo Disparpora" class="logo"/>
    <h3 class="white-text title">Dinas Pariwisata, Kepemudaan, dan Olahraga</h3>
    <h5 class="grey-text text-lighten-3 subtitle">Kota Serang</h5>
    <div class="button-group">
      <a href="https://disparpora.serangkota.go.id/" class="btn-icon"><img src="<?php echo $URL; ?>/images/icon/disparpora.png" alt="Disparpora" class="icon"/><span>Disparpora</span></a>
      <a href="<?php echo $URL; ?>/kepemudaan" class="btn-icon"><img src="<?php echo $URL; ?>/images/icon/youth.png" alt="Kepemudaan" class="icon"/><span>Data Kepemudaan</span></a>
      <a href="#kalender" class="btn-icon"><img src="<?php echo $URL; ?>/images/icon/calendar.png" alt="Kalender" class="icon"/><span>Kalender</span></a>
      <a href="<?php echo $URL; ?>/artikel" class="btn-icon"><img src="<?php echo $URL; ?>/images/icon/artikel.png" alt="artikel" class="icon"/><span>Informasi Terkini</span></a>
      <a href="<?php echo $URL; ?>/pengkinian" class="btn-icon"><img src="<?php echo $URL; ?>/images/icon/update.png" alt="pengkinian" class="icon"/><span>Form Pendataan</span></a>
      <a href="<?php echo $URL; ?>/survei" class="btn-icon"><img src="<?php echo $URL; ?>/images/icon/survey.png" alt="Survey" class="icon"/><span>Survey</span></a>
      <a href="<?php echo $URL; ?>/ipp" class="btn-icon"><img src="<?php echo $URL; ?>/images/icon/ipp.png" alt="Survey" class="icon"/><span>IPP</span></a>
    </div>
  </div>
</div>

<section class="calendar-section" id="kalender">
  <div class="container">
      <h2 class="calendar-title">Kalender Kegiatan</h2>
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
</section>

<div id="eventDetailModal" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h4 class="modal-title" id="eventDetailLabel">Detail Kegiatan</h4>
    <div class="divider" style="margin: 20px 0;"></div>
    <div class="detail-row"><div class="detail-label">Judul</div><div class="detail-value" id="modalTitle" style="font-weight: bold;"></div></div>
    <div class="detail-row"><div class="detail-label">Mulai</div><div class="detail-value" id="modalStart"></div></div>
    <div class="detail-row"><div class="detail-label">Selesai</div><div class="detail-value" id="modalEnd"></div></div>
    <div class="detail-row"><div class="detail-label">Kategori</div><div class="detail-value"><span id="modalCat" class="chip"></span></div></div>
    <div class="detail-row"><div class="detail-label">Deskripsi</div><div class="detail-value" id="modalDesc"></div></div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Tutup</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js"></script>
<script>
function formatTanggalIndonesia(dateObj) {
    if (!dateObj) return "-";
    let date = (typeof dateObj === "string") ? new Date(dateObj) : dateObj;
    const hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    const bulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
    let h = hari[date.getDay()];
    let t = date.getDate();
    let b = bulan[date.getMonth()];
    let y = date.getFullYear();
    let jam = date.getHours().toString().padStart(2, '0') + ":" + date.getMinutes().toString().padStart(2, '0');
    return `${h}, ${t} ${b} ${y}, ${jam} WIB`;
}

document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('eventDetailModal');
    const modalInstance = M.Modal.init(modalEl);

    // ======================================================== //
    //          KODE INI YANG MEMPERBAIKI TOMBOL TUTUP
    // ======================================================== //
    const closeButton = modalEl.querySelector('.modal-close');
    if (closeButton) {
        closeButton.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah perilaku default link
            modalInstance.close();
        });
    }
    // ======================================================== //

    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listMonth'
        },
        events: '<?php echo $URL; ?>/fullcalendarmuda/api/events.php',
        eventDidMount: function(info) {
            M.Tooltip.init(info.el, {
                html: info.event.title,
                position: 'top',
                margin: 0
            });
        },
        eventClick: function(info) {
            const tooltipInstance = M.Tooltip.getInstance(info.el);
            if (tooltipInstance) {
                tooltipInstance.destroy();
            }
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
</script>