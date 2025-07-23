<div class="container">
    <div class="card-panel white z-depth-3" style="margin-top: 40px; border-radius: 12px;">
      <h5 class="center-align">Formulir Pemuda Inovatif</h5>
      <form class="row" id="formInisiatifPemuda">
        
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
        
        <div class="input-field  col s12 m6">
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
          <label for="no_hp">Nomor HP <span class="red-text">*</span></label>
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
          <input id="nama_karya" name="nama_karya" type="text">
          <label for="nama_karya">Nama Inovasi/Karya <span class="red-text">*</span></label>
        </div>

        <div class="input-field col s12">
          <input id="bidang_karya" name="bidang_karya" type="text">
          <label for="bidang_karya">Bidang Karya <span class="red-text">*</span></label>
        </div>

        <div class="input-field col s12">
          <input id="tahun_mulai_karya" name="tahun_mulai_karya" type="number" min="1900" max="2099" step="1">
          <label for="tahun_mulai_karya">Tahun Mulai Dilaksanakan Inovasi/Karya(1900-2099) <span class="red-text">*</span></label>
        </div>

        <div class="input-field col s12">
          <input id="deskripsi" name="deskripsi" type="text">
          <label for="deskripsi">Deskripsi Singkat tentang inovasi terkini <span class="red-text">*</span></label>
        </div>
        <div class="row">
            <p>Upload File Portofolio Karya Inovatif <i>(Tidak Wajib)</i></p>
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


        <div class="center-align">
          <div class="btn waves-effect waves-light blue white-text" onclick="saveData()">
            Kirim
            <i class="material-icons right white-text">send</i>
          </div>
        </div>


      </form>
    </div>
  </div>
  
  <script>
    // Inisialisasi Materialize tanggal
    document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('input[type="date"]');
      M.Datepicker.init(elems, {
        format: 'yyyy-mm-dd',
        yearRange: 100
      });
    });
    // console.log($("#nik"))

    // ---------------- UPLOAD FILE ----------------
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
    // ---------- END UPLOAD FILE ---------------------------

    function saveData(){
              
        let form = document.getElementById("formInisiatifPemuda");
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

        // -------- UPLOAD FILE ----------
        let fileInput = document.getElementById("pdfFile");
        if (fileInput && fileInput.files.length > 0) {
            formData.set("upload_file", fileInput.files[0]); // atau .append() jika bisa multiple
        }
        //  -------------------------------

        // console.log(formData);
        Swal.fire({
          title: 'Mengirim data...',
          didOpen: () => {
            Swal.showLoading()
          },
          allowOutsideClick: false
        });
        $.ajax({
            url: '<?php echo $URL; ?>/API/savePemudaInovatifStaging',
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            
            success: function (data) {
                var response= JSON.stringify(data);
                var myResponse=JSON.parse(response);
                if(myResponse.response_status=="true")
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
                else
                  Swal.fire({
                    icon: 'error',
                    title: 'Gagal mengirim data',
                    text: myResponse.message,
                  });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal mengirim data',
                  text: error.message
                });
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
  </script>