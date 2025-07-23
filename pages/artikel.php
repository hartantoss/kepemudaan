<?php
    $type=$_GET['type'];
    $detailArtikel= $type == "ACARA" ? "bacaAcara": ( $type == "BERITA" ? "bacaBerita" : ($type == "AKTIVITAS" ? "bacaAktivitas" : ($type == "DATA" ? "lihatData" : '' ) ) );

?>
<style>
  
  .card-image .kategori-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: #2196f3;
    color: white;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
  }
  .card-title {
    font-size: 1.3rem;
    font-weight: bold;
  }
  .card-content p {
    color: #555;
  }
  .header-section {
    background-color: #263238; /* blue-grey darken-4 */
    padding: 60px 20px;
    border-radius: 0 0 20px 20px;
    color: white;
    text-align: center;
  }

  .header-section h3 {
    font-weight: 700;
    font-size: 2.8rem;
    margin-bottom: 10px;
    letter-spacing: 1px;
  }

  .header-section p {
    font-size: 1.2rem;
    font-weight: 300;
    opacity: 0.9;
  }

  .header-section i.material-icons {
    vertical-align: middle;
    margin-right: 8px;
  }

  #listArtikel .card {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  #listArtikel .card-content {
    flex-grow: 1;
  }

  .input-field {
    position: relative;
  }

  .input-field a.btn {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    padding: 0 12px;
    height: 36px;
    line-height: 36px;
    min-width: auto;
  }

  .collection-item {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    border-bottom: 1px solid #e0e0e0;
  }

  .section h6 {
    margin-bottom: 10px;
    font-size: 1.1rem;
  }
  .section .chip {
    margin-top: 5px;
    margin-bottom: 10px;
  }


  /* Custom Pagination Style */
  .custom-pagination li a {
      border: 1px solid #ccc;
      color: #039be5;
      border-radius: 0;
      margin: 0;
      padding: 0 20px;
      font-weight: 500;
    }

    .custom-pagination li.active a {
      background-color: #039be5;
      color: white;
    }

    .custom-pagination li {
      margin: 0;
    }

    .custom-pagination {
      display: inline-flex;
      border-radius: 6px;
      overflow: hidden;
      padding:30px;
    }

  @media only screen and (max-width: 600px) {
    #listArtikel .card-content {
      min-height: auto !important;
    }
  }
</style>

<!-- Gradient Header Section -->
<div class="section" style="
  background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
  padding: 60px 20px;
  border-radius: 0 0 20px 20px;
  color: white;
">
  <div class="container center-align">
    <h3 style="font-weight: 700; font-size: 2.8rem; margin-bottom: 10px; letter-spacing: 1px; color:white">
      <i class="material-icons" style="vertical-align: middle; margin-right: 8px;">article</i>
      Daftar Artikel
    </h3>
    <p style="font-size: 1.2rem; font-weight: 300; opacity: 0.9;">
      Temukan insight terbaru, berita menarik, dan konten pilihan hanya di sini.
    </p>
  </div>
</div>

<!-- Artikel List Container -->
<div class="row" style="margin-top: 40px;">
  <div class="col s12 m12 l10 push-l1" >
    <div class="col s12 m9 l9" style="padding-bottom:10px">
      <div class="col s12" id="listArtikel">
      </div>
      
      
      <div class="col s12 center-align" style="margin-top: 40px;">
        <ul class="pagination custom-pagination" id="listPagination">
          <li class="active"><a href="#!">1</a></li>
          <li><a href="#!">2</a></li>
          <li><a href="#!">3</a></li>
        </ul>
      </div>

    </div>
    <div class="col s12 m3 l3">
      <div class="col s12 card-panel">
        <!-- Search Bar -->
        <div class="input-field" style="display: flex; gap: 8px;">
          <input id="searchTextForm" type="text" class="validate" placeholder="Keyword" style="flex: 1;">
          <a class="btn-floating waves-effect blue lighten-1">
            <i class="material-icons" onclick="searchText()">search</i>
          </a>
        </div>

        <!-- Tag Section -->
        <div class="section">
          <h6 class="blue-text text-darken-2" style="font-weight: 600;">Tag</h6>
          <div class="divider" style="margin-bottom: 10px; background-color: #039be5;"></div>
          <div id="listTagView">
            <a class="chip blue lighten-5 blue-text text-darken-4">Semua</a>
          </div>
        </div>

        <!-- Kategori Section -->
        <div class="section">
          <h6 class="blue-text text-darken-2" style="font-weight: 600;">Kategori</h6>
          <div class="divider" style="margin-bottom: 10px; background-color: #039be5;"></div>
          <ul class="collection" style="border: none;" id="listKatgoriView">
            <li class="collection-item blue lighten-5">
              <i class="material-icons left blue-text text-darken-3" style="font-size: 16px;">arrow_right</i>
              <span class="blue-text text-darken-3">Semua</span>
            </li>
            <li class="collection-item blue lighten-5">
              <i class="material-icons left blue-text text-darken-3" style="font-size: 16px;">arrow_right</i>
              <span class="blue-text text-darken-3">Gaya Hidup</span>
            </li>
            <li class="collection-item blue lighten-5">
              <i class="material-icons left blue-text text-darken-3" style="font-size: 16px;">arrow_right</i>
              <span class="blue-text text-darken-3">Hiburan</span>
            </li>
            <li class="collection-item blue lighten-5">
              <i class="material-icons left blue-text text-darken-3" style="font-size: 16px;">arrow_right</i>
              <span class="blue-text text-darken-3">Sosial Budaya</span>
            </li>
          </ul>
        </div>


        <div class="section">

        </div>

      </div>
    </div>
    <!-- Artikel akan di-render di sini -->
  </div>
</div>

<!-- Tambahkan sekali di halaman -->
<script async defer src="https://www.instagram.com/embed.js"></script>
<script>
    $(document).ready( function () {  
        showArtikel();
        showTag();
        showKatgori();
    } );

    var tags="all";
    var kategori="all";
    var search="";
    var numPage=1;

    
    function showArtikel(){
        var token = "";

        $.ajax({
            url: '<?php echo $URL; ?>/API/loadArtikel',
            method: 'POST',
            data: {
                "token":token,
                "tipe":"<?php echo $type;?>",
                "numPage":numPage,
                "tags":tags,
                "kategori":kategori,
                "search":search
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                var myResponAllData=JSON.parse(response);

                
                if(myResponAllData.response_status=="true"){
                    $("#listArtikel").html("");
                    $("#listRecent").html("");
                    console.log(myResponAllData);
                    var beritaList="";
                    var listRecent="";
                    for(a=0; (a<myResponAllData.data.length);a++){
                        
                      beritaList += `
                        <div class="col s12 m6 l4">
                          <div class="card hoverable" style="margin: 10px 0;">
                            <div class="card-image" style="height: 200px; overflow: hidden;">
                              <img src="<?php echo $URL;?>/${myResponAllData.data[a].foto}" 
                                  alt="${(myResponAllData.data[a].judul_id).substring(0,10)}" 
                                  style="height: 100%; width: 100%; object-fit: cover;">
                              <span class="kategori-badge white-text blue darken-2" 
                                    style="position: absolute; top: 10px; left: 10px; padding: 5px 10px; border-radius: 5px; font-size: 12px;">
                                ${myResponAllData.data[a].kategori}
                              </span>
                            </div>
                            <div class="card-content" style="min-height: 160px;">
                              <span class="card-title truncate" style="font-size: 1.2rem; font-weight: 600;">
                                ${(myResponAllData.data[a].judul_id).substring(0, 60)}...
                              </span>
                              <p class="grey-text" style="font-size: 0.9rem;">${myResponAllData.data[a].created_date}</p>
                              <p style="margin-top: 5px; font-size: 0.95rem;">
                                ${(myResponAllData.data[a].deskripsi_id).substring(0, 80)}...
                              </p>
                            </div>
                            <div class="card-action">
                              <a href="<?php echo $URL."/".$detailArtikel."/";?>${myResponAllData.data[a].judul_id}" 
                                class="blue-text text-darken-2">Read More</a>
                            </div>
                          </div>
                        </div>
                      `;
                        
                    }

                    for(a=0; (a<myResponAllData.list_recent.length);a++){
                        
                        listRecent+=`
                            <div class="d-flex rounded overflow-hidden mb-3 idContentView">
                                <img class="img-fluid" src="<?php echo $URL;?>/${myResponAllData.list_recent[a].foto}" style="width: 100px; height: 100px; object-fit: cover;" alt="">
                                <a href="<?php echo $URL."/".$detailArtikel."/";?>${myResponAllData.list_recent[a].judul_id}" class="h5 fw-semi-bold d-flex align-items-center bg-light px-3 mb-0 ">
                                    ${(myResponAllData.list_recent[a].judul_id).substring(0,45)}
                                </a>
                            </div>
                            
                        `;
                        
                    }

                    var listPage="";
                    for(a=0; (a<myResponAllData.list_page.length);a++){
                        
                        if(myResponAllData.list_page[a]==myResponAllData.page_now)
                        listPage+=`
                                <li class="active"><a style="cursor:pointer;" onclick="setNumRow(${myResponAllData.list_page[a]})" >${myResponAllData.list_page[a]}</a></li>                                
                            `;
                        else
                        listPage+=`
                                <li><a style="cursor:pointer;"  onclick="setNumRow(${myResponAllData.list_page[a]})">${myResponAllData.list_page[a]}</a></li>                                
                            `;
                        
                    }

                    $("#listArtikel").html(beritaList);
                    $("#listRecent").html(listRecent);
                    $("#listPagination").html(listPage);
                    $('.tooltipped').tooltip();
                    
                }
                else{
                    alert(myResponAllData.message);
                }
                // console.log(JSON.stringify(myResponse.token));
                // alert(data);
            },
            complete : function (data){
                // sleep(500)
                // changeLanguage();
            }
        });
    }

    function showTag(){
        var token = "";

        $.ajax({
            url: '<?php echo $URL; ?>/API/showTag',
            method: 'POST',
            data: {
                "token": token,
                "tipe": "<?php echo $type;?>"
            },
            success: function (data) {
                // console.log("Response API:", data); // Debugging

                if (data.response_status === "true") {
                    $("#listTagView").html(""); // Kosongkan list sebelum mengisi ulang
                    let listTag = `<a style="cursor:pointer;" onclick="searchTag('all')" class="chip blue lighten-5 blue-text text-darken-4">Semua</a>`;

                    data.data.forEach(item => {
                        let tagName = Object.keys(item)[0]; // Ambil nama tag dari key pertama
                        listTag += `
                            <a style="cursor:pointer;" onclick="searchTag('${tagName}')" class="chip blue lighten-5 blue-text text-darken-4">${tagName}</a>
                        `;
                    });

                    $("#listTagView").html(listTag);
                    $('.tooltipped').tooltip(); // Update tooltips jika ada
                    // changeLanguage(); // Jika ada perubahan bahasa
                } else {
                    alert(data.message);
                }
            }
        });
    }

    function showKatgori(){
        var token = "";

        $.ajax({
            url: '<?php echo $URL; ?>/API/showKategori',
            method: 'POST',
            data: {
                "token": token,
                "tipe": "<?php echo $type;?>"
            },
            success: function (data) {
                // console.log("Response API:", data); // Debugging

                if (data.response_status === "true") {
                    $("#listKatgoriView").html(""); // Kosongkan list sebelum mengisi ulang
                    let listKatgori = `
                      <li class="collection-item blue lighten-5"  onclick="searchKatgori('all')" style="cursor: pointer; margin-bottom:1px;">
                        <i class="material-icons left blue-text text-darken-3" style="font-size: 16px;">arrow_right</i>
                        <span class="blue-text text-darken-3">Semua</span>
                      </li>
                    `;

                    data.data.forEach(item => {
                        let tagName = Object.keys(item)[0]; // Ambil nama tag dari key pertama
                        listKatgori += `
                          <li class="collection-item blue lighten-5" onclick="searchKatgori('${tagName}')" style="cursor: pointer; margin-bottom:1px;">
                            <i class="material-icons left blue-text text-darken-3"  style="font-size: 16px;">arrow_right</i>
                            <span class="blue-text text-darken-3">${tagName}</span>
                          </li>
                        `;
                    });

                    $("#listKatgoriView").html(listKatgori);
                    $('.tooltipped').tooltip(); // Update tooltips jika ada
                    // changeLanguage(); // Jika ada perubahan bahasa
                } else {
                    alert(data.message);
                }
            }
        });
    }



    function searchKatgori(item){
        kategori=item;
        search="";
        $("#searchTextForm").val("");
        showArtikel();
    }
    function searchTag(item){
        tags=item;
        search="";
        $("#searchTextForm").val("");
        showArtikel();
    }
    function searchText(){
        search=$("#searchTextForm").val();
        showArtikel();
    }

    function setNumRow(x){
        numPage=x;
        showArtikel();
    }



  // const artikelList = [
  //   {
  //     id: 1,
  //     judul: "Produk Lokal Mendominasi Pasar Skincare...",
  //     tanggal: "30 Mei 2025, 09:14",
  //     lokasi: "SURABAYA",
  //     deskripsi: "Analisis lebih lanjut StatsMe...",
  //     kategori: "Gaya Hidup",
  //     gambar: "https://via.placeholder.com/600x300?text=Skincare",
  //   },
  //   {
  //     id: 2,
  //     judul: "Pernikahan Ideal di Mata Generasi Z...",
  //     tanggal: "20 Mei 2025, 14:58",
  //     lokasi: "MAKASSAR",
  //     deskripsi: "Generasi Z dan budaya menikah saat ini...",
  //     kategori: "Sosial Budaya",
  //     gambar: "https://via.placeholder.com/600x300?text=Pernikahan",
  //   },
  //   {
  //     id: 3,
  //     judul: "Serum Kian Favorit, Pelembab Laris Manis...",
  //     tanggal: "28 Mei 2025, 08:36",
  //     lokasi: "SURABAYA",
  //     deskripsi: "Penampilan menjadi topik utama...",
  //     kategori: "Gaya Hidup",
  //     gambar: "https://via.placeholder.com/600x300?text=Serum",
  //   }
  // ];

  // const container = document.getElementById('artikel-list');

  // artikelList.forEach(artikel => {
  //   const col = document.createElement('div');
  //   col.className = 'col s12 m6 l4'; // responsive columns

  //   col.innerHTML = `
  //     <div class="card hoverable">
  //       <div class="card-image">
  //         <img src="${artikel.gambar}" alt="${artikel.judul}">
  //         <span class="kategori-badge">${artikel.kategori}</span>
  //       </div>
  //       <div class="card-content">
  //         <span class="card-title">${artikel.judul}</span>
  //         <p class="grey-text">${artikel.lokasi}, ${artikel.tanggal}</p>
  //         <p>${artikel.deskripsi}</p>
  //       </div>
  //       <div class="card-action">
  //         <a href="detail.html?id=${artikel.id}" class="blue-text text-darken-2">Read More</a>
  //       </div>
  //     </div>
  //   `;

  //   container.appendChild(col);
  // });

</script>