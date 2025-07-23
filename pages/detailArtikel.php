<?php
    $type=$_GET['type'];
    $detailArtikel= $type == "ACARA" ? "bacaAcara": ( $type == "BERITA" ? "bacaBerita" : ($type == "AKTIVITAS" ? "bacaAktivitas" : ($type == "DATA" ? "lihatData" : '' ) ) );

?>
<style>
  .article-title {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 10px;
  }

  .article-meta {
    color: #757575;
    font-size: 0.95rem;
    margin-bottom: 30px;
  }

  .article-content p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #444;
  }

  .article-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 30px;
  }

  .chip-custom {
    background-color: #e3f2fd;
    color: #1565c0;
    font-weight: 500;
  }

  .divider {
    margin: 30px 0;
  }

  .section-tag {
    margin-top: 30px;
  }

  .related-article-card .card-image {
    height: 140px;
    overflow: hidden;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
  }

  .related-article-card .card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .related-article-card .card-title {
    font-size: 1rem;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 8px;
  }

  .related-article-card .card-content {
    min-height: 90px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding-bottom: 8px;
  }

  .related-article-card .card-action {
    padding: 10px 16px;
  }

  .back-link {
    margin-top: 40px;
    display: inline-block;
  }
</style>

<div class="container" style="margin-top: 50px;">
  <div class="row">
    <div class="col s12 m10 offset-m1">
      <!-- Judul -->
      <h1 class="article-title" id="judulIdView">-</h1>

      <!-- Meta Info -->
      <div class="article-meta" style="padding:5px">
        <div class="left"><span class="material-symbols-outlined left">event</span> <span id="dateView"></div>
        <div class="right"><span class="material-symbols-outlined left">person</span> DISPARPORA</div>
      </div>

      <!-- Gambar Utama -->
      <img src="-" alt="Gambar Artikel" id="imgArtView" class="article-image z-depth-1" />

      <!-- Isi Artikel -->
      <div class="article-content" id="listParagraphIdView">
      </div>

      <!-- Tag/Kategori -->
      <div class="section-tag">
        <strong>Tag:</strong>
        <div class="chip chip-custom" id="tagView">-</div>
        <strong>Kategori:</strong>
        <div class="chip chip-custom" id="kategoriView">-</div>
      </div>
      

      <!-- Divider -->
      <div class="divider"></div>

      <!-- Artikel Terkait -->
      <div class="section">
        <div class="related-title">Artikel Terkait</div>
        <div class="row" id="listRecent">
          
        </div>
      </div>

      <!-- Garis -->
      <div class="divider"></div>

      <!-- Link Kembali -->
      <a href="artikel.html" class="blue-text text-darken-2 back-link">
        <i class="material-icons left">arrow_back</i> Kembali ke Daftar Artikel
      </a>
    </div>
  </div>
</div>


<script>
    $(document).ready( function () {  
        showArtikel();
        // showTag();
        // showKatgori();
    } );

    var tags="all";
    var kategori="all";
    var search="";
    var numPage=1;
    var judul = "";
    <?php if(isset($_GET['j'])) echo "judul='".$_GET['j']."'";?>;

    
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
                "search":search,
                "judul":judul
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                var myResponAllData=JSON.parse(response);

                
                if(myResponAllData.response_status=="true"){
                    $("#listRecent").html("");
                    console.log(myResponAllData);
                    var listRecent="";
                    for(a=0; (a<myResponAllData.data.length);a++){
                        $("#imgArtView").attr('src', '<?php echo $URL;?>/'+myResponAllData.data[a].foto);
                    
                        $("#judulIdView").html(myResponAllData.data[a].judul_id);
                    
                        var listIdDesk="";
                        var thisDeskIdArray=(myResponAllData.data[a].deskripsi_id).split(/\r?\n|\r|\n/g);
                        

                        document.title=myResponAllData.data[a].judul_id;
                        document.querySelector('meta[name="description"]').setAttribute("content", thisDeskIdArray[0]);

                        for(b=0;b<thisDeskIdArray.length;b++)
                            listIdDesk+=`<p>${thisDeskIdArray[b]}</p>`;
                        
                        $("#listParagraphIdView").html(listIdDesk);
                        $("#tagView").html(myResponAllData.data[a].tag);
                        $("#kategoriView").html(myResponAllData.data[a].kategori);
                        $("#dateView").html(myResponAllData.data[a].created_date);
                        
                    }

                    for(a=0; (a<myResponAllData.list_recent.length);a++){
                        
                        listRecent+=`
                            <div class="col s12 m4">
                              <div class="card related-article-card">
                                <div class="card-image">
                                  <img src="<?php echo $URL;?>/${myResponAllData.list_recent[a].foto}" alt="Terkait 1">
                                </div>
                                <div class="card-content">
                                  <span class="card-title" style="font-size: 1.1rem;">${(myResponAllData.list_recent[a].judul_id).substring(0,45)}</span>
                                  <p class="grey-text">${(myResponAllData.list_recent[a].created_date)}</p>
                                </div>
                                <div class="card-action">
                                  <a href="<?php echo $URL."/".$detailArtikel."/";?>${myResponAllData.list_recent[a].judul_id}" class="blue-text text-darken-2">Baca Selengkapnya</a>
                                </div>
                              </div>
                            </div>
                        `;
                        
                    }
                    $("#listRecent").html(listRecent);
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



</script>