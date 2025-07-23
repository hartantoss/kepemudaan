<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_kepemudaan";

$mysqli = new mysqli($host, $user, $pass, $db);

// Aktifkan pengecekan koneksi saat development/debugging:
if ($mysqli->connect_errno) {
    // Tampilkan pesan error yang jelas
    echo "<div style='background: #ffcccc; padding:1em; border-radius:6px; color:#a00; margin:1em 0'>";
    echo "<b>Gagal koneksi database!</b><br>";
    echo "Error: " . $mysqli->connect_error;
    echo "</div>";
    exit; // Stop proses file berikutnya
} else {
    // Untuk debugging: aktifkan baris di bawah jika ingin lihat pesan berhasil
    // echo "<div>berhasil.</div>";
}
?>
