<div class="container">
  <div class="card-panel white z-depth-3" style="margin-top: 40px; border-radius: 12px;">
    <h5 class="center-align">Formulir Komunitas Kepemudaan</h5>
    <form id="formKomunitasKepemudaan" class="row">
      
      <div class="input-field col s12">
        <input id="nama_komunitas" name="nama_komunitas" type="text">
        <label for="nama_komunitas">Nama Komunitas <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12">
        <input id="ketua_komunitas" name="ketua_komunitas" type="text">
        <label for="ketua_komunitas">Nama Ketua Komunitas <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12 m6">
        <select name="jenis_kelamin" id="jenis_kelamin">
          <option value="" disabled selected>Pilih Jenis Kelamin</option>
          <option value="Laki - Laki">Laki - Laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>
        <label>Jenis Kelamin <span class="red-text">*</span></label>
      </div>
      

      <div class="input-field col s12 m6">
        <input id="no_hp_ketua" name="no_hp_ketua" type="tel">
        <label for="no_hp_ketua">Nomor Hp Ketua Komunitas <span class="red-text">*</span></label>
      </div>
      <div class="input-field col s12">
        <input id="jumlah_anggota" name="jumlah_anggota" type="number" min="0" step="1">
        <label for="jumlah_anggota">Jumlah Anggota Komunitas <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12">
        <input id="kegiatan" name="kegiatan" type="text">
        <label for="kegiatan">Kegiatan dalam Komunitas <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12">
        <input id="tanggal_berdiri" name="tanggal_berdiri" type="date">
        <label for="tanggal_berdiri">Tanggal Berdiri Komunitas <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12">
        <textarea id="alamat_sekretariat" name="alamat_sekretariat" class="materialize-textarea"></textarea>
        <label for="alamat_sekretariat">Alamat Sekretariat Komunitas <span class="red-text">*</span></label>
      </div>
      <div class="input-field col s12 m6">
        <select name="kecamatan" id="kecamatan">
          <option value="" disabled selected>Pilih Kecamatan</option>
          <option value="Cipocok Jaya">Cipocok Jaya</option>
          <option value="Curug">Curug</option>
          <option value="Kasemen">Kasemen</option>
          <option value="Serang">Serang</option>
          <option value="Taktakan">Taktakan</option>
          <option value="Walantaka">Walantaka</option>
        </select>
        <label>Kecamatan <span class="red-text">*</span></label>
      </div>
    
      <div class="input-field col s12 m6">
        <input id="email" name="email" type="email" class="validate">
        <label for="email">e-Mail <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12">
        <input id="instagram" name="instagram" type="text">
        <label for="instagram">Username Instagram <span class="red-text">*</span></label>
      </div>

      

      
      <div class="center-align">
        <div class="btn waves-effect waves-light blue white-text" onclick="saveDataKomunitasKepemudaan()">
          Kirim
          <i class="material-icons right white-text">send</i>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('input[type="date"]');
    M.Datepicker.init(elems, {
      format: 'yyyy-mm-dd',
      yearRange: 100
    });
  });

  function saveDataKomunitasKepemudaan(){
    let form = document.getElementById("formKomunitasKepemudaan");
    let formData = new FormData(form);

    let isValid = true;
    let firstInvalid = null;

    const inputs = form.querySelectorAll("input:not([type='file']), textarea, select");
    inputs.forEach((el) => {
      const isSelect = el.tagName === "SELECT";
      const isEmpty = el.value.trim() === "" || el.value === null;

      if (isEmpty) {
        isValid = false;

        if (!firstInvalid) {
          firstInvalid = el;
        }

        el.classList.add("invalid");
      } else {
        el.classList.remove("invalid");
      }
    });

    if (!isValid) {
      Swal.fire({
        icon: "warning",
        title: "Form Belum Lengkap",
        text: "Harap lengkapi semua bidang wajib sebelum mengirim.",
      });

      if (firstInvalid) firstInvalid.focus();
      return;
    }


    Swal.fire({
      title: 'Mengirim data...',
      didOpen: () => {
        Swal.showLoading();
      },
      allowOutsideClick: false
    });

    $.ajax({
      url: '<?php echo $URL; ?>/API/saveKomunitasKepemudaanStaging',
      method: 'POST',
      processData: false,
      contentType: false,
      cache: false,
      data: formData,
      success: function(data){
        var response = JSON.stringify(data);
        var myResponse = JSON.parse(response);
        if(myResponse.response_status == "true"){
          Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: myResponse.message,
              confirmButtonText: 'OK'
          }).then((result) => {
              if (result.isConfirmed) {
                  window.location.href = '<?php echo $URL;?>/pengkinian/';
              }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal mengirim data',
            text: myResponse.message
          });
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        Swal.fire({
          icon: 'error',
          title: 'Gagal mengirim data',
          text: errorThrown
        });
        console.log('jqXHR:', jqXHR);
        console.log('textStatus:', textStatus);
        console.log('errorThrown:', errorThrown);
      }
    });
  }
</script>
