<?php include 'connect.php';?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PT Statistika Cemerlang Indonesia" />
    <meta name="keywords" content="Statsme" />
    <meta name="author" content="Dandi Wibowo" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="icon" href="<?php echo $URL;?>/images/logo.png" type="image/x-icon" />
    <title>StatsMe</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f8f9fa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            flex-direction: column;
        }
        .container {
            max-width: 600px;
            padding: 20px;
        }
        h1 {
            font-size: 8rem;
            color: #dc3545;
            margin: 0;
        }
        h2 {
            font-size: 2rem;
            margin: 10px 0;
        }
        p {
            font-size: 1.2rem;
            color: #666;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            font-size: 1.2rem;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        a:hover {
            background-color: #0056b3;
        }
        .image {
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="<?php echo $URL; ?>/images/404.png" alt="404 Image" class="image">
        <h2>Oops! Halaman Tidak Ditemukan</h2>
        <p>Halaman yang Anda cari mungkin telah dihapus, atau URL yang Anda masukkan salah.</p>
        <a href="<?php echo $URL; ?>">Kembali ke Beranda</a>
    </div>
</body>
</html>
