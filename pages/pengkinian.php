<style>
    body {
      background-color: #f5f5f5;
      font-family: 'Poppins', sans-serif;
    }

    .section-title {
      font-weight: 600;
      margin-top: 40px;
      margin-bottom: 30px;
      color: #333;
    }

    .category-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 12px;
    }

    .category-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }

    .card-content {
      color: white;
      padding: 30px 20px;
      border-radius: 12px;
    }

    h6 {
      margin-top: 15px;
      font-weight: 500;
    }
    .card:hover{
      cursor:pointer;
    }

    /* Kartu warna-warni */
    .blue-card    { background-color: #2196F3; }
    .green-card   { background-color: #4CAF50; }
    .amber-card   { background-color: #FFB300; }
    .red-card     { background-color: #EF5350; }
    .purple-card  { background-color: #7E57C2; }
    .teal-card    { background-color: #009688; }
    .indigo-card  { background-color: #3F51B5; }
    .pink-card    { background-color: #EC407A; }

    @media only screen and (max-width: 600px) {
      .card-content {
        padding: 20px 15px;
      }
    }
  </style>



 <!-- Main Content -->
 <div class="container">
    <div class="section center">
      <h5 class="section-title">Pengkinian Data</h5>

      <div class="row">

        <div class="col s12 m6 l4">
          <div class="card category-card blue-card" onclick="openForm('formPemudaInovatif')">
            <div class="card-content center">
              <i class="material-icons large">emoji_objects</i>
              <h6>Pemuda Inovatif</h6>
            </div>
          </div>
        </div>

        <div class="col s12 m6 l4">
          <div class="card category-card green-card" onclick="openForm('formPemudaPelopor')">
            <div class="card-content center">
              <i class="material-icons large">explore</i>
              <h6>Pemuda Pelopor</h6>
            </div>
          </div>
        </div>

        <div class="col s12 m6 l4">
          <div class="card category-card amber-card" onclick="openForm('formWirausahaMuda')">
            <div class="card-content center">
              <i class="material-icons large">work</i>
              <h6>Wirausaha Muda</h6>
            </div>
          </div>
        </div>

        <div class="col s12 m6 l4">
          <div class="card category-card purple-card" onclick="openForm('formPemudaBerorganisasi')">
            <div class="card-content center">
              <i class="material-icons large">diversity_2</i>
              <h6>Pemuda Berorganisasi</h6>
            </div>
          </div>
        </div>
        <div class="col s12 m6 l4">
          <div class="card category-card red-card" onclick="openForm('formPemudaBerprestasi')">
            <div class="card-content center">
              <i class="material-icons large">emoji_events</i>
              <h6>Pemuda Berprestasi</h6>
            </div>
          </div>
        </div>
      
        <div class="col s12 m6 l4">
          <div class="card category-card teal-card " onclick="openForm('formDutaPemuda')">
            <div class="card-content center">
              <i class="material-icons large">stars</i>
              <h6>Duta Pemuda</h6>
            </div>
          </div>
        </div>

        <div class="col s12 m6 l6">
          <div class="card category-card indigo-card">
            <div class="card-content center"  onclick="openForm('formOrganisasiKepemudaan')">
              <i class="material-icons large">apartment</i>
              <h6>Organisasi Kepemudaan<br>di Kota Serang</h6>
            </div>
          </div>
        </div>

        <div class="col s12 m6 l6">
          <div class="card category-card pink-card"  onclick="openForm('formKomunitasKepemudaan')">
            <div class="card-content center">
              <i class="material-icons large">diversity_3</i>
              <h6>Komunitas Kepemudaan<br>di Kota Serang</h6>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script>
    function openForm(x){
      window.location="<?php echo $URL; ?>/"+x;
    }
  </script>