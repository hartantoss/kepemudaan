<!-- Font & Materialize -->
<!-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> -->

<style>
  body {
    font-family: 'Inter', sans-serif;
    background: #f5f7fa;
    margin: 0;
    margin-top:60px !important;
  }
  /* Navbar styling */
  nav .brand-logo {
    display: flex;
    align-items: center;
  }
  nav .brand-logo img {
    height: 45px;
    margin-right: 10px;
  }
  nav ul li a {
    font-weight: 500;
    color: white;
  }

  nav ul li.active a {
    background-color: #ffd54f;
    border-radius: 6px;
    color: #1a237e !important;
  }
  
  nav {
    background-color: #1e3a8a;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    padding: 0 16px;
    position:fixed;
    top:0px;
    z-index: 1;
  }

  .nav-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between; /* Bagi ruang secara proporsional */
    flex-wrap: wrap; /* Penting kalau sempit */
  }

  .brand-logo {
    display: flex;
    align-items: center;
    max-width: 60%; /* Batasi agar tidak nabrak menu */
    white-space: normal;
    flex-shrink: 1; /* Boleh mengecil saat sempit */
  }

  .brand-logo img {
    height: 40px;
    margin-right: 10px;
    flex-shrink: 0; /* Gambar tetap */
  }

  .brand-text {
    display: flex;
    flex-direction: column;
    font-size: 0.85rem;
    line-height: 1.2;
    color: white;
  }

  nav ul {
    display: flex;
    flex-wrap: wrap;
    margin: 0;
    right:10px;
    position: fixed;
  }

  nav ul li a {
    padding: 8px 12px;
    white-space: nowrap;
  }


  nav ul li a:hover {
    background-color: rgba(255, 255, 255, 0.12);
  }

  nav ul li.active a {
    background-color: #f59e0b;
    color: #1e3a8a !important;
    font-weight: 600;
  }

  .sidenav li a {
    color: #1e3a8a;
    font-weight: 500;
    font-size: 1rem;
    padding: 14px 20px;
  }

  .sidenav li.active a {
    background-color: #f59e0b;
    color: white;
    font-weight: 600;
  }

  .material-icons {
    color: white;
  }

  @media screen and (max-width: 600px) {
    .brand-text {
      font-size: 0.75rem;
    }
  }
</style>

<!-- Navbar -->
<nav>
  <div class="nav-wrapper container">
    <!-- Kiri: Logo -->
    <a href="<?php echo $URL; ?>" class="brand-logo">
      <img src="<?php echo $URL; ?>/images/logo.png" alt="Logo">
      <div class="brand-text">
        <span>WEBSITE KEPEMUDAAN</span>
        <span>DISPARPORA KOTA SERANG</span>
      </div>
    </a>

    <!-- Mobile Icon -->
    <a href="#" data-target="mobile-nav" class="sidenav-trigger right">
      <i class="material-icons">menu</i>
    </a>

    <!-- Kanan: Menu Desktop -->
    <ul class="right hide-on-med-and-down">
      <li class="disparporaNav"><a href="https://disparpora.serangkota.go.id/">Website Disparpora</a></li>
      <li class="kepemudaanNav"><a href="<?php echo $URL; ?>/kepemudaan">Data Kepemudaan</a></li>
      <li class="artikeNav"><a href="<?php echo $URL; ?>/artikel">Informasi Terkini</a></li>
      <li class="pengkinianNav"><a href="<?php echo $URL; ?>/pengkinian">Form Pendataan</a></li>
      <li class="surveiNav"><a href="<?php echo $URL; ?>/survei">Survey</a></li>
      <li class="ippNav"><a href="<?php echo $URL; ?>/ipp">IPP</a></li>
    </ul>
  </div>
</nav>

<!-- Mobile Sidenav -->
<ul class="sidenav" id="mobile-nav">
  <li class="disparporaNav"><a href="https://disparpora.serangkota.go.id/">Website Disparpora</a></li>
  <li class="kepemudaanNav"><a href="<?php echo $URL; ?>/kepemudaan">Data Kepemudaan</a></li>
  <li class="artikeNav"><a href="<?php echo $URL; ?>/artikel">Informasi Terkini</a></li>
  <li class="pengkinianNav"><a href="<?php echo $URL; ?>/pengkinian">Form Pendataan</a></li>
  <li class="ippNav"><a href="<?php echo $URL; ?>/ipp">IPP</a></li>
</ul>

<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
  var thisPage = "<?php echo $_GET['pg']; ?>Nav";

  document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.sidenav');
    M.Sidenav.init(elems);

    document.querySelectorAll("." + thisPage).forEach(function (el) {
      el.classList.add("active");
    });
  });
</script>
