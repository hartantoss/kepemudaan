<div class="container">
  <div class="card-panel white z-depth-3" style="margin-top: 40px; border-radius: 12px;">
    <h5 class="center-align">Formulir Pemuda Berorganisasi</h5>
    <form id="formPemudaBerorganisasi" class="row">
      
      <div class="input-field col s12">
        <input id="nama" name="nama" type="text" class="validate" required>
        <label for="nama">Nama <span class="red-text">*</span></label>
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
        <input id="tempat_lahir" name="tempat_lahir" type="text">
        <label for="tempat_lahir">Tempat Lahir <span class="red-text">*</span></label>
      </div>
      <div class="input-field col s12 m6">
        <input id="tanggal_lahir" name="tanggal_lahir" type="date">
        <label for="tanggal_lahir">Tanggal Lahir <span class="red-text">*</span></label>
      </div>
    

      <div class="input-field col s12 m6">
        <input id="nik" name="nik" type="text" class="validate" required>
        <label for="nik">NIK <span class="red-text">*</span></label>
      </div>
      <div class="input-field col s12">
        <textarea id="alamat_ktp" name="alamat_ktp" class="materialize-textarea"></textarea>
        <label for="alamat_ktp">Alamat sesuai KTP <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12">
        <textarea id="alamat_domisili" name="alamat_domisili" class="materialize-textarea"></textarea>
        <label for="alamat_domisili">Alamat Domisili Kota Serang <span class="red-text">*</span></label>
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
        <input id="no_hp" name="no_hp" type="tel">
        <label for="no_hp">Nomor Hp <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12">
        <input id="email" name="email" type="email" class="validate">
        <label for="email">e-Mail <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12">
        <input id="instagram" name="instagram" type="text">
        <label for="instagram">Username Instagram <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12">
        <input id="nama_organisasi" name="nama_organisasi" type="text">
        <label for="nama_organisasi">Nama Organisasi <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12">
        <input id="ketua_organisasi" name="ketua_organisasi" type="text">
        <label for="ketua_organisasi">Nama Ketua Organisasi <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12">
        <input id="no_hp_ketua" name="no_hp_ketua" type="tel">
        <label for="no_hp_ketua">Nomor Hp Ketua Organisasi <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12">
        <input id="kegiatan" name="kegiatan" type="text">
        <label for="kegiatan">Kegiatan dalam Organisasi <span class="red-text">*</span></label>
      </div>

      <div class="input-field col s12">
        <input id="tahun_bergabung" name="tahun_bergabung" type="number" min="1900" max="2099" step="1">
        <label for="tahun_bergabung">Tahun Bergabung dengan Organisasi(1900-2099) <span class="red-text">*</span></label>
      </div>

      <div class="center-align">
        <div class="btn waves-effect waves-light blue white-text" onclick="saveDataPemudaBerorganisasi()">
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

  function saveDataPemudaBerorganisasi(){
    let form = document.getElementById("formPemudaBerorganisasi");
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
        Swal.showLoading()
      },
      allowOutsideClick: false
    });

    $.ajax({
      url: '<?php echo $URL; ?>/API/savePemudaBerorganisasiStaging',
      method: 'POST',
      processData: false,
      contentType: false,
      cache: false,
      data: formData,
      success: function(data) {
        var response = JSON.stringify(data);
        var myResponse = JSON.parse(response);
        if(myResponse.response_status=="true"){
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
            text: myResponse.message,
          });
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
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
