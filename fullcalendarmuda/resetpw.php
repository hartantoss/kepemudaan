<?php
require_once "koneksi.php";
$username = "admin";
$newpass  = "admin123";
$hash = password_hash($newpass, PASSWORD_DEFAULT);
$stmt = $mysqli->prepare("UPDATE admin_users SET password=? WHERE username=?");
$stmt->bind_param("ss", $hash, $username);
$stmt->execute();
echo "Password admin berhasil direset ke <b>admin123</b> (hash baru: $hash)<br>";
?>
