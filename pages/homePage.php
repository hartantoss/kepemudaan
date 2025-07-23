  <!-- STYLE -->
  <style>
    /* Fullscreen hero */
    .banner-hero {
      position: relative;
      background: url('<?php echo $URL; ?>/images/welcoming/banner_opening.jpg') center center/cover no-repeat;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0;
    }

    .overlay {
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.55);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 25px;
      text-align: center;
    }

    .logo {
      max-width: 110px;
    }

    .title {
      font-weight: 600;
      font-size: 2.1rem;
      margin: 0;
    }

    .subtitle {
      font-weight: 400;
      font-size: 1.3rem;
      margin: 0;
    }

    .button-group {
      display: flex;
      gap: 30px;
      flex-wrap: wrap;
      justify-content: center;
      margin-top: 20px;
    }

    .btn-icon {
      background: white;
      border-radius: 12px;
      padding: 14px 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
      text-decoration: none;
      color: #333;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
      width: 120px;
    }

    .btn-icon:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.35);
    }

    .btn-icon .icon {
      width: 38px;
      height: 38px;
      margin-bottom: 10px;
    }

    .btn-icon span {
      font-weight: 600;
      font-size: 1rem;
      text-align: center;
    }

    @media screen and (max-width: 600px) {
      .title {
        font-size: 1.6rem;
      }
      .subtitle {
        font-size: 1rem;
      }
      .btn-icon {
        width: 100px;
        padding: 12px 14px;
      }
      .btn-icon .icon {
        width: 32px;
        height: 32px;
      }
    }

    /* Footer */
    footer.page-footer {
      padding-top: 20px;
      background-color: #0d47a1;
    }

    footer img {
      height: 45px;
      margin-bottom: 10px;
    }
  </style>
<!-- Hero -->
<div class="banner-hero">
  <div class="overlay center-align">
    <img
      src="<?php echo $URL; ?>/images/logo.png"
      alt="Logo Disparpora"
      class="logo"
    />
    <h3 class="white-text title">
      Dinas Pariwisata, Kepemudaan, dan Olahraaga
    </h3>
    <h5 class="grey-text text-lighten-3 subtitle">Kota Serang</h5>

    <div class="button-group">
      <a href="https://disparpora.serangkota.go.id/" class="btn-icon">
        <img
          src="<?php echo $URL; ?>/images/icon/disparpora.png"
          alt="Disparpora"
          class="icon"
        />
        <span>Disparpora</span>
      </a>
      <a href="<?php echo $URL; ?>/kepemudaan" class="btn-icon">
        <img
          src="<?php echo $URL; ?>/images/icon/youth.png"
          alt="Kepemudaan"
          class="icon"
        />
        <span>Data Kepemudaan</span>
      </a>
      
      <a href="<?php echo $URL; ?>/artikel" class="btn-icon">
        <img
          src="<?php echo $URL; ?>/images/icon/artikel.png"
          alt="artikel"
          class="icon"
        />
        <span>Informasi Terkini</span>
      </a>
      <a href="<?php echo $URL; ?>/pengkinian" class="btn-icon">
        <img
          src="<?php echo $URL; ?>/images/icon/update.png"
          alt="pengkinian"
          class="icon"
        />
        <span>Form Pendataan</span>
      </a>
      <a href="<?php echo $URL; ?>/survei" class="btn-icon">
        <img
          src="<?php echo $URL; ?>/images/icon/survey.png"
          alt="Survey"
          class="icon"
        />
        <span>Survey</span>
      </a>
      <a href="<?php echo $URL; ?>/ipp" class="btn-icon">
        <img
          src="<?php echo $URL; ?>/images/icon/ipp.png"
          alt="Survey"
          class="icon"
        />
        <span>IPP</span>
      </a>
    </div>
  </div>
</div>