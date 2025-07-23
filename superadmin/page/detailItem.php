<style>
  /* Styling untuk user card dan status badge */
  .user-card {
    position: relative;
    border-radius: 12px;
    background: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.06);
    padding: 20px 20px 20px 80px;
    margin-bottom: 20px;
    transition: box-shadow 0.3s ease;
  }

  .user-card:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
  }

  .user-avatar {
    position: absolute;
    left: 20px;
    top: 20px;
    background-color: #e3f2fd;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .user-avatar i {
    color: #1976d2;
    font-size: 24px;
  }

  .status-badge {
    position: absolute;
    top: -10px;
    right: 20px;
    padding: 4px 10px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 500;
    color: white;
    text-transform: uppercase;
  }

  .status-waiting { background-color: #ffb300; }
  .status-approved { background-color: #43a047; }
  .status-rejected { background-color: #e53935; }
  .status-main { background-color: #1e88e5; }

  .action-icons {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    align-items: center;
  }

  .action-icons i {
    margin-left: 10px;
    cursor: pointer;
    transition: color 0.2s ease, transform 0.2s ease;
  }

  .action-icons i:hover {
    transform: scale(1.2);
  }

  .action-icons .edit { color: #1976d2; }
  .action-icons .approve { color: #388e3c; }
  .action-icons .reject { color: #d32f2f; }
  .action-icons .compare { color: #ad2fd3; }



  /* Styling untuk modal */
  .modal-content {
    padding: 30px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
  }

  .modal-content h5 {
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
    font-weight: 600;
    text-align: center;
  }

  /* Styling untuk input dan textarea */
  .input-field input, .input-field textarea {
    border-radius: 8px;
    padding: 12px;
    font-size: 14px;
    color: #333;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    transition: border-color 0.3s ease;
  }

  .input-field input:focus, .input-field textarea:focus {
    border-color: #2196F3;
    box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
  }

  .input-field label {
    font-size: 14px;
    color: #666;
  }

  .input-field i {
    font-size: 12px;
    color: #888;
  }

  /* Styling tombol */
  .btn {
    background-color: white;
  } 

  /* .btn:hover {
    background-color: #1976D2;
  }*/

  .btn-floating.red {
    background-color: #f44336;
    font-size: 18px;
    transition: background-color 0.3s ease;
  } 

  .btn-floating.red:hover {
    background-color: #d32f2f;
  }

  /* Styling untuk file upload */
  .file-field input[type="file"] {
    padding: 8px;
  }

  .file-path-wrapper {
    margin-top: 10px;
  }

  .file-path {
    border-radius: 8px;
    padding: 12px;
    background-color: #f1f1f1;
    font-size: 14px;
  }

  /* Styling select element */
  select {
    border-radius: 8px;
    font-size: 14px;
    padding: 12px;
    background-color: #f1f1f1;
    color: #333;
    border: 1px solid #ddd;
  }

  select:focus {
    border-color: #2196F3;
    box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
  }

  .missing {
    color: red;
    font-style: italic;
  }
</style>

<!-- Modal Structure -->

<div id="comparisonModals" class="modal">
  <div class="modal-content row">
    <!-- Header Modal -->
    <h5 class="center-align">Perbandingan data</h5>

    <div class="col s12" id="compareContainer">

    </div>

    <div class="col s12">
      <div class="btn orange white-text" onclick="approveData()" style="border:none">Approve</div>
      <div class="btn red white-text" onclick="rejectData()" style="border:none">Reject</div>
    </div>
  </div>
</div>

<div class="row" style="margin-bottom:20px;">
    <div class="col s12" id="breadCrumpView"></div>
</div>
<div class="row" style="margin:10px 0px 0px 0px;">
    <div class="row">
        <div class="col s12">
            <h6 class="grey-text text-darken-2">Data Duplikat: <strong id="diplicateView">Andi Saputra</strong></h6>

            <div class="col s12" id="listData">
            
            </div>
        </div>
    </div>

</div>


<a id="addButton" onclick="openData(-1)" style="position:fixed; bottom:20px; right:20px;" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
<script>
    var idJenisData="<?php echo $_GET['idJenisData']; ?>";
    var idItem="<?php echo $_GET['idItem']; ?>";
    var selectedId=0;
    var breadCrump=[
        {
            "text":"Dasboard",
            "url":"<?php echo $URL; ?>/admin/homepage"
        },
        {
            "text":"Jenis Data",
            "url":"<?php echo $URL; ?>/admin/jenisData"
        }
    ];
    var myResponAllData=[];
    var idArtikel=-1;
    var tags="all";
    var kategori="all";
    var search="";
    var numPage=1;
    var aprjUrl="";
    var endPointUrl="";
    var mainData=[];

    const fieldMap = {
      nama: 'Nama',
      nik: 'NIK',
      nama_organisasi: 'Nama Organisasi',
      nama_komunitas: 'Nama Komunitas',
      instagram: "Instagram",
    };
    const tableMap = {
      nama: 'Nama',
      email: 'Email',
      nik: 'NIK',
      alamat_ktp: 'Alamat KTP',
      alamat_domisili: 'Alamat Domisili',
      tempat_lahir: 'Tempat Lahir',
      tanggal_lahir: 'Tanggal Lahir',
      kecamatan: 'Kecamatan',
      jenis_kelamin: 'Jenis Kelamin',
      instagram: 'Instagram',
      deskripsi: 'Deskripsi',
      nama_karya: 'Nama Karya',
      bidang_karya: 'Bidang Karya',
      tahun_mulai_karya: 'Tahun Mulai Karya',
      nama_organisasi: 'Nama Organisasi',
      ketua_organisasi: 'Ketua Organisasi',
      nama_komunitas: 'Nama Komunitas',
      ketua_komunitas: 'Ketua Komunitas',
      no_hp_ketua: 'Nomor HP Ketua',
      jumlah_anggota: 'Jumlah Anggota',
      kegiatan: 'Kegiatan',
      tanggal_berdiri: 'Tanggal Berdiri',
      alamat_sekretariat: 'Alamat Sekretariat',
    };
    
    $(document).ready( function () {    
        showProperties();
        // showItem();
        $("#diplicateView").html(idItem)
        
    } );

    function parseSummaryString(str) {
        const result = {};
        str.split(";").filter(Boolean).forEach(pair => {
            const [key, val] = pair.split(":");
            result[key] = val;
        });
        return result;
    }

    // =============== Generate Card ================
    function generateCardDynamic(item) {
      const statusInfo = getStatusLabel(item.status);

      let infoHTML = '';
      for (const key in fieldMap) {
        if (item[key]) {
          infoHTML += `<div class="user-info"><strong>${fieldMap[key]}:</strong> ${item[key]}</div>\n`;
        }
      }

      if(item.status=='2')
        mainData=item;

      return `
      <div class="user-card">
        <div class="user-avatar">
          <i class="material-icons">male</i>
        </div>
        <div class="status-badge ${statusInfo.class}">${statusInfo.label}</div>
        ${infoHTML}
        
        <div class="action-icons">
          <i class='right grey-text'>By ${item.uploaded_by}</i>
          <i class="material-symbols-outlined tooltipped edit" data-tooltip="Compare" onclick="compareData(${item.id})">two_pager</i>
          
        </div>
      </div>`;
    }
    function getStatusLabel(status) {
      switch (status) {
        case "1":
          return { label: "Waiting Approval", class: "status-waiting" };
        case "2":
          return { label: "Main Data", class: "status-main" };
        case "0":
          return { label: "Rejected", class: "status-rejected" };
        default:
          return { label: "Unknown", class: "status-unknown" };
      }
    }
    function renderCards(dataArray) {
      const container = document.getElementById("listData");
      container.innerHTML = dataArray.map(generateCardDynamic).join('');
    }
    //==============================================

    // Generate Table Comparison
    function generateComparisonTable(dataA, dataB) {
      let html = `  
        <table class="highlight">
          <thead>
            <tr>
              <th>Field</th>
              <th>Selected Data</th>
              <th>Main Data</th>
            </tr>
          </thead>
          <tbody>
      `;

      for (const key in dataA) {
        if (!dataA.hasOwnProperty(key)) continue;

        // Tampilkan hanya jika key ada di fieldMap
        if (tableMap.hasOwnProperty(key)) {
          const label = tableMap[key];
          html += `
            <tr>
              <td><strong>${label}</strong></td>
              <td>${dataA[key] || '-'}</td>
              <td>${dataB?.[key] || '-'}</td>
            </tr>
          `;
        }
      }

      html += `</tbody></table>`;
      return html;
    }


    function compareData(id){
      var dataList=myResponAllData.data;
      const selectedData = dataList.find(d => d.id == id);
      selectedId=selectedData.id;
      if (!selectedData || !mainData) return;

      document.getElementById("compareContainer").innerHTML = generateComparisonTable(selectedData, mainData);
      $("#comparisonModals").modal("open");
      // console.log(selectedId);
    }
    // =================================

    function showItem(){
        var token = localStorage.getItem('token');

        $.ajax({
            url: '<?php echo $URL; ?>/API/'+endPointUrl,
            method: 'POST',
            data: {
                "token":token,
                "numPage":numPage,
                "search":idItem,
                "type":"DETAIL"
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                myResponAllData=JSON.parse(response);
                // console.log(myResponAllData)
                
                if(myResponAllData.response_status=="true"){
                    renderCards(myResponAllData.data);                    
                    $('.tooltipped').tooltip();
                }
                else{
                    alert(myResponAllData.message);
                }
                // console.log(JSON.stringify(myResponse.token));
                // alert(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
    function showProperties() {
        var token = localStorage.getItem('token');
        // console.log("masuk");

        $.ajax({
            url: '<?php echo $URL; ?>/API/showJenisData',
            method: 'POST',
            data: {
                "token": token,
                "idJenisData": idJenisData
            },
            dataType: 'json', // pastikan jQuery otomatis parsing JSON
            success: function (data) {
                // console.log(data); // gunakan "data", bukan "response"

                // Tidak perlu stringify dan parse ulang
                var myResponAllData = data;

                if (myResponAllData.response_status === "true") {
                    let newItem = {
                        text: myResponAllData.data[0].judul,
                        url: "<?php echo $URL; ?>/admin/itemData/" + idJenisData
                    };
                    breadCrump.push(newItem);
                    createBreadCrum(breadCrump);
                    createBreadCrum(breadCrump);
                    var thisEP=parseSummaryString(myResponAllData.data[0].url);
                    endPointUrl=thisEP.detil;
                    aprjUrl=thisEP.crud;
                    showItem();

                } else {
                    alert(myResponAllData.message);
                }
            },
            error: function (request, status, error) {
                console.log(request.responseText);
                console.log(status);
                console.log(error);
            }
        });
    }

    function openData(x){
        
        // var idArtikel=0;
        // if(x!=-1){
        //     idArtikel=myResponAllData.data[x].id;
        // }
        window.open("<?php echo $URL;?>/detailItem/"+x, '_blank');
    }

    function searchText(){
        search=$("#searchTextForm").val();
        showItem();
    }

    function approveData() {
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang anda setujui akan masuk ke visualisasi diagram.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Approve',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#388e3c',
        cancelButtonColor: '#d32f2f',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // Tampilkan loading SweetAlert
          Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu sebentar.',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          var token = localStorage.getItem('token');
          var idUser = localStorage.getItem("iduser");
          let formData = new FormData();
          formData.append('token', token);
          formData.append("id", selectedId);

          $.ajax({
            url: '<?php echo $URL; ?>/API/approve' + aprjUrl,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,

            success: function (data) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data telah disetujui.',
                confirmButtonColor: '#388e3c'
              });
            },

            error: function (jqXHR, textStatus, errorThrown) {
              Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat menyetujui data.',
                confirmButtonColor: '#d32f2f'
              });

              console.error('Error detail:', { jqXHR, textStatus, errorThrown });
            },

            complete: function () {
              showItem();
              $("#comparisonModals").modal('close');
            }
          });
        }
      });
    }


    // Fungsi untuk tombol Reject
    function rejectData() {
        Swal.fire({
        title: 'Apakah anda yakin ?',
        text: "Data yang anda tolak tidak akan masuk ke visualisasi",
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Reject',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#388e3c',
        reverseButtons: true
        }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu sebentar.',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          var token = localStorage.getItem('token');
          var idUser = localStorage.getItem("iduser");
          let formData = new FormData();
          formData.append('token', token);
          formData.append("id", selectedId);

          $.ajax({
            url: '<?php echo $URL; ?>/API/reject' + aprjUrl,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,

            success: function (data) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data telah ditolak.',
                confirmButtonColor: '#388e3c'
              });
            },

            error: function (jqXHR, textStatus, errorThrown) {
              Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat menolak data.',
                confirmButtonColor: '#d32f2f'
              });

              console.error('Error detail:', { jqXHR, textStatus, errorThrown });
            },

            complete: function () {
              showItem();
              $("#comparisonModals").modal('close');
            }
          });
        }
        });
    }

</script>