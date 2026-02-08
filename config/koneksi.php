<?php
$host     = "localhost";
$user     = "root";         // Ganti jika user MySQL Anda berbeda
$password = "";             // Kosongkan jika tidak pakai password
$database = "db_showroom";

$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
