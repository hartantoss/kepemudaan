<?php
// Mulai session
session_start();

// Panggil file koneksi utama
require_once "../connect.php"; 

// Cek jika pengguna sudah login, langsung arahkan ke halaman admin
if (isset($_SESSION['user_id'])) {
    header("Location: admin_event.php");
    exit;
}

$error_message = '';

// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error_message = "Username dan password tidak boleh kosong!";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // ===============================================
        //           KOREKSI FINAL ADA DI BARIS INI
        // ===============================================
        $query = "SELECT id, password FROM admin_users WHERE username = ?";
        // ===============================================
        
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($user = mysqli_fetch_assoc($result)) {
            // Verifikasi hash password
            if (password_verify($password, $user['password'])) {
                // Password benar, simpan sesi
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                header("Location: admin_event.php");
                exit;
            } else {
                $error_message = "Password salah!";
            }
        } else {
            $error_message = "Username tidak ditemukan!";
        }
        // Tutup statement
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin Kalender</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body { background-color: #f5f7fa; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-card { width: 400px; padding: 30px; border-radius: 10px; }
        .card-title { font-weight: 500; }
        .btn { width: 100%; height: 45px; line-height: 45px; }
        .error-msg { color: #d32f2f; margin-top: 15px; text-align: center; }
    </style>
</head>
<body>
    <div class="card login-card z-depth-2">
        <h4 class="card-title center-align">Admin Login</h4>
        <div class="row">
            <form class="col s12" method="POST" action="login.php">
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="username" type="text" name="username" class="validate">
                        <label for="username">Username</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">lock</i>
                        <input id="password" type="password" name="password" class="validate">
                        <label for="password">Password</label>
                    </div>
                </div>
                <?php if (!empty($error_message)): ?>
                    <p class="error-msg"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <div class="row">
                    <div class="input-field col s12">
                        <button class="btn waves-effect waves-light" type="submit" name="action">Login
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>